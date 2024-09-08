<?php defined('BASEPATH') OR exit('No direct script access allowed');

class WarningMail extends CI_Controller {
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
	
    public function warningMailNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_WARNING_MAIL_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/warningMail/warning_mail_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'warning_letter'=>$data['onboardingLettersData']['employee_warning_letter'],
                        'warning_reason'=>$this->input->post('warning_reason'),
                        'warning_description'=>$this->input->post('warning_description'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_WARNING_MAIL_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-warning-mail');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function warningMailView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_warning_mail_view_previous_url', current_url());
            
            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_warning_mail');
            }
            if(isset($_POST['submit_search'])){
                $searchWarningMail = $this->input->post('search_warning_mail');
                $this->session->set_userdata('session_warning_mail', $searchWarningMail);
            }
            $sessionWarningMail = $this->session->userdata('session_warning_mail');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_warning_mail_email');
                $this->session->unset_userdata('session_warning_mail_status');
                redirect('view-warning-mail');
            }
                
            $searchWarningMailEmail = $this->input->post('search_warning_mail_email');
            if($searchWarningMailEmail === 'pending' or $searchWarningMailEmail == 'sending'){
                $this->session->set_userdata('session_warning_mail_email', $searchWarningMailEmail);
            } else if($searchWarningMailEmail === 'all'){
                $this->session->unset_userdata('session_warning_mail_email');
            }
            $sessionWarningMailEmail = $this->session->userdata('session_warning_mail_email');
            
            $searchWarningMailStatus = $this->input->post('search_warning_mail_status');
            if($searchWarningMailStatus == 'active' or $searchWarningMailStatus == 'inactive'){
                $this->session->set_userdata('session_warning_mail_status', $searchWarningMailStatus);
            } else if($searchWarningMailStatus === 'all'){
                $this->session->unset_userdata('session_warning_mail_status');
            }
            $sessionWarningMailStatus = $this->session->userdata('session_warning_mail_status');
            
            $data = array();
            //get rows count
            $conditions['search_warning_mail'] = $sessionWarningMail;
            $conditions['search_warning_mail_email'] = $sessionWarningMailEmail;
            $conditions['search_warning_mail_status'] = $sessionWarningMailStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewWarningMailData($conditions, HRM_WARNING_MAIL_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-warning-mail');
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
            
            $warningMail = $this->DataModel->viewWarningMailData($conditions, HRM_WARNING_MAIL_TABLE);
            $data['countWarningMail'] = $this->DataModel->countWarningMailData($conditions, HRM_WARNING_MAIL_TABLE);
            $data['countWarningMailTrash'] = $this->DataModel->countWarningMailTrashData($conditions, HRM_WARNING_MAIL_TABLE);
            
            $data['viewWarningMail'] = array();
            if(is_array($warningMail) || is_object($warningMail)){
                foreach($warningMail as $Row){
                    $dataArray = array();
                    $dataArray['warning_mail_id'] = $Row['warning_mail_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['warning_reason'] = $Row['warning_reason'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['is_email'] = $Row['is_email'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    array_push($data['viewWarningMail'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/warningMail/warning_mail_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function warningMailEmail($warningMailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_WARNING_MAIL_EMAIL_ALIAS, "can_edit");
            if($isPermission){
                $warningMailID = urlDecodes($warningMailID);
                if(ctype_digit($warningMailID)){
            		$data['emailWarningMail'] = $this->DataModel->getData('warning_mail_id = '.$warningMailID, HRM_WARNING_MAIL_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['emailWarningMail']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['emailWarningMail'] != null){
        	            $employeeEmail  = $data['employeeData']['employee_email'];
        	            
        	            $pageBreak = '<div style="page-break-before: always;"></div>';
                        
                        ob_start();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'] . '.pdf';
                        $htmlCode = str_replace(array(
                            "#[page_break]#",
                            "#[employee_name]#",
                            "#[warning_reason]#",
                            "#[warning_description]#",
                            "#[create_date]#",
                        ),array(
                            $pageBreak,
                            $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'], 
                            $data['emailWarningMail']['warning_reason'],
                            $data['emailWarningMail']['warning_description'],
                            $data['emailWarningMail']['create_date'],
                        ),$data['emailWarningMail']['warning_letter']);
                        
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
                        $mail->Subject = 'Warning Mail Letter';
                        $mail->Body = 'Hello '.$data['employeeData']['employee_first_name'].' '.' '.$data['employeeData']['employee_last_name'].',<br><br>';
                        $mail->Body .= 'Hope you are doing well!<br><br>';
                        $mail->Body .= 'Kindly find the attachment and let me know if there are any questions.<br><br>';
                        $mail->Body .= '<br><br><br><br>--<br>Regards,<br>HR Manager<br>+91 99257 27373<br>Syphnosys Technology Private Limited';
                        if($mail->Send()){
                            unlink($fileName);
                            $editData = array(
                                'is_email'=>'sending'
                            );
                            $editDataEntry = $this->DataModel->editData('warning_mail_id = '.$warningMailID, HRM_WARNING_MAIL_TABLE, $editData);
                            $this->session->set_userdata("session_warning_mail_email_success","Your mail has been sent successfully!");
                            
                            $sessionWarningMailViewPreviousUrl = $this->session->userdata('session_warning_mail_view_previous_url');
                            if(!empty($sessionWarningMailViewPreviousUrl)){
                                redirect($sessionWarningMailViewPreviousUrl);
                            }
                        } else {
                            unlink($fileName);
                            $this->session->set_userdata('session_warning_mail_email_error','There is error in sending mail! Please try again later');
                            
                            $sessionWarningMailViewPreviousUrl = $this->session->userdata('session_warning_mail_view_previous_url');
                            if(!empty($sessionWarningMailViewPreviousUrl)){
                                redirect($sessionWarningMailViewPreviousUrl);
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
    
    public function warningMailDetail($warningMailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_WARNING_MAIL_ALIAS, "can_view");
            if($isPermission){
                $warningMailID = urlDecodes($warningMailID);
                if(ctype_digit($warningMailID)){
            		$warningMail = $this->DataModel->viewData(null, 'warning_mail_id = '.$warningMailID, HRM_WARNING_MAIL_TABLE);
        	        $data['detailWarningMail'] = array();
                    if(is_array($warningMail) || is_object($warningMail)){
                        foreach($warningMail as $Row){
                            $dataArray = array();
                            $dataArray['warning_mail_id'] = $Row['warning_mail_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['warning_letter'] = $Row['warning_letter'];
                            $dataArray['warning_reason'] = $Row['warning_reason'];
                            $dataArray['warning_description'] = $Row['warning_description'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['detailWarningMail'], $dataArray);
                        }
                    }
                    if($data['detailWarningMail'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/warningMail/warning_mail_detail', $data);
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
    
    public function warningMailPdf($warningMailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_WARNING_MAIL_ALIAS, "can_view");
            if($isPermission){
                $warningMailID = urlDecodes($warningMailID);
                if(ctype_digit($warningMailID)){
            		$data['pdfWarningMail'] = $this->DataModel->getData('warning_mail_id = '.$warningMailID, HRM_WARNING_MAIL_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfWarningMail']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
        	        if($data['pdfWarningMail'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/warningMail/warning_mail_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Warning Mail'.'.pdf', array("Attachment"=>0));
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
    
    public function warningMailEdit($warningMailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_WARNING_MAIL_ALIAS, "can_edit");
            if($isPermission){
                $warningMailID = urlDecodes($warningMailID);
                if(ctype_digit($warningMailID)){
                    $data['warningMailData'] = $this->DataModel->getData('warning_mail_id = '.$warningMailID, HRM_WARNING_MAIL_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['warningMailData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['warningMailData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/warningMail/warning_mail_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'warning_reason'=>$this->input->post('warning_reason'),
                            'warning_description'=>$this->input->post('warning_description'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('warning_mail_id = '.$warningMailID, HRM_WARNING_MAIL_TABLE, $editData);
                        if($editDataEntry){
                            $sessionWarningMailViewPreviousUrl = $this->session->userdata('session_warning_mail_view_previous_url');
                            if(!empty($sessionWarningMailViewPreviousUrl)){
                                redirect($sessionWarningMailViewPreviousUrl);
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
    
    public function warningMailTrash($warningMailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $warningMailID = urlDecodes($warningMailID);
                    if(ctype_digit($warningMailID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('warning_mail_id = '.$warningMailID, HRM_WARNING_MAIL_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_warning_mail_trash_success','Your warning mail has been trash successfully!');
                            $sessionWarningMailViewPreviousUrl = $this->session->userdata('session_warning_mail_view_previous_url');
                            if(!empty($sessionWarningMailViewPreviousUrl)){
                                redirect($sessionWarningMailViewPreviousUrl);
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
    
    public function warningMailTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_warning_mail_trash_view_previous_url', current_url());
                    
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_warning_mail_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchWarningMailTrash = $this->input->post('search_warning_mail_trash');
                        $this->session->set_userdata('session_warning_mail_trash', $searchWarningMailTrash);
                    }
                    $sessionWarningMailTrash = $this->session->userdata('session_warning_mail_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_warning_mail_trash_status');
                        redirect('view-trash-warning-mail');
                    }
                        
                    $searchWarningMailTrashStatus = $this->input->post('search_warning_mail_trash_status');
                    if($searchWarningMailTrashStatus == 'active' or $searchWarningMailTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_warning_mail_trash_status', $searchWarningMailTrashStatus);
                    } else if($searchWarningMailTrashStatus === 'all'){
                        $this->session->unset_userdata('session_warning_mail_trash_status');
                    }
                    $sessionWarningMailTrashStatus = $this->session->userdata('session_warning_mail_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_warning_mail_trash'] = $sessionWarningMailTrash;
                    $conditions['search_warning_mail_trash_status'] = $sessionWarningMailTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewWarningMailTrashData($conditions, HRM_WARNING_MAIL_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-warning-mail');
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
                    
                    $warningMail = $this->DataModel->viewWarningMailTrashData($conditions, HRM_WARNING_MAIL_TABLE);
                    $data['countWarningMail'] = $this->DataModel->countWarningMailTrashData($conditions, HRM_WARNING_MAIL_TABLE);

                    $data['viewWarningMail'] = array();
                    if(is_array($warningMail) || is_object($warningMail)){
                        foreach($warningMail as $Row){
                            $dataArray = array();
                            $dataArray['warning_mail_id'] = $Row['warning_mail_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['warning_reason'] = $Row['warning_reason'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['viewWarningMail'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/warningMail/warning_mail_trash_view', $data);
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
    
    public function warningMailRestore($warningMailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $warningMailID = urlDecodes($warningMailID);
                    if(ctype_digit($warningMailID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('warning_mail_id = '.$warningMailID, HRM_WARNING_MAIL_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_warning_mail_restore_success','Your warning mail has been restore successfully!');
                            $sessionWarningMailTrashViewPreviousUrl = $this->session->userdata('session_warning_mail_trash_view_previous_url');
                            if(!empty($sessionWarningMailTrashViewPreviousUrl)){
                                redirect($sessionWarningMailTrashViewPreviousUrl);
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
    
    public function warningMailDelete($warningMailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $warningMailID = urlDecodes($warningMailID);
                    if(ctype_digit($warningMailID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('warning_mail_id = '.$warningMailID, HRM_WARNING_MAIL_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_warning_mail_delete_success','Your warning mail has been delete successfully!');
                                    $sessionWarningMailTrashViewPreviousUrl = $this->session->userdata('session_warning_mail_trash_view_previous_url');
                                    if(!empty($sessionWarningMailTrashViewPreviousUrl)){
                                        redirect($sessionWarningMailTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_warning_mail_delete_error','Your password are not matched! Please enter correct password');
                                $sessionWarningMailTrashViewPreviousUrl = $this->session->userdata('session_warning_mail_trash_view_previous_url');
                                if(!empty($sessionWarningMailTrashViewPreviousUrl)){
                                    redirect($sessionWarningMailTrashViewPreviousUrl);
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
