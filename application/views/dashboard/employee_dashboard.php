<?php
    $isEmployeeDashboardView = checkPermission(EMPLOYEE_DASHBOARD_ALIAS, "can_view");
    
    $isAttendanceEmployeeAdd = checkPermission(HRM_ATTENDANCE_EMPLOYEE_ALIAS, "can_add");
    $isAttendanceEmployeeView = checkPermission(HRM_ATTENDANCE_EMPLOYEE_ALIAS, "can_view");
    $isAttendanceEmployeeEdit = checkPermission(HRM_ATTENDANCE_EMPLOYEE_ALIAS, "can_edit");
    
    $isLeaveEmployeeAdd = checkPermission(HRM_LEAVE_EMPLOYEE_ALIAS, "can_add");
    $isLeaveEmployeeView = checkPermission(HRM_LEAVE_EMPLOYEE_ALIAS, "can_view");
    
    $isHolidayView = checkPermission(HRM_HOLIDAY_ALIAS, "can_view");
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
        
        <?php if(!empty($this->session->userdata('session_attendance_employee_dashboard_first_punch_in_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_attendance_employee_dashboard_first_punch_in_success'); $this->session->unset_userdata('session_attendance_employee_dashboard_first_punch_in_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_attendance_employee_dashboard_first_punch_out_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_attendance_employee_dashboard_first_punch_out_error'); $this->session->unset_userdata('session_attendance_employee_dashboard_first_punch_out_error'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_attendance_employee_dashboard_second_punch_in_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_attendance_employee_dashboard_second_punch_in_success'); $this->session->unset_userdata('session_attendance_employee_dashboard_second_punch_in_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_attendance_employee_dashboard_second_punch_out_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_attendance_employee_dashboard_second_punch_out_error'); $this->session->unset_userdata('session_attendance_employee_dashboard_second_punch_out_error'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_logout_attendance_employee_dashboard_punch_out_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_logout_attendance_employee_dashboard_punch_out_error'); $this->session->unset_userdata('session_logout_attendance_employee_dashboard_punch_out_error'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_leave_employee_dashboard_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_leave_employee_dashboard_success'); $this->session->unset_userdata('session_leave_employee_dashboard_success'); ?>
            </div>
        <?php } ?>
        
        <?php if($isEmployeeDashboardView){ ?>
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-md-5">
                        <div class="card card-bordered h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <span class="user-card">
                                                <span class="user-avatar bg-secondary-dim sq mds">
                                                    <img src="<?php echo base_url(); ?>source/images/dashboard/my-log.png">
                                                </span>
                                                <span class="user-info">
                                                     <h6><span class="text-secondary">My Log</span> <span class="timeline-head"><?php if(!empty($attendanceData['working_date'])){ $workingDate = DateTime::createFromFormat('d/m/Y', $attendanceData['working_date']); echo $workingDate->format('d M Y'); } ?></span></h6>
                                                </span>
                                            </span>
                                        </h6>
                                    </div>
                                    <?php if($isAttendanceEmployeeView){ ?>
                                        <div class="card-action">
                                            <a href="<?php echo base_url(); ?>view-employee-attendance" class="link link-sm">View All<em class="icon ni ni-chevron-right"></em></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if($isAttendanceEmployeeView){ ?>
                                <div class="card-inner">
                                    <?php 
                                        if(!empty($attendanceData['working_start_time'])){ 
                                            $workingStartTime = $attendanceData['working_start_time']; 
                                            $startTimes = explode(",", $workingStartTime); 
                                            
                                            $firstPunchInStart = reset($startTimes);
                                            $firstTimestampsStart = strtotime($firstPunchInStart); 
                                            
                                            $firstPunchInEnd = end($startTimes);
                                            $firstTimestampsEnd = strtotime($firstPunchInEnd); 
                                        }
                                        
                                        if(!empty($attendanceData['working_end_time'])){
                                            $workingEndTime = $attendanceData['working_end_time'];
                                            $endTimes = explode(",", $workingEndTime); 
                                            $lastPunchOut = end($endTimes);
                                            $lastTimestamps = strtotime($lastPunchOut); 
                                        }  
                                    ?>
                                    <div class="card card-bordered p-3 bg-lighter">
                                        <span class="tb-lead">Punch In at</span>
                                        <span class="sub-text"><?php if(!empty($attendanceData['working_start_time'])){ $workingDate = DateTime::createFromFormat('d/m/Y', $attendanceData['working_date']); echo $workingDate->format('D, jS M Y'); ?> <?php echo date('h:i A', $firstTimestampsStart); } ?></span>
                                    </div>
                                    <div class="center">
                                        <?php
                                            $totalMinutes = 0;
                                            $totalHours = '00 hr : 00 min'; 
                                    
                                        if(!empty($attendanceData['working_start_time']) && !empty($attendanceData['working_end_time'])){
                                            $originalStartTime = $attendanceData['working_start_time'];
                                            $startTimes = explode(',', $originalStartTime);
                                            $workingStartTime = array_map('trim', $startTimes);
                                    
                                            $originalEndTime = $attendanceData['working_end_time'];
                                            $endTimes = explode(',', $originalEndTime);
                                            $workingEndTime = array_map('trim', $endTimes); ?>
                                    
                                            <?php if(count($workingStartTime) === count($workingEndTime)){
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
                                                $totalHours = $totalHoursFormatted.' hr'.' : '.$totalMinutesFormatted.' min'; ?>
                                                <div class="user-avatar-punch xl bg-lighter border border-lighter mt-3">
                                                    <h6><span class="tb-lead text-center"><?php echo $totalHours; ?></span></h6>
                                                </div>
                                            <?php } else { ?>
                                                <div class="user-avatar-punch xl bg-lighter border border-lighter mt-3">
                                                    <h6><span class="tb-lead text-center"><div id="clock"><?php echo date('H:i:s'); ?></div></span></h6>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="user-avatar-punch xl bg-lighter border border-lighter mt-3">
                                                <h6><span class="tb-lead text-center"><div id="clock"><?php echo date('H:i:s'); ?></div></span></h6>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php if($isAttendanceEmployeeAdd){ ?>
                                        <?php if(empty($attendanceData['punch_status'])){ ?>
                                            <div class="center mt-3">
                                                <?php if($this->session->userdata['current_date'] == date("d/m/Y")){ ?>
                                                    <button type="button" class="btn btn-round btn-primary" data-bs-toggle="modal" data-bs-target="#firstPunchIn"><em class="icon ni ni-clock"></em>&nbsp;Punch In</button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-round btn-primary" disabled><em class="icon ni ni-clock"></em>&nbsp;Punch In</button>
                                                <?php } ?> 
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    
                                    <?php if($isAttendanceEmployeeEdit){ ?>
                                        <?php if(!empty($attendanceData['punch_status'])){ ?>
                                            <?php if($attendanceData['punch_status'] == 'none'){ ?>
                                                <div class="center mt-3">
                                                    <?php if($attendanceData['working_date'] == date("d/m/Y")){ ?>
                                                        <button type="button" class="btn btn-round btn-primary" data-bs-toggle="modal" data-bs-target="#firstPunchOut"><em class="icon ni ni-clock"></em>&nbsp;<?php if(!empty($attendanceData['working_start_time'])){ ?> <?php echo date('h:i A', $firstTimestampsEnd); } ?> - Punch Out</button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-round btn-primary" disabled><em class="icon ni ni-clock"></em>&nbsp;<?php if(!empty($attendanceData['working_start_time'])){ ?> <?php echo date('h:i A', $firstTimestampsEnd); } ?> - Punch Out</button>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    
                                    <?php if($isAttendanceEmployeeEdit){ ?>
                                        <?php if(!empty($attendanceData['punch_status'])){ ?>
                                            <?php if($attendanceData['punch_status'] == 'true'){ ?>
                                                <div class="center mt-3">
                                                    <?php if($attendanceData['working_date'] == date("d/m/Y")){ ?>
                                                        <button type="button" class="btn btn-round btn-primary" data-bs-toggle="modal" data-bs-target="#secondPunchIn"><em class="icon ni ni-clock"></em>&nbsp;<?php if(!empty($attendanceData['working_end_time'])){ ?> <?php echo date('h:i A', $lastTimestamps); } ?> - Punch In</button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-round btn-primary" disabled><em class="icon ni ni-clock"></em>&nbsp;<?php if(!empty($attendanceData['working_end_time'])){ ?> <?php echo date('h:i A', $lastTimestamps); } ?> - Punch In</button>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    
                                    <?php if($isAttendanceEmployeeEdit){ ?>
                                        <?php if(!empty($attendanceData['punch_status'])){ ?>
                                            <?php if($attendanceData['punch_status'] == 'false'){ ?>
                                                <div class="center mt-3">
                                                    <?php if($attendanceData['working_date'] == date("d/m/Y")){ ?>
                                                        <button type="button" class="btn btn-round btn-primary" data-bs-toggle="modal" data-bs-target="#secondPunchOut"><em class="icon ni ni-clock"></em>&nbsp;<?php if(!empty($attendanceData['working_start_time'])){ ?> <?php echo date('h:i A', $firstTimestampsEnd); } ?> - Punch Out</button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-round btn-primary" disabled><em class="icon ni ni-clock"></em>&nbsp;<?php if(!empty($attendanceData['working_start_time'])){ ?> <?php echo date('h:i A', $firstTimestampsEnd); } ?> - Punch Out</button>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="card card-bordered p-3 bg-lighter mt-3">
                                        <span class="tb-lead">Punch Out at</span>
                                        <span class="sub-text"><?php if(!empty($attendanceData['working_end_time'])){ $workingDate = DateTime::createFromFormat('d/m/Y', $attendanceData['working_date']); echo $workingDate->format('D, jS M Y'); ?> <?php echo date('h:i A', $lastTimestamps); } ?></span>
                                    </div>
                                    <div class="row g-gs">
                                        <div class="col-md-4">
                                            <div class="card card-bordered p-1 bg-lighter mt-3 text-center">
                                                <span class="tb-lead">Break</span>
                                                <span class="sub-text">30 min</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card card-bordered p-1 bg-lighter mt-3 text-center">
                                                <span class="tb-lead">Hours</span>
                                                <span class="sub-text"><?php if(!empty($attendanceData['working_hours'])){ echo $attendanceData['working_hours']; } else { echo "00:00"; } ?> hrs</span>
                                            </div>
                                        </div>
                                        <?php if(isset($attendanceData) && is_array($attendanceData) && $attendanceData['working_belowtime_hours'] != null && isset($attendanceData['working_belowtime_hours']) && $attendanceData['working_belowtime_hours'] != "00:00"){ ?>
                                            <div class="col-md-4">
                                                <div class="card card-bordered p-1 bg-lighter mt-3 text-center">
                                                    <span class="tb-lead">Belowtime</span>
                                                    <span class="sub-text"><?php if(!empty($attendanceData['working_belowtime_hours'])){ echo $attendanceData['working_belowtime_hours']; } else { echo "00:00"; } ?> hrs</span>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-4">
                                                <div class="card card-bordered p-1 bg-lighter mt-3 text-center">
                                                    <span class="tb-lead">Overtime</span>
                                                    <span class="sub-text"><?php if(!empty($attendanceData['working_overtime_hours'])){ echo $attendanceData['working_overtime_hours']; } else { echo "00:00"; } ?> hrs</span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1" id="firstPunchIn">
                                    <div class="modal-dialog modal-dialog-top" role="document">
                                        <div class="modal-content">
                                            <form action="<?php echo base_url(); ?>employee-dashboard" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Attendance</h5>
                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <em class="icon ni ni-cross"></em>
                                                    </a>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to punch in <?php echo $this->session->userdata['user_name']; ?>?</p>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <span class="sub-text"><input type="submit" class="btn btn-sm btn-success submitBtn" id="start_first_punch_in" name="submit_first_punch_in" value="Punch In"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1" id="firstPunchOut">
                                    <div class="modal-dialog modal-dialog-top" role="document">
                                        <div class="modal-content">
                                            <form action="<?php echo base_url(); ?>employee-dashboard" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Attendance</h5>
                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <em class="icon ni ni-cross"></em>
                                                    </a>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to punch out <?php echo $this->session->userdata['user_name']; ?>?</p>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <span class="sub-text"><input type="submit" class="btn btn-sm btn-danger submitBtn" id="stop_first_punch_out" name="submit_first_punch_out" value="Punch Out"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1" id="secondPunchIn">
                                    <div class="modal-dialog modal-dialog-top" role="document">
                                        <div class="modal-content">
                                            <form action="<?php echo base_url(); ?>employee-dashboard" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Attendance</h5>
                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <em class="icon ni ni-cross"></em>
                                                    </a>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to punch in <?php echo $this->session->userdata['user_name']; ?>?</p>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <span class="sub-text"><input type="submit" class="btn btn-sm btn-success submitBtn" id="start_second_punch_in" name="submit_second_punch_in" value="Punch In"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1" id="secondPunchOut">
                                    <div class="modal-dialog modal-dialog-top" role="document">
                                        <div class="modal-content">
                                            <form action="<?php echo base_url(); ?>employee-dashboard" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Attendance</h5>
                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <em class="icon ni ni-cross"></em>
                                                    </a>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to punch out <?php echo $this->session->userdata['user_name']; ?>?</p>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <span class="sub-text"><input type="submit" class="btn btn-sm btn-danger submitBtn" id="stop_second_punch_out" name="submit_second_punch_out" value="Punch Out"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="card-inner">
                                    <div class="text-center">
                                        <img src="<?php echo base_url(); ?>source/images/no-permission.png" width="200" height="200">
                                    </div>
                                    <div class="nk-block-content text-center p-3">
                                        <span class="sub-text">You don't have permission to show the the my log's data</span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-bordered h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <span class="user-card">
                                                <span class="user-avatar bg-orange-dim sq mds">
                                                    <img src="<?php echo base_url(); ?>source/images/dashboard/today-activity.png">
                                                </span>
                                                <span class="user-info">
                                                    <h6 class="text-orange">Today Activity</h6>
                                                </span>
                                            </span>
                                        </h6>
                                    </div>
                                    <?php if($isAttendanceEmployeeView){ ?>
                                        <div class="card-action">
                                            <a href="<?php echo base_url(); ?>view-employee-attendance" class="link link-sm">View All<em class="icon ni ni-chevron-right"></em></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if($isAttendanceEmployeeView){ ?>
                                <div class="card-inner">
                                    <div class="timeline">
                                        <h6 class="timeline-head"><?php if(!empty($attendanceData['working_date'])){ $date = DateTime::createFromFormat('d/m/Y', $attendanceData['working_date']); echo $date->format('F, Y'); } ?></h6>
                                        <ul class="timeline-list">
                                            <?php 
                                                if(!empty($attendanceData['working_start_time'])){ 
                                                    $workingStartTime = $attendanceData['working_start_time'];
                                                    $startTimes = explode(",", $workingStartTime);
                                                }
                                                
                                                if(!empty($attendanceData['working_end_time'])){
                                                    $workingEndTime = $attendanceData['working_end_time'];
                                                    $endTimes = explode(",", $workingEndTime);
                                                }  
                                            ?>
                                            <?php if(!empty($attendanceData['working_date'])){ ?>
                                                <?php for($i = 0; $i < count($startTimes); $i++){ ?>
                                                    <?php if(!empty($startTimes[$i])){ ?>
                                                        <li class="timeline-item">
                                                            <div class="timeline-status bg-success is-outline"></div>
                                                            <div class="timeline-date"><?php $workingDate = DateTime::createFromFormat('d/m/Y', $attendanceData['working_date']); echo $workingDate->format('d M');?> <em class="icon ni ni-alarm-alt"></em></div>
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
                                                            <div class="timeline-date"><?php $workingDate = DateTime::createFromFormat('d/m/Y', $attendanceData['working_date']); echo $workingDate->format('d M');?> <em class="icon ni ni-alarm-alt"></em></div>
                                                            <div class="timeline-data">
                                                                <h6 class="timeline-title">Punch Out at</h6>
                                                                <div class="timeline-des">
                                                                    <span class="time"><?php $endTimestamp = strtotime($endTimes[$i]); echo date('h:i A', $endTimestamp) . "<br>"; ?></span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <div class="center">
                                                    <div class="col-md-12">
                                                        <div class="card card-bordered p-3 bg-lighter text-center">
                                                            <span class="tb-lead">No Log Data Found</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="card-inner">
                                    <div class="text-center">
                                        <img src="<?php echo base_url(); ?>source/images/no-permission.png" width="200" height="200">
                                    </div>
                                    <div class="nk-block-content text-center p-3">
                                        <span class="sub-text">You don't have permission to show the the today activity's data</span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <span class="user-card">
                                                <span class="user-avatar bg-info-dim sq mds">
                                                    <img src="<?php echo base_url(); ?>source/images/dashboard/my-total-hour.png">
                                                </span>
                                                <span class="user-info">
                                                    <h6 class="text-info">My Total Hours</h6>
                                                    <span class="badge badge-dim rounded-pill bg-info">Current Month</span>
                                                </span>
                                            </span>
                                        </h6>
                                    </div>
                                    <?php if($isAttendanceEmployeeView){ ?>
                                        <div class="card-action">
                                            <a href="<?php echo base_url(); ?>view-employee-attendance" class="link link-sm">View All<em class="icon ni ni-chevron-right"></em></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if($isAttendanceEmployeeView){ ?>
                                <div class="card-inner">
                                    <div class="example-alerts">
                                        <div class="row gy-4">
                                            <div class="col-md-6">
                                                <div class="example-alert">
                                                    <div class="alert alert-primary text-center">
                                                        <div class="btn btn-p-0 btn-nofocus text-primary"><em class="icon ni ni-alarm-alt"></em><span><?php echo calculateWorkingDays(date('n'),date('Y')); ?></span></div>
                                                        <span class="btn btn-p-0 btn-nofocus text-primary">Working Days</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="example-alert">
                                                    <div class="alert alert-secondary text-center">
                                                        <div class="btn btn-p-0 btn-nofocus text-secondary"><em class="icon ni ni-alarm"></em><span><?php echo $workedDays; ?></span></div>
                                                        <span class="btn btn-p-0 btn-nofocus text-secondary">Worked Days</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="example-alert">
                                                    <div class="alert alert-success text-center">
                                                        <div class="btn btn-p-0 btn-nofocus text-success"><em class="icon ni ni-building"></em><span><?php echo calculateWorkingDays(date('n'),date('Y')) * WORKING_HOURS.":00" ; ?></span></div>
                                                        <span class="btn btn-p-0 btn-nofocus text-success">Working Hours</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="example-alert">
                                                    <div class="alert alert-danger text-center">
                                                        <div class="btn btn-p-0 btn-nofocus text-danger"><em class="icon ni ni-bag"></em><span><?php echo $workedHours; ?></span></div>
                                                        <span class="btn btn-p-0 btn-nofocus text-danger">Worked Hours</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="example-alert">
                                                    <div class="alert alert-info text-center">
                                                        <div class="btn btn-p-0 btn-nofocus text-info"><em class="icon ni ni-calendar-alt"></em><span><?php echo $overtimeHours; ?></span></div>
                                                        <span class="btn btn-p-0 btn-nofocus text-info">Overtime Hours</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="example-alert">
                                                    <div class="alert alert-warning text-center">
                                                        <div class="btn btn-p-0 btn-nofocus text-warning"><em class="icon ni ni-calendar"></em><span><?php echo $belowtimeHours; ?></span></div>
                                                        <span class="btn btn-p-0 btn-nofocus text-warning">Belowtime Hours</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="card-inner">
                                    <div class="text-center">
                                        <img src="<?php echo base_url(); ?>source/images/no-permission.png" width="200" height="200">
                                    </div>
                                    <div class="nk-block-content text-center p-3">
                                        <span class="sub-text">You don't have permission to show the the my total hour's data</span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <span class="user-card">
                                                <span class="user-avatar bg-danger-dim sq mds">
                                                    <img src="<?php echo base_url(); ?>source/images/dashboard/leave-balance.png">
                                                </span>
                                                <span class="user-info">
                                                    <h6 class="text-danger">Leave Balance</h6>
                                                    <span class="badge badge-dim rounded-pill bg-danger">Current Year</span>
                                                </span>
                                            </span>
                                        </h6>
                                    </div>
                                    <?php if($isLeaveEmployeeView){ ?>
                                        <div class="card-action">
                                            <a href="<?php echo base_url(); ?>view-employee-leave" class="link link-sm">View All<em class="icon ni ni-chevron-right"></em></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if($isLeaveEmployeeView){ ?>
                                <div class="card-inner">
                                    <div class="team">
                                        <ul class="team-statistics">
                                            <li><div class="text-primary"><?php echo $totalLeaves; ?></div><span>Total Leaves</span></li>
                                            <li><div class="text-warning"><?php echo calculateAbsentLeaveDays($employeeData['employee_joining_date']); ?></div><span>Absent Leaves</span></li>
                                            <li><div class="text-info"><?php echo $pendingLeaves; ?></div><span>Pending Leaves</span></li>
                                            
                                        </ul>
                                        <ul class="team-statistics">
                                            <li><div class="text-success"><?php echo $approvalLeaves; ?></div><span>Approval Leaves</span></li>
                                            <li><div class="text-danger"><?php echo $rejectedLeaves; ?></div><span>Rejected Leaves</span></li>
                                            <li><div class="text-pink"><?php echo $cancelledLeaves; ?></div><span>Cancelled Leaves</span></li>
                                        </ul>
                                         <ul class="team-statistics">
                                            <li><div class="text-secondary"><?php echo calculateBalanceLeaveDays($employeeData['employee_joining_date'], $employeeData['employee_leaving_date']) - $paidLeaves; ?></div><span>Balance Leaves</span></li>
                                            <li><div class="text-success"><?php echo $paidLeaves; ?></div><span>Paid Leaves</span></li>
                                            <li><div class="text-danger"><?php echo $approvalLeaves - $paidLeaves; ?></div><span>Unpaid Leaves</span></li>
                                        </ul>
                                    </div>
                                    <div class="collapse" id="leaveCollapse" style="">
                                        <div class="divider"></div>
                                        <div class="rating-card-description">
                                            <h5 class="card-title">Important notes</h5>
                                            <p class="text-muted">If your leave exceeding from this month kindly issue two different leave requests.</p>
                                            <ul class="pt-2 gy-1">
                                                <li><em class="icon ni ni-check-circle"></em><span>Duration for short leave : 3 hours (Maximum)</span></li>
                                                <li><em class="icon ni ni-check-circle"></em><span>Duration for half leave : 4 hours</span></li>
                                                <li><em class="icon ni ni-check-circle"></em><span>Sandwich leaves can't be balanced</span></li>
                                                <li><em class="icon ni ni-check-circle"></em><span>1 week prior notice will be needed for leaves more than 6 days.</span></li>
                                                <li><em class="icon ni ni-check-circle"></em><span>Employee must fulfil the duration of the short leave within 5 days.</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer rating-card-footer bg-light border-top d-flex align-center justify-content-between">
                                    <a class="switch-text collapsed" data-bs-toggle="collapse" href="#leaveCollapse" aria-expanded="false">
                                        <div class="link link-gray switch-text-normal">
                                            <span>Less Info</span><em class="icon ni ni-upword-ios"></em>
                                        </div>
                                        <div class="link link-gray switch-text-collapsed">
                                            <span>More Info</span><em class="icon ni ni-downward-ios"></em>
                                        </div>
                                    </a>
                                    <?php if($isLeaveEmployeeAdd){ ?>
                                        <a data-bs-toggle="modal" data-bs-target="#leaveModal" class="btn btn-primary">Apply Leave</a>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <div class="card-inner">
                                    <div class="text-center">
                                        <img src="<?php echo base_url(); ?>source/images/no-permission.png" width="200" height="200">
                                    </div>
                                    <div class="nk-block-content text-center p-3">
                                        <span class="sub-text">You don't have permission to show the the leave balance's data</span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <span class="user-card">
                                                <span class="user-avatar bg-primary-dim sq mds">
                                                    <img src="<?php echo base_url(); ?>source/images/dashboard/holiday.png">
                                                </span>
                                                <span class="user-info">
                                                    <h6 class="text-primary">Upcoming Holidays</h6>
                                                </span>
                                            </span>
                                        </h6>
                                    </div>
                                    <?php if($isHolidayView){ ?>
                                        <div class="card-action">
                                            <a href="<?php echo base_url(); ?>view-holiday" class="link link-sm">View All<em class="icon ni ni-chevron-right"></em></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if($isHolidayView){ ?>
                                <?php if(!empty($viewUpcomingHoliday)){ ?>
                                    <ul class="nk-activity">
                                        <?php foreach($viewUpcomingHoliday as $data){ ?>
                                            <li class="nk-activity-item">
                                                <?php $color = assignDimColor($data['holiday_id']); ?>
                                                <div class="nk-activity-media user-avatar bg-<?php echo $color; ?>-dim text-uppercase"><?php echo get_first_letters($data['holiday_name']); ?></div>
                                                <div class="nk-activity-data">
                                                    <div class="label"><?php echo $data['holiday_name']; ?></div>
                                                    <span class="time"><?php $date = DateTime::createFromFormat('d/m/Y', $data['holiday_date']); echo $date->format('D d M Y'); ?></span>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } else { ?>
                                    <div class="card-inner">
                                        <div class="text-center">
                                            <img src="<?php echo base_url(); ?>source/images/no-data.png" width="300" height="190">
                                        </div>
                                        <div class="nk-block-content text-center p-3">
                                            <span class="sub-text">No upcoming holidays</span>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="card-inner">
                                    <div class="text-center">
                                        <img src="<?php echo base_url(); ?>source/images/no-permission.png" width="200" height="200">
                                    </div>
                                    <div class="nk-block-content text-center p-3">
                                        <span class="sub-text">You don't have permission to show the the upcoming holiday's data</span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered h-100" style="background-image: url(https://syphnosys.com/portal/source/images/dashboard/celebrationbg.png);background-position: center;">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <span class="user-card">
                                                <span class="user-avatar bg-warning-dim sq mds">
                                                    <img src="<?php echo base_url(); ?>source/images/dashboard/birthday.png">
                                                </span>
                                                <span class="user-info">
                                                    <h6 class="text-warning">Upcoming Birthday</h6>
                                                </span>
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($viewUpcomingBirthday)){ ?>
                                <ul class="nk-support">
                                    <?php foreach($viewUpcomingBirthday as $data){ ?>
                                        <li class="nk-support-item">
                                            <?php if(!empty($data['employee_photo'] && $data['employee_photo'] != "Unknown")){ ?>
                                                <div class="user-avatar bg-light">
                                                    <a class="gallery-image popup-image" href="<?php echo base_url(); ?>uploads/hrm/employee_photo/<?php echo $data['employee_photo']; ?>">
                                                        <img src="<?php echo base_url(); ?>uploads/hrm/employee_photo/<?php echo $data['employee_photo']; ?>" class="rounded-circle" height="40" width="40">
                                                    </a>
                                                </div>
                                            <?php } else if(!empty($data['employee_photo'] && $data['employee_photo'] == "Unknown")){ ?>
                                                <div class="user-avatar bg-light">
                                                    <em class="icon ni ni-user-alt-fill"></em>
                                                </div>
                                            <?php } else { ?>
                                                <?php $color = assignDimColor($data['employee_id']); ?>
                                                <div class="user-avatar bg-<?php echo $color; ?>-dim">
                                                    <span><?php echo get_first_letters($data['employee_first_name']); echo get_first_letters($data['employee_last_name']); ?></span>
                                                </div>
                                            <?php } ?>
                                            <div class="nk-support-content">
                                                <div class="title">
                                                    <span><?php echo $data['employee_first_name']; ?> <?php echo $data['employee_last_name']; ?></span>
                                                </div>
                                                <p>“wish you a very Happy birthday!”.</p>
                                                <span class="time"><?php echo $data['employee_birth_date']; ?></span>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } else { ?>
                                <div class="card-inner">
                                    <div class="text-center">
                                        <img src="<?php echo base_url(); ?>source/images/no-data.png" width="300" height="190">
                                    </div>
                                    <div class="nk-block-content text-center p-3">
                                        <span class="sub-text">No upcoming birthday</span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered h-100" style="background-image: url(https://syphnosys.com/portal/source/images/dashboard/celebrationbg.png);background-position: center;">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <span class="user-card">
                                                <span class="user-avatar bg-success-dim sq mds">
                                                    <img src="<?php echo base_url(); ?>source/images/dashboard/anniversary.png">
                                                </span>
                                                <span class="user-info">
                                                    <h6 class="text-success">Upcoming Work Anniversary</h6>
                                                </span>
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($viewUpcomingWorkAnniversary)){ ?>
                                <ul class="nk-support">
                                    <?php foreach($viewUpcomingWorkAnniversary as $data){ ?>
                                        <?php $employeeContractDate = DateTime::createFromFormat('d/m/Y', $data['employee_contract_date']);  $employeeContractFormattedYear = $employeeContractDate->format('Y'); if($employeeContractFormattedYear != date('Y')) { ?>
                                            <li class="nk-support-item">
                                                <?php if(!empty($data['employee_photo'] && $data['employee_photo'] != "Unknown")){ ?>
                                                    <div class="user-avatar bg-light">
                                                        <a class="gallery-image popup-image" href="<?php echo base_url(); ?>uploads/hrm/employee_photo/<?php echo $data['employee_photo']; ?>">
                                                            <img src="<?php echo base_url(); ?>uploads/hrm/employee_photo/<?php echo $data['employee_photo']; ?>" class="rounded-circle" height="40" width="40">
                                                        </a>
                                                    </div>
                                                <?php } else if(!empty($data['employee_photo'] && $data['employee_photo'] == "Unknown")){ ?>
                                                    <div class="user-avatar bg-light">
                                                        <em class="icon ni ni-user-alt-fill"></em>
                                                    </div>
                                                <?php } else { ?>
                                                    <?php $color = assignDimColor($data['employee_id']); ?>
                                                    <div class="user-avatar bg-<?php echo $color; ?>-dim">
                                                        <span><?php echo get_first_letters($data['employee_first_name']); echo get_first_letters($data['employee_last_name']); ?></span>
                                                    </div>
                                                <?php } ?>
                                                <div class="nk-support-content">
                                                    <div class="title">
                                                        <span><?php echo $data['employee_first_name']; ?> <?php echo $data['employee_last_name']; ?></span>
                                                    </div>
                                                    <p>“Congrats on your success! Keep up the great work!”.</p>
                                                    <span class="time"><?php
                                                        $employeeContractDate = DateTime::createFromFormat('d/m/Y', $data['employee_contract_date']);
                                                        $employeeContractFormattedDate = $employeeContractDate->format('Y');
            
                                                        $contractDate = DateTime::createFromFormat('Y', $employeeContractFormattedDate);
                                                        $currentDate = DateTime::createFromFormat('Y', date('Y'));
                                                
                                                        $interval = $contractDate->diff($currentDate);
                                                
                                                        $totalYears = $interval->y;
                                                        
                                                        $numberFormated = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                                                        echo $numberFormated->format($totalYears);
                                                    ?> Anniversary</span>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            <?php } else { ?>
                                <div class="card-inner">
                                    <div class="text-center">
                                        <img src="<?php echo base_url(); ?>source/images/no-data.png" width="300" height="190">
                                    </div>
                                    <div class="nk-block-content text-center p-3">
                                        <span class="sub-text">No upcoming work anniversary</span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        
    </div>
</div>

<div class="modal fade" id="leaveModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url(); ?>employee-dashboard" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">New Leave</h5>
                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2 leaveType" data-ui="xl" name="leave_type" data-placeholder="Select a type" required>
                                        <option label="empty" value=""></option>
                                        <option value="full">Full</option>
                                        <option value="half">Half</option>
                                        <option value="short">Short</option>
                                    </select>
                                    <label class="form-label-outlined" for="leave_type">Leave Type *</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" class="form-control form-control-xl form-control-outlined date-picker" name="leave_from_date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                    <label class="form-label-outlined" for="leave_from_date">Leave From Date *</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" class="form-control form-control-xl form-control-outlined date-picker" name="leave_to_date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                    <label class="form-label-outlined" for="leave_to_date">Leave To Date *</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 n-none" id="leaveFromTime">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" class="form-control form-control-xl form-control-outlined time-picker" name="leave_from_time" autocomplete="off" required>
                                    <label class="form-label-outlined" for="leave_from_time">Leave From Time *</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 n-none" id="leaveToTime">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                    <input type="text" class="form-control form-control-xl form-control-outlined time-picker" name="leave_to_time" autocomplete="off" required>
                                    <label class="form-label-outlined" for="leave_to_time">Leave To Time *</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 n-none" id="leaveDays">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control form-control-xl form-control-outlined" name="leave_days" autocomplete="off" required>
                                    <label class="form-label-outlined" for="leave_days">Leave Days *</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <textarea class="form-control form-control-xl form-control-outlined" name="leave_reason" required></textarea>
                                    <label class="form-label-outlined" for="leave_reason">Leave Reason *</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary submitBtn" name="submit_leave" value="Save Informations">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function handleLeaveTypeChange() {
            var selectedValue = $(this).val();
    
            if (selectedValue == 'short') {
                $('#leaveFromTime').show();
                $('#leaveToTime').show();
            } else {
                $('#leaveFromTime').hide();
                $('#leaveToTime').hide();
            }
        }
    
        $('.leaveType').change(handleLeaveTypeChange);
    
        $('.leaveType').each(function() {
            handleLeaveTypeChange.call(this);
        });
    
        $('form').submit(function(event) {
            var totalLeaveDays = 0;
            
            $('.leaveType').each(function() {
                var selectedValue = $(this).val();
    
                if (selectedValue == 'full' || selectedValue == 'half') {
                    $('#leaveFromTime').find('input').val('');
                    $('#leaveToTime').find('input').val('');
                }
                
                if (selectedValue == 'full') {
                    $('#leaveDays').find('input').val('full');
                }
    
                if (selectedValue == 'half') {
                    $('#leaveDays').find('input').val('0.5');
                }
    
                if (selectedValue == 'short') {
                    $('#leaveDays').find('input').val('0');
                }
            });
        });
    });
</script>
    
<?php 
    $employeeBirthDate = DateTime::createFromFormat('d/m/Y', $employeeData['employee_birth_date']);
    $employeeContractDate = DateTime::createFromFormat('d/m/Y', $employeeData['employee_contract_date']);
?>
<?php if($employeeBirthDate->format('d/m') == date('d/m') || $employeeContractDate->format('d/m') == date('d/m')){ ?>
    <canvas class="confetti" id="canvas"></canvas>
<?php } ?>