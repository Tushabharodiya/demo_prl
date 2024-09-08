<?php
    $sessionSopProcedureViewPreviousUrl = $this->session->userdata('session_sop_procedure_view_previous_url');
    $sessionSopProcedureTrashViewPreviousUrl = $this->session->userdata('session_sop_procedure_trash_view_previous_url');

    $sessionSopProcedureTrash = $this->session->userdata('session_sop_procedure_trash');
    $sessionSopProcedureTrashStatus = $this->session->userdata('session_sop_procedure_trash_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Procedure</h4>
                    <div class="nk-block-des text-soft">
                        <?php if(!empty($this->session->userdata['user_role'])){ ?>
                            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                <p><?php echo "You have total $countProcedure procedures."; ?></p>
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
                                                            <span class="sub-title dropdown-title">Filter Procedure</span>
                                                        </div>
                                                        <div class="dropdown-body dropdown-body-rg">
                                                            <div class="row gx-6 gy-3">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">Status</label>
                                                                        <select class="form-control form-select" id="search-status" name="search_sop_procedure_trash_status" data-placeholder="Select a status">
                                                                            <?php $str='';
                                                                                if(!empty($sessionSopProcedureTrashStatus == 'all')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionSopProcedureTrashStatus == 'true')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="true"<?php echo $str; ?>>True</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionSopProcedureTrashStatus == 'false')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="false"<?php echo $str; ?>>False</option>
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
                                <li><a href="<?php if(!empty($sessionSopProcedureViewPreviousUrl)){ echo $sessionSopProcedureViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a></li>
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
                                <input type="text" class="form-control form-control-lg" name="search_sop_procedure_trash" value="<?php if(!empty($sessionSopProcedureTrash)){ echo $sessionSopProcedureTrash; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_sop_procedure_restore_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_sop_procedure_restore_success'); $this->session->unset_userdata('session_sop_procedure_restore_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_sop_procedure_delete_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_sop_procedure_delete_success'); $this->session->unset_userdata('session_sop_procedure_delete_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_sop_procedure_delete_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_sop_procedure_delete_error'); $this->session->unset_userdata('session_sop_procedure_delete_error'); ?>
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
                                        <th class="nk-tb-col" width="30%"><span>Title</span></th>
                                        <th class="nk-tb-col" width="24%"><span>Department</span></th>
                                        <th class="nk-tb-col" width="24%"><span>Created By</span></th>
                                        <th class="nk-tb-col" width="7%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="5%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                        <?php if(!empty($viewProcedure)){ ?>
                                            <tbody>
                                                <?php foreach($viewProcedure as $data){ ?>
                                                <tr class="tb-tnx-item">
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['sop_id']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php 
                                                            $sopTitle = $data['sop_title'];
                                                            if(strlen($sopTitle) > 35){
                                                                echo substr($sopTitle, 0, 35);
                                                            } else {
                                                                echo $sopTitle;
                                                            }
                                                        ?></span>
                                                        <?php if(strlen($sopTitle) > 35){ ?>
                                                            <a data-bs-toggle="modal" data-bs-target="#modalTitleZoom<?php echo $data['sop_id'];?>" class="sub-text text-primary">Read More</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['sop_department']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['sop_created_by']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                       <span><?php 
                                                            $sopStatus = '';
                                                            if($data['sop_status'] == 'true'){
                                                                $sopStatus.= '<span class="tb-status text-success">True</span>';
                                                            } else if($data['sop_status'] == 'false'){
                                                                $sopStatus.= '<span class="tb-status text-danger">False</span>';
                                                            } 
                                                            echo $sopStatus; 
                                                        ?></span>
                                                    </td>
                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a data-bs-toggle="modal" data-bs-target="#restoreModal<?php echo urlEncodes($data['sop_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Restore">
                                                                            <em class="icon ni ni-undo"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['sop_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                            <em class="icon ni ni-trash-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <div class="modal fade zoom" tabindex="-1" id="modalTitleZoom<?php echo $data['sop_id'];?>">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $data['sop_id'];?></h5>
                                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><?php echo $data['sop_title'];?></p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><?php echo $data['sop_status'];?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="restoreModal<?php echo urlEncodes($data['sop_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Restore Procedure</h5>
                                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to restore <?php echo $data['sop_title'];?>?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>restore-sop-procedure/<?php echo urlEncodes($data['sop_id']); ?>" class="btn btn-sm btn-primary submitBtn">Restore</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['sop_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <form action="<?php echo base_url(); ?>delete-sop-procedure/<?php echo urlEncodes($data['sop_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete Procedure</h5>
                                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <em class="icon ni ni-cross"></em>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row g-gs">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <div class="form-label-group">
                                                                                    <label class="form-label" for="password">Are you sure you want to permanently delete <?php echo $data['sop_title'];?>?</label>
                                                                                </div>
                                                                                <div class="form-control-wrap">
                                                                                    <a tabindex="-1" href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-icon form-icon-right passcode-switch" data-target="password<?php echo $data['sop_id'];?>">
                                                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                                    </a>
                                                                                    <input autocomplete="new-password" type="password" class="form-control" id="password<?php echo $data['sop_id'];?>" name="password" placeholder="Enter admin password" required>
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
                                                    <td colspan="6">
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
                                                <td colspan="6">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">You don't have permission to show the procedure's data</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <div class="nk-block-content text-center p-3">
                                                    <span class="sub-text">You don't have permission to show the procedure's data</span>
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
            url: '<?= base_url('view-trash-sop-procedure'); ?>',
            type: 'POST',
            data: { search_sop_procedure_trash_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>