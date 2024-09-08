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
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $data['permissionData'] = $this->DataModel->viewData(null, null, PERMISSION_MASTER_TABLE);
                    
                    $permissionAliasData = $this->DataModel->viewData('alias_id '.'ASC', null, PERMISSION_ALIAS_TABLE);
                        
                    $data['viewPermissionAlias'] = array();
                    if (is_array($permissionAliasData) || is_object($permissionAliasData)){
                        foreach($permissionAliasData as $Row){
                            $dataArray = array();
                            $dataArray['alias_id'] = $Row['alias_id'];
                            $dataArray['alias_name'] = $Row['alias_name'];
                            $dataArray['permissionData'] = $this->DataModel->viewData(null, 'alias_id = '.$dataArray['alias_id'], PERMISSION_MASTER_TABLE);
                            array_push($data['viewPermissionAlias'], $dataArray);
                        }
                    }

		    	    $this->load->view('header');
		    		$this->load->view('master/department/department_new', $data);
		    		$this->load->view('footer');
				    if($this->input->post('submit')){
						$newData = array(
				    		'department_name'=>$this->input->post('department_name'),
				    	    'department_status'=>'Publish',
				    	    'trash_status'=>'false',
						);
		    		    $departmentID = $this->DataModel->insertData(DEPARTMENT_TABLE, $newData);
	        		    if($departmentID){
	        		        if(isset($_POST['department_permission'])){
    	        		        foreach($_POST['department_permission'] as $permissionID){
    				                $permissionData = $this->DataModel->getData('permission_id = '.$permissionID, PERMISSION_MASTER_TABLE);
    				                $newData = array(
    				                    'department_id'=>$departmentID,
                                        'permission_id'=>$permissionData['permission_id'],
            				    		'permission_name'=>$permissionData['permission_name'],
            				    		'permission_alias'=>$permissionData['permission_alias'],
            				    	    'can_add'=>$permissionData['can_add'],
            				    	    'can_view'=>$permissionData['can_view'],
            				    	    'can_edit'=>$permissionData['can_edit'],
            				    	    'can_delete'=>$permissionData['can_delete'],
            				    	    'permission_status'=>$permissionData['permission_status'],
            						);
    				                $newDataEntry = $this->DataModel->insertData(PERMISSION_DEPARTMENT_TABLE, $newData);
    				                if($newDataEntry){
        			                    redirect('view-department'); 
        			                }
    				            }
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
            redirect('logout');
        }
	}

    public function departmentView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_department_view_previous_url', current_url());
                    
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_department');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchDepartment = $this->input->post('search_department');
                        $this->session->set_userdata('session_department', $searchDepartment);
                    }
                    $sessionDepartment = $this->session->userdata('session_department');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_department_status');
                        redirect('view-department');
                    }
                        
                    $searchDepartmentStatus = $this->input->post('search_department_status');
                    if($searchDepartmentStatus === 'publish' or $searchDepartmentStatus == 'unpublish'){
                        $this->session->set_userdata('session_department_status', $searchDepartmentStatus);
                    } else if($searchDepartmentStatus === 'all'){
                        $this->session->unset_userdata('session_department_status');
                    }
                    $sessionDepartmentStatus = $this->session->userdata('session_department_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_department'] = $sessionDepartment;
                    $conditions['search_department_status'] = $sessionDepartmentStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewDepartmentData($conditions, DEPARTMENT_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-department');
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
                    
                    $department = $this->DataModel->viewDepartmentData($conditions, DEPARTMENT_TABLE);
                    $data['countDepartment'] = $this->DataModel->countDepartmentData($conditions, DEPARTMENT_TABLE);
                    $data['countDepartmentTrash'] = $this->DataModel->countDepartmentTrashData($conditions, DEPARTMENT_TABLE);
                    
                    $data['viewDepartment'] = array();
                    if(is_array($department) || is_object($department)){
                        foreach($department as $Row){
                            $dataArray = array();
                            $dataArray['department_id'] = $Row['department_id'];
                            $dataArray['department_name'] = $Row['department_name'];
                            $dataArray['department_status'] = $Row['department_status'];
                            array_push($data['viewDepartment'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/department/department_view', $data);
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

    public function departmentEdit($departmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $departmentID = urlDecodes($departmentID);
                    if(ctype_digit($departmentID)){
                        $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);

                        if(!empty($data['departmentData'])){
                            $this->load->view('header');
                            $this->load->view('master/department/department_edit', $data);
                            $this->load->view('footer');
                        } else {
                            redirect('error');
                        }
                        if($this->input->post('submit')){
                            $editData = array(
                                'department_name'=>$this->input->post('department_name'),
                                'department_status'=>$this->input->post('department_status')
                            );
                            $editDataEntry = $this->DataModel->editData('department_id = '.$departmentID, DEPARTMENT_TABLE, $editData);
                            if($editDataEntry){
                                $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
                                if(!empty($sessionDepartmentViewPreviousUrl)){
                                    redirect($sessionDepartmentViewPreviousUrl);
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
    
    public function departmentTrash($departmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $departmentID = urlDecodes($departmentID);
                    if(ctype_digit($departmentID)){
                        $employeeData = $this->DataModel->getData('department_id = '.$departmentID, HRM_EMPLOYEE_TABLE);
                        $sopDepartmentData = $this->DataModel->getData('department_id = '.$departmentID, SOP_DEPARTMENT_TABLE);
                        $sopUserData = $this->DataModel->getData('department_id = '.$departmentID, SOP_USER_TABLE);
                        $departmentPermissionData = $this->DataModel->getData('department_id = '.$departmentID, PERMISSION_DEPARTMENT_TABLE);
                        $userPermissionData = $this->DataModel->getData('department_id = '.$departmentID, PERMISSION_USER_TABLE);
                        $userMasterData = $this->DataModel->getData('department_id = '.$departmentID, MASTER_USER_TABLE);
                        
                        if(!empty($employeeData)){
                            $this->session->set_userdata('session_department_trash_employee', "You can't trash the department!");
                            $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
                            if(!empty($sessionDepartmentViewPreviousUrl)){
                                redirect($sessionDepartmentViewPreviousUrl);
                            }
                        } else if(!empty($sopDepartmentData)){
                            $this->session->set_userdata('session_department_trash_sop_department', "You can't trash the department!");
                            $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
                            if(!empty($sessionDepartmentViewPreviousUrl)){
                                redirect($sessionDepartmentViewPreviousUrl);
                            }
                        } else if(!empty($sopUserData)){
                            $this->session->set_userdata('session_department_trash_sop_user', "You can't trash the department!");
                            $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
                            if(!empty($sessionDepartmentViewPreviousUrl)){
                                redirect($sessionDepartmentViewPreviousUrl);
                            }
                        } else if(!empty($departmentPermissionData)){
                            $url = 'department-rights/' . urlEncodes($departmentID);
                            $this->session->set_userdata('session_department_trash_department_permission', "You can't trash the department! Please delete <a href='" . base_url($url) . "' class='alert-link'>department rights</a> before trashing department");
                            $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
                            if(!empty($sessionDepartmentViewPreviousUrl)){
                                redirect($sessionDepartmentViewPreviousUrl);
                            }
                        } else if(!empty($userPermissionData)){
                            $url = 'user-rights/' . urlEncodes($departmentID);
                            $this->session->set_userdata('session_department_trash_user_permission', "You can't trash the department! Please delete <a href='" . base_url($url) . "' class='alert-link'>user rights</a> before trashing department");
                            $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
                            if(!empty($sessionDepartmentViewPreviousUrl)){
                                redirect($sessionDepartmentViewPreviousUrl);
                            }
                        } else if(!empty($userMasterData)){
                            $this->session->set_userdata('session_department_trash_user_master', "You can't trash the department!");
                            $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
                            if(!empty($sessionDepartmentViewPreviousUrl)){
                                redirect($sessionDepartmentViewPreviousUrl);
                            }
                        } else {                            
                            $editData = array(
                                'trash_status'=>'true',
                            );
                            $editDataEntry = $this->DataModel->editData('department_id = '.$departmentID, DEPARTMENT_TABLE, $editData);
                            if($editDataEntry){
                                $this->session->set_userdata('session_department_trash_success','Your department has been trash successfully!');
                                $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
                                if(!empty($sessionDepartmentViewPreviousUrl)){
                                    redirect($sessionDepartmentViewPreviousUrl);
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
                    
                    $this->session->set_userdata('session_department_trash_view_previous_url', current_url());
                    
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_department_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchDepartmentTrash = $this->input->post('search_department_trash');
                        $this->session->set_userdata('session_department_trash', $searchDepartmentTrash);
                    }
                    $sessionDepartmentTrash = $this->session->userdata('session_department_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_department_trash_status');
                        redirect('view-trash-department');
                    }
                        
                    $searchDepartmentTrashStatus = $this->input->post('search_department_trash_status');
                    if($searchDepartmentTrashStatus === 'publish' or $searchDepartmentTrashStatus == 'unpublish'){
                        $this->session->set_userdata('session_department_trash_status', $searchDepartmentTrashStatus);
                    } else if($searchDepartmentTrashStatus === 'all'){
                        $this->session->unset_userdata('session_department_trash_status');
                    }
                    $sessionDepartmentTrashStatus = $this->session->userdata('session_department_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_department_trash'] = $sessionDepartmentTrash;
                    $conditions['search_department_trash_status'] = $sessionDepartmentTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewDepartmentTrashData($conditions, DEPARTMENT_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-department');
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
                    
                    $department = $this->DataModel->viewDepartmentTrashData($conditions, DEPARTMENT_TABLE);
                    $data['countDepartment'] = $this->DataModel->countDepartmentTrashData($conditions, DEPARTMENT_TABLE);

                    $data['viewDepartment'] = array();
                    if(is_array($department) || is_object($department)){
                        foreach($department as $Row){
                            $dataArray = array();
                            $dataArray['department_id'] = $Row['department_id'];
                            $dataArray['department_name'] = $Row['department_name'];
                            $dataArray['department_status'] = $Row['department_status'];
                            array_push($data['viewDepartment'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/department/department_trash_view', $data);
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
    
    public function departmentRestore($departmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $departmentID = urlDecodes($departmentID);
                    if(ctype_digit($departmentID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('department_id = '.$departmentID, DEPARTMENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_department_restore_success','Your department has been restore successfully!');
                            $sessionDepartmentTrashViewPreviousUrl = $this->session->userdata('session_department_trash_view_previous_url');
                            if(!empty($sessionDepartmentTrashViewPreviousUrl)){
                                redirect($sessionDepartmentTrashViewPreviousUrl);
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
    
    public function departmentDelete($departmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $departmentID = urlDecodes($departmentID);
                    if(ctype_digit($departmentID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_department_delete_success','Your department has been delete successfully!');
                                    $sessionDepartmentTrashViewPreviousUrl = $this->session->userdata('session_department_trash_view_previous_url');
                                    if(!empty($sessionDepartmentTrashViewPreviousUrl)){
                                        redirect($sessionDepartmentTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_department_delete_error','Your password are not matched! Please enter correct password');
                                $sessionDepartmentTrashViewPreviousUrl = $this->session->userdata('session_department_trash_view_previous_url');
                                if(!empty($sessionDepartmentTrashViewPreviousUrl)){
                                    redirect($sessionDepartmentTrashViewPreviousUrl);
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
