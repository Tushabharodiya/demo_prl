<?php
    $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
    $sessionEmployeeTrashViewPreviousUrl = $this->session->userdata('session_employee_trash_view_previous_url');

    $sessionEmployeeTrash = $this->session->userdata('session_employee_trash');
    $sessionEmployeeTrashIsEmployee = $this->session->userdata('session_employee_trash_is_employee');
    $sessionEmployeeTrashType = $this->session->userdata('session_employee_trash_type');
    $sessionEmployeeTrashStatus = $this->session->userdata('session_employee_trash_status');
    $sessionEmployeeTrashCreatedStartDate = $this->session->userdata('session_employee_trash_created_start_date');
    $sessionEmployeeTrashCreatedEndDate = $this->session->userdata('session_employee_trash_created_end_date');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Employee</h4>
                    <div class="nk-block-des text-soft">
                        <?php if(!empty($this->session->userdata['user_role'])){ ?>
                            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                <p><?php echo "You have total $countEmployee employees."; ?></p>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
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
                                                                        <select class="form-control form-select" id="search-employee" name="search_employee_trash_is_employee" data-placeholder="Select a employee">
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashIsEmployee == 'all')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashIsEmployee == 'pending')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="pending"<?php echo $str; ?>>Pending</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashIsEmployee == 'selected')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="selected"<?php echo $str; ?>>Selected</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashIsEmployee == 'rejected')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="rejected"<?php echo $str; ?>>Rejected</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">Type</label>
                                                                        <select class="form-control form-select" id="search-type" name="search_employee_trash_type" data-placeholder="Select a type">
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashType == 'all')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashType == 'intern')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="intern"<?php echo $str; ?>>Intern</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashType == 'employee')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="employee"<?php echo $str; ?>>Employee</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">Status</label>
                                                                        <select class="form-control form-select" id="search-status" name="search_employee_trash_status" data-placeholder="Select a status">
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashStatus == 'all')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashStatus == 'draft')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="draft"<?php echo $str; ?>>Draft</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashStatus == 'active')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionEmployeeTrashStatus == 'inactive')){
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
                                                                                <input type="text" class="form-control date-picker" name="search_employee_trash_created_start_date" value="<?php if(!empty($sessionEmployeeTrashCreatedStartDate)){ echo $sessionEmployeeTrashCreatedStartDate; } ?>" placeholder="Enter start date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                                                                <div class="input-group-addon">TO</div>
                                                                                <input type="text" class="form-control date-picker" name="search_employee_trash_created_end_date" value="<?php if(!empty($sessionEmployeeTrashCreatedEndDate)){ echo $sessionEmployeeTrashCreatedEndDate; } ?>" placeholder="Enter end date" data-date-format="dd/mm/yyyy" autocomplete="off">
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
                                <?php } ?>
                                <li><a href="<?php if(!empty($sessionEmployeeViewPreviousUrl)){ echo $sessionEmployeeViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if(!empty($this->session->userdata['user_role'])){ ?>
            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                <div class="nk-search-box mt-0">
                    <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-lg" name="search_employee_trash" value="<?php if(!empty($sessionEmployeeTrash)){ echo $sessionEmployeeTrash; } ?>" placeholder="Search..." autocomplete="off">
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
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_restore_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_restore_success'); $this->session->unset_userdata('session_employee_restore_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_delete_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_delete_success'); $this->session->unset_userdata('session_employee_delete_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_delete_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_delete_error'); $this->session->unset_userdata('session_employee_delete_error'); ?>
            </div>
        <?php } ?>

        <div class="nk-block">
            <div class="row g-gs">
                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
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
                                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                        <div class="team-options">
                                                            <div class="drodown">
                                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end" style="">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                                <li><a data-bs-toggle="modal" data-bs-target="#restoreModal<?php echo urlEncodes($data['employee_id']);?>"><em class="icon ni ni-undo"></em><span>Restore</span></a></li>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                        <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                                <li><a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['employee_id']);?>"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
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
                                <div class="modal fade" tabindex="-1" id="restoreModal<?php echo urlEncodes($data['employee_id']);?>">
                                    <div class="modal-dialog modal-dialog-top" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Restore Employee</h5>
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to restore <?php echo $data['employee_first_name'];?>?</p>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <span class="sub-text"><a href="<?php echo base_url(); ?>restore-employee/<?php echo urlEncodes($data['employee_id']); ?>" class="btn btn-sm btn-primary submitBtn">Restore</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['employee_id']);?>">
                                    <div class="modal-dialog modal-dialog-top" role="document">
                                        <div class="modal-content">
                                            <form action="<?php echo base_url(); ?>delete-employee/<?php echo urlEncodes($data['employee_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Employee</h5>
                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <em class="icon ni ni-cross"></em>
                                                    </a>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row g-gs">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="password">Are you sure you want to permanently delete <?php echo $data['employee_first_name'];?>?</label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <a tabindex="-1" href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-icon form-icon-right passcode-switch" data-target="password<?php echo $data['employee_id'];?>">
                                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                    </a>
                                                                    <input autocomplete="new-password" type="password" class="form-control" id="password<?php echo $data['employee_id'];?>" name="password" placeholder="Enter admin password" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <span class="sub-text"><input type="submit" class="btn btn-sm btn-danger submitBtn" name="submit" value="Delete"></span>
                                                </div>
                                            </form>
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
            <?php if(!empty($this->session->userdata['user_role'])){ ?>
                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                    <ul class="pagination justify-content-center justify-content-md-center mt-3">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                <?php } ?>
            <?php } ?>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-employee').addEventListener('change', function() {
        var selectedIsEmployee = this.value;
        $.ajax({
            url: '<?= base_url('view-trash-employee'); ?>',
            type: 'POST',
            data: { search_employee_trash_is_employee: selectedIsEmployee },
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
            url: '<?= base_url('view-trash-employee'); ?>',
            type: 'POST',
            data: { search_employee_trash_type: selectedType },
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
            url: '<?= base_url('view-trash-employee'); ?>',
            type: 'POST',
            data: { search_employee_trash_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>