<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AppraisalCertificate extends CI_Controller {
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
	
    public function appraisalCertificateNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/appraisalCertificate/appraisal_certificate_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'appraisal_certificate_letter'=>$data['onboardingLettersData']['employee_appraisal_certificate_letter'],
                        'effective_date'=>$this->input->post('effective_date'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_APPRAISAL_CERTIFICATE_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-appraisal-certificate');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function appraisalCertificateView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_appraisal_certificate_view_previous_url', current_url());
            
            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_appraisal_certificate');
            }
            if(isset($_POST['submit_search'])){
                $searchAppraisalCertificate = $this->input->post('search_appraisal_certificate');
                $this->session->set_userdata('session_appraisal_certificate', $searchAppraisalCertificate);
            }
            $sessionAppraisalCertificate = $this->session->userdata('session_appraisal_certificate');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_appraisal_certificate_email');
                $this->session->unset_userdata('session_appraisal_certificate_status');
                redirect('view-appraisal-certificate');
            }
                
            $searchAppraisalCertificateEmail = $this->input->post('search_appraisal_certificate_email');
            if($searchAppraisalCertificateEmail === 'pending' or $searchAppraisalCertificateEmail == 'sending'){
                $this->session->set_userdata('session_appraisal_certificate_email', $searchAppraisalCertificateEmail);
            } else if($searchAppraisalCertificateEmail === 'all'){
                $this->session->unset_userdata('session_appraisal_certificate_email');
            }
            $sessionAppraisalCertificateEmail = $this->session->userdata('session_appraisal_certificate_email');
            
            $searchAppraisalCertificateStatus = $this->input->post('search_appraisal_certificate_status');
            if($searchAppraisalCertificateStatus == 'active' or $searchAppraisalCertificateStatus == 'inactive'){
                $this->session->set_userdata('session_appraisal_certificate_status', $searchAppraisalCertificateStatus);
            } else if($searchAppraisalCertificateStatus === 'all'){
                $this->session->unset_userdata('session_appraisal_certificate_status');
            }
            $sessionAppraisalCertificateStatus = $this->session->userdata('session_appraisal_certificate_status');
            
            $data = array();
            //get rows count
            $conditions['search_appraisal_certificate'] = $sessionAppraisalCertificate;
            $conditions['search_appraisal_certificate_email'] = $sessionAppraisalCertificateEmail;
            $conditions['search_appraisal_certificate_status'] = $sessionAppraisalCertificateStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAppraisalCertificateData($conditions, HRM_APPRAISAL_CERTIFICATE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-appraisal-certificate');
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
            
            $appraisalCertificate = $this->DataModel->viewAppraisalCertificateData($conditions, HRM_APPRAISAL_CERTIFICATE_TABLE);
            $data['countAppraisalCertificate'] = $this->DataModel->countAppraisalCertificateData($conditions, HRM_APPRAISAL_CERTIFICATE_TABLE);
            $data['countAppraisalCertificateTrash'] = $this->DataModel->countAppraisalCertificateTrashData($conditions, HRM_APPRAISAL_CERTIFICATE_TABLE);
            
            $data['viewAppraisalCertificate'] = array();
            if(is_array($appraisalCertificate) || is_object($appraisalCertificate)){
                foreach($appraisalCertificate as $Row){
                    $dataArray = array();
                    $dataArray['appraisal_certificate_id'] = $Row['appraisal_certificate_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['is_email'] = $Row['is_email'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewAppraisalCertificate'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/appraisalCertificate/appraisal_certificate_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function appraisalCertificateEmail($appraisalCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_APPRAISAL_CERTIFICATE_EMAIL_ALIAS, "can_edit");
            if($isPermission){
                $appraisalCertificateID = urlDecodes($appraisalCertificateID);
                if(ctype_digit($appraisalCertificateID)){
            		$data['emailAppraisalCertificate'] = $this->DataModel->getData('appraisal_certificate_id = '.$appraisalCertificateID, HRM_APPRAISAL_CERTIFICATE_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['emailAppraisalCertificate']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['emailAppraisalCertificate'] != null){
        	            $employeeEmail  = $data['employeeData']['employee_email'];
        	            
        	            $pageBreak = '<div style="page-break-before: always;"></div>';
                        
                        ob_start();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'] . '.pdf';
                        $htmlCode = str_replace(array(
                            "#[page_break]#",
                            "#[employee_name]#",
                            "#[employee_department]#",
                            "#[employee_salary]#",
                            "#[create_date]#",
                        ),array(
                            $pageBreak,
                            $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'], 
                            $data['departmentData']['department_name'], 
                            $data['employeeData']['employee_salary'],
                            $data['emailAppraisalCertificate']['create_date'],
                        ),$data['emailAppraisalCertificate']['appraisal_certificate_letter']);
                        
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
                        $mail->Subject = 'Appraisal Certificate Letter';
                        $mail->Body = 'Dear '.$data['employeeData']['employee_first_name'].' '.' '.$data['employeeData']['employee_last_name'].',<br><br>';
                        $mail->Body .= 'Thank you for your contribution to the business over time.<br><br>';
                        $mail->Body .= 'I am particularly pleased that you earned a Significantly Exceeds Expectations rating in your performance review. This is just a reward for your dedication, passion, and commitment to excellence.<br><br>';
                        $mail->Body .= 'Congratulations on your promotion, effective '.$data['emailAppraisalCertificate']['effective_date'].'<br><br>';
                        $mail->Body .= 'We have consolidated our business through the last financial year and look forward to a year of strong growth. With your commitment and contribution, I am confident of a great year ahead in which we will surpass all our targets.<br><br>';
                        $mail->Body .= "I've attached the details of your revised compensation package.<br><br>";
                        $mail->Body .= '<br><br><br><br>--<br>Regards,<br>HR Manager<br>+91 99257 27373<br>Syphnosys Technology Private Limited';
                        if($mail->Send()){
                            unlink($fileName);
                            $editData = array(
                                'is_email'=>'sending'
                            );
                            $editDataEntry = $this->DataModel->editData('appraisal_certificate_id = '.$appraisalCertificateID, HRM_APPRAISAL_CERTIFICATE_TABLE, $editData);
                            $this->session->set_userdata("session_appraisal_certificate_email_success","Your mail has been sent successfully!");
                            
                            $sessionAppraisalCertificateViewPreviousUrl = $this->session->userdata('session_appraisal_certificate_view_previous_url');
                            if(!empty($sessionAppraisalCertificateViewPreviousUrl)){
                                redirect($sessionAppraisalCertificateViewPreviousUrl);
                            }
                        } else {
                            unlink($fileName);
                            $this->session->set_userdata('session_appraisal_certificate_email_error','There is error in sending mail! Please try again later');
                            
                            $sessionAppraisalCertificateViewPreviousUrl = $this->session->userdata('session_appraisal_certificate_view_previous_url');
                            if(!empty($sessionAppraisalCertificateViewPreviousUrl)){
                                redirect($sessionAppraisalCertificateViewPreviousUrl);
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
    
    public function appraisalCertificateDetail($appraisalCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_view");
            if($isPermission){
                $appraisalCertificateID = urlDecodes($appraisalCertificateID);
                if(ctype_digit($appraisalCertificateID)){
            		$appraisalCertificate = $this->DataModel->viewData(null, 'appraisal_certificate_id = '.$appraisalCertificateID, HRM_APPRAISAL_CERTIFICATE_TABLE);
        	        $data['detailAppraisalCertificate'] = array();
                    if(is_array($appraisalCertificate) || is_object($appraisalCertificate)){
                        foreach($appraisalCertificate as $Row){
                            $dataArray = array();
                            $dataArray['appraisal_certificate_id'] = $Row['appraisal_certificate_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['appraisal_certificate_letter'] = $Row['appraisal_certificate_letter'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailAppraisalCertificate'], $dataArray);
                        }
                    }
                    if($data['detailAppraisalCertificate'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/appraisalCertificate/appraisal_certificate_detail', $data);
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
    
    public function appraisalCertificatePdf($appraisalCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_view");
            if($isPermission){
                $appraisalCertificateID = urlDecodes($appraisalCertificateID);
                if(ctype_digit($appraisalCertificateID)){
            		$data['pdfAppraisalCertificate'] = $this->DataModel->getData('appraisal_certificate_id = '.$appraisalCertificateID, HRM_APPRAISAL_CERTIFICATE_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfAppraisalCertificate']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['pdfAppraisalCertificate'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/appraisalCertificate/appraisal_certificate_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Appraisal Certificate'.'.pdf', array("Attachment"=>0));
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
    
    public function appraisalCertificateEdit($appraisalCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_edit");
            if($isPermission){
                $appraisalCertificateID = urlDecodes($appraisalCertificateID);
                if(ctype_digit($appraisalCertificateID)){
                    $data['appraisalCertificateData'] = $this->DataModel->getData('appraisal_certificate_id = '.$appraisalCertificateID, HRM_APPRAISAL_CERTIFICATE_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['appraisalCertificateData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['appraisalCertificateData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/appraisalCertificate/appraisal_certificate_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'effective_date'=>$this->input->post('effective_date'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('appraisal_certificate_id = '.$appraisalCertificateID, HRM_APPRAISAL_CERTIFICATE_TABLE, $editData);
                        if($editDataEntry){
                            $sessionAppraisalCertificateViewPreviousUrl = $this->session->userdata('session_appraisal_certificate_view_previous_url');
                            if(!empty($sessionAppraisalCertificateViewPreviousUrl)){
                                redirect($sessionAppraisalCertificateViewPreviousUrl);
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
    
    public function appraisalCertificateTrash($appraisalCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $appraisalCertificateID = urlDecodes($appraisalCertificateID);
                    if(ctype_digit($appraisalCertificateID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('appraisal_certificate_id = '.$appraisalCertificateID, HRM_APPRAISAL_CERTIFICATE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_appraisal_certificate_trash_success','Your appraisal certificate has been trash successfully!');
                            $sessionAppraisalCertificateViewPreviousUrl = $this->session->userdata('session_appraisal_certificate_view_previous_url');
                            if(!empty($sessionAppraisalCertificateViewPreviousUrl)){
                                redirect($sessionAppraisalCertificateViewPreviousUrl);
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
    
    public function appraisalCertificateTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_appraisal_certificate_trash_view_previous_url', current_url());
                    
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_appraisal_certificate_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchAppraisalCertificateTrash = $this->input->post('search_appraisal_certificate_trash');
                        $this->session->set_userdata('session_appraisal_certificate_trash', $searchAppraisalCertificateTrash);
                    }
                    $sessionAppraisalCertificateTrash = $this->session->userdata('session_appraisal_certificate_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_appraisal_certificate_trash_status');
                        redirect('view-trash-appraisal-certificate');
                    }
                        
                    $searchAppraisalCertificateTrashStatus = $this->input->post('search_appraisal_certificate_trash_status');
                    if($searchAppraisalCertificateTrashStatus == 'active' or $searchAppraisalCertificateTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_appraisal_certificate_trash_status', $searchAppraisalCertificateTrashStatus);
                    } else if($searchAppraisalCertificateTrashStatus === 'all'){
                        $this->session->unset_userdata('session_appraisal_certificate_trash_status');
                    }
                    $sessionAppraisalCertificateTrashStatus = $this->session->userdata('session_appraisal_certificate_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_appraisal_certificate_trash'] = $sessionAppraisalCertificateTrash;
                    $conditions['search_appraisal_certificate_trash_status'] = $sessionAppraisalCertificateTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewAppraisalCertificateTrashData($conditions, HRM_APPRAISAL_CERTIFICATE_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-appraisal-certificate');
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
                    
                    $appraisalCertificate = $this->DataModel->viewAppraisalCertificateTrashData($conditions, HRM_APPRAISAL_CERTIFICATE_TABLE);
                    $data['countAppraisalCertificate'] = $this->DataModel->countAppraisalCertificateTrashData($conditions, HRM_APPRAISAL_CERTIFICATE_TABLE);

                    $data['viewAppraisalCertificate'] = array();
                    if(is_array($appraisalCertificate) || is_object($appraisalCertificate)){
                        foreach($appraisalCertificate as $Row){
                            $dataArray = array();
                            $dataArray['appraisal_certificate_id'] = $Row['appraisal_certificate_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewAppraisalCertificate'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/appraisalCertificate/appraisal_certificate_trash_view', $data);
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
    
    public function appraisalCertificateRestore($appraisalCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $appraisalCertificateID = urlDecodes($appraisalCertificateID);
                    if(ctype_digit($appraisalCertificateID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('appraisal_certificate_id = '.$appraisalCertificateID, HRM_APPRAISAL_CERTIFICATE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_appraisal_certificate_restore_success','Your appraisal certificate has been restore successfully!');
                            $sessionAppraisalCertificateTrashViewPreviousUrl = $this->session->userdata('session_appraisal_certificate_trash_view_previous_url');
                            if(!empty($sessionAppraisalCertificateTrashViewPreviousUrl)){
                                redirect($sessionAppraisalCertificateTrashViewPreviousUrl);
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
    
    public function appraisalCertificateDelete($appraisalCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $appraisalCertificateID = urlDecodes($appraisalCertificateID);
                    if(ctype_digit($appraisalCertificateID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('appraisal_certificate_id = '.$appraisalCertificateID, HRM_APPRAISAL_CERTIFICATE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_appraisal_certificate_delete_success','Your appraisal certificate has been delete successfully!');
                                    $sessionAppraisalCertificateTrashViewPreviousUrl = $this->session->userdata('session_appraisal_certificate_trash_view_previous_url');
                                    if(!empty($sessionAppraisalCertificateTrashViewPreviousUrl)){
                                        redirect($sessionAppraisalCertificateTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_appraisal_certificate_delete_error','Your password are not matched! Please enter correct password');
                                $sessionAppraisalCertificateTrashViewPreviousUrl = $this->session->userdata('session_appraisal_certificate_trash_view_previous_url');
                                if(!empty($sessionAppraisalCertificateTrashViewPreviousUrl)){
                                    redirect($sessionAppraisalCertificateTrashViewPreviousUrl);
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
