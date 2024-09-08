<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {
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
	
    public function appointmentNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_APPOINTMENT_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/appointment/appointment_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'appointment_letter'=>$data['onboardingLettersData']['employee_appointment_letter'],
                        'effective_date'=>$this->input->post('effective_date'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_APPOINTMENT_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-appointment');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function appointmentView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_appointment_view_previous_url', current_url());
            
            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_appointment');
            }
            if(isset($_POST['submit_search'])){
                $searchAppointment = $this->input->post('search_appointment');
                $this->session->set_userdata('session_appointment', $searchAppointment);
            }
            $sessionAppointment = $this->session->userdata('session_appointment');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_appointment_status');
                redirect('view-appointment');
            }
                
            $searchAppointmnetStatus = $this->input->post('search_appointment_status');
            if($searchAppointmnetStatus == 'active' or $searchAppointmnetStatus == 'inactive'){
                $this->session->set_userdata('session_appointment_status', $searchAppointmnetStatus);
            } else if($searchAppointmnetStatus === 'all'){
                $this->session->unset_userdata('session_appointment_status');
            }
            $sessionAppointmentStatus = $this->session->userdata('session_appointment_status');
            
            $data = array();
            //get rows count
            $conditions['search_appointment'] = $sessionAppointment;
            $conditions['search_appointment_status'] = $sessionAppointmentStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAppointmentData($conditions, HRM_APPOINTMENT_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-appointment');
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

            $appointment = $this->DataModel->viewAppointmentData($conditions, HRM_APPOINTMENT_TABLE);
            $data['countAppointment'] = $this->DataModel->countAppointmentData($conditions, HRM_APPOINTMENT_TABLE);
            $data['countAppointmentTrash'] = $this->DataModel->countAppointmentTrashData($conditions, HRM_APPOINTMENT_TABLE);
            
            $data['viewAppointment'] = array();
            if(is_array($appointment) || is_object($appointment)){
                foreach($appointment as $Row){
                    $dataArray = array();
                    $dataArray['appointment_id'] = $Row['appointment_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewAppointment'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/appointment/appointment_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function appointmentDetail($appointmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_APPOINTMENT_ALIAS, "can_view");
            if($isPermission){
                $appointmentID = urlDecodes($appointmentID);
                if(ctype_digit($appointmentID)){
            		$appointment = $this->DataModel->viewData(null, 'appointment_id = '.$appointmentID, HRM_APPOINTMENT_TABLE);
        	        $data['detailAppointment'] = array();
                    if(is_array($appointment) || is_object($appointment)){
                        foreach($appointment as $Row){
                            $dataArray = array();
                            $dataArray['appointment_id'] = $Row['appointment_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['appointment_letter'] = $Row['appointment_letter'];
                            $dataArray['effective_date'] = $Row['effective_date'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailAppointment'], $dataArray);
                        }
                    }
                    if($data['detailAppointment'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/appointment/appointment_detail', $data);
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
    
    public function appointmentPdf($appointmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_APPOINTMENT_ALIAS, "can_view");
            if($isPermission){
                $appointmentID = urlDecodes($appointmentID);
                if(ctype_digit($appointmentID)){
            		$data['pdfAppointment'] = $this->DataModel->getData('appointment_id = '.$appointmentID, HRM_APPOINTMENT_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfAppointment']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['pdfAppointment'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/appointment/appointment_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Appointment Letter'.'.pdf', array("Attachment"=>0));
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

    public function appointmentEdit($appointmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_APPOINTMENT_ALIAS, "can_edit");
            if($isPermission){
                $appointmentID = urlDecodes($appointmentID);
                if(ctype_digit($appointmentID)){
                    $data['appointmentData'] = $this->DataModel->getData('appointment_id = '.$appointmentID, HRM_APPOINTMENT_TABLE);
                    
                	$data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['appointmentData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['appointmentData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/appointment/appointment_edit', $data);
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
                        $editDataEntry = $this->DataModel->editData('appointment_id = '.$appointmentID, HRM_APPOINTMENT_TABLE, $editData);
                        if($editDataEntry){
                            $sessionAppointmentViewPreviousUrl = $this->session->userdata('session_appointment_view_previous_url');
                            if(!empty($sessionAppointmentViewPreviousUrl)){
                                redirect($sessionAppointmentViewPreviousUrl);
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
    
    public function appointmentTrash($appointmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $appointmentID = urlDecodes($appointmentID);
                    if(ctype_digit($appointmentID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('appointment_id = '.$appointmentID, HRM_APPOINTMENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_appointment_trash_success','Your appointment has been trash successfully!');
                            $sessionAppointmentViewPreviousUrl = $this->session->userdata('session_appointment_view_previous_url');
                            if(!empty($sessionAppointmentViewPreviousUrl)){
                                redirect($sessionAppointmentViewPreviousUrl);
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
    
    public function appointmentTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_appointment_trash_view_previous_url', current_url());
                    
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_appointment_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchAppointmentTrash = $this->input->post('search_appointment_trash');
                        $this->session->set_userdata('session_appointment_trash', $searchAppointmentTrash);
                    }
                    $sessionAppointmentTrash = $this->session->userdata('session_appointment_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_appointment_trash_status');
                        redirect('view-trash-appointment');
                    }
                        
                    $searchAppointmnetTrashStatus = $this->input->post('search_appointment_trash_status');
                    if($searchAppointmnetTrashStatus == 'active' or $searchAppointmnetTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_appointment_trash_status', $searchAppointmnetTrashStatus);
                    } else if($searchAppointmnetTrashStatus === 'all'){
                        $this->session->unset_userdata('session_appointment_trash_status');
                    }
                    $sessionAppointmentTrashStatus = $this->session->userdata('session_appointment_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_appointment_trash'] = $sessionAppointmentTrash;
                    $conditions['search_appointment_trash_status'] = $sessionAppointmentTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewAppointmentTrashData($conditions, HRM_APPOINTMENT_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-appointment');
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
        
                    $appointment = $this->DataModel->viewAppointmentTrashData($conditions, HRM_APPOINTMENT_TABLE);
                    $data['countAppointment'] = $this->DataModel->countAppointmentTrashData($conditions, HRM_APPOINTMENT_TABLE);
        
                    $data['viewAppointment'] = array();
                    if(is_array($appointment) || is_object($appointment)){
                        foreach($appointment as $Row){
                            $dataArray = array();
                            $dataArray['appointment_id'] = $Row['appointment_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewAppointment'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/appointment/appointment_trash_view', $data);
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
    
    public function appointmentRestore($appointmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $appointmentID = urlDecodes($appointmentID);
                    if(ctype_digit($appointmentID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('appointment_id = '.$appointmentID, HRM_APPOINTMENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_appointment_restore_success','Your appointment has been restore successfully!');
                            $sessionAppointmentTrashViewPreviousUrl = $this->session->userdata('session_appointment_trash_view_previous_url');
                            if(!empty($sessionAppointmentTrashViewPreviousUrl)){
                                redirect($sessionAppointmentTrashViewPreviousUrl);
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
    
    public function appointmentDelete($appointmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $appointmentID = urlDecodes($appointmentID);
                    if(ctype_digit($appointmentID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('appointment_id = '.$appointmentID, HRM_APPOINTMENT_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_appointment_delete_success','Your appointment has been delete successfully!');
                                    $sessionAppointmentTrashViewPreviousUrl = $this->session->userdata('session_appointment_trash_view_previous_url');
                                    if(!empty($sessionAppointmentTrashViewPreviousUrl)){
                                        redirect($sessionAppointmentTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_appointment_delete_error','Your password are not matched! Please enter correct password');
                                $sessionAppointmentTrashViewPreviousUrl = $this->session->userdata('session_appointment_trash_view_previous_url');
                                if(!empty($sessionAppointmentTrashViewPreviousUrl)){
                                    redirect($sessionAppointmentTrashViewPreviousUrl);
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
