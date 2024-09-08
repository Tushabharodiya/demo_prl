<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <meta name="robots" content="noindex, nofollow" />
    
    <link rel="shortcut icon" href="<?php echo base_url(); ?>source/images/favicon.png">
    
    <title><?php echo TITLE; ?></title>
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>source/assets/css/style.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>source/assets/css/theme.css?ver=3.1.3">
    
    <script src="<?php echo base_url();?>source/js/bootsjs/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="<?php echo base_url();?>source/tinymce/js/tinymce/tinymce.css">
    <script src="<?php echo base_url(); ?>source/assets/js/example-toastr.js?ver=3.1.3"></script>
</head>

<?php
    if($this->session->userdata('panelLog') == ""){
        redirect('login');
    } else if($this->session->userdata('panelLog') == "FALSE"){
        redirect('confirmOTP');
    }
?>  

<?php
    // Invoice Alias
    $publisherAlias = $this->DataModel->userPermissionData(PUBLISHER_ALIAS);
    $advertiserAlias = $this->DataModel->userPermissionData(ADVERTISER_ALIAS);
    $invoiceAlias = $this->DataModel->userPermissionData(INVOICE_ALIAS);
    
    // SOP Alias
    $sopProcedureAlias = $this->DataModel->userPermissionData(SOP_PROCEDURE_ALIAS);
    $sopDepartmentAlias = $this->DataModel->userPermissionData(SOP_DEPARTMENT_ALIAS);
    $sopUserAlias = $this->DataModel->userPermissionData(SOP_USER_ALIAS);
    
    // HRM Alias
    $hrmEmployeeAlias = $this->DataModel->userPermissionData(HRM_EMPLOYEE_ALIAS);
    
    $hrmAttendanceAdminAlias = $this->DataModel->userPermissionData(HRM_ATTENDANCE_ADMIN_ALIAS);
    $hrmAttendanceEmployeeAlias = $this->DataModel->userPermissionData(HRM_ATTENDANCE_EMPLOYEE_ALIAS);
    
    $hrmLeaveAdminAlias = $this->DataModel->userPermissionData(HRM_LEAVE_ADMIN_ALIAS);
    $hrmLeaveEmployeeAlias = $this->DataModel->userPermissionData(HRM_LEAVE_EMPLOYEE_ALIAS);
    
    $hrmHolidayAlias = $this->DataModel->userPermissionData(HRM_HOLIDAY_ALIAS);
    
    $hrmEventAlias = $this->DataModel->userPermissionData(HRM_EVENT_ALIAS);
    
    $hrmReportingAdminAlias = $this->DataModel->userPermissionData(HRM_REPORTING_ADMIN_ALIAS);
    $hrmReportingEmployeeAlias = $this->DataModel->userPermissionData(HRM_REPORTING_EMPLOYEE_ALIAS);
    
    $hrmSalaryAlias = $this->DataModel->userPermissionData(HRM_SALARY_ALIAS);
    
    $hrmSystemAlias = $this->DataModel->userPermissionData(HRM_SYSTEM_ALIAS);
    
    $hrmDeviceAlias = $this->DataModel->userPermissionData(HRM_DEVICE_ALIAS);
    
    $hrmGmailAlias = $this->DataModel->userPermissionData(HRM_GMAIL_ALIAS);
    
    $hrmOnboardingLettersAlias = $this->DataModel->userPermissionData(HRM_ONBOARDING_LETTERS_ALIAS);
    
    $hrmInternOfferAlias = $this->DataModel->userPermissionData(HRM_INTERN_OFFER_ALIAS);
    $hrmInternshipCertificateAlias = $this->DataModel->userPermissionData(HRM_INTERNSHIP_CERTIFICATE_ALIAS);
    $hrmEmployeeOfferAlias = $this->DataModel->userPermissionData(HRM_EMPLOYEE_OFFER_ALIAS);
    $hrmAppraisalCertificateAlias = $this->DataModel->userPermissionData(HRM_APPRAISAL_CERTIFICATE_ALIAS);
    $hrmWarningMailAlias = $this->DataModel->userPermissionData(HRM_WARNING_MAIL_ALIAS);
    
    $hrmAppointmentAlias = $this->DataModel->userPermissionData(HRM_APPOINTMENT_ALIAS);
    $hrmHrPolicyAlias = $this->DataModel->userPermissionData(HRM_HR_POLICY_ALIAS);
    $hrmDeclarationAlias = $this->DataModel->userPermissionData(HRM_DECLARATION_ALIAS);
    $hrmConsentAlias = $this->DataModel->userPermissionData(HRM_CONSENT_ALIAS);
    
    $hrmNonDisclosureAgreementAlias = $this->DataModel->userPermissionData(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS);
    $hrmServiceAgreementAlias = $this->DataModel->userPermissionData(HRM_SERVICE_AGREEMENT_ALIAS);
    
    $hrmOffboardingLettersAlias = $this->DataModel->userPermissionData(HRM_OFFBOARDING_LETTERS_ALIAS);
    
    $hrmNoDueCertificateAlias = $this->DataModel->userPermissionData(HRM_NO_DUE_CERTIFICATE_ALIAS);
    $hrmRelievingAlias = $this->DataModel->userPermissionData(HRM_RELIEVING_ALIAS);
    $hrmExperienceAlias = $this->DataModel->userPermissionData(HRM_EXPERIENCE_ALIAS);
    $hrmTerminationAlias = $this->DataModel->userPermissionData(HRM_EXPERIENCE_ALIAS);
?>

<?php if($this->session->userdata['theme_mode'] == "dark"){ ?>
    <body class="nk-body bg-white npc-default has-aside dark-mode">
<?php } else { ?>
    <body class="nk-body bg-white npc-default has-aside">
<?php } ?>
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-xxxl wide-xxxl">
                        <div class="nk-header-wrap">
                            <div class="nk-header-brand">
                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="logo-link">
                                    <img class="logo-light logo-img" src="<?php echo base_url(); ?>source/images/logo.png" srcset="<?php echo base_url(); ?>source/images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="<?php echo base_url(); ?>source/images/logo-dark.png" srcset="<?php echo base_url(); ?>source/images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div>
                            <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                    <div class="nk-header-menu">
                                        <ul class="nk-menu nk-menu-main">
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>dashboard" class="nk-menu-link">
                                                    <span class="nk-menu-text">Overview</span>
                                                </a>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">All Letters</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <?php $onboardingLetterID = 1; ?>
                                                    <li class="nk-menu-item has-sub">
                                                        <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                            <span class="nk-menu-text">On Employee</span>
                                                        </a>
                                                        <ul class="nk-menu-sub">
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=w1X1ASLRj6" class="nk-menu-link"><span class="nk-menu-text">Intern Offer</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=mpoUzGzAhJ" class="nk-menu-link"><span class="nk-menu-text">Internship Cert</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=CPym8M3Utz" class="nk-menu-link"><span class="nk-menu-text">Employee Offer</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=uc5E51X0JI" class="nk-menu-link"><span class="nk-menu-text">Appraisal Cert</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=wNVjmEb8uc" class="nk-menu-link"><span class="nk-menu-text">Warning Mail</span></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="nk-menu-item has-sub">
                                                        <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                            <span class="nk-menu-text">On Company</span>
                                                        </a>
                                                        <ul class="nk-menu-sub">
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=9L6yXxjDwb" class="nk-menu-link"><span class="nk-menu-text">Appointment</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=pBDy29Uv91" class="nk-menu-link"><span class="nk-menu-text">HR Policy</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=eUu1LYeZvN" class="nk-menu-link"><span class="nk-menu-text">Declaration</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=YslfKa8v2R" class="nk-menu-link"><span class="nk-menu-text">Consent</span></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="nk-menu-item has-sub">
                                                        <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                            <span class="nk-menu-text">On Agreement</span>
                                                        </a>
                                                        <ul class="nk-menu-sub">
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=xrIeDIEHW7" class="nk-menu-link"><span class="nk-menu-text">Non-Dis Agreement</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=Z9oA8eqyI3" class="nk-menu-link"><span class="nk-menu-text">Service Agreement</span></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <?php $offboardingLetterID = 1; ?>
                                                    <li class="nk-menu-item has-sub">
                                                        <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                            <span class="nk-menu-text">Off Employee</span>
                                                        </a>
                                                        <ul class="nk-menu-sub">
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-offboarding-letters/<?php echo urlEncodes($offboardingLetterID); ?>?param=vvcAX9Xtq0" class="nk-menu-link"><span class="nk-menu-text">No Due Certificate</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-offboarding-letters/<?php echo urlEncodes($offboardingLetterID); ?>?param=ZyC8C04vgG" class="nk-menu-link"><span class="nk-menu-text">Relieving</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-offboarding-letters/<?php echo urlEncodes($offboardingLetterID); ?>?param=EKhMYxkeLZ" class="nk-menu-link"><span class="nk-menu-text">Experience</span></a>
                                                            </li>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>edit-offboarding-letters/<?php echo urlEncodes($offboardingLetterID); ?>?param=C1IFWYxhVw" class="nk-menu-link"><span class="nk-menu-text">Termination</span></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">On-Employee</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-intern-offer" class="nk-menu-link"><span class="nk-menu-text">Intern Offer</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-internship-certificate" class="nk-menu-link"><span class="nk-menu-text">Internship Certificate</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-employee-offer" class="nk-menu-link"><span class="nk-menu-text">Employee Offer</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-appraisal-certificate" class="nk-menu-link"><span class="nk-menu-text">Appraisal Certificate</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-warning-mail" class="nk-menu-link"><span class="nk-menu-text">Warning Mail</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">On-Company</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-appointment" class="nk-menu-link"><span class="nk-menu-text">Appointment</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-hr-policy" class="nk-menu-link"><span class="nk-menu-text">HR Policy</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-declaration" class="nk-menu-link"><span class="nk-menu-text">Declaration</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-consent" class="nk-menu-link"><span class="nk-menu-text">Consent</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">On-Agreement</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-non-disclosure-agreement" class="nk-menu-link"><span class="nk-menu-text">Non-Dis Agreement</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-service-agreement" class="nk-menu-link"><span class="nk-menu-text">Service Agreement</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-text">Off-Employee</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-no-due-certificate" class="nk-menu-link"><span class="nk-menu-text">No Due Certificate</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-relieving" class="nk-menu-link"><span class="nk-menu-text">Relieving</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-experience" class="nk-menu-link"><span class="nk-menu-text">Experience</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url();?>view-termination" class="nk-menu-link"><span class="nk-menu-text">Termination</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } else { ?>
                                    <div class="nk-header-menu">
                                        <ul class="nk-menu nk-menu-main">
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>employee-dashboard" class="nk-menu-link">
                                                    <span class="nk-menu-text">Overview</span>
                                                </a>
                                            </li>
                                            <?php if(!empty($hrmOnboardingLettersAlias) or !empty($hrmOffboardingLettersAlias)){ ?>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-text">All Letters</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php $onboardingLetterID = 1; ?>
                                                        <?php if(!empty($hrmOnboardingLettersAlias)){ ?>
                                                            <li class="nk-menu-item has-sub">
                                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                                    <span class="nk-menu-text">On Employee</span>
                                                                </a>
                                                                <ul class="nk-menu-sub">
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=w1X1ASLRj6" class="nk-menu-link"><span class="nk-menu-text">Intern Offer</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=mpoUzGzAhJ" class="nk-menu-link"><span class="nk-menu-text">Internship Cert</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=CPym8M3Utz" class="nk-menu-link"><span class="nk-menu-text">Employee Offer</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=uc5E51X0JI" class="nk-menu-link"><span class="nk-menu-text">Appraisal Cert</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=wNVjmEb8uc" class="nk-menu-link"><span class="nk-menu-text">Warning Mail</span></a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmOnboardingLettersAlias)){ ?>
                                                            <li class="nk-menu-item has-sub">
                                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                                    <span class="nk-menu-text">On Company</span>
                                                                </a>
                                                                <ul class="nk-menu-sub">
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=9L6yXxjDwb" class="nk-menu-link"><span class="nk-menu-text">Appointment</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=pBDy29Uv91" class="nk-menu-link"><span class="nk-menu-text">HR Policy</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=eUu1LYeZvN" class="nk-menu-link"><span class="nk-menu-text">Declaration</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=YslfKa8v2R" class="nk-menu-link"><span class="nk-menu-text">Consent</span></a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmOnboardingLettersAlias)){ ?>
                                                            <li class="nk-menu-item has-sub">
                                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                                    <span class="nk-menu-text">On Agreement</span>
                                                                </a>
                                                                <ul class="nk-menu-sub">
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=xrIeDIEHW7" class="nk-menu-link"><span class="nk-menu-text">Non-Dis Agreement</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-onboarding-letters/<?php echo urlEncodes($onboardingLetterID); ?>?param=Z9oA8eqyI3" class="nk-menu-link"><span class="nk-menu-text">Service Agreement</span></a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        <?php } ?>
                                                        <?php $offboardingLetterID = 1; ?>
                                                        <?php if(!empty($hrmOffboardingLettersAlias)){ ?>
                                                            <li class="nk-menu-item has-sub">
                                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                                    <span class="nk-menu-text">Off Employee</span>
                                                                </a>
                                                                <ul class="nk-menu-sub">
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-offboarding-letters/<?php echo urlEncodes($offboardingLetterID); ?>?param=vvcAX9Xtq0" class="nk-menu-link"><span class="nk-menu-text">No Due Certificate</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-offboarding-letters/<?php echo urlEncodes($offboardingLetterID); ?>?param=ZyC8C04vgG" class="nk-menu-link"><span class="nk-menu-text">Relieving</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-offboarding-letters/<?php echo urlEncodes($offboardingLetterID); ?>?param=EKhMYxkeLZ" class="nk-menu-link"><span class="nk-menu-text">Experience</span></a>
                                                                    </li>
                                                                    <li class="nk-menu-item">
                                                                        <a href="<?php echo base_url();?>edit-offboarding-letters/<?php echo urlEncodes($offboardingLetterID); ?>?param=C1IFWYxhVw" class="nk-menu-link"><span class="nk-menu-text">Termination</span></a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if(!empty($hrmInternOfferAlias) or !empty($hrmInternshipCertificateAlias) or !empty($hrmEmployeeOfferAlias) or !empty($hrmAppraisalCertificateAlias) or !empty($hrmWarningMailAlias)){ ?>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-text">On-Employee</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($hrmInternOfferAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-intern-offer" class="nk-menu-link"><span class="nk-menu-text">Intern Offer</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmInternshipCertificateAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-internship-certificate" class="nk-menu-link"><span class="nk-menu-text">Internship Certificate</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmEmployeeOfferAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-employee-offer" class="nk-menu-link"><span class="nk-menu-text">Employee Offer</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmAppraisalCertificateAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-appraisal-certificate" class="nk-menu-link"><span class="nk-menu-text">Appraisal Certificate</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmWarningMailAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-warning-mail" class="nk-menu-link"><span class="nk-menu-text">Warning Mail</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if(!empty($hrmAppointmentAlias) or !empty($hrmHrPolicyAlias) or !empty($hrmDeclarationAlias)or !empty($hrmConsentAlias)){ ?>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-text">On-Company</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($hrmAppointmentAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-appointment" class="nk-menu-link"><span class="nk-menu-text">Appointment</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmHrPolicyAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-hr-policy" class="nk-menu-link"><span class="nk-menu-text">HR Policy</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmDeclarationAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-declaration" class="nk-menu-link"><span class="nk-menu-text">Declaration</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmConsentAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-consent" class="nk-menu-link"><span class="nk-menu-text">Consent</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if(!empty($hrmNonDisclosureAgreementAlias) or !empty($hrmServiceAgreementAlias)){ ?>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-text">On-Agreement</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($hrmNonDisclosureAgreementAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-non-disclosure-agreement" class="nk-menu-link"><span class="nk-menu-text">Non-Dis Agreement</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmServiceAgreementAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-service-agreement" class="nk-menu-link"><span class="nk-menu-text">Service Agreement</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if(!empty($hrmNoDueCertificateAlias) or !empty($hrmRelievingAlias) or !empty($hrmExperienceAlias) or !empty($hrmTerminationAlias)){ ?>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-text">Off-Employee</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($hrmNoDueCertificateAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-no-due-certificate" class="nk-menu-link"><span class="nk-menu-text">No Due Certificate</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmRelievingAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-relieving" class="nk-menu-link"><span class="nk-menu-text">Relieving</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmExperienceAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-experience" class="nk-menu-link"><span class="nk-menu-text">Experience</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmTerminationAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url();?>view-termination" class="nk-menu-link"><span class="nk-menu-text">Termination</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle me-lg-n1" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-block d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <span><?php echo get_first_letters($this->session->userdata['user_name']); ?></span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?php if($this->session->userdata != null){ ?> <?php echo $this->session->userdata['user_name']; ?> <?php } ?></span>
                                                        <span class="sub-text"><?php if($this->session->userdata != null){ ?> <?php echo $this->session->userdata['user_email']; ?> <?php } ?></span>
                                                    </div>
                                                    <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                                        <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                            <div class="user-action">
                                                                <a class="btn btn-icon me-n2" href="<?php echo base_url(); ?>view-permission"><em class="icon ni ni-setting"></em></a>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="<?php echo base_url(); ?>user-profile"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                                    <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                                        <?php if($this->session->userdata['user_role'] == "Super"){ ?> 
                                                            <li><a href="<?php echo base_url(); ?>view-user"><em class="icon ni ni-user-list"></em><span>All User</span></a></li>
                                                            <li><a href="<?php echo base_url(); ?>login-history"><em class="icon ni ni-activity-alt"></em><span>Login History</span></a></li>
                                                            <li><a href="<?php echo base_url(); ?>view-ip"><em class="icon ni ni-map-pin"></em><span>Allowed IP</span></a></li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if($this->session->userdata['theme_mode'] == "dark"){ ?>
                                                        <li><a href="<?php echo base_url(); ?>dashboard/theme"><em class="icon ni ni-sun"></em><span>Light Mode</span></a></li>
                                                    <?php } else { ?>
                                                        <li><a href="<?php echo base_url(); ?>dashboard/theme"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                                    <?php } ?>
                                                    <li><a href="<?php echo base_url(); ?>unset-session"><em class="icon ni ni-reload-alt"></em></em><span>Refresh</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="<?php echo base_url(); ?>logout"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-lg-none">
                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="toggle nk-quick-nav-icon me-n1" data-target="sideNav"><em class="icon ni ni-menu"></em></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-xxxl wide-xxxl">
                        <div class="nk-content-inner">
                            <div class="nk-aside" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">
                                <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                    <?php if($this->session->userdata['user_role'] != "Super"){ ?> 
                                        <?php
                                            $masterUserData = $this->DataModel->getData('user_id = "'.$this->session->userdata['user_id'].'"', MASTER_USER_TABLE);
                                			$employeeID = $masterUserData['employee_id'];
                                			$employeeData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                                			$departmentData = $this->DataModel->getData('department_id = '.$employeeData['department_id'], DEPARTMENT_TABLE);
                                    	?>
                                        <div class="user-card user-card-s2 mb-3">
                                            <?php if(!empty($employeeData['employee_photo'] && $employeeData['employee_photo'] != "Unknown")){ ?>
                                                <div class="user-avatar sq lg bg-light">
                                                    <a class="gallery-image popup-image" href="<?php echo base_url();?>uploads/hrm/employee_photo/<?php echo $employeeData['employee_photo']; ?>">
                                                        <img src="<?php echo base_url();?>uploads/hrm/employee_photo/<?php echo $employeeData['employee_photo']; ?>">
                                                    </a>
                                                </div>
                                            <?php } else { ?>
                                                <div class="user-avatar sq lg bg-light">
                                                    <em class="icon ni ni-user-alt-fill"></em>
                                                </div>
                                            <?php } ?>
                                            <div class="user-info">
                                                <h6><?php echo $employeeData['employee_first_name']; ?> <?php echo $employeeData['employee_last_name']; ?></h6>
                                                <span class="sub-text"><?php echo $departmentData['department_name']; ?></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <div class="nk-sidebar-menu" data-simplebar>
                                    <ul class="nk-menu">
                                    <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                        <?php if($this->session->userdata['user_role'] == "Super"){ ?>  
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Dashboards</h6>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>dashboard" class="nk-menu-link">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span>
                                                    <span class="nk-menu-text">Dashboard</span>
                                                </a>
                                            </li>
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Invoice</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                                    <span class="nk-menu-text">Invoice</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-publisher" class="nk-menu-link"><span class="nk-menu-text">Publisher</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-advertiser" class="nk-menu-link"><span class="nk-menu-text">Advertiser</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-invoice" class="nk-menu-link"><span class="nk-menu-text">Invoice</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Sops</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-opt-dot-alt"></em></span>
                                                    <span class="nk-menu-text">Sops</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-sop-procedure" class="nk-menu-link"><span class="nk-menu-text">Procedure</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-sop-department" class="nk-menu-link"><span class="nk-menu-text">Department</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-sop-user" class="nk-menu-link"><span class="nk-menu-text">User</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">HRM</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-account-setting"></em></span>
                                                    <span class="nk-menu-text">HRM</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-employee" class="nk-menu-link"><span class="nk-menu-text">Employee</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-admin-attendance" class="nk-menu-link"><span class="nk-menu-text">Attendance</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-admin-leave" class="nk-menu-link"><span class="nk-menu-text">Leave</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-holiday" class="nk-menu-link"><span class="nk-menu-text">Holiday</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-event" class="nk-menu-link"><span class="nk-menu-text">Event</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-admin-reporting" class="nk-menu-link"><span class="nk-menu-text">Reporting</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-salary" class="nk-menu-link"><span class="nk-menu-text">Salary</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-system" class="nk-menu-link"><span class="nk-menu-text">System</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-device" class="nk-menu-link"><span class="nk-menu-text">Device</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-gmail" class="nk-menu-link"><span class="nk-menu-text">Gmail</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Master</h6>
                                            </li>
                                            <li class="nk-menu-item has-sub">
                                                <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                                    <span class="nk-menu-text">Master Settings</span>
                                                </a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-user" class="nk-menu-link"><span class="nk-menu-text">User Master</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-department" class="nk-menu-link"><span class="nk-menu-text">Department Master</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-permission" class="nk-menu-link"><span class="nk-menu-text">Permission Master</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo base_url(); ?>view-alias" class="nk-menu-link"><span class="nk-menu-text">Permission Alias</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php } else { ?>
                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt">Dashboards</h6>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="<?php echo base_url(); ?>employee-dashboard" class="nk-menu-link">
                                                    <span class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span>
                                                    <span class="nk-menu-text">Dashboard</span>
                                                </a>
                                            </li>
                                            <?php if(!empty($publisherAlias) or !empty($advertiserAlias) or !empty($invoiceAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">Invoice</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                                        <span class="nk-menu-text">Invoice</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($publisherAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-publisher" class="nk-menu-link"><span class="nk-menu-text">Publisher</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($advertiserAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-advertiser" class="nk-menu-link"><span class="nk-menu-text">Advertiser</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($invoiceAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-invoice" class="nk-menu-link"><span class="nk-menu-text">Invoice</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if(!empty($sopProcedureAlias) or !empty($sopDepartmentAlias) or !empty($sopUserAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">Sops</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-opt-dot-alt"></em></span>
                                                        <span class="nk-menu-text">Sops</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($sopProcedureAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-sop-procedure" class="nk-menu-link"><span class="nk-menu-text">Procedure</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($sopDepartmentAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-sop-department" class="nk-menu-link"><span class="nk-menu-text">Department</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($sopUserAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-sop-user" class="nk-menu-link"><span class="nk-menu-text">User</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if(!empty($hrmAttendanceEmployeeAlias) or !empty($hrmLeaveEmployeeAlias) or !empty($hrmHolidayAlias) or !empty($hrmReportingEmployeeAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">Employees</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                                        <span class="nk-menu-text">Employees</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($hrmAttendanceEmployeeAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-employee-attendance" class="nk-menu-link"><span class="nk-menu-text">Attendance</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmLeaveEmployeeAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-employee-leave" class="nk-menu-link"><span class="nk-menu-text">Leave</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmHolidayAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-holiday" class="nk-menu-link"><span class="nk-menu-text">Holiday</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmReportingEmployeeAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-employee-reporting" class="nk-menu-link"><span class="nk-menu-text">Reporting</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if(!empty($hrmEmployeeAlias) or !empty($hrmAttendanceAdminAlias) or !empty($hrmLeaveAdminAlias) or !empty($hrmEventAlias) or !empty($hrmReportingAdminAlias) or !empty($hrmSalaryAlias) or !empty($hrmSystemAlias) or !empty($hrmDeviceAlias) or !empty($hrmGmailAlias)){ ?>
                                                <li class="nk-menu-heading">
                                                    <h6 class="overline-title text-primary-alt">HR</h6>
                                                </li>
                                                <li class="nk-menu-item has-sub">
                                                    <a href="<?php echo base_url(); ?>#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
                                                        <span class="nk-menu-text">HR</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <?php if(!empty($hrmEmployeeAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-employee" class="nk-menu-link"><span class="nk-menu-text">Employee</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmAttendanceAdminAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-admin-attendance" class="nk-menu-link"><span class="nk-menu-text">Attendance</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmLeaveAdminAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-admin-leave" class="nk-menu-link"><span class="nk-menu-text">Leave</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmEventAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-event" class="nk-menu-link"><span class="nk-menu-text">Event</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmReportingAdminAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-admin-reporting" class="nk-menu-link"><span class="nk-menu-text">Reporting</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmSalaryAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-salary" class="nk-menu-link"><span class="nk-menu-text">Salary</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmSystemAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-system" class="nk-menu-link"><span class="nk-menu-text">System</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmDeviceAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-device" class="nk-menu-link"><span class="nk-menu-text">Device</span></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($hrmGmailAlias)){ ?>
                                                            <li class="nk-menu-item">
                                                                <a href="<?php echo base_url(); ?>view-gmail" class="nk-menu-link"><span class="nk-menu-text">Gmail</span></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    </ul>
                                </div>
                                <div class="nk-aside-close">
                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
                                </div>
                            </div>
                            <div class="nk-content-body">