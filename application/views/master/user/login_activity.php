<?php
    $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
    $sessionLoginViewPreviousUrl = $this->session->userdata('session_login_view_previous_url');
    
    $sessionLoginActivity = $this->session->userdata('session_login_activity');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-activity-round-fill"></em> Login Activity</h4>
                    <div class="nk-block-des text-soft">
                        <p><?php echo "You have total $countLoginActivity login datas."; ?></p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionUserViewPreviousUrl)){ echo $sessionUserViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                        <input type="text" class="form-control form-control-lg" name="search_login_activity" value="<?php if(!empty($sessionLoginActivity)){ echo $sessionLoginActivity; } ?>" placeholder="Search..." autocomplete="off">
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
                                        <th class="nk-tb-col" width="20%"><span>Name</span></th>
                                        <th class="nk-tb-col" width="25%"><span>Email</span></th>
                                        <th class="nk-tb-col" width="20%"><span>Login</span></th>
                                        <th class="nk-tb-col" width="20%"><span>Logout</span></th>
                                        <th class="nk-tb-col text-end" width="5%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if(!empty($viewLoginActivity)){ ?>
                                    <tbody>
                                        <?php foreach($viewLoginActivity as $data){ ?>
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
                                                        <a href="<?php echo base_url(); ?>login-description/<?php echo urlEncodes($data['unique_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Login Description">
                                                            <em class="icon ni ni-eye-fill"></em>
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