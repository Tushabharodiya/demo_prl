<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|-------------------------------------------------------------------------------
| Display Debug backtrace
|-------------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|-------------------------------------------------------------------------------
| File and Directory Modes
|-------------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|-------------------------------------------------------------------------------
| File Stream Modes
|-------------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|-------------------------------------------------------------------------------
| Exit Status Codes
|-------------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// =============================================================================
// ================================ Panel Setting ==============================
// =============================================================================
/* AWS Setting */
define("S3_REGION", "ap-south-1");
define("S3_SECRET", "135AegeYZSSn6kHOU0ospt8WdFCD6NIpzSubiIZD");
define("BUCKET_NAME", "dummy-datas-bucket");
define("IMAGE_PATH", "images/");

/* Common Setting */
define("URL", "https://syphnosys.com/portal/");
define("COPYRIGHT", "Copyright © 2019-2025 Reserved By - Syphnosys Technology Private Limited.");
define("TITLE", "Portal Panel");
define("OTP", "admin");
define("AUTH_KEY", "5926478023654985");

/* Database Setting */
define("HOST", "localhost");
define("USER", "syphnosy_root");
define("PASS", 'SYS@dev#web#cloud#12');
define("DB", "syphnosys_portal");

// =============================================================================
// ================================ Gmail Setting ==============================
// =============================================================================
define("USER_NAME", "Syphnosys Technology Private Limited");
define("USER_EMAIL", "noreply.syphnosys@gmail.com");
define("USER_PASSWORD", "flslfpxrvaltqptx");

// =============================================================================
// ================================ Company Setting ============================
// =============================================================================
define("BREAK_TIME", "30 min");
define("WORKING_HOURS", "8");
define("OVERTIME_MINUTE", "15");

// =============================================================================
// ================================ Director Setting ===========================
// =============================================================================
define("DIRECTOR_1_NAME", "Vipulkumar Vadodariya");
define("DIRECTOR_1_ADDRESS", "<p>Vipulkumar Arjanbhai Vadodariya</p><p>115, Radhe Park Society, Near Tirupati Society, Yogichowk, Surat - 395010.</p>");
define("DIRECTOR_2_NAME", "Akshay Dabhoya");
define("DIRECTOR_2_ADDRESS", "<p>Akshay Ishwarbhai Dabhoya</p><p>C-103, Manki Residency, Near Welcome Residency, Amroli, Variyav, Surat - 394107.</p>");

// =============================================================================
// ========================== Permission Alias Setting =========================
// =============================================================================
// --------------------------------- Dashbaord ------------------------------ //
// Dashbaord Alias
define("ADMIN_DASHBOARD_ALIAS", "admin_dashboard_alias");
define("EMPLOYEE_DASHBOARD_ALIAS", "employee_dashboard_alias");
define("USER_LOGOUT_ALIAS", "user_logout_alias");

// --------------------------------- Invoice -------------------------------- //
// Publisher Alias
define("PUBLISHER_ALIAS", "publisher_alias");
define("PUBLISHER_TOTAL_ALIAS", "publisher_total_alias");
define("PUBLISHER_ACTIVE_ALIAS", "publisher_active_alias");
define("PUBLISHER_BLOCKED_ALIAS", "publisher_blocked_alias");

// Advertiser Alias
define("ADVERTISER_ALIAS", "advertiser_alias");
define("ADVERTISER_TOTAL_ALIAS", "advertiser_total_alias");
define("ADVERTISER_ACTIVE_ALIAS", "advertiser_active_alias");
define("ADVERTISER_BLOCKED_ALIAS", "advertiser_blocked_alias");

// Invoice Alias
define("INVOICE_ALIAS", "invoice_alias");
define("INVOICE_TOTAL_ALIAS", "invoice_total_alias");
define("INVOICE_ACTIVE_ALIAS", "invoice_active_alias");
define("INVOICE_BLOCKED_ALIAS", "invoice_blocked_alias"); 

// ---------------------------------- SOP ----------------------------------- //
// Procedure Alias
define("SOP_PROCEDURE_ALIAS", "sop_procedure_alias");
define("SOP_PROCEDURE_TOTAL_ALIAS", "sop_procedure_total_alias");
define("SOP_PROCEDURE_TRUE_ALIAS", "sop_procedure_true_alias");
define("SOP_PROCEDURE_FALSE_ALIAS", "sop_procedure_false_alias");

// Department Alias
define("SOP_DEPARTMENT_ALIAS", "sop_department_alias");

// User Alias
define("SOP_USER_ALIAS", "sop_user_alias");

// ---------------------------------- HRM ----------------------------------- //
// Employee Alias
define("HRM_EMPLOYEE_ALIAS", "hrm_employee_alias");

define("HRM_EMPLOYEE_TOTAL_ALIAS", "hrm_employee_total_alias");

define("HRM_EMPLOYEE_INTERN_ALIAS", "hrm_employee_intern_alias");
define("HRM_EMPLOYEE_EMPLOYEE_ALIAS", "hrm_employee_employee_alias");

define("HRM_EMPLOYEE_PENDING_ALIAS", "hrm_employee_pending_alias");
define("HRM_EMPLOYEE_SELECTED_ALIAS", "hrm_employee_selected_alias");
define("HRM_EMPLOYEE_REJECTED_ALIAS", "hrm_employee_rejected_alias");

define("HRM_EMPLOYEE_DRAFT_ALIAS", "hrm_employee_draft_alias");
define("HRM_EMPLOYEE_ACTIVE_ALIAS", "hrm_employee_active_alias");
define("HRM_EMPLOYEE_INACTIVE_ALIAS", "hrm_employee_inactive_alias");

define("HRM_EMPLOYEE_SELECTION_ALIAS", "hrm_employee_selection_alias");
define("HRM_EMPLOYEE_PHOTO_ALIAS", "hrm_employee_photo_alias");
define("HRM_EMPLOYEE_REVIEW_ALIAS", "hrm_employee_review_alias");

define("HRM_EMPLOYEE_HR_REVIEW_ALIAS", "hrm_employee_hr_review_alias");
define("HRM_EMPLOYEE_ADMIN_REVIEW_ALIAS", "hrm_employee_admin_review_alias");
define("HRM_EMPLOYEE_TECHNICAL_REVIEW_ALIAS", "hrm_employee_technical_review_alias");

// Attendance Alias
define("HRM_ATTENDANCE_ADMIN_ALIAS", "hrm_attendance_admin_alias");
define("HRM_ATTENDANCE_ADMIN_TOTAL_ALIAS", "hrm_attendance_admin_total_alias");
define("HRM_ATTENDANCE_ADMIN_PENDING_ALIAS", "hrm_attendance_admin_pending_alias");
define("HRM_ATTENDANCE_ADMIN_APPROVED_ALIAS", "hrm_attendance_admin_approved_alias");
define("HRM_ATTENDANCE_ADMIN_REJECTED_ALIAS", "hrm_attendance_admin_rejected_alias");

define("HRM_ATTENDANCE_EMPLOYEE_ALIAS", "hrm_attendance_employee_alias");

// Leave Alias
define("HRM_LEAVE_ADMIN_ALIAS", "hrm_leave_admin_alias");
define("HRM_LEAVE_ADMIN_TOTAL_ALIAS", "hrm_leave_admin_total_alias");
define("HRM_LEAVE_ADMIN_FULL_ALIAS", "hrm_leave_admin_full_alias");
define("HRM_LEAVE_ADMIN_HALF_ALIAS", "hrm_leave_admin_half_alias");
define("HRM_LEAVE_ADMIN_SHORT_ALIAS", "hrm_leave_admin_short_alias");
define("HRM_LEAVE_ADMIN_PENDING_ALIAS", "hrm_leave_admin_pending_alias");
define("HRM_LEAVE_ADMIN_APPROVED_ALIAS", "hrm_leave_admin_approved_alias");
define("HRM_LEAVE_ADMIN_REJECTED_ALIAS", "hrm_leave_admin_rejected_alias");
define("HRM_LEAVE_ADMIN_CANCELLED_ALIAS", "hrm_leave_admin_cancelled_alias");

define("HRM_LEAVE_EMPLOYEE_ALIAS", "hrm_leave_employee_alias");

// Holiday Alias
define("HRM_HOLIDAY_ALIAS", "hrm_holiday_alias");

// Event Alias
define("HRM_EVENT_ALIAS", "hrm_event_alias");

// Reporting Alias
define("HRM_REPORTING_ADMIN_ALIAS", "hrm_reporting_admin_alias");
define("HRM_REPORTING_EMPLOYEE_ALIAS", "hrm_reporting_employee_alias");

// Salary Slip Alias
define("HRM_SALARY_ALIAS", "hrm_salary_alias");
define("HRM_SALARY_EMAIL_ALIAS", "hrm_salary_email_alias");
define("HRM_SALARY_TOTAL_ALIAS", "hrm_salary_total_alias");
define("HRM_SALARY_PENDING_ALIAS", "hrm_salary_pending_alias");
define("HRM_SALARY_SENDING_ALIAS", "hrm_salary_sending_alias");

// System Alias
define("HRM_SYSTEM_ALIAS", "hrm_system_alias");

// Device Alias
define("HRM_DEVICE_ALIAS", "hrm_device_alias");

// Gmail Alias
define("HRM_GMAIL_ALIAS", "hrm_gmail_alias");

// ------------------------------- HRM LETTER ------------------------------- //
// On Boarding Letters Alias
define("HRM_ONBOARDING_LETTERS_ALIAS", "hrm_onboarding_letters_alias");

// On Employee Alias
define("HRM_INTERN_OFFER_ALIAS", "hrm_intern_offer_alias");
define("HRM_INTERN_OFFER_EMAIL_ALIAS", "hrm_intern_offer_email_alias");
define("HRM_INTERNSHIP_CERTIFICATE_ALIAS", "hrm_internship_certificate_alias");
define("HRM_EMPLOYEE_OFFER_ALIAS", "hrm_employee_offer_alias");
define("HRM_EMPLOYEE_OFFER_EMAIL_ALIAS", "hrm_employee_offer_email_alias");
define("HRM_APPRAISAL_CERTIFICATE_ALIAS", "hrm_appraisal_certificate_alias");
define("HRM_APPRAISAL_CERTIFICATE_EMAIL_ALIAS", "hrm_appraisal_certificate_email_alias");
define("HRM_WARNING_MAIL_ALIAS", "hrm_warning_mail_alias");
define("HRM_WARNING_MAIL_EMAIL_ALIAS", "hrm_warning_mail_email_alias");

// On Company Alias
define("HRM_APPOINTMENT_ALIAS", "hrm_appointment_alias");
define("HRM_HR_POLICY_ALIAS", "hrm_hr_policy_alias");
define("HRM_DECLARATION_ALIAS", "hrm_declaration_alias");
define("HRM_CONSENT_ALIAS", "hrm_consent_alias");

// On Agreement Alias
define("HRM_NON_DISCLOSURE_AGREEMENT_ALIAS", "hrm_non_disclosure_agreement_alias");
define("HRM_SERVICE_AGREEMENT_ALIAS", "hrm_service_agreement_alias");

// Off Boarding Letters Alias
define("HRM_OFFBOARDING_LETTERS_ALIAS", "hrm_offboarding_letters_alias");

// Off Employee Alias
define("HRM_NO_DUE_CERTIFICATE_ALIAS", "hrm_no_due_certificate_alias");
define("HRM_RELIEVING_ALIAS", "hrm_relieving_alias");
define("HRM_EXPERIENCE_ALIAS", "hrm_experience_alias");
define("HRM_TERMINATION_ALIAS", "hrm_termination_alias");
define("HRM_TERMINATION_EMAIL_ALIAS", "hrm_termination_email_alias");

// =============================================================================
// =============================== Table Setting ===============================
// =============================================================================
// Session Settings
define("SESSION_TABLE", "ci_sessions");

// Invoice Table
define("PUBLISHER_TABLE", "inv_publisher");
define("ADVERTISER_TABLE", "inv_advertiser");
define("INVOICE_TABLE", "inv_invoice");

// SOP Table
define("SOP_PROCEDURE_TABLE", "sop_procedure");
define("SOP_IMAGE_TABLE", "sop_image");
define("SOP_DEPARTMENT_TABLE", "sop_department");
define("SOP_USER_TABLE", "sop_user");

// HRM Table
define("HRM_EMPLOYEE_TABLE", "hrm_employee");
define("HRM_ATTENDANCE_TABLE", "hrm_attendance");
define("HRM_LEAVE_TABLE", "hrm_leave");
define("HRM_HOLIDAY_TABLE", "hrm_holiday");
define("HRM_EVENT_TABLE", "hrm_event");
define("HRM_REPORTING_TABLE", "hrm_reporting");
define("HRM_SALARY_TABLE", "hrm_salary");
define("HRM_SYSTEM_TABLE", "hrm_system");
define("HRM_DEVICE_TABLE", "hrm_device");
define("HRM_GMAIL_TABLE", "hrm_gmail");

define("HRM_ONBOARDING_LETTERS_TABLE", "hrm_onboarding_letters");

define("HRM_INTERN_OFFER_TABLE", "hrm_letter_intern_offer");
define("HRM_INTERNSHIP_CERTIFICATE_TABLE", "hrm_letter_internship_certificate");
define("HRM_EMPLOYEE_OFFER_TABLE", "hrm_letter_employee_offer");
define("HRM_APPRAISAL_CERTIFICATE_TABLE", "hrm_letter_appraisal_certificate");
define("HRM_WARNING_MAIL_TABLE", "hrm_letter_warning_mail");

define("HRM_APPOINTMENT_TABLE", "hrm_letter_appointment");
define("HRM_HR_POLICY_TABLE", "hrm_letter_hr_policy");
define("HRM_DECLARATION_TABLE", "hrm_letter_declaration");
define("HRM_CONSENT_TABLE", "hrm_letter_consent");

define("HRM_NON_DISCLOSURE_AGREEMENT_TABLE", "hrm_letter_non_disclosure_agreement");
define("HRM_SERVICE_AGREEMENT_TABLE", "hrm_letter_service_agreement");

define("HRM_OFFBOARDING_LETTERS_TABLE", "hrm_offboarding_letters");

define("HRM_NO_DUE_CERTIFICATE_TABLE", "hrm_letter_no_due_certificate");
define("HRM_RELIEVING_TABLE", "hrm_letter_relieving");
define("HRM_EXPERIENCE_TABLE", "hrm_letter_experience");
define("HRM_TERMINATION_TABLE", "hrm_letter_termination");

// Master Table
define("SUPER_USER_TABLE", "sys_zuser_super");
define("MASTER_USER_TABLE", "sys_zuser_master");
define("PERMISSION_USER_TABLE", "sys_permission_user");
define("PERMISSION_DEPARTMENT_TABLE", "sys_permission_department");
define("PERMISSION_MASTER_TABLE", "sys_permission_master");
define("PERMISSION_ALIAS_TABLE", "sys_permission_alias");
define("DEPARTMENT_TABLE", "sys_department");
define("IP_TABLE", "sys_allowed_ip");
define("LOGIN_DATA_TABLE", "sys_login_data");