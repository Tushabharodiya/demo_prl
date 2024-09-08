<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeOffer extends CI_Controller {
    function __construct() {
		parent::__construct();

		if ($this->session->userdata('auth_key') != AUTH_KEY){ 
            redirect('login');
        }
	}
	
	public function index(){
        $this->load->view('header');
        $this->load->view('error');
        $this->load->view('footer');
    }
	
    public function employeeOfferNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_OFFER_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/employeeOffer/employee_offer_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'employee_offer_letter'=>$data['onboardingLettersData']['employee_offer_letter'],
                        'reporting_date'=>$this->input->post('reporting_date'),
                        'reporting_time'=>$this->input->post('reporting_time'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_EMPLOYEE_OFFER_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-employee-offer');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function employeeOfferView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_employee_offer_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_employee_offer');
            }
            if(isset($_POST['submit_search'])){
                $searchEmployeeOffer = $this->input->post('search_employee_offer');
                $this->session->set_userdata('session_employee_offer', $searchEmployeeOffer);
            }
            $sessionEmployeeOffer = $this->session->userdata('session_employee_offer');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_employee_offer_email');
                $this->session->unset_userdata('session_employee_offer_status');
                redirect('view-employee-offer');
            }
            
            $searchEmployeeOfferEmail = $this->input->post('search_employee_offer_email');
            if($searchEmployeeOfferEmail === 'pending' or $searchEmployeeOfferEmail == 'sending'){
                $this->session->set_userdata('session_employee_offer_email', $searchEmployeeOfferEmail);
            } else if($searchEmployeeOfferEmail === 'all'){
                $this->session->unset_userdata('session_employee_offer_email');
            }
            $sessionEmployeeOfferEmail = $this->session->userdata('session_employee_offer_email');
                
            $searchEmployeeOfferStatus = $this->input->post('search_employee_offer_status');
            if($searchEmployeeOfferStatus == 'active' or $searchEmployeeOfferStatus == 'inactive'){
                $this->session->set_userdata('session_employee_offer_status', $searchEmployeeOfferStatus);
            } else if($searchEmployeeOfferStatus === 'all'){
                $this->session->unset_userdata('session_employee_offer_status');
            }
            $sessionEmployeeOfferStatus = $this->session->userdata('session_employee_offer_status');
            
            $data = array();
            //get rows count
            $conditions['search_employee_offer'] = $sessionEmployeeOffer;
            $conditions['search_employee_offer_email'] = $sessionEmployeeOfferEmail;
            $conditions['search_employee_offer_status'] = $sessionEmployeeOfferStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewEmployeeOfferData($conditions, HRM_EMPLOYEE_OFFER_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-employee-offer');
            $config['uri_segment'] = 2;
            $config['total_rows']  = $totalRec;
            $config['per_page']    = 10;
            
            //styling
            $config['num_tag_open'] = '<li class="page-item page-link">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active page-item"><a href="javascript:void(0);" class="page-link" >';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_link'] = '&raquo';
            $config['prev_link'] = '&laquo';
            $config['next_tag_open'] = '<li class="pg-next page-item page-link">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="pg-prev page-item page-link">';
            $config['prev_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item page-link">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item page-link">';
            $config['last_tag_close'] = '</li>';
            
            //initialize pagination library
            $this->pagination->initialize($config);
            
            //define offset
            $page = $this->uri->segment(2);
            $offset = !$page?0:$page;
            
            //get rows
            $conditions['returnType'] = '';
            $conditions['start'] = $offset;
            $conditions['limit'] = 10;
            
            $employeeOffer = $this->DataModel->viewEmployeeOfferData($conditions, HRM_EMPLOYEE_OFFER_TABLE);
            $data['countEmployeeOffer'] = $this->DataModel->countEmployeeOfferData($conditions, HRM_EMPLOYEE_OFFER_TABLE);
            $data['countEmployeeOfferTrash'] = $this->DataModel->countEmployeeOfferTrashData($conditions, HRM_EMPLOYEE_OFFER_TABLE);
            
            $data['viewEmployeeOffer'] = array();
            if(is_array($employeeOffer) || is_object($employeeOffer)){
                foreach($employeeOffer as $Row){
                    $dataArray = array();
                    $dataArray['employee_offer_id'] = $Row['employee_offer_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['is_email'] = $Row['is_email'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewEmployeeOffer'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/employeeOffer/employee_offer_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function employeeOfferEmail($employeeOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_OFFER_EMAIL_ALIAS, "can_edit");
            if($isPermission){
                $employeeOfferID = urlDecodes($employeeOfferID);
                if(ctype_digit($employeeOfferID)){
            		$data['emailEmployeeOffer'] = $this->DataModel->getData('employee_offer_id = '.$employeeOfferID, HRM_EMPLOYEE_OFFER_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['emailEmployeeOffer']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['emailEmployeeOffer'] != null){
        	            $employeeEmail  = $data['employeeData']['employee_email'];
        	            
        	            $pageBreak = '<div style="page-break-before: always;"></div>';
                            
                        $employeeCompensation = $data['employeeData']['employee_compensation']; 
                        $myNumber = str_replace(',', '', $employeeCompensation); 
                        $number = $myNumber;
                        $no = floor($number);
                        $point = round($number - $no, 2) * 100;
                        $hundred = null;
                        $digits_1 = strlen($no);
                        $i = 0;
                        $str = array();
                        $words = array('0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten', 
                            '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fourteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
                            '30' => 'thirty', '40' => 'forty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninety');
                        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
                        while ($i < $digits_1) {
                            $divider = ($i == 2) ? 10 : 100;
                            $number = floor($no % $divider);
                            $no = floor($no / $divider);
                            $i += ($divider == 10) ? 1 : 2;
                            if ($number) {
                                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                                $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
                            } else $str[] = null;
                        }
                        $str = array_reverse($str);
                        $result = implode('', $str);
                        $points = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
                        $compensationWord = ($points) ? $result . "Rupees  " . $points . " Paise" : $result . "Rupees ";
                        
                        ob_start();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'] . '.pdf';
                        $htmlCode = str_replace(array(
                            "#[page_break]#",
                            "#[employee_name]#",
                            "#[employee_department]#",
                            "#[employee_compensation]#",
                            "#[employee_compensation_word]#",
                            "#[reporting_date]#",
                            "#[reporting_time]#",
                            "#[create_date]#",
                        ),array(
                            $pageBreak,
                            $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'], 
                            $data['departmentData']['department_name'], 
                            $data['employeeData']['employee_compensation'], 
                            $compensationWord,
                            $data['emailEmployeeOffer']['reporting_date'],
                            $data['emailEmployeeOffer']['reporting_time'],
                            $data['emailEmployeeOffer']['create_date'], 
                        ),$data['emailEmployeeOffer']['employee_offer_letter']);
                        
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($htmlCode);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $file = $this->dompdf->output();
                        file_put_contents($fileName, $file);
                        require 'class/class.phpmailer.php';
                        $mail = new PHPMailer;
                        $mail->IsSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->Port = '465';
                        $mail->SMTPAuth = true;
                        $mail->Username = USER_EMAIL;
                        $mail->Password = USER_PASSWORD; 
                        $mail->SMTPSecure = 'ssl';
                        $mail->From = USER_EMAIL;
                        $mail->FromName = USER_NAME;
                        $mail->AddAddress($employeeEmail);
                        $mail->WordWrap = 50;
                        $mail->IsHTML(true);
                        $mail->AddAttachment($fileName);
                        $mail->Subject = 'Employee Offer Letter';
                        $mail->Body = 'Dear '.$data['employeeData']['employee_first_name'].' '.' '.$data['employeeData']['employee_last_name'].',<br><br>';
                        $mail->Body .= 'Congratulations on your offer from Syphnosys Technology Private Limited!<br><br>';
                        $mail->Body .= 'We are delighted to offer you the position of Human resource manager with an anticipated start date of '.$data['employeeData']['employee_joining_date'].' as discussed, Please find attached your detailed offer letter.<br><br>';
                        $mail->Body .= 'A warm welcome to the team! Looking forward to working with your expertise.<br><br>';
                        $mail->Body .= 'Please confirm that you have received this email and accept the offer.<br><br>';
                        $mail->Body .= '<br><br><br><br>--<br>Regards,<br>HR Manager<br>+91 99257 27373<br>Syphnosys Technology Private Limited';
                        if($mail->Send()){
                            unlink($fileName);
                            $editData = array(
                                'is_email'=>'sending'
                            );
                            $editDataEntry = $this->DataModel->editData('employee_offer_id = '.$employeeOfferID, HRM_EMPLOYEE_OFFER_TABLE, $editData);
                            $this->session->set_userdata("session_employee_offer_email_success","Your mail has been sent successfully!");
                            
                            $sessionEmployeeOfferViewPreviousUrl = $this->session->userdata('session_employee_offer_view_previous_url');
                            if(!empty($sessionEmployeeOfferViewPreviousUrl)){
                                redirect($sessionEmployeeOfferViewPreviousUrl);
                            }
                        } else {
                            unlink($fileName);
                            $this->session->set_userdata('session_employee_offer_email_error','There is error in sending mail! Please try again later');
                            
                            $sessionEmployeeOfferViewPreviousUrl = $this->session->userdata('session_employee_offer_view_previous_url');
                            if(!empty($sessionEmployeeOfferViewPreviousUrl)){
                                redirect($sessionEmployeeOfferViewPreviousUrl);
                            }
                        }
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function employeeOfferDetail($employeeOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_OFFER_ALIAS, "can_view");
            if($isPermission){
                $employeeOfferID = urlDecodes($employeeOfferID);
                if(ctype_digit($employeeOfferID)){
            		$employeeOffer = $this->DataModel->viewData(null, 'employee_offer_id = '.$employeeOfferID, HRM_EMPLOYEE_OFFER_TABLE);
        	        $data['detailEmployeeOffer'] = array();
                    if(is_array($employeeOffer) || is_object($employeeOffer)){
                        foreach($employeeOffer as $Row){
                            $dataArray = array();
                            $dataArray['employee_offer_id'] = $Row['employee_offer_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['employee_offer_letter'] = $Row['employee_offer_letter'];
                            $dataArray['reporting_date'] = $Row['reporting_date'];
                            $dataArray['reporting_time'] = $Row['reporting_time'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailEmployeeOffer'], $dataArray);
                        }
                    }
                    if($data['detailEmployeeOffer'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/employeeOffer/employee_offer_detail', $data);
                		$this->load->view('footer');
            	    } else {
            	        redirect('error');
            	    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function employeeOfferPdf($employeeOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_OFFER_ALIAS, "can_view");
            if($isPermission){
                $employeeOfferID = urlDecodes($employeeOfferID);
                if(ctype_digit($employeeOfferID)){
            		$data['pdfEmployeeOffer'] = $this->DataModel->getData('employee_offer_id = '.$employeeOfferID, HRM_EMPLOYEE_OFFER_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfEmployeeOffer']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
                    if($data['pdfEmployeeOffer'] != null){
                        ob_start();
                        $html = $this->load->view('hrm/employeeOffer/employee_offer_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Offer Letter'.'.pdf', array("Attachment"=>0));
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function employeeOfferEdit($employeeOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_OFFER_ALIAS, "can_edit");
            if($isPermission){
                $employeeOfferID = urlDecodes($employeeOfferID);
                if(ctype_digit($employeeOfferID)){
                    $data['employeeOfferData'] = $this->DataModel->getData('employee_offer_id = '.$employeeOfferID, HRM_EMPLOYEE_OFFER_TABLE);
                   
                	$data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['employeeOfferData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['employeeOfferData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/employeeOffer/employee_offer_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'reporting_date'=>$this->input->post('reporting_date'),
                            'reporting_time'=>$this->input->post('reporting_time'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('employee_offer_id = '.$employeeOfferID, HRM_EMPLOYEE_OFFER_TABLE, $editData);
                        if($editDataEntry){
                            $sessionEmployeeOfferViewPreviousUrl = $this->session->userdata('session_employee_offer_view_previous_url');
                            if(!empty($sessionEmployeeOfferViewPreviousUrl)){
                                redirect($sessionEmployeeOfferViewPreviousUrl);
                            }
                        }
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function employeeOfferTrash($employeeOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $employeeOfferID = urlDecodes($employeeOfferID);
                    if(ctype_digit($employeeOfferID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('employee_offer_id = '.$employeeOfferID, HRM_EMPLOYEE_OFFER_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_employee_offer_trash_success','Your employee offer has been trash successfully!');
                            $sessionEmployeeOfferViewPreviousUrl = $this->session->userdata('session_employee_offer_view_previous_url');
                            if(!empty($sessionEmployeeOfferViewPreviousUrl)){
                                redirect($sessionEmployeeOfferViewPreviousUrl);
                            }
                        }
                    } else {
                        redirect('error');
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
     public function employeeOfferTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_employee_offer_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_employee_offer_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchEmployeeOfferTrash = $this->input->post('search_employee_offer_trash');
                        $this->session->set_userdata('session_employee_offer_trash', $searchEmployeeOfferTrash);
                    }
                    $sessionEmployeeOfferTrash = $this->session->userdata('session_employee_offer_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_employee_offer_trash_status');
                        redirect('view-trash-employee-offer');
                    }
                        
                    $searchEmployeeOfferTrashStatus = $this->input->post('search_employee_offer_trash_status');
                    if($searchEmployeeOfferTrashStatus == 'active' or $searchEmployeeOfferTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_employee_offer_trash_status', $searchEmployeeOfferTrashStatus);
                    } else if($searchEmployeeOfferTrashStatus === 'all'){
                        $this->session->unset_userdata('session_employee_offer_trash_status');
                    }
                    $sessionEmployeeOfferTrashStatus = $this->session->userdata('session_employee_offer_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_employee_offer_trash'] = $sessionEmployeeOfferTrash;
                    $conditions['search_employee_offer_trash_status'] = $sessionEmployeeOfferTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewEmployeeOfferTrashData($conditions, HRM_EMPLOYEE_OFFER_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-employee-offer');
                    $config['uri_segment'] = 2;
                    $config['total_rows']  = $totalRec;
                    $config['per_page']    = 10;
                    
                    //styling
                    $config['num_tag_open'] = '<li class="page-item page-link">';
                    $config['num_tag_close'] = '</li>';
                    $config['cur_tag_open'] = '<li class="active page-item"><a href="javascript:void(0);" class="page-link" >';
                    $config['cur_tag_close'] = '</a></li>';
                    $config['next_link'] = '&raquo';
                    $config['prev_link'] = '&laquo';
                    $config['next_tag_open'] = '<li class="pg-next page-item page-link">';
                    $config['next_tag_close'] = '</li>';
                    $config['prev_tag_open'] = '<li class="pg-prev page-item page-link">';
                    $config['prev_tag_close'] = '</li>';
                    $config['first_tag_open'] = '<li class="page-item page-link">';
                    $config['first_tag_close'] = '</li>';
                    $config['last_tag_open'] = '<li class="page-item page-link">';
                    $config['last_tag_close'] = '</li>';
                    
                    //initialize pagination library
                    $this->pagination->initialize($config);
                    
                    //define offset
                    $page = $this->uri->segment(2);
                    $offset = !$page?0:$page;
                    
                    //get rows
                    $conditions['returnType'] = '';
                    $conditions['start'] = $offset;
                    $conditions['limit'] = 10;
                    
                    $employeeOffer = $this->DataModel->viewEmployeeOfferTrashData($conditions, HRM_EMPLOYEE_OFFER_TABLE);
                    $data['countEmployeeOffer'] = $this->DataModel->countEmployeeOfferTrashData($conditions, HRM_EMPLOYEE_OFFER_TABLE);

                    $data['viewEmployeeOffer'] = array();
                    if(is_array($employeeOffer) || is_object($employeeOffer)){
                        foreach($employeeOffer as $Row){
                            $dataArray = array();
                            $dataArray['employee_offer_id'] = $Row['employee_offer_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewEmployeeOffer'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/employeeOffer/employee_offer_trash_view', $data);
                    $this->load->view('footer');
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function employeeOfferRestore($employeeOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $employeeOfferID = urlDecodes($employeeOfferID);
                    if(ctype_digit($employeeOfferID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('employee_offer_id = '.$employeeOfferID, HRM_EMPLOYEE_OFFER_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_employee_offer_restore_success','Your employee offer has been restore successfully!');
                            $sessionEmployeeOfferTrashViewPreviousUrl = $this->session->userdata('session_employee_offer_trash_view_previous_url');
                            if(!empty($sessionEmployeeOfferTrashViewPreviousUrl)){
                                redirect($sessionEmployeeOfferTrashViewPreviousUrl);
                            }
                        }
                    } else {
                        redirect('error');
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function employeeOfferDelete($employeeOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $employeeOfferID = urlDecodes($employeeOfferID);
                    if(ctype_digit($employeeOfferID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('employee_offer_id = '.$employeeOfferID, HRM_EMPLOYEE_OFFER_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_employee_offer_delete_success','Your employee offer has been delete successfully!');
                                    $sessionEmployeeOfferTrashViewPreviousUrl = $this->session->userdata('session_employee_offer_trash_view_previous_url');
                                    if(!empty($sessionEmployeeOfferTrashViewPreviousUrl)){
                                        redirect($sessionEmployeeOfferTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_employee_offer_delete_error','Your password are not matched! Please enter correct password');
                                $sessionEmployeeOfferTrashViewPreviousUrl = $this->session->userdata('session_employee_offer_trash_view_previous_url');
                                if(!empty($sessionEmployeeOfferTrashViewPreviousUrl)){
                                    redirect($sessionEmployeeOfferTrashViewPreviousUrl);
                                }
                            }
                        }
                    } else {
                        redirect('error');
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
}
