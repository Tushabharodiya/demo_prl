<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
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
    
    public function attendanceAdminView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_attendance_admin_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_attendance_admin');
            }
            if(isset($_POST['submit_search'])){
                $searchAttendanceAdmin = $this->input->post('search_attendance_admin');
                $this->session->set_userdata('session_attendance_admin', $searchAttendanceAdmin);
            }
            $sessionAttendanceAdmin = $this->session->userdata('session_attendance_admin');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_attendance_admin_type');
                $this->session->unset_userdata('session_attendance_admin_status');
                $this->session->unset_userdata('session_attendance_admin_working_start_date');
                $this->session->unset_userdata('session_attendance_admin_working_end_date');
                redirect('view-admin-attendance');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchAttendanceAdminWorkingStartDate = $this->input->post('search_attendance_admin_working_start_date');
                $searchAttendanceAdminWorkingEndDate = $this->input->post('search_attendance_admin_working_end_date');
                
                $this->session->set_userdata('session_attendance_admin_working_start_date', $searchAttendanceAdminWorkingStartDate);
                $this->session->set_userdata('session_attendance_admin_working_end_date', $searchAttendanceAdminWorkingEndDate);
            }
            $sessionAttendanceAdminWorkingStartDate = $this->session->userdata('session_attendance_admin_working_start_date');
            $sessionAttendanceAdminWorkingEndDate = $this->session->userdata('session_attendance_admin_working_end_date');
                
            $searchAttendanceAdminType = $this->input->post('search_attendance_admin_type');
            if($searchAttendanceAdminType == 'pending' or $searchAttendanceAdminType == 'approved' or $searchAttendanceAdminType == 'rejected'){
                $this->session->set_userdata('session_attendance_admin_type', $searchAttendanceAdminType);
            } else if($searchAttendanceAdminType === 'all'){
                $this->session->unset_userdata('session_attendance_admin_type');
            }
            $sessionAttendanceAdminType = $this->session->userdata('session_attendance_admin_type');

            $searchAttendanceAdminStatus = $this->input->post('search_attendance_admin_status');
            if($searchAttendanceAdminStatus == 'active' or $searchAttendanceAdminStatus == 'inactive'){
                $this->session->set_userdata('session_attendance_admin_status', $searchAttendanceAdminStatus);
            } else if($searchAttendanceAdminStatus === 'all'){
                $this->session->unset_userdata('session_attendance_admin_status');
            }
            $sessionAttendanceAdminStatus = $this->session->userdata('session_attendance_admin_status');
            
            $data = array();
            //get rows count
            $conditions['search_attendance_admin'] = $sessionAttendanceAdmin;
            $conditions['search_attendance_admin_type'] = $sessionAttendanceAdminType;
            $conditions['search_attendance_admin_status'] = $sessionAttendanceAdminStatus;
            $conditions['search_attendance_admin_working_start_date'] = $sessionAttendanceAdminWorkingStartDate;
            $conditions['search_attendance_admin_working_end_date'] = $sessionAttendanceAdminWorkingEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAttendanceAdminData($conditions, HRM_ATTENDANCE_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-admin-attendance');
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
            
            $attendance = $this->DataModel->viewAttendanceAdminData($conditions, HRM_ATTENDANCE_TABLE);
            $data['countAttendance'] = $this->DataModel->countAttendanceAdminData($conditions, HRM_ATTENDANCE_TABLE);
            $data['countAttendanceTrash'] = $this->DataModel->countAttendanceAdminTrashData($conditions, HRM_ATTENDANCE_TABLE);
            
            $data['workedDays'] = $this->DataModel->countAttendanceAdminHoursData($conditions, HRM_ATTENDANCE_TABLE);
            
            $workedHoursData = $this->DataModel->getAttendanceAdminHoursData('working_hours', $conditions, HRM_ATTENDANCE_TABLE);
			if(!empty($workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'])){
			    $workingHours = $workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'];
                $workedTimeParts = explode(':', $workingHours);
                $workedTimeFormatted = $workedTimeParts[0] . ':' . $workedTimeParts[1];
                $data['workedHours'] = $workedTimeFormatted;
			} else {
			    $data['workedHours'] = "00:00";
			}
			
			$overtimeHoursData = $this->DataModel->getAttendanceAdminHoursData('working_overtime_hours', $conditions, HRM_ATTENDANCE_TABLE);
			if(!empty($overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'])){
			    $workingOvertimeHours = $overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'];
                $overtimeTimeParts = explode(':', $workingOvertimeHours);
                $overtimeTimeFormatted = $overtimeTimeParts[0] . ':' . $overtimeTimeParts[1];
                $data['overtimeHours'] = $overtimeTimeFormatted;
			} else {
			    $data['overtimeHours'] = "00:00";
			}
			
			$belowtimeHoursData = $this->DataModel->getAttendanceAdminHoursData('working_belowtime_hours', $conditions, HRM_ATTENDANCE_TABLE);
			if(!empty($belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'])){
			    $workingBelowtimeHours = $belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'];
                $belowtimeTimeParts = explode(':', $workingBelowtimeHours);
                $belowtimeTimeFormatted = $belowtimeTimeParts[0] . ':' . $belowtimeTimeParts[1];
                $data['belowtimeHours'] = $belowtimeTimeFormatted;
			} else {
			    $data['belowtimeHours'] = "00:00";
			}

            $data['viewAttendance'] = array();
            if(is_array($attendance) || is_object($attendance)){
                foreach($attendance as $Row){
                    $dataArray = array();
                    $dataArray['working_id'] = $Row['working_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['working_date'] = $Row['working_date'];
                    $dataArray['working_start_time'] = $Row['working_start_time'];
                    $dataArray['working_end_time'] = $Row['working_end_time'];
                    $dataArray['working_hours'] = $Row['working_hours'];
                    $dataArray['working_overtime_hours'] = $Row['working_overtime_hours'];
                    $dataArray['working_belowtime_hours'] = $Row['working_belowtime_hours'];
                    $dataArray['working_type'] = $Row['working_type'];
                    $dataArray['punch_status'] = $Row['punch_status'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    $dataArray['leaveData'] = $this->DataModel->getData('employee_id = "'.$dataArray['employee_id'].'" And leave_from_date="'.$dataArray['working_date'].'" And leave_to_date="'.$dataArray['working_date'].'"', HRM_LEAVE_TABLE);
                    $dataArray['attendanceData'] = $this->DataModel->getData('working_id = '.$dataArray['working_id'], HRM_ATTENDANCE_TABLE);
                    array_push($data['viewAttendance'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/attendance/attendance_admin_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function attendanceAdminEdit($workingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_ATTENDANCE_ADMIN_ALIAS, "can_edit");
            if($isPermission){
                $workingID = urlDecodes($workingID);
                if(ctype_digit($workingID)){
                    $data['attendanceData'] = $this->DataModel->getData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE);
                    
                    if($this->input->post('submit_attendance_approved')){
                        $editData = array(
                            'working_hours'=>$this->input->post('working_hours'),
                            'working_overtime_hours'=>($this->input->post('working_overtime_hours') !== null) ? $this->input->post('working_overtime_hours') : "00:00",
                            'working_belowtime_hours'=>($this->input->post('working_belowtime_hours') !== null) ? $this->input->post('working_belowtime_hours') : "00:00",
                            'working_type'=>'approved',
                        );
                        $editDataEntry = $this->DataModel->editData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE, $editData);
                        if($editDataEntry){
                            if(!empty($this->input->post('working_overtime_hours'))){
                                $this->session->set_userdata('session_attendance_admin_edit_approved_overtime_success','Your overtime has been approved successfully!');
                            } else {
                                $this->session->set_userdata('session_attendance_admin_edit_approved_belowtime_success','Your belowtime has been approved successfully!');
                            }
                            $sessionAttendanceAdminViewPreviousUrl = $this->session->userdata('session_attendance_admin_view_previous_url');
                            if(!empty($sessionAttendanceAdminViewPreviousUrl)){
                                redirect($sessionAttendanceAdminViewPreviousUrl);
                            }
                        }
                    }
                    
                    if($this->input->post('submit_attendance_rejected')){
                        $editData = array(
                            'working_hours'=>"08:00",
                            'working_overtime_hours'=>"00:00",
                            'working_belowtime_hours'=>"00:00",
                            'working_type'=>'rejected',
                        );
                        $editDataEntry = $this->DataModel->editData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE, $editData);
                        if($editDataEntry){
                            if(!empty($this->input->post('working_overtime_hours'))){
                                $this->session->set_userdata('session_attendance_admin_edit_rejected_overtime_error','Your overtime has been rejected successfully!');
                            } else {
                                $this->session->set_userdata('session_attendance_admin_edit_rejected_belowtime_error','Your belowtime has been rejected successfully!');
                            }
                            $sessionAttendanceAdminViewPreviousUrl = $this->session->userdata('session_attendance_admin_view_previous_url');
                            if(!empty($sessionAttendanceAdminViewPreviousUrl)){
                                redirect($sessionAttendanceAdminViewPreviousUrl);
                            }
                        }
                    }
                    
                    if($this->input->post('submit')){
                        $workingStartTimeArray = json_decode($this->input->post('working_start_time'), true);
                        $workingEndTimeArray = json_decode($this->input->post('working_end_time'), true);
                        
                        $workingStartTime = array_column($workingStartTimeArray, 'value');
                        $workingEndTime = array_column($workingEndTimeArray, 'value');

                        $editData = array(
                            'working_date'=>$this->input->post('working_date'),
                            'working_start_time'=>implode(', ', $workingStartTime),
                            'working_end_time'=>implode(', ', $workingEndTime),
                        );
                        $editDataEntry = $this->DataModel->editData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE, $editData);
                        if($editDataEntry){
                            $sessionAttendanceAdminViewPreviousUrl = $this->session->userdata('session_attendance_admin_view_previous_url');
                            if(!empty($sessionAttendanceAdminViewPreviousUrl)){
                                redirect($sessionAttendanceAdminViewPreviousUrl);
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
    
    public function attendanceAdminTrash($workingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $workingID = urlDecodes($workingID);
                    if(ctype_digit($workingID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_attendance_admin_trash_success','Your attendance has been trash successfully!');
                            $sessionAttendanceAdminViewPreviousUrl = $this->session->userdata('session_attendance_admin_view_previous_url');
                            if(!empty($sessionAttendanceAdminViewPreviousUrl)){
                                redirect($sessionAttendanceAdminViewPreviousUrl);
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
    
    public function attendanceAdminTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_attendance_admin_trash_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_attendance_admin_trash');
            }
            if(isset($_POST['submit_search'])){
                $searchAttendanceAdminTrash = $this->input->post('search_attendance_admin_trash');
                $this->session->set_userdata('session_attendance_admin_trash', $searchAttendanceAdminTrash);
            }
            $sessionAttendanceAdminTrash = $this->session->userdata('session_attendance_admin_trash');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_attendance_admin_trash_type');
                $this->session->unset_userdata('session_attendance_admin_trash_status');
                $this->session->unset_userdata('session_attendance_admin_trash_working_start_date');
                $this->session->unset_userdata('session_attendance_admin_trash_working_end_date');
                redirect('view-trash-admin-attendance');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchAttendanceAdminTrashWorkingStartDate = $this->input->post('search_attendance_admin_trash_working_start_date');
                $searchAttendanceAdminTrashWorkingEndDate = $this->input->post('search_attendance_admin_trash_working_end_date');
                
                $this->session->set_userdata('session_attendance_admin_trash_working_start_date', $searchAttendanceAdminTrashWorkingStartDate);
                $this->session->set_userdata('session_attendance_admin_trash_working_end_date', $searchAttendanceAdminTrashWorkingEndDate);
            }
            $sessionAttendanceAdminTrashWorkingStartDate = $this->session->userdata('session_attendance_admin_trash_working_start_date');
            $sessionAttendanceAdminTrashWorkingEndDate = $this->session->userdata('session_attendance_admin_trash_working_end_date');
                
            $searchAttendanceAdminTrashType = $this->input->post('search_attendance_admin_trash_type');
            if($searchAttendanceAdminTrashType == 'pending' or $searchAttendanceAdminTrashType == 'approved' or $searchAttendanceAdminTrashType == 'rejected'){
                $this->session->set_userdata('session_attendance_admin_trash_type', $searchAttendanceAdminTrashType);
            } else if($searchAttendanceAdminTrashType === 'all'){
                $this->session->unset_userdata('session_attendance_admin_trash_type');
            }
            $sessionAttendanceAdminTrashType = $this->session->userdata('session_attendance_admin_trash_type');

            $searchAttendanceAdminTrashStatus = $this->input->post('search_attendance_admin_trash_status');
            if($searchAttendanceAdminTrashStatus == 'active' or $searchAttendanceAdminTrashStatus == 'inactive'){
                $this->session->set_userdata('session_attendance_admin_trash_status', $searchAttendanceAdminTrashStatus);
            } else if($searchAttendanceAdminTrashStatus === 'all'){
                $this->session->unset_userdata('session_attendance_admin_trash_status');
            }
            $sessionAttendanceAdminTrashStatus = $this->session->userdata('session_attendance_admin_trash_status');
            
            $data = array();
            //get rows count
            $conditions['search_attendance_admin_trash'] = $sessionAttendanceAdminTrash;
            $conditions['search_attendance_admin_trash_type'] = $sessionAttendanceAdminTrashType;
            $conditions['search_attendance_admin_trash_status'] = $sessionAttendanceAdminTrashStatus;
            $conditions['search_attendance_admin_trash_working_start_date'] = $sessionAttendanceAdminTrashWorkingStartDate;
            $conditions['search_attendance_admin_trash_working_end_date'] = $sessionAttendanceAdminTrashWorkingEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAttendanceAdminTrashData($conditions, HRM_ATTENDANCE_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-trash-admin-attendance');
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
            
            $attendance = $this->DataModel->viewAttendanceAdminTrashData($conditions, HRM_ATTENDANCE_TABLE);
            $data['countAttendance'] = $this->DataModel->countAttendanceAdminTrashData($conditions, HRM_ATTENDANCE_TABLE);
            
            $data['workedDays'] = $this->DataModel->countAttendanceAdminTrashHoursData($conditions, HRM_ATTENDANCE_TABLE);
            
            $workedHoursData = $this->DataModel->getAttendanceAdminTrashHoursData('working_hours', $conditions, HRM_ATTENDANCE_TABLE);
			if(!empty($workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'])){
			    $workingHours = $workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'];
                $workedTimeParts = explode(':', $workingHours);
                $workedTimeFormatted = $workedTimeParts[0] . ':' . $workedTimeParts[1];
                $data['workedHours'] = $workedTimeFormatted;
			} else {
			    $data['workedHours'] = "00:00";
			}
			
			$overtimeHoursData = $this->DataModel->getAttendanceAdminTrashHoursData('working_overtime_hours', $conditions, HRM_ATTENDANCE_TABLE);
			if(!empty($overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'])){
			    $workingOvertimeHours = $overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'];
                $overtimeTimeParts = explode(':', $workingOvertimeHours);
                $overtimeTimeFormatted = $overtimeTimeParts[0] . ':' . $overtimeTimeParts[1];
                $data['overtimeHours'] = $overtimeTimeFormatted;
			} else {
			    $data['overtimeHours'] = "00:00";
			}
			
			$belowtimeHoursData = $this->DataModel->getAttendanceAdminTrashHoursData('working_belowtime_hours', $conditions, HRM_ATTENDANCE_TABLE);
			if(!empty($belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'])){
			    $workingBelowtimeHours = $belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'];
                $belowtimeTimeParts = explode(':', $workingBelowtimeHours);
                $belowtimeTimeFormatted = $belowtimeTimeParts[0] . ':' . $belowtimeTimeParts[1];
                $data['belowtimeHours'] = $belowtimeTimeFormatted;
			} else {
			    $data['belowtimeHours'] = "00:00";
			}

            $data['viewAttendance'] = array();
            if(is_array($attendance) || is_object($attendance)){
                foreach($attendance as $Row){
                    $dataArray = array();
                    $dataArray['working_id'] = $Row['working_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['working_date'] = $Row['working_date'];
                    $dataArray['working_start_time'] = $Row['working_start_time'];
                    $dataArray['working_end_time'] = $Row['working_end_time'];
                    $dataArray['working_hours'] = $Row['working_hours'];
                    $dataArray['working_overtime_hours'] = $Row['working_overtime_hours'];
                    $dataArray['working_belowtime_hours'] = $Row['working_belowtime_hours'];
                    $dataArray['working_type'] = $Row['working_type'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    $dataArray['leaveData'] = $this->DataModel->getData('employee_id = "'.$dataArray['employee_id'].'" And leave_from_date="'.$dataArray['working_date'].'" And leave_to_date="'.$dataArray['working_date'].'"', HRM_LEAVE_TABLE);
                    array_push($data['viewAttendance'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/attendance/attendance_admin_trash_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function attendanceAdminRestore($workingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $workingID = urlDecodes($workingID);
                    if(ctype_digit($workingID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_attendance_admin_restore_success','Your attendance has been restore successfully!');
                            $sessionAttendanceAdminTrashViewPreviousUrl = $this->session->userdata('session_attendance_admin_trash_view_previous_url');
                            if(!empty($sessionAttendanceAdminTrashViewPreviousUrl)){
                                redirect($sessionAttendanceAdminTrashViewPreviousUrl);
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
    
    public function attendanceAdminDelete($workingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $workingID = urlDecodes($workingID);
                    if(ctype_digit($workingID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_attendance_admin_delete_success','Your attendance has been delete successfully!');
                                    $sessionAttendanceAdminTrashViewPreviousUrl = $this->session->userdata('session_attendance_admin_trash_view_previous_url');
                                    if(!empty($sessionAttendanceAdminTrashViewPreviousUrl)){
                                        redirect($sessionAttendanceAdminTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_attendance_admin_delete_error','Your password are not matched! Please enter correct password');
                                $sessionAttendanceAdminTrashViewPreviousUrl = $this->session->userdata('session_attendance_admin_trash_view_previous_url');
                                if(!empty($sessionAttendanceAdminTrashViewPreviousUrl)){
                                    redirect($sessionAttendanceAdminTrashViewPreviousUrl);
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
    
    public function attendanceEmployeeView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_attendance_employee_view_previous_url', current_url());
            
            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_attendance_employee');
            }
            if(isset($_POST['submit_search'])){
                $searchAttendanceEmployee = $this->input->post('search_attendance_employee');
                $this->session->set_userdata('session_attendance_employee', $searchAttendanceEmployee);
            }
            $sessionAttendanceEmployee = $this->session->userdata('session_attendance_employee');

            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_attendance_employee_working_start_date');
                $this->session->unset_userdata('session_attendance_employee_working_end_date');
                redirect('view-employee-attendance');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchAttendanceEmployeeWorkingStartDate = $this->input->post('search_attendance_employee_working_start_date');
                $searchAttendanceEmployeeWorkingEndDate = $this->input->post('search_attendance_employee_working_end_date');
                
                $this->session->set_userdata('session_attendance_employee_working_start_date', $searchAttendanceEmployeeWorkingStartDate);
                $this->session->set_userdata('session_attendance_employee_working_end_date', $searchAttendanceEmployeeWorkingEndDate);
            }
            $sessionAttendanceEmployeeWorkingStartDate = $this->session->userdata('session_attendance_employee_working_start_date');
            $sessionAttendanceEmployeeWorkingEndDate = $this->session->userdata('session_attendance_employee_working_end_date');
                
            $data = array();
            //get rows count
            $conditions['search_attendance_employee'] = $sessionAttendanceEmployee;
            $conditions['search_attendance_employee_working_start_date'] = $sessionAttendanceEmployeeWorkingStartDate;
            $conditions['search_attendance_employee_working_end_date'] = $sessionAttendanceEmployeeWorkingEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAttendanceEmployeeData($conditions, HRM_ATTENDANCE_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-employee-attendance');
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
            
            $attendance = $this->DataModel->viewAttendanceEmployeeData($conditions, HRM_ATTENDANCE_TABLE);
            $data['countAttendance'] = $this->DataModel->countAttendanceEmployeeData($conditions, HRM_ATTENDANCE_TABLE);
            
            $data['workedDays'] = $this->DataModel->countAttendanceEmployeeHoursData($conditions, HRM_ATTENDANCE_TABLE);
            
            $workedHoursData = $this->DataModel->getAttendanceEmployeeHoursData('working_hours', $conditions, HRM_ATTENDANCE_TABLE);
			if(!empty($workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'])){
			    $workingHours = $workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'];
                $workedTimeParts = explode(':', $workingHours);
                $workedTimeFormatted = $workedTimeParts[0] . ':' . $workedTimeParts[1];
                $data['workedHours'] = $workedTimeFormatted;
			} else {
			    $data['workedHours'] = "00:00";
			}
			
			$overtimeHoursData = $this->DataModel->getAttendanceEmployeeHoursData('working_overtime_hours', $conditions, HRM_ATTENDANCE_TABLE);
			if(!empty($overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'])){
			    $workingOvertimeHours = $overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'];
                $overtimeTimeParts = explode(':', $workingOvertimeHours);
                $overtimeTimeFormatted = $overtimeTimeParts[0] . ':' . $overtimeTimeParts[1];
                $data['overtimeHours'] = $overtimeTimeFormatted;
			} else {
			    $data['overtimeHours'] = "00:00";
			}
			
			$belowtimeHoursData = $this->DataModel->getAttendanceEmployeeHoursData('working_belowtime_hours', $conditions, HRM_ATTENDANCE_TABLE);
			if(!empty($belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'])){
			    $workingBelowtimeHours = $belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'];
                $belowtimeTimeParts = explode(':', $workingBelowtimeHours);
                $belowtimeTimeFormatted = $belowtimeTimeParts[0] . ':' . $belowtimeTimeParts[1];
                $data['belowtimeHours'] = $belowtimeTimeFormatted;
			} else {
			    $data['belowtimeHours'] = "00:00";
			}

            $data['viewAttendance'] = array();
            if(is_array($attendance) || is_object($attendance)){
                foreach($attendance as $Row){
                    $dataArray = array();
                    $dataArray['working_id'] = $Row['working_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['working_date'] = $Row['working_date'];
                    $dataArray['working_start_time'] = $Row['working_start_time'];
                    $dataArray['working_end_time'] = $Row['working_end_time'];
                    $dataArray['working_hours'] = $Row['working_hours'];
                    $dataArray['working_overtime_hours'] = $Row['working_overtime_hours'];
                    $dataArray['working_belowtime_hours'] = $Row['working_belowtime_hours'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    array_push($data['viewAttendance'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/attendance/attendance_employee_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
}