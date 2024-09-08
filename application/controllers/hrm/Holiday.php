<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Controller {
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
	
    public function holidayNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_HOLIDAY_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('hrm/holiday/holiday_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $holidayDate = $this->input->post('holiday_date');
                    $dateTime = DateTime::createFromFormat('d/m/Y', $holidayDate);
                    $holidayDay = $dateTime->format('l'); 

                    $newData = array(
                        'holiday_name'=>$this->input->post('holiday_name'),
                        'holiday_date'=>$holidayDate,
                        'holiday_day'=>$holidayDay,
                        'holiday_type'=>'upcoming',
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_HOLIDAY_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-holiday');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function holidayView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_holiday_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_holiday');
            }
            if(isset($_POST['submit_search'])){
                $searchHoliday = $this->input->post('search_holiday');
                $this->session->set_userdata('session_holiday', $searchHoliday);
            }
            $sessionHoliday = $this->session->userdata('session_holiday');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_holiday_type');
                $this->session->unset_userdata('session_holiday_start_date');
                $this->session->unset_userdata('session_holiday_end_date');
                redirect('view-holiday');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchHolidayStartDate = $this->input->post('search_holiday_start_date');
                $searchHolidayEndDate = $this->input->post('search_holiday_end_date');
                
                $this->session->set_userdata('session_holiday_start_date', $searchHolidayStartDate);
                $this->session->set_userdata('session_holiday_end_date', $searchHolidayEndDate);
            }
            $sessionHolidayStartDate = $this->session->userdata('session_holiday_start_date');
            $sessionHolidayEndDate = $this->session->userdata('session_holiday_end_date');
            
            $searchHolidayType = $this->input->post('search_holiday_type');
            if($searchHolidayType === 'upcoming' or $searchHolidayType == 'completed'){
                $this->session->set_userdata('session_holiday_type', $searchHolidayType);
            } else if($searchHolidayType === 'all'){
                $this->session->unset_userdata('session_holiday_type');
            }
            $sessionHolidayType = $this->session->userdata('session_holiday_type');
            
            $data = array();
            //get rows count
            $conditions['search_holiday'] = $sessionHoliday;
            $conditions['search_holiday_type'] = $sessionHolidayType;
            $conditions['search_holiday_start_date'] = $sessionHolidayStartDate;
            $conditions['search_holiday_end_date'] = $sessionHolidayEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewHolidayData($conditions, HRM_HOLIDAY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-holiday');
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
            
            $holiday = $this->DataModel->viewHolidayData($conditions, HRM_HOLIDAY_TABLE);
            $data['countHoliday'] = $this->DataModel->countHolidayData($conditions, HRM_HOLIDAY_TABLE);
            $data['countHolidayTrash'] = $this->DataModel->countHolidayTrashData($conditions, HRM_HOLIDAY_TABLE);
            
            $data['viewHoliday'] = array();
            if(is_array($holiday) || is_object($holiday)){
                foreach($holiday as $Row){
                    $dataArray = array();
                    $dataArray['holiday_id'] = $Row['holiday_id'];
                    $dataArray['holiday_name'] = $Row['holiday_name'];
                    $dataArray['holiday_date'] = $Row['holiday_date'];
                    $dataArray['holiday_day'] = $Row['holiday_day'];
                    $dataArray['holiday_type'] = $Row['holiday_type'];
                    array_push($data['viewHoliday'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/holiday/holiday_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function holidayEdit($holidayID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_HOLIDAY_ALIAS, "can_edit");
            if($isPermission){
                $holidayID = urlDecodes($holidayID);
                if(ctype_digit($holidayID)){
                    $data['holidayData'] = $this->DataModel->getData('holiday_id = '.$holidayID, HRM_HOLIDAY_TABLE);

                    if(!empty($data['holidayData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/holiday/holiday_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $holidayDate = $this->input->post('holiday_date');
                        $dateTime = DateTime::createFromFormat('d/m/Y', $holidayDate);
                        $holidayDay = $dateTime->format('l'); 
                    
                        $editData = array(
                            'holiday_name'=>$this->input->post('holiday_name'),
                            'holiday_date'=>$holidayDate,
                            'holiday_day'=>$holidayDay,
                            'holiday_type'=>$this->input->post('holiday_type'),
                        );
                        $editDataEntry = $this->DataModel->editData('holiday_id = '.$holidayID, HRM_HOLIDAY_TABLE, $editData);
                        if($editDataEntry){
                            $sessionHolidayViewPreviousUrl = $this->session->userdata('session_holiday_view_previous_url');
                            if(!empty($sessionHolidayViewPreviousUrl)){
                                redirect($sessionHolidayViewPreviousUrl);
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
    
    public function holidayTrash($holidayID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $holidayID = urlDecodes($holidayID);
                    if(ctype_digit($holidayID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('holiday_id = '.$holidayID, HRM_HOLIDAY_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_holiday_trash_success','Your holiday has been trash successfully!');
                            $sessionHolidayViewPreviousUrl = $this->session->userdata('session_holiday_view_previous_url');
                            if(!empty($sessionHolidayViewPreviousUrl)){
                                redirect($sessionHolidayViewPreviousUrl);
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
    
    public function holidayTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_holiday_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_holiday_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchHolidayTrash = $this->input->post('search_holiday_trash');
                        $this->session->set_userdata('session_holiday_trash', $searchHolidayTrash);
                    }
                    $sessionHolidayTrash = $this->session->userdata('session_holiday_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_holiday_trash_type');
                        $this->session->unset_userdata('session_holiday_trash_start_date');
                        $this->session->unset_userdata('session_holiday_trash_end_date');
                        redirect('view-trash-holiday');
                    }
                    
                    if(isset($_POST['submit_filter'])){
                        $searchHolidayTrashStartDate = $this->input->post('search_holiday_trash_start_date');
                        $searchHolidayTrashEndDate = $this->input->post('search_holiday_trash_end_date');
                        
                        $this->session->set_userdata('session_holiday_trash_start_date', $searchHolidayTrashStartDate);
                        $this->session->set_userdata('session_holiday_trash_end_date', $searchHolidayTrashEndDate);
                    }
                    $sessionHolidayTrashStartDate = $this->session->userdata('session_holiday_trash_start_date');
                    $sessionHolidayTrashEndDate = $this->session->userdata('session_holiday_trash_end_date');
                    
                    $searchHolidayTrashType = $this->input->post('search_holiday_trash_type');
                    if($searchHolidayTrashType === 'upcoming' or $searchHolidayTrashType == 'completed'){
                        $this->session->set_userdata('session_holiday_trash_type', $searchHolidayTrashType);
                    } else if($searchHolidayTrashType === 'all'){
                        $this->session->unset_userdata('session_holiday_trash_type');
                    }
                    $sessionHolidayTrashType = $this->session->userdata('session_holiday_trash_type');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_holiday_trash'] = $sessionHolidayTrash;
                    $conditions['search_holiday_trash_type'] = $sessionHolidayTrashType;
                    $conditions['search_holiday_trash_start_date'] = $sessionHolidayTrashStartDate;
                    $conditions['search_holiday_trash_end_date'] = $sessionHolidayTrashEndDate;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewHolidayTrashData($conditions, HRM_HOLIDAY_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-holiday');
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
                    
                    $holiday = $this->DataModel->viewHolidayTrashData($conditions, HRM_HOLIDAY_TABLE);
                    $data['countHoliday'] = $this->DataModel->countHolidayTrashData($conditions, HRM_HOLIDAY_TABLE);
        
                    $data['viewHoliday'] = array();
                    if(is_array($holiday) || is_object($holiday)){
                        foreach($holiday as $Row){
                            $dataArray = array();
                            $dataArray['holiday_id'] = $Row['holiday_id'];
                            $dataArray['holiday_name'] = $Row['holiday_name'];
                            $dataArray['holiday_date'] = $Row['holiday_date'];
                            $dataArray['holiday_day'] = $Row['holiday_day'];
                            $dataArray['holiday_type'] = $Row['holiday_type'];
                            array_push($data['viewHoliday'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/holiday/holiday_trash_view', $data);
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
    
    public function holidayRestore($holidayID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $holidayID = urlDecodes($holidayID);
                    if(ctype_digit($holidayID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('holiday_id = '.$holidayID, HRM_HOLIDAY_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_holiday_restore_success','Your holiday has been restore successfully!');
                            $sessionHolidayTrashViewPreviousUrl = $this->session->userdata('session_holiday_trash_view_previous_url');
                            if(!empty($sessionHolidayTrashViewPreviousUrl)){
                                redirect($sessionHolidayTrashViewPreviousUrl);
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
    
    public function holidayDelete($holidayID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $holidayID = urlDecodes($holidayID);
                    if(ctype_digit($holidayID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('holiday_id = '.$holidayID, HRM_HOLIDAY_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_holiday_delete_success','Your holiday has been delete successfully!');
                                    $sessionHolidayTrashViewPreviousUrl = $this->session->userdata('session_holiday_trash_view_previous_url');
                                    if(!empty($sessionHolidayTrashViewPreviousUrl)){
                                        redirect($sessionHolidayTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_holiday_delete_error','Your password are not matched! Please enter correct password');
                                $sessionHolidayTrashViewPreviousUrl = $this->session->userdata('session_holiday_trash_view_previous_url');
                                if(!empty($sessionHolidayTrashViewPreviousUrl)){
                                    redirect($sessionHolidayTrashViewPreviousUrl);
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
