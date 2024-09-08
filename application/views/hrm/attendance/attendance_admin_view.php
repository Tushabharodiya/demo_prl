<?php
    $isAttendanceAdminView = checkPermission(HRM_ATTENDANCE_ADMIN_ALIAS, "can_view");
    $isAttendanceAdminEdit = checkPermission(HRM_ATTENDANCE_ADMIN_ALIAS, "can_edit");

    $sessionAttendanceAdminViewPreviousUrl = $this->session->userdata('session_attendance_admin_view_previous_url');

    $sessionAttendanceAdmin = $this->session->userdata('session_attendance_admin');
    $sessionAttendanceAdminType = $this->session->userdata('session_attendance_admin_type');
    $sessionAttendanceAdminStatus = $this->session->userdata('session_attendance_admin_status');
    $sessionAttendanceAdminWorkingStartDate = $this->session->userdata('session_attendance_admin_working_start_date');
    $sessionAttendanceAdminWorkingEndDate = $this->session->userdata('session_attendance_admin_working_end_date');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Attendance</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isAttendanceAdminView){ ?>
                            <p><?php echo "You have total $countAttendance attendances."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isAttendanceAdminView){ ?>
                                    <li>
                                        <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="dropdown">
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter Attendance</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Type</label>
                                                                    <select class="form-control form-select" id="search-type" name="search_attendance_admin_type" data-placeholder="Select a type">
                                                                        <?php $str='';
                                                                            if(!empty($sessionAttendanceAdminType == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAttendanceAdminType == 'pending')){
                                                                                $str.='selected';
                                                                        } ?> <option value="pending"<?php echo $str; ?>>Pending</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAttendanceAdminType == 'approved')){
                                                                                $str.='selected';
                                                                        } ?> <option value="approved"<?php echo $str; ?>>Approved</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAttendanceAdminType == 'rejected')){
                                                                                $str.='selected';
                                                                        } ?> <option value="rejected"<?php echo $str; ?>>Rejected</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                    <select class="form-control form-select" id="search-status" name="search_attendance_admin_status" data-placeholder="Select a status">
                                                                        <?php $str='';
                                                                            if(!empty($sessionAttendanceAdminStatus == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAttendanceAdminStatus == 'active')){
                                                                                $str.='selected';
                                                                        } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAttendanceAdminStatus == 'inactive')){
                                                                                $str.='selected';
                                                                        } ?> <option value="inactive"<?php echo $str; ?>>Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Working Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="input-daterange date-picker-range input-group">
                                                                            <input type="text" class="form-control date-picker" name="search_attendance_admin_working_start_date" value="<?php if(!empty($sessionAttendanceAdminWorkingStartDate)){ echo $sessionAttendanceAdminWorkingStartDate; } ?>" placeholder="Enter start date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                                                            <div class="input-group-addon">TO</div>
                                                                            <input type="text" class="form-control date-picker" name="search_attendance_admin_working_end_date" value="<?php if(!empty($sessionAttendanceAdminWorkingEndDate)){ echo $sessionAttendanceAdminWorkingEndDate; } ?>" placeholder="Enter end date" data-date-format="dd/mm/yyyy" autocomplete="off">
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
                                        <li><a href="<?php echo base_url(); ?>view-trash-admin-attendance" class="btn btn-white btn-outline-light"><em class="icon ni ni-trash-fill"></em><span>Trash <sup><?php echo $countAttendanceTrash; ?></sup></span></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if(!empty($sessionAttendanceAdmin) && !empty($sessionAttendanceAdminWorkingStartDate) && !empty($sessionAttendanceAdminWorkingEndDate)){ ?>
            <div class="example-alerts">
                <div class="row gy-4">
                    <div class="col-md-2">
                        <div class="example-alert">
                            <div class="alert alert-light text-center">
                                <div class="btn btn-p-0 btn-nofocus"><em class="icon ni ni-alarm-alt"></em><span><?php echo calculateWorkingDaysBetweenDates($sessionAttendanceAdminWorkingStartDate, $sessionAttendanceAdminWorkingEndDate); ?></span></div>
                                <span class="btn btn-p-0 btn-nofocus">Working Days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="example-alert">
                            <div class="alert alert-light text-center">
                                <div class="btn btn-p-0 btn-nofocus"><em class="icon ni ni-alarm"></em><span><?php echo $workedDays; ?></span></div>
                                <span class="btn btn-p-0 btn-nofocus">Worked Days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="example-alert">
                            <div class="alert alert-light text-center">
                                <div class="btn btn-p-0 btn-nofocus"><em class="icon ni ni-building"></em><span><?php echo calculateWorkingDaysBetweenDates($sessionAttendanceAdminWorkingStartDate, $sessionAttendanceAdminWorkingEndDate) * WORKING_HOURS.":00" ; ?></span></div>
                                <span class="btn btn-p-0 btn-nofocus">Working Hours</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="example-alert">
                            <div class="alert alert-light text-center">
                                <div class="btn btn-p-0 btn-nofocus"><em class="icon ni ni-bag"></em><span><?php echo $workedHours; ?></span></div>
                                <span class="btn btn-p-0 btn-nofocus">Worked Hours</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="example-alert">
                            <div class="alert alert-light text-center">
                                <div class="btn btn-p-0 btn-nofocus"><em class="icon ni ni-calendar-alt"></em><span><?php echo $overtimeHours; ?></span></div>
                                <span class="btn btn-p-0 btn-nofocus">Overtime Hours</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="example-alert">
                            <div class="alert alert-light text-center">
                                <div class="btn btn-p-0 btn-nofocus"><em class="icon ni ni-calendar"></em><span><?php echo $belowtimeHours; ?></span></div>
                                <span class="btn btn-p-0 btn-nofocus">Belowtime Hours</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        
        <?php if($isAttendanceAdminView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_attendance_admin" value="<?php if(!empty($sessionAttendanceAdmin)){ echo $sessionAttendanceAdmin; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_attendance_admin_edit_approved_overtime_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_attendance_admin_edit_approved_overtime_success'); $this->session->unset_userdata('session_attendance_admin_edit_approved_overtime_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_attendance_admin_edit_approved_belowtime_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_attendance_admin_edit_approved_belowtime_success'); $this->session->unset_userdata('session_attendance_admin_edit_approved_belowtime_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_attendance_admin_edit_rejected_overtime_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_attendance_admin_edit_rejected_overtime_error'); $this->session->unset_userdata('session_attendance_admin_edit_rejected_overtime_error'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_attendance_admin_edit_rejected_belowtime_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_attendance_admin_edit_rejected_belowtime_error'); $this->session->unset_userdata('session_attendance_admin_edit_rejected_belowtime_error'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_attendance_admin_trash_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_attendance_admin_trash_success'); $this->session->unset_userdata('session_attendance_admin_trash_success'); ?>
            </div>
        <?php } ?>

        <div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner p-0">
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="table-responsive">
                                <table class="table table-tranx">
                                    <thead>
                                        <tr class="tb-tnx-head">
                                            <th class="nk-tb-col" width="10%"><span>ID</span></th>
                                            <th class="nk-tb-col" width="20%"><span>Employee</span></th>
                                            <th class="nk-tb-col" width="14%"><span>Department</span></th>
                                            <th class="nk-tb-col" width="8%"><span>Date</span></th>
                                            <th class="nk-tb-col" width="7%"><span>Hours</span></th>
                                            <th class="nk-tb-col" width="7%"><span>Overtime</span></th>
                                            <th class="nk-tb-col" width="7%"><span>Belowtime</span></th>
                                            <th class="nk-tb-col" width="5%"><span>Half</span></th>
                                            <th class="nk-tb-col" width="5%"><span>Short</span></th>
                                            <th class="nk-tb-col" width="7%"><span>Type</span></th>
                                            <th class="nk-tb-col" width="5%"><span>Status</span></th>
                                            <th class="nk-tb-col text-end" width="5%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if($isAttendanceAdminView){ ?>
                                        <?php if(!empty($viewAttendance)){ ?>
                                            <tbody>
                                                <?php foreach($viewAttendance as $data){ ?>
                                                    <tr class="tb-tnx-item">
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['working_id']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <div class="user-card">
                                                                <?php if(!empty($data['employeeData']['employee_photo'] && $data['employeeData']['employee_photo'] != "Unknown")){ ?>
                                                                    <div class="user-avatar bg-light">
                                                                        <a class="gallery-image popup-image" href="<?php echo base_url();?>uploads/hrm/employee_photo/<?php echo $data['employeeData']['employee_photo']; ?>">
                                                                            <img src="<?php echo base_url();?>uploads/hrm/employee_photo/<?php echo $data['employeeData']['employee_photo']; ?>" class="rounded-circle" height="40" width="40">
                                                                        </a>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="user-avatar bg-light">
                                                                        <em class="icon ni ni-user-alt-fill"></em>
                                                                    </div>
                                                                <?php } ?>
                                                                <a data-bs-toggle="modal" data-bs-target="#infoModal<?php echo urlEncodes($data['working_id']);?>">
                                                                    <div class="user-info ms-3">
                                                                        <span class="tb-lead"><?php echo $data['employeeData']['employee_first_name']; ?> <?php echo $data['employeeData']['employee_middle_name']; ?> <?php echo $data['employeeData']['employee_last_name']; ?></span>
                                                                        <span><?php echo $data['employeeData']['employee_email']; ?></span>
                                                                    </div>
                                                                </a>               
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['departmentData']['department_name']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['working_date']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php if(!empty($data['working_hours'])){ echo $data['working_hours']; } else { echo "00:00"; } ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php if(!empty($data['working_overtime_hours'])){ echo $data['working_overtime_hours']; } else { echo "00:00"; } ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php if(!empty($data['working_belowtime_hours'])){ echo $data['working_belowtime_hours']; } else { echo "00:00"; } ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span><?php 
                                                                if(!empty($data['leaveData']['leave_from_date']) and !empty($data['leaveData']['leave_to_date']) and $data['leaveData']['leave_type'] == 'half' and $data['leaveData']['is_leave'] == 'approved'){ ?>
                                                                    <em class="icon ni ni-check-circle text-success"></em>
                                                                <?php } else { ?>
                                                                    <em class="icon ni ni-cross-circle text-danger"></em>  
                                                                <?php } ?>
                                                            </span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span><?php 
                                                                if(!empty($data['leaveData']['leave_from_date']) and !empty($data['leaveData']['leave_to_date']) and $data['leaveData']['leave_type'] == 'short' and $data['leaveData']['is_leave'] == 'approved'){ ?>
                                                                    <em class="icon ni ni-check-circle text-success"></em>
                                                                <?php } else { ?>
                                                                    <em class="icon ni ni-cross-circle text-danger"></em>  
                                                                <?php } ?>
                                                            </span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span><?php 
                                                                if(!empty($data['working_type'])){
                                                                    $workingType = '';
                                                                    if($data['working_type'] == 'pending'){
                                                                        $workingType.= '<span class="tb-status text-warning">Pending</span>';
                                                                    } else if($data['working_type'] == 'approved'){
                                                                        $workingType.= '<span class="tb-status text-success">Approved</span>';
                                                                    } else if($data['working_type'] == 'rejected'){
                                                                        $workingType.= '<span class="tb-status text-danger">Rejected</span>';
                                                                    }
                                                                    echo $workingType; 
                                                                } else {
                                                                    echo "-";
                                                                }
                                                            ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span><?php 
                                                                $employeeStatus = '';
                                                                if($data['employeeData']['employee_status'] == 'draft'){
                                                                    $employeeStatus.= '<span class="tb-status text-primary">Draft</span>';
                                                                } else if($data['employeeData']['employee_status'] == 'active'){
                                                                    $employeeStatus.= '<span class="tb-status text-success">Active</span>';
                                                                } else if($data['employeeData']['employee_status'] == 'inactive'){
                                                                    $employeeStatus.= '<span class="tb-status text-danger">Inactive</span>';
                                                                }
                                                                echo $employeeStatus; 
                                                            ?></span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <li>
                                                                    <div class="drodown">
                                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <?php if($isAttendanceAdminEdit){ ?>
                                                                                    <?php if($data['punch_status'] == 'true'){ ?>
                                                                                        <li><a data-bs-toggle="modal" data-bs-target="#attendanceModal<?php echo urlEncodes($data['working_id']); ?>"><em class="icon ni ni-alarm"></em><span>Attendance</span></a></li>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                                <?php if($isAttendanceAdminEdit){ ?>
                                                                                    <?php if($data['punch_status'] == 'true'){ ?>
                                                                                        <li><a data-bs-toggle="modal" data-bs-target="#editModal<?php echo urlEncodes($data['working_id']); ?>"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                                        <li><a data-bs-toggle="modal" data-bs-target="#trashModal<?php echo urlEncodes($data['working_id']); ?>"><em class="icon ni ni-trash-fill"></em><span>Trash</span></a></li>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade zoom" tabindex="-1" id="infoModal<?php echo urlEncodes($data['working_id']); ?>">
                                                        <div class="modal-dialog modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Attendance Info</h5>
                                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <em class="icon ni ni-cross"></em>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="nk-block">
                                                                        <div class="row g-gs">
                                                                            <div class="col-md-6">
                                                                                <div class="card card-bordered">
                                                                                    <div class="card-inner border-bottom">
                                                                                        <div class="card-title-group">
                                                                                            <div class="card-title">
                                                                                                <h6><span class="title">Timesheet</span> <span class="timeline-head"><?php if(!empty($data['working_date'])){ $workingDate = DateTime::createFromFormat('d/m/Y', $data['working_date']); echo $workingDate->format('d M Y'); } ?></span></h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-inner">
                                                                                        <?php 
                                                                                            if(!empty($data['working_start_time'])){ 
                                                                                                $workingStartTime = $data['working_start_time']; 
                                                                                                $startTimes = explode(",", $workingStartTime);
                                                                                                $firstPunchIn = reset($startTimes);
                                                                                                $firstTimestamps = strtotime($firstPunchIn); 
                                                                                            }
                                                                                            
                                                                                            if(!empty($data['working_end_time'])){
                                                                                                $workingEndTime = $data['working_end_time']; 
                                                                                                $endTimes = explode(",", $workingEndTime); 
                                                                                                $lastPunchOut = end($endTimes);
                                                                                                $lastTimestamps = strtotime($lastPunchOut);
                                                                                            }  
                                                                                        ?>
                                                                                        <div class="card card-bordered p-3 bg-lighter">
                                                                                            <span class="tb-lead">Punch In at</span>
                                                                                            <span class="sub-text"><?php if(!empty($data['working_start_time'])){ $workingDate = DateTime::createFromFormat('d/m/Y', $data['working_date']); echo $workingDate->format('D, jS M Y'); ?> <?php echo date('h:i A', $firstTimestamps); } ?></span>
                                                                                        </div>
                                                                                        <div class="center">
                                                                                            <div class="user-avatar xl bg-lighter border border-lighter mt-3">
                                                                                                <h6><span class="tb-lead"><?php if(!empty($data['working_hours'])){ echo $data['working_hours']; } else { echo "00:00"; } ?> hrs</span></h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="card card-bordered p-3 bg-lighter mt-3">
                                                                                            <span class="tb-lead">Punch Out at</span>
                                                                                            <span class="sub-text"><?php if(!empty($data['working_end_time'])){ $workingDate = DateTime::createFromFormat('d/m/Y', $data['working_date']); echo $workingDate->format('D, jS M Y'); ?> <?php echo date('h:i A', $lastTimestamps); } ?></span>
                                                                                        </div>
                                                                                        <div class="row g-gs">
                                                                                            <div class="col-md-6">
                                                                                                <div class="card card-bordered p-1 bg-lighter mt-3 text-center">
                                                                                                    <span class="tb-lead">Break</span>
                                                                                                    <span class="sub-text"><?php echo BREAK_TIME; ?></span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php if($data['working_belowtime_hours'] != null && isset($data['working_belowtime_hours']) && $data['working_belowtime_hours'] != "00:00"){ ?>
                                                                                                <div class="col-md-6">
                                                                                                    <div class="card card-bordered p-1 bg-lighter mt-3 text-center">
                                                                                                        <span class="tb-lead">Belowtime</span>
                                                                                                        <span class="sub-text"><?php if(!empty($data['working_belowtime_hours'])){ echo $data['working_belowtime_hours']; } else { echo "00:00"; } ?> hrs</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <?php } else { ?>
                                                                                                <div class="col-md-6">
                                                                                                    <div class="card card-bordered p-1 bg-lighter mt-3 text-center">
                                                                                                        <span class="tb-lead">Overtime</span>
                                                                                                        <span class="sub-text"><?php if(!empty($data['working_overtime_hours'])){ echo $data['working_overtime_hours']; } else { echo "00:00"; } ?> hrs</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="card card-bordered">
                                                                                    <div class="card-inner border-bottom">
                                                                                        <div class="card-title-group">
                                                                                            <div class="card-title">
                                                                                                <h6 class="title">Activity</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-inner">
                                                                                        <div class="timeline">
                                                                                            <h6 class="timeline-head"><?php if(!empty($data['working_date'])){ $date = DateTime::createFromFormat('d/m/Y', $data['working_date']); echo $date->format('F, Y'); } ?></h6>
                                                                                            <ul class="timeline-list">
                                                                                                <?php 
                                                                                                    if(!empty($data['working_start_time'])){ 
                                                                                                        $workingStartTime = $data['working_start_time'];
                                                                                                        $startTimes = explode(",", $workingStartTime);
                                                                                                    }
                                                                                                    
                                                                                                    if(!empty($data['working_end_time'])){
                                                                                                        $workingEndTime = $data['working_end_time'];
                                                                                                        $endTimes = explode(",", $workingEndTime);
                                                                                                    }  
                                                                                                ?>
                                                                                                <?php for ($i = 0; $i < count($startTimes); $i++) { ?>
                                                                                                    <?php if(!empty($startTimes[$i])){ ?>
                                                                                                        <li class="timeline-item">
                                                                                                            <div class="timeline-status bg-success is-outline"></div>
                                                                                                            <div class="timeline-date"><?php $workingDate = DateTime::createFromFormat('d/m/Y', $data['working_date']); echo $workingDate->format('d M');?> <em class="icon ni ni-alarm-alt"></em></div>
                                                                                                            <div class="timeline-data">
                                                                                                                <h6 class="timeline-title">Punch In at</h6>
                                                                                                                <div class="timeline-des">
                                                                                                                    <span class="time"><?php $startTimestamps = strtotime($startTimes[$i]); echo date('h:i A', $startTimestamps) . "<br>"; ?></span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </li>
                                                                                                    <?php } ?>
                                                                                                    <?php if(!empty($endTimes[$i])){ ?>
                                                                                                        <li class="timeline-item">
                                                                                                            <div class="timeline-status bg-danger is-outline"></div>
                                                                                                            <div class="timeline-date"><?php $workingDate = DateTime::createFromFormat('d/m/Y', $data['working_date']); echo $workingDate->format('d M');?> <em class="icon ni ni-alarm-alt"></em></div>
                                                                                                            <div class="timeline-data">
                                                                                                                <h6 class="timeline-title">Punch Out at</h6>
                                                                                                                <div class="timeline-des">
                                                                                                                    <span class="time"><?php $endTimestamp = strtotime($endTimes[$i]); echo date('h:i A', $endTimestamp) . "<br>"; ?></span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </li>
                                                                                                    <?php } ?>
                                                                                                <?php } ?>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer bg-light">
                                                                    <span class="sub-text"><?php echo $data['employeeData']['employee_first_name']; ?> <?php echo $data['employeeData']['employee_middle_name']; ?> <?php echo $data['employeeData']['employee_last_name']; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" tabindex="-1" id="attendanceModal<?php echo urlEncodes($data['working_id']); ?>">
                                                        <div class="modal-dialog modal-dialog-top" role="document">
                                                            <div class="modal-content">
                                                                <form action="<?php echo base_url(); ?>edit-admin-attendance/<?php echo urlEncodes($data['working_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Approve Attendance</h5>
                                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <em class="icon ni ni-cross"></em>
                                                                        </a>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to approved <?php echo $data['employeeData']['employee_first_name']; ?>?</p>
                                                                        <?php
                                                                            if($data['punch_status'] == 'true'){
                                                                                if(!empty($data['working_start_time'])){ 
                                                                                    $originalStartTime = $data['working_start_time'];
                                                                                    $startTimes = explode(',', $originalStartTime);
                                                                                    $workingStartTime = array_map('trim', $startTimes);
                                                                                }
                                                                                
                                                                                if(!empty($data['working_end_time'])){ 
                                                                                    $originalEndTime = $data['working_end_time'];
                                                                                    $endTimes = explode(',', $originalEndTime);
                                                                                    $workingEndTime = array_map('trim', $endTimes);
                                                                                }
                                                                                
                                                                                $totalMinutes = 0;
                                                                                
                                                                                for($i = 0; $i < count($workingStartTime); $i++){
                                                                                    $startTime = DateTime::createFromFormat('H:i', $workingStartTime[$i]);
                                                                                    $endTime = DateTime::createFromFormat('H:i', $workingEndTime[$i]);
                                                                                
                                                                                    $interval = ($endTime->getTimestamp() - $startTime->getTimestamp()) / 60; 
                                                                                    $totalMinutes += $interval;
                                                                                }
                                                                                
                                                                                $totalHours = floor($totalMinutes / 60);
                                                                                $totalMinutes %= 60;
                                                                                
                                                                                $totalHoursFormatted = sprintf("%02d", $totalHours);
                                                                                $totalMinutesFormatted = sprintf("%02d", $totalMinutes);
                                                                                $totalHours = $totalHoursFormatted.':'.$totalMinutesFormatted;
                                                                                
                                                                                $totalTime = $totalHours;
                                                                                list($hours, $minutes) = explode(':', $totalTime);
                                                                                
                                                                                $hours = (int)$hours;
                                                                                $minutes = (int)$minutes;
                                                                                
                                                                                $workingHours = WORKING_HOURS;
                                                                                $workingMinutes = 0;
                                                                                
                                                                                // Overtime calculation
                                                                                if($hours > $workingHours || ($hours == $workingHours && $minutes > $workingMinutes)){
                                                                                    $overtimeHours = $hours - $workingHours;
                                                                                    $overtimeMinutes = $minutes - $workingMinutes;
                                                                                
                                                                                    $overtime = sprintf("%02d:%02d", $overtimeHours, $overtimeMinutes);
                                                                                    $totalOvertimeHours = $overtime;
                                                                                } else {
                                                                                    $totalOvertimeHours = "00:00";
                                                                                }
                                                                                
                                                                                list($overtimeHours, $overtimeMinutes) = explode(':', $totalOvertimeHours);
                                                                                $totalOvertimeMinutes = ($overtimeHours * 60) + $overtimeMinutes;
                                                                                
                                                                                // Belowtime calculation
                                                                                if ($hours < $workingHours || ($hours == $workingHours && $minutes < $workingMinutes)) {
                                                                                    $belowtimeHours = $workingHours - $hours;
                                                                                    $belowtimeMinutes = $workingMinutes - $minutes;
                                                                                
                                                                                    if ($belowtimeMinutes < 0) {
                                                                                        $belowtimeMinutes += 60;
                                                                                        $belowtimeHours -= 1;
                                                                                    }
                                                                                
                                                                                    $belowtime = sprintf("%02d:%02d", $belowtimeHours, $belowtimeMinutes);
                                                                                    $totalBelowtimeHours = $belowtime;
                                                                                } else {
                                                                                    $totalBelowtimeHours = "00:00";
                                                                                }
                                                                                
                                                                                list($belowtimeHours, $belowtimeMinutes) = explode(':', $totalBelowtimeHours);
                                                                                $totalBelowtimeMinutes = ($belowtimeHours * 60) + $belowtimeMinutes;
                                                                            }
                                                                        ?>
                                                                        <div class="row g-gs">
                                                                            <div class="col-md-6">
                                                                                <div class="card card-bordered p-3 bg-lighter text-center">
                                                                                    <span class="tb-lead">Total Hours</span>
                                                                                    <span class="sub-text"><input type="text" class="form-control" name="working_hours" value="<?php echo $totalHours; ?>" placeholder="Enter working hours" required readonly></span>
                                                                                </div>
                                                                            </div>
                                                                            <?php if($totalBelowtimeHours != "00:00"){ ?>
                                                                                <div class="col-md-6">
                                                                                    <div class="card card-bordered p-3 bg-lighter text-center">
                                                                                        <span class="tb-lead">Belowtime Hours</span>
                                                                                        <span class="sub-text"><input type="text" class="form-control" name="working_belowtime_hours" value="<?php echo $totalBelowtimeHours; ?>" placeholder="Enter working belowtime hours" required></span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <div class="col-md-6">
                                                                                    <div class="card card-bordered p-3 bg-lighter text-center">
                                                                                        <span class="tb-lead">Overtime Hours</span>
                                                                                        <span class="sub-text"><input type="text" class="form-control" name="working_overtime_hours" value="<?php echo $totalOvertimeHours; ?>" placeholder="Enter working overtime hours" required></span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer bg-light">
                                                                        <span class="sub-text"><input type="submit" class="btn btn-sm btn-success submitBtn" name="submit_attendance_approved" value="Approved"></span>
                                                                        <span class="sub-text"><input type="submit" class="btn btn-sm btn-danger submitBtn" name="submit_attendance_rejected" value="Rejected"></span>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="editModal<?php echo urlEncodes($data['working_id']); ?>">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form action="<?php echo base_url(); ?>edit-admin-attendance/<?php echo urlEncodes($data['working_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Attendance</h5>
                                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <em class="icon ni ni-cross"></em>
                                                                        </a>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row gy-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="form-label" for="working_date">Working Date *</label>
                                                                                    <div class="form-control-wrap">
                                                                                        <div class="form-icon form-icon-right">
                                                                                            <em class="icon ni ni-calendar-alt"></em>
                                                                                        </div>
                                                                                        <input type="text" class="form-control date-picker" name="working_date" value="<?php echo $data['attendanceData']['working_date']; ?>" placeholder="Enter working date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="form-label" for="working_start_time">Working Start Time *</label>
                                                                                    <div class="form-control-wrap">
                                                                                        <input type="text" class="form-control js-tagify tagify" name="working_start_time" value="<?php echo $data['attendanceData']['working_start_time']; ?>" placeholder="Enter working start time" autocomplete="off" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="form-label" for="working_end_time">Working End Time *</label>
                                                                                    <div class="form-control-wrap">
                                                                                        <input type="text" class="form-control js-tagify tagify" name="working_end_time" value="<?php echo $data['attendanceData']['working_end_time']; ?>" placeholder="Enter working end time" autocomplete="off" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <input type="submit" class="btn btn-primary submitBtn" name="submit" value="Update">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" tabindex="-1" id="trashModal<?php echo urlEncodes($data['working_id']); ?>">
                                                        <div class="modal-dialog modal-dialog-top" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Trash Attendance</h5>
                                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <em class="icon ni ni-cross"></em>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to trash <?php echo $data['employeeData']['employee_first_name']; ?>?</p>
                                                                </div>
                                                                <div class="modal-footer bg-light">
                                                                    <span class="sub-text"><a href="<?php echo base_url(); ?>trash-admin-attendance/<?php echo urlEncodes($data['working_id']); ?>" class="btn btn-sm btn-warning submitBtn">Trash</a></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </tbody>
                                        <?php } else { ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="nk-block-content text-center p-3">
                                                            <span class="sub-text">No data available in table</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="12">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">You don't have permission to show the attendance's data</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($isAttendanceAdminView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-type').addEventListener('change', function() {
        var selectedType = this.value;
        $.ajax({
            url: '<?= base_url('view-admin-attendance'); ?>',
            type: 'POST',
            data: { search_attendance_admin_type: selectedType },
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
            url: '<?= base_url('view-admin-attendance'); ?>',
            type: 'POST',
            data: { search_attendance_admin_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>