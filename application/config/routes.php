<?php defined('BASEPATH') OR exit('No direct script access allowed');

// --------------------------------- Invoice -------------------------------- //
// Publisher Functions
$route['new-publisher'] = 'invoice/publisher/publisherNew';
$route['view-publisher'] = 'invoice/publisher/publisherView';
$route['view-publisher'.'/(:num)'] = 'invoice/publisher/publisherView/$1';
$route['edit-publisher'.'/(:any)'] = 'invoice/publisher/publisherEdit/$1';

// Advertiser Functions
$route['new-advertiser'] = 'invoice/advertiser/advertiserNew';
$route['view-advertiser'] = 'invoice/advertiser/advertiserView';
$route['view-advertiser'.'/(:num)'] = 'invoice/advertiser/advertiserView/$1';
$route['edit-advertiser'.'/(:any)'] = 'invoice/advertiser/advertiserEdit/$1';

// Invoice Functions
$route['new-invoice'] = 'invoice/invoice/invoiceNew';
$route['view-invoice'] = 'invoice/invoice/invoiceView';
$route['view-invoice'.'/(:num)'] = 'invoice/invoice/invoiceView/$1';
$route['detail-invoice'.'/(:any)'] = 'invoice/invoice/invoiceDetail/$1';
$route['edit-invoice'.'/(:any)'] = 'invoice/invoice/invoiceEdit/$1';
$route['trash-invoice'.'/(:any)'] = 'invoice/invoice/invoiceTrash/$1';
$route['view-trash-invoice'] = 'invoice/invoice/invoiceTrashView';
$route['view-trash-invoice'.'/(:num)'] = 'invoice/invoice/invoiceTrashView/$1';
$route['restore-invoice'.'/(:any)'] = 'invoice/invoice/invoiceRestore/$1';
$route['delete-invoice'.'/(:any)'] = 'invoice/invoice/invoiceDelete/$1';

// ----------------------------------- SOP ---------------------------------- //
// Procedure Functions
$route['new-sop-procedure'] = 'sop/procedure/procedureNew';
$route['view-sop-procedure'] = 'sop/procedure/procedureView';
$route['view-sop-procedure'.'/(:num)'] = 'sop/procedure/procedureView/$1';
$route['info-sop-image'.'/(:any)'] = 'sop/procedure/imageInfo/$1';
$route['delete-sop-image'] = 'sop/procedure/imageDelete/$1';
$route['info-sop-procedure'.'/(:any)'] = 'sop/procedure/procedureInfo/$1';
$route['edit-sop-procedure'.'/(:any)'] = 'sop/procedure/procedureEdit/$1';
$route['trash-sop-procedure'.'/(:any)'] = 'sop/procedure/procedureTrash/$1';
$route['view-trash-sop-procedure'] = 'sop/procedure/procedureTrashView';
$route['view-trash-sop-procedure'.'/(:num)'] = 'sop/procedure/procedureTrashView/$1';
$route['restore-sop-procedure'.'/(:any)'] = 'sop/procedure/procedureRestore/$1';
$route['delete-sop-procedure'.'/(:any)'] = 'sop/procedure/procedureDelete/$1';

// Department Functions
$route['new-sop-department'] = 'sop/department/departmentNew';
$route['view-sop-department'] = 'sop/department/departmentView';
$route['view-sop-department'.'/(:num)'] = 'sop/department/departmentView/$1';
$route['edit-sop-department'.'/(:any)'] = 'sop/department/departmentEdit/$1'; 
$route['trash-sop-department'.'/(:any)'] = 'sop/department/departmentTrash/$1';
$route['view-trash-sop-department'] = 'sop/department/departmentTrashView';
$route['view-trash-sop-department'.'/(:num)'] = 'sop/department/departmentTrashView/$1';
$route['restore-sop-department'.'/(:any)'] = 'sop/department/departmentRestore/$1';
$route['delete-sop-department'.'/(:any)'] = 'sop/department/departmentDelete/$1';

// User Functions
$route['new-sop-user'] = 'sop/user/userNew';
$route['view-sop-user'] = 'sop/user/userView';
$route['view-sop-user'.'/(:num)'] = 'sop/user/userView/$1';
$route['view-sop-user-procedure'.'/(:any)'] = 'sop/user/userProcedureView/$1';
$route['view-sop-user-procedure'.'/(:any)'.'/(:num)'] = 'sop/user/userProcedureView/$1/$2';
$route['info-sop-user-procedure'.'/(:any)'] = 'sop/user/userProcedureInfo/$1';
$route['edit-sop-user'.'/(:any)'] = 'sop/user/userEdit/$1';
$route['trash-sop-user'.'/(:any)'] = 'sop/user/userTrash/$1';
$route['view-trash-sop-user'] = 'sop/user/userTrashView';
$route['view-trash-sop-user'.'/(:num)'] = 'sop/user/userTrashView/$1';
$route['restore-sop-user'.'/(:any)'] = 'sop/user/userRestore/$1';
$route['delete-sop-user'.'/(:any)'] = 'sop/user/userDelete/$1';

// ----------------------------------- HRM ---------------------------------- //
// Employee Functions
$route['new-employee'] = 'hrm/employee/employeeNew';
$route['view-employee'] = 'hrm/employee/employeeView';
$route['view-employee'.'/(:num)'] = 'hrm/employee/employeeView/$1';
$route['edit-selection-employee'.'/(:any)'] = 'hrm/employee/employeeSelectionEdit/$1';
$route['edit-status-employee'.'/(:any)'] = 'hrm/employee/employeeStatusEdit/$1';
$route['edit-notice-period-employee'.'/(:any)'] = 'hrm/employee/employeeNoticePeriodEdit/$1';
$route['info-employee'.'/(:any)'] = 'hrm/employee/employeeInfo/$1';
$route['edit-employee'.'/(:any)'] = 'hrm/employee/employeeEdit/$1';
$route['trash-employee'.'/(:any)'] = 'hrm/employee/employeeTrash/$1';
$route['view-trash-employee'] = 'hrm/employee/employeeTrashView';
$route['view-trash-employee'.'/(:num)'] = 'hrm/employee/employeeTrashView/$1';
$route['restore-employee'.'/(:any)'] = 'hrm/employee/employeeRestore/$1';
$route['delete-employee'.'/(:any)'] = 'hrm/employee/employeeDelete/$1';

// Attendance Functions
$route['view-admin-attendance'] = 'hrm/attendance/attendanceAdminView';
$route['view-admin-attendance'.'/(:num)'] = 'hrm/attendance/attendanceAdminView/$1';
$route['edit-admin-attendance'.'/(:any)'] = 'hrm/attendance/attendanceAdminEdit/$1';
$route['trash-admin-attendance'.'/(:any)'] = 'hrm/attendance/attendanceAdminTrash/$1';
$route['view-trash-admin-attendance'] = 'hrm/attendance/attendanceAdminTrashView';
$route['view-trash-admin-attendance'.'/(:num)'] = 'hrm/attendance/attendanceAdminTrashView/$1';
$route['restore-admin-attendance'.'/(:any)'] = 'hrm/attendance/attendanceAdminRestore/$1';
$route['delete-admin-attendance'.'/(:any)'] = 'hrm/attendance/attendanceAdminDelete/$1';

$route['view-employee-attendance'] = 'hrm/attendance/attendanceEmployeeView';
$route['view-employee-attendance'.'/(:num)'] = 'hrm/attendance/attendanceEmployeeView/$1';

// Leave Functions
$route['view-admin-leave'] = 'hrm/leave/leaveAdminView';
$route['view-admin-leave'.'/(:num)'] = 'hrm/leave/leaveAdminView/$1';
$route['edit-admin-leave'.'/(:any)'] = 'hrm/leave/leaveAdminEdit/$1';
$route['trash-admin-leave'.'/(:any)'] = 'hrm/leave/leaveAdminTrash/$1';
$route['view-trash-admin-leave'] = 'hrm/leave/leaveAdminTrashView';
$route['view-trash-admin-leave'.'/(:num)'] = 'hrm/leave/leaveAdminTrashView/$1';
$route['restore-admin-leave'.'/(:any)'] = 'hrm/leave/leaveAdminRestore/$1';
$route['delete-admin-leave'.'/(:any)'] = 'hrm/leave/leaveAdminDelete/$1';

$route['new-employee-leave'] = 'hrm/leave/leaveEmployeeNew';
$route['view-employee-leave'] = 'hrm/leave/leaveEmployeeView';
$route['view-employee-leave'.'/(:num)'] = 'hrm/leave/leaveEmployeeView/$1';
$route['edit-employee-leave'.'/(:any)'] = 'hrm/leave/leaveEmployeeEdit/$1';

// Holiday Functions
$route['new-holiday'] = 'hrm/holiday/holidayNew';
$route['view-holiday'] = 'hrm/holiday/holidayView';
$route['view-holiday'.'/(:num)'] = 'hrm/holiday/holidayView/$1';
$route['edit-holiday'.'/(:any)'] = 'hrm/holiday/holidayEdit/$1';
$route['trash-holiday'.'/(:any)'] = 'hrm/holiday/holidayTrash/$1';
$route['view-trash-holiday'] = 'hrm/holiday/holidayTrashView';
$route['view-trash-holiday'.'/(:num)'] = 'hrm/holiday/holidayTrashView/$1';
$route['restore-holiday'.'/(:any)'] = 'hrm/holiday/holidayRestore/$1';
$route['delete-holiday'.'/(:any)'] = 'hrm/holiday/holidayDelete/$1';

// Event Functions
$route['new-event'] = 'hrm/event/eventNew';
$route['view-event'] = 'hrm/event/eventView';
$route['view-event'.'/(:num)'] = 'hrm/event/eventView/$1';

// Reporting Functions
$route['view-admin-reporting'] = 'hrm/reporting/reportingAdminView';
$route['view-admin-reporting'.'/(:num)'] = 'hrm/reporting/reportingAdminView/$1';
$route['trash-admin-reporting'.'/(:any)'] = 'hrm/reporting/reportingAdminTrash/$1';
$route['view-trash-admin-reporting'] = 'hrm/reporting/reportingAdminTrashView';
$route['view-trash-admin-reporting'.'/(:num)'] = 'hrm/reporting/reportingAdminTrashView/$1';
$route['restore-admin-reporting'.'/(:any)'] = 'hrm/reporting/reportingAdminRestore/$1';
$route['delete-admin-reporting'.'/(:any)'] = 'hrm/reporting/reportingAdminDelete/$1';

$route['new-employee-reporting'] = 'hrm/reporting/reportingEmployeeNew';
$route['view-employee-reporting'] = 'hrm/reporting/reportingEmployeeView';
$route['view-employee-reporting'.'/(:num)'] = 'hrm/reporting/reportingEmployeeView/$1';
$route['edit-employee-reporting'.'/(:any)'] = 'hrm/reporting/reportingEmployeeEdit/$1';

// Salary Functions
$route['new-salary'] = 'hrm/salary/salaryNew';
$route['view-salary'] = 'hrm/salary/salaryView';
$route['view-salary'.'/(:num)'] = 'hrm/salary/salaryView/$1';
$route['email-salary'.'/(:any)'] = 'hrm/salary/salaryEmail/$1';
$route['detail-salary'.'/(:any)'] = 'hrm/salary/salaryDetail/$1';
$route['edit-salary'.'/(:any)'] = 'hrm/salary/salaryEdit/$1';
$route['trash-salary'.'/(:any)'] = 'hrm/salary/salaryTrash/$1';
$route['view-trash-salary'] = 'hrm/salary/salaryTrashView';
$route['view-trash-salary'.'/(:num)'] = 'hrm/salary/salaryTrashView/$1';
$route['restore-salary'.'/(:any)'] = 'hrm/salary/salaryRestore/$1';
$route['delete-salary'.'/(:any)'] = 'hrm/salary/salaryDelete/$1';

// System Functions
$route['new-system'] = 'hrm/system/systemNew';
$route['view-system'] = 'hrm/system/systemView';
$route['view-system'.'/(:num)'] = 'hrm/system/systemView/$1';
$route['edit-system'.'/(:any)'] = 'hrm/system/systemEdit/$1';
$route['trash-system'.'/(:any)'] = 'hrm/system/systemTrash/$1';
$route['view-trash-system'] = 'hrm/system/systemTrashView';
$route['view-trash-system'.'/(:num)'] = 'hrm/system/systemTrashView/$1';
$route['restore-system'.'/(:any)'] = 'hrm/system/systemRestore/$1';
$route['delete-system'.'/(:any)'] = 'hrm/system/systemDelete/$1';

// Device Functions
$route['new-device'] = 'hrm/device/deviceNew';
$route['view-device'] = 'hrm/device/deviceView';
$route['view-device'.'/(:num)'] = 'hrm/device/deviceView/$1';
$route['edit-device'.'/(:any)'] = 'hrm/device/deviceEdit/$1';
$route['trash-device'.'/(:any)'] = 'hrm/device/deviceTrash/$1';
$route['view-trash-device'] = 'hrm/device/deviceTrashView';
$route['view-trash-device'.'/(:num)'] = 'hrm/device/deviceTrashView/$1';
$route['restore-device'.'/(:any)'] = 'hrm/device/deviceRestore/$1';
$route['delete-device'.'/(:any)'] = 'hrm/device/deviceDelete/$1';

// Gmail Functions
$route['new-gmail'] = 'hrm/gmail/gmailNew';
$route['view-gmail'] = 'hrm/gmail/gmailView';
$route['view-gmail'.'/(:num)'] = 'hrm/gmail/gmailView/$1';
$route['edit-gmail'.'/(:any)'] = 'hrm/gmail/gmailEdit/$1';
$route['trash-gmail'.'/(:any)'] = 'hrm/gmail/gmailTrash/$1';
$route['view-trash-gmail'] = 'hrm/gmail/gmailTrashView';
$route['view-trash-gmail'.'/(:num)'] = 'hrm/gmail/gmailTrashView/$1';
$route['restore-gmail'.'/(:any)'] = 'hrm/gmail/gmailRestore/$1';
$route['delete-gmail'.'/(:any)'] = 'hrm/gmail/gmailDelete/$1';

// Onboarding Letters Functions
$route['edit-onboarding-letters'.'/(:any)'] = 'hrm/onboarding/onboardingLettersEdit/$1';

// Intern Offer Functions
$route['new-intern-offer'] = 'hrm/internOffer/internOfferNew';
$route['view-intern-offer'] = 'hrm/internOffer/internOfferView';
$route['view-intern-offer'.'/(:num)'] = 'hrm/internOffer/internOfferView/$1';
$route['email-intern-offer'.'/(:any)'] = 'hrm/internOffer/internOfferEmail/$1';
$route['detail-intern-offer'.'/(:any)'] = 'hrm/internOffer/internOfferDetail/$1';
$route['pdf-intern-offer'.'/(:any)'] = 'hrm/internOffer/internOfferPdf/$1';
$route['edit-intern-offer'.'/(:any)'] = 'hrm/internOffer/internOfferEdit/$1';
$route['trash-intern-offer'.'/(:any)'] = 'hrm/internOffer/internOfferTrash/$1';
$route['view-trash-intern-offer'] = 'hrm/internOffer/internOfferTrashView';
$route['view-trash-intern-offer'.'/(:num)'] = 'hrm/internOffer/internOfferTrashView/$1';
$route['restore-intern-offer'.'/(:any)'] = 'hrm/internOffer/internOfferRestore/$1';
$route['delete-intern-offer'.'/(:any)'] = 'hrm/internOffer/internOfferDelete/$1';

// Internship Certificate Functions
$route['new-internship-certificate'] = 'hrm/internshipCertificate/internshipCertificateNew';
$route['view-internship-certificate'] = 'hrm/internshipCertificate/internshipCertificateView';
$route['view-internship-certificate'.'/(:num)'] = 'hrm/internshipCertificate/internshipCertificateView/$1';
$route['detail-internship-certificate'.'/(:any)'] = 'hrm/internshipCertificate/internshipCertificateDetail/$1';
$route['pdf-internship-certificate'.'/(:any)'] = 'hrm/internshipCertificate/internshipCertificatePdf/$1';
$route['edit-internship-certificate'.'/(:any)'] = 'hrm/internshipCertificate/internshipCertificateEdit/$1';
$route['trash-internship-certificate'.'/(:any)'] = 'hrm/internshipCertificate/internshipCertificateTrash/$1';
$route['view-trash-internship-certificate'] = 'hrm/internshipCertificate/internshipCertificateTrashView';
$route['view-trash-internship-certificate'.'/(:num)'] = 'hrm/internshipCertificate/internshipCertificateTrashView/$1';
$route['restore-internship-certificate'.'/(:any)'] = 'hrm/internshipCertificate/internshipCertificateRestore/$1';
$route['delete-internship-certificate'.'/(:any)'] = 'hrm/internshipCertificate/internshipCertificateDelete/$1';

// Employee Offer Functions
$route['new-employee-offer'] = 'hrm/employeeOffer/employeeOfferNew';
$route['view-employee-offer'] = 'hrm/employeeOffer/employeeOfferView';
$route['view-employee-offer'.'/(:num)'] = 'hrm/employeeOffer/employeeOfferView/$1';
$route['email-employee-offer'.'/(:any)'] = 'hrm/employeeOffer/employeeOfferEmail/$1';
$route['detail-employee-offer'.'/(:any)'] = 'hrm/employeeOffer/employeeOfferDetail/$1';
$route['pdf-employee-offer'.'/(:any)'] = 'hrm/employeeOffer/employeeOfferPdf/$1';
$route['edit-employee-offer'.'/(:any)'] = 'hrm/employeeOffer/employeeOfferEdit/$1';
$route['trash-employee-offer'.'/(:any)'] = 'hrm/employeeOffer/employeeOfferTrash/$1';
$route['view-trash-employee-offer'] = 'hrm/employeeOffer/employeeOfferTrashView';
$route['view-trash-employee-offer'.'/(:num)'] = 'hrm/employeeOffer/employeeOfferTrashView/$1';
$route['restore-employee-offer'.'/(:any)'] = 'hrm/employeeOffer/employeeOfferRestore/$1';
$route['delete-employee-offer'.'/(:any)'] = 'hrm/employeeOffer/employeeOfferDelete/$1';

// Appraisal Certificate Functions
$route['new-appraisal-certificate'] = 'hrm/appraisalCertificate/appraisalCertificateNew';
$route['view-appraisal-certificate'] = 'hrm/appraisalCertificate/appraisalCertificateView';
$route['view-appraisal-certificate'.'/(:num)'] = 'hrm/appraisalCertificate/appraisalCertificateView/$1';
$route['email-appraisal-certificate'.'/(:any)'] = 'hrm/appraisalCertificate/appraisalCertificateEmail/$1';
$route['detail-appraisal-certificate'.'/(:any)'] = 'hrm/appraisalCertificate/appraisalCertificateDetail/$1';
$route['pdf-appraisal-certificate'.'/(:any)'] = 'hrm/appraisalCertificate/appraisalCertificatePdf/$1';
$route['edit-appraisal-certificate'.'/(:any)'] = 'hrm/appraisalCertificate/appraisalCertificateEdit/$1';
$route['trash-appraisal-certificate'.'/(:any)'] = 'hrm/appraisalCertificate/appraisalCertificateTrash/$1';
$route['view-trash-appraisal-certificate'] = 'hrm/appraisalCertificate/appraisalCertificateTrashView';
$route['view-trash-appraisal-certificate'.'/(:num)'] = 'hrm/appraisalCertificate/appraisalCertificateTrashView/$1';
$route['restore-appraisal-certificate'.'/(:any)'] = 'hrm/appraisalCertificate/appraisalCertificateRestore/$1';
$route['delete-appraisal-certificate'.'/(:any)'] = 'hrm/appraisalCertificate/appraisalCertificateDelete/$1';

// Warning Mail Functions
$route['new-warning-mail'] = 'hrm/warningMail/warningMailNew';
$route['view-warning-mail'] = 'hrm/warningMail/warningMailView';
$route['view-warning-mail'.'/(:num)'] = 'hrm/warningMail/warningMailView/$1';
$route['email-warning-mail'.'/(:any)'] = 'hrm/warningMail/warningMailEmail/$1';
$route['detail-warning-mail'.'/(:any)'] = 'hrm/warningMail/warningMailDetail/$1';
$route['pdf-warning-mail'.'/(:any)'] = 'hrm/warningMail/warningMailPdf/$1';
$route['edit-warning-mail'.'/(:any)'] = 'hrm/warningMail/warningMailEdit/$1';
$route['trash-warning-mail'.'/(:any)'] = 'hrm/warningMail/warningMailTrash/$1';
$route['view-trash-warning-mail'] = 'hrm/warningMail/warningMailTrashView';
$route['view-trash-warning-mail'.'/(:num)'] = 'hrm/warningMail/warningMailTrashView/$1';
$route['restore-warning-mail'.'/(:any)'] = 'hrm/warningMail/warningMailRestore/$1';
$route['delete-warning-mail'.'/(:any)'] = 'hrm/warningMail/warningMailDelete/$1';

// Appointment Functions
$route['new-appointment'] = 'hrm/appointment/appointmentNew';
$route['view-appointment'] = 'hrm/appointment/appointmentView';
$route['view-appointment'.'/(:num)'] = 'hrm/appointment/appointmentView/$1';
$route['detail-appointment'.'/(:any)'] = 'hrm/appointment/appointmentDetail/$1';
$route['pdf-appointment'.'/(:any)'] = 'hrm/appointment/appointmentPdf/$1';
$route['edit-appointment'.'/(:any)'] = 'hrm/appointment/appointmentEdit/$1';
$route['trash-appointment'.'/(:any)'] = 'hrm/appointment/appointmentTrash/$1';
$route['view-trash-appointment'] = 'hrm/appointment/appointmentTrashView';
$route['view-trash-appointment'.'/(:num)'] = 'hrm/appointment/appointmentTrashView/$1';
$route['restore-appointment'.'/(:any)'] = 'hrm/appointment/appointmentRestore/$1';
$route['delete-appointment'.'/(:any)'] = 'hrm/appointment/appointmentDelete/$1';

// Hr Policy Functions
$route['new-hr-policy'] = 'hrm/hrPolicy/hrPolicyNew';
$route['view-hr-policy'] = 'hrm/hrPolicy/hrPolicyView';
$route['view-hr-policy'.'/(:num)'] = 'hrm/hrPolicy/hrPolicyView/$1';
$route['detail-hr-policy'.'/(:any)'] = 'hrm/hrPolicy/hrPolicyDetail/$1';
$route['pdf-hr-policy'.'/(:any)'] = 'hrm/hrPolicy/hrPolicyPdf/$1';
$route['edit-hr-policy'.'/(:any)'] = 'hrm/hrPolicy/hrPolicyEdit/$1';
$route['trash-hr-policy'.'/(:any)'] = 'hrm/hrPolicy/hrPolicyTrash/$1';
$route['view-trash-hr-policy'] = 'hrm/hrPolicy/hrPolicyTrashView';
$route['view-trash-hr-policy'.'/(:num)'] = 'hrm/hrPolicy/hrPolicyTrashView/$1';
$route['restore-hr-policy'.'/(:any)'] = 'hrm/hrPolicy/hrPolicyRestore/$1';
$route['delete-hr-policy'.'/(:any)'] = 'hrm/hrPolicy/hrPolicyDelete/$1';

// Declaration Functions
$route['new-declaration'] = 'hrm/declaration/declarationNew';
$route['view-declaration'] = 'hrm/declaration/declarationView';
$route['view-declaration'.'/(:num)'] = 'hrm/declaration/declarationView/$1';
$route['detail-declaration'.'/(:any)'] = 'hrm/declaration/declarationDetail/$1';
$route['pdf-declaration'.'/(:any)'] = 'hrm/declaration/declarationPdf/$1';
$route['edit-declaration'.'/(:any)'] = 'hrm/declaration/declarationEdit/$1';
$route['trash-declaration'.'/(:any)'] = 'hrm/declaration/declarationTrash/$1';
$route['view-trash-declaration'] = 'hrm/declaration/declarationTrashView';
$route['view-trash-declaration'.'/(:num)'] = 'hrm/declaration/declarationTrashView/$1';
$route['restore-declaration'.'/(:any)'] = 'hrm/declaration/declarationRestore/$1';
$route['delete-declaration'.'/(:any)'] = 'hrm/declaration/declarationDelete/$1';

// Consent Functions
$route['new-consent'] = 'hrm/consent/consentNew';
$route['view-consent'] = 'hrm/consent/consentView';
$route['view-consent'.'/(:num)'] = 'hrm/consent/cosentnView/$1';
$route['detail-consent'.'/(:any)'] = 'hrm/consent/consentDetail/$1';
$route['pdf-consent'.'/(:any)'] = 'hrm/consent/consentPdf/$1';
$route['edit-consent'.'/(:any)'] = 'hrm/consent/consentEdit/$1';
$route['trash-consent'.'/(:any)'] = 'hrm/consent/consentTrash/$1';
$route['view-trash-consent'] = 'hrm/consent/consentTrashView';
$route['view-trash-consent'.'/(:num)'] = 'hrm/consent/consentTrashView/$1';
$route['restore-consent'.'/(:any)'] = 'hrm/consent/consentRestore/$1';
$route['delete-consent'.'/(:any)'] = 'hrm/consent/consentDelete/$1';

// Non Disclosure Agreement Functions
$route['new-non-disclosure-agreement'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementNew';
$route['view-non-disclosure-agreement'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementView';
$route['view-non-disclosure-agreement'.'/(:num)'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementView/$1';
$route['detail-non-disclosure-agreement'.'/(:any)'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementDetail/$1';
$route['pdf-non-disclosure-agreement'.'/(:any)'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementPdf/$1';
$route['edit-non-disclosure-agreement'.'/(:any)'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementEdit/$1';
$route['trash-non-disclosure-agreement'.'/(:any)'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementTrash/$1';
$route['view-trash-non-disclosure-agreement'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementTrashView';
$route['view-trash-non-disclosure-agreement'.'/(:num)'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementTrashView/$1';
$route['restore-non-disclosure-agreement'.'/(:any)'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementRestore/$1';
$route['delete-non-disclosure-agreement'.'/(:any)'] = 'hrm/nonDisclosureAgreement/nonDisclosureAgreementDelete/$1';

// Service Agreement Functions
$route['new-service-agreement'] = 'hrm/serviceAgreement/serviceAgreementNew';
$route['view-service-agreement'] = 'hrm/serviceAgreement/serviceAgreementView';
$route['view-service-agreement'.'/(:num)'] = 'hrm/serviceAgreement/serviceAgreementView/$1';
$route['detail-service-agreement'.'/(:any)'] = 'hrm/serviceAgreement/serviceAgreementDetail/$1';
$route['pdf-service-agreement'.'/(:any)'] = 'hrm/serviceAgreement/serviceAgreementPdf/$1';
$route['edit-service-agreement'.'/(:any)'] = 'hrm/serviceAgreement/serviceAgreementEdit/$1';
$route['trash-service-agreement'.'/(:any)'] = 'hrm/serviceAgreement/serviceAgreementTrash/$1';
$route['view-trash-service-agreement'] = 'hrm/serviceAgreement/serviceAgreementTrashView';
$route['view-trash-service-agreement'.'/(:num)'] = 'hrm/serviceAgreement/serviceAgreementTrashView/$1';
$route['restore-service-agreement'.'/(:any)'] = 'hrm/serviceAgreement/serviceAgreementRestore/$1';
$route['delete-service-agreement'.'/(:any)'] = 'hrm/serviceAgreement/serviceAgreementDelete/$1';

// Offboarding Letters Functions
$route['edit-offboarding-letters'.'/(:any)'] = 'hrm/offboarding/offboardingLettersEdit/$1';

// No Due Certificate Functions
$route['new-no-due-certificate'] = 'hrm/noDueCertificate/noDueCertificateNew';
$route['view-no-due-certificate'] = 'hrm/noDueCertificate/noDueCertificateView';
$route['view-no-due-certificate'.'/(:num)'] = 'hrm/noDueCertificate/noDueCertificateView/$1';
$route['detail-no-due-certificate'.'/(:any)'] = 'hrm/noDueCertificate/noDueCertificateDetail/$1';
$route['pdf-no-due-certificate'.'/(:any)'] = 'hrm/noDueCertificate/noDueCertificatePdf/$1';
$route['edit-no-due-certificate'.'/(:any)'] = 'hrm/noDueCertificate/noDueCertificateEdit/$1';
$route['trash-no-due-certificate'.'/(:any)'] = 'hrm/noDueCertificate/noDueCertificateTrash/$1';
$route['view-trash-no-due-certificate'] = 'hrm/noDueCertificate/noDueCertificateTrashView';
$route['view-trash-no-due-certificate'.'/(:num)'] = 'hrm/noDueCertificate/noDueCertificateTrashView/$1';
$route['restore-no-due-certificate'.'/(:any)'] = 'hrm/noDueCertificate/noDueCertificateRestore/$1';
$route['delete-no-due-certificate'.'/(:any)'] = 'hrm/noDueCertificate/noDueCertificateDelete/$1';

// Relieving Functions
$route['new-relieving'] = 'hrm/relieving/relievingNew';
$route['view-relieving'] = 'hrm/relieving/relievingView';
$route['view-relieving'.'/(:num)'] = 'hrm/relieving/relievingView/$1';
$route['detail-relieving'.'/(:any)'] = 'hrm/relieving/relievingDetail/$1';
$route['pdf-relieving'.'/(:any)'] = 'hrm/relieving/relievingPdf/$1';
$route['edit-relieving'.'/(:any)'] = 'hrm/relieving/relievingEdit/$1';
$route['trash-relieving'.'/(:any)'] = 'hrm/relieving/relievingTrash/$1';
$route['view-trash-relieving'] = 'hrm/relieving/relievingTrashView';
$route['view-trash-relieving'.'/(:num)'] = 'hrm/relieving/relievingTrashView/$1';
$route['restore-relieving'.'/(:any)'] = 'hrm/relieving/relievingRestore/$1';
$route['delete-relieving'.'/(:any)'] = 'hrm/relieving/relievingDelete/$1';

// Experience Functions
$route['new-experience'] = 'hrm/experience/experienceNew';
$route['view-experience'] = 'hrm/experience/experienceView';
$route['view-experience'.'/(:num)'] = 'hrm/experience/experienceView/$1';
$route['detail-experience'.'/(:any)'] = 'hrm/experience/experienceDetail/$1';
$route['pdf-experience'.'/(:any)'] = 'hrm/experience/experiencePdf/$1';
$route['edit-experience'.'/(:any)'] = 'hrm/experience/experienceEdit/$1';
$route['trash-experience'.'/(:any)'] = 'hrm/experience/experienceTrash/$1';
$route['view-trash-experience'] = 'hrm/experience/experienceTrashView';
$route['view-trash-experience'.'/(:num)'] = 'hrm/experience/experienceTrashView/$1';
$route['restore-experience'.'/(:any)'] = 'hrm/experience/experienceRestore/$1';
$route['delete-experience'.'/(:any)'] = 'hrm/experience/experienceDelete/$1';

// Termination Functions
$route['new-termination'] = 'hrm/termination/terminationNew';
$route['view-termination'] = 'hrm/termination/terminationView';
$route['view-termination'.'/(:num)'] = 'hrm/termination/terminationView/$1';
$route['email-termination'.'/(:any)'] = 'hrm/termination/terminationEmail/$1';
$route['detail-termination'.'/(:any)'] = 'hrm/termination/terminationDetail/$1';
$route['pdf-termination'.'/(:any)'] = 'hrm/termination/terminationPdf/$1';
$route['edit-termination'.'/(:any)'] = 'hrm/termination/terminationEdit/$1';
$route['trash-termination'.'/(:any)'] = 'hrm/termination/terminationTrash/$1';
$route['view-trash-termination'] = 'hrm/termination/terminationTrashView';
$route['view-trash-termination'.'/(:num)'] = 'hrm/termination/terminationTrashView/$1';
$route['restore-termination'.'/(:any)'] = 'hrm/termination/terminationRestore/$1';
$route['delete-termination'.'/(:any)'] = 'hrm/termination/terminationDelete/$1';

// ----------------------------------- Master ------------------------------- //
// User Functions
$route['new-user'] = 'master/user/userNew';
$route['view-user'] = 'master/user/userView';
$route['view-user'.'/(:num)'] = 'master/user/userView/$1';
$route['view-department-user'.'/(:any)'] = 'master/user/departmentUserView/$1';
$route['view-department-user'.'/(:any)'.'/(:num)'] = 'master/user/departmentUserView/$1/$2';
$route['edit-user'.'/(:any)'] = 'master/user/userEdit/$1';
$route['user-profile'] = 'master/user/userProfile';
$route['trash-user'.'/(:any)'] = 'master/user/userTrash/$1';
$route['view-trash-user'] = 'master/user/userTrashView';
$route['view-trash-user'.'/(:num)'] = 'master/user/userTrashView/$1';
$route['restore-user'.'/(:any)'] = 'master/user/userRestore/$1';
$route['delete-user'.'/(:any)'] = 'master/user/userDelete/$1';

// Department Functions
$route['new-department'] = 'master/department/departmentNew';
$route['view-department'] = 'master/department/departmentView';
$route['view-department'.'/(:num)'] = 'master/department/departmentView/$1';
$route['edit-department'.'/(:any)'] = 'master/department/departmentEdit/$1';
$route['trash-department'.'/(:any)'] = 'master/department/departmentTrash/$1';
$route['view-trash-department'] = 'master/department/departmentTrashView';
$route['view-trash-department'.'/(:num)'] = 'master/department/departmentTrashView/$1';
$route['restore-department'.'/(:any)'] = 'master/department/departmentRestore/$1';
$route['delete-department'.'/(:any)'] = 'master/department/departmentDelete/$1';

// Permission Functions
$route['new-permission'] = 'master/permission/permissionNew';
$route['view-permission'] = 'master/permission/permissionView';
$route['view-permission'.'/(:num)'] = 'master/permission/permissionView/$1';
$route['view-alias-permission'.'/(:any)'] = 'master/permission/aliasPermissionView/$1';
$route['view-alias-permission'.'/(:any)'.'/(:num)'] = 'master/permission/aliasPermissionView/$1/$2';
$route['edit-permission'.'/(:any)'] = 'master/permission/permissionEdit/$1';
$route['department-rights'.'/(:any)'] = 'master/permission/departmentRights/$1';
$route['department-permission'.'/(:any)'] = 'master/permission/departmentPermission/$1';
$route['user-rights'.'/(:any)'] = 'master/permission/userRights/$1';
$route['user-permission'.'/(:any)'] = 'master/permission/userPermission/$1';

// Alias Functions
$route['new-alias'] = 'master/alias/aliasNew';
$route['view-alias'] = 'master/alias/aliasView';
$route['view-alias'.'/(:num)'] = 'master/alias/aliasView/$1';
$route['edit-alias'.'/(:any)'] = 'master/alias/aliasEdit/$1';

// Ip Functions
$route['new-ip'] = 'master/ip/ipNew';
$route['view-ip'] = 'master/ip/ipView';
$route['view-ip'.'/(:num)'] = 'master/ip/ipView/$1';
$route['edit-ip'.'/(:any)'] = 'master/ip/ipEdit/$1';
$route['trash-ip'.'/(:any)'] = 'master/ip/ipTrash/$1';
$route['view-trash-ip'] = 'master/ip/ipTrashView';
$route['view-trash-ip'.'/(:num)'] = 'master/ip/ipTrashView/$1';
$route['restore-ip'.'/(:any)'] = 'master/ip/ipRestore/$1';
$route['delete-ip'.'/(:any)'] = 'master/ip/ipDelete/$1';

// Login Functions
$route['login-history'] = 'master/user/loginHistory';
$route['login-history'.'/(:num)'] = 'master/user/loginHistory/$1';
$route['login-description'.'/(:any)'] = 'master/user/loginDescription/$1';
$route['login-activity'.'/(:any)'] = 'master/user/loginActivity/$1';
$route['login-activity'.'/(:any)'.'/(:num)'] = 'master/user/loginActivity/$1/$2';
$route['trash-login-history'.'/(:any)'] = 'master/user/loginHistoryTrash/$1';
$route['view-trash-login-history'] = 'master/user/loginHistoryTrashView';
$route['view-trash-login-history'.'/(:num)'] = 'master/user/loginHistoryTrashView/$1';
$route['restore-login-history'.'/(:any)'] = 'master/user/loginHistoryRestore/$1';
$route['delete-login-history'.'/(:any)'] = 'master/user/loginHistoryDelete/$1';

// Logout Functions
$route['user-logout'.'/(:any)'] = 'logout/userLogout/$1';
$route['logout-activity'] = 'logout/logoutActivity';

// Dashboard Functions 
$route['employee-dashboard'] = 'dashboard/employeeDashboard';

// Session Functions 
$route['unset-session'] = 'SessionUnsetter/unsetSession';

// Common Settings
$route['default_controller'] = 'dashboard';
$route['404_override'] = 'error404';
$route['permission-denied'] = 'error404/permissionDenied';
$route['ip-denied'] = 'error404/ipDenied';
$route['time-denied'] = 'error404/timeDenied';
$route['translate_uri_dashes'] = FALSE;