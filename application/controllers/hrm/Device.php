<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends CI_Controller {
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
	
    public function deviceNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_DEVICE_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/device/device_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $deviceAccessoryArray = json_decode($this->input->post('device_accessory'), true);
                    $deviceAccessory = array_column($deviceAccessoryArray, 'value');
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'device_name'=>$this->input->post('device_name'),
                        'device_accessory'=>implode(', ', $deviceAccessory),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_DEVICE_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-device');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function deviceView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_device_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_device');
            }
            if(isset($_POST['submit_search'])){
                $searchDevice = $this->input->post('search_device');
                $this->session->set_userdata('session_device', $searchDevice);
            }
            $sessionDevice = $this->session->userdata('session_device');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_device_status');
                redirect('view-device');
            }
            
            $searchDeviceStatus = $this->input->post('search_device_status');
            if($searchDeviceStatus === 'active' or $searchDeviceStatus == 'inactive'){
                $this->session->set_userdata('session_device_status', $searchDeviceStatus);
            } else if($searchDeviceStatus === 'all'){
                $this->session->unset_userdata('session_device_status');
            }
            $sessionDeviceStatus = $this->session->userdata('session_device_status');
            
            $data = array();
            //get rows count
            $conditions['search_device'] = $sessionDevice;
            $conditions['search_device_status'] = $sessionDeviceStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewDeviceData($conditions, HRM_DEVICE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-device');
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
            
            $device = $this->DataModel->viewDeviceData($conditions, HRM_DEVICE_TABLE);
            $data['countDevice'] = $this->DataModel->countDeviceData($conditions, HRM_DEVICE_TABLE);
            $data['countDeviceTrash'] = $this->DataModel->countDeviceTrashData($conditions, HRM_DEVICE_TABLE);
            
            $data['viewDevice'] = array();
            if(is_array($device) || is_object($device)){
                foreach($device as $Row){
                    $dataArray = array();
                    $dataArray['device_id'] = $Row['device_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['device_name'] = $Row['device_name'];
                    $dataArray['device_accessory'] = $Row['device_accessory'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewDevice'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/device/device_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function deviceEdit($deviceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_DEVICE_ALIAS, "can_edit");
            if($isPermission){
                $deviceID = urlDecodes($deviceID);
                if(ctype_digit($deviceID)){
                    $data['deviceData'] = $this->DataModel->getData('device_id = '.$deviceID, HRM_DEVICE_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['deviceData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);

                    if(!empty($data['deviceData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/device/device_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $deviceAccessoryArray = json_decode($this->input->post('device_accessory'), true);
                        $deviceAccessory = array_column($deviceAccessoryArray, 'value');
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'device_name'=>$this->input->post('device_name'),
                            'device_accessory'=>implode(', ', $deviceAccessory),
                        );
                        $editDataEntry = $this->DataModel->editData('device_id = '.$deviceID, HRM_DEVICE_TABLE, $editData);
                        if($editDataEntry){
                            $sessionDeviceViewPreviousUrl = $this->session->userdata('session_device_view_previous_url');
                            if(!empty($sessionDeviceViewPreviousUrl)){
                                redirect($sessionDeviceViewPreviousUrl);
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
    
    public function deviceTrash($deviceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $deviceID = urlDecodes($deviceID);
                    if(ctype_digit($deviceID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('device_id = '.$deviceID, HRM_DEVICE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_device_trash_success','Your device has been trash successfully!');
                            $sessionDeviceViewPreviousUrl = $this->session->userdata('session_device_view_previous_url');
                            if(!empty($sessionDeviceViewPreviousUrl)){
                                redirect($sessionDeviceViewPreviousUrl);
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
    
    public function deviceTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_device_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_device_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchDeviceTrash = $this->input->post('search_device_trash');
                        $this->session->set_userdata('session_device_trash', $searchDeviceTrash);
                    }
                    $sessionDeviceTrash = $this->session->userdata('session_device_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_device_trash_status');
                        redirect('view-trash-device');
                    }
                    
                    $searchDeviceTrashStatus = $this->input->post('search_device_trash_status');
                    if($searchDeviceTrashStatus === 'active' or $searchDeviceTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_device_trash_status', $searchDeviceTrashStatus);
                    } else if($searchDeviceTrashStatus === 'all'){
                        $this->session->unset_userdata('session_device_trash_status');
                    }
                    $sessionDeviceTrashStatus = $this->session->userdata('session_device_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_device_trash'] = $sessionDeviceTrash;
                    $conditions['search_device_trash_status'] = $sessionDeviceTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewDeviceTrashData($conditions, HRM_DEVICE_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-device');
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
                    
                    $device = $this->DataModel->viewDeviceTrashData($conditions, HRM_DEVICE_TABLE);
                    $data['countDevice'] = $this->DataModel->countDeviceTrashData($conditions, HRM_DEVICE_TABLE);
        
                    $data['viewDevice'] = array();
                    if(is_array($device) || is_object($device)){
                        foreach($device as $Row){
                            $dataArray = array();
                            $dataArray['device_id'] = $Row['device_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['device_name'] = $Row['device_name'];
                            $dataArray['device_accessory'] = $Row['device_accessory'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewDevice'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/device/device_trash_view', $data);
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
    
    public function deviceRestore($deviceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $deviceID = urlDecodes($deviceID);
                    if(ctype_digit($deviceID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('device_id = '.$deviceID, HRM_DEVICE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_device_restore_success','Your device has been restore successfully!');
                            $sessionDeviceTrashViewPreviousUrl = $this->session->userdata('session_device_trash_view_previous_url');
                            if(!empty($sessionDeviceTrashViewPreviousUrl)){
                                redirect($sessionDeviceTrashViewPreviousUrl);
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
    
    public function deviceDelete($deviceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $deviceID = urlDecodes($deviceID);
                    if(ctype_digit($deviceID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('device_id = '.$deviceID, HRM_DEVICE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_device_delete_success','Your device has been delete successfully!');
                                    $sessionDeviceTrashViewPreviousUrl = $this->session->userdata('session_device_trash_view_previous_url');
                                    if(!empty($sessionDeviceTrashViewPreviousUrl)){
                                        redirect($sessionDeviceTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_device_delete_error','Your password are not matched! Please enter correct password');
                                $sessionDeviceTrashViewPreviousUrl = $this->session->userdata('session_device_trash_view_previous_url');
                                if(!empty($sessionDeviceTrashViewPreviousUrl)){
                                    redirect($sessionDeviceTrashViewPreviousUrl);
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
