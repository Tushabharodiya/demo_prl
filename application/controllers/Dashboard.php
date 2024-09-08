<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		if ($this->session->userdata('auth_key') != AUTH_KEY){ 
            redirect('login');
        }
	}
    
    public function index(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $data['viewActiveLogin'] = $this->DataModel->viewData(null, '(is_login="True")', MASTER_USER_TABLE);
            
            $data['publisherCount'] = $this->DataModel->countData(null, PUBLISHER_TABLE);
            $data['publisherActiveCount'] = $this->DataModel->countData('(publisher_status="active")', PUBLISHER_TABLE);
            $data['publisherBlockedCount'] = $this->DataModel->countData('(publisher_status="blocked")', PUBLISHER_TABLE);
            
            $data['advertiserCount'] = $this->DataModel->countData(null, ADVERTISER_TABLE);
            $data['advertiserActiveCount'] = $this->DataModel->countData('(advertiser_status="active")', ADVERTISER_TABLE);
            $data['advertiserBlockedCount'] = $this->DataModel->countData('(advertiser_status="blocked")', ADVERTISER_TABLE);
            
            $data['invoiceCount'] = $this->DataModel->countData(null, INVOICE_TABLE);
            $data['invoiceActiveCount'] = $this->DataModel->countData('(invoice_status="active")', INVOICE_TABLE);
            $data['invoiceBlockedCount'] = $this->DataModel->countData('(invoice_status="blocked")', INVOICE_TABLE);
            
            $data['sopProcedureCount'] = $this->DataModel->countData(null, SOP_PROCEDURE_TABLE);
            $data['sopProcedureTrueCount'] = $this->DataModel->countData('(sop_status="true")', SOP_PROCEDURE_TABLE);
            $data['sopProcedureFalseCount'] = $this->DataModel->countData('(sop_status="false")', SOP_PROCEDURE_TABLE);
            
            $data['sopDepartmentCount'] = $this->DataModel->countData(null, SOP_DEPARTMENT_TABLE);
            
            $data['sopUserCount'] = $this->DataModel->countData(null, SOP_USER_TABLE);
            
            $data['employeeCount'] = $this->DataModel->countData(null, HRM_EMPLOYEE_TABLE);
            $data['employeeInternCount'] = $this->DataModel->countData('(employee_type="intern")', HRM_EMPLOYEE_TABLE);
            $data['employeeEmployeeCount'] = $this->DataModel->countData('(employee_type="employee")', HRM_EMPLOYEE_TABLE);
            $data['employeePendingCount'] = $this->DataModel->countData('(is_employee="pending")', HRM_EMPLOYEE_TABLE);
            $data['employeeSelectedCount'] = $this->DataModel->countData('(is_employee="selected")', HRM_EMPLOYEE_TABLE);
            $data['employeeRejectedCount'] = $this->DataModel->countData('(is_employee="rejected")', HRM_EMPLOYEE_TABLE);
            $data['employeeDraftCount'] = $this->DataModel->countData('(employee_status="draft")', HRM_EMPLOYEE_TABLE);
            $data['employeeActiveCount'] = $this->DataModel->countData('(employee_status="active")', HRM_EMPLOYEE_TABLE);
            $data['employeeInactiveCount'] = $this->DataModel->countData('(employee_status="inactive")', HRM_EMPLOYEE_TABLE);
            
            $data['attendanceCount'] = $this->DataModel->countData(null, HRM_ATTENDANCE_TABLE);
            $data['attendancePendingCount'] = $this->DataModel->countData('(working_type="pending")', HRM_ATTENDANCE_TABLE);
            $data['attendanceApprovedCount'] = $this->DataModel->countData('(working_type="approved")', HRM_ATTENDANCE_TABLE);
            $data['attendanceRejectedCount'] = $this->DataModel->countData('(working_type="rejected")', HRM_ATTENDANCE_TABLE);
            
            $data['leaveCount'] = $this->DataModel->countData(null, HRM_LEAVE_TABLE);
            $data['leaveFullCount'] = $this->DataModel->countData('(leave_type="full")', HRM_LEAVE_TABLE);
            $data['leaveHalfCount'] = $this->DataModel->countData('(leave_type="half")', HRM_LEAVE_TABLE);
            $data['leaveShortCount'] = $this->DataModel->countData('(leave_type="short")', HRM_LEAVE_TABLE);
            $data['leavePendingCount'] = $this->DataModel->countData('(is_leave="pending")', HRM_LEAVE_TABLE);
            $data['leaveApprovedCount'] = $this->DataModel->countData('(is_leave="approved")', HRM_LEAVE_TABLE);
            $data['leaveRejectedCount'] = $this->DataModel->countData('(is_leave="rejected")', HRM_LEAVE_TABLE);
            $data['leaveCancelledCount'] = $this->DataModel->countData('(is_leave="cancelled")', HRM_LEAVE_TABLE);
            
            $data['salaryCount'] = $this->DataModel->countData(null, HRM_SALARY_TABLE);
            $data['salaryPendingCount'] = $this->DataModel->countData('(is_email="pending")', HRM_SALARY_TABLE);
            $data['salarySendingCount'] = $this->DataModel->countData('(is_email="sending")', HRM_SALARY_TABLE);
            
            $data['internOfferCount'] = $this->DataModel->countData(null, HRM_INTERN_OFFER_TABLE);
            $data['internshipCertificateCount'] = $this->DataModel->countData(null, HRM_INTERNSHIP_CERTIFICATE_TABLE);
            $data['employeeOfferCount'] = $this->DataModel->countData(null, HRM_EMPLOYEE_OFFER_TABLE);
            $data['appraisalCertificateCount'] = $this->DataModel->countData(null, HRM_APPRAISAL_CERTIFICATE_TABLE);
            $data['warningMailCount'] = $this->DataModel->countData(null, HRM_WARNING_MAIL_TABLE);
            
            $data['appointmentCount'] = $this->DataModel->countData(null, HRM_APPOINTMENT_TABLE);
            $data['hrPolicyCount'] = $this->DataModel->countData(null, HRM_HR_POLICY_TABLE);
            $data['declarationCount'] = $this->DataModel->countData(null, HRM_DECLARATION_TABLE);
            $data['consentCount'] = $this->DataModel->countData(null, HRM_CONSENT_TABLE);
            
            $data['nonDisclosureAgreementCount'] = $this->DataModel->countData(null, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
            $data['serviceAgreementCount'] = $this->DataModel->countData(null, HRM_SERVICE_AGREEMENT_TABLE);
            
            $data['noDueCertificateCount'] = $this->DataModel->countData(null, HRM_NO_DUE_CERTIFICATE_TABLE);
            $data['relievingCount'] = $this->DataModel->countData(null, HRM_RELIEVING_TABLE);
            $data['experienceCount'] = $this->DataModel->countData(null, HRM_EXPERIENCE_TABLE);
            $data['terminationCount'] = $this->DataModel->countData(null, HRM_TERMINATION_TABLE);
            
			$this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
	
	public function employeeDashboard(){
		$isLogin = checkAuth();
        if($isLogin == "True"){
			$data['attendanceData'] = $this->DataModel->getData('user_id = "'.$this->session->userdata['user_id'].'" And working_date = "'.todayDate().'"', HRM_ATTENDANCE_TABLE);
			
			$masterUserData = $this->DataModel->getData('user_id = "'.$this->session->userdata['user_id'].'"', MASTER_USER_TABLE);
			$employeeID = $masterUserData['employee_id'];
			$data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
			
			$data['workedDays'] = $this->DataModel->countAttendanceEmployeeDashboardHoursData('user_id = "'.$this->session->userdata['user_id'].'" And MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.date('m').'" And YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.date('Y').'"', HRM_ATTENDANCE_TABLE);
			
			$workedHoursData = $this->DataModel->getAttendanceEmployeeDashboardHoursData('working_hours', 'user_id = "'.$this->session->userdata['user_id'].'" And MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.date('m').'" And YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.date('Y').'"', HRM_ATTENDANCE_TABLE);
			if(!empty($workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'])){
			    $workingHours = $workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'];
                $workedTimeParts = explode(':', $workingHours);
                $workedTimeFormatted = $workedTimeParts[0] . ':' . $workedTimeParts[1];
                $data['workedHours'] = $workedTimeFormatted;
			} else {
			    $data['workedHours'] = "00:00";
			}
			
			$overtimeHoursData = $this->DataModel->getAttendanceEmployeeDashboardHoursData('working_overtime_hours', 'user_id = "'.$this->session->userdata['user_id'].'" And MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.date('m').'" And YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.date('Y').'"', HRM_ATTENDANCE_TABLE);
			if(!empty($overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'])){
			    $workingOvertimeHours = $overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'];
                $overTimeParts = explode(':', $workingOvertimeHours);
                $overTimeFormatted = $overTimeParts[0] . ':' . $overTimeParts[1];
                $data['overtimeHours'] = $overTimeFormatted;
			} else {
			    $data['overtimeHours'] = "00:00";
			}
			
			$belowtimeHoursData = $this->DataModel->getAttendanceEmployeeDashboardHoursData('working_belowtime_hours', 'user_id = "'.$this->session->userdata['user_id'].'" And MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.date('m').'" And YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.date('Y').'"', HRM_ATTENDANCE_TABLE);
			if(!empty($belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'])){
			    $workingBelowtimeHours = $belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'];
                $belowTimeParts = explode(':', $workingBelowtimeHours);
                $belowTimeFormatted = $belowTimeParts[0] . ':' . $belowTimeParts[1];
                $data['belowtimeHours'] = $belowTimeFormatted;
			} else {
			    $data['belowtimeHours'] = "00:00";
			}
            
            $totalLeavesData = $this->DataModel->getLeaveEmployeeDashboardDaysData('user_id = "'.$this->session->userdata['user_id'].'" ' . 'AND STR_TO_DATE(leave_from_date, "%d/%m/%Y") >= STR_TO_DATE("'.startDate().'", "%d/%m/%Y") ' . 'AND STR_TO_DATE(leave_to_date, "%d/%m/%Y") <= STR_TO_DATE("'.endDate().'", "%d/%m/%Y")', HRM_LEAVE_TABLE);
            if(!empty($totalLeavesData)){
                $data['totalLeaves'] = $totalLeavesData; 
            } else {
                $data['totalLeaves'] = 0; 
            }
            
            $pendingLeavesData = $this->DataModel->getLeaveEmployeeDashboardDaysData('user_id = "'.$this->session->userdata['user_id'].'" ' . 'AND STR_TO_DATE(leave_from_date, "%d/%m/%Y") >= STR_TO_DATE("'.startDate().'", "%d/%m/%Y") ' . 'AND STR_TO_DATE(leave_to_date, "%d/%m/%Y") <= STR_TO_DATE("'.endDate().'", "%d/%m/%Y")' . 'AND is_leave = "pending"', HRM_LEAVE_TABLE);
            if(!empty($pendingLeavesData)){
                $data['pendingLeaves'] = $pendingLeavesData; 
            } else {
                $data['pendingLeaves'] = 0; 
            }
            
            $approvalLeavesData = $this->DataModel->getLeaveEmployeeDashboardDaysData('user_id = "'.$this->session->userdata['user_id'].'" ' . 'AND STR_TO_DATE(leave_from_date, "%d/%m/%Y") >= STR_TO_DATE("'.startDate().'", "%d/%m/%Y") ' . 'AND STR_TO_DATE(leave_to_date, "%d/%m/%Y") <= STR_TO_DATE("'.endDate().'", "%d/%m/%Y")' . 'AND is_leave = "approved"', HRM_LEAVE_TABLE);
            if(!empty($approvalLeavesData)){
                $data['approvalLeaves'] = $approvalLeavesData;
            } else {
                $data['approvalLeaves'] = 0;
            }
            
            $rejectedLeavesData = $this->DataModel->getLeaveEmployeeDashboardDaysData('user_id = "'.$this->session->userdata['user_id'].'" ' . 'AND STR_TO_DATE(leave_from_date, "%d/%m/%Y") >= STR_TO_DATE("'.startDate().'", "%d/%m/%Y") ' . 'AND STR_TO_DATE(leave_to_date, "%d/%m/%Y") <= STR_TO_DATE("'.endDate().'", "%d/%m/%Y")' . 'AND is_leave = "rejected"', HRM_LEAVE_TABLE);
            if(!empty($rejectedLeavesData)){
                $data['rejectedLeaves'] = $rejectedLeavesData; 
            } else {
                $data['rejectedLeaves'] = 0; 
            }
            
            $cancelledLeavesData = $this->DataModel->getLeaveEmployeeDashboardDaysData('user_id = "'.$this->session->userdata['user_id'].'" ' . 'AND STR_TO_DATE(leave_from_date, "%d/%m/%Y") >= STR_TO_DATE("'.startDate().'", "%d/%m/%Y") ' . 'AND STR_TO_DATE(leave_to_date, "%d/%m/%Y") <= STR_TO_DATE("'.endDate().'", "%d/%m/%Y")' . 'AND is_leave = "cancelled"', HRM_LEAVE_TABLE);
            if(!empty($cancelledLeavesData)){
                $data['cancelledLeaves'] = $cancelledLeavesData; 
            } else {
                $data['cancelledLeaves'] = 0; 
            }
            
            $paidLeavesData = $this->DataModel->getLeaveEmployeeDashboardPaidData('user_id = "'.$this->session->userdata['user_id'].'" ' . 'AND STR_TO_DATE(leave_from_date, "%d/%m/%Y") >= STR_TO_DATE("'.startDate().'", "%d/%m/%Y") ' . 'AND STR_TO_DATE(leave_to_date, "%d/%m/%Y") <= STR_TO_DATE("'.endDate().'", "%d/%m/%Y")', HRM_LEAVE_TABLE);
            if(!empty($paidLeavesData)){
                $data['paidLeaves'] = $paidLeavesData; 
            } else {
                $data['paidLeaves'] = 0; 
            }
            
            $data['viewUpcomingHoliday'] = $this->DataModel->viewUpcomingHolidayData(HRM_HOLIDAY_TABLE);
            
            $data['viewUpcomingBirthday'] = calculateUpcomingBirthday();
            
            $data['viewUpcomingWorkAnniversary'] = viewUpcomingWorkAnniversary();

            $this->load->view('header');
            $this->load->view('dashboard/employee_dashboard', $data);
            $this->load->view('footer');
            
            $isPermissionAttendanceAdd = checkPermission(HRM_ATTENDANCE_EMPLOYEE_ALIAS, "can_add");
            $isPermissionAttendanceEdit = checkPermission(HRM_ATTENDANCE_EMPLOYEE_ALIAS, "can_edit");
            
            $isPermissionLeaveAdd = checkPermission(HRM_LEAVE_EMPLOYEE_ALIAS, "can_add");
            
            if($this->input->post('submit_first_punch_in')){
                if($isPermissionAttendanceAdd){
                    $newData = array(
                        'user_id'=>$this->session->userdata['user_id'],
                        'employee_id'=>$this->session->userdata['employee_id'],
                        'working_date'=>todayDate(),
                        'working_start_time'=>currentTime(),
                        'working_type'=>'pending',
                        'punch_status'=>'none',
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_ATTENDANCE_TABLE, $newData);
                    if($newDataEntry){
                        $this->session->set_userdata('session_attendance_employee_dashboard_first_punch_in_success','You have successfully punched in!');
                        redirect('employee-dashboard');
                    }
                } else {
                    redirect('permission-denied');
                }
            }
            
            if($this->input->post('submit_first_punch_out')){
                if($isPermissionAttendanceEdit){
                    $workingID = $data['attendanceData']['working_id'];
                    $editData = array(
                        'working_end_time'=>currentTime(),
                        'punch_status'=>'true',
                    );
                    $editDataEntry = $this->DataModel->editData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE, $editData);
                    if($editDataEntry){
                        $this->session->set_userdata('session_attendance_employee_dashboard_first_punch_out_error','You have successfully punched out!');
                        redirect('employee-dashboard');
                    }
                } else {
                    redirect('permission-denied');
                }
            }
            
            if($this->input->post('submit_second_punch_in')){
                if($isPermissionAttendanceEdit){
                    $workingID = $data['attendanceData']['working_id'];
                    $workingStartTime = $data['attendanceData']['working_start_time'];
                    $editData = array(
                        'working_start_time'=>$workingStartTime . ", " . currentTime(),
                        'punch_status'=>'false',
                    );
                    $editDataEntry = $this->DataModel->editData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE, $editData);
                    if($editDataEntry){
                        $this->session->set_userdata('session_attendance_employee_dashboard_second_punch_in_success','You have successfully punched in!');
                        redirect('employee-dashboard');
                    }
                } else {
                    redirect('permission-denied');
                }
            }
            
            if($this->input->post('submit_second_punch_out')){
                if($isPermissionAttendanceEdit){
                    $workingID = $data['attendanceData']['working_id'];
                    $workingEndTime = $data['attendanceData']['working_end_time'];
                    $editData = array(
                        'working_end_time'=>$workingEndTime . ", " . currentTime(),
                        'punch_status'=>'true',
                    );
                    $editDataEntry = $this->DataModel->editData('working_id = '.$workingID, HRM_ATTENDANCE_TABLE, $editData);
                    if($editDataEntry){
                        $this->session->set_userdata('session_attendance_employee_dashboard_second_punch_out_error','You have successfully punched out!');
                        redirect('employee-dashboard');
                    }
                } else {
                    redirect('permission-denied');
                }
            }
            
            if($this->input->post('submit_leave')){
                if($isPermissionLeaveAdd){
                    $leaveFromDate = $this->input->post('leave_from_date');
                    $leaveToDate = $this->input->post('leave_to_date');
                    $totalLeaveDays = calculateLeaveDays($leaveFromDate, $leaveToDate);
            
                    $newData = array(
                        'user_id'=>$this->session->userdata['user_id'],
                        'employee_id'=>$this->session->userdata['employee_id'],
                        'leave_date'=>todayDate(),
                        'leave_from_date'=>$this->input->post('leave_from_date'),
                        'leave_to_date'=>$this->input->post('leave_to_date'),
                        'leave_from_time'=>$this->input->post('leave_from_time'),
                        'leave_to_time'=>$this->input->post('leave_to_time'),
                        'leave_days'=>$this->input->post('leave_days'),
                        'leave_reason'=>$this->input->post('leave_reason'),
                        'leave_type'=>$this->input->post('leave_type'),
                        'is_leave'=> 'pending',
                        'trash_status'=> 'false',
                    );
                    $lastInsertedID = $this->DataModel->insertData(HRM_LEAVE_TABLE, $newData);
                    if($lastInsertedID){
                        if($this->input->post('leave_days') == 'full'){
                            $editData = array(
                                'leave_days' =>$totalLeaveDays,
                            );
                            $editDataEntry = $this->DataModel->editData('leave_id = '.$lastInsertedID, HRM_LEAVE_TABLE, $editData);
                        }
                        $this->session->set_userdata('session_leave_employee_dashboard_success','Your leave has been sent successfully!');
                        redirect('employee-dashboard');
                    }
                } else {
                    redirect('permission-denied');
                }
            }
        } else {
            redirect('logout');
        }
	}
	
	public function theme(){
		$isLogin = checkAuth();
        if($isLogin == "True"){
            if($this->session->userdata['theme_mode'] == "light"){
               	$this->session->set_userdata('theme_mode', "dark");
            } else {
                $this->session->set_userdata('theme_mode', "light");
            }
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    redirect('dashboard');
                } else {
                    redirect('employee-dashboard');
                }
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
	}
}