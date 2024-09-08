<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting extends CI_Controller {
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
    
    public function reportingAdminView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_reporting_admin_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_reporting_admin');
            }
            if(isset($_POST['submit_search'])){
                $searchReportingAdmin = $this->input->post('search_reporting_admin');
                $this->session->set_userdata('session_reporting_admin', $searchReportingAdmin);
            }
            $sessionReportingAdmin = $this->session->userdata('session_reporting_admin');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_reporting_admin_type');
                $this->session->unset_userdata('session_reporting_admin_status');
                $this->session->unset_userdata('session_reporting_admin_reporting_start_date');
                $this->session->unset_userdata('session_reporting_admin_reporting_end_date');
                redirect('view-admin-reporting');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchReportingAdminReportingStartDate = $this->input->post('search_reporting_admin_reporting_start_date');
                $searchReportingAdminReportingEndDate = $this->input->post('search_reporting_admin_reporting_end_date');
                
                $this->session->set_userdata('session_reporting_admin_reporting_start_date', $searchReportingAdminReportingStartDate);
                $this->session->set_userdata('session_reporting_admin_reporting_end_date', $searchReportingAdminReportingEndDate);
            }
            $sessionReportingAdminReportingStartDate = $this->session->userdata('session_reporting_admin_reporting_start_date');
            $sessionReportingAdminReportingEndDate = $this->session->userdata('session_reporting_admin_reporting_end_date');
                
            $searchReportingAdminType = $this->input->post('search_reporting_admin_type');
            if($searchReportingAdminType == 'inprogress' or $searchReportingAdminType == 'completed'){
                $this->session->set_userdata('session_reporting_admin_type', $searchReportingAdminType);
            } else if($searchReportingAdminType === 'all'){
                $this->session->unset_userdata('session_reporting_admin_type');
            }
            $sessionReportingAdminType = $this->session->userdata('session_reporting_admin_type');
            
            $searchReportingAdminStatus = $this->input->post('search_reporting_admin_status');
            if($searchReportingAdminStatus == 'active' or $searchReportingAdminStatus == 'inactive'){
                $this->session->set_userdata('session_reporting_admin_status', $searchReportingAdminStatus);
            } else if($searchReportingAdminStatus === 'all'){
                $this->session->unset_userdata('session_reporting_admin_status');
            }
            $sessionReportingAdminStatus = $this->session->userdata('session_reporting_admin_status');
            
            $data = array();
            //get rows count
            $conditions['search_reporting_admin'] = $sessionReportingAdmin;
            $conditions['search_reporting_admin_type'] = $sessionReportingAdminType;
            $conditions['search_reporting_admin_status'] = $sessionReportingAdminStatus;
            $conditions['search_reporting_admin_reporting_start_date'] = $sessionReportingAdminReportingStartDate;
            $conditions['search_reporting_admin_reporting_end_date'] = $sessionReportingAdminReportingEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewReportingAdminData($conditions, HRM_REPORTING_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-admin-reporting');
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
            
            $reporting = $this->DataModel->viewReportingAdminData($conditions, HRM_REPORTING_TABLE);
            $data['countReporting'] = $this->DataModel->countReportingAdminData($conditions, HRM_REPORTING_TABLE);
            $data['countReportingTrash'] = $this->DataModel->countReportingAdminTrashData($conditions, HRM_REPORTING_TABLE);

            $data['viewReporting'] = array();
            if(is_array($reporting) || is_object($reporting)){
                foreach($reporting as $Row){
                    $dataArray = array();
                    $dataArray['reporting_id'] = $Row['reporting_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['user_id'] = $Row['user_id'];
                    $dataArray['reporting_project_name'] = $Row['reporting_project_name'];
                    $dataArray['reporting_task'] = $Row['reporting_task'];
                    $dataArray['reporting_date'] = $Row['reporting_date'];
                    $dataArray['reporting_progress'] = $Row['reporting_progress'];
                    $dataArray['reporting_type'] = $Row['reporting_type'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewReporting'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/reporting/reporting_admin_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function reportingAdminTrash($reportingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $reportingID = urlDecodes($reportingID);
                    if(ctype_digit($reportingID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('reporting_id = '.$reportingID, HRM_REPORTING_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_reporting_admin_trash_success','Your reporting has been trash successfully!');
                            $sessionReportingAdminViewPreviousUrl = $this->session->userdata('session_reporting_admin_view_previous_url');
                            if(!empty($sessionReportingAdminViewPreviousUrl)){
                                redirect($sessionReportingAdminViewPreviousUrl);
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
    
    public function reportingAdminTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_reporting_admin_trash_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_reporting_admin_trash');
            }
            if(isset($_POST['submit_search'])){
                $searchReportingAdminTrash = $this->input->post('search_reporting_admin_trash');
                $this->session->set_userdata('session_reporting_admin_trash', $searchReportingAdminTrash);
            }
            $sessionReportingAdminTrash = $this->session->userdata('session_reporting_admin_trash');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_reporting_admin_trash_type');
                $this->session->unset_userdata('session_reporting_admin_trash_status');
                $this->session->unset_userdata('session_reporting_admin_trash_reporting_start_date');
                $this->session->unset_userdata('session_reporting_admin_trash_reporting_end_date');
                redirect('view-trash-admin-reporting');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchReportingAdminTrashReportingStartDate = $this->input->post('search_reporting_admin_trash_reporting_start_date');
                $searchReportingAdminTrashReportingEndDate = $this->input->post('search_reporting_admin_trash_reporting_end_date');
                
                $this->session->set_userdata('session_reporting_admin_trash_reporting_start_date', $searchReportingAdminTrashReportingStartDate);
                $this->session->set_userdata('session_reporting_admin_trash_reporting_end_date', $searchReportingAdminTrashReportingEndDate);
            }
            $sessionReportingAdminTrashReportingStartDate = $this->session->userdata('session_reporting_admin_trash_reporting_start_date');
            $sessionReportingAdminTrashReportingEndDate = $this->session->userdata('session_reporting_admin_trash_reporting_end_date');
                
            $searchReportingAdminTrashType = $this->input->post('search_reporting_admin_trash_type');
            if($searchReportingAdminTrashType == 'inprogress' or $searchReportingAdminTrashType == 'completed'){
                $this->session->set_userdata('session_reporting_admin_trash_type', $searchReportingAdminTrashType);
            } else if($searchReportingAdminTrashType === 'all'){
                $this->session->unset_userdata('session_reporting_admin_trash_type');
            }
            $sessionReportingAdminTrashType = $this->session->userdata('session_reporting_admin_trash_type');
            
            $searchReportingAdminTrashStatus = $this->input->post('search_reporting_admin_trash_status');
            if($searchReportingAdminTrashStatus == 'active' or $searchReportingAdminTrashStatus == 'inactive'){
                $this->session->set_userdata('session_reporting_admin_trash_status', $searchReportingAdminTrashStatus);
            } else if($searchReportingAdminTrashStatus === 'all'){
                $this->session->unset_userdata('session_reporting_admin_trash_status');
            }
            $sessionReportingAdminTrashStatus = $this->session->userdata('session_reporting_admin_trash_status');
            
            $data = array();
            //get rows count
            $conditions['search_reporting_admin_trash'] = $sessionReportingAdminTrash;
            $conditions['search_reporting_admin_trash_type'] = $sessionReportingAdminTrashType;
            $conditions['search_reporting_admin_trash_status'] = $sessionReportingAdminTrashStatus;
            $conditions['search_reporting_admin_trash_reporting_start_date'] = $sessionReportingAdminTrashReportingStartDate;
            $conditions['search_reporting_admin_trash_reporting_end_date'] = $sessionReportingAdminTrashReportingEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewReportingAdminTrashData($conditions, HRM_REPORTING_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-trash-admin-reporting');
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
            
            $reporting = $this->DataModel->viewReportingAdminTrashData($conditions, HRM_REPORTING_TABLE);
            $data['countReporting'] = $this->DataModel->countReportingAdminTrashData($conditions, HRM_REPORTING_TABLE);

            $data['viewReporting'] = array();
            if(is_array($reporting) || is_object($reporting)){
                foreach($reporting as $Row){
                    $dataArray = array();
                    $dataArray['reporting_id'] = $Row['reporting_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['user_id'] = $Row['user_id'];
                    $dataArray['reporting_project_name'] = $Row['reporting_project_name'];
                    $dataArray['reporting_task'] = $Row['reporting_task'];
                    $dataArray['reporting_date'] = $Row['reporting_date'];
                    $dataArray['reporting_progress'] = $Row['reporting_progress'];
                    $dataArray['reporting_type'] = $Row['reporting_type'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewReporting'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/reporting/reporting_admin_trash_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function reportingAdminRestore($reportingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $reportingID = urlDecodes($reportingID);
                    if(ctype_digit($reportingID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('reporting_id = '.$reportingID, HRM_REPORTING_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_reporting_admin_restore_success','Your reporting has been restore successfully!');
                            $sessionReportingAdminTrashViewPreviousUrl = $this->session->userdata('session_reporting_admin_trash_view_previous_url');
                            if(!empty($sessionReportingAdminTrashViewPreviousUrl)){
                                redirect($sessionReportingAdminTrashViewPreviousUrl);
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
    
    public function reportingAdminDelete($reportingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $reportingID = urlDecodes($reportingID);
                    if(ctype_digit($reportingID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('reporting_id = '.$reportingID, HRM_REPORTING_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_reporting_admin_delete_success','Your reporting has been delete successfully!');
                                    $sessionReportingAdminTrashViewPreviousUrl = $this->session->userdata('session_reporting_admin_trash_view_previous_url');
                                    if(!empty($sessionReportingAdminTrashViewPreviousUrl)){
                                        redirect($sessionReportingAdminTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_reporting_admin_delete_error','Your password are not matched! Please enter correct password');
                                $sessionReportingAdminTrashViewPreviousUrl = $this->session->userdata('session_reporting_admin_trash_view_previous_url');
                                if(!empty($sessionReportingAdminTrashViewPreviousUrl)){
                                    redirect($sessionReportingAdminTrashViewPreviousUrl);
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
    
    public function reportingEmployeeNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_REPORTING_EMPLOYEE_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('hrm/reporting/reporting_employee_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->session->userdata['employee_id'],
                        'user_id'=>$this->session->userdata['user_id'],
                        'reporting_project_name'=>$this->input->post('reporting_project_name'),
                        'reporting_task'=>$this->input->post('reporting_task'),
                        'reporting_date'=>todayDate(),
                        'reporting_progress'=>$this->input->post('reporting_progress'),
                        'reporting_type'=>$this->input->post('reporting_type'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_REPORTING_TABLE, $newData);
                    if($newDataEntry){
                        $this->session->set_userdata('session_reporting_employee_new_success','Your reporting has been sent successfully!');
                        redirect('view-employee-reporting');
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function reportingEmployeeView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_reporting_employee_view_previous_url', current_url());
            
            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_reporting_employee');
            }
            if(isset($_POST['submit_search'])){
                $searchReportingEmployee = $this->input->post('search_reporting_employee');
                $this->session->set_userdata('session_reporting_employee', $searchReportingEmployee);
            }
            $sessionReportingEmployee = $this->session->userdata('session_reporting_employee');

            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_reporting_employee_type');
                $this->session->unset_userdata('session_reporting_employee_reporting_start_date');
                $this->session->unset_userdata('session_reporting_employee_reporting_end_date');
                redirect('view-employee-reporting');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchReportingEmployeeReportingStartDate = $this->input->post('search_reporting_employee_reporting_start_date');
                $searchReportingEmployeeReportingEndDate = $this->input->post('search_reporting_employee_reporting_end_date');
                
                $this->session->set_userdata('session_reporting_employee_reporting_start_date', $searchReportingEmployeeReportingStartDate);
                $this->session->set_userdata('session_reporting_employee_reporting_end_date', $searchReportingEmployeeReportingEndDate);
            }
            $sessionReportingEmployeeReportingStartDate = $this->session->userdata('session_reporting_employee_reporting_start_date');
            $sessionReportingEmployeeReportingEndDate = $this->session->userdata('session_reporting_employee_reporting_end_date');
            
            $searchReportingEmployeeType = $this->input->post('search_reporting_employee_type');
            if($searchReportingEmployeeType == 'inprogress' or $searchReportingEmployeeType == 'completed'){
                $this->session->set_userdata('session_reporting_employee_type', $searchReportingEmployeeType);
            } else if($searchReportingEmployeeType === 'all'){
                $this->session->unset_userdata('session_reporting_employee_type');
            }
            $sessionReportingEmployeeType = $this->session->userdata('session_reporting_employee_type');
                
            $data = array();
            //get rows count
            $conditions['search_reporting_employee'] = $sessionReportingEmployee;
            $conditions['search_reporting_employee_type'] = $sessionReportingEmployeeType;
            $conditions['search_reporting_employee_reporting_start_date'] = $sessionReportingEmployeeReportingStartDate;
            $conditions['search_reporting_employee_reporting_end_date'] = $sessionReportingEmployeeReportingEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewReportingEmployeeData($conditions, HRM_REPORTING_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-employee-reporting');
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
            
            $reporting = $this->DataModel->viewReportingEmployeeData($conditions, HRM_REPORTING_TABLE);
            $data['countReporting'] = $this->DataModel->countReportingEmployeeData($conditions, HRM_REPORTING_TABLE);

            $data['viewReporting'] = array();
            if(is_array($reporting) || is_object($reporting)){
                foreach($reporting as $Row){
                    $dataArray = array();
                    $dataArray['reporting_id'] = $Row['reporting_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['user_id'] = $Row['user_id'];
                    $dataArray['reporting_project_name'] = $Row['reporting_project_name'];
                    $dataArray['reporting_task'] = $Row['reporting_task'];
                    $dataArray['reporting_date'] = $Row['reporting_date'];
                    $dataArray['reporting_progress'] = $Row['reporting_progress'];
                    $dataArray['reporting_type'] = $Row['reporting_type'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewReporting'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/reporting/reporting_employee_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function reportingEmployeeEdit($reportingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_REPORTING_EMPLOYEE_ALIAS, "can_edit");
            if($isPermission){
                $reportingID = urlDecodes($reportingID);
                if(ctype_digit($reportingID)){
                    $data['reportingData'] = $this->DataModel->getData('reporting_id = '.$reportingID, HRM_REPORTING_TABLE);

                    if(!empty($data['reportingData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/reporting/reporting_employee_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'reporting_project_name'=>$this->input->post('reporting_project_name'),
                            'reporting_task'=>$this->input->post('reporting_task'),
                            'reporting_date'=>$this->input->post('reporting_date'),
                            'reporting_progress'=>$this->input->post('reporting_progress'),
                            'reporting_type'=>$this->input->post('reporting_type'),
                        );
                        $editDataEntry = $this->DataModel->editData('reporting_id = '.$reportingID, HRM_REPORTING_TABLE, $editData);
                        if($editDataEntry){
                            $sessionReportingEmployeeViewPreviousUrl = $this->session->userdata('session_reporting_employee_view_previous_url');
                            if(!empty($sessionReportingEmployeeViewPreviousUrl)){
                                redirect($sessionReportingEmployeeViewPreviousUrl);
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
}