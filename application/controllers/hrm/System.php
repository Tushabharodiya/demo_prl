<?php defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CI_Controller {
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
	
    public function systemNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SYSTEM_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/system/system_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'system_name'=>$this->input->post('system_name'),
                        'system_password'=>$this->input->post('system_password'),
                        'system_operating'=>$this->input->post('system_operating'),
                        'system_ram'=>$this->input->post('system_ram'),
                        'system_processor'=>$this->input->post('system_processor'),
                        'system_ssd'=>$this->input->post('system_ssd'),
                        'system_hdd'=>$this->input->post('system_hdd'),
                        'system_version'=>$this->input->post('system_version'),
                        'system_keyboard'=>$this->input->post('system_keyboard'),
                        'system_mouse'=>$this->input->post('system_mouse'),
                        'system_display'=>$this->input->post('system_display'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_SYSTEM_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-system');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function systemView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_system_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_system');
            }
            if(isset($_POST['submit_search'])){
                $searchSystem = $this->input->post('search_system');
                $this->session->set_userdata('session_system', $searchSystem);
            }
            $sessionSystem = $this->session->userdata('session_system');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_system_status');
                redirect('view-system');
            }
            
            $searchSystemStatus = $this->input->post('search_system_status');
            if($searchSystemStatus === 'active' or $searchSystemStatus == 'inactive'){
                $this->session->set_userdata('session_system_status', $searchSystemStatus);
            } else if($searchSystemStatus === 'all'){
                $this->session->unset_userdata('session_system_status');
            }
            $sessionSystemStatus = $this->session->userdata('session_system_status');
            
            $data = array();
            //get rows count
            $conditions['search_system'] = $sessionSystem;
            $conditions['search_system_status'] = $sessionSystemStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewSystemData($conditions, HRM_SYSTEM_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-system');
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
            
            $system = $this->DataModel->viewSystemData($conditions, HRM_SYSTEM_TABLE);
            $data['countSystem'] = $this->DataModel->countSystemData($conditions, HRM_SYSTEM_TABLE);
            $data['countSystemTrash'] = $this->DataModel->countSystemTrashData($conditions, HRM_SYSTEM_TABLE);
            
            $data['viewSystem'] = array();
            if(is_array($system) || is_object($system)){
                foreach($system as $Row){
                    $dataArray = array();
                    $dataArray['system_id'] = $Row['system_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['system_name'] = $Row['system_name'];
                    $dataArray['system_password'] = $Row['system_password'];
                    $dataArray['system_operating'] = $Row['system_operating'];
                    $dataArray['system_ram'] = $Row['system_ram'];
                    $dataArray['system_processor'] = $Row['system_processor'];
                    $dataArray['system_ssd'] = $Row['system_ssd'];
                    $dataArray['system_hdd'] = $Row['system_hdd'];
                    $dataArray['system_version'] = $Row['system_version'];
                    $dataArray['system_keyboard'] = $Row['system_keyboard'];
                    $dataArray['system_mouse'] = $Row['system_mouse'];
                    $dataArray['system_display'] = $Row['system_display'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewSystem'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/system/system_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function systemEdit($systemID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SYSTEM_ALIAS, "can_edit");
            if($isPermission){
                $systemID = urlDecodes($systemID);
                if(ctype_digit($systemID)){
                    $data['systemData'] = $this->DataModel->getData('system_id = '.$systemID, HRM_SYSTEM_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['systemData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);

                    if(!empty($data['systemData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/system/system_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'system_name'=>$this->input->post('system_name'),
                            'system_password'=>$this->input->post('system_password'),
                            'system_operating'=>$this->input->post('system_operating'),
                            'system_ram'=>$this->input->post('system_ram'),
                            'system_processor'=>$this->input->post('system_processor'),
                            'system_ssd'=>$this->input->post('system_ssd'),
                            'system_hdd'=>$this->input->post('system_hdd'),
                            'system_version'=>$this->input->post('system_version'),
                            'system_keyboard'=>$this->input->post('system_keyboard'),
                            'system_mouse'=>$this->input->post('system_mouse'),
                            'system_display'=>$this->input->post('system_display'),
                        );
                        $editDataEntry = $this->DataModel->editData('system_id = '.$systemID, HRM_SYSTEM_TABLE, $editData);
                        if($editDataEntry){
                            $sessionSystemViewPreviousUrl = $this->session->userdata('session_system_view_previous_url');
                            if(!empty($sessionSystemViewPreviousUrl)){
                                redirect($sessionSystemViewPreviousUrl);
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
    
    public function systemTrash($systemID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $systemID = urlDecodes($systemID);
                    if(ctype_digit($systemID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('system_id = '.$systemID, HRM_SYSTEM_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_system_trash_success','Your system has been trash successfully!');
                            $sessionSystemViewPreviousUrl = $this->session->userdata('session_system_view_previous_url');
                            if(!empty($sessionSystemViewPreviousUrl)){
                                redirect($sessionSystemViewPreviousUrl);
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
    
    public function systemTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_system_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_system_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchSystemTrash = $this->input->post('search_system_trash');
                        $this->session->set_userdata('session_system_trash', $searchSystemTrash);
                    }
                    $sessionSystemTrash = $this->session->userdata('session_system_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_system_trash_status');
                        redirect('view-trash-system');
                    }
                    
                    $searchSystemTrashStatus = $this->input->post('search_system_trash_status');
                    if($searchSystemTrashStatus === 'active' or $searchSystemTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_system_trash_status', $searchSystemTrashStatus);
                    } else if($searchSystemTrashStatus === 'all'){
                        $this->session->unset_userdata('session_system_trash_status');
                    }
                    $sessionSystemTrashStatus = $this->session->userdata('session_system_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_system_trash'] = $sessionSystemTrash;
                    $conditions['search_system_trash_status'] = $sessionSystemTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewSystemTrashData($conditions, HRM_SYSTEM_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-system');
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
                    
                    $system = $this->DataModel->viewSystemTrashData($conditions, HRM_SYSTEM_TABLE);
                    $data['countSystem'] = $this->DataModel->countSystemTrashData($conditions, HRM_SYSTEM_TABLE);
        
                    $data['viewSystem'] = array();
                    if(is_array($system) || is_object($system)){
                        foreach($system as $Row){
                            $dataArray = array();
                            $dataArray['system_id'] = $Row['system_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['system_name'] = $Row['system_name'];
                            $dataArray['system_password'] = $Row['system_password'];
                            $dataArray['system_operating'] = $Row['system_operating'];
                            $dataArray['system_ram'] = $Row['system_ram'];
                            $dataArray['system_processor'] = $Row['system_processor'];
                            $dataArray['system_ssd'] = $Row['system_ssd'];
                            $dataArray['system_hdd'] = $Row['system_hdd'];
                            $dataArray['system_version'] = $Row['system_version'];
                            $dataArray['system_keyboard'] = $Row['system_keyboard'];
                            $dataArray['system_mouse'] = $Row['system_mouse'];
                            $dataArray['system_display'] = $Row['system_display'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewSystem'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/system/system_trash_view', $data);
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
    
    public function systemRestore($systemID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $systemID = urlDecodes($systemID);
                    if(ctype_digit($systemID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('system_id = '.$systemID, HRM_SYSTEM_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_system_restore_success','Your system has been restore successfully!');
                            $sessionSystemTrashViewPreviousUrl = $this->session->userdata('session_system_trash_view_previous_url');
                            if(!empty($sessionSystemTrashViewPreviousUrl)){
                                redirect($sessionSystemTrashViewPreviousUrl);
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
    
    public function systemDelete($systemID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $systemID = urlDecodes($systemID);
                    if(ctype_digit($systemID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('system_id = '.$systemID, HRM_SYSTEM_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_system_delete_success','Your system has been delete successfully!');
                                    $sessionSystemTrashViewPreviousUrl = $this->session->userdata('session_system_trash_view_previous_url');
                                    if(!empty($sessionSystemTrashViewPreviousUrl)){
                                        redirect($sessionSystemTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_system_delete_error','Your password are not matched! Please enter correct password');
                                $sessionSystemTrashViewPreviousUrl = $this->session->userdata('session_system_trash_view_previous_url');
                                if(!empty($sessionSystemTrashViewPreviousUrl)){
                                    redirect($sessionSystemTrashViewPreviousUrl);
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
