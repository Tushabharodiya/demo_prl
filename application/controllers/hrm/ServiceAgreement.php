<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceAgreement extends CI_Controller {
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
	
    public function serviceAgreementNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SERVICE_AGREEMENT_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/serviceAgreement/service_agreement_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'service_agreement_letter'=>$data['onboardingLettersData']['employee_service_agreement_letter'],
                        'director_name'=>$this->input->post('director_name'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_SERVICE_AGREEMENT_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-service-agreement');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function serviceAgreementView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_service_agreement_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_service_agreement');
            }
            if(isset($_POST['submit_search'])){
                $searchServiceAgreement = $this->input->post('search_service_agreement');
                $this->session->set_userdata('session_service_agreement', $searchServiceAgreement);
            }
            $sessionServiceAgreement = $this->session->userdata('session_service_agreement');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_service_agreement_status');
                redirect('view-service-agreement');
            }
                
            $searchServiceAgreementStatus = $this->input->post('search_service_agreement_status');
            if($searchServiceAgreementStatus == 'active' or $searchServiceAgreementStatus == 'inactive'){
                $this->session->set_userdata('session_service_agreement_status', $searchServiceAgreementStatus);
            } else if($searchServiceAgreementStatus === 'all'){
                $this->session->unset_userdata('session_service_agreement_status');
            }
            $sessionServiceAgreementStatus = $this->session->userdata('session_service_agreement_status');
            
            $data = array();
            //get rows count
            $conditions['search_service_agreement'] = $sessionServiceAgreement;
            $conditions['search_service_agreement_status'] = $sessionServiceAgreementStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewServiceAgreementData($conditions, HRM_SERVICE_AGREEMENT_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-service-agreement');
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
            
            $serviceAgreement = $this->DataModel->viewServiceAgreementData($conditions, HRM_SERVICE_AGREEMENT_TABLE);
            $data['countServiceAgreement'] = $this->DataModel->countServiceAgreementData($conditions, HRM_SERVICE_AGREEMENT_TABLE);
            $data['countServiceAgreementTrash'] = $this->DataModel->countServiceAgreementTrashData($conditions, HRM_SERVICE_AGREEMENT_TABLE);
            
            $data['viewServiceAgreement'] = array();
            if(is_array($serviceAgreement) || is_object($serviceAgreement)){
                foreach($serviceAgreement as $Row){
                    $dataArray = array();
                    $dataArray['service_agreement_id'] = $Row['service_agreement_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewServiceAgreement'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/serviceAgreement/service_agreement_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function serviceAgreementDetail($serviceAgreementID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SERVICE_AGREEMENT_ALIAS, "can_view");
            if($isPermission){
                $serviceAgreementID = urlDecodes($serviceAgreementID);
                if(ctype_digit($serviceAgreementID)){
            		$serviceAgreement = $this->DataModel->viewData(null, 'service_agreement_id = '.$serviceAgreementID, HRM_SERVICE_AGREEMENT_TABLE);
        	        $data['detailServiceAgreement'] = array();
                    if(is_array($serviceAgreement) || is_object($serviceAgreement)){
                        foreach($serviceAgreement as $Row){
                            $dataArray = array();
                            $dataArray['service_agreement_id'] = $Row['service_agreement_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['service_agreement_letter'] = $Row['service_agreement_letter'];
                            $dataArray['director_name'] = $Row['director_name'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailServiceAgreement'], $dataArray);
                        }
                    }
                    if($data['detailServiceAgreement'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/serviceAgreement/service_agreement_detail', $data);
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
    
    public function serviceAgreementPdf($serviceAgreementID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SERVICE_AGREEMENT_ALIAS, "can_view");
            if($isPermission){
                $serviceAgreementID = urlDecodes($serviceAgreementID);
                if(ctype_digit($serviceAgreementID)){
            		$data['pdfServiceAgreement'] = $this->DataModel->getData('service_agreement_id = '.$serviceAgreementID, HRM_SERVICE_AGREEMENT_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfServiceAgreement']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['pdfServiceAgreement'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/serviceAgreement/service_agreement_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Service Agreement'.'.pdf', array("Attachment"=>0));
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
    
    public function serviceAgreementEdit($serviceAgreementID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SERVICE_AGREEMENT_ALIAS, "can_edit");
            if($isPermission){
                $serviceAgreementID = urlDecodes($serviceAgreementID);
                if(ctype_digit($serviceAgreementID)){
                    $data['serviceAgreementData'] = $this->DataModel->getData('service_agreement_id = '.$serviceAgreementID, HRM_SERVICE_AGREEMENT_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['serviceAgreementData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);

                    if(!empty($data['serviceAgreementData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/serviceAgreement/service_agreement_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'director_name'=>$this->input->post('director_name'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('service_agreement_id = '.$serviceAgreementID, HRM_SERVICE_AGREEMENT_TABLE, $editData);
                        if($editDataEntry){
                            $sessionServiceAgreementViewPreviousUrl = $this->session->userdata('session_service_agreement_view_previous_url');
                            if(!empty($sessionServiceAgreementViewPreviousUrl)){
                                redirect($sessionServiceAgreementViewPreviousUrl);
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
    
    public function serviceAgreementTrash($serviceAgreementID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $serviceAgreementID = urlDecodes($serviceAgreementID);
                    if(ctype_digit($serviceAgreementID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('service_agreement_id = '.$serviceAgreementID, HRM_SERVICE_AGREEMENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_service_agreement_trash_success','Your service agreement has been trash successfully!');
                            $sessionServiceAgreementViewPreviousUrl = $this->session->userdata('session_service_agreement_view_previous_url');
                            if(!empty($sessionServiceAgreementViewPreviousUrl)){
                                redirect($sessionServiceAgreementViewPreviousUrl);
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
    
    public function serviceAgreementTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_service_agreement_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_service_agreement_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchServiceAgreementTrash = $this->input->post('search_service_agreement_trash');
                        $this->session->set_userdata('session_service_agreement_trash', $searchServiceAgreementTrash);
                    }
                    $sessionServiceAgreementTrash = $this->session->userdata('session_service_agreement_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_service_agreement_trash_status');
                        redirect('view-trash-service-agreement');
                    }
                        
                    $searchServiceAgreementTrashStatus = $this->input->post('search_service_agreement_trash_status');
                    if($searchServiceAgreementTrashStatus == 'active' or $searchServiceAgreementTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_service_agreement_trash_status', $searchServiceAgreementTrashStatus);
                    } else if($searchServiceAgreementTrashStatus === 'all'){
                        $this->session->unset_userdata('session_service_agreement_trash_status');
                    }
                    $sessionServiceAgreementTrashStatus = $this->session->userdata('session_service_agreement_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_service_agreement_trash'] = $sessionServiceAgreementTrash;
                    $conditions['search_service_agreement_trash_status'] = $sessionServiceAgreementTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewServiceAgreementTrashData($conditions, HRM_SERVICE_AGREEMENT_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-service-agreement');
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
                    
                    $serviceAgreement = $this->DataModel->viewServiceAgreementTrashData($conditions, HRM_SERVICE_AGREEMENT_TABLE);
                    $data['countServiceAgreement'] = $this->DataModel->countServiceAgreementTrashData($conditions, HRM_SERVICE_AGREEMENT_TABLE);

                    $data['viewServiceAgreement'] = array();
                    if(is_array($serviceAgreement) || is_object($serviceAgreement)){
                        foreach($serviceAgreement as $Row){
                            $dataArray = array();
                            $dataArray['service_agreement_id'] = $Row['service_agreement_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewServiceAgreement'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/serviceAgreement/service_agreement_trash_view', $data);
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
    
    public function serviceAgreementRestore($serviceAgreementID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $serviceAgreementID = urlDecodes($serviceAgreementID);
                    if(ctype_digit($serviceAgreementID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('service_agreement_id = '.$serviceAgreementID, HRM_SERVICE_AGREEMENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_service_agreement_restore_success','Your service agreement has been restore successfully!');
                            $sessionServiceAgreementTrashViewPreviousUrl = $this->session->userdata('session_service_agreement_trash_view_previous_url');
                            if(!empty($sessionServiceAgreementTrashViewPreviousUrl)){
                                redirect($sessionServiceAgreementTrashViewPreviousUrl);
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
    
    public function serviceAgreementDelete($serviceAgreementID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $serviceAgreementID = urlDecodes($serviceAgreementID);
                    if(ctype_digit($serviceAgreementID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('service_agreement_id = '.$serviceAgreementID, HRM_SERVICE_AGREEMENT_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_service_agreement_delete_success','Your service agreement has been delete successfully!');
                                    $sessionServiceAgreementTrashViewPreviousUrl = $this->session->userdata('session_service_agreement_trash_view_previous_url');
                                    if(!empty($sessionServiceAgreementTrashViewPreviousUrl)){
                                        redirect($sessionServiceAgreementTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_service_agreement_delete_error','Your password are not matched! Please enter correct password');
                                $sessionServiceAgreementTrashViewPreviousUrl = $this->session->userdata('session_service_agreement_trash_view_previous_url');
                                if(!empty($sessionServiceAgreementTrashViewPreviousUrl)){
                                    redirect($sessionServiceAgreementTrashViewPreviousUrl);
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
