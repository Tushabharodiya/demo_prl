<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
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
	
	public function userNew(){
	    $isLogin = checkAuth();
	    if($isLogin == "True"){
    	    if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){ 
        			$data['departmentData'] = $this->DataModel->viewData('department_id '.'DESC', null, DEPARTMENT_TABLE);
        			$data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
        			$this->load->view('header');
        			$this->load->view('master/user/user_new', $data);  
        			$this->load->view('footer');
            		if($this->input->post('submit')){
                        $departmentID = $this->input->post('department_permission');
                        $userRole = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                        $employeeID = $this->input->post('employee_id');
                        $userName = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                		$newData = array(
                		    'employee_id'=>$employeeID,
                			'department_id'=>$departmentID,
                    		'user_name'=>$userName['employee_first_name']. ' '.$userName['employee_last_name'],
                    		'user_email'=>$this->input->post('user_email'),
                    	    'user_password'=>md5($this->input->post('user_password')),
                    	    'user_role'=>$userRole['department_name'],
                    	    'user_key'=>uniqueKey(),
                    	    'user_status'=>$this->input->post('user_status'),
                    	    'is_login'=>'-',
                    	    'trash_status'=>'false',
                		);
	                	$newUserID = $this->DataModel->insertData(MASTER_USER_TABLE, $newData);
	                	
                        $departmentPermission = $this->DataModel->viewData(null, 'department_id = '.$departmentID, PERMISSION_DEPARTMENT_TABLE);
                        foreach($departmentPermission as $permissionRow){
                            $newData = array(
                                'user_id'=>$newUserID,
                                'department_id'=>$departmentID,
                                'permission_id'=>$permissionRow['permission_id'],
                                'permission_name'=>$permissionRow['permission_name'],
                                'permission_alias'=>$permissionRow['permission_alias'],
                                'can_add'=>$permissionRow['can_add'],
                                'can_view'=>$permissionRow['can_view'],
                                'can_edit'=>$permissionRow['can_edit'],
                                'can_delete'=>$permissionRow['can_delete'],
                                'permission_status'=>$permissionRow['permission_status']
                            );
                            $newDataEntry = $this->DataModel->insertData(PERMISSION_USER_TABLE, $newData);
                        }
            			redirect('view-user');
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
	
	public function userView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_user_view_previous_url', current_url());

                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_user');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchUser = $this->input->post('search_user');
                        $this->session->set_userdata('session_user', $searchUser);
                    }
                    $sessionUser = $this->session->userdata('session_user');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_user_login');
                        $this->session->unset_userdata('session_user_status');
                        redirect('view-user');
                    }
                    
                    $searchUserLogin = $this->input->post('search_user_login');
                    if($searchUserLogin === 'true' or $searchUserLogin == 'false'){
                        $this->session->set_userdata('session_user_login', $searchUserLogin);
                    } else if($searchUserLogin === 'all'){
                        $this->session->unset_userdata('session_user_login');
                    }
                    $sessionUserLogin = $this->session->userdata('session_user_login');
                    
                    $searchUserStatus = $this->input->post('search_user_status');
                    if($searchUserStatus === 'active' or $searchUserStatus == 'blocked'){
                        $this->session->set_userdata('session_user_status', $searchUserStatus);
                    } else if($searchUserStatus === 'all'){
                        $this->session->unset_userdata('session_user_status');
                    }
                    $sessionUserStatus = $this->session->userdata('session_user_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_user'] = $sessionUser;
                    $conditions['search_user_login'] = $sessionUserLogin;
                    $conditions['search_user_status'] = $sessionUserStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewUserData($conditions, MASTER_USER_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-user');
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
                    
                    $user = $this->DataModel->viewUserData($conditions, MASTER_USER_TABLE);
                    $data['countUser'] = $this->DataModel->countUserData($conditions, MASTER_USER_TABLE);
                    $data['countUserTrash'] = $this->DataModel->countUserTrashData($conditions, MASTER_USER_TABLE);
                    
                    $data['viewUser'] = array();
                    if(is_array($user) || is_object($user)){
                        foreach($user as $Row){
                            $dataArray = array();
                            $dataArray['user_id'] = $Row['user_id'];
                            $dataArray['department_id'] = $Row['department_id'];
                            $dataArray['user_name'] = $Row['user_name'];
                            $dataArray['user_email'] = $Row['user_email'];
                            $dataArray['is_login'] = $Row['is_login'];
                            $dataArray['user_status'] = $Row['user_status'];
                            $departmentData = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                            if($departmentData){
                                $dataArray['departmentName'] = $departmentData['department_name'];
                            } else {
                                $dataArray['departmentName'] = "-";
                            }
                            array_push($data['viewUser'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/user/user_view', $data);
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
    
    public function departmentUserView($departmentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $departmentID = urlDecodes($departmentID);
                    if(ctype_digit($departmentID)){
                        
                        $this->session->set_userdata('session_user_view_previous_url', current_url());
                        
                        if(isset($_POST['reset_search'])){
                            $this->session->unset_userdata('session_department_user');
                        }
                        if(isset($_POST['submit_search'])){
                            $searchDepartmentUser = $this->input->post('search_department_user');
                            $this->session->set_userdata('session_department_user', $searchDepartmentUser);
                        }
                        $sessionDepartmentUser = $this->session->userdata('session_department_user');
                        
                        if(isset($_POST['reset_filter'])){
                            $this->session->unset_userdata('session_department_user_status');
                            redirect('view-department-user/'.urlEncodes($departmentID));
                        }
                            
                        $searchDepartmentUserStatus = $this->input->post('search_department_user_status');
                        if($searchDepartmentUserStatus === 'active' or $searchDepartmentUserStatus == 'blocked'){
                            $this->session->set_userdata('session_department_user_status', $searchDepartmentUserStatus);
                        } else if($searchDepartmentUserStatus === 'all'){
                            $this->session->unset_userdata('session_department_user_status');
                        }
                        $sessionDepartmentUserStatus = $this->session->userdata('session_department_user_status');
                        
                        $data = array();
                        //get rows count
                        $conditions['search_department_user'] = $sessionDepartmentUser;
                        $conditions['search_department_user_status'] = $sessionDepartmentUserStatus;
                        $conditions['returnType'] = 'count';
                        
                        $totalRec = $this->DataModel->viewDepartmentUserData($conditions, $departmentID, MASTER_USER_TABLE);
                
                        //pagination config
                        $config['base_url']    = site_url('view-department-user/'.urlEncodes($departmentID));
                        $config['uri_segment'] = 3;
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
                        $page = $this->uri->segment(3);
                        $offset = !$page?0:$page;
                        
                        //get rows
                        $conditions['returnType'] = '';
                        $conditions['start'] = $offset;
                        $conditions['limit'] = 10;
                        
                        $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                        
                        $departmentUser = $this->DataModel->viewDepartmentUserData($conditions, $departmentID, MASTER_USER_TABLE);
                        $data['countDepartmentUser'] = $this->DataModel->countDepartmentUserData($conditions, $departmentID, MASTER_USER_TABLE);
                        
                        $data['viewDepartmentUser'] = array();
                        if(is_array($departmentUser) || is_object($departmentUser)){
                            foreach($departmentUser as $Row){
                                $dataArray = array();
                                $dataArray['user_id'] = $Row['user_id'];
                                $dataArray['user_name'] = $Row['user_name'];
                                $dataArray['user_email'] = $Row['user_email'];
                                $dataArray['user_role'] = $Row['user_role'];
                                $dataArray['user_status'] = $Row['user_status'];
                                array_push($data['viewDepartmentUser'], $dataArray);
                            }
                        }
                        $this->load->view('header');
                        $this->load->view('master/user/department_user_view', $data);
                        $this->load->view('footer');
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

	public function userEdit($userID = 0){
	    $isLogin = checkAuth();
	    if($isLogin == "True"){
    	    if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){ 
            	    $userID = urlDecodes($userID);
            	    if(ctype_digit($userID)){
                		$userMasterData = $this->DataModel->getData('user_id = '.$userID, MASTER_USER_TABLE);
                		
                		$data = array('userMasterData'=>$userMasterData);
                		
                		$data['viewDepartment'] = $this->DataModel->viewData('department_id '.'DESC', null, DEPARTMENT_TABLE);
                        $departmentID = $userMasterData['department_id'];
                        $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                        
                        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee="selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                        $employeeID = $userMasterData['employee_id'];
                        $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                        
            			if($data['userMasterData'] != null){
            			    $this->load->view('header');
                    		$this->load->view('master/user/user_edit', $data);
                    		$this->load->view('footer');
            			} else {
            				redirect('error');
            			}
                		if($this->input->post('submit')){
                			if($this->input->post('user_password') == ""){
                		        $userPassword = $userMasterData['user_password'];
                		    } else {
                		        $userPassword = md5($this->input->post('user_password'));
                		    }
                			$departmentID = $this->input->post('department_id');
                        	$userRole = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                        	$employeeID = $this->input->post('employee_id');
                            $userName = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                		    $editData = array(
                		        'employee_id'=>$employeeID,
                        		'department_id'=>$departmentID,
                    		    'user_name'=>$userName['employee_first_name']. ' '.$userName['employee_last_name'],
                        		'user_email'=>$this->input->post('user_email'),
                        		'user_password'=>$userPassword,
                        	    'user_role'=>$userRole['department_name'],
                        	    'user_status'=>$this->input->post('user_status')
                			);
                			$editDataEntry = $this->DataModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editData);
            				if($editDataEntry){
            					$sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
                                if(!empty($sessionUserViewPreviousUrl)){
                                    redirect($sessionUserViewPreviousUrl);
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

    public function userProfile(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $this->load->view('header');
            $this->load->view('master/user/user_profile');
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function userTrash($userID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $userID = urlDecodes($userID);
                    if(ctype_digit($userID)){
                        $sopUserData = $this->DataModel->getData('user_id = '.$userID, SOP_USER_TABLE);
                        $attendanceData = $this->DataModel->getData('user_id = '.$userID, HRM_ATTENDANCE_TABLE);
                        $leaveData = $this->DataModel->getData('user_id = '.$userID, HRM_LEAVE_TABLE);
                        $reportingData = $this->DataModel->getData('user_id = '.$userID, HRM_REPORTING_TABLE);
                        $userPermissionData = $this->DataModel->getData('user_id = '.$userID, PERMISSION_USER_TABLE);
                        $loginHistoryData = $this->DataModel->getData('user_id = '.$userID, LOGIN_DATA_TABLE);

                        if(!empty($sopUserData)){
                            $this->session->set_userdata('session_user_trash_sop_user', "You can't trash the user!");
                            $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
                            if(!empty($sessionUserViewPreviousUrl)){
                                redirect($sessionUserViewPreviousUrl);
                            }
                        } else if(!empty($attendanceData)){
                            $this->session->set_userdata('session_user_trash_attendance_admin', "You can't trash the user!");
                            $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
                            if(!empty($sessionUserViewPreviousUrl)){
                                redirect($sessionUserViewPreviousUrl);
                            }
                        } else if(!empty($leaveData)){
                            $this->session->set_userdata('session_user_trash_leave_admin', "You can't trash the user!");
                            $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
                            if(!empty($sessionUserViewPreviousUrl)){
                                redirect($sessionUserViewPreviousUrl);
                            }
                        } else if(!empty($reportingData)){
                            $this->session->set_userdata('session_user_trash_reporting_admin', "You can't trash the user!");
                            $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
                            if(!empty($sessionUserViewPreviousUrl)){
                                redirect($sessionUserViewPreviousUrl);
                            }
                        } else if(!empty($userPermissionData)){
                            $url = 'user-rights/' . urlEncodes($userID);
                            $this->session->set_userdata('session_user_trash_user_permission', "You can't trash the user! Please delete <a href='" . base_url($url) . "' class='alert-link'>user rights</a> before trashing user");
                            $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
                            if(!empty($sessionUserViewPreviousUrl)){
                                redirect($sessionUserViewPreviousUrl);
                            }
                        } else if(!empty($loginHistoryData)){
                            $this->session->set_userdata('session_user_trash_login_history', "You can't trash the user!");
                            $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
                            if(!empty($sessionUserViewPreviousUrl)){
                                redirect($sessionUserViewPreviousUrl);
                            }
                        } else {                            
                            $editData = array(
                                'trash_status'=>'true',
                            );
                            $editDataEntry = $this->DataModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editData);
                            if($editDataEntry){
                                $this->session->set_userdata('session_user_trash_success','Your user has been trash successfully!');
                                $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
                                if(!empty($sessionUserViewPreviousUrl)){
                                    redirect($sessionUserViewPreviousUrl);
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
    
    public function userTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_user_trash_view_previous_url', current_url());

                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_user_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchUserTrash = $this->input->post('search_user_trash');
                        $this->session->set_userdata('session_user_trash', $searchUserTrash);
                    }
                    $sessionUserTrash = $this->session->userdata('session_user_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_user_trash_login');
                        $this->session->unset_userdata('session_user_trash_status');
                        redirect('view-trash-user');
                    }
                    
                    $searchUserTrashLogin = $this->input->post('search_user_trash_login');
                    if($searchUserTrashLogin === 'true' or $searchUserTrashLogin == 'false'){
                        $this->session->set_userdata('session_user_trash_login', $searchUserTrashLogin);
                    } else if($searchUserTrashLogin === 'all'){
                        $this->session->unset_userdata('session_user_trash_login');
                    }
                    $sessionUserTrashLogin = $this->session->userdata('session_user_trash_login');
                    
                    $searchUserTrashStatus = $this->input->post('search_user_trash_status');
                    if($searchUserTrashStatus === 'active' or $searchUserTrashStatus == 'blocked'){
                        $this->session->set_userdata('session_user_trash_status', $searchUserTrashStatus);
                    } else if($searchUserTrashStatus === 'all'){
                        $this->session->unset_userdata('session_user_trash_status');
                    }
                    $sessionUserTrashStatus = $this->session->userdata('session_user_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_user_trash'] = $sessionUserTrash;
                    $conditions['search_user_trash_login'] = $sessionUserTrashLogin;
                    $conditions['search_user_trash_status'] = $sessionUserTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewUserTrashData($conditions, MASTER_USER_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-user');
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
                    
                    $user = $this->DataModel->viewUserTrashData($conditions, MASTER_USER_TABLE);
                    $data['countUser'] = $this->DataModel->countUserTrashData($conditions, MASTER_USER_TABLE);
                    
                    $data['viewUser'] = array();
                    if(is_array($user) || is_object($user)){
                        foreach($user as $Row){
                            $dataArray = array();
                            $dataArray['user_id'] = $Row['user_id'];
                            $dataArray['department_id'] = $Row['department_id'];
                            $dataArray['user_name'] = $Row['user_name'];
                            $dataArray['user_email'] = $Row['user_email'];
                            $dataArray['is_login'] = $Row['is_login'];
                            $dataArray['user_status'] = $Row['user_status'];
                            $departmentData = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                            if($departmentData){
                                $dataArray['departmentName'] = $departmentData['department_name'];
                            } else {
                                $dataArray['departmentName'] = "-";
                            }
                            array_push($data['viewUser'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/user/user_trash_view', $data);
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
    
    public function userRestore($userID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $userID = urlDecodes($userID);
                    if(ctype_digit($userID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_user_restore_success','Your user has been restore successfully!');
                            $sessionUserTrashViewPreviousUrl = $this->session->userdata('session_user_trash_view_previous_url');
                            if(!empty($sessionUserTrashViewPreviousUrl)){
                                redirect($sessionUserTrashViewPreviousUrl);
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
    
    public function userDelete($userID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $userID = urlDecodes($userID);
                    if(ctype_digit($userID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('user_id = '.$userID, MASTER_USER_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_user_delete_success','Your user has been delete successfully!');
                                    $sessionUserTrashViewPreviousUrl = $this->session->userdata('session_user_trash_view_previous_url');
                                    if(!empty($sessionUserTrashViewPreviousUrl)){
                                        redirect($sessionUserTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_user_delete_error','Your password are not matched! Please enter correct password');
                                $sessionUserTrashViewPreviousUrl = $this->session->userdata('session_user_trash_view_previous_url');
                                if(!empty($sessionUserTrashViewPreviousUrl)){
                                    redirect($sessionUserTrashViewPreviousUrl);
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
    
    public function loginHistory(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_login_history_view_previous_url', current_url());
                    $this->session->set_userdata('session_login_view_previous_url', current_url());

                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_login_history');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchLoginHistory = $this->input->post('search_login_history');
                        $this->session->set_userdata('session_login_history', $searchLoginHistory);
                    }
                    $sessionLoginHistory = $this->session->userdata('session_login_history');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_login_history'] = $sessionLoginHistory;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewLoginHistoryData($conditions, LOGIN_DATA_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('login-history');
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
                    
                    $loginHistory = $this->DataModel->viewLoginHistoryData($conditions, LOGIN_DATA_TABLE);
                    $data['countLoginHistory'] = $this->DataModel->countLoginHistoryData($conditions, LOGIN_DATA_TABLE);
                    $data['countLoginHistoryTrash'] = $this->DataModel->countLoginHistoryTrashData($conditions, LOGIN_DATA_TABLE);
                    
                    $data['viewLoginHistory'] = array();
                    if(is_array($loginHistory) || is_object($loginHistory)){
                        foreach($loginHistory as $Row){
                            $dataArray = array();
                            $dataArray['unique_id'] = $Row['unique_id'];
                            $dataArray['user_name'] = $Row['user_name'];
                            $dataArray['user_email'] = $Row['user_email'];
                            $dataArray['user_login'] = $Row['user_login'];
                            $dataArray['user_logout'] = $Row['user_logout'];
                            array_push($data['viewLoginHistory'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/user/login_history', $data);
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
    
    public function loginDescription($uniqueID = 0){
 	    $isLogin = checkAuth();
	    if($isLogin == "True"){
	        if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
             	    $uniqueID = urlDecodes($uniqueID);
            	    if(ctype_digit($uniqueID)){
            	        $data['loginDescription'] = $this->DataModel->getData('unique_id = '.$uniqueID, LOGIN_DATA_TABLE);
            	        if($data['loginDescription'] != null){
                	        $this->load->view('header');
                    		$this->load->view('master/user/login_description', $data);
                    		$this->load->view('footer');
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
                redirect('error');
            }
	    } else {
	        redirect('logout');
	    }
	}
	
	public function loginActivity($userID = 0){
 	    $isLogin = checkAuth();
	    if($isLogin == "True"){
	        if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
             	    $userID = urlDecodes($userID);
            	    if(ctype_digit($userID)){
            	        
            	        $this->session->set_userdata('session_login_view_previous_url', current_url());
            	        
            	        if(isset($_POST['reset_search'])){
                            $this->session->unset_userdata('session_login_activity');
                        }
                        if(isset($_POST['submit_search'])){
                            $searchLoginActivity = $this->input->post('search_login_activity');
                            $this->session->set_userdata('session_login_activity', $searchLoginActivity);
                        }
                        $sessionLoginActivity = $this->session->userdata('session_login_activity');
                        
                        $data = array();
                        //get rows count
                        $conditions['search_login_activity'] = $sessionLoginActivity;
                        $conditions['returnType'] = 'count';
                        
                        $totalRec = $this->DataModel->viewLoginActivityData($conditions, $userID, LOGIN_DATA_TABLE);
                
                        //pagination config
                        $config['base_url']    = site_url('login-activity/'.urlEncodes($userID));
                        $config['uri_segment'] = 3;
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
                        $page = $this->uri->segment(3);
                        $offset = !$page?0:$page;
                        
                        //get rows
                        $conditions['returnType'] = '';
                        $conditions['start'] = $offset;
                        $conditions['limit'] = 10;
                        
                        $loginActivity = $this->DataModel->viewLoginActivityData($conditions, $userID, LOGIN_DATA_TABLE);
                        $data['countLoginActivity'] = $this->DataModel->countLoginActivityData($conditions, $userID, LOGIN_DATA_TABLE);
                        
                        $data['viewLoginActivity'] = array();
                        if(is_array($loginActivity) || is_object($loginActivity)){
                            foreach($loginActivity as $Row){
                                $dataArray = array();
                                $dataArray['unique_id'] = $Row['unique_id'];
                                $dataArray['user_name'] = $Row['user_name'];
                                $dataArray['user_email'] = $Row['user_email'];
                                $dataArray['user_login'] = $Row['user_login'];
                                $dataArray['user_logout'] = $Row['user_logout'];
                                array_push($data['viewLoginActivity'], $dataArray);
                            }
                        }
                        $this->load->view('header');
                        $this->load->view('master/user/login_activity', $data);
                        $this->load->view('footer');
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
	
	public function loginHistoryTrash($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $uniqueID = urlDecodes($uniqueID);
                    if(ctype_digit($uniqueID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('unique_id = '.$uniqueID, LOGIN_DATA_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_login_history_trash_success','Your login history has been trash successfully!');
                            $sessionLoginHistoryViewPreviousUrl = $this->session->userdata('session_login_history_view_previous_url');
                            if(!empty($sessionLoginHistoryViewPreviousUrl)){
                                redirect($sessionLoginHistoryViewPreviousUrl);
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
    
    public function loginHistoryTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_login_history_trash_view_previous_url', current_url());
                    
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_login_history_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchLoginHistoryTrash = $this->input->post('search_login_history_trash');
                        $this->session->set_userdata('session_login_history_trash', $searchLoginHistoryTrash);
                    }
                    $sessionLoginHistoryTrash = $this->session->userdata('session_login_history_trash');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_login_history_trash'] = $sessionLoginHistoryTrash;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewLoginHistoryTrashData($conditions, LOGIN_DATA_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-login-history');
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
                    
                    $loginHistory = $this->DataModel->viewLoginHistoryTrashData($conditions, LOGIN_DATA_TABLE);
                    $data['countLoginHistory'] = $this->DataModel->countLoginHistoryTrashData($conditions, LOGIN_DATA_TABLE);
                    
                    $data['viewLoginHistory'] = array();
                    if(is_array($loginHistory) || is_object($loginHistory)){
                        foreach($loginHistory as $Row){
                            $dataArray = array();
                            $dataArray['unique_id'] = $Row['unique_id'];
                            $dataArray['user_name'] = $Row['user_name'];
                            $dataArray['user_email'] = $Row['user_email'];
                            $dataArray['user_login'] = $Row['user_login'];
                            $dataArray['user_logout'] = $Row['user_logout'];
                            array_push($data['viewLoginHistory'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/user/login_history_trash_view', $data);
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
    
    public function loginHistoryRestore($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $uniqueID = urlDecodes($uniqueID);
                    if(ctype_digit($uniqueID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('unique_id = '.$uniqueID, LOGIN_DATA_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_login_history_restore_success','Your login history has been restore successfully!');
                            $sessionLoginHistoryTrashViewPreviousUrl = $this->session->userdata('session_login_history_trash_view_previous_url');
                            if(!empty($sessionLoginHistoryTrashViewPreviousUrl)){
                                redirect($sessionLoginHistoryTrashViewPreviousUrl);
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
    
    public function loginHistoryDelete($uniqueID = 0){
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
                                $resultDataEntry = $this->DataModel->deleteData('unique_id = '.$uniqueID, LOGIN_DATA_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_login_history_delete_success','Your login history has been delete successfully!');
                                    $sessionLoginHistoryTrashViewPreviousUrl = $this->session->userdata('session_login_history_trash_view_previous_url');
                                    if(!empty($sessionLoginHistoryTrashViewPreviousUrl)){
                                        redirect($sessionLoginHistoryTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_login_history_delete_error','Your password are not matched! Please enter correct password');
                                $sessionLoginHistoryTrashViewPreviousUrl = $this->session->userdata('session_login_history_trash_view_previous_url');
                                if(!empty($sessionLoginHistoryTrashViewPreviousUrl)){
                                    redirect($sessionLoginHistoryTrashViewPreviousUrl);
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