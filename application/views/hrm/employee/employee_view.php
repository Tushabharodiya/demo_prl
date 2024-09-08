<?php
    $isEmployeeAdd = checkPermission(HRM_EMPLOYEE_ALIAS, "can_add");
    $isEmployeeView = checkPermission(HRM_EMPLOYEE_ALIAS, "can_view");
    $isEmployeeSelectionEdit = checkPermission(HRM_EMPLOYEE_SELECTION_ALIAS, "can_edit");
    $isEmployeeInactiveEdit = checkPermission(HRM_EMPLOYEE_INACTIVE_ALIAS, "can_edit");
    $isEmployeeActiveEdit = checkPermission(HRM_EMPLOYEE_ACTIVE_ALIAS, "can_edit");
    $isEmployeeEdit = checkPermission(HRM_EMPLOYEE_ALIAS, "can_edit");

    $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');

    $sessionEmployee = $this->session->userdata('session_employee');
    $sessionEmployeeIsEmployee = $this->session->userdata('session_employee_is_employee');
    $sessionEmployeeType = $this->session->userdata('session_employee_type');
    $sessionEmployeeStatus = $this->session->userdata('session_employee_status');
    $sessionEmployeeCreatedStartDate = $this->session->userdata('session_employee_created_start_date');
    $sessionEmployeeCreatedEndDate = $this->session->userdata('session_employee_created_end_date');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Employee</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isEmployeeView){ ?>
                            <p><?php echo "You have total $countEmployee employees."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isEmployeeView){ ?>
                                    <li>
                                        <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="dropdown">
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter Employee</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Employee</label>
                                                                    <select class="form-control form-select" id="search-employee" name="search_employee_is_employee" data-placeholder="Select a employee">
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeIsEmployee == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeIsEmployee == 'pending')){
                                                                                $str.='selected';
                                                                        } ?> <option value="pending"<?php echo $str; ?>>Pending</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeIsEmployee == 'selected')){
                                                                                $str.='selected';
                                                                        } ?> <option value="selected"<?php echo $str; ?>>Selected</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeIsEmployee == 'rejected')){
                                                                                $str.='selected';
                                                                        } ?> <option value="rejected"<?php echo $str; ?>>Rejected</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Type</label>
                                                                    <select class="form-control form-select" id="search-type" name="search_employee_type" data-placeholder="Select a type">
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeType == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeType == 'intern')){
                                                                                $str.='selected';
                                                                        } ?> <option value="intern"<?php echo $str; ?>>Intern</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeType == 'employee')){
                                                                                $str.='selected';
                                                                        } ?> <option value="employee"<?php echo $str; ?>>Employee</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                    <select class="form-control form-select" id="search-status" name="search_employee_status" data-placeholder="Select a status">
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeStatus == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeStatus == 'draft')){
                                                                                $str.='selected';
                                                                        } ?> <option value="draft"<?php echo $str; ?>>Draft</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeStatus == 'active')){
                                                                                $str.='selected';
                                                                        } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionEmployeeStatus == 'inactive')){
                                                                                $str.='selected';
                                                                        } ?> <option value="inactive"<?php echo $str; ?>>Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Created Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="input-daterange date-picker-range input-group">
                                                                            <input type="text" class="form-control date-picker" name="search_employee_created_start_date" value="<?php if(!empty($sessionEmployeeCreatedStartDate)){ echo $sessionEmployeeCreatedStartDate; } ?>" placeholder="Enter start date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                                                            <div class="input-group-addon">TO</div>
                                                                            <input type="text" class="form-control date-picker" name="search_employee_created_end_date" value="<?php if(!empty($sessionEmployeeCreatedEndDate)){ echo $sessionEmployeeCreatedEndDate; } ?>" placeholder="Enter end date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-foot between">
                                                        <input type="submit" class="btn btn-sm btn-dim btn-secondary" name="reset_filter" value="Reset Filter">
                                                        <input type="submit" class="btn btn-sm btn-dim btn-info" name="submit_filter" value="Submit Filter">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                <?php } ?>
                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                        <li><a href="<?php echo base_url(); ?>view-trash-employee" class="btn btn-white btn-outline-light"><em class="icon ni ni-trash-fill"></em><span>Trash <sup><?php echo $countEmployeeTrash; ?></sup></span></a></li>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($isEmployeeAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-employee" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isEmployeeView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_employee" value="<?php if(!empty($sessionEmployee)){ echo $sessionEmployee; } ?>" placeholder="Search..." autocomplete="off">
                            <div class="form-icon form-icon-right">
                                <em class="icon ni ni-search"></em>
                            </div>
                            <input type="submit" class="btn btn-sm btn-info d-none" name="submit_search" value="Filter">
                            <input type="submit" class="btn btn-sm btn-secondary d-none" name="reset_search" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_selection_edit_is_employee_selected'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_selection_edit_is_employee_selected'); $this->session->unset_userdata('session_employee_selection_edit_is_employee_selected'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_selection_edit_is_employee_rejected'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_selection_edit_is_employee_rejected'); $this->session->unset_userdata('session_employee_selection_edit_is_employee_rejected'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_selection_edit_reset'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_selection_edit_reset'); $this->session->unset_userdata('session_employee_selection_edit_reset'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_status_edit_active'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_status_edit_active'); $this->session->unset_userdata('session_employee_status_edit_active'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_status_edit_inactive'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_status_edit_inactive'); $this->session->unset_userdata('session_employee_status_edit_inactive'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_notice_period_edit_leaving_date_submit'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_notice_period_edit_leaving_date_submit'); $this->session->unset_userdata('session_employee_notice_period_edit_leaving_date_submit'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_notice_period_edit_leaving_date_cancel'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_notice_period_edit_leaving_date_cancel'); $this->session->unset_userdata('session_employee_notice_period_edit_leaving_date_cancel'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_trash_attendance_admin'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_attendance_admin');?> Please delete <a href="<?php echo base_url('view-admin-attendance');?>" class="alert-link">attendance</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_attendance_admin');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_leave_admin'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_leave_admin');?> Please delete <a href="<?php echo base_url('view-admin-leave');?>" class="alert-link">leave</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_leave_admin');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_reporting_admin'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_reporting_admin');?> Please delete <a href="<?php echo base_url('view-admin-reporting');?>" class="alert-link">reporting</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_reporting_admin');?>
            </div>
        <?php } ?>  
        
        <?php if(!empty($this->session->userdata('session_employee_trash_salary'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_salary');?> Please delete <a href="<?php echo base_url('view-salary');?>" class="alert-link">salary</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_salary');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_intern_offer'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_intern_offer');?> Please delete <a href="<?php echo base_url('view-intern-offer');?>" class="alert-link">intern offer</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_intern_offer');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_internship_certificate'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_internship_certificate');?> Please delete <a href="<?php echo base_url('view-internship-certificate');?>" class="alert-link">internship certificate</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_internship_certificate');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_employee_offer'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_employee_offer');?> Please delete <a href="<?php echo base_url('view-employee-offer');?>" class="alert-link">employee offer</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_employee_offer');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_appraisal_certificate'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_appraisal_certificate');?> Please delete <a href="<?php echo base_url('view-appraisal-certificate');?>" class="alert-link">appraisal certificate</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_appraisal_certificate');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_trash_warning_mail'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_warning_mail');?> Please delete <a href="<?php echo base_url('view-warning-mail');?>" class="alert-link">warning mail</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_warning_mail');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_appointment'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_appointment');?> Please delete <a href="<?php echo base_url('view-appointment');?>" class="alert-link">appointment</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_appointment');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_hr_policy'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_hr_policy');?> Please delete <a href="<?php echo base_url('view-hr-policy');?>" class="alert-link">hr policy</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_hr_policy');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_declaration'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_declaration');?> Please delete <a href="<?php echo base_url('view-declaration');?>" class="alert-link">declaration</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_declaration');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_consent'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_consent');?> Please delete <a href="<?php echo base_url('view-consent');?>" class="alert-link">consent</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_consent');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_non_disclosure_agreement'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_non_disclosure_agreement');?> Please delete <a href="<?php echo base_url('view-non-disclosure-agreement');?>" class="alert-link">non disclosure agreement</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_non_disclosure_agreement');?>
            </div>
        <?php } ?> 
        
        <?php if(!empty($this->session->userdata('session_employee_trash_service_agreement'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_service_agreement');?> Please delete <a href="<?php echo base_url('view-service-agreement');?>" class="alert-link">service agreement</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_service_agreement');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_trash_no_due_certificate'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_no_due_certificate');?> Please delete <a href="<?php echo base_url('view-no-due-certificate');?>" class="alert-link">no due certificate</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_no_due_certificate');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_trash_relieving'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_relieving');?> Please delete <a href="<?php echo base_url('view-relieving');?>" class="alert-link">relieving</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_relieving');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_trash_experience'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_experience');?> Please delete <a href="<?php echo base_url('view-experience');?>" class="alert-link">experience</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_experience');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_trash_termination'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_termination');?> Please delete <a href="<?php echo base_url('view-terminationr');?>" class="alert-link">termination</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_termination');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_trash_user_master'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_user_master');?> Please delete <a href="<?php echo base_url('view-user');?>" class="alert-link">user</a> before trashing employee<?php echo $this->session->unset_userdata('session_employee_trash_user_master');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_trash_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_trash_success'); $this->session->unset_userdata('session_employee_trash_success'); ?>
            </div>
        <?php } ?>

        <div class="nk-block">
            <div class="row g-gs">
                <?php if($isEmployeeView){ ?>
                    <?php if(!empty($viewEmployee)){ ?>
                        <?php foreach($viewEmployee as $data){ ?>
                            <div class="col-md-3">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div class="team">
                                            <?php if($data['employee_status'] == 'draft'){ ?>
                                                <div class="team-status bg-primary text-white"><em class="icon ni ni-na"></em></div>
                                            <?php } else if($data['employee_status'] == 'active'){ ?>
                                                <div class="team-status bg-success text-white"><em class="icon ni ni-check"></em></div>
                                            <?php } else if($data['employee_status'] == 'inactive'){ ?>
                                                <div class="team-status bg-danger text-white"><em class="icon ni ni-cross"></em></div>
                                            <?php } ?>
                                            <?php if($isEmployeeSelectionEdit or $isEmployeeInactiveEdit or $isEmployeeActiveEdit or $isEmployeeEdit){ ?>
                                                <div class="team-options">
                                                    <div class="drodown">
                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            <ul class="link-list-opt no-bdr">
                                                                <?php if($isEmployeeSelectionEdit){ ?>
                                                                    <?php if($data['employee_status'] == 'draft' or $data['employee_status'] == 'active'){ ?>
                                                                        <?php if(!empty($data['hr_review']) or !empty($data['admin_review']) or !empty($data['technical_review'])){ ?>
                                                                            <li><a data-bs-toggle="modal" data-bs-target="#selectionModal<?php echo urlEncodes($data['employee_id']); ?>"><em class="icon ni ni-user-check"></em><span>Selection</span></a></li>
                                                                        <?php } else { ?>
                                                                            <li><a role="link" aria-disabled="true"><em class="icon ni ni-user-check"></em><span>Selection</span></a></li>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if($data['employee_status'] == "active"){ ?>
                                                                    <?php if($isEmployeeInactiveEdit){ ?>
                                                                        <li><a data-bs-toggle="modal" data-bs-target="#inactiveModal<?php echo urlEncodes($data['employee_id']);?>"><em class="icon ni ni-cross-round"></em><span>Inactive</span></a></li>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php if($isEmployeeActiveEdit){ ?>
                                                                        <li><a data-bs-toggle="modal" data-bs-target="#activeModal<?php echo urlEncodes($data['employee_id']);?>"><em class="icon ni ni-check-round"></em><span>Active</span></a></li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if($isEmployeeEdit){ ?>
                                                                    <?php if($data['employee_status'] == "active"){ ?>
                                                                        <?php if(!empty($data['employee_leaving_date'])){ ?>
                                                                            <li><a data-bs-toggle="modal" data-bs-target="#offNoticePeriodModal<?php echo urlEncodes($data['employee_id']);?>"><em class="icon ni ni-cross-circle"></em><span>Notice Period</span></a></li>
                                                                        <?php } else { ?>
                                                                            <li><a data-bs-toggle="modal" data-bs-target="#onNoticePeriodModal<?php echo urlEncodes($data['employee_id']);?>"><em class="icon ni ni-check-circle"></em><span>Notice Period</span></a></li>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if($isEmployeeEdit){ ?>
                                                                    <?php if($data['employee_status'] == 'draft' or $data['employee_status'] == 'active'){ ?>
                                                                        <li><a href="<?php echo base_url(); ?>edit-employee/<?php echo urlEncodes($data['employee_id']); ?>"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                        <li><a data-bs-toggle="modal" data-bs-target="#trashModal<?php echo urlEncodes($data['employee_id']);?>"><em class="icon ni ni-trash"></em><span>Trash</span></a></li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="user-card user-card-s2">
                                                <?php if(!empty($data['employee_photo'] && $data['employee_photo'] != "Unknown")){ ?>
                                                    <div class="user-avatar md bg-light">
                                                        <a class="gallery-image popup-image" href="<?php echo base_url();?>uploads/hrm/employee_photo/<?php echo $data['employee_photo']; ?>">
                                                            <img src="<?php echo base_url(); ?>uploads/hrm/employee_photo/<?php echo $data['employee_photo']; ?>" class="rounded-circle" alt="">
                                                        </a>
                                                    </div>
                                                <?php } else if(!empty($data['employee_photo'] && $data['employee_photo'] == "Unknown")){ ?>
                                                    <div class="user-avatar md bg-light">
                                                        <em class="icon ni ni-user-alt-fill"></em>
                                                    </div>
                                                <?php } else { ?>
                                                    <?php $color = assignFillColor($data['employee_id']); ?>
                                                    <div class="user-avatar md" style="background-color: <?php echo $color; ?>">
                                                        <span><?php echo get_first_letters($data['employee_first_name']); echo get_first_letters($data['employee_last_name']); ?></span>
                                                    </div>
                                                <?php } ?>
                                                <div class="user-info">
                                                    <h6><?php echo $data['employee_first_name']; ?> <?php echo $data['employee_middle_name']; ?> <?php echo $data['employee_last_name']; ?></h6>
                                                    <span class="sub-text"><?php echo $data['employee_email']; ?></span>
                                                </div>
                                            </div>
                                            <div class="team-details">
                                                <span class="badge badge-dim bg-light text-gray"><p><?php echo $data['departmentData']['department_name']; ?></p></span>
                                            </div>
                                            <ul class="pricing-features mt-3">
                                                <li><span class="w-50">Mobile</span> - <span class="sub-text ms-auto"><?php echo $data['employee_mobile_no']; ?></span></li>
                                                <li><span class="w-50">Created Date</span> - <span class="sub-text ms-auto"><?php echo $data['employee_created_date']; ?></span></li>
                                                <li><span class="w-50">Employee</span> - <span class="sub-text text-success ms-auto"><?php 
                                                    $isEmployee = '';
                                                    if($data['is_employee'] == 'pending'){
                                                        $isEmployee.= '<span class="tb-status text-warning">Pending</span>';
                                                    } else if($data['is_employee'] == 'selected'){
                                                        $isEmployee.= '<span class="tb-status text-success">Selected</span>';
                                                    } else if($data['is_employee'] == 'rejected'){
                                                        $isEmployee.= '<span class="tb-status text-danger">Rejected</span>';
                                                    } 
                                                    echo $isEmployee; 
                                                ?></span></li>
                                                <li><span class="w-50">Type</span> - <span class="sub-text text-info ms-auto"><?php 
                                                    if(!empty($data['employee_type'])){
                                                        $employeeType = '';
                                                        if($data['employee_type'] == 'intern'){
                                                            $employeeType.= '<span class="tb-status text-primary">Intern</span>';
                                                        } else if($data['employee_type'] == 'employee'){
                                                            $employeeType.= '<span class="tb-status text-info">Employee</span>';
                                                        }
                                                        echo $employeeType; 
                                                    } else {
                                                        echo "-";
                                                    }
                                                ?></span></li>
                                                <li><span class="w-50">Status</span> - <span class="sub-text text-danger ms-auto"><?php 
                                                    $employeeStatus = '';
                                                    if($data['employee_status'] == 'draft'){
                                                        $employeeStatus.= '<span class="tb-status text-primary">Draft</span>';
                                                    } else if($data['employee_status'] == 'active'){
                                                        $employeeStatus.= '<span class="tb-status text-success">Active</span>';
                                                    } else if($data['employee_status'] == 'inactive'){
                                                        $employeeStatus.= '<span class="tb-status text-danger">Inactive</span>';
                                                    }
                                                    echo $employeeStatus; 
                                                ?></span></li>
                                            </ul>
                                            <div class="team-view mt-3">
                                                <a href="<?php echo base_url(); ?>info-employee/<?php echo urlEncodes($data['employee_id']); ?>" class="btn btn-round btn-outline-light w-150px"><span>View Profile</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="selectionModal<?php echo urlEncodes($data['employee_id']); ?>">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <form action="<?php echo base_url(); ?>edit-selection-employee/<?php echo urlEncodes($data['employee_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Selection Employee</h5>
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="is_employee">Is Employee *</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-control form-select js-select2 isEmployee" name="is_employee" data-id="<?php echo $data['employee_id']; ?>" data-placeholder="Select a employee" required>
                                                                    <option label="empty" value=""></option>
                                                                    <option value="selected"<?php if($data['is_employee'] =="selected"){ echo "selected"; } else { echo ""; } ?>>Selected</option>
                                                                    <option value="rejected"<?php if($data['is_employee'] =="rejected"){ echo "selected"; } else { echo ""; } ?>>Rejected</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="col-md-12 n-none" id="employeeRefFrom<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_ref_from">Employee Ref From *</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_ref_from" value="<?php echo $data['employee_ref_from']; ?>" placeholder="Enter employee ref from" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeJoiningDate<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_joining_date">Employee Joining Date *</label>
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-right">
                                                                    <em class="icon ni ni-calendar-alt"></em>
                                                                </div>
                                                                <input type="text" class="form-control date-picker" name="employee_joining_date" value="<?php echo $data['employee_joining_date']; ?>" placeholder="Enter employee joining date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeAccessCardNo<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_access_card_no">Employee Access Card No *</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_access_card_no" value="<?php echo $data['employee_access_card_no']; ?>" placeholder="Enter employee access card no" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeQualification<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_qualification">Employee Qualification *</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_qualification" value="<?php echo $data['employee_qualification']; ?>" placeholder="Enter employee qualification" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeGender<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_gender">Employee Gender *</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-control form-select js-select2" name="employee_gender" data-placeholder="Select a gender" required>
                                                                    <option label="empty" value=""></option>
                                                                    <option value="Male"<?php if($data['employee_gender'] =="Male"){ echo "selected"; } else { echo ""; } ?>>Male</option> 
                                                                    <option value="Female"<?php if($data['employee_gender'] =="Female"){ echo "selected"; } else { echo ""; } ?>>Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeePanFrontImage<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_pan_front_image">Employee Pan Front Image</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <?php if(!empty($data['employee_pan_front_image'])){ ?>
                                                                            <div class="btn btn-outline-success btn-dim"><em class="icon ni ni-done"></em></div>
                                                                        <?php } else { ?>
                                                                            <div class="btn btn-outline-danger btn-dim"><em class="icon ni ni-na"></em></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-control form-file-input" id="file-uploader-pan-front-image" name="employee_pan_front_image" value="<?php echo $data['employee_pan_front_image']; ?>">
                                                                        <label class="form-file-label" for="employee_pan_front_image">Choose files</label>
                                                                        <div id="feedback-pan-front-image"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeePanBackImage<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_pan_back_image">Employee Pan Back Image</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <?php if(!empty($data['employee_pan_back_image'])){ ?>
                                                                            <div class="btn btn-outline-success btn-dim"><em class="icon ni ni-done"></em></div>
                                                                        <?php } else { ?>
                                                                            <div class="btn btn-outline-danger btn-dim"><em class="icon ni ni-na"></em></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-control form-file-input" id="file-uploader-pan-back-image" name="employee_pan_back_image" value="<?php echo $data['employee_pan_back_image']; ?>">
                                                                        <label class="form-file-label" for="employee_pan_back_image">Choose files</label>
                                                                        <div id="feedback-pan-back-image"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeAadharFrontImage<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_aadhar_front_image">Employee Aadhar Front Image</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <?php if(!empty($data['employee_aadhar_front_image'])){ ?>
                                                                            <div class="btn btn-outline-success btn-dim"><em class="icon ni ni-done"></em></div>
                                                                        <?php } else { ?>
                                                                            <div class="btn btn-outline-danger btn-dim"><em class="icon ni ni-na"></em></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-control form-file-input" id="file-uploader-aadhar-front-image" name="employee_aadhar_front_image" value="<?php echo $data['employee_aadhar_front_image']; ?>">
                                                                        <label class="form-file-label" for="employee_aadhar_front_image">Choose files</label>
                                                                        <div id="feedback-aadhar-front-image"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeAadharBackImage<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_aadhar_back_image">Employee Aadhar Back Image</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <?php if(!empty($data['employee_aadhar_back_image'])){ ?>
                                                                            <div class="btn btn-outline-success btn-dim"><em class="icon ni ni-done"></em></div>
                                                                        <?php } else { ?>
                                                                            <div class="btn btn-outline-danger btn-dim"><em class="icon ni ni-na"></em></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-control form-file-input" id="file-uploader-aadhar-back-image" name="employee_aadhar_back_image" value="<?php echo $data['employee_aadhar_back_image']; ?>">
                                                                        <label class="form-file-label" for="employee_aadhar_back_image">Choose files</label>
                                                                        <div id="feedback-aadhar-back-image"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeResidentialProofImage<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_residential_proof_image">Employee Residential Proof Image</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <?php if(!empty($data['employee_residential_proof_image'])){ ?>
                                                                            <div class="btn btn-outline-success btn-dim"><em class="icon ni ni-done"></em></div>
                                                                        <?php } else { ?>
                                                                            <div class="btn btn-outline-danger btn-dim"><em class="icon ni ni-na"></em></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-control form-file-input" id="file-uploader-residential-proof-image" name="employee_residential_proof_image" value="<?php echo $data['employee_residential_proof_image']; ?>">
                                                                        <label class="form-file-label" for="employee_residential_proof_image">Choose files</label>
                                                                        <div id="feedback-residential-proof-image"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 n-none" id="employeeTypes<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_type">Employee Type *</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-control form-select js-select2 employeeType" data-id="<?php echo $data['employee_id']; ?>" name="employee_type" data-placeholder="Select a type" required>
                                                                    <option label="empty" value=""></option>
                                                                    <option value="intern"<?php if($data['employee_type'] =="intern"){ echo "selected"; } else { echo ""; } ?>>Intern</option> 
                                                                    <option value="employee"<?php if($data['employee_type'] =="employee"){ echo "selected"; } else { echo ""; } ?>>Employee</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeInternshipMonth<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_internship_month">Employee Internship Month *</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control" name="employee_internship_month" value="<?php echo $data['employee_internship_month']; ?>" placeholder="Enter employee internship month" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeStipend<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_stipend">Employee Stipend *</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_stipend" value="<?php echo $data['employee_stipend']; ?>" placeholder="Enter employee stipend" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeContractDate<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_contract_date">Employee Contract Date *</label>
                                                            <div class="form-control-wrap">
                                                                <div class="form-icon form-icon-right"> 
                                                                    <em class="icon ni ni-calendar-alt"></em>
                                                                </div>
                                                                <input type="text" class="form-control date-picker" name="employee_contract_date" value="<?php echo $data['employee_contract_date']; ?>" placeholder="Enter employee contract date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeCompensation<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_compensation">Employee Compensation *</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_compensation" value="<?php echo $data['employee_compensation']; ?>" placeholder="Enter employee compensation" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeSalary<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_salary">Employee Salary *</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_salary" value="<?php echo $data['employee_salary']; ?>" placeholder="Enter employee salary" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeBankName<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_bank_name">Employee Bank Name</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_bank_name" value="<?php echo $data['employee_bank_name']; ?>" placeholder="Enter employee bank name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeAccountNo<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_account_no">Employee Account No</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_account_no" value="<?php echo $data['employee_account_no']; ?>" placeholder="Enter employee account no">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeChequeNo<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_cheque_no">Employee Cheque No</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_cheque_no" value="<?php echo $data['employee_cheque_no']; ?>" placeholder="Enter employee cheque no">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeConsentName<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_consent_name">Employee Consent Name</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="employee_consent_name" value="<?php echo $data['employee_consent_name']; ?>" placeholder="Enter employee consent name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeChequeImage<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_cheque_image">Employee Cheque Image</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <?php if(!empty($data['employee_cheque_image'])){ ?>
                                                                            <div class="btn btn-outline-success btn-dim"><em class="icon ni ni-done"></em></div>
                                                                        <?php } else { ?>
                                                                            <div class="btn btn-outline-danger btn-dim"><em class="icon ni ni-na"></em></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-control form-file-input" id="file-uploader-cheque-image" name="employee_cheque_image" value="<?php echo $data['employee_cheque_image']; ?>">
                                                                        <label class="form-file-label" for="employee_cheque_image">Choose files</label>
                                                                        <div id="feedback-cheque-image"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeExperienceCertificateImage<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_experience_certificate_image">Employee Experience Certificate Image</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <?php if(!empty($data['employee_experience_certificate_image'])){ ?>
                                                                            <div class="btn btn-outline-success btn-dim"><em class="icon ni ni-done"></em></div>
                                                                        <?php } else { ?>
                                                                            <div class="btn btn-outline-danger btn-dim"><em class="icon ni ni-na"></em></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-control form-file-input" id="file-uploader-experience-certificate-image" name="employee_experience_certificate_image" value="<?php echo $data['employee_experience_certificate_image']; ?>">
                                                                        <label class="form-file-label" for="employee_experience_certificate_image">Choose files</label>
                                                                        <div id="feedback-experience-certificate-image"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeRelievingLetterImage<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_relieving_letter_image">Employee Relieving Letter Image</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <?php if(!empty($data['employee_relieving_letter_image'])){ ?>
                                                                            <div class="btn btn-outline-success btn-dim"><em class="icon ni ni-done"></em></div>
                                                                        <?php } else { ?>
                                                                            <div class="btn btn-outline-danger btn-dim"><em class="icon ni ni-na"></em></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-control form-file-input" id="file-uploader-relieving-letter-image" name="employee_relieving_letter_image" value="<?php echo $data['employee_relieving_letter_image']; ?>">
                                                                        <label class="form-file-label" for="employee_relieving_letter_image">Choose files</label>
                                                                        <div id="feedback-relieving-letter-image"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 n-none" id="employeeSalarySlipImage<?php echo $data['employee_id']; ?>">
                                                        <div class="form-group">
                                                            <label class="form-label" for="employee_salary_slip_image">Employee Salary Slip Image</label>
                                                            <div class="form-control-wrap">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <?php if(!empty($data['employee_salary_slip_image'])){ ?>
                                                                            <div class="btn btn-outline-success btn-dim"><em class="icon ni ni-done"></em></div>
                                                                        <?php } else { ?>
                                                                            <div class="btn btn-outline-danger btn-dim"><em class="icon ni ni-na"></em></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="form-file">
                                                                        <input type="file" class="form-control form-file-input" id="file-uploader-salary-slip-image" name="employee_salary_slip_image" value="<?php echo $data['employee_salary_slip_image']; ?>">
                                                                        <label class="form-file-label" for="employee_salary_slip_image">Choose files</label>
                                                                        <div id="feedback-salary-slip-image"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="submit" class="btn btn-primary submitBtn" name="submit_selection" value="Update">
                                                            <input type="submit" class="btn btn-danger submitBtn" name="reset_selection" value="Reset">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <span class="sub-text"><?php echo $data['employee_first_name'].' '.$data['employee_middle_name'].' '.$data['employee_last_name'] ?></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="inactiveModal<?php echo urlEncodes($data['employee_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Inactive Employee</h5>
                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to inactive <?php echo $data['employee_first_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>edit-status-employee/<?php echo urlEncodes($data['employee_id']); ?>" class="btn btn-sm btn-danger submitBtn">Inactive</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="activeModal<?php echo urlEncodes($data['employee_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Active Employee</h5>
                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to active <?php echo $data['employee_first_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>edit-status-employee/<?php echo urlEncodes($data['employee_id']); ?>" class="btn btn-sm btn-success submitBtn">Active</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="offNoticePeriodModal<?php echo urlEncodes($data['employee_id']); ?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <form action="<?php echo base_url(); ?>edit-notice-period-employee/<?php echo urlEncodes($data['employee_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Notice Period Employee</h5>
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to off notice period for <?php echo $data['employee_first_name'];?>?</p>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <input type="submit" class="btn btn-danger submitBtn" name="cancel_notice_period" value="Off">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="onNoticePeriodModal<?php echo urlEncodes($data['employee_id']); ?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <form action="<?php echo base_url(); ?>edit-notice-period-employee/<?php echo urlEncodes($data['employee_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Notice Period Employee</h5>
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to on notice period for <?php echo $data['employee_first_name'];?>?</p>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <input type="submit" class="btn btn-primary submitBtn" name="submit_notice_period" value="On">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" id="trashModal<?php echo urlEncodes($data['employee_id']);?>">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Trash Employee</h5>
                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to trash <?php echo $data['employee_first_name'];?>?</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <span class="sub-text"><a href="<?php echo base_url(); ?>trash-employee/<?php echo urlEncodes($data['employee_id']); ?>" class="btn btn-sm btn-warning submitBtn">Trash</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="col-md-12">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="text-center">
                                        <img src="<?php echo base_url(); ?>source/images/no-data.png" width="300" height="190">
                                        <span class="sub-text mt-3">No data available in table</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="col-md-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="text-center">
                                    <img src="<?php echo base_url(); ?>source/images/no-permission.png" width="200" height="200">
                                    <span class="sub-text mt-3">You don't have permission to show the employee's data</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php if($isEmployeeView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-employee').addEventListener('change', function() {
        var selectedEmployee = this.value;
        $.ajax({
            url: '<?= base_url('view-employee'); ?>',
            type: 'POST',
            data: { search_employee_is_employee: selectedEmployee },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<script>
    document.getElementById('search-type').addEventListener('change', function() {
        var selectedType = this.value;
        $.ajax({
            url: '<?= base_url('view-employee'); ?>',
            type: 'POST',
            data: { search_employee_type: selectedType },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<script>
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        $.ajax({
            url: '<?= base_url('view-employee'); ?>',
            type: 'POST',
            data: { search_employee_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        function handleIsEmployeeChange() {
            var id = $(this).data('id');
            var selectedValue = $(this).val();
    
            if (selectedValue == 'selected') {
                $('#employeeRefFrom' + id).show();
                $('#employeeJoiningDate' + id).show();
                $('#employeeAccessCardNo' + id).show();
                $('#employeeQualification' + id).show();
                $('#employeeGender' + id).show();
                $('#employeePanFrontImage' + id).show();
                $('#employeePanBackImage' + id).show();
                $('#employeeAadharFrontImage' + id).show();
                $('#employeeAadharBackImage' + id).show();
                $('#employeeResidentialProofImage' + id).show();
                $('#employeeTypes' + id).show();
            } else {
                $('#employeeRefFrom' + id).show();
                $('#employeeJoiningDate' + id).hide();
                $('#employeeAccessCardNo' + id).hide();
                $('#employeeQualification' + id).hide();
                $('#employeeGender' + id).hide();
                $('#employeePanFrontImage' + id).hide();
                $('#employeePanBackImage' + id).hide();
                $('#employeeAadharFrontImage' + id).hide();
                $('#employeeAadharBackImage' + id).hide();
                $('#employeeResidentialProofImage' + id).hide();
                $('#employeeTypes' + id).hide();
                
                
                $('#employeeInternshipMonth' + id).hide();
                $('#employeeStipend' + id).hide();
                $('#employeeContractDate' + id).hide();
                $('#employeeCompensation' + id).hide();
                $('#employeeSalary' + id).hide();
                $('#employeeBankName' + id).hide();
                $('#employeeAccountNo' + id).hide();
                $('#employeeChequeNo' + id).hide();
                $('#employeeConsentName' + id).hide();
                $('#employeeChequeImage' + id).hide();
                $('#employeeExperienceCertificateImage' + id).hide();
                $('#employeeRelievingLetterImage' + id).hide();
                $('#employeeSalarySlipImage' + id).hide();
            }
            
        }

        $('.isEmployee').change(handleIsEmployeeChange);
    
        $('.isEmployee').each(function() {
            handleIsEmployeeChange.call(this);
        });

        $('form').submit(function() {
            $('.isEmployee').each(function() {
                var id = $(this).data('id');
                var selectedValue = $(this).val();
    
                if (selectedValue != 'selected') {
                    $('#employeeJoiningDate' + id).find('input').val('');
                    $('#employeeAccessCardNo' + id).find('input').val('');
                    $('#employeeQualification' + id).find('input').val('');
                    $('#employeeGender' + id).find('select').val('');
                    $('#employeePanFrontImage' + id).find('input').val('');
                    $('#employeePanBackImage' + id).find('input').val('');
                    $('#employeeAadharFrontImage' + id).find('input').val('');
                    $('#employeeAadharBackImage' + id).find('input').val('');
                    $('#employeeResidentialProofImage' + id).find('input').val('');
                    $('#employeeTypes' + id).find('select').val('');
                    
                    $('#employeeInternshipMonth' + id).find('input').val('');
                    $('#employeeStipend' + id).find('input').val('');
                    $('#employeeContractDate' + id).find('input').val('');
                    $('#employeeCompensation' + id).find('input').val('');
                    $('#employeeSalary' + id).find('input').val('');
                    $('#employeeBankName' + id).find('input').val('');
                    $('#employeeAccountNo' + id).find('input').val('');
                    $('#employeeChequeNo' + id).find('input').val('');
                    $('#employeeConsentName' + id).find('input').val('');
                    $('#employeeChequeImage' + id).find('input').val('');
                    $('#employeeExperienceCertificateImage' + id).find('input').val('');
                    $('#employeeRelievingLetterImage' + id).find('input').val('');
                    $('#employeeSalarySlipImage' + id).find('input').val('');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        function handleEmployeeTypeChange() {
            var id = $(this).data('id');
            var selectedValue = $(this).val();
    
            if (selectedValue == 'intern') {
                $('#employeeInternshipMonth' + id).show();
                $('#employeeStipend' + id).show();
            } else {
                $('#employeeInternshipMonth' + id).hide();
                $('#employeeStipend' + id).hide();
            }
            
            if (selectedValue == 'employee') {
                $('#employeeContractDate' + id).show();
                $('#employeeCompensation' + id).show();
                $('#employeeSalary' + id).show();
                $('#employeeBankName' + id).show();
                $('#employeeAccountNo' + id).show();
                $('#employeeChequeNo' + id).show();
                $('#employeeConsentName' + id).show();
                $('#employeeChequeImage' + id).show();
                $('#employeeExperienceCertificateImage' + id).show();
                $('#employeeRelievingLetterImage' + id).show();
                $('#employeeSalarySlipImage' + id).show();
            } else {
                $('#employeeContractDate' + id).hide();
                $('#employeeCompensation' + id).hide();
                $('#employeeSalary' + id).hide();
                $('#employeeBankName' + id).hide();
                $('#employeeAccountNo' + id).hide();
                $('#employeeChequeNo' + id).hide();
                $('#employeeConsentName' + id).hide();
                $('#employeeChequeImage' + id).hide();
                $('#employeeExperienceCertificateImage' + id).hide();
                $('#employeeRelievingLetterImage' + id).hide();
                $('#employeeSalarySlipImage' + id).hide();
            }
        }

        $('.employeeType').change(handleEmployeeTypeChange);
    
        $('.employeeType').each(function() {
            handleEmployeeTypeChange.call(this);
        });
    });
</script>

<script>
    const fileUploaderPanFrontImage = document.getElementById('file-uploader-pan-front-image');
    const feedbackPanFrontImage = document.getElementById('feedback-pan-front-image');

    fileUploaderPanFrontImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackPanFrontImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF or WEBP image. </span>`;
                return;
            } else {
                feedbackPanFrontImage.innerHTML = ` `;
                return;
            } 
        }
    });
</script>

<script>
    const fileUploaderPanBackImage = document.getElementById('file-uploader-pan-back-image');
    const feedbackPanBackImage = document.getElementById('feedback-pan-back-image');

    fileUploaderPanBackImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackPanBackImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF or WEBP image. </span>`;
                return;
            } else {
                feedbackPanBackImage.innerHTML = ` `;
                return;
            } 
        }
    });
</script>

<script>
    const fileUploaderAadharFrontImage = document.getElementById('file-uploader-aadhar-front-image');
    const feedbackAadharFrontImage = document.getElementById('feedback-aadhar-front-image');

    fileUploaderAadharFrontImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackAadharFrontImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF or WEBP image. </span>`;
                return;
            } else {
                feedbackAadharFrontImage.innerHTML = ` `;
                return;
            } 
        }
    });
</script>

<script>
    const fileUploaderAadharBackImage = document.getElementById('file-uploader-aadhar-back-image');
    const feedbackAadharBackImage = document.getElementById('feedback-aadhar-back-image');

    fileUploaderAadharBackImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackAadharBackImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF or WEBP image. </span>`;
                return;
            } else {
                feedbackAadharBackImage.innerHTML = ` `;
                return;
            } 
        }
    });
</script>

<script>
    const fileUploaderResidentialProofImage = document.getElementById('file-uploader-residential-proof-image');
    const feedbackResidentialProofImage = document.getElementById('feedback-residential-proof-image');

    fileUploaderResidentialProofImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackResidentialProofImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF or WEBP image. </span>`;
                return;
            } else {
                feedbackResidentialProofImage.innerHTML = ` `;
                return;
            } 
        }
    });
</script>

<script>
    const fileUploaderChequeImage = document.getElementById('file-uploader-cheque-image');
    const feedbackChequeImage = document.getElementById('feedback-cheque-image');

    fileUploaderChequeImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackChequeImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF or WEBP image. </span>`;
                return;
            } else { 
                feedbackChequeImage.innerHTML = ` `;
                return;
            } 
        }
    });
</script>

<script>
    const fileUploaderExperienceCertificateImage = document.getElementById('file-uploader-experience-certificate-image');
    const feedbackExperienceCertificateImage = document.getElementById('feedback-experience-certificate-image');

    fileUploaderExperienceCertificateImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackExperienceCertificateImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF or WEBP image. </span>`;
                return;
            } else {
                feedbackExperienceCertificateImage.innerHTML = ` `;
                return;
            } 
        }
    });
</script>

<script>
    const fileUploaderRelievingLetterImage = document.getElementById('file-uploader-relieving-letter-image');
    const feedbackRelievingLetterImage = document.getElementById('feedback-relieving-letter-image');

    fileUploaderRelievingLetterImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackRelievingLetterImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF or WEBP image. </span>`;
                return;
            } else {
                feedbackRelievingLetterImage.innerHTML = ` `;
                return;
            } 
        }
    });
</script>

<script>
    const fileUploaderSalarySlipImage = document.getElementById('file-uploader-salary-slip-image');
    const feedbackSalarySlipImage = document.getElementById('feedback-salary-slip-image');

    fileUploaderSalarySlipImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackSalarySlipImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF or WEBP image. </span>`;
                return;
            } else {
                feedbackSalarySlipImage.innerHTML = ` `;
                return;
            } 
        }
    });
</script>