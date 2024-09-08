<?php
    $isSopDepartmentAdd = checkPermission(SOP_DEPARTMENT_ALIAS, "can_add");
    $isSopDepartmentView = checkPermission(SOP_DEPARTMENT_ALIAS, "can_view");
    $isSopDepartmentEdit = checkPermission(SOP_DEPARTMENT_ALIAS, "can_edit");
    $isSopDepartmentDelete = checkPermission(SOP_DEPARTMENT_ALIAS, "can_delete");

    $sessionSopDepartmentViewPreviousUrl = $this->session->userdata('session_sop_department_view_previous_url');

    $sessionSopDepartment = $this->session->userdata('session_sop_department');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Department</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isSopDepartmentView){ ?>
                            <p><?php echo "You have total $countDepartment departments."; ?></p>
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
                                        <li><a href="<?php echo base_url(); ?>view-trash-sop-department" class="btn btn-white btn-outline-light"><em class="icon ni ni-trash-fill"></em><span>Trash <sup><?php echo $countDepartmentTrash; ?></sup></span></a></li>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($isSopDepartmentAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-sop-department" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isSopDepartmentView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_sop_department" value="<?php if(!empty($sessionSopDepartment)){ echo $sessionSopDepartment; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_sop_department_trash_user'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_sop_department_trash_user');?> Please delete <a href="<?php echo base_url('view-sop-user');?>" class="alert-link">sop user</a> before trashing department<?php echo $this->session->unset_userdata('session_sop_department_trash_user');?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_sop_department_trash_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_sop_department_trash_success'); $this->session->unset_userdata('session_sop_department_trash_success'); ?>
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
                                        <th class="nk-tb-col" width="80%"><span>Name</span></th>
                                        <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if($isSopDepartmentView){ ?>
                                    <?php if(!empty($viewDepartment)){ ?>
                                        <tbody>
                                            <?php foreach($viewDepartment as $data){ ?>
                                            <tr class="tb-tnx-item">
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['unique_id']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['departmentData']['department_name']; ?></span>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <?php if($isSopDepartmentEdit){ ?>
                                                            <li class="nk-tb-action">
                                                                <a href="<?php echo base_url(); ?>edit-sop-department/<?php echo urlEncodes($data['unique_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                    <em class="icon ni ni-edit-fill"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#trashModal<?php echo urlEncodes($data['unique_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Trash">
                                                                        <em class="icon ni ni-trash-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <div class="modal fade" tabindex="-1" id="trashModal<?php echo urlEncodes($data['unique_id']);?>">
                                                <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Trash Department</h5>
                                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to trash <?php echo $data['departmentData']['department_name']; ?>?</p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><a href="<?php echo base_url(); ?>trash-sop-department/<?php echo urlEncodes($data['unique_id']); ?>" class="btn btn-sm btn-warning submitBtn">Trash</a></span>
                                                        </div>
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
                                <?php } else { ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <div class="nk-block-content text-center p-3">
                                                    <span class="sub-text">You don't have permission to show the department's data</span>
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
            <?php if($isSopDepartmentView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div>
        
    </div>
</div>