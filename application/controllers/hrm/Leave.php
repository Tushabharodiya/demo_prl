<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {
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
    
    public function leaveAdminView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_leave_admin_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_leave_admin');
            }
            if(isset($_POST['submit_search'])){
                $searchLeaveAdmin = $this->input->post('search_leave_admin');
                $this->session->set_userdata('session_leave_admin', $searchLeaveAdmin);
            }
            $sessionLeaveAdmin = $this->session->userdata('session_leave_admin');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_leave_admin_type');
                $this->session->unset_userdata('session_leave_admin_leave');
                $this->session->unset_userdata('session_leave_admin_status');
                $this->session->unset_userdata('session_leave_admin_from_start_date');
                $this->session->unset_userdata('session_leave_admin_from_end_date');
                redirect('view-admin-leave');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchLeaveAdminFromStartDate = $this->input->post('search_leave_admin_from_start_date');
                $searchLeaveAdminFromEndDate = $this->input->post('search_leave_admin_from_end_date');
                
                $this->session->set_userdata('session_leave_admin_from_start_date', $searchLeaveAdminFromStartDate);
                $this->session->set_userdata('session_leave_admin_from_end_date', $searchLeaveAdminFromEndDate);
            }
            $sessionLeaveAdminFromStartDate = $this->session->userdata('session_leave_admin_from_start_date');
            $sessionLeaveAdminFromEndDate = $this->session->userdata('session_leave_admin_from_end_date');
                
            $searchLeaveAdminType = $this->input->post('search_leave_admin_type');
            if($searchLeaveAdminType == 'full' or $searchLeaveAdminType == 'half' or $searchLeaveAdminType == 'short'){
                $this->session->set_userdata('session_leave_admin_type', $searchLeaveAdminType);
            } else if($searchLeaveAdminType === 'all'){
                $this->session->unset_userdata('session_leave_admin_type');
            }
            $sessionLeaveAdminType = $this->session->userdata('session_leave_admin_type');

            $searchLeaveAdminLeave = $this->input->post('search_leave_admin_leave');
            if($searchLeaveAdminLeave == 'pending' or $searchLeaveAdminLeave == 'approved' or $searchLeaveAdminLeave == 'rejected' or $searchLeaveAdminLeave == 'cancelled'){
                $this->session->set_userdata('session_leave_admin_leave', $searchLeaveAdminLeave);
            } else if($searchLeaveAdminLeave === 'all'){
                $this->session->unset_userdata('session_leave_admin_leave');
            }
            $sessionLeaveAdminLeave = $this->session->userdata('session_leave_admin_leave');

            $searchLeaveAdminStatus = $this->input->post('search_leave_admin_status');
            if($searchLeaveAdminStatus == 'active' or $searchLeaveAdminStatus == 'inactive'){
                $this->session->set_userdata('session_leave_admin_status', $searchLeaveAdminStatus);
            } else if($searchLeaveAdminStatus === 'all'){
                $this->session->unset_userdata('session_leave_admin_status');
            }
            $sessionLeaveAdminStatus = $this->session->userdata('session_leave_admin_status');
            
            $data = array();
            //get rows count
            $conditions['search_leave_admin'] = $sessionLeaveAdmin;
            $conditions['search_leave_admin_type'] = $sessionLeaveAdminType;
            $conditions['search_leave_admin_leave'] = $sessionLeaveAdminLeave;
            $conditions['search_leave_admin_status'] = $sessionLeaveAdminStatus;
            $conditions['search_leave_admin_from_start_date'] = $sessionLeaveAdminFromStartDate;
            $conditions['search_leave_admin_from_end_date'] = $sessionLeaveAdminFromEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewLeaveAdminData($conditions, HRM_LEAVE_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-admin-leave');
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
            
            $leave = $this->DataModel->viewLeaveAdminData($conditions, HRM_LEAVE_TABLE);
            $data['countLeave'] = $this->DataModel->countLeaveAdminData($conditions, HRM_LEAVE_TABLE);
            $data['countLeaveTrash'] = $this->DataModel->countLeaveAdminTrashData($conditions, HRM_LEAVE_TABLE);
            
            $totalLeavesData = $this->DataModel->getLeaveAdminDaysData($conditions, null, HRM_LEAVE_TABLE);
            if(!empty($totalLeavesData)){
                $data['totalLeaves'] = $totalLeavesData; 
            } else {
                $data['totalLeaves'] = 0; 
            }
            
            $pendingLeavesData = $this->DataModel->getLeaveAdminDaysData($conditions, "pending", HRM_LEAVE_TABLE);
            if(!empty($pendingLeavesData)){
                $data['pendingLeaves'] = $pendingLeavesData; 
            } else {
                $data['pendingLeaves'] = 0; 
            }
            
            $approvalLeavesData = $this->DataModel->getLeaveAdminDaysData($conditions, "approved", HRM_LEAVE_TABLE);
            if(!empty($approvalLeavesData)){
                $data['approvalLeaves'] = $approvalLeavesData;
            } else {
                $data['approvalLeaves'] = 0;
            }
            
            $rejectedLeavesData = $this->DataModel->getLeaveAdminDaysData($conditions, "rejected", HRM_LEAVE_TABLE);
            if(!empty($rejectedLeavesData)){
                $data['rejectedLeaves'] = $rejectedLeavesData; 
            } else {
                $data['rejectedLeaves'] = 0; 
            }
            
            $cancelledLeavesData = $this->DataModel->getLeaveAdminDaysData($conditions, "cancelled", HRM_LEAVE_TABLE);
            if(!empty($cancelledLeavesData)){
                $data['cancelledLeaves'] = $cancelledLeavesData; 
            } else {
                $data['cancelledLeaves'] = 0; 
            }
            
            $paidLeavesData = $this->DataModel->getLeaveAdminPaidData($conditions, HRM_LEAVE_TABLE);
            if(!empty($paidLeavesData)){
                $data['paidLeaves'] = $paidLeavesData; 
            } else {
                $data['paidLeaves'] = 0; 
            }

            $data['viewLeave'] = array();
            if(is_array($leave) || is_object($leave)){
                foreach($leave as $Row){
                    $dataArray = array();
                    $dataArray['leave_id'] = $Row['leave_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['user_id'] = $Row['user_id'];
                    $dataArray['leave_date'] = $Row['leave_date'];
                    $dataArray['leave_from_date'] = $Row['leave_from_date'];
                    $dataArray['leave_to_date'] = $Row['leave_to_date'];
                    $dataArray['leave_from_time'] = $Row['leave_from_time'];
                    $dataArray['leave_to_time'] = $Row['leave_to_time'];
                    $dataArray['leave_days'] = $Row['leave_days'];
                    $dataArray['leave_paid'] = $Row['leave_paid'];
                    $dataArray['leave_reason'] = $Row['leave_reason'];
                    $dataArray['leave_rejection_reason'] = $Row['leave_rejection_reason'];
                    $dataArray['leave_reviewed_by'] = $Row['leave_reviewed_by'];
                    $dataArray['leave_type'] = $Row['leave_type'];
                    $dataArray['is_leave'] = $Row['is_leave'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    $dataArray['paidLeavesData'] = $this->DataModel->getLeaveEmployeeDashboardPaidData('employee_id = "'.$dataArray['employee_id'].'" ' . 'AND STR_TO_DATE(leave_from_date, "%d/%m/%Y") >= STR_TO_DATE("'.startDate().'", "%d/%m/%Y") ' . 'AND STR_TO_DATE(leave_to_date, "%d/%m/%Y") <= STR_TO_DATE("'.endDate().'", "%d/%m/%Y")', HRM_LEAVE_TABLE);
                    $data['userID'] = $dataArray['user_id']; 
                    $data['employeeJoiningDate'] = $dataArray['employeeData']['employee_joining_date']; 
                    $data['employeeLeavingDate'] = $dataArray['employeeData']['employee_leaving_date']; 
                    array_push($data['viewLeave'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/leave/leave_admin_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function leaveAdminEdit($leaveID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_LEAVE_ADMIN_ALIAS, "can_edit");
            if($isPermission){
                $leaveID = urlDecodes($leaveID);
                if(ctype_digit($leaveID)){
                    $data['leaveData'] = $this->DataModel->getData('leave_id = '.$leaveID, HRM_LEAVE_TABLE);
                    
                    if($this->input->post('submit_leave_approved')){
                        $editData = array(
                            'leave_paid'=>$this->input->post('leave_paid'),
                            'leave_rejection_reason'=>'',
                            'leave_reviewed_by'=>$this->session->userdata['user_name'],
                            'is_leave'=>'approved',
                        );
                        $editDataEntry = $this->DataModel->editData('leave_id = '.$leaveID, HRM_LEAVE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_leave_admin_edit_approved_leave_success','Your leave has been approved successfully!');
                            $sessionLeaveAdminViewPreviousUrl = $this->session->userdata('session_leave_admin_view_previous_url');
                            if(!empty($sessionLeaveAdminViewPreviousUrl)){
                                redirect($sessionLeaveAdminViewPreviousUrl);
                            }
                        }
                    }
                    
                    if($this->input->post('submit_leave_rejected')){
                        $editData = array(
                            'leave_paid'=>0,
                            'leave_rejection_reason'=>$this->input->post('leave_rejection_reason'),
                            'leave_reviewed_by'=>$this->session->userdata['user_name'],
                            'is_leave'=>'rejected',
                        );
                        $editDataEntry = $this->DataModel->editData('leave_id = '.$leaveID, HRM_LEAVE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_leave_admin_edit_rejected_leave_error','Your leave has been rejected successfully!');
                            $sessionLeaveAdminViewPreviousUrl = $this->session->userdata('session_leave_admin_view_previous_url');
                            if(!empty($sessionLeaveAdminViewPreviousUrl)){
                                redirect($sessionLeaveAdminViewPreviousUrl);
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
    
    public function leaveAdminTrash($leaveID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $leaveID = urlDecodes($leaveID);
                    if(ctype_digit($leaveID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('leave_id = '.$leaveID, HRM_LEAVE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_leave_admin_trash_success','Your leave has been trash successfully!');
                            $sessionLeaveAdminViewPreviousUrl = $this->session->userdata('session_leave_admin_view_previous_url');
                            if(!empty($sessionLeaveAdminViewPreviousUrl)){
                                redirect($sessionLeaveAdminViewPreviousUrl);
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
    
    public function leaveAdminTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_leave_admin_trash_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_leave_admin_trash');
            }
            if(isset($_POST['submit_search'])){
                $searchLeaveAdminTrash = $this->input->post('search_leave_admin_trash');
                $this->session->set_userdata('session_leave_admin_trash', $searchLeaveAdminTrash);
            }
            $sessionLeaveAdminTrash = $this->session->userdata('session_leave_admin_trash');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_leave_admin_trash_type');
                $this->session->unset_userdata('session_leave_admin_trash_leave');
                $this->session->unset_userdata('session_leave_admin_trash_status');
                $this->session->unset_userdata('session_leave_admin_trash_from_start_date');
                $this->session->unset_userdata('session_leave_admin_trash_from_end_date');
                redirect('view-trash-admin-leave');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchLeaveAdminTrashFromStartDate = $this->input->post('search_leave_admin_trash_from_start_date');
                $searchLeaveAdminTrashFromEndDate = $this->input->post('search_leave_admin_trash_from_end_date');
                
                $this->session->set_userdata('session_leave_admin_trash_from_start_date', $searchLeaveAdminTrashFromStartDate);
                $this->session->set_userdata('session_leave_admin_trash_from_end_date', $searchLeaveAdminTrashFromEndDate);
            }
            $sessionLeaveAdminTrashFromStartDate = $this->session->userdata('session_leave_admin_trash_from_start_date');
            $sessionLeaveAdminTrashFromEndDate = $this->session->userdata('session_leave_admin_trash_from_end_date');
                
            $searchLeaveAdminTrashType = $this->input->post('search_leave_admin_trash_type');
            if($searchLeaveAdminTrashType == 'full' or $searchLeaveAdminTrashType == 'half' or $searchLeaveAdminTrashType == 'short'){
                $this->session->set_userdata('session_leave_admin_trash_type', $searchLeaveAdminTrashType);
            } else if($searchLeaveAdminTrashType === 'all'){
                $this->session->unset_userdata('session_leave_admin_trash_type');
            }
            $sessionLeaveAdminTrashType = $this->session->userdata('session_leave_admin_trash_type');

            $searchLeaveAdminTrashLeave = $this->input->post('search_leave_admin_trash_leave');
            if($searchLeaveAdminTrashLeave == 'pending' or $searchLeaveAdminTrashLeave == 'approved' or $searchLeaveAdminTrashLeave == 'rejected' or $searchLeaveAdminTrashLeave == 'cancelled'){
                $this->session->set_userdata('session_leave_admin_trash_leave', $searchLeaveAdminTrashLeave);
            } else if($searchLeaveAdminTrashLeave === 'all'){
                $this->session->unset_userdata('session_leave_admin_trash_leave');
            }
            $sessionLeaveAdminTrashLeave = $this->session->userdata('session_leave_admin_trash_leave');

            $searchLeaveAdminTrashStatus = $this->input->post('search_leave_admin_trash_status');
            if($searchLeaveAdminTrashStatus == 'active' or $searchLeaveAdminTrashStatus == 'inactive'){
                $this->session->set_userdata('session_leave_admin_trash_status', $searchLeaveAdminTrashStatus);
            } else if($searchLeaveAdminTrashStatus === 'all'){
                $this->session->unset_userdata('session_leave_admin_trash_status');
            }
            $sessionLeaveAdminTrashStatus = $this->session->userdata('session_leave_admin_trash_status');
            
            $data = array();
            //get rows count
            $conditions['search_leave_admin_trash'] = $sessionLeaveAdminTrash;
            $conditions['search_leave_admin_trash_type'] = $sessionLeaveAdminTrashType;
            $conditions['search_leave_admin_trash_leave'] = $sessionLeaveAdminTrashLeave;
            $conditions['search_leave_admin_trash_status'] = $sessionLeaveAdminTrashStatus;
            $conditions['search_leave_admin_trash_from_start_date'] = $sessionLeaveAdminTrashFromStartDate;
            $conditions['search_leave_admin_trash_from_end_date'] = $sessionLeaveAdminTrashFromEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewLeaveAdminTrashData($conditions, HRM_LEAVE_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-trash-admin-leave');
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
            
            $leave = $this->DataModel->viewLeaveAdminTrashData($conditions, HRM_LEAVE_TABLE);
            $data['countLeave'] = $this->DataModel->countLeaveAdminTrashData($conditions, HRM_LEAVE_TABLE);
            
            $totalLeavesData = $this->DataModel->getLeaveAdminTrashDaysData($conditions, null, HRM_LEAVE_TABLE);
            if(!empty($totalLeavesData)){
                $data['totalLeaves'] = $totalLeavesData; 
            } else {
                $data['totalLeaves'] = 0; 
            }
            
            $pendingLeavesData = $this->DataModel->getLeaveAdminTrashDaysData($conditions, "pending", HRM_LEAVE_TABLE);
            if(!empty($pendingLeavesData)){
                $data['pendingLeaves'] = $pendingLeavesData; 
            } else {
                $data['pendingLeaves'] = 0; 
            }
            
            $approvalLeavesData = $this->DataModel->getLeaveAdminTrashDaysData($conditions, "approved", HRM_LEAVE_TABLE);
            if(!empty($approvalLeavesData)){
                $data['approvalLeaves'] = $approvalLeavesData;
            } else {
                $data['approvalLeaves'] = 0;
            }
            
            $rejectedLeavesData = $this->DataModel->getLeaveAdminTrashDaysData($conditions, "rejected", HRM_LEAVE_TABLE);
            if(!empty($rejectedLeavesData)){
                $data['rejectedLeaves'] = $rejectedLeavesData; 
            } else {
                $data['rejectedLeaves'] = 0; 
            }
            
            $cancelledLeavesData = $this->DataModel->getLeaveAdminTrashDaysData($conditions, "cancelled", HRM_LEAVE_TABLE);
            if(!empty($cancelledLeavesData)){
                $data['cancelledLeaves'] = $cancelledLeavesData; 
            } else {
                $data['cancelledLeaves'] = 0; 
            }
            
            $paidLeavesData = $this->DataModel->getLeaveAdminTrashPaidData($conditions, HRM_LEAVE_TABLE);
            if(!empty($paidLeavesData)){
                $data['paidLeaves'] = $paidLeavesData; 
            } else {
                $data['paidLeaves'] = 0; 
            }

            $data['viewLeave'] = array();
            if(is_array($leave) || is_object($leave)){
                foreach($leave as $Row){
                    $dataArray = array();
                    $dataArray['leave_id'] = $Row['leave_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['user_id'] = $Row['user_id'];
                    $dataArray['leave_date'] = $Row['leave_date'];
                    $dataArray['leave_from_date'] = $Row['leave_from_date'];
                    $dataArray['leave_to_date'] = $Row['leave_to_date'];
                    $dataArray['leave_from_time'] = $Row['leave_from_time'];
                    $dataArray['leave_to_time'] = $Row['leave_to_time'];
                    $dataArray['leave_days'] = $Row['leave_days'];
                    $dataArray['leave_paid'] = $Row['leave_paid'];
                    $dataArray['leave_reason'] = $Row['leave_reason'];
                    $dataArray['leave_rejection_reason'] = $Row['leave_rejection_reason'];
                    $dataArray['leave_reviewed_by'] = $Row['leave_reviewed_by'];
                    $dataArray['leave_type'] = $Row['leave_type'];
                    $dataArray['is_leave'] = $Row['is_leave'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    $data['userID'] = $dataArray['user_id']; 
                    $data['employeeJoiningDate'] = $dataArray['employeeData']['employee_joining_date']; 
                    $data['employeeLeavingDate'] = $dataArray['employeeData']['employee_leaving_date']; 
                    array_push($data['viewLeave'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/leave/leave_admin_trash_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function leaveAdminRestore($leaveID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $leaveID = urlDecodes($leaveID);
                    if(ctype_digit($leaveID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('leave_id = '.$leaveID, HRM_LEAVE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_leave_admin_restore_success','Your leave has been restore successfully!');
                            $sessionLeaveAdminTrashViewPreviousUrl = $this->session->userdata('session_leave_admin_trash_view_previous_url');
                            if(!empty($sessionLeaveAdminTrashViewPreviousUrl)){
                                redirect($sessionLeaveAdminTrashViewPreviousUrl);
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
    
    public function leaveAdminDelete($leaveID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $leaveID = urlDecodes($leaveID);
                    if(ctype_digit($leaveID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('leave_id = '.$leaveID, HRM_LEAVE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_leave_admin_delete_success','Your leave has been delete successfully!');
                                    $sessionLeaveAdminTrashViewPreviousUrl = $this->session->userdata('session_leave_admin_trash_view_previous_url');
                                    if(!empty($sessionLeaveAdminTrashViewPreviousUrl)){
                                        redirect($sessionLeaveAdminTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_leave_admin_delete_error','Your password are not matched! Please enter correct password');
                                $sessionLeaveAdminTrashViewPreviousUrl = $this->session->userdata('session_leave_admin_trash_view_previous_url');
                                if(!empty($sessionLeaveAdminTrashViewPreviousUrl)){
                                    redirect($sessionLeaveAdminTrashViewPreviousUrl);
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
    
    public function leaveEmployeeNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_LEAVE_EMPLOYEE_ALIAS, "can_add");
            if($isPermission){
                if($this->input->post('submit')){
                    $leaveFromDate = $this->input->post('leave_from_date');
                    $leaveToDate = $this->input->post('leave_to_date');
                    $totalLeaveDays = calculateLeaveDays($leaveFromDate, $leaveToDate);
                    
                    $newData = array(
                        'employee_id'=>$this->session->userdata['employee_id'],
                        'user_id'=>$this->session->userdata['user_id'],
                        'leave_date'=>todayDate(),
                        'leave_from_date'=>$this->input->post('leave_from_date'),
                        'leave_to_date'=>$this->input->post('leave_to_date'),
                        'leave_from_time'=>$this->input->post('leave_from_time'),
                        'leave_to_time'=>$this->input->post('leave_to_time'),
                        'leave_days'=>$this->input->post('leave_days'),
                        'leave_reason'=>$this->input->post('leave_reason'),
                        'leave_type'=>$this->input->post('leave_type'),
                        'is_leave'=>'pending',
                        'trash_status'=>'false',
                    );
                    $lastInsertedID = $this->DataModel->insertData(HRM_LEAVE_TABLE, $newData);
                    if($lastInsertedID){
                        if($this->input->post('leave_days') == 'full'){
                            $editData = array(
                                'leave_days' =>$totalLeaveDays,
                            );
                            $editDataEntry = $this->DataModel->editData('leave_id = '.$lastInsertedID, HRM_LEAVE_TABLE, $editData);
                        }
                        $this->session->set_userdata('session_leave_employee_new_success','Your leave has been sent successfully!');
                        redirect('view-employee-leave');
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function leaveEmployeeView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_leave_employee_view_previous_url', current_url());
            
            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_leave_employee');
            }
            if(isset($_POST['submit_search'])){
                $searchLeaveEmployee = $this->input->post('search_leave_employee');
                $this->session->set_userdata('session_leave_employee', $searchLeaveEmployee);
            }
            $sessionLeaveEmployee = $this->session->userdata('session_leave_employee');

            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_leave_employee_type');
                $this->session->unset_userdata('session_leave_employee_leave');
                $this->session->unset_userdata('session_leave_employee_from_start_date');
                $this->session->unset_userdata('session_leave_employee_from_end_date');
                redirect('view-employee-leave');
            }
            
            if(isset($_POST['submit_filter'])){
                $searchLeaveEmployeeFromStartDate = $this->input->post('search_leave_employee_from_start_date');
                $searchLeaveEmployeeFromEndDate = $this->input->post('search_leave_employee_from_end_date');
                
                $this->session->set_userdata('session_leave_employee_from_start_date', $searchLeaveEmployeeFromStartDate);
                $this->session->set_userdata('session_leave_employee_from_end_date', $searchLeaveEmployeeFromEndDate);
            }
            $sessionLeaveEmployeeFromStartDate = $this->session->userdata('session_leave_employee_from_start_date');
            $sessionLeaveEmployeeFromEndDate = $this->session->userdata('session_leave_employee_from_end_date');
            
            $searchLeaveEmployeeType = $this->input->post('search_leave_employee_type');
            if($searchLeaveEmployeeType == 'full' or $searchLeaveEmployeeType == 'half' or $searchLeaveEmployeeType == 'short'){
                $this->session->set_userdata('session_leave_employee_type', $searchLeaveEmployeeType);
            } else if($searchLeaveEmployeeType === 'all'){
                $this->session->unset_userdata('session_leave_employee_type');
            }
            $sessionLeaveEmployeeType = $this->session->userdata('session_leave_employee_type');

            $searchLeaveEmployeeLeave = $this->input->post('search_leave_employee_leave');
            if($searchLeaveEmployeeLeave == 'pending' or $searchLeaveEmployeeLeave == 'approved' or $searchLeaveEmployeeLeave == 'rejected' or $searchLeaveEmployeeLeave == 'cancelled'){
                $this->session->set_userdata('session_leave_employee_leave', $searchLeaveEmployeeLeave);
            } else if($searchLeaveEmployeeLeave === 'all'){
                $this->session->unset_userdata('session_leave_employee_leave');
            }
            $sessionLeaveEmployeeLeave = $this->session->userdata('session_leave_employee_leave');
                
            $data = array();
            //get rows count
            $conditions['search_leave_employee'] = $sessionLeaveEmployee;
            $conditions['search_leave_employee_type'] = $sessionLeaveEmployeeType;
            $conditions['search_leave_employee_leave'] = $sessionLeaveEmployeeLeave;
            $conditions['search_leave_employee_from_start_date'] = $sessionLeaveEmployeeFromStartDate;
            $conditions['search_leave_employee_from_end_date'] = $sessionLeaveEmployeeFromEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewLeaveEmployeeData($conditions, HRM_LEAVE_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-employee-leave');
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
            
            $leave = $this->DataModel->viewLeaveEmployeeData($conditions, HRM_LEAVE_TABLE);
            $data['countLeave'] = $this->DataModel->countLeaveEmployeeData($conditions, HRM_LEAVE_TABLE);
            
            $totalLeavesData = $this->DataModel->getLeaveEmployeeDaysData($conditions, null, HRM_LEAVE_TABLE);
            if(!empty($totalLeavesData)){
                $data['totalLeaves'] = $totalLeavesData; 
            } else {
                $data['totalLeaves'] = 0; 
            }
            
            $pendingLeavesData = $this->DataModel->getLeaveEmployeeDaysData($conditions, "pending", HRM_LEAVE_TABLE);
            if(!empty($pendingLeavesData)){
                $data['pendingLeaves'] = $pendingLeavesData; 
            } else {
                $data['pendingLeaves'] = 0; 
            }
            
            $approvalLeavesData = $this->DataModel->getLeaveEmployeeDaysData($conditions, "approved", HRM_LEAVE_TABLE);
            if(!empty($approvalLeavesData)){
                $data['approvalLeaves'] = $approvalLeavesData;
            } else {
                $data['approvalLeaves'] = 0;
            }
            
            $rejectedLeavesData = $this->DataModel->getLeaveEmployeeDaysData($conditions, "rejected", HRM_LEAVE_TABLE);
            if(!empty($rejectedLeavesData)){
                $data['rejectedLeaves'] = $rejectedLeavesData; 
            } else {
                $data['rejectedLeaves'] = 0; 
            }
            
            $cancelledLeavesData = $this->DataModel->getLeaveEmployeeDaysData($conditions, "cancelled", HRM_LEAVE_TABLE);
            if(!empty($cancelledLeavesData)){
                $data['cancelledLeaves'] = $cancelledLeavesData; 
            } else {
                $data['cancelledLeaves'] = 0; 
            }
            
            $paidLeavesData = $this->DataModel->getLeaveEmployeePaidData($conditions, HRM_LEAVE_TABLE);
            if(!empty($paidLeavesData)){
                $data['paidLeaves'] = $paidLeavesData; 
            } else {
                $data['paidLeaves'] = 0; 
            }

            $data['viewLeave'] = array();
            if(is_array($leave) || is_object($leave)){
                foreach($leave as $Row){
                    $dataArray = array();
                    $dataArray['leave_id'] = $Row['leave_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['user_id'] = $Row['user_id'];
                    $dataArray['leave_date'] = $Row['leave_date'];
                    $dataArray['leave_from_date'] = $Row['leave_from_date'];
                    $dataArray['leave_to_date'] = $Row['leave_to_date'];
                    $dataArray['leave_from_time'] = $Row['leave_from_time'];
                    $dataArray['leave_to_time'] = $Row['leave_to_time'];
                    $dataArray['leave_days'] = $Row['leave_days'];
                    $dataArray['leave_paid'] = $Row['leave_paid'];
                    $dataArray['leave_reason'] = $Row['leave_reason'];
                    $dataArray['leave_rejection_reason'] = $Row['leave_rejection_reason'];
                    $dataArray['leave_reviewed_by'] = $Row['leave_reviewed_by'];
                    $dataArray['leave_type'] = $Row['leave_type'];
                    $dataArray['is_leave'] = $Row['is_leave'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    $dataArray['leaveData'] = $this->DataModel->getData('leave_id = '.$dataArray['leave_id'], HRM_LEAVE_TABLE);
                    $data['userID'] = $dataArray['user_id']; 
                    $data['employeeJoiningDate'] = $dataArray['employeeData']['employee_joining_date']; 
                    $data['employeeLeavingDate'] = $dataArray['employeeData']['employee_leaving_date']; 
                    array_push($data['viewLeave'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/leave/leave_employee_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function leaveEmployeeEdit($leaveID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_LEAVE_EMPLOYEE_ALIAS, "can_edit");
            if($isPermission){
                $leaveID = urlDecodes($leaveID);
                if(ctype_digit($leaveID)){
                    
                    if($this->input->post('submit_leave_cancel')){
                        $editData = array(
                            'is_leave'=>'cancelled',
                        );
                        $editDataEntry = $this->DataModel->editData('leave_id = '.$leaveID, HRM_LEAVE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_leave_employee_edit_leave_cancel_error','Your leave has been cancel successfully!');
                            $sessionLeaveEmployeeViewPreviousUrl = $this->session->userdata('session_leave_employee_view_previous_url');
                            if(!empty($sessionLeaveEmployeeViewPreviousUrl)){
                                redirect($sessionLeaveEmployeeViewPreviousUrl);
                            }
                        }
                    }
                    
                    if($this->input->post('submit')){
                        $leaveFromDate = $this->input->post('leave_from_date');
                        $leaveToDate = $this->input->post('leave_to_date');
                        $totalLeaveDays = calculateLeaveDays($leaveFromDate, $leaveToDate);
                    
                        $editData = array(
                            'leave_from_date'=>$this->input->post('leave_from_date'),
                            'leave_to_date'=>$this->input->post('leave_to_date'),
                            'leave_from_time'=>$this->input->post('leave_from_time'),
                            'leave_to_time'=>$this->input->post('leave_to_time'),
                            'leave_days'=>$this->input->post('leave_days'),
                            'leave_reason'=>$this->input->post('leave_reason'),
                            'leave_type'=>$this->input->post('leave_type'),
                            'is_leave'=>'pending',
                        );
                        $editDataEntry = $this->DataModel->editData('leave_id = '.$leaveID, HRM_LEAVE_TABLE, $editData);
                        if($editDataEntry){
                            if($this->input->post('leave_days') == 'full'){
                                $editData = array(
                                    'leave_days' =>$totalLeaveDays,
                                );
                                $editDataEntry = $this->DataModel->editData('leave_id = '.$leaveID, HRM_LEAVE_TABLE, $editData);
                            }
                            $sessionLeaveEmployeeViewPreviousUrl = $this->session->userdata('session_leave_employee_view_previous_url');
                            if(!empty($sessionLeaveEmployeeViewPreviousUrl)){
                                redirect($sessionLeaveEmployeeViewPreviousUrl);
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