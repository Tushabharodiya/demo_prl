<?php
    $isLeaveEmployeeAdd = checkPermission(HRM_LEAVE_EMPLOYEE_ALIAS, "can_add");
    $isLeaveEmployeeView = checkPermission(HRM_LEAVE_EMPLOYEE_ALIAS, "can_view");
    $isLeaveEmployeeEdit = checkPermission(HRM_LEAVE_EMPLOYEE_ALIAS, "can_edit");
    
    $sessionLeaveEmployeeViewPreviousUrl = $this->session->userdata('session_leave_employee_view_previous_url');

    $sessionLeaveEmployee = $this->session->userdata('session_leave_employee');
    $sessionLeaveEmployeeType = $this->session->userdata('session_leave_employee_type');
    $sessionLeaveEmployeeLeave = $this->session->userdata('session_leave_employee_leave');
    $sessionLeaveEmployeeFromStartDate = $this->session->userdata('session_leave_employee_from_start_date');
    $sessionLeaveEmployeeFromEndDate = $this->session->userdata('session_leave_employee_from_end_date');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Leave</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isLeaveEmployeeView){ ?>
                            <p><?php echo "You have total $countLeave leaves."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isLeaveEmployeeView){ ?>
                                    <li>
                                        <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="dropdown">
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter Leave</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Type</label>
                                                                    <select class="form-control form-select" id="search-type" name="search_leave_employee_type" data-placeholder="Select a type">
                                                                        <?php $str='';
                                                                            if(!empty($sessionLeaveEmployeeType == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionLeaveEmployeeType == 'full')){
                                                                                $str.='selected';
                                                                        } ?> <option value="full"<?php echo $str; ?>>Full</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionLeaveEmployeeType == 'half')){
                                                                                $str.='selected';
                                                                        } ?> <option value="half"<?php echo $str; ?>>Half</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionLeaveEmployeeType == 'short')){
                                                                                $str.='selected';
                                                                        } ?> <option value="short"<?php echo $str; ?>>Short</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Leave</label>
                                                                    <select class="form-control form-select" id="search-leave" name="search_leave_employee_leave" data-placeholder="Select a leave">
                                                                        <?php $str='';
                                                                            if(!empty($sessionLeaveEmployeeLeave == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionLeaveEmployeeLeave == 'pending')){
                                                                                $str.='selected';
                                                                        } ?> <option value="pending"<?php echo $str; ?>>Pending</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionLeaveEmployeeLeave == 'approved')){
                                                                                $str.='selected';
                                                                        } ?> <option value="approved"<?php echo $str; ?>>Approved</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionLeaveEmployeeLeave == 'rejected')){
                                                                                $str.='selected';
                                                                        } ?> <option value="rejected"<?php echo $str; ?>>Rejected</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionLeaveEmployeeLeave == 'cancelled')){
                                                                                $str.='selected';
                                                                        } ?> <option value="cancelled"<?php echo $str; ?>>Cancelled</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Leave From Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="input-daterange date-picker-range input-group">
                                                                            <input type="text" class="form-control date-picker" name="search_leave_employee_from_start_date" value="<?php if(!empty($sessionLeaveEmployeeFromStartDate)){ echo $sessionLeaveEmployeeFromStartDate; } ?>" placeholder="Enter start date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                                                            <div class="input-group-addon">TO</div>
                                                                            <input type="text" class="form-control date-picker" name="search_leave_employee_from_end_date" value="<?php if(!empty($sessionLeaveEmployeeFromEndDate)){ echo $sessionLeaveEmployeeFromEndDate; } ?>" placeholder="Enter end date" data-date-format="dd/mm/yyyy" autocomplete="off">
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
                                <?php if($isLeaveEmployeeAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if(!empty($sessionLeaveEmployeeFromStartDate) && !empty($sessionLeaveEmployeeFromEndDate)){ ?>
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-md-12">
                        <div class="team">
                            <ul class="team-statistics">
                                <li><div class="example-alert">
                                    <div class="alert alert-pro alert-primary">
                                        <div class="alert-text">
                                            <div class="text-primary"><?php echo $totalLeaves; ?></div>
                                            <p>Total Leaves</p>
                                        </div>
                                    </div>
                                </div></li>
                                <li><div class="example-alert">
                                    <div class="alert alert-pro alert-warning">
                                        <div class="alert-text">
                                            <div class="text-warning"><?php if(!empty($employeeJoiningDate)){ echo calculateAbsentLeaveDaysBetweenDates($employeeJoiningDate, $sessionLeaveEmployeeFromStartDate, $sessionLeaveEmployeeFromEndDate, $userID); } else { echo "0"; } ?></div>
                                            <p>Absent Leaves</p>
                                        </div>
                                    </div>
                                </div></li>
                                <li><div class="example-alert">
                                    <div class="alert alert-pro alert-info">
                                        <div class="alert-text">
                                            <div class="text-info"><?php echo $pendingLeaves; ?></div>
                                            <p>Pending Leaves</p>
                                        </div>
                                    </div>
                                </div></li>
                                <li><div class="example-alert">
                                    <div class="alert alert-pro alert-success">
                                        <div class="alert-text">
                                            <div class="text-success"><?php echo $approvalLeaves; ?></div>
                                            <p>Approval Leaves</p>
                                        </div>
                                    </div>
                                </div></li>
                                <li><div class="example-alert">
                                    <div class="alert alert-pro alert-danger">
                                        <div class="alert-text">
                                            <div class="text-danger"><?php echo $rejectedLeaves; ?></div>
                                            <p>Rejected Leaves</p>
                                        </div>
                                    </div>
                                </div></li>
                                <li><div class="example-alert">
                                    <div class="alert alert-pro alert-gray">
                                        <div class="alert-text">
                                            <div class="text-gray"><?php echo $cancelledLeaves; ?></div>
                                            <p>Cancelled Leaves</p>
                                        </div>
                                    </div>
                                </div></li>
                                <li><div class="example-alert">
                                    <div class="alert alert-pro alert-secondary">
                                        <div class="alert-text">
                                            <div class="text-secondary"><?php if(!empty($employeeJoiningDate)){ echo calculateBalanceLeaveDaysBetweenDates($employeeJoiningDate, $employeeLeavingDate, $sessionLeaveEmployeeFromStartDate, $sessionLeaveEmployeeFromEndDate, $userID) - $paidLeaves; } else { echo "0"; } ?></div>
                                            <p>Balance Leaves</p>
                                        </div>
                                    </div>
                                </div></li>
                                <li><div class="example-alert">
                                    <div class="alert alert-pro alert-success">
                                        <div class="alert-text">
                                            <div class="text-success"><?php echo $paidLeaves; ?></div>
                                            <p>Paid Leaves</p>
                                        </div>
                                    </div>
                                </div></li>
                                <li><div class="example-alert">
                                    <div class="alert alert-pro alert-danger">
                                        <div class="alert-text">
                                            <div class="text-danger"><?php echo $approvalLeaves - $paidLeaves; ?></div>
                                            <p>Unpaid Leaves</p>
                                        </div>
                                    </div>
                                </div></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        
        <?php if($isLeaveEmployeeView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_leave_employee" value="<?php if(!empty($sessionLeaveEmployee)){ echo $sessionLeaveEmployee; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_leave_employee_new_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_leave_employee_new_success'); $this->session->unset_userdata('session_leave_employee_new_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_leave_employee_edit_leave_cancel_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_leave_employee_edit_leave_cancel_error'); $this->session->unset_userdata('session_leave_employee_edit_leave_cancel_error'); ?>
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
                                            <th class="nk-tb-col" width="8%"><span>Date</span></th>
                                            <th class="nk-tb-col" width="8%"><span>From</span></th>
                                            <th class="nk-tb-col" width="8%"><span>To</span></th>
                                            <th class="nk-tb-col" width="8%"><span>Days</span></th>
                                            <th class="nk-tb-col" width="8%"><span>Paid</span></th>
                                            <th class="nk-tb-col" width="17%"><span>Reason</span></th>
                                            <th class="nk-tb-col" width="17%"><span>Rejection</span></th>
                                            <th class="nk-tb-col" width="5%"><span>Type</span></th>
                                            <th class="nk-tb-col" width="6%"><span>Leave</span></th>
                                            <th class="nk-tb-col text-end" width="5%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if($isLeaveEmployeeView){ ?>
                                        <?php if(!empty($viewLeave)){ ?>
                                            <tbody>
                                                <?php foreach($viewLeave as $data){ ?>
                                                    <tr class="tb-tnx-item" data-bs-toggle="modal" data-bs-target="#infoModal<?php echo urlEncodes($data['leave_id']);?>">
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['leave_id']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['leave_date']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['leave_from_date']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['leave_to_date']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['leave_days']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php if($data['is_leave'] == 'pending' or $data['is_leave'] == 'cancelled'){ echo "-"; } else { echo $data['leave_paid']; } ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php 
                                                                $leaveReason = $data['leave_reason'];
                                                                if(strlen($leaveReason) > 28){
                                                                    echo substr($leaveReason, 0, 28);
                                                                } else {
                                                                    echo $leaveReason;
                                                                }
                                                            ?></span>
                                                            <?php if(strlen($leaveReason) > 28){ ?>
                                                                <a data-bs-toggle="modal" data-bs-target="#reasonModal<?php echo $data['leave_id'];?>" class="sub-text text-primary">Read More</a>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <?php if(!empty($data['leave_rejection_reason'])){ ?>
                                                                <span class="sub-text"><?php 
                                                                    $leaveRejectionReason = $data['leave_rejection_reason'];
                                                                    if(strlen($leaveRejectionReason) > 28){
                                                                        echo substr($leaveRejectionReason, 0, 28);
                                                                    } else {
                                                                        echo $leaveRejectionReason;
                                                                    }
                                                                ?></span>
                                                                <?php if(strlen($leaveRejectionReason) > 28){ ?>
                                                                    <a data-bs-toggle="modal" data-bs-target="#rejectionModal<?php echo $data['leave_id'];?>" class="sub-text text-primary">Read More</a>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <span class="sub-text"><?php echo "-"; ?></span>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span><?php 
                                                                if(!empty($data['leave_type'])){
                                                                    $leaveType = '';
                                                                    if($data['leave_type'] == 'full'){
                                                                        $leaveType.= '<span class="badge bg-outline-success">Full</span>';
                                                                    } else if($data['leave_type'] == 'half'){
                                                                        $leaveType.= '<span class="badge bg-outline-warning">Half</span>';
                                                                    } else if($data['leave_type'] == 'short'){
                                                                        $leaveType.= '<span class="badge bg-outline-info">Short</span>';
                                                                    }
                                                                    echo $leaveType; 
                                                                } else {
                                                                    echo "-";
                                                                }
                                                            ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span><?php 
                                                                if(!empty($data['is_leave'])){
                                                                    $isLeave = '';
                                                                    if($data['is_leave'] == 'pending'){
                                                                        $isLeave.= '<span class="badge badge-dim bg-warning"><em class="icon ni ni-alert-circle"></em><span>Pending</span></span>';
                                                                    } else if($data['is_leave'] == 'approved'){
                                                                        $isLeave.= '<span class="badge badge-dim bg-success"><em class="icon ni ni-check-circle"></em><span>Approved</span></span>';
                                                                    } else if($data['is_leave'] == 'rejected'){
                                                                        $isLeave.= '<span class="badge badge-dim bg-danger"><em class="icon ni ni-cross-circle"></em><span>Rejected</span></span>';
                                                                    } else if($data['is_leave'] == 'cancelled'){
                                                                        $isLeave.= '<span class="badge badge-dim bg-primary"><em class="icon ni ni-minus-circle"></em><span>Cancelled</span></span>';
                                                                    }
                                                                    echo $isLeave; 
                                                                } else {
                                                                    echo "-";
                                                                }
                                                            ?></span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <?php if($isLeaveEmployeeEdit){ ?>
                                                                    <?php if($data['is_leave'] == 'pending'){ ?>
                                                                        <li class="nk-tb-action">
                                                                            <a data-bs-toggle="modal" data-bs-target="#cancelModal<?php echo urlEncodes($data['leave_id']); ?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Cancel">
                                                                                <em class="icon ni ni-cross-round-fill"></em>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if($isLeaveEmployeeEdit){ ?>
                                                                    <?php if($data['is_leave'] == 'cancelled'){ ?>
                                                                        <li class="nk-tb-action">
                                                                            <a data-bs-toggle="modal" data-bs-target="#editModal<?php echo urlEncodes($data['leave_id']); ?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                                <em class="icon ni ni-edit-fill"></em>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade zoom" tabindex="-1" id="infoModal<?php echo urlEncodes($data['leave_id']); ?>">
                                                        <div class="modal-dialog modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Leave Info</h5>
                                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <em class="icon ni ni-cross"></em>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="nk-block">
                                                                        <div class="project">
                                                                            <div class="project-head">
                                                                                <a role="link" aria-disabled="true" class="project-title">
                                                                                    <?php if(!empty($data['employeeData']['employee_photo'] && $data['employeeData']['employee_photo'] != "Unknown")){ ?>
                                                                                        <div class="user-avatar sq bg-light">
                                                                                            <img src="<?php echo base_url();?>uploads/hrm/employee_photo/<?php echo $data['employeeData']['employee_photo']; ?>" height="40" width="40">
                                                                                        </div>
                                                                                    <?php } else { ?>
                                                                                        <div class="user-avatar sq bg-light">
                                                                                            <em class="icon ni ni-user-alt-fill"></em>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <div class="project-info">
                                                                                        <h6 class="title"><?php echo $data['employeeData']['employee_first_name']; ?> <?php echo $data['employeeData']['employee_middle_name']; ?> <?php echo $data['employeeData']['employee_last_name']; ?></h6>
                                                                                        <span class="sub-text"><?php echo $data['departmentData']['department_name']; ?></span>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                            <div class="project-details">
                                                                                <?php if($data['leave_type'] == 'full'){ ?>
                                                                                    <p><span class="data-label">Leave ID : </span><span class="data-value"><?php echo isset($data['leave_id']) && !empty($data['leave_id']) ? $data['leave_id'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave Date : </span><span class="data-value"><?php echo isset($data['leave_date']) && !empty($data['leave_date']) ? $data['leave_date'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave From Date : </span><span class="data-value"><?php echo isset($data['leave_from_date']) && !empty($data['leave_from_date']) ? $data['leave_from_date'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave To Date : </span><span class="data-value"><?php echo isset($data['leave_to_date']) && !empty($data['leave_to_date']) ? $data['leave_to_date'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave Days : </span><span class="data-value"><?php if(!empty($data['leave_days'])) { echo $data['leave_days']; } else { echo "-"; } ?></span></p>
                                                                                    <?php if(!empty($data['leave_paid'])){ ?>
                                                                                        <p><span class="data-label">Leave Paid : </span><span class="data-value"><?php echo isset($data['leave_paid']) && !empty($data['leave_paid']) ? $data['leave_paid'] : '-'; ?></span></p>
                                                                                    <?php } ?>
                                                                                    <p><span class="data-label">Leave Reason : </span><span class="data-value"><?php echo isset($data['leave_reason']) && !empty($data['leave_reason']) ? $data['leave_reason'] : '-'; ?></span></p>
                                                                                    <?php if(!empty($data['leave_rejection_reason'])){ ?>
                                                                                        <p><span class="data-label">Leave Rejection Reason : </span><span class="data-value"><?php echo isset($data['leave_rejection_reason']) && !empty($data['leave_rejection_reason']) ? $data['leave_rejection_reason'] : '-'; ?></span></p>
                                                                                    <?php } ?>
                                                                                    <?php if(!empty($data['leave_reviewed_by'])){ ?>
                                                                                        <p><span class="data-label">Leave Reviewed By : </span><span class="data-value"><?php echo isset($data['leave_reviewed_by']) && !empty($data['leave_reviewed_by']) ? $data['leave_reviewed_by'] : '-'; ?></span></p>
                                                                                    <?php } ?>
                                                                                    <p><span class="data-label">Leave Type : </span><span class="data-value"><?php echo isset($data['leave_type']) && !empty($data['leave_type']) ? $data['leave_type'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Is Leave : </span><span class="data-value"><?php echo isset($data['is_leave']) && !empty($data['is_leave']) ? $data['is_leave'] : '-'; ?></span></p>
                                                                                <?php } else if($data['leave_type'] == 'half'){ ?>
                                                                                    <p><span class="data-label">Leave ID : </span><span class="data-value"><?php echo isset($data['leave_id']) && !empty($data['leave_id']) ? $data['leave_id'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave Date : </span><span class="data-value"><?php echo isset($data['leave_date']) && !empty($data['leave_date']) ? $data['leave_date'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave From Date : </span><span class="data-value"><?php echo isset($data['leave_from_date']) && !empty($data['leave_from_date']) ? $data['leave_from_date'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave To Date : </span><span class="data-value"><?php echo isset($data['leave_to_date']) && !empty($data['leave_to_date']) ? $data['leave_to_date'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave Days : </span><span class="data-value"><?php if(!empty($data['leave_days'])) { echo $data['leave_days']; } else { echo "-"; } ?></span></p>
                                                                                    <?php if(!empty($data['leave_paid'])){ ?>
                                                                                        <p><span class="data-label">Leave Paid : </span><span class="data-value"><?php echo isset($data['leave_paid']) && !empty($data['leave_paid']) ? $data['leave_paid'] : '-'; ?></span></p>
                                                                                    <?php } ?>
                                                                                    <p><span class="data-label">Leave Reason : </span><span class="data-value"><?php echo isset($data['leave_reason']) && !empty($data['leave_reason']) ? $data['leave_reason'] : '-'; ?></span></p>
                                                                                    <?php if(!empty($data['leave_rejection_reason'])){ ?>
                                                                                        <p><span class="data-label">Leave Rejection Reason : </span><span class="data-value"><?php echo isset($data['leave_rejection_reason']) && !empty($data['leave_rejection_reason']) ? $data['leave_rejection_reason'] : '-'; ?></span></p>
                                                                                    <?php } ?>
                                                                                    <?php if(!empty($data['leave_reviewed_by'])){ ?>
                                                                                        <p><span class="data-label">Leave Reviewed By : </span><span class="data-value"><?php echo isset($data['leave_reviewed_by']) && !empty($data['leave_reviewed_by']) ? $data['leave_reviewed_by'] : '-'; ?></span></p>
                                                                                    <?php } ?>
                                                                                    <p><span class="data-label">Leave Type : </span><span class="data-value"><?php echo isset($data['leave_type']) && !empty($data['leave_type']) ? $data['leave_type'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Is Leave : </span><span class="data-value"><?php echo isset($data['is_leave']) && !empty($data['is_leave']) ? $data['is_leave'] : '-'; ?></span></p>
                                                                                <?php } else if($data['leave_type'] == 'short'){ ?>
                                                                                    <p><span class="data-label">Leave ID : </span><span class="data-value"><?php echo isset($data['leave_id']) && !empty($data['leave_id']) ? $data['leave_id'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave Date : </span><span class="data-value"><?php echo isset($data['leave_date']) && !empty($data['leave_date']) ? $data['leave_date'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave From Date : </span><span class="data-value"><?php echo isset($data['leave_from_date']) && !empty($data['leave_from_date']) ? $data['leave_from_date'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave To Date : </span><span class="data-value"><?php echo isset($data['leave_to_date']) && !empty($data['leave_to_date']) ? $data['leave_to_date'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave From Time : </span><span class="data-value"><?php echo isset($data['leave_from_time']) && !empty($data['leave_from_time']) ? $data['leave_from_time'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave To Time : </span><span class="data-value"><?php echo isset($data['leave_to_time']) && !empty($data['leave_to_time']) ? $data['leave_to_time'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Leave Reason : </span><span class="data-value"><?php echo isset($data['leave_reason']) && !empty($data['leave_reason']) ? $data['leave_reason'] : '-'; ?></span></p>
                                                                                    <?php if(!empty($data['leave_rejection_reason'])){ ?>
                                                                                        <p><span class="data-label">Leave Rejection Reason : </span><span class="data-value"><?php echo isset($data['leave_rejection_reason']) && !empty($data['leave_rejection_reason']) ? $data['leave_rejection_reason'] : '-'; ?></span></p>
                                                                                    <?php } ?>
                                                                                    <?php if(!empty($data['leave_reviewed_by'])){ ?>
                                                                                        <p><span class="data-label">Leave Reviewed By : </span><span class="data-value"><?php echo isset($data['leave_reviewed_by']) && !empty($data['leave_reviewed_by']) ? $data['leave_reviewed_by'] : '-'; ?></span></p>
                                                                                    <?php } ?>
                                                                                    <p><span class="data-label">Leave Type : </span><span class="data-value"><?php echo isset($data['leave_type']) && !empty($data['leave_type']) ? $data['leave_type'] : '-'; ?></span></p>
                                                                                    <p><span class="data-label">Is Leave : </span><span class="data-value"><?php echo isset($data['is_leave']) && !empty($data['is_leave']) ? $data['is_leave'] : '-'; ?></span></p>
                                                                                <?php } ?>
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
                                                    <div class="modal fade zoom" tabindex="-1" id="reasonModal<?php echo $data['leave_id'];?>">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><?php echo $data['leave_id'];?></h5>
                                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <em class="icon ni ni-cross"></em>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><?php echo $data['leave_reason'];?></p>
                                                                </div>
                                                                <div class="modal-footer bg-light">
                                                                    <span class="sub-text"><?php echo $data['employeeData']['employee_first_name']; ?> <?php echo $data['employeeData']['employee_middle_name']; ?> <?php echo $data['employeeData']['employee_last_name']; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade zoom" tabindex="-1" id="rejectionModal<?php echo $data['leave_id'];?>">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><?php echo $data['leave_id'];?></h5>
                                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <em class="icon ni ni-cross"></em>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><?php echo $data['leave_rejection_reason'];?></p>
                                                                </div>
                                                                <div class="modal-footer bg-light">
                                                                    <span class="sub-text"><?php echo $data['employeeData']['employee_first_name']; ?> <?php echo $data['employeeData']['employee_middle_name']; ?> <?php echo $data['employeeData']['employee_last_name']; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" tabindex="-1" id="cancelModal<?php echo urlEncodes($data['leave_id']); ?>">
                                                        <div class="modal-dialog modal-dialog-top" role="document">
                                                            <div class="modal-content">
                                                                <form action="<?php echo base_url(); ?>edit-employee-leave/<?php echo urlEncodes($data['leave_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Cancel Leave</h5>
                                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <em class="icon ni ni-cross"></em>
                                                                        </a>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure want to cancel your leave?</p>
                                                                    </div>
                                                                    <div class="modal-footer bg-light">
                                                                        <span class="sub-text"><input type="submit" class="btn btn-sm btn-danger submitBtn" name="submit_leave_cancel" value="Cancel"></span>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="editModal<?php echo urlEncodes($data['leave_id']); ?>">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form action="<?php echo base_url(); ?>edit-employee-leave/<?php echo urlEncodes($data['leave_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Leave</h5>
                                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <em class="icon ni ni-cross"></em>
                                                                        </a>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row gy-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <div class="form-control-wrap">
                                                                                        <select class="form-control form-select js-select2 leaveTypeEdit" data-ui="xl" data-id="<?php echo $data['leave_id']; ?>" name="leave_type" data-placeholder="Select a type" required>
                                                                                            <option value="full"<?php if($data['leaveData']['leave_type'] =="full"){ echo "selected"; } else { echo ""; } ?>>Full</option> 
                                                                                            <option value="half"<?php if($data['leaveData']['leave_type'] =="half"){ echo "selected"; } else { echo ""; } ?>>Half</option>
                                                                                            <option value="short"<?php if($data['leaveData']['leave_type'] =="short"){ echo "selected"; } else { echo ""; } ?>>Short</option>
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
                                                                                        <input type="text" class="form-control form-control-xl form-control-outlined date-picker" name="leave_from_date" value="<?php echo $data['leaveData']['leave_from_date']; ?>" data-date-format="dd/mm/yyyy" autocomplete="off" required>
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
                                                                                        <input type="text" class="form-control form-control-xl form-control-outlined date-picker" name="leave_to_date" value="<?php echo $data['leaveData']['leave_to_date']; ?>" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                                                                        <label class="form-label-outlined" for="leave_to_date">Leave To Date *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 n-none" id="leaveFromTimeEdit<?php echo $data['leave_id']; ?>">
                                                                                <div class="form-group">
                                                                                    <div class="form-control-wrap">
                                                                                        <div class="form-icon form-icon-right">
                                                                                            <em class="icon ni ni-clock"></em>
                                                                                        </div>
                                                                                        <input type="text" class="form-control form-control-xl form-control-outlined time-picker" name="leave_from_time" value="<?php echo $data['leaveData']['leave_from_time']; ?>" autocomplete="off" required>
                                                                                        <label class="form-label-outlined" for="leave_from_time">Leave From Time *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 n-none" id="leaveToTimeEdit<?php echo $data['leave_id']; ?>">
                                                                                <div class="form-group">
                                                                                    <div class="form-control-wrap">
                                                                                        <div class="form-icon form-icon-right">
                                                                                            <em class="icon ni ni-clock"></em>
                                                                                        </div>
                                                                                        <input type="text" class="form-control form-control-xl form-control-outlined time-picker" name="leave_to_time" value="<?php echo $data['leaveData']['leave_to_time']; ?>" autocomplete="off" required>
                                                                                        <label class="form-label-outlined" for="leave_to_time">Leave To Time *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 n-none" id="leaveDaysEdit<?php echo $data['leave_id']; ?>">
                                                                                <div class="form-group">
                                                                                    <div class="form-control-wrap">
                                                                                        <input type="text" class="form-control form-control-xl form-control-outlined" name="leave_days" value="<?php echo $data['leaveData']['leave_days']; ?>" autocomplete="off" required>
                                                                                        <label class="form-label-outlined" for="leave_days">Leave Days *</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <div class="form-control-wrap">
                                                                                        <textarea class="form-control form-control-xl form-control-outlined" name="leave_reason" required><?php echo $data['leaveData']['leave_reason']; ?></textarea>
                                                                                        <label class="form-label-outlined" for="leave_reason">Leave Reason *</label>
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
                                                <?php } ?>
                                            </tbody>
                                        <?php } else { ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="11">
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
                                                <td colspan="11">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">You don't have permission to show the leave's data</span>
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
            <?php if($isLeaveEmployeeView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div>
        
    </div>
</div>

<div class="modal fade" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url(); ?>new-employee-leave" method="post" class="form-validate is-alter" enctype="multipart/form-data">
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
                                    <select class="form-control form-select js-select2 leaveTypeAdd" data-ui="xl" name="leave_type" data-placeholder="Select a type" required>
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
                        <div class="col-md-12 n-none" id="leaveFromTimeAdd">
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
                        <div class="col-md-12 n-none" id="leaveToTimeAdd">
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
                        <div class="col-md-12 n-none" id="leaveDaysAdd">
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
                                <input type="submit" class="btn btn-primary submitBtn" name="submit" value="Save Informations">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('search-type').addEventListener('change', function() {
        var selectedType = this.value;
        $.ajax({
            url: '<?= base_url('view-employee-leave'); ?>',
            type: 'POST',
            data: { search_leave_employee_type: selectedType },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<script>
    document.getElementById('search-leave').addEventListener('change', function() {
        var selectedLeave = this.value;
        $.ajax({
            url: '<?= base_url('view-employee-leave'); ?>',
            type: 'POST',
            data: { search_leave_employee_leave: selectedLeave },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        function handleLeaveTypeChange() {
            var selectedValue = $(this).val();
    
            if (selectedValue == 'short') {
                $('#leaveFromTimeAdd').show();
                $('#leaveToTimeAdd').show();
            } else {
                $('#leaveFromTimeAdd').hide();
                $('#leaveToTimeAdd').hide();
            }
        }
    
        $('.leaveTypeAdd').change(handleLeaveTypeChange);
    
        $('.leaveTypeAdd').each(function() {
            handleLeaveTypeChange.call(this);
        });
        
        $('form').submit(function(event) {
            var totalLeaveDays = 0;
            
            $('.leaveTypeAdd').each(function() {
                var selectedValue = $(this).val();
    
                if (selectedValue == 'full' || selectedValue == 'half') {
                    $('#leaveFromTimeAdd').find('input').val('');
                    $('#leaveToTimeAdd').find('input').val('');
                }
                
                if (selectedValue == 'full') {
                    $('#leaveDaysAdd').find('input').val('full');
                }
    
                if (selectedValue == 'half') {
                    $('#leaveDaysAdd').find('input').val('0.5');
                }
    
                if (selectedValue == 'short') {
                    $('#leaveDaysAdd').find('input').val('0');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        function handleLeaveTypeChange() {
            var id = $(this).data('id');
            var selectedValue = $(this).val();
    
            if (selectedValue == 'short') {
                $('#leaveFromTimeEdit' + id).show();
                $('#leaveToTimeEdit' + id).show();
            } else {
                $('#leaveFromTimeEdit' + id).hide();
                $('#leaveToTimeEdit' + id).hide();
            }
        }
    
        $('.leaveTypeEdit').change(handleLeaveTypeChange);
    
        $('.leaveTypeEdit').each(function() {
            handleLeaveTypeChange.call(this);
        });
    
        $('form').submit(function(event) {
            var totalLeaveDays = 0;
            
            $('.leaveTypeEdit').each(function() {
                var id = $(this).data('id');
                var selectedValue = $(this).val();
    
                if (selectedValue == 'full' || selectedValue == 'half') {
                    $('#leaveFromTimeEdit' + id).find('input').val('');
                    $('#leaveToTimeEdit' + id).find('input').val('');
                }
    
                if (selectedValue == 'full') {
                    $('#leaveDaysEdit' + id).find('input').val('full');
                }
    
                if (selectedValue == 'half') {
                    $('#leaveDaysEdit' + id).find('input').val('0.5');
                }
    
                if (selectedValue == 'short') {
                    $('#leaveDaysEdit' + id).find('input').val('0');
                }
            });
        });
    });
</script>