<?php
    $departmentID = $this->uri->segment(2);

    $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
    $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');

    $sessionDepartmentUser = $this->session->userdata('session_department_user');
    $sessionDepartmentUserStatus = $this->session->userdata('session_department_user_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-user-list-fill"></em> All Department User</h4>
                    <div class="nk-block-des text-soft">
                        <p><?php echo "You have total $countDepartmentUser department users."; ?></p>
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
                                            <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Department User</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_user_department_status" data-id="<?php echo $departmentID; ?>"  data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionDepartmentUserStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionDepartmentUserStatus == 'active')){
                                                                            $str.='selected';
                                                                    } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionDepartmentUserStatus == 'blocked')){
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
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>new-user" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                </li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionDepartmentViewPreviousUrl)){ echo $sessionDepartmentViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                        <input type="text" class="form-control form-control-lg" name="search_department_user" value="<?php if(!empty($sessionDepartmentUser)){ echo $sessionDepartmentUser; } ?>" placeholder="Search..." autocomplete="off">
                        <div class="form-icon form-icon-right">
                            <em class="icon ni ni-search"></em>
                        </div>
                        <input type="submit" class="btn btn-sm btn-info d-none" name="submit_search" value="Filter">
                        <input type="submit" class="btn btn-sm btn-secondary d-none" name="reset_search" value="Reset">
                    </div>
                </div>
            </form>
        </div>

        <div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table table-tranx">
                                <thead>
                                    <tr class="tb-tnx-head">
                                        <th class="nk-tb-col" width="10%"><span>ID</span></th>
                                        <th class="nk-tb-col" width="15%"><span>Department</span></th>
                                        <th class="nk-tb-col" width="20%"><span>User</span></th>
                                        <th class="nk-tb-col" width="20%"><span>Email</span></th>
                                        <th class="nk-tb-col" width="15%"><span>Role</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if(!empty($viewDepartmentUser)){ ?>
                                    <tbody>
                                        <?php foreach($viewDepartmentUser as $data){ ?>
                                        <tr class="tb-tnx-item">
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_id']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $departmentData['department_name']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_name']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_email']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_role']; ?></span>
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
                                                </ul>
                                            </td>
                                        </tr>
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
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        var departmentID = $(this).data('id');
        $.ajax({
            url: '<?= base_url('view-department-user'); ?>/' + departmentID,
            type: 'POST',
            data: { search_department_user_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>