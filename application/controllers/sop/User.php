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
            $isPermission = checkPermission(SOP_USER_ALIAS, "can_add");
            if($isPermission){
                $data['procedureData'] = $this->DataModel->viewData(null, null, SOP_PROCEDURE_TABLE);
                $data['userData'] = $this->DataModel->viewData('user_id '.'DESC', null, MASTER_USER_TABLE);
                $this->load->view('header');
                $this->load->view('sop/user/user_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $userID = $this->input->post('user_id');
                    $userData = $this->DataModel->getData('user_id = '.$userID, MASTER_USER_TABLE);
                    $departmentData = $this->DataModel->getData('department_id = '.$userData['department_id'], SOP_DEPARTMENT_TABLE);
                    $departmentName = $this->DataModel->getData('department_id = '.$userData['department_id'], DEPARTMENT_TABLE);
                    if(!empty($departmentData)){
                        $newData = array(
                            'department_id'=>$userData['department_id'],
                            'department_permission'=>$departmentData['unique_id'],
                            'user_id'=>$this->input->post('user_id'),
                            'user_permission'=>$departmentData['department_permission'],
                            'trash_status'=>'false',
                        );
                        $newDataEntry = $this->DataModel->insertData(SOP_USER_TABLE, $newData);
                        if($newDataEntry){
                            redirect('view-sop-user');  
                        }
                    } else {
                        $this->session->set_userdata('session_sop_user_new', $departmentName['department_name']);
                        redirect('new-sop-user');
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function userView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_sop_user_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_sop_user');
            }
            if(isset($_POST['submit_search'])){
                $searchSopUser = $this->input->post('search_sop_user');
                $this->session->set_userdata('session_sop_user', $searchSopUser);
            }
            $sessionSopUser = $this->session->userdata('session_sop_user');
            
            $data = array();
            //get rows count
            $conditions['search_sop_user'] = $sessionSopUser;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewSopUserData($conditions, SOP_USER_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-sop-user');
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
            
            $user = $this->DataModel->viewSopUserData($conditions, SOP_USER_TABLE);
            $data['countUser'] = $this->DataModel->countSopUserData($conditions, SOP_USER_TABLE);
            $data['countUserTrash'] = $this->DataModel->countSopUserTrashData($conditions, SOP_USER_TABLE);
            
            $data['viewUser'] = array();
            if(is_array($user) || is_object($user)){
                foreach($user as $Row){
                    $dataArray = array();
                    $dataArray['unique_id'] = $Row['unique_id'];
                    $dataArray['department_id'] = $Row['department_id'];
                    $dataArray['user_id'] = $Row['user_id'];
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                    $dataArray['userData'] = $this->DataModel->getData('user_id = '.$dataArray['user_id'], MASTER_USER_TABLE);
                    array_push($data['viewUser'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('sop/user/user_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
   
    public function userProcedureView($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $uniqueID = urlDecodes($uniqueID);
            if(ctype_digit($uniqueID)){
                $data['getUser'] = $this->DataModel->getData('unique_id = '.$uniqueID, SOP_USER_TABLE);
                $deptUniqueID = $data['getUser']['department_permission'];
                $data['getDepartment'] = $this->DataModel->getData('unique_id = '.$deptUniqueID, SOP_DEPARTMENT_TABLE);
                if($data['getUser'] != null && $data['getDepartment']){
                    $data['viewUserProcedure'] = array();
                    $userPermission = $data['getUser']['user_permission'];
                    $departmentPermission = $data['getDepartment']['department_permission'];
                    $userArray = explode(",", $userPermission);
                    $departmentArray = explode(",", $departmentPermission);
                    $mainArray = array_unique(array_merge($userArray, $departmentArray));
              
                    $this->session->set_userdata('session_sop_user_procedure_view_previous_url', current_url());
                    
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_sop_user_procedure');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchSopUserProcedure = $this->input->post('search_sop_user_procedure');
                        $this->session->set_userdata('session_sop_user_procedure', $searchSopUserProcedure);
                    }
                    $sessionSopUserProcedure = $this->session->userdata('session_sop_user_procedure');

                    $data = array();
                    //get rows count
                    $conditions['search_sop_user_procedure'] = $sessionSopUserProcedure;

                    //pagination config
                    $config['base_url'] = site_url('view-sop-user-procedure/'.urlEncodes($uniqueID));
                    $config['uri_segment'] = 3;
                    $config['total_rows'] = count($mainArray); 
                    $config['per_page'] = 10;  
                    
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
            
                    $page = $this->uri->segment(3);
                   
                    $data['viewUserProcedure'] = array();
                    
                    $mainArraySubset = array_slice($mainArray, $page, $config['per_page']); 
                    $countUserProcedure = 0;

                    if(!empty($mainArraySubset)){
                        foreach($mainArraySubset as $sopID){
                            $array = $this->DataModel->viewUserProcedureData($conditions, 'sop_id = '.$sopID, SOP_PROCEDURE_TABLE);
                            if(is_array($array) || is_object($array)){
                                $countUserProcedure++;
                                foreach($array as $Row){
                                    $dataArray = array();
                                    $dataArray['sop_id'] = $Row['sop_id'];
                                    $dataArray['sop_title'] = $Row['sop_title'];
                                    $dataArray['sop_department'] = $Row['sop_department'];
                                    $dataArray['sop_created_by'] = $Row['sop_created_by'];
                                    array_push($data['viewUserProcedure'], $dataArray);
                                }
                            }
                        }
                    }
                    $data['countUserProcedure'] = $countUserProcedure;
                    $this->load->view('header');
                    $this->load->view('sop/user/user_procedure_view', $data);
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
    
    public function userProcedureInfo($sopID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(SOP_PROCEDURE_ALIAS, "can_view");
            if($isPermission){
                $sopID = urlDecodes($sopID);
                if(ctype_digit($sopID)){
            		$data['infoUserProcedure'] = $this->DataModel->viewData(null, 'sop_id = '.$sopID, SOP_PROCEDURE_TABLE);
                    if($data['infoUserProcedure'] != null){
            	        $this->load->view('header');
                		$this->load->view('sop/user/user_procedure_info', $data);
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
    
    public function userEdit($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(SOP_USER_ALIAS, "can_edit");
            if($isPermission){
                $uniqueID = urlDecodes($uniqueID);
                if(ctype_digit($uniqueID)){
                    $data['procedureData'] = $this->DataModel->viewData(null, null, SOP_PROCEDURE_TABLE);
                    $data['viewUser'] = $this->DataModel->viewData('user_id '.'DESC', null, MASTER_USER_TABLE);
                    $data['getUser'] = $this->DataModel->getData('unique_id = '.$uniqueID, SOP_USER_TABLE);
                    $userID = $data['getUser']['user_id'];
                    $data['userData'] = $this->DataModel->getData('user_id = '.$userID, MASTER_USER_TABLE);
                    
                    if(!empty($data['procedureData'])){
                        $this->load->view('header');
                        $this->load->view('sop/user/user_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $userArray = array();
                        if(!empty($_POST['user_permission'])){
                            foreach($_POST['user_permission'] as $userIDs){
                                array_push($userArray, $userIDs);
                            }
                        }
                        $userString = implode(',', $userArray);
                        $userID = $this->input->post('user_id');
                        $userData = $this->DataModel->getData('user_id = '.$userID, MASTER_USER_TABLE);
                        $departmentData = $this->DataModel->getData('department_id = '.$userData['department_id'], SOP_DEPARTMENT_TABLE);
                        $editData = array(
                            'department_id'=>$userData['department_id'],
                            'department_permission'=>$departmentData['unique_id'],
                            'user_id'=>$this->input->post('user_id'),
                            'user_permission'=>$userString,
                        );
                        $editDataEntry = $this->DataModel->editData('unique_id = '.$uniqueID, SOP_USER_TABLE, $editData);
                        if($editDataEntry){
                            $sessionSopUserViewPreviousUrl = $this->session->userdata('session_sop_user_view_previous_url');
                            if(!empty($sessionSopUserViewPreviousUrl)){
                                redirect($sessionSopUserViewPreviousUrl);
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
    
    public function userTrash($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $uniqueID = urlDecodes($uniqueID);
                    if(ctype_digit($uniqueID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('unique_id = '.$uniqueID, SOP_USER_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_sop_user_trash_success','Your user has been trash successfully!');
                            $sessionSopUserViewPreviousUrl = $this->session->userdata('session_sop_user_view_previous_url');
                            if(!empty($sessionSopUserViewPreviousUrl)){
                                redirect($sessionSopUserViewPreviousUrl);
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

                    $this->session->set_userdata('session_sop_user_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_sop_user_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchSopUserTrash = $this->input->post('search_sop_user_trash');
                        $this->session->set_userdata('session_sop_user_trash', $searchSopUserTrash);
                    }
                    $sessionSopUserTrash = $this->session->userdata('session_sop_user_trash');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_sop_user_trash'] = $sessionSopUserTrash;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewSopUserTrashData($conditions, SOP_USER_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-sop-user');
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
                    
                    $user = $this->DataModel->viewSopUserTrashData($conditions, SOP_USER_TABLE);
                    $data['countUser'] = $this->DataModel->countSopUserTrashData($conditions, SOP_USER_TABLE);

                    $data['viewUser'] = array();
                    if(is_array($user) || is_object($user)){
                        foreach($user as $Row){
                            $dataArray = array();
                            $dataArray['unique_id'] = $Row['unique_id'];
                            $dataArray['department_id'] = $Row['department_id'];
                            $dataArray['user_id'] = $Row['user_id'];
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                            $dataArray['userData'] = $this->DataModel->getData('user_id = '.$dataArray['user_id'], MASTER_USER_TABLE);
                            array_push($data['viewUser'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('sop/user/user_trash_view', $data);
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
    
    public function userRestore($uniqueID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $uniqueID = urlDecodes($uniqueID);
                    if(ctype_digit($uniqueID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('unique_id = '.$uniqueID, SOP_USER_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_sop_user_restore_success','Your user has been restore successfully!');
                            $sessionSopUserTrashViewPreviousUrl = $this->session->userdata('session_sop_user_trash_view_previous_url');
                            if(!empty($sessionSopUserTrashViewPreviousUrl)){
                                redirect($sessionSopUserTrashViewPreviousUrl);
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
    
    public function userDelete($uniqueID = 0){
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
                                $resultDataEntry = $this->DataModel->deleteData('unique_id = '.$uniqueID, SOP_USER_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_sop_user_delete_success','Your user has been delete successfully!');
                                    $sessionSopUserTrashViewPreviousUrl = $this->session->userdata('session_sop_user_trash_view_previous_url');
                                    if(!empty($sessionSopUserTrashViewPreviousUrl)){
                                        redirect($sessionSopUserTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_sop_user_delete_error','Your password are not matched! Please enter correct password');
                                $sessionSopUserTrashViewPreviousUrl = $this->session->userdata('session_sop_user_trash_view_previous_url');
                                if(!empty($sessionSopUserTrashViewPreviousUrl)){
                                    redirect($sessionSopUserTrashViewPreviousUrl);
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