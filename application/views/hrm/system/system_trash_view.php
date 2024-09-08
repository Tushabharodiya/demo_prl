<?php
    $sessionSystemViewPreviousUrl = $this->session->userdata('session_system_view_previous_url');
    $sessionSystemTrashViewPreviousUrl = $this->session->userdata('session_system_trash_view_previous_url');

    $sessionSystemTrash = $this->session->userdata('session_system_trash');
    $sessionSystemTrashStatus = $this->session->userdata('session_system_trash_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">System</h4>
                    <div class="nk-block-des text-soft">
                        <?php if(!empty($this->session->userdata['user_role'])){ ?>
                            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                <p><?php echo "You have total $countSystem systems."; ?></p>
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
                                                    <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                        <div class="dropdown-head">
                                                            <span class="sub-title dropdown-title">Filter System</span>
                                                        </div>
                                                        <div class="dropdown-body dropdown-body-rg">
                                                            <div class="row gx-6 gy-3">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">Status</label>
                                                                        <select class="form-control form-select" id="search-status" name="search_system_trash_status" data-placeholder="Select a status">
                                                                            <?php $str='';
                                                                                if(!empty($sessionSystemTrashStatus == 'all')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionSystemTrashStatus == 'active')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionSystemTrashStatus == 'inactive')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="inactive"<?php echo $str; ?>>Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-foot between">
                                                            <input type="submit" class="btn btn-sm btn-dim btn-secondary" name="reset_filter" value="Reset Filter">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                                <li><a href="<?php if(!empty($sessionSystemViewPreviousUrl)){ echo $sessionSystemViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a></li>
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
                                <input type="text" class="form-control form-control-lg" name="search_system_trash" value="<?php if(!empty($sessionSystemTrash)){ echo $sessionSystemTrash; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_system_restore_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_system_restore_success'); $this->session->unset_userdata('session_system_restore_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_system_delete_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_system_delete_success'); $this->session->unset_userdata('session_system_delete_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_system_delete_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_system_delete_error'); $this->session->unset_userdata('session_system_delete_error'); ?>
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
                                            <th class="nk-tb-col" width="25%"><span>Employee</span></th>
                                            <th class="nk-tb-col" width="15%"><span>Department</span></th>
                                            <th class="nk-tb-col" width="20%"><span>Name</span></th>
                                            <th class="nk-tb-col" width="20%"><span>Password</span></th>
                                            <th class="nk-tb-col" width="5%"><span>Status</span></th>
                                            <th class="nk-tb-col text-end" width="5%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                        <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                            <?php if(!empty($viewSystem)){ ?>
                                                <tbody>
                                                    <?php foreach($viewSystem as $data){ ?>
                                                    <tr class="tb-tnx-item">
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['system_id']; ?></span>
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
                                                                <a data-bs-toggle="modal" data-bs-target="#infoModal<?php echo urlEncodes($data['system_id']);?>">
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
                                                            <span class="sub-text"><?php echo $data['system_name']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['system_password']; ?></span>
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
                                                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                        <li class="nk-tb-action">
                                                                            <a data-bs-toggle="modal" data-bs-target="#restoreModal<?php echo urlEncodes($data['system_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Restore">
                                                                                <em class="icon ni ni-undo"></em>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                        <li class="nk-tb-action">
                                                                            <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['system_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                                <em class="icon ni ni-trash-fill"></em>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade zoom" tabindex="-1" id="infoModal<?php echo urlEncodes($data['system_id']); ?>">
                                                    <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">System Info</h5>
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
                                                                            <p><span class="data-label">System ID : </span><span class="data-value"><?php echo isset($data['system_id']) && !empty($data['system_id']) ? $data['system_id'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System Name : </span><span class="data-value"><?php echo isset($data['system_name']) && !empty($data['system_name']) ? $data['system_name'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System Password : </span><span class="data-value"><?php echo isset($data['system_password']) && !empty($data['system_password']) ? $data['system_password'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System Operating : </span><span class="data-value"><?php echo isset($data['system_operating']) && !empty($data['system_operating']) ? $data['system_operating'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System Ram : </span><span class="data-value"><?php echo isset($data['system_ram']) && !empty($data['system_ram']) ? $data['system_ram'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System Processor : </span><span class="data-value"><?php echo isset($data['system_processor']) && !empty($data['system_processor']) ? $data['system_processor'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System SSD : </span><span class="data-value"><?php echo isset($data['system_ssd']) && !empty($data['system_ssd']) ? $data['system_ssd'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System HDD : </span><span class="data-value"><?php echo isset($data['system_hdd']) && !empty($data['system_hdd']) ? $data['system_hdd'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System Version : </span><span class="data-value"><?php echo isset($data['system_version']) && !empty($data['system_version']) ? $data['system_version'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System Keyboard : </span><span class="data-value"><?php echo isset($data['system_keyboard']) && !empty($data['system_keyboard']) ? $data['system_keyboard'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System Mouse : </span><span class="data-value"><?php echo isset($data['system_mouse']) && !empty($data['system_mouse']) ? $data['system_mouse'] : '-'; ?></span></p>
                                                                            <p><span class="data-label">System Display : </span><span class="data-value"><?php echo isset($data['system_display']) && !empty($data['system_display']) ? $data['system_display'] : '-'; ?></span></p>
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
                                                    <div class="modal fade" tabindex="-1" id="restoreModal<?php echo urlEncodes($data['system_id']);?>">
                                                        <div class="modal-dialog modal-dialog-top" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Restore System</h5>
                                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <em class="icon ni ni-cross"></em>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to restore <?php echo $data['employeeData']['employee_first_name'];?>?</p>
                                                                </div>
                                                                <div class="modal-footer bg-light">
                                                                    <span class="sub-text"><a href="<?php echo base_url(); ?>restore-system/<?php echo urlEncodes($data['system_id']); ?>" class="btn btn-sm btn-primary submitBtn">Restore</a></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['system_id']);?>">
                                                        <div class="modal-dialog modal-dialog-top" role="document">
                                                            <div class="modal-content">
                                                                <form action="<?php echo base_url(); ?>delete-system/<?php echo urlEncodes($data['system_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Delete System</h5>
                                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <em class="icon ni ni-cross"></em>
                                                                        </a>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row g-gs">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <div class="form-label-group">
                                                                                        <label class="form-label" for="password">Are you sure you want to permanently delete <?php echo $data['employeeData']['employee_first_name'];?>?</label>
                                                                                    </div>
                                                                                    <div class="form-control-wrap">
                                                                                        <a tabindex="-1" href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-icon form-icon-right passcode-switch" data-target="password<?php echo $data['system_id'];?>">
                                                                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                                        </a>
                                                                                        <input autocomplete="new-password" type="password" class="form-control" id="password<?php echo $data['system_id'];?>" name="password" placeholder="Enter admin password" required>
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
                                                </tbody>
                                            <?php } else { ?>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7">
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
                                                    <td colspan="7">
                                                        <div class="nk-block-content text-center p-3">
                                                            <span class="sub-text">You don't have permission to show the system's data</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">You don't have permission to show the system's data</span>
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
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        $.ajax({
            url: '<?= base_url('view-trash-system'); ?>',
            type: 'POST',
            data: { search_system_trash_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>