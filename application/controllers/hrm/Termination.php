<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Termination extends CI_Controller {
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
	
    public function terminationNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_TERMINATION_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['offboardingLettersData'] = $this->DataModel->getData(null, HRM_OFFBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/termination/termination_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'termination_letter'=>$data['offboardingLettersData']['employee_termination_letter'],
                        'termination_reason'=>$this->input->post('termination_reason'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_TERMINATION_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-termination');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function terminationView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_termination_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_termination');
            }
            if(isset($_POST['submit_search'])){
                $searchTermination = $this->input->post('search_termination');
                $this->session->set_userdata('session_termination', $searchTermination);
            }
            $sessionTermination = $this->session->userdata('session_termination');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_termination_email');
                $this->session->unset_userdata('session_termination_status');
                redirect('view-termination');
            }
            
            $searchTerminationEmail = $this->input->post('search_termination_email');
            if($searchTerminationEmail === 'pending' or $searchTerminationEmail == 'sending'){
                $this->session->set_userdata('session_termination_email', $searchTerminationEmail);
            } else if($searchTerminationEmail === 'all'){
                $this->session->unset_userdata('session_termination_email');
            }
            $sessionTerminationEmail = $this->session->userdata('session_termination_email');
            
            $searchTerminationStatus = $this->input->post('search_termination_status');
            if($searchTerminationStatus == 'active' or $searchTerminationStatus == 'inactive'){
                $this->session->set_userdata('session_termination_status', $searchTerminationStatus);
            } else if($searchTerminationStatus === 'all'){
                $this->session->unset_userdata('session_termination_status');
            }
            $sessionTerminationStatus = $this->session->userdata('session_termination_status');
            
            $data = array();
            //get rows count
            $conditions['search_termination'] = $sessionTermination;
            $conditions['search_termination_email'] = $sessionTerminationEmail;
            $conditions['search_termination_status'] = $sessionTerminationStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewTerminationData($conditions, HRM_TERMINATION_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-termination');
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
            
            $termination = $this->DataModel->viewTerminationData($conditions, HRM_TERMINATION_TABLE);
            $data['countTermination'] = $this->DataModel->countTerminationData($conditions, HRM_TERMINATION_TABLE);
            $data['countTerminationTrash'] = $this->DataModel->countTerminationTrashData($conditions, HRM_TERMINATION_TABLE);
            
            $data['viewTermination'] = array();
            if(is_array($termination) || is_object($termination)){
                foreach($termination as $Row){
                    $dataArray = array();
                    $dataArray['termination_id'] = $Row['termination_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['is_email'] = $Row['is_email'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    array_push($data['viewTermination'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/termination/termination_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function terminationEmail($terminationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_TERMINATION_EMAIL_ALIAS, "can_edit");
            if($isPermission){
                $terminationID = urlDecodes($terminationID);
                if(ctype_digit($terminationID)){
            		$data['emailTermination'] = $this->DataModel->getData('termination_id = '.$terminationID, HRM_TERMINATION_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['emailTermination']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['emailTermination'] != null){
        	            $employeeEmail  = $data['employeeData']['employee_email'];
        	            
        	            $pageBreak = '<div style="page-break-before: always;"></div>';
                        
                        ob_start();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'] . '.pdf';
                        $htmlCode = str_replace(array(
                            "#[page_break]#",
                            "#[employee_name]#",
                            "#[termination_reason]#",
                            "#[create_date]#",
                        ),array(
                            $pageBreak,
                            $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'], 
                            $data['emailTermination']['termination_reason'],
                            $data['emailTermination']['create_date'],
                        ),$data['emailTermination']['termination_letter']);
                        
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
                        $mail->Subject = 'Termination Letter';
                        $mail->Body = 'Hello '.$data['employeeData']['employee_first_name'].' '.' '.$data['employeeData']['employee_last_name'].',<br><br>';
                        $mail->Body .= 'Hope you are doing well!<br><br>';
                        $mail->Body .= 'We regret to inform you that your employment with us is being terminated, wef '.$data['emailTermination']['create_date'].'.<br><br>';
                        $mail->Body .= 'Kindly find the attachment and let me know if there are any questions.<br><br>';
                        $mail->Body .= '<br><br><br><br>--<br>Regards,<br>HR Manager<br>+91 99257 27373<br>Syphnosys Technology Private Limited';
                        if($mail->Send()){
                            unlink($fileName);
                            $editData = array(
                                'is_email'=>'sending'
                            );
                            $editDataEntry = $this->DataModel->editData('termination_id = '.$terminationID, HRM_TERMINATION_TABLE, $editData);
                            $this->session->set_userdata("session_termination_email_success","Your mail has been sent successfully!");
                            
                            $sessionTerminationViewPreviousUrl = $this->session->userdata('session_termination_view_previous_url');
                            if(!empty($sessionTerminationViewPreviousUrl)){
                                redirect($sessionTerminationViewPreviousUrl);
                            }
                        } else {
                            unlink($fileName);
                            $this->session->set_userdata('session_termination_email_error','There is error in sending mail! Please try again later');
                            
                            $sessionTerminationViewPreviousUrl = $this->session->userdata('session_termination_view_previous_url');
                            if(!empty($sessionTerminationViewPreviousUrl)){
                                redirect($sessionTerminationViewPreviousUrl);
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
    
    public function terminationDetail($terminationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_TERMINATION_ALIAS, "can_view");
            if($isPermission){
                $terminationID = urlDecodes($terminationID);
                if(ctype_digit($terminationID)){
            		$termination = $this->DataModel->viewData(null, 'termination_id = '.$terminationID, HRM_TERMINATION_TABLE);
        	        $data['detailTermination'] = array();
                    if(is_array($termination) || is_object($termination)){
                        foreach($termination as $Row){
                            $dataArray = array();
                            $dataArray['termination_id'] = $Row['termination_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['termination_letter'] = $Row['termination_letter'];
                            $dataArray['termination_reason'] = $Row['termination_reason'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['detailTermination'], $dataArray);
                        }
                    }
                    if($data['detailTermination'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/termination/termination_detail', $data);
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
    
    public function terminationPdf($terminationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_TERMINATION_ALIAS, "can_view");
            if($isPermission){
                $terminationID = urlDecodes($terminationID);
                if(ctype_digit($terminationID)){
            		$data['pdfTermination'] = $this->DataModel->getData('termination_id = '.$terminationID, HRM_TERMINATION_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfTermination']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
        	        if($data['pdfTermination'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/termination/termination_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Termination Letter'.'.pdf', array("Attachment"=>0));
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
    
    public function terminationEdit($terminationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_TERMINATION_ALIAS, "can_edit");
            if($isPermission){
                $terminationID = urlDecodes($terminationID);
                if(ctype_digit($terminationID)){
                    $data['terminationData'] = $this->DataModel->getData('termination_id = '.$terminationID, HRM_TERMINATION_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['terminationData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['terminationData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/termination/termination_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'termination_reason'=>$this->input->post('termination_reason'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('termination_id = '.$terminationID, HRM_TERMINATION_TABLE, $editData);
                        if($editDataEntry){
                            $sessionTerminationViewPreviousUrl = $this->session->userdata('session_termination_view_previous_url');
                            if(!empty($sessionTerminationViewPreviousUrl)){
                                redirect($sessionTerminationViewPreviousUrl);
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
    
    public function terminationTrash($terminationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $terminationID = urlDecodes($terminationID);
                    if(ctype_digit($terminationID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('termination_id = '.$terminationID, HRM_TERMINATION_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_termination_trash_success','Your termination has been trash successfully!');
                            $sessionTerminationViewPreviousUrl = $this->session->userdata('session_termination_view_previous_url');
                            if(!empty($sessionTerminationViewPreviousUrl)){
                                redirect($sessionTerminationViewPreviousUrl);
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
    
    public function terminationTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_termination_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_termination_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchTerminationTrash = $this->input->post('search_termination_trash');
                        $this->session->set_userdata('session_termination_trash', $searchTerminationTrash);
                    }
                    $sessionTerminationTrash = $this->session->userdata('session_termination_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_termination_trash_status');
                        redirect('view-trash-termination');
                    }
                        
                    $searchTerminationTrashStatus = $this->input->post('search_termination_trash_status');
                    if($searchTerminationTrashStatus == 'active' or $searchTerminationTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_termination_trash_status', $searchTerminationTrashStatus);
                    } else if($searchTerminationTrashStatus === 'all'){
                        $this->session->unset_userdata('session_termination_trash_status');
                    }
                    $sessionTerminationTrashStatus = $this->session->userdata('session_termination_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_termination_trash'] = $sessionTerminationTrash;
                    $conditions['search_termination_trash_status'] = $sessionTerminationTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewTerminationTrashData($conditions, HRM_TERMINATION_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-termination');
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
                    
                    $termination = $this->DataModel->viewTerminationTrashData($conditions, HRM_TERMINATION_TABLE);
                    $data['countTermination'] = $this->DataModel->countTerminationTrashData($conditions, HRM_TERMINATION_TABLE);

                    $data['viewTermination'] = array();
                    if(is_array($termination) || is_object($termination)){
                        foreach($termination as $Row){
                            $dataArray = array();
                            $dataArray['termination_id'] = $Row['termination_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['viewTermination'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/termination/termination_trash_view', $data);
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
    
    public function terminationRestore($terminationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $terminationID = urlDecodes($terminationID);
                    if(ctype_digit($terminationID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('termination_id = '.$terminationID, HRM_TERMINATION_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_termination_restore_success','Your termination has been restore successfully!');
                            $sessionTerminationTrashViewPreviousUrl = $this->session->userdata('session_termination_trash_view_previous_url');
                            if(!empty($sessionTerminationTrashViewPreviousUrl)){
                                redirect($sessionTerminationTrashViewPreviousUrl);
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
    
    public function terminationDelete($terminationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $terminationID = urlDecodes($terminationID);
                    if(ctype_digit($terminationID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('termination_id = '.$terminationID, HRM_TERMINATION_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_termination_delete_success','Your termination has been delete successfully!');
                                    $sessionTerminationTrashViewPreviousUrl = $this->session->userdata('session_termination_trash_view_previous_url');
                                    if(!empty($sessionTerminationTrashViewPreviousUrl)){
                                        redirect($sessionTerminationTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_termination_delete_error','Your password are not matched! Please enter correct password');
                                $sessionTerminationTrashViewPreviousUrl = $this->session->userdata('session_termination_trash_view_previous_url');
                                if(!empty($sessionTerminationTrashViewPreviousUrl)){
                                    redirect($sessionTerminationTrashViewPreviousUrl);
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
