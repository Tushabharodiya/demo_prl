<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SessionUnsetter extends CI_Controller {
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
	
	public function unsetSession(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $this->session->unset_userdata('session_publisher_view_previous_url');
            $this->session->unset_userdata('session_publisher');
            $this->session->unset_userdata('session_publisher_status');
            
            $this->session->unset_userdata('session_advertiser_view_previous_url');
            $this->session->unset_userdata('session_advertiser');
            $this->session->unset_userdata('session_advertiser_status');
            
            $this->session->unset_userdata('session_invoice_view_previous_url');
            $this->session->unset_userdata('session_invoice');
            $this->session->unset_userdata('session_invoice_status');
            
            $this->session->unset_userdata('session_invoice_trash_view_previous_url');
            $this->session->unset_userdata('session_invoice_trash');
            $this->session->unset_userdata('session_invoice_trash_status');
            
            $this->session->unset_userdata('session_sop_procedure_view_previous_url');
            $this->session->unset_userdata('session_sop_procedure');
            $this->session->unset_userdata('session_sop_procedure_status');
            
            $this->session->unset_userdata('session_sop_department_view_previous_url');
            $this->session->unset_userdata('session_sop_department');
            
            $this->session->unset_userdata('session_sop_user_procedure_view_previous_url');
            $this->session->unset_userdata('session_sop_user');
            $this->session->unset_userdata('session_sop_user_view_previous_url');
            
            $this->session->unset_userdata('session_employee_view_previous_url');
            $this->session->unset_userdata('session_employee');
            $this->session->unset_userdata('session_employee_is_employee');
            $this->session->unset_userdata('session_employee_type');
            $this->session->unset_userdata('session_employee_status');
            $this->session->unset_userdata('session_employee_created_start_date');
            $this->session->unset_userdata('session_employee_created_end_date');
            
            $this->session->unset_userdata('session_employee_trash_view_previous_url');
            $this->session->unset_userdata('session_employee_trash');
            $this->session->unset_userdata('session_employee_trash_is_employee');
            $this->session->unset_userdata('session_employee_trash_type');
            $this->session->unset_userdata('session_employee_trash_status');
            $this->session->unset_userdata('session_employee_trash_created_start_date');
            $this->session->unset_userdata('session_employee_trash_created_end_date');
            
            $this->session->unset_userdata('session_attendance_admin_view_previous_url');
            $this->session->unset_userdata('session_attendance_admin');
            $this->session->unset_userdata('session_attendance_admin_type');
            $this->session->unset_userdata('session_attendance_admin_status');
            $this->session->unset_userdata('session_attendance_admin_working_start_date');
            $this->session->unset_userdata('session_attendance_admin_working_end_date');
            
            $this->session->unset_userdata('session_attendance_admin_trash_view_previous_url');
            $this->session->unset_userdata('session_attendance_admin_trash');
            $this->session->unset_userdata('session_attendance_admin_trash_type');
            $this->session->unset_userdata('session_attendance_admin_trash_status');
            $this->session->unset_userdata('session_attendance_admin_trash_working_start_date');
            $this->session->unset_userdata('session_attendance_admin_trash_working_end_date');
            
            $this->session->unset_userdata('session_attendance_employee_view_previous_url');
            $this->session->unset_userdata('session_attendance_employee');
            $this->session->unset_userdata('session_attendance_employee_working_start_date');
            $this->session->unset_userdata('session_attendance_employee_working_end_date');
            
            $this->session->unset_userdata('session_leave_admin_view_previous_url');
            $this->session->unset_userdata('session_leave_admin');
            $this->session->unset_userdata('session_leave_admin_type');
            $this->session->unset_userdata('session_leave_admin_leave');
            $this->session->unset_userdata('session_leave_admin_status');
            $this->session->unset_userdata('session_leave_admin_from_start_date');
            $this->session->unset_userdata('session_leave_admin_from_end_date');
            
            $this->session->unset_userdata('session_leave_admin_trash_view_previous_url');
            $this->session->unset_userdata('session_leave_admin_trash');
            $this->session->unset_userdata('session_leave_admin_trash_type');
            $this->session->unset_userdata('session_leave_admin_trash_leave');
            $this->session->unset_userdata('session_leave_admin_trash_status');
            $this->session->unset_userdata('session_leave_admin_trash_from_start_date');
            $this->session->unset_userdata('session_leave_admin_trash_from_end_date');
            
            $this->session->unset_userdata('session_leave_employee_view_previous_url');
            $this->session->unset_userdata('session_leave_employee');
            $this->session->unset_userdata('session_leave_employee_type');
            $this->session->unset_userdata('session_leave_employee_leave');
            $this->session->unset_userdata('session_leave_employee_from_start_date');
            $this->session->unset_userdata('session_leave_employee_from_end_date');
            
            $this->session->unset_userdata('session_holiday_view_previous_url');
            $this->session->unset_userdata('session_holiday');
            $this->session->unset_userdata('session_holiday_type');
            
            $this->session->unset_userdata('session_holiday_trash_view_previous_url');
            $this->session->unset_userdata('session_holiday_trash');
            $this->session->unset_userdata('session_holiday_trash_type');
            
            $this->session->unset_userdata('session_reporting_admin_view_previous_url');
            $this->session->unset_userdata('session_reporting_admin');
            $this->session->unset_userdata('session_reporting_admin_type');
            $this->session->unset_userdata('session_reporting_admin_status');
            $this->session->unset_userdata('session_reporting_admin_reporting_start_date');
            $this->session->unset_userdata('session_reporting_admin_reporting_end_date');
            
            $this->session->unset_userdata('session_reporting_admin_trash_view_previous_url');
            $this->session->unset_userdata('session_reporting_admin_trash');
            $this->session->unset_userdata('session_reporting_admin_trash_type');
            $this->session->unset_userdata('session_reporting_admin_trash_status');
            $this->session->unset_userdata('session_reporting_admin_trash_reporting_start_date');
            $this->session->unset_userdata('session_reporting_admin_trash_reporting_end_date');
            
            $this->session->unset_userdata('session_reporting_employee_view_previous_url');
            $this->session->unset_userdata('session_reporting_employee');
            $this->session->unset_userdata('session_reporting_employee_type');
            $this->session->unset_userdata('session_reporting_employee_reporting_start_date');
            $this->session->unset_userdata('session_reporting_employee_reporting_end_date');

            $this->session->unset_userdata('session_salary_view_previous_url');
            $this->session->unset_userdata('session_salary');
            $this->session->unset_userdata('session_salary_email');
            $this->session->unset_userdata('session_salary_type');
            $this->session->unset_userdata('session_salary_status');
            
            $this->session->unset_userdata('session_salary_trash_view_previous_url');
            $this->session->unset_userdata('session_salary_trash');
            $this->session->unset_userdata('session_salary_trash_email');
            $this->session->unset_userdata('session_salary_trash_type');
            $this->session->unset_userdata('session_salary_trash_status');
            
            $this->session->unset_userdata('session_system_view_previous_url');
            $this->session->unset_userdata('session_system');
            $this->session->unset_userdata('session_system_status');
            
            $this->session->unset_userdata('session_system_trash_view_previous_url');
            $this->session->unset_userdata('session_system_trash');
            $this->session->unset_userdata('session_system_trash_status');
            
            $this->session->unset_userdata('session_device_view_previous_url');
            $this->session->unset_userdata('session_device');
            $this->session->unset_userdata('session_device_status');
            
            $this->session->unset_userdata('session_device_trash_view_previous_url');
            $this->session->unset_userdata('session_device_trash');
            $this->session->unset_userdata('session_device_trash_status');
            
            $this->session->unset_userdata('session_gmail_view_previous_url');
            $this->session->unset_userdata('session_gmail');
            $this->session->unset_userdata('session_gmail_status');
            
            $this->session->unset_userdata('session_gmail_trash_view_previous_url');
            $this->session->unset_userdata('session_gmail_trash');
            $this->session->unset_userdata('session_gmail_trash_status');
            
            $this->session->unset_userdata('session_intern_offer_view_previous_url');
            $this->session->unset_userdata('session_intern_offer');
            $this->session->unset_userdata('session_intern_offer_email');
            $this->session->unset_userdata('session_intern_offer_status');
            
            $this->session->unset_userdata('session_intern_offer_trash_view_previous_url');
            $this->session->unset_userdata('session_intern_offer_trash');
            $this->session->unset_userdata('session_intern_offer_trash_status');
            
            $this->session->unset_userdata('session_internship_certificate_view_previous_url');
            $this->session->unset_userdata('session_internship_certificate');
            $this->session->unset_userdata('session_internship_certificate_status');
            
            $this->session->unset_userdata('session_internship_certificate_trash_view_previous_url');
            $this->session->unset_userdata('session_internship_certificate_trash');
            $this->session->unset_userdata('session_internship_certificate_trash_status');
            
            $this->session->unset_userdata('session_employee_offer_view_previous_url');
            $this->session->unset_userdata('session_employee_offer');
            $this->session->unset_userdata('session_employee_offer_email');
            $this->session->unset_userdata('session_employee_offer_status');
            
            $this->session->unset_userdata('session_employee_offer_trash_view_previous_url');
            $this->session->unset_userdata('session_employee_offer_trash');
            $this->session->unset_userdata('session_employee_offer_trash_status');
            
            $this->session->unset_userdata('session_appraisal_certificate_view_previous_url');
            $this->session->unset_userdata('session_appraisal_certificate');
            $this->session->unset_userdata('session_appraisal_certificate_email');
            $this->session->unset_userdata('session_appraisal_certificate_status');
            
            $this->session->unset_userdata('session_appraisal_certificate_trash_view_previous_url');
            $this->session->unset_userdata('session_appraisal_certificate_trash');
            $this->session->unset_userdata('session_appraisal_certificate_trash_status');
            
            $this->session->unset_userdata('session_warning_mail_view_previous_url');
            $this->session->unset_userdata('session_warning_mail');
            $this->session->unset_userdata('session_warning_mail_email');
            $this->session->unset_userdata('session_warning_mail_status');
            
            $this->session->unset_userdata('session_warning_mail_trash_view_previous_url');
            $this->session->unset_userdata('session_warning_mail_trash');
            $this->session->unset_userdata('session_warning_mail_trash_status');
            
            $this->session->unset_userdata('session_appointment_view_previous_url');
            $this->session->unset_userdata('session_appointment');
            $this->session->unset_userdata('session_appointment_status');
            
            $this->session->unset_userdata('session_appointment_trash_view_previous_url');
            $this->session->unset_userdata('session_appointment_trash');
            $this->session->unset_userdata('session_appointment_trash_status');
            
            $this->session->unset_userdata('session_hr_policy_view_previous_url');
            $this->session->unset_userdata('session_hr_policy');
            $this->session->unset_userdata('session_hr_policy_type');
            $this->session->unset_userdata('session_hr_policy_status');
            
            $this->session->unset_userdata('session_hr_policy_trash_view_previous_url');
            $this->session->unset_userdata('session_hr_policy_trash');
            $this->session->unset_userdata('session_hr_policy_trash_type');
            $this->session->unset_userdata('session_hr_policy_trash_status');
            
            $this->session->unset_userdata('session_declaration_view_previous_url');
            $this->session->unset_userdata('session_declaration');
            $this->session->unset_userdata('session_declaration_type');
            $this->session->unset_userdata('session_declaration_status');
            
            $this->session->unset_userdata('session_declaration_trash_view_previous_url');
            $this->session->unset_userdata('session_declaration_trash');
            $this->session->unset_userdata('session_declaration_trash_type');
            $this->session->unset_userdata('session_declaration_trash_status');
                
            $this->session->unset_userdata('session_consent_view_previous_url');    
            $this->session->unset_userdata('session_consent');
            $this->session->unset_userdata('session_consent_status');
            
            $this->session->unset_userdata('session_consent_trash_view_previous_url');    
            $this->session->unset_userdata('session_consent_trash');
            $this->session->unset_userdata('session_consent_trash_status');
            
            $this->session->unset_userdata('session_non_disclosure_agreement_view_previous_url');
            $this->session->unset_userdata('session_non_disclosure_agreement');
            $this->session->unset_userdata('session_non_disclosure_agreement_type');
            $this->session->unset_userdata('session_non_disclosure_agreement_status');
            
            $this->session->unset_userdata('session_non_disclosure_agreement_trash_view_previous_url');
            $this->session->unset_userdata('session_non_disclosure_agreement_trash');
            $this->session->unset_userdata('session_non_disclosure_agreement_trash_type');
            $this->session->unset_userdata('session_non_disclosure_agreement_trash_status');
                
            $this->session->unset_userdata('session_service_agreement_view_previous_url');
            $this->session->unset_userdata('session_service_agreement');
            $this->session->unset_userdata('session_service_agreement_status');
            
            $this->session->unset_userdata('session_service_agreement_trash_view_previous_url');
            $this->session->unset_userdata('session_service_agreement_trash');
            $this->session->unset_userdata('session_service_agreement_trash_status');
            
            $this->session->unset_userdata('session_no_due_certificate_view_previous_url');
            $this->session->unset_userdata('session_no_due_certificate');
            $this->session->unset_userdata('session_no_due_certificate_status');
            
            $this->session->unset_userdata('session_no_due_certificate_trash_view_previous_url');
            $this->session->unset_userdata('session_no_due_certificate_trash');
            $this->session->unset_userdata('session_no_due_certificate_trash_status');
            
            $this->session->unset_userdata('session_relieving_view_previous_url');
            $this->session->unset_userdata('session_relieving');
            $this->session->unset_userdata('session_relieving_status');
            
            $this->session->unset_userdata('session_relieving_trash_view_previous_url');
            $this->session->unset_userdata('session_relieving_trash');
            $this->session->unset_userdata('session_relieving_trash_status');
            
            $this->session->unset_userdata('session_experience_view_previous_url');
            $this->session->unset_userdata('session_experience');
            $this->session->unset_userdata('session_experience_status');
            
            $this->session->unset_userdata('session_experience_trash_view_previous_url');
            $this->session->unset_userdata('session_experience_trash');
            $this->session->unset_userdata('session_experience_trash_status');
            
            $this->session->unset_userdata('session_termination_view_previous_url');
            $this->session->unset_userdata('session_termination');
            $this->session->unset_userdata('session_termination_email');
            $this->session->unset_userdata('session_termination_status');
            
            $this->session->unset_userdata('session_termination_trash_view_previous_url');
            $this->session->unset_userdata('session_termination_trash');
            $this->session->unset_userdata('session_termination_trash_status');
            
            $this->session->unset_userdata('session_alias_view_previous_url');
            $this->session->unset_userdata('session_alias');
            $this->session->unset_userdata('session_alias_status');
            
            $this->session->unset_userdata('session_department_view_previous_url');
            $this->session->unset_userdata('session_department');
            $this->session->unset_userdata('session_department_status');
            
            $this->session->unset_userdata('session_department_trash_view_previous_url');
            $this->session->unset_userdata('session_department_trash');
            $this->session->unset_userdata('session_department_trash_status');
            
            $this->session->unset_userdata('session_ip_view_previous_url');
            $this->session->unset_userdata('session_ip');
            $this->session->unset_userdata('session_ip_status');
            
            $this->session->unset_userdata('session_ip_trash_view_previous_url');
            $this->session->unset_userdata('session_ip_trash');
            $this->session->unset_userdata('session_ip_trash_status');
            
            $this->session->unset_userdata('session_permission_view_previous_url');
            $this->session->unset_userdata('session_permission');
            $this->session->unset_userdata('session_permission_status');
            $this->session->unset_userdata('session_alias_permission');
            $this->session->unset_userdata('session_alias_permission_status');
            
            $this->session->unset_userdata('session_user_view_previous_url');
            $this->session->unset_userdata('session_user');
            $this->session->unset_userdata('session_user_login');
            $this->session->unset_userdata('session_user_status');
            $this->session->unset_userdata('session_department_user');
            $this->session->unset_userdata('session_department_user_status');
            $this->session->unset_userdata('session_user_trash_view_previous_url');
            $this->session->unset_userdata('session_user_trash');
            $this->session->unset_userdata('session_user_trash_login');
            $this->session->unset_userdata('session_user_trash_status');
            $this->session->unset_userdata('session_login_history_view_previous_url');
            $this->session->unset_userdata('session_login_view_previous_url');
            $this->session->unset_userdata('session_login_history');
            $this->session->unset_userdata('session_login_activity');
            $this->session->unset_userdata('session_login_history_trash_view_previous_url');
            $this->session->unset_userdata('session_login_history_trash');
            
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