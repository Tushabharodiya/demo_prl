<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Declaration extends CI_Controller {
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
	
    public function declarationNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_HR_POLICY_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/declaration/declaration_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'declaration_letter'=>$data['onboardingLettersData']['employee_declaration_letter'],
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_DECLARATION_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-declaration');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function declarationView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_declaration_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_declaration');
            }
            if(isset($_POST['submit_search'])){
                $searchDeclaration = $this->input->post('search_declaration');
                $this->session->set_userdata('session_declaration', $searchDeclaration);
            }
            $sessionDeclaration = $this->session->userdata('session_declaration');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_declaration_type');
                $this->session->unset_userdata('session_declaration_status');
                redirect('view-declaration');
            }
            
            $searchDeclarationType = $this->input->post('search_declaration_type');
            if($searchDeclarationType == 'intern' or $searchDeclarationType == 'employee'){
                $this->session->set_userdata('session_declaration_type', $searchDeclarationType);
            } else if($searchDeclarationType === 'all'){
                $this->session->unset_userdata('session_declaration_type');
            }
            $sessionDeclarationType = $this->session->userdata('session_declaration_type');
            
            $searchDeclarationStatus = $this->input->post('search_declaration_status');
            if($searchDeclarationStatus == 'active' or $searchDeclarationStatus == 'inactive'){
                $this->session->set_userdata('session_declaration_status', $searchDeclarationStatus);
            } else if($searchDeclarationStatus === 'all'){
                $this->session->unset_userdata('session_declaration_status');
            }
            $sessionDeclarationStatus = $this->session->userdata('session_declaration_status');
            
            $data = array();
            //get rows count
            $conditions['search_declaration'] = $sessionDeclaration;
            $conditions['search_declaration_type'] = $sessionDeclarationType;
            $conditions['search_declaration_status'] = $sessionDeclarationStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewDeclarationData($conditions, HRM_DECLARATION_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-declaration');
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
            
            $declaration = $this->DataModel->viewDeclarationData($conditions, HRM_DECLARATION_TABLE);
            $data['countDeclaration'] = $this->DataModel->countDeclarationData($conditions, HRM_DECLARATION_TABLE);
            $data['countDeclarationTrash'] = $this->DataModel->countDeclarationTrashData($conditions, HRM_DECLARATION_TABLE);
            
            $data['viewDeclaration'] = array();
            if(is_array($declaration) || is_object($declaration)){
                foreach($declaration as $Row){
                    $dataArray = array();
                    $dataArray['declaration_id'] = $Row['declaration_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    array_push($data['viewDeclaration'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/declaration/declaration_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function declarationDetail($declarationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_DECLARATION_ALIAS, "can_view");
            if($isPermission){
                $declarationID = urlDecodes($declarationID);
                if(ctype_digit($declarationID)){
            		$declaration = $this->DataModel->viewData(null, 'declaration_id = '.$declarationID, HRM_DECLARATION_TABLE);
        	        $data['detailDeclaration'] = array();
                    if(is_array($declaration) || is_object($declaration)){
                        foreach($declaration as $Row){
                            $dataArray = array();
                            $dataArray['declaration_id'] = $Row['declaration_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['declaration_letter'] = $Row['declaration_letter'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['detailDeclaration'], $dataArray);
                        }
                    }
                    if($data['detailDeclaration'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/declaration/declaration_detail', $data);
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
    
    public function declarationPdf($declarationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_DECLARATION_ALIAS, "can_view");
            if($isPermission){
                $declarationID = urlDecodes($declarationID);
                if(ctype_digit($declarationID)){
            		$data['pdfDeclaration'] = $this->DataModel->getData('declaration_id = '.$declarationID, HRM_DECLARATION_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfDeclaration']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
        	        if($data['pdfDeclaration'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/declaration/declaration_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Declaration'.'.pdf', array("Attachment"=>0));
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
    
    public function declarationEdit($declarationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_DECLARATION_ALIAS, "can_edit");
            if($isPermission){
                $declarationID = urlDecodes($declarationID);
                if(ctype_digit($declarationID)){
                    $data['declarationData'] = $this->DataModel->getData('declaration_id = '.$declarationID, HRM_DECLARATION_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['declarationData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['declarationData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/declaration/declaration_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('declaration_id = '.$declarationID, HRM_DECLARATION_TABLE, $editData);
                        if($editDataEntry){
                            $sessionDeclarationViewPreviousUrl = $this->session->userdata('session_declaration_view_previous_url');
                            if(!empty($sessionDeclarationViewPreviousUrl)){
                                redirect($sessionDeclarationViewPreviousUrl);
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
    
    public function declarationTrash($declarationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $declarationID = urlDecodes($declarationID);
                    if(ctype_digit($declarationID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('declaration_id = '.$declarationID, HRM_DECLARATION_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_declaration_trash_success','Your declaration has been trash successfully!');
                            $sessionDeclarationViewPreviousUrl = $this->session->userdata('session_declaration_view_previous_url');
                            if(!empty($sessionDeclarationViewPreviousUrl)){
                                redirect($sessionDeclarationViewPreviousUrl);
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
    
    public function declarationTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
            
                    $this->session->set_userdata('session_declaration_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_declaration_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchDeclarationTrash = $this->input->post('search_declaration_trash');
                        $this->session->set_userdata('session_declaration_trash', $searchDeclarationTrash);
                    }
                    $sessionDeclarationTrash = $this->session->userdata('session_declaration_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_declaration_trash_type');
                        $this->session->unset_userdata('session_declaration_trash_status');
                        redirect('view-trash-declaration');
                    }
                    
                    $searchDeclarationTrashType = $this->input->post('search_declaration_trash_type');
                    if($searchDeclarationTrashType == 'intern' or $searchDeclarationTrashType == 'employee'){
                        $this->session->set_userdata('session_declaration_trash_type', $searchDeclarationTrashType);
                    } else if($searchDeclarationTrashType === 'all'){
                        $this->session->unset_userdata('session_declaration_trash_type');
                    }
                    $sessionDeclarationTrashType = $this->session->userdata('session_declaration_trash_type');
                    
                    $searchDeclarationTrashStatus = $this->input->post('search_declaration_trash_status');
                    if($searchDeclarationTrashStatus == 'active' or $searchDeclarationTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_declaration_trash_status', $searchDeclarationTrashStatus);
                    } else if($searchDeclarationTrashStatus === 'all'){
                        $this->session->unset_userdata('session_declaration_trash_status');
                    }
                    $sessionDeclarationTrashStatus = $this->session->userdata('session_declaration_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_declaration_trash'] = $sessionDeclarationTrash;
                    $conditions['search_declaration_trash_type'] = $sessionDeclarationTrashType;
                    $conditions['search_declaration_trash_status'] = $sessionDeclarationTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewDeclarationTrashData($conditions, HRM_DECLARATION_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-declaration');
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
                    
                    $declaration = $this->DataModel->viewDeclarationTrashData($conditions, HRM_DECLARATION_TABLE);
                    $data['countDeclaration'] = $this->DataModel->countDeclarationTrashData($conditions, HRM_DECLARATION_TABLE);

                    $data['viewDeclaration'] = array();
                    if(is_array($declaration) || is_object($declaration)){
                        foreach($declaration as $Row){
                            $dataArray = array();
                            $dataArray['declaration_id'] = $Row['declaration_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['viewDeclaration'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/declaration/declaration_trash_view', $data);
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
    
    public function declarationRestore($declarationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $declarationID = urlDecodes($declarationID);
                    if(ctype_digit($declarationID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('declaration_id = '.$declarationID, HRM_DECLARATION_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_declaration_restore_success','Your declaration has been restore successfully!');
                            $sessionDeclarationTrashViewPreviousUrl = $this->session->userdata('session_declaration_trash_view_previous_url');
                            if(!empty($sessionDeclarationTrashViewPreviousUrl)){
                                redirect($sessionDeclarationTrashViewPreviousUrl);
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
    
    public function declarationDelete($declarationID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $declarationID = urlDecodes($declarationID);
                    if(ctype_digit($declarationID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('declaration_id = '.$declarationID, HRM_DECLARATION_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_declaration_delete_success','Your invoice has been delete successfully!');
                                    $sessionDeclarationTrashViewPreviousUrl = $this->session->userdata('session_declaration_trash_view_previous_url');
                                    if(!empty($sessionDeclarationTrashViewPreviousUrl)){
                                        redirect($sessionDeclarationTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_declaration_delete_error','Your password are not matched! Please enter correct password');
                                $sessionDeclarationTrashViewPreviousUrl = $this->session->userdata('session_declaration_trash_view_previous_url');
                                if(!empty($sessionDeclarationTrashViewPreviousUrl)){
                                    redirect($sessionDeclarationTrashViewPreviousUrl);
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
