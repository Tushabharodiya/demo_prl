<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {
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
	
    public function departmentNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(SOP_DEPARTMENT_ALIAS, "can_add");
            if($isPermission){
                $data['procedureData'] = $this->DataModel->viewData('sop_id '.'DESC', null, SOP_PROCEDURE_TABLE);
                $data['departmentData'] = $this->DataModel->viewData('department_id '.'DESC', null, DEPARTMENT_TABLE);
                $this->load->view('header');
                $this->load->view('sop/department/department_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $departmentArray = array();
                    if(!empty($_POST['department_permission'])){
                        foreach($_POST['department_permission'] as $departmentIDs){
                            array_push($departmentArray, $departmentIDs);
                        }
                    }
                    $departmentString = implode(',', $departmentArray);
                    $newData = array(
                        'department_id'=>$this->input->post('department_id'),
                        'department_permission'=>$departmentString,
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(SOP_DEPARTMENT_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-sop-department');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function departmentView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_sop_department_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_sop_department');
            }
            if(isset($_POST['submit_search'])){
                $searchSopDepartment = $this->input->post('search_sop_department');
                $this->session->set_userdata('session_sop_department', $searchSopDepartment);
            }
            $sessionSopDepartment = $this->session->userdata('session_sop_department');
            
            $data = array();
            //get rows count
            $conditions['search_sop_department'] = $sessionSopDepartment;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewSopDepartmentData($conditions, SOP_DEPARTMENT_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-sop-department');
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
            
            $department = $this->DataModel->viewSopDepartmentData($conditions, SOP_DEPARTMENT_TABLE);
            $data['countDepartment'] = $this->DataModel->countSopDepartmentData($conditions, SOP_DEPARTMENT_TABLE);
            $data['countDepartmentTrash'] = $this->DataModel->countSopDepartmentTrashData($conditions, SOP_DEPARTMENT_TABLE);
            
            $data['viewDepartment'] = array();
            if(is_array($department) || is_object($department)){
                foreach($department as $Row){
                    $dataArray = array();
                    $dataArray['unique_id'] = $Row['unique_id'];
                    $dataArray['department_id'] = $Row['department_id'];
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewDepartment'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('sop/department/department_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function departmentEdit($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(SOP_DEPARTMENT_ALIAS, "can_edit");
            if($isPermission){
                $uniqueID = urlDecodes($uniqueID);
                if(ctype_digit($uniqueID)){
                    $data['procedureData'] = $this->DataModel->viewData('sop_id '.'DESC', null, SOP_PROCEDURE_TABLE);
                    $data['viewDepartment'] = $this->DataModel->viewData('department_id '.'DESC', null, DEPARTMENT_TABLE);
                    $data['getDepartment'] = $this->DataModel->getData('unique_id = '.$uniqueID, SOP_DEPARTMENT_TABLE);
                    $departmentID = $data['getDepartment']['department_id'];
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                   
                    if(!empty($data['procedureData'])){
                        $this->load->view('header');
                        $this->load->view('sop/department/department_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $departmentArray = array();
                        if(!empty($_POST['department_permission'])){
                            foreach($_POST['department_permission'] as $departmentIDs){
                                array_push($departmentArray, $departmentIDs);
                            }
                        }
                        $departmentString = implode(',', $departmentArray);
                        $editData = array(
                            'department_id'=>$this->input->post('department_id'),
                            'department_permission'=>$departmentString
                        );
                        $editDataEntry = $this->DataModel->editData('unique_id = '.$uniqueID, SOP_DEPARTMENT_TABLE, $editData);
                        if($editDataEntry){
                            $sessionSopDepartmentViewPreviousUrl = $this->session->userdata('session_sop_department_view_previous_url');
                            if(!empty($sessionSopDepartmentViewPreviousUrl)){
                                redirect($sessionSopDepartmentViewPreviousUrl);
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
    
    public function departmentTrash($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $uniqueID = urlDecodes($uniqueID);
                    if(ctype_digit($uniqueID)){
                        $userData = $this->DataModel->getData('department_permission = '.$uniqueID, SOP_USER_TABLE);
                        if(!empty($userData)){
                            $this->session->set_userdata('session_sop_department_trash_sop_user', "You can't trash the department!");
                            $sessionSopDepartmentViewPreviousUrl = $this->session->userdata('session_sop_department_view_previous_url');
                            if(!empty($sessionSopDepartmentViewPreviousUrl)){
                                redirect($sessionSopDepartmentViewPreviousUrl);
                            }
                        } else {                            
                            $editData = array(
                                'trash_status'=>'true',
                            );
                            $editDataEntry = $this->DataModel->editData('unique_id = '.$uniqueID, SOP_DEPARTMENT_TABLE, $editData);
                            if($editDataEntry){
                                $this->session->set_userdata('session_sop_department_trash_success','Your department has been trash successfully!');
                                $sessionSopDepartmentViewPreviousUrl = $this->session->userdata('session_sop_department_view_previous_url');
                                if(!empty($sessionSopDepartmentViewPreviousUrl)){
                                    redirect($sessionSopDepartmentViewPreviousUrl);
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
    
    public function departmentTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_sop_department_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_sop_department_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchSopDepartmentTrash = $this->input->post('search_sop_department_trash');
                        $this->session->set_userdata('session_sop_department_trash', $searchSopDepartmentTrash);
                    }
                    $sessionSopDepartmentTrash = $this->session->userdata('session_sop_department_trash');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_sop_department_trash'] = $sessionSopDepartmentTrash;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewSopDepartmentTrashData($conditions, SOP_DEPARTMENT_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-sop-department');
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
                    
                    $department = $this->DataModel->viewSopDepartmentTrashData($conditions, SOP_DEPARTMENT_TABLE);
                    $data['countDepartment'] = $this->DataModel->countSopDepartmentTrashData($conditions, SOP_DEPARTMENT_TABLE);
        
                    $data['viewDepartment'] = array();
                    if(is_array($department) || is_object($department)){
                        foreach($department as $Row){
                            $dataArray = array();
                            $dataArray['unique_id'] = $Row['unique_id'];
                            $dataArray['department_id'] = $Row['department_id'];
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewDepartment'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('sop/department/department_trash_view', $data);
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
    
    public function departmentRestore($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $uniqueID = urlDecodes($uniqueID);
                    if(ctype_digit($uniqueID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('unique_id = '.$uniqueID, SOP_DEPARTMENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_sop_department_restore_success','Your department has been restore successfully!');
                            $sessionSopDepartmentTrashViewPreviousUrl = $this->session->userdata('session_sop_department_trash_view_previous_url');
                            if(!empty($sessionSopDepartmentTrashViewPreviousUrl)){
                                redirect($sessionSopDepartmentTrashViewPreviousUrl);
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
    
    public function departmentDelete($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $uniqueID = urlDecodes($uniqueID);
                    if(ctype_digit($uniqueID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('unique_id = '.$uniqueID, SOP_DEPARTMENT_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_sop_department_delete_success','Your department has been delete successfully!');
                                    $sessionSopDepartmentTrashViewPreviousUrl = $this->session->userdata('session_sop_department_trash_view_previous_url');
                                    if(!empty($sessionSopDepartmentTrashViewPreviousUrl)){
                                        redirect($sessionSopDepartmentTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_sop_department_delete_error','Your password are not matched! Please enter correct password');
                                $sessionSopDepartmentTrashViewPreviousUrl = $this->session->userdata('session_sop_department_trash_view_previous_url');
                                if(!empty($sessionSopDepartmentTrashViewPreviousUrl)){
                                    redirect($sessionSopDepartmentTrashViewPreviousUrl);
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