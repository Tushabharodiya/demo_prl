<?php
    $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
    
    $sessionUser = $this->session->userdata('session_user');
    $sessionUserLogin = $this->session->userdata('session_user_login');
    $sessionUserStatus = $this->session->userdata('session_user_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-users-fill"></em> All User</h4>
                    <div class="nk-block-des text-soft">
                        <p><?php echo "You have total $countUser users."; ?></p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li>
                                    <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                        <div class="dropdown">
                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter User</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Login</label>
                                                                <select class="form-control form-select" id="search-login" name="search_user_login" data-placeholder="Select a login">
                                                                    <?php $str='';
                                                                        if(!empty($sessionUserLogin == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionUserLogin == 'true')){
                                                                            $str.='selected';
                                                                    } ?> <option value="true"<?php echo $str; ?>>True</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionUserLogin == 'false')){
                                                                            $str.='selected';
                                                                    } ?> <option value="false"<?php echo $str; ?>>False</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_user_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionUserStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionUserStatus == 'active')){
                                                                            $str.='selected';
                                                                    } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionUserStatus == 'blocked')){
                                                                            $str.='selected';
                                                                    } ?> <option value="blocked"<?php echo $str; ?>>Blocked</option>
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
                                <li><a href="<?php echo base_url(); ?>view-trash-user" class="btn btn-white btn-outline-light"><em class="icon ni ni-trash-fill"></em><span>Trash <sup><?php echo $countUserTrash; ?></sup></span></a></li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>new-user" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nk-search-box mt-0">
            <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg" name="search_user" value="<?php if(!empty($sessionUser)){ echo $sessionUser; } ?>" placeholder="Search..." autocomplete="off">
                        <div class="form-icon form-icon-right">
                            <em class="icon ni ni-search"></em>
                        </div>
                        <input type="submit" class="btn btn-sm btn-info d-none" name="submit_search" value="Filter">
                        <input type="submit" class="btn btn-sm btn-secondary d-none" name="reset_search" value="Reset">
                    </div>
                </div>
            </form>
        </div>
        
        <?php if(!empty($this->session->userdata('session_user_trash_sop_user'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_user_trash_sop_user');?> Please delete <a href="<?php echo base_url('view-sop-user');?>" class="alert-link">sop user</a> before trashing user<?php echo $this->session->unset_userdata('session_user_trash_sop_user');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_user_trash_attendance_admin'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_user_trash_attendance_admin');?> Please delete <a href="<?php echo base_url('view-admin-attendance');?>" class="alert-link">attendance</a> before trashing user<?php echo $this->session->unset_userdata('session_user_trash_attendance_admin');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_user_trash_leave_admin'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_user_trash_leave_admin');?> Please delete <a href="<?php echo base_url('view-admin-leave');?>" class="alert-link">leave</a> before trashing user<?php echo $this->session->unset_userdata('session_user_trash_leave_admin');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_user_trash_reporting_admin'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_user_trash_reporting_admin');?> Please delete <a href="<?php echo base_url('view-admin-reporting');?>" class="alert-link">reporting</a> before trashing user<?php echo $this->session->unset_userdata('session_user_trash_reporting_admin');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_user_trash_user_permission'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_user_trash_user_permission'); $this->session->unset_userdata('session_user_trash_user_permission'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_user_trash_login_history'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_user_trash_login_history');?> Please delete <a href="<?php echo base_url('login-history');?>" class="alert-link">login history</a> before trashing user<?php echo $this->session->unset_userdata('session_user_trash_login_history');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_user_trash_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_user_trash_success'); $this->session->unset_userdata('session_user_trash_success'); ?>
            </div>
        <?php } ?>

        <div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table table-tranx">
                                <thead>
                                    <tr class="tb-tnx-head">
                                        <th class="nk-tb-col" width="10%"><span>ID</span></th>
                                        <th class="nk-tb-col" width="20%"><span>Name</span></th>
                                        <th class="nk-tb-col" width="22%"><span>Email</span></th>
                                        <th class="nk-tb-col" width="18%"><span>Department</span></th>
                                        <th class="nk-tb-col" width="8%"><span>Is Login</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="12%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if(!empty($viewUser)){ ?>
                                    <tbody>
                                        <?php foreach($viewUser as $data){ ?>
                                        <tr class="tb-tnx-item">
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_id']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <a href="<?php echo base_url(); ?>login-activity/<?php echo urlEncodes($data['user_id']); ?>"><span><?php echo $data['user_name']; ?></span></a>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_email']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['departmentName']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span><?php 
                                                    $isLogin = '';
                                                    if($data['is_login'] == 'True'){
                                                        $isLogin.= '<span class="tb-status text-success">True</span>';
                                                    }else if ($data['is_login'] == 'False'){
                                                        $isLogin.= '<span class="tb-status text-danger">False</span>';
                                                    }else{
                                                        $isLogin .= '-';
                                                    }
                                                    echo $isLogin; 
                                                ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span><?php 
                                                    $userStatus = '';
                                                    if($data['user_status'] == 'active'){
                                                        $userStatus.= '<span class="tb-status text-success">Active</span>';
                                                    } else if($data['user_status'] == 'blocked'){
                                                        $userStatus.= '<span class="tb-status text-danger">Blocked</span>';
                                                    }
                                                    echo $userStatus; 
                                                ?></span>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li class="nk-tb-action">
                                                        <a href="<?php echo base_url(); ?>user-rights/<?php echo urlEncodes($data['user_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="User Rights">
                                                            <em class="icon ni ni-shield-half"></em>
                                                        </a>
                                                    </li>
                                                    <li class="nk-tb-action">
                                                        <a href="<?php echo base_url(); ?>user-permission/<?php echo urlEncodes($data['user_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="User Permission">
                                                            <em class="icon ni ni-send"></em>
                                                        </a>
                                                    </li>
                                                    <li class="nk-tb-action">
                                                        <a href="<?php echo base_url(); ?>edit-user/<?php echo urlEncodes($data['user_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="User Edit">
                                                            <em class="icon ni ni-edit-fill"></em>
                                                        </a>
                                                    </li>
                                                    <li class="nk-tb-action">
                                                        <a data-bs-toggle="modal" data-bs-target="#trashModal<?php echo urlEncodes($data['user_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="User Trash">
                                                            <em class="icon ni ni-trash-fill"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <div class="modal fade" tabindex="-1" id="trashModal<?php echo urlEncodes($data['user_id']);?>">
                                            <div class="modal-dialog modal-dialog-top" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Trash User</h5>
                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <em class="icon ni ni-cross"></em>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to trash <?php echo $data['user_name']; ?>?</p>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <span class="sub-text"><a href="<?php echo base_url(); ?>trash-user/<?php echo urlEncodes($data['user_id']); ?>" class="btn btn-sm btn-warning submitBtn">Trash</a></span>
                                                    </div>
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="pagination justify-content-center justify-content-md-center mt-3">
                <?php echo $this->pagination->create_links(); ?>
            </ul>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-login').addEventListener('change', function() {
        var selectedLogin = this.value;
        $.ajax({
            url: '<?= base_url('view-user'); ?>',
            type: 'POST',
            data: { search_user_login: selectedLogin },
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
            url: '<?= base_url('view-user'); ?>',
            type: 'POST',
            data: { search_user_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>