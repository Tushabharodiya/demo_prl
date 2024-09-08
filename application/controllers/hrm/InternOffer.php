<?php defined('BASEPATH') OR exit('No direct script access allowed');

class InternOffer extends CI_Controller {
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
	
    public function internOfferNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_INTERN_OFFER_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "intern" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/internOffer/intern_offer_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'intern_offer_letter'=>$data['onboardingLettersData']['intern_offer_letter'],
                        'reporting_date'=>$this->input->post('reporting_date'),
                        'reporting_time'=>$this->input->post('reporting_time'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_INTERN_OFFER_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-intern-offer');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function internOfferView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_intern_offer_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_intern_offer');
            }
            if(isset($_POST['submit_search'])){
                $searchInternOffer = $this->input->post('search_intern_offer');
                $this->session->set_userdata('session_intern_offer', $searchInternOffer);
            }
            $sessionInternOffer = $this->session->userdata('session_intern_offer');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_intern_offer_email');
                $this->session->unset_userdata('session_intern_offer_status');
                redirect('view-intern-offer');
            }
            
            $searchInternOfferEmail = $this->input->post('search_intern_offer_email');
            if($searchInternOfferEmail === 'pending' or $searchInternOfferEmail == 'sending'){
                $this->session->set_userdata('session_intern_offer_email', $searchInternOfferEmail);
            } else if($searchInternOfferEmail === 'all'){
                $this->session->unset_userdata('session_intern_offer_email');
            }
            $sessionInternOfferEmail = $this->session->userdata('session_intern_offer_email');
            
            $searchInternOfferStatus = $this->input->post('search_intern_offer_status');
            if($searchInternOfferStatus == 'active' or $searchInternOfferStatus == 'inactive'){
                $this->session->set_userdata('session_intern_offer_status', $searchInternOfferStatus);
            } else if($searchInternOfferStatus === 'all'){
                $this->session->unset_userdata('session_intern_offer_status');
            }
            $sessionInternOfferStatus = $this->session->userdata('session_intern_offer_status');
            
            $data = array();
            //get rows count
            $conditions['search_intern_offer'] = $sessionInternOffer;
            $conditions['search_intern_offer_email'] = $sessionInternOfferEmail;
            $conditions['search_intern_offer_status'] = $sessionInternOfferStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewInternOfferData($conditions, HRM_INTERN_OFFER_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-intern-offer');
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
            
            $internOffer = $this->DataModel->viewInternOfferData($conditions, HRM_INTERN_OFFER_TABLE);
            $data['countInternOffer'] = $this->DataModel->countInternOfferData($conditions, HRM_INTERN_OFFER_TABLE);
            $data['countInternOfferTrash'] = $this->DataModel->countInternOfferTrashData($conditions, HRM_INTERN_OFFER_TABLE);
            
            $data['viewInternOffer'] = array();
            if(is_array($internOffer) || is_object($internOffer)){
                foreach($internOffer as $Row){
                    $dataArray = array();
                    $dataArray['intern_offer_id'] = $Row['intern_offer_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['is_email'] = $Row['is_email'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewInternOffer'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/internOffer/intern_offer_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function internOfferEmail($internOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_INTERN_OFFER_EMAIL_ALIAS, "can_edit");
            if($isPermission){
                $internOfferID = urlDecodes($internOfferID);
                if(ctype_digit($internOfferID)){
            		$data['emailInternOffer'] = $this->DataModel->getData('intern_offer_id = '.$internOfferID, HRM_INTERN_OFFER_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['emailInternOffer']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['emailInternOffer'] != null){
        	            $employeeEmail  = $data['employeeData']['employee_email'];
        	            
        	            $pageBreak = '<div style="page-break-before: always;"></div>';
                
                        $employeeStipend = $data['employeeData']['employee_stipend']; 
                        $myNumber = str_replace(',', '', $employeeStipend); 
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
                        $stipendWord = ($points) ? $result . "Rupees  " . $points . " Paise" : $result . "Rupees ";
                        
                        ob_start();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'] . '.pdf';
                        $htmlCode = str_replace(array(
                            "#[page_break]#",
                            "#[employee_name]#",
                            "#[employee_department]#",
                            "#[employee_internship_month]#",
                            "#[employee_stipend]#",
                            "#[employee_stipend_word]#",
                            "#[reporting_date]#",
                            "#[reporting_time]#",
                            "#[create_date]#",
                        ),array(
                            $pageBreak,
                            $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'], 
                            $data['departmentData']['department_name'], 
                            $data['employeeData']['employee_internship_month'], 
                            $data['employeeData']['employee_stipend'], 
                            $stipendWord,
                            $data['emailInternOffer']['reporting_date'],
                            $data['emailInternOffer']['reporting_time'],
                            $data['emailInternOffer']['create_date'], 
                        ),$data['emailInternOffer']['intern_offer_letter']);
                        
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
                        $mail->Subject = 'Intern Offer Letter';
                        $mail->Body = 'Dear '.$data['employeeData']['employee_first_name'].' '.' '.$data['employeeData']['employee_last_name'].',<br><br>';
                        $mail->Body .= 'Congratulations on your offer from Syphnosys Technology Private Limited!<br><br>';
                        $mail->Body .= 'We are delighted to offer you the position of '.$data['departmentData']['department_name'].' (Trainee) with an anticipated start date of '.$data['employeeData']['employee_joining_date'].' as discussed, Please find attached your detailed offer letter.<br><br>';
                        $mail->Body .= 'A warm welcome to the team! Looking forward to working with your expertise.<br><br>';
                        $mail->Body .= 'Please confirm that you have received this email and accept the offer.<br><br>';
                        $mail->Body .= '<br><br><br><br>--<br>Regards,<br>HR Manager<br>+91 99257 27373<br>Syphnosys Technology Private Limited';
                        if($mail->Send()){
                            unlink($fileName);
                            $editData = array(
                                'is_email'=>'sending'
                            );
                            $editDataEntry = $this->DataModel->editData('intern_offer_id = '.$internOfferID, HRM_INTERN_OFFER_TABLE, $editData);
                            $this->session->set_userdata("session_intern_offer_email_success","Your mail has been sent successfully!");
                            
                            $sessionInternOfferViewPreviousUrl = $this->session->userdata('session_intern_offer_view_previous_url');
                            if(!empty($sessionInternOfferViewPreviousUrl)){
                                redirect($sessionInternOfferViewPreviousUrl);
                            }
                        } else {
                            unlink($fileName);
                            $this->session->set_userdata('session_intern_offer_email_error','There is error in sending mail! Please try again later');
                            
                            $sessionInternOfferViewPreviousUrl = $this->session->userdata('session_intern_offer_view_previous_url');
                            if(!empty($sessionInternOfferViewPreviousUrl)){
                                redirect($sessionInternOfferViewPreviousUrl);
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
    
    public function internOfferDetail($internOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_INTERN_OFFER_ALIAS, "can_view");
            if($isPermission){
                $internOfferID = urlDecodes($internOfferID);
                if(ctype_digit($internOfferID)){
            		$internOffer = $this->DataModel->viewData(null, 'intern_offer_id = '.$internOfferID, HRM_INTERN_OFFER_TABLE);
        	        $data['detailInternOffer'] = array();
                    if(is_array($internOffer) || is_object($internOffer)){
                        foreach($internOffer as $Row){
                            $dataArray = array();
                            $dataArray['intern_offer_id'] = $Row['intern_offer_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['intern_offer_letter'] = $Row['intern_offer_letter'];
                            $dataArray['reporting_date'] = $Row['reporting_date'];
                            $dataArray['reporting_time'] = $Row['reporting_time'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailInternOffer'], $dataArray);
                        }
                    }
                    if($data['detailInternOffer'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/internOffer/intern_offer_detail', $data);
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
    
    public function internOfferPdf($internOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_INTERN_OFFER_ALIAS, "can_view");
            if($isPermission){
                $internOfferID = urlDecodes($internOfferID);
                if(ctype_digit($internOfferID)){
            		$data['pdfInternOffer'] = $this->DataModel->getData('intern_offer_id = '.$internOfferID, HRM_INTERN_OFFER_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfInternOffer']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
                    if($data['pdfInternOffer'] != null){
                        ob_start();
                        $html = $this->load->view('hrm/internOffer/intern_offer_pdf', $data, TRUE);
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
    
    public function internOfferEdit($internOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_INTERN_OFFER_ALIAS, "can_edit");
            if($isPermission){
                $internOfferID = urlDecodes($internOfferID);
                if(ctype_digit($internOfferID)){
                    $data['internOfferData'] = $this->DataModel->getData('intern_offer_id = '.$internOfferID, HRM_INTERN_OFFER_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "intern" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['internOfferData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['internOfferData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/internOffer/intern_offer_edit', $data);
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
                        $editDataEntry = $this->DataModel->editData('intern_offer_id = '.$internOfferID, HRM_INTERN_OFFER_TABLE, $editData);
                        if($editDataEntry){
                            $sessionInternOfferViewPreviousUrl = $this->session->userdata('session_intern_offer_view_previous_url');
                            if(!empty($sessionInternOfferViewPreviousUrl)){
                                redirect($sessionInternOfferViewPreviousUrl);
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
    
    public function internOfferTrash($internOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $internOfferID = urlDecodes($internOfferID);
                    if(ctype_digit($internOfferID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('intern_offer_id = '.$internOfferID, HRM_INTERN_OFFER_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_intern_offer_trash_success','Your intern offer has been trash successfully!');
                            $sessionInternOfferViewPreviousUrl = $this->session->userdata('session_intern_offer_view_previous_url');
                            if(!empty($sessionInternOfferViewPreviousUrl)){
                                redirect($sessionInternOfferViewPreviousUrl);
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
    
     public function internOfferTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_intern_offer_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_intern_offer_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchInternOfferTrash = $this->input->post('search_intern_offer_trash');
                        $this->session->set_userdata('session_intern_offer_trash', $searchInternOfferTrash);
                    }
                    $sessionInternOfferTrash = $this->session->userdata('session_intern_offer_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_intern_offer_trash_status');
                        redirect('view-trash-intern-offer');
                    }
                        
                    $searchInternOfferTrashStatus = $this->input->post('search_intern_offer_trash_status');
                    if($searchInternOfferTrashStatus == 'active' or $searchInternOfferTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_intern_offer_trash_status', $searchInternOfferTrashStatus);
                    } else if($searchInternOfferTrashStatus === 'all'){
                        $this->session->unset_userdata('session_intern_offer_trash_status');
                    }
                    $sessionInternOfferTrashStatus = $this->session->userdata('session_intern_offer_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_intern_offer_trash'] = $sessionInternOfferTrash;
                    $conditions['search_intern_offer_trash_status'] = $sessionInternOfferTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewInternOfferTrashData($conditions, HRM_INTERN_OFFER_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-intern-offer');
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
                    
                    $internOffer = $this->DataModel->viewInternOfferTrashData($conditions, HRM_INTERN_OFFER_TABLE);
                    $data['countInternOffer'] = $this->DataModel->countInternOfferTrashData($conditions, HRM_INTERN_OFFER_TABLE);
        
                    $data['viewInternOffer'] = array();
                    if(is_array($internOffer) || is_object($internOffer)){
                        foreach($internOffer as $Row){
                            $dataArray = array();
                            $dataArray['intern_offer_id'] = $Row['intern_offer_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewInternOffer'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/internOffer/intern_offer_trash_view', $data);
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
    
    public function internOfferRestore($internOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $internOfferID = urlDecodes($internOfferID);
                    if(ctype_digit($internOfferID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('intern_offer_id = '.$internOfferID, HRM_INTERN_OFFER_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_intern_offer_restore_success','Your intern offer has been restore successfully!');
                            $sessionInternOfferTrashViewPreviousUrl = $this->session->userdata('session_intern_offer_trash_view_previous_url');
                            if(!empty($sessionInternOfferTrashViewPreviousUrl)){
                                redirect($sessionInternOfferTrashViewPreviousUrl);
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
    
    public function internOfferDelete($internOfferID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $internOfferID = urlDecodes($internOfferID);
                    if(ctype_digit($internOfferID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('intern_offer_id = '.$internOfferID, HRM_INTERN_OFFER_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_intern_offer_delete_success','Your intern offer has been delete successfully!');
                                    $sessionInternOfferTrashViewPreviousUrl = $this->session->userdata('session_intern_offer_trash_view_previous_url');
                                    if(!empty($sessionInternOfferTrashViewPreviousUrl)){
                                        redirect($sessionInternOfferTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_intern_offer_delete_error','Your password are not matched! Please enter correct password');
                                $sessionInternOfferTrashViewPreviousUrl = $this->session->userdata('session_intern_offer_trash_view_previous_url');
                                if(!empty($sessionInternOfferTrashViewPreviousUrl)){
                                    redirect($sessionInternOfferTrashViewPreviousUrl);
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
