<?php
    $sessionLoginHistoryViewPreviousUrl = $this->session->userdata('session_login_history_view_previous_url');
    $sessionLoginHistoryTrashViewPreviousUrl = $this->session->userdata('session_login_history_trash_view_previous_url');

    $sessionLoginHistoryTrash = $this->session->userdata('session_login_history_trash');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-users-fill"></em> Login History</h4>
                    <div class="nk-block-des text-soft">
                        <p><?php echo "You have total $countLoginHistory login datas."; ?></p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionLoginHistoryViewPreviousUrl)){ echo $sessionLoginHistoryViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                        <input type="text" class="form-control form-control-lg" name="search_login_history_trash" value="<?php if(!empty($sessionLoginHistoryTrash)){ echo $sessionLoginHistoryTrash; } ?>" placeholder="Search..." autocomplete="off">
                        <div class="form-icon form-icon-right">
                            <em class="icon ni ni-search"></em>
                        </div>
                        <input type="submit" class="btn btn-sm btn-info d-none" name="submit_search" value="Filter">
                        <input type="submit" class="btn btn-sm btn-secondary d-none" name="reset_search" value="Reset">
                    </div>
                </div>
            </form>
        </div>
        
        <?php if(!empty($this->session->userdata('session_login_history_restore_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_login_history_restore_success'); $this->session->unset_userdata('session_login_history_restore_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_login_history_delete_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_login_history_delete_success'); $this->session->unset_userdata('session_login_history_delete_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_login_history_delete_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_login_history_delete_error'); $this->session->unset_userdata('session_login_history_delete_error'); ?>
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
                                        <th class="nk-tb-col" width="25%"><span>Email</span></th>
                                        <th class="nk-tb-col" width="20%"><span>Login</span></th>
                                        <th class="nk-tb-col" width="20%"><span>Logout</span></th>
                                        <th class="nk-tb-col text-end" width="5%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if(!empty($viewLoginHistory)){ ?>
                                    <tbody>
                                        <?php foreach($viewLoginHistory as $data){ ?>
                                        <tr class="tb-tnx-item">
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['unique_id']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_name']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_email']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_login']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['user_logout']; ?></span>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li class="nk-tb-action">
                                                        <a data-bs-toggle="modal" data-bs-target="#restoreModal<?php echo urlEncodes($data['unique_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Restore">
                                                            <em class="icon ni ni-undo"></em>
                                                        </a>
                                                    </li>
                                                    <li class="nk-tb-action">
                                                        <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['unique_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <em class="icon ni ni-trash-fill"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <div class="modal fade" tabindex="-1" id="restoreModal<?php echo urlEncodes($data['unique_id']);?>">
                                            <div class="modal-dialog modal-dialog-top" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Restore Login History</h5>
                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <em class="icon ni ni-cross"></em>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to restore <?php echo $data['user_name']; ?>?</p>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <span class="sub-text"><a href="<?php echo base_url(); ?>restore-login-history/<?php echo urlEncodes($data['unique_id']); ?>" class="btn btn-sm btn-primary submitBtn">Restore</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['unique_id']);?>">
                                            <div class="modal-dialog modal-dialog-top" role="document">
                                                <div class="modal-content">
                                                    <form action="<?php echo base_url(); ?>delete-login-history/<?php echo urlEncodes($data['unique_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Login History</h5>
                                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row g-gs">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="form-label-group">
                                                                            <label class="form-label" for="password">Are you sure you want to permanently delete <?php echo $data['user_name']; ?>?</label>
                                                                        </div>
                                                                        <div class="form-control-wrap">
                                                                            <a tabindex="-1" href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-icon form-icon-right passcode-switch" data-target="password<?php echo $data['unique_id'];?>">
                                                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                            </a>
                                                                            <input autocomplete="new-password" type="password" class="form-control" id="password<?php echo $data['unique_id'];?>" name="password" placeholder="Enter admin password" required>
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