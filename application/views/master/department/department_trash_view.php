<?php
    $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
    $sessionDepartmentTrashViewPreviousUrl = $this->session->userdata('session_department_trash_view_previous_url');
    
    $sessionDepartmentTrash = $this->session->userdata('session_department_trash');
    $sessionDepartmentTrashStatus = $this->session->userdata('session_department_trash_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-user-fill-c"></em> All Department</h4>
                    <div class="nk-block-des text-soft">
                        <p><?php echo "You have total $countDepartment departments."; ?></p>
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
                                                    <span class="sub-title dropdown-title">Filter Department</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_department_trash_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionDepartmentTrashStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionDepartmentTrashStatus == 'publish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="publish"<?php echo $str; ?>>Publish</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionDepartmentTrashStatus == 'unpublish')){
                                                                            $str.='selected';
                                                                    } ?> <option value="unpublish"<?php echo $str; ?>>Unpublish</option>
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
                        <input type="text" class="form-control form-control-lg" name="search_department_trash" value="<?php if(!empty($sessionDepartmentTrash)){ echo $sessionDepartmentTrash; } ?>" placeholder="Search..." autocomplete="off">
                        <div class="form-icon form-icon-right">
                            <em class="icon ni ni-search"></em>
                        </div>
                        <input type="submit" class="btn btn-sm btn-info d-none" name="submit_search" value="Filter">
                        <input type="submit" class="btn btn-sm btn-secondary d-none" name="reset_search" value="Reset">
                    </div>
                </div>
            </form>
        </div>
        
        <?php if(!empty($this->session->userdata('session_department_restore_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_department_restore_success'); $this->session->unset_userdata('session_department_restore_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_department_delete_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_department_delete_success'); $this->session->unset_userdata('session_department_delete_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_department_delete_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_department_delete_error'); $this->session->unset_userdata('session_department_delete_error'); ?>
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
                                        <th class="nk-tb-col" width="10%"><span>Position</span></th>
                                        <th class="nk-tb-col" width="60%"><span>Name</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="20%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if(!empty($viewDepartment)){ ?>
                                    <tbody>
                                        <?php foreach($viewDepartment as $data){ ?>
                                        <tr class="tb-tnx-item">
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['department_id']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['department_name']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span><?php 
                                                    $departmentStatus = '';
                                                    if($data['department_status'] == 'publish'){
                                                        $departmentStatus.= '<span class="tb-status text-success">Publish</span>';
                                                    } else if($data['department_status'] == 'unpublish'){
                                                        $departmentStatus.= '<span class="tb-status text-danger">Unpublish</span>';
                                                    }
                                                    echo $departmentStatus; 
                                                ?></span>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li class="nk-tb-action">
                                                        <a data-bs-toggle="modal" data-bs-target="#restoreModal<?php echo urlEncodes($data['department_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Department Restore">
                                                            <em class="icon ni ni-undo"></em>
                                                        </a>
                                                    </li>
                                                    <li class="nk-tb-action">
                                                        <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['department_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Department Delete">
                                                            <em class="icon ni ni-trash-fill"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <div class="modal fade" tabindex="-1" id="restoreModal<?php echo urlEncodes($data['department_id']);?>">
                                            <div class="modal-dialog modal-dialog-top" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Restore Department</h5>
                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <em class="icon ni ni-cross"></em>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to restore <?php echo $data['department_name']; ?>?</p>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <span class="sub-text"><a href="<?php echo base_url(); ?>restore-department/<?php echo urlEncodes($data['department_id']); ?>" class="btn btn-sm btn-primary submitBtn">Restore</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['department_id']);?>">
                                            <div class="modal-dialog modal-dialog-top" role="document">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url(); ?>delete-department/<?php echo urlEncodes($data['department_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Department</h5>
                                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row g-gs">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="form-label-group">
                                                                            <label class="form-label" for="password">Are you sure you want to permanently delete <?php echo $data['department_name']; ?>?</label>
                                                                        </div>
                                                                        <div class="form-control-wrap">
                                                                            <a tabindex="-1" href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-icon form-icon-right passcode-switch" data-target="password<?php echo $data['department_id'];?>">
                                                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                            </a>
                                                                            <input autocomplete="new-password" type="password" class="form-control" id="password<?php echo $data['department_id'];?>" name="password" placeholder="Enter admin password" required>
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
                                            <td colspan="4">
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
        $.ajax({
            url: '<?= base_url('view-trash-department'); ?>',
            type: 'POST',
            data: { search_department_trash_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>