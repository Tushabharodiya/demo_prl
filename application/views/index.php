<?php
    $isAdminDashboardView = checkPermission(ADMIN_DASHBOARD_ALIAS, "can_view");
    
    $isUserLogoutEdit = checkPermission(USER_LOGOUT_ALIAS, "can_edit");
    
    $isPublisherTotalView = checkPermission(PUBLISHER_TOTAL_ALIAS, "can_view");
    $isPublisherTotalEdit = checkPermission(PUBLISHER_TOTAL_ALIAS, "can_edit");
    $isPublisherActiveView = checkPermission(PUBLISHER_ACTIVE_ALIAS, "can_view");
    $isPublisherActiveEdit = checkPermission(PUBLISHER_ACTIVE_ALIAS, "can_edit");
    $isPublisherBlockedView = checkPermission(PUBLISHER_BLOCKED_ALIAS, "can_view");
    $isPublisherBlockedEdit = checkPermission(PUBLISHER_BLOCKED_ALIAS, "can_edit");
    
    $isAdvertiserTotalView = checkPermission(ADVERTISER_TOTAL_ALIAS, "can_view");
    $isAdvertiserTotalEdit = checkPermission(ADVERTISER_TOTAL_ALIAS, "can_edit");
    $isAdvertiserActiveView = checkPermission(ADVERTISER_ACTIVE_ALIAS, "can_view");
    $isAdvertiserActiveEdit = checkPermission(ADVERTISER_ACTIVE_ALIAS, "can_edit");
    $isAdvertiserBlockedView = checkPermission(ADVERTISER_BLOCKED_ALIAS, "can_view");
    $isAdvertiserBlockedEdit = checkPermission(ADVERTISER_BLOCKED_ALIAS, "can_edit");
    
    $isInvoiceTotalView = checkPermission(INVOICE_TOTAL_ALIAS, "can_view");
    $isInvoiceTotalEdit = checkPermission(INVOICE_TOTAL_ALIAS, "can_edit");
    $isInvoiceActiveView = checkPermission(INVOICE_ACTIVE_ALIAS, "can_view");
    $isInvoiceActiveEdit = checkPermission(INVOICE_ACTIVE_ALIAS, "can_edit");
    $isInvoiceBlockedView = checkPermission(INVOICE_BLOCKED_ALIAS, "can_view");
    $isInvoiceBlockedEdit = checkPermission(INVOICE_BLOCKED_ALIAS, "can_edit");
    
    $isSopProcedureTotalView = checkPermission(SOP_PROCEDURE_TOTAL_ALIAS, "can_view");
    $isSopProcedureTotalEdit = checkPermission(SOP_PROCEDURE_TOTAL_ALIAS, "can_edit");
    $isSopProcedureTrueView = checkPermission(SOP_PROCEDURE_TRUE_ALIAS, "can_view");
    $isSopProcedureTrueEdit = checkPermission(SOP_PROCEDURE_TRUE_ALIAS, "can_edit");
    $isSopProcedureFalseView = checkPermission(SOP_PROCEDURE_FALSE_ALIAS, "can_view");
    $isSopProcedureFalseEdit = checkPermission(SOP_PROCEDURE_FALSE_ALIAS, "can_edit");
    
    $isSopDepartmentView = checkPermission(SOP_DEPARTMENT_ALIAS, "can_view");
    $isSopDepartmentEdit = checkPermission(SOP_DEPARTMENT_ALIAS, "can_edit");
    
    $isSopUserView = checkPermission(SOP_USER_ALIAS, "can_view");
    $isSopUserEdit = checkPermission(SOP_USER_ALIAS, "can_edit");
    
    $isHrmEmployeeTotalView = checkPermission(HRM_EMPLOYEE_TOTAL_ALIAS, "can_view");
    $isHrmEmployeeTotalEdit = checkPermission(HRM_EMPLOYEE_TOTAL_ALIAS, "can_edit");
    $isHrmEmployeeInternView = checkPermission(HRM_EMPLOYEE_INTERN_ALIAS, "can_view");
    $isHrmEmployeeInternEdit = checkPermission(HRM_EMPLOYEE_INTERN_ALIAS, "can_edit");
    $isHrmEmployeeEmployeeView = checkPermission(HRM_EMPLOYEE_EMPLOYEE_ALIAS, "can_view");
    $isHrmEmployeeEmployeeEdit = checkPermission(HRM_EMPLOYEE_EMPLOYEE_ALIAS, "can_edit");
    $isHrmEmployeePendingView = checkPermission(HRM_EMPLOYEE_PENDING_ALIAS, "can_view");
    $isHrmEmployeePendingEdit = checkPermission(HRM_EMPLOYEE_PENDING_ALIAS, "can_edit");
    $isHrmEmployeeSelectedView = checkPermission(HRM_EMPLOYEE_SELECTED_ALIAS, "can_view");
    $isHrmEmployeeSelectedEdit = checkPermission(HRM_EMPLOYEE_SELECTED_ALIAS, "can_edit");
    $isHrmEmployeeRejectedView = checkPermission(HRM_EMPLOYEE_REJECTED_ALIAS, "can_view");
    $isHrmEmployeeRejectedEdit = checkPermission(HRM_EMPLOYEE_REJECTED_ALIAS, "can_edit");
    $isHrmEmployeeDraftView = checkPermission(HRM_EMPLOYEE_DRAFT_ALIAS, "can_view");
    $isHrmEmployeeDraftEdit = checkPermission(HRM_EMPLOYEE_DRAFT_ALIAS, "can_edit");
    $isHrmEmployeeActiveView = checkPermission(HRM_EMPLOYEE_ACTIVE_ALIAS, "can_view");
    $isHrmEmployeeActiveEdit = checkPermission(HRM_EMPLOYEE_ACTIVE_ALIAS, "can_edit");
    $isHrmEmployeeInactiveView = checkPermission(HRM_EMPLOYEE_INACTIVE_ALIAS, "can_view");
    $isHrmEmployeeInactiveEdit = checkPermission(HRM_EMPLOYEE_INACTIVE_ALIAS, "can_edit");
    
    $isHrmAttendanceTotalView = checkPermission(HRM_ATTENDANCE_ADMIN_TOTAL_ALIAS, "can_view");
    $isHrmAttendanceTotalEdit = checkPermission(HRM_ATTENDANCE_ADMIN_TOTAL_ALIAS, "can_edit");
    $isHrmAttendancePendingView = checkPermission(HRM_ATTENDANCE_ADMIN_PENDING_ALIAS, "can_view");
    $isHrmAttendancePendingEdit = checkPermission(HRM_ATTENDANCE_ADMIN_PENDING_ALIAS, "can_edit");
    $isHrmAttendanceApprovedView = checkPermission(HRM_ATTENDANCE_ADMIN_APPROVED_ALIAS, "can_view");
    $isHrmAttendanceApprovedEdit = checkPermission(HRM_ATTENDANCE_ADMIN_APPROVED_ALIAS, "can_edit");
    $isHrmAttendanceRejectedView = checkPermission(HRM_ATTENDANCE_ADMIN_REJECTED_ALIAS, "can_view");
    $isHrmAttendanceRejectedEdit = checkPermission(HRM_ATTENDANCE_ADMIN_REJECTED_ALIAS, "can_edit");
    
    $isHrmLeaveTotalView = checkPermission(HRM_LEAVE_ADMIN_TOTAL_ALIAS, "can_view");
    $isHrmLeaveTotalEdit = checkPermission(HRM_LEAVE_ADMIN_TOTAL_ALIAS, "can_edit");
    $isHrmLeaveFullView = checkPermission(HRM_LEAVE_ADMIN_FULL_ALIAS, "can_view");
    $isHrmLeaveFullEdit = checkPermission(HRM_LEAVE_ADMIN_FULL_ALIAS, "can_edit");
    $isHrmLeaveHalfView = checkPermission(HRM_LEAVE_ADMIN_HALF_ALIAS, "can_view");
    $isHrmLeaveHalfEdit = checkPermission(HRM_LEAVE_ADMIN_HALF_ALIAS, "can_edit");
    $isHrmLeaveShortView = checkPermission(HRM_LEAVE_ADMIN_SHORT_ALIAS, "can_view");
    $isHrmLeaveShortEdit = checkPermission(HRM_LEAVE_ADMIN_SHORT_ALIAS, "can_edit");
    $isHrmLeavePendingView = checkPermission(HRM_LEAVE_ADMIN_PENDING_ALIAS, "can_view");
    $isHrmLeavePendingEdit = checkPermission(HRM_LEAVE_ADMIN_PENDING_ALIAS, "can_edit");
    $isHrmLeaveApprovedView = checkPermission(HRM_LEAVE_ADMIN_APPROVED_ALIAS, "can_view");
    $isHrmLeaveApprovedEdit = checkPermission(HRM_LEAVE_ADMIN_APPROVED_ALIAS, "can_edit");
    $isHrmLeaveRejectedView = checkPermission(HRM_LEAVE_ADMIN_REJECTED_ALIAS, "can_view");
    $isHrmLeaveRejectedEdit = checkPermission(HRM_LEAVE_ADMIN_REJECTED_ALIAS, "can_edit");
    $isHrmLeaveCancelledView = checkPermission(HRM_LEAVE_ADMIN_CANCELLED_ALIAS, "can_view");
    $isHrmLeaveCancelledEdit = checkPermission(HRM_LEAVE_ADMIN_CANCELLED_ALIAS, "can_edit");
    
    $isHrmSalaryTotalView = checkPermission(HRM_SALARY_TOTAL_ALIAS, "can_view");
    $isHrmSalaryTotalEdit = checkPermission(HRM_SALARY_TOTAL_ALIAS, "can_edit");
    $isHrmSalaryPendingView = checkPermission(HRM_SALARY_PENDING_ALIAS, "can_view");
    $isHrmSalaryPendingEdit = checkPermission(HRM_SALARY_PENDING_ALIAS, "can_edit");
    $isHrmSalarySendingView = checkPermission(HRM_SALARY_SENDING_ALIAS, "can_view");
    $isHrmSalarySendingEdit = checkPermission(HRM_SALARY_SENDING_ALIAS, "can_edit");
    
    $isHrmInternOfferView = checkPermission(HRM_INTERN_OFFER_ALIAS, "can_view");
    $isHrmInternOfferEdit = checkPermission(HRM_INTERN_OFFER_ALIAS, "can_edit");
    $isHrmInternshipCertificateView = checkPermission(HRM_INTERNSHIP_CERTIFICATE_ALIAS, "can_view");
    $isHrmInternshipCertificateEdit = checkPermission(HRM_INTERNSHIP_CERTIFICATE_ALIAS, "can_edit");
    $isHrmEmployeeOfferView = checkPermission(HRM_EMPLOYEE_OFFER_ALIAS, "can_view");
    $isHrmEmployeeOfferEdit = checkPermission(HRM_EMPLOYEE_OFFER_ALIAS, "can_edit");
    $isHrmAppraisalCertificateView = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_view");
    $isHrmAppraisalCertificateEdit = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_edit");
    $isHrmWarningMailView = checkPermission(HRM_WARNING_MAIL_ALIAS, "can_view");
    $isHrmWarningMailEdit = checkPermission(HRM_WARNING_MAIL_ALIAS, "can_edit");
    
    $isHrmAppointmentView = checkPermission(HRM_APPOINTMENT_ALIAS, "can_view");
    $isHrmAppointmentEdit = checkPermission(HRM_APPOINTMENT_ALIAS, "can_edit");
    $isHrmHrPolicyView = checkPermission(HRM_HR_POLICY_ALIAS, "can_view");
    $isHrmHrPolicyEdit = checkPermission(HRM_HR_POLICY_ALIAS, "can_edit");
    $isHrmDeclarationView = checkPermission(HRM_DECLARATION_ALIAS, "can_view");
    $isHrmDeclarationEdit = checkPermission(HRM_DECLARATION_ALIAS, "can_edit");
    $isHrmConsentView = checkPermission(HRM_CONSENT_ALIAS, "can_view");
    $isHrmConsentEdit = checkPermission(HRM_CONSENT_ALIAS, "can_edit");
    
    $isHrmNonDisclosureAgreementView = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_view");
    $isHrmNonDisclosureAgreementEdit = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_edit");
    $isHrmServiceAgreementView = checkPermission(HRM_SERVICE_AGREEMENT_ALIAS, "can_view");
    $isHrmServiceAgreementEdit = checkPermission(HRM_SERVICE_AGREEMENT_ALIAS, "can_edit");
    
    $isHrmNoDueCertificateView = checkPermission(HRM_NO_DUE_CERTIFICATE_ALIAS, "can_view");
    $isHrmNoDueCertificateEdit = checkPermission(HRM_NO_DUE_CERTIFICATE_ALIAS, "can_edit");
    $isHrmRelievingView = checkPermission(HRM_RELIEVING_ALIAS, "can_view");
    $isHrmRelievingEdit = checkPermission(HRM_RELIEVING_ALIAS, "can_edit");
    $isHrmExperienceView = checkPermission(HRM_EXPERIENCE_ALIAS, "can_view");
    $isHrmExperienceEdit = checkPermission(HRM_EXPERIENCE_ALIAS, "can_edit");
    $isHrmTerminationView = checkPermission(HRM_TERMINATION_ALIAS, "can_view");
    $isHrmTerminationEdit = checkPermission(HRM_TERMINATION_ALIAS, "can_edit");
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Hello, <?php if($this->session->userdata != null){ ?> <?php echo $this->session->userdata['user_name']; ?> <?php } ?></h3>
                    <div class="nk-block-des text-soft">
                        <p>Welcome to our dashboard. Manage your account.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isAdminDashboardView){ ?>
            <div class="nk-block nk-block-lg">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <ul class="nav nav-tabs mt-n3">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tabItemSession"><em class="icon ni ni-activity-round"></em><span>Active Session</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabItemInvoice"><em class="icon ni ni-tranx"></em><span>Invoice Dashboard</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabItemSop"><em class="icon ni ni-opt-dot-alt"></em><span>Sop Dashboard</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabItemHrm"><em class="icon ni ni-account-setting"></em><span>HRM Dashboard</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabItemSession">
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <h6 class="card-title">Active Sessions</h6>
                                            <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                    <div class="card-action">
                                                        <a href="<?php echo base_url(); ?>view-user" class="link link-sm">See All Users<em class="icon ni ni-chevron-right"></em></a>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-tranx">
                                            <thead>
                                                <tr class="tb-tnx-head">
                                                    <th width="10%"><span>#</span></th>
                                                    <th width="20%"><span>Name</span></th>
                                                    <th width="20%"><span>Email</span></th>
                                                    <th width="20%"><span>Role</span></th>
                                                    <th width="19%"><span>Login</span></th>
                                                    <th width="6%"><span>Is Login</span></th>
                                                    <th width="5%"><span>Logout</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($viewActiveLogin as $data){ ?>
                                                <tr class="tb-tnx-item">
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>"><span><?php echo $data['user_id']; ?></span></a>
                                                    </td>
                                                    <td>
                                                        <span><?php echo $data['user_name']; ?></span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo $data['user_email']; ?></span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo $data['user_role']; ?></span>
                                                    </td>
                                                    <td>
                                                       <span><?php echo $data['user_login']; ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-dot bg-success"><?php echo $data['is_login']; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if($isUserLogoutEdit){ ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#logoutModal<?php echo urlEncodes($data['user_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Logout">
                                                                <em class="icon ni ni-signout"></em>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" tabindex="-1" id="logoutModal<?php echo urlEncodes($data['user_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">User</h5>
                                                                <a href="<?php echo base_url(); ?>dashboard" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to logout <?php echo $data['user_name'];?>?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>user-logout/<?php echo urlEncodes($data['user_id']); ?>" class="btn btn-sm btn-danger submitBtn">Logout</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabItemInvoice">
                                <?php if(!empty($isPublisherTotalView) or !empty($isPublisherActiveView) or !empty($isPublisherBlockedView) or 
                                    !empty($isAdvertiserTotalView) or !empty($isAdvertiserActiveView) or !empty($isAdvertiserBlockedView) or 
                                    !empty($isInvoiceTotalView) or !empty($isInvoiceActiveView) or !empty($isInvoiceBlockedView)){ ?>
                                    <div class="row g-gs">
                                        <?php if(!empty($isPublisherTotalView) or !empty($isPublisherActiveView) or !empty($isPublisherBlockedView)){ ?>
                                            <div class="col-md-4">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Publisher</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Publisher"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isPublisherTotalView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($publisherCount != null){ ?>
                                                                            <?php if($isPublisherTotalEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-publisher" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <input type="hidden" name="search_publisher_status" value="all">
                                                                                            <h6><span class="count text-primary"><?php if($publisherCount != null){ echo $publisherCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($publisherCount != null){ echo $publisherCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($publisherCount != null){ echo $publisherCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isPublisherActiveView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($publisherActiveCount != null){ ?>
                                                                            <?php if($isPublisherActiveEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-publisher" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_publisher_status" value="active">
                                                                                            <h6><span class="count text-success"><?php if($publisherActiveCount != null){ echo $publisherActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Active">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($publisherActiveCount != null){ echo $publisherActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Active</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($publisherActiveCount != null){ echo $publisherActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Active</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isPublisherBlockedView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($publisherBlockedCount != null){ ?>
                                                                            <?php if($isPublisherBlockedEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-publisher" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <input type="hidden" name="search_publisher_status" value="blocked">
                                                                                            <h6><span class="count text-danger"><?php if($publisherBlockedCount != null){ echo $publisherBlockedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Blocked">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($publisherBlockedCount != null){ echo $publisherBlockedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Blocked</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($publisherBlockedCount != null){ echo $publisherBlockedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Blocked</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($isAdvertiserTotalView) or !empty($isAdvertiserActiveView) or !empty($isAdvertiserBlockedView)){ ?>
                                            <div class="col-md-4">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Advertiser</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Advertiser"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isAdvertiserTotalView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($advertiserCount != null){ ?>
                                                                            <?php if($isAdvertiserTotalEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-advertiser" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <input type="hidden" name="search_advertiser_status" value="all">
                                                                                            <h6><span class="count text-primary"><?php if($advertiserCount != null){ echo $advertiserCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($advertiserCount != null){ echo $advertiserCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($advertiserCount != null){ echo $advertiserCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isAdvertiserActiveView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($advertiserActiveCount != null){ ?>
                                                                            <?php if($isAdvertiserActiveEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-advertiser" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_advertiser_status" value="active">
                                                                                            <h6><span class="count text-success"><?php if($advertiserActiveCount != null){ echo $advertiserActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Active">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($advertiserActiveCount != null){ echo $advertiserActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Active</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($advertiserActiveCount != null){ echo $advertiserActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Active</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isAdvertiserBlockedView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($advertiserBlockedCount != null){ ?>
                                                                            <?php if($isAdvertiserBlockedEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-advertiser" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <input type="hidden" name="search_advertiser_status" value="blocked">
                                                                                            <h6><span class="count text-danger"><?php if($advertiserBlockedCount != null){ echo $advertiserBlockedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Blocked">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($advertiserBlockedCount != null){ echo $advertiserBlockedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Blocked</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($advertiserBlockedCount != null){ echo $advertiserBlockedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Blocked</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($isInvoiceTotalView) or !empty($isInvoiceActiveView) or !empty($isInvoiceBlockedView)){ ?>
                                            <div class="col-md-4">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Invoice</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Invoice"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isInvoiceTotalView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($invoiceCount != null){ ?>
                                                                            <?php if($isInvoiceTotalEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-invoice" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <input type="hidden" name="search_invoice_status" value="all">
                                                                                            <h6><span class="count text-primary"><?php if($invoiceCount != null){ echo $invoiceCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($invoiceCount != null){ echo $invoiceCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($invoiceCount != null){ echo $invoiceCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isInvoiceActiveView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($invoiceActiveCount != null){ ?>
                                                                            <?php if($isInvoiceActiveEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-invoice" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_invoice_status" value="active">
                                                                                            <h6><span class="count text-success"><?php if($invoiceActiveCount != null){ echo $invoiceActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Active">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($invoiceActiveCount != null){ echo $invoiceActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Active</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($invoiceActiveCount != null){ echo $invoiceActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Active</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isInvoiceBlockedView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($invoiceBlockedCount != null){ ?>
                                                                            <?php if($isInvoiceBlockedEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-invoice" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <input type="hidden" name="search_invoice_status" value="blocked">
                                                                                            <h6><span class="count text-danger"><?php if($invoiceBlockedCount != null){ echo $invoiceBlockedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Blocked">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($invoiceBlockedCount != null){ echo $invoiceBlockedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Blocked</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($invoiceBlockedCount != null){ echo $invoiceBlockedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Blocked</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner">
                                             <div class="nk-block-content text-center p-3">
                                                <span class="sub-text">You don't have permission to show the invoice dashboard's data</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane" id="tabItemSop">
                                <?php if(!empty($isSopProcedureTotalView) or !empty($isSopProcedureTrueView) or !empty($isSopProcedureFalseView) or !empty($isSopDepartmentView) or !empty($isSopUserView)){ ?>
                                    <div class="row g-gs">
                                        <?php if(!empty($isSopProcedureTotalView) or !empty($isSopProcedureTrueView) or !empty($isSopProcedureFalseView)){ ?>
                                            <div class="col-md-4">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Procedure</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Procedure"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isSopProcedureTotalView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($sopProcedureCount != null){ ?>
                                                                            <?php if($isSopProcedureTotalEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-sop-procedure" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <input type="hidden" name="search_sop_procedure_status" value="all">
                                                                                            <h6><span class="count text-primary"><?php if($sopProcedureCount != null){ echo $sopProcedureCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($sopProcedureCount != null){ echo $sopProcedureCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($sopProcedureCount != null){ echo $sopProcedureCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isSopProcedureTrueView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($sopProcedureTrueCount != null){ ?>
                                                                            <?php if($isSopProcedureTrueEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-sop-procedure" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_sop_procedure_status" value="true">
                                                                                            <h6><span class="count text-success"><?php if($sopProcedureTrueCount != null){ echo $sopProcedureTrueCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="True">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($sopProcedureTrueCount != null){ echo $sopProcedureTrueCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">True</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($sopProcedureTrueCount != null){ echo $sopProcedureTrueCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">True</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isSopProcedureFalseView){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($sopProcedureFalseCount != null){ ?>
                                                                            <?php if($isSopProcedureFalseEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-sop-procedure" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <input type="hidden" name="search_sop_procedure_status" value="false">
                                                                                            <h6><span class="count text-danger"><?php if($sopProcedureFalseCount != null){ echo $sopProcedureFalseCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="False">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($sopProcedureFalseCount != null){ echo $sopProcedureFalseCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">False</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($sopProcedureFalseCount != null){ echo $sopProcedureFalseCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">False</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($isSopDepartmentView)){ ?>
                                            <div class="col-md-4">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Department</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Department"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if(!empty($isSopDepartmentView)){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($sopDepartmentCount != null){ ?>
                                                                            <?php if($isSopDepartmentEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-sop-department" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <h6><span class="count text-primary"><?php if($sopDepartmentCount != null){ echo $sopDepartmentCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($sopDepartmentCount != null){ echo $sopDepartmentCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($sopDepartmentCount != null){ echo $sopDepartmentCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($isSopUserView)){ ?>
                                            <div class="col-md-4">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">User</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="User"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if(!empty($isSopUserView)){ ?>
                                                                    <div class="col-md-4">
                                                                        <?php if($sopUserCount != null){ ?>
                                                                            <?php if($isSopUserEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-sop-user" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <h6><span class="count text-primary"><?php if($sopUserCount != null){ echo $sopUserCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($sopUserCount != null){ echo $sopUserCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($sopUserCount != null){ echo $sopUserCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner">
                                             <div class="nk-block-content text-center p-3">
                                                <span class="sub-text">You don't have permission to show the sop dashboard's data</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane" id="tabItemHrm">
                                <?php if(!empty($isHrmEmployeeTotalView) or !empty($isHrmEmployeeInternView) or !empty($isHrmEmployeeEmployeeView) or 
                                    !empty($isHrmEmployeePendingView) or !empty($isHrmEmployeeSelectedView) or !empty($isHrmEmployeeRejectedView) or 
                                    !empty($isHrmEmployeeDraftView) or !empty($isHrmEmployeeActiveView) or !empty($isHrmEmployeeInactiveView) or 
                                    !empty($isHrmAttendanceTotalView) or !empty($isHrmAttendancePendingView) or !empty($isHrmAttendanceApprovedView) or !empty($isHrmAttendanceRejectedView) or
                                    !empty($isHrmLeaveTotalView) or !empty($isHrmLeaveFullView) or !empty($isHrmLeaveHalfView) or !empty($isHrmLeaveShortView) or !empty($isHrmLeavePendingView) or !empty($isHrmLeaveApprovedView) or !empty($isHrmLeaveRejectedView) or !empty($isHrmLeaveCancelledView) or
                                    !empty($isHrmSalaryTotalView) or !empty($isHrmSalaryPendingView) or !empty($isHrmSalarySendingView) or
                                    !empty($isHrmInternOfferView) or !empty($isHrmInternshipCertificateView) or !empty($isHrmEmployeeOfferView) or !empty($isHrmAppraisalCertificateView) or !empty($isHrmWarningMailView) or 
                                    !empty($isHrmAppointmentView) or !empty($isHrmHrPolicyView) or !empty($isHrmDeclarationView) or !empty($isHrmConsentView) or 
                                    !empty($isHrmNonDisclosureAgreementView) or !empty($isHrmServiceAgreementView) or 
                                    !empty($isHrmNoDueCertificateView) or !empty($isHrmRelievingView) or !empty($isHrmExperienceView) or !empty($isHrmTerminationView)){ ?>
                                    <div class="row g-gs">
                                        <?php if(!empty($isHrmEmployeeTotalView) or !empty($isHrmEmployeeInternView) or !empty($isHrmEmployeeEmployeeView) or 
                                            !empty($isHrmEmployeePendingView) or !empty($isHrmEmployeeSelectedView) or !empty($isHrmEmployeeRejectedView) or
                                            !empty($isHrmEmployeeDraftView) or !empty($isHrmEmployeeActiveView) or !empty($isHrmEmployeeInactiveView)){ ?>
                                            <div class="col-md-6">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Employee</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Employee"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isHrmEmployeeTotalView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($employeeCount != null){ ?>
                                                                            <?php if($isHrmEmployeeTotalEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <input type="hidden" name="search_employee_type" value="all">
                                                                                            <input type="hidden" name="search_employee_employee" value="all">
                                                                                            <input type="hidden" name="search_employee_status" value="all">
                                                                                            <h6><span class="count text-primary"><?php if($employeeCount != null){ echo $employeeCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($employeeCount != null){ echo $employeeCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($employeeCount != null){ echo $employeeCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmEmployeeInternView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($employeeInternCount != null){ ?>
                                                                            <?php if($isHrmEmployeeInternEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-secondary text-center">
                                                                                            <input type="hidden" name="search_employee_type" value="intern">
                                                                                            <h6><span class="count text-secondary"><?php if($employeeInternCount != null){ echo $employeeInternCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-secondary" value="Intern">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-secondary text-center">
                                                                                        <h6><span class="count text-secondary"><?php if($employeeInternCount != null){ echo $employeeInternCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-secondary">Intern</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-secondary text-center">
                                                                                    <h6><span class="count text-secondary"><?php if($employeeInternCount != null){ echo $employeeInternCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-secondary">Intern</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmEmployeeEmployeeView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($employeeEmployeeCount != null){ ?>
                                                                            <?php if($isHrmEmployeeEmployeeEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-info text-center">
                                                                                            <input type="hidden" name="search_employee_type" value="employee">
                                                                                            <h6><span class="count text-info"><?php if($employeeEmployeeCount != null){ echo $employeeEmployeeCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-info" value="Employee">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-info text-center">
                                                                                        <h6><span class="count text-info"><?php if($employeeEmployeeCount != null){ echo $employeeEmployeeCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-info">Employee</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-info text-center">
                                                                                    <h6><span class="count text-info"><?php if($employeeEmployeeCount != null){ echo $employeeEmployeeCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-info">Employee</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmEmployeePendingView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($employeePendingCount != null){ ?>
                                                                            <?php if($isHrmEmployeePendingEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-warning text-center">
                                                                                            <input type="hidden" name="search_employee_employee" value="pending">
                                                                                            <h6><span class="count text-warning"><?php if($employeePendingCount != null){ echo $employeePendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-warning" value="Pending">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-warning text-center">
                                                                                        <h6><span class="count text-warning"><?php if($employeePendingCount != null){ echo $employeePendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-warning">Pending</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-warning text-center">
                                                                                    <h6><span class="count text-warning"><?php if($employeePendingCount != null){ echo $employeePendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-warning">Pending</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmEmployeeSelectedView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($employeeSelectedCount != null){ ?>
                                                                            <?php if($isHrmEmployeeSelectedEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_employee_employee" value="selected">
                                                                                            <h6><span class="count text-success"><?php if($employeeSelectedCount != null){ echo $employeeSelectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Selected">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($employeeSelectedCount != null){ echo $employeeSelectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Selected</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($employeeSelectedCount != null){ echo $employeeSelectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Selected</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmEmployeeRejectedView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($employeeRejectedCount != null){ ?>
                                                                            <?php if($isHrmEmployeeRejectedEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <input type="hidden" name="search_employee_employee" value="rejected">
                                                                                            <h6><span class="count text-danger"><?php if($employeeRejectedCount != null){ echo $employeeRejectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Rejected">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($employeeRejectedCount != null){ echo $employeeRejectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Rejected</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($employeeRejectedCount != null){ echo $employeeRejectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Rejected</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmEmployeeDraftView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($employeeDraftCount != null){ ?>
                                                                            <?php if($isHrmEmployeeDraftEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <input type="hidden" name="search_employee_status" value="draft">
                                                                                            <h6><span class="count text-primary"><?php if($employeeDraftCount != null){ echo $employeeDraftCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Draft">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($employeeDraftCount != null){ echo $employeeDraftCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Draft</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($employeeDraftCount != null){ echo $employeeDraftCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Draft</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmEmployeeActiveView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($employeeActiveCount != null){ ?>
                                                                            <?php if($isHrmEmployeeActiveEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_employee_status" value="active">
                                                                                            <h6><span class="count text-success"><?php if($employeeActiveCount != null){ echo $employeeActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Active">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($employeeActiveCount != null){ echo $employeeActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Active</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($employeeActiveCount != null){ echo $employeeActiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Active</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmEmployeeInactiveView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($employeeInactiveCount != null){ ?>
                                                                            <?php if($isHrmEmployeeInactiveEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <input type="hidden" name="search_employee_status" value="inactive">
                                                                                            <h6><span class="count text-danger"><?php if($employeeInactiveCount != null){ echo $employeeInactiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Inactive">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($employeeInactiveCount != null){ echo $employeeInactiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Inactive</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($employeeInactiveCount != null){ echo $employeeInactiveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Inactive</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($isHrmLeaveTotalView) or !empty($isHrmLeaveFullView) or !empty($isHrmLeaveHalfView) or !empty($isHrmLeaveShortView) or !empty($isHrmLeavePendingView) or !empty($isHrmLeaveApprovedView) or !empty($isHrmLeaveRejectedView) or !empty($isHrmLeaveCancelledView)){ ?>
                                            <div class="col-md-6">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Leave</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Leave"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isHrmLeaveTotalView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($leaveCount != null){ ?>
                                                                            <?php if($isHrmLeaveTotalEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-leave" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <input type="hidden" name="search_leave_employee_type" value="all">
                                                                                            <input type="hidden" name="search_leave_employee_leave" value="all">
                                                                                            <h6><span class="count text-primary"><?php if($leaveCount != null){ echo $leaveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($leaveCount != null){ echo $leaveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($leaveCount != null){ echo $leaveCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmLeaveFullView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($leaveFullCount != null){ ?>
                                                                            <?php if($isHrmLeaveFullEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-leave" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_leave_employee_type" value="full">
                                                                                            <h6><span class="count text-success"><?php if($leaveFullCount != null){ echo $leaveFullCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Full">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($leaveFullCount != null){ echo $leaveFullCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Full</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($leaveFullCount != null){ echo $leaveFullCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Full</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmLeaveHalfView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($leaveHalfCount != null){ ?>
                                                                            <?php if($isHrmLeaveHalfEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-leave" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-warning text-center">
                                                                                            <input type="hidden" name="search_leave_employee_type" value="half">
                                                                                            <h6><span class="count text-warning"><?php if($leaveHalfCount != null){ echo $leaveHalfCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-warning" value="Half">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-warning text-center">
                                                                                        <h6><span class="count text-warning"><?php if($leaveHalfCount != null){ echo $leaveHalfCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-warning">Half</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-warning text-center">
                                                                                    <h6><span class="count text-warning"><?php if($leaveHalfCount != null){ echo $leaveHalfCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-warning">Half</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmLeaveShortView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($leaveShortCount != null){ ?>
                                                                            <?php if($isHrmLeaveShortEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-leave" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-secondary text-center">
                                                                                            <input type="hidden" name="search_leave_employee_type" value="short">
                                                                                            <h6><span class="count text-secondary"><?php if($leaveShortCount != null){ echo $leaveShortCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-secondary" value="Short">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-secondary text-center">
                                                                                        <h6><span class="count text-secondary"><?php if($leaveShortCount != null){ echo $leaveShortCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-secondary">Short</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-secondary text-center">
                                                                                    <h6><span class="count text-secondary"><?php if($leaveShortCount != null){ echo $leaveShortCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-secondary">Short</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmLeavePendingView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($leavePendingCount != null){ ?>
                                                                            <?php if($isHrmLeavePendingEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-leave" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-warning text-center">
                                                                                            <input type="hidden" name="search_leave_employee_leave" value="pending">
                                                                                            <h6><span class="count text-warning"><?php if($leavePendingCount != null){ echo $leavePendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-warning" value="Pending">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-warning text-center">
                                                                                        <h6><span class="count text-warning"><?php if($leavePendingCount != null){ echo $leavePendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-warning">Pending</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-warning text-center">
                                                                                    <h6><span class="count text-warning"><?php if($leavePendingCount != null){ echo $leavePendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-warning">Pending</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmLeaveApprovedView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($leaveApprovedCount != null){ ?>
                                                                            <?php if($isHrmLeaveApprovedEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-leave" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_leave_employee_leave" value="approved">
                                                                                            <h6><span class="count text-success"><?php if($leaveApprovedCount != null){ echo $leaveApprovedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Approved">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($leaveApprovedCount != null){ echo $leaveApprovedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Approved</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($leaveApprovedCount != null){ echo $leaveApprovedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Approved</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmLeaveRejectedView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($leaveRejectedCount != null){ ?>
                                                                            <?php if($isHrmLeaveRejectedEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-leave" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <input type="hidden" name="search_leave_employee_leave" value="rejected">
                                                                                            <h6><span class="count text-danger"><?php if($leaveRejectedCount != null){ echo $leaveRejectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Rejected">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($leaveRejectedCount != null){ echo $leaveRejectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Rejected</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($leaveRejectedCount != null){ echo $leaveRejectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Rejected</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmLeaveCancelledView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($leaveCancelledCount != null){ ?>
                                                                            <?php if($isHrmLeaveCancelledEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-leave" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-info text-center">
                                                                                            <input type="hidden" name="search_leave_employee_leave" value="cancelled">
                                                                                            <h6><span class="count text-info"><?php if($leaveCancelledCount != null){ echo $leaveCancelledCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-info" value="Cancelled">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-info text-center">
                                                                                        <h6><span class="count text-info"><?php if($leaveCancelledCount != null){ echo $leaveCancelledCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-info">Cancelled</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-info text-center">
                                                                                    <h6><span class="count text-info"><?php if($leaveCancelledCount != null){ echo $leaveCancelledCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-info">Cancelled</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($isHrmAttendanceTotalView) or !empty($isHrmAttendancePendingView) or !empty($isHrmAttendancePendingView) or !empty($isHrmAttendanceRejectedView)){ ?>
                                            <div class="col-md-6">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Attendance</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Attendance"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isHrmAttendanceTotalView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($attendanceCount != null){ ?>
                                                                            <?php if($isHrmAttendanceTotalEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-attendance" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <input type="hidden" name="search_attendance_admin_type" value="all">
                                                                                            <input type="hidden" name="search_attendance_admin_status" value="all">
                                                                                            <h6><span class="count text-primary"><?php if($attendanceCount != null){ echo $attendanceCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($attendanceCount != null){ echo $attendanceCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($attendanceCount != null){ echo $attendanceCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmAttendancePendingView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($attendancePendingCount != null){ ?>
                                                                            <?php if($isHrmAttendancePendingEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-attendance" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-warning text-center">
                                                                                            <input type="hidden" name="search_attendance_admin_type" value="pending">
                                                                                            <h6><span class="count text-warning"><?php if($attendancePendingCount != null){ echo $attendancePendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-warning" value="Pending">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-warning text-center">
                                                                                        <h6><span class="count text-warning"><?php if($attendancePendingCount != null){ echo $attendancePendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-warning">Pending</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-warning text-center">
                                                                                    <h6><span class="count text-warning"><?php if($attendancePendingCount != null){ echo $attendancePendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-warning">Pending</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmAttendancePendingView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($attendanceApprovedCount != null){ ?>
                                                                            <?php if($isHrmAttendanceApprovedEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-attendance" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_attendance_admin_type" value="approved">
                                                                                            <h6><span class="count text-success"><?php if($attendanceApprovedCount != null){ echo $attendanceApprovedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Approved">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($attendanceApprovedCount != null){ echo $attendanceApprovedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Approved</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($attendanceApprovedCount != null){ echo $attendanceApprovedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Approved</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmAttendanceRejectedView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($attendanceRejectedCount != null){ ?>
                                                                            <?php if($isHrmAttendanceRejectedEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-admin-attendance" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <input type="hidden" name="search_attendance_admin_type" value="rejected">
                                                                                            <h6><span class="count text-danger"><?php if($attendanceRejectedCount != null){ echo $attendanceRejectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Rejected">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($attendanceRejectedCount != null){ echo $attendanceRejectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Rejected</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($attendanceRejectedCount != null){ echo $attendanceRejectedCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Rejected</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($isHrmSalaryTotalView) or !empty($isHrmSalaryPendingView) or !empty($isHrmSalarySendingView)){ ?>
                                            <div class="col-md-6">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Salary</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Salary"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isHrmSalaryTotalView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($salaryCount != null){ ?>
                                                                            <?php if($isHrmSalaryTotalEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-salary" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <input type="hidden" name="search_salary_email" value="all">
                                                                                            <h6><span class="count text-primary"><?php if($salaryCount != null){ echo $salaryCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Total">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($salaryCount != null){ echo $salaryCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($salaryCount != null){ echo $salaryCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Total</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmSalaryPendingView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($salaryPendingCount != null){ ?>
                                                                            <?php if($isHrmSalaryPendingEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-salary" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-warning text-center">
                                                                                            <input type="hidden" name="search_salary_email" value="pending">
                                                                                            <h6><span class="count text-warning"><?php if($salaryPendingCount != null){ echo $salaryPendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-warning" value="Pending">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-warning text-center">
                                                                                        <h6><span class="count text-warning"><?php if($salaryPendingCount != null){ echo $salaryPendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-warning">Pending</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-warning text-center">
                                                                                    <h6><span class="count text-warning"><?php if($salaryPendingCount != null){ echo $salaryPendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-warning">Pending</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmSalarySendingView){ ?>
                                                                    <div class="col-md-3">
                                                                        <?php if($salarySendingCount != null){ ?>
                                                                            <?php if($isHrmSalarySendingEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-salary" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <input type="hidden" name="search_salary_email" value="sending">
                                                                                            <h6><span class="count text-success"><?php if($salarySendingCount != null){ echo $salarySendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Sending">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($salarySendingCount != null){ echo $salarySendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Sending</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($salarySendingCount != null){ echo $salarySendingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Sending</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($isHrmInternOfferView) or !empty($isHrmInternshipCertificateView) or !empty($isHrmEmployeeOfferView) or !empty($isHrmAppraisalCertificateView) or !empty($isHrmWarningMailView) or 
                                            !empty($isHrmAppointmentView) or !empty($isHrmHrPolicyView) or !empty($isHrmDeclarationView) or !empty($isHrmConsentView) or 
                                            !empty($isHrmNonDisclosureAgreementView) or !empty($isHrmServiceAgreementView)){ ?>
                                            <div class="col-md-12">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Total Onboarding Letter</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total Onboarding Letter"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isHrmInternOfferView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($internOfferCount != null){ ?>
                                                                            <?php if($isHrmInternOfferEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-intern-offer" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <h6><span class="count text-primary"><?php if($internOfferCount != null){ echo $internOfferCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="Intern Offer">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($internOfferCount != null){ echo $internOfferCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">Intern Offer</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($internOfferCount != null){ echo $internOfferCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">Intern Offer</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmInternshipCertificateView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($internshipCertificateCount != null){ ?>
                                                                            <?php if($isHrmInternshipCertificateEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-internship-certificate" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-secondary text-center">
                                                                                            <h6><span class="count text-secondary"><?php if($internshipCertificateCount != null){ echo $internshipCertificateCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-secondary" value="Internship Certificate">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-secondary text-center">
                                                                                        <h6><span class="count text-secondary"><?php if($internshipCertificateCount != null){ echo $internshipCertificateCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-secondary">Internship Certificate</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-secondary text-center">
                                                                                    <h6><span class="count text-secondary"><?php if($internshipCertificateCount != null){ echo $internshipCertificateCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-secondary">Internship Certificate</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmEmployeeOfferView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($employeeOfferCount != null){ ?>
                                                                            <?php if($isHrmEmployeeOfferEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-employee-offer" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <h6><span class="count text-success"><?php if($employeeOfferCount != null){ echo $employeeOfferCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Employee Offer">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($employeeOfferCount != null){ echo $employeeOfferCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Employee Offer</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($employeeOfferCount != null){ echo $employeeOfferCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Employee Offer</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmAppraisalCertificateView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($appraisalCertificateCount != null){ ?>
                                                                            <?php if($isHrmAppraisalCertificateEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-appraisal-certificate" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <h6><span class="count text-danger"><?php if($appraisalCertificateCount != null){ echo $appraisalCertificateCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Appraisal Certificate">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($appraisalCertificateCount != null){ echo $appraisalCertificateCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Appraisal Certificate</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($appraisalCertificateCount != null){ echo $appraisalCertificateCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Appraisal Certificate</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmWarningMailView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($warningMailCount != null){ ?>
                                                                            <?php if($isHrmWarningMailEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-warning-mail" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-warning text-center">
                                                                                            <h6><span class="count text-warning"><?php if($warningMailCount != null){ echo $warningMailCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-warning" value="Warning Mail">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-warning text-center">
                                                                                        <h6><span class="count text-warning"><?php if($warningMailCount != null){ echo $warningMailCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-warning">Warning Mail</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-warning text-center">
                                                                                    <h6><span class="count text-warning"><?php if($warningMailCount != null){ echo $warningMailCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-warning">Warning Mail</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmAppointmentView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($appointmentCount != null){ ?>
                                                                            <?php if($isHrmAppointmentEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-appointment" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-info text-center">
                                                                                            <h6><span class="count text-info"><?php if($appointmentCount != null){ echo $appointmentCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-info" value="Appointment">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-info text-center">
                                                                                        <h6><span class="count text-info"><?php if($appointmentCount != null){ echo $appointmentCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-info">Appointment</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-info text-center">
                                                                                    <h6><span class="count text-info"><?php if($appointmentCount != null){ echo $appointmentCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-info">Appointment</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmHrPolicyView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($hrPolicyCount != null){ ?>
                                                                            <?php if($isHrmHrPolicyEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-hr-policy" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-info text-center">
                                                                                            <h6><span class="count text-info"><?php if($hrPolicyCount != null){ echo $hrPolicyCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-info" value="HR Policy">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-info text-center">
                                                                                        <h6><span class="count text-info"><?php if($hrPolicyCount != null){ echo $hrPolicyCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-info">HR Policy</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-info text-center">
                                                                                    <h6><span class="count text-info"><?php if($hrPolicyCount != null){ echo $hrPolicyCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-info">HR Policy</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmDeclarationView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($declarationCount != null){ ?>
                                                                            <?php if($isHrmDeclarationEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-declaration" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-warning text-center">
                                                                                            <h6><span class="count text-warning"><?php if($declarationCount != null){ echo $declarationCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-warning" value="Declaration">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-warning text-center">
                                                                                        <h6><span class="count text-warning"><?php if($declarationCount != null){ echo $declarationCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-warning">Declaration</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-warning text-center">
                                                                                    <h6><span class="count text-warning"><?php if($declarationCount != null){ echo $declarationCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-warning">Declaration</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmConsentView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($consentCount != null){ ?>
                                                                            <?php if($isHrmConsentEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-consent" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <h6><span class="count text-danger"><?php if($consentCount != null){ echo $consentCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Consent">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($consentCount != null){ echo $consentCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Consent</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($consentCount != null){ echo $consentCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Consent</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmNonDisclosureAgreementView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($nonDisclosureAgreementCount != null){ ?>
                                                                            <?php if($isHrmNonDisclosureAgreementEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-non-disclosure-agreement" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <h6><span class="count text-success"><?php if($nonDisclosureAgreementCount != null){ echo $nonDisclosureAgreementCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Non Disclosure Agreement">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($nonDisclosureAgreementCount != null){ echo $nonDisclosureAgreementCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Non Disclosure Agreement</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($nonDisclosureAgreementCount != null){ echo $nonDisclosureAgreementCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Non Disclosure Agreement</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmServiceAgreementView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($serviceAgreementCount != null){ ?>
                                                                            <?php if($isHrmServiceAgreementEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-service-agreement" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-secondary text-center">
                                                                                            <h6><span class="count text-secondary"><?php if($serviceAgreementCount != null){ echo $serviceAgreementCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-secondary" value="Service Agreement">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-secondary text-center">
                                                                                        <h6><span class="count text-secondary"><?php if($serviceAgreementCount != null){ echo $serviceAgreementCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-secondary">Service Agreement</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-secondary text-center">
                                                                                    <h6><span class="count text-secondary"><?php if($serviceAgreementCount != null){ echo $serviceAgreementCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-secondary">Service Agreement</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($isHrmNoDueCertificateView) or !empty($isHrmRelievingView) or !empty($isHrmExperienceView) or !empty($isHrmTerminationView)){ ?>
                                            <div class="col-md-12">
                                                <div class="card card-bordered card-preview h-100">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Total Offboarding Letter</h6>
                                                            </div>
                                                            <div class="card-tools">
                                                                <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total Offboarding Letter"></em>
                                                            </div>
                                                        </div>
                                                        <div class="example-alerts">
                                                            <div class="row gy-4">
                                                                <?php if($isHrmNoDueCertificateView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($noDueCertificateCount != null){ ?>
                                                                            <?php if($isHrmNoDueCertificateEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-no-due-certificate" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-primary text-center">
                                                                                            <h6><span class="count text-primary"><?php if($noDueCertificateCount != null){ echo $noDueCertificateCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-primary" value="No Due Certificate">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-primary text-center">
                                                                                        <h6><span class="count text-primary"><?php if($noDueCertificateCount != null){ echo $noDueCertificateCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-primary">No Due Certificate</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-primary text-center">
                                                                                    <h6><span class="count text-primary"><?php if($noDueCertificateCount != null){ echo $noDueCertificateCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-primary">No Due Certificate</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmRelievingView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($relievingCount != null){ ?>
                                                                            <?php if($isHrmRelievingEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-relieving" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-secondary text-center">
                                                                                            <h6><span class="count text-secondary"><?php if($relievingCount != null){ echo $relievingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-secondary" value="Relieving">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-secondary text-center">
                                                                                        <h6><span class="count text-secondary"><?php if($relievingCount != null){ echo $relievingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-secondary">Relieving</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-secondary text-center">
                                                                                    <h6><span class="count text-secondary"><?php if($relievingCount != null){ echo $relievingCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-secondary">Relieving</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmExperienceView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($experienceCount != null){ ?>
                                                                            <?php if($isHrmExperienceEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-experience" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-success text-center">
                                                                                            <h6><span class="count text-success"><?php if($experienceCount != null){ echo $experienceCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-success" value="Experience">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-success text-center">
                                                                                        <h6><span class="count text-success"><?php if($experienceCount != null){ echo $experienceCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-success">Experience</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-success text-center">
                                                                                    <h6><span class="count text-success"><?php if($experienceCount != null){ echo $experienceCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-success">Experience</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if($isHrmTerminationView){ ?>
                                                                    <div class="col-md-2">
                                                                        <?php if($terminationCount != null){ ?>
                                                                            <?php if($isHrmTerminationEdit){ ?>
                                                                                <form action="<?php echo base_url(); ?>view-termination" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                                    <div class="example-alert">
                                                                                        <div class="alert alert-danger text-center">
                                                                                            <h6><span class="count text-danger"><?php if($terminationCount != null){ echo $terminationCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                            <input type="submit" class="btn btn-sm btn-dim btn-danger" value="Termination">
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            <?php } else { ?>
                                                                                <div class="example-alert">
                                                                                    <div class="alert alert-danger text-center">
                                                                                        <h6><span class="count text-danger"><?php if($terminationCount != null){ echo $terminationCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                        <span class="btn btn-sm btn-dim btn-danger">Termination</span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <div class="example-alert">
                                                                                <div class="alert alert-danger text-center">
                                                                                    <h6><span class="count text-danger"><?php if($terminationCount != null){ echo $terminationCount; ?> <?php } else { ?> 0 <?php } ?></span></h6>
                                                                                    <span class="btn btn-sm btn-dim btn-danger">Termination</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner">
                                            <div class="nk-block-content text-center p-3">
                                                <span class="sub-text">You don't have permission to show the hrm dashboard's data</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        
    </div>
</div>