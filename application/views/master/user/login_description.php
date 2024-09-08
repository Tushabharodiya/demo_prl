<?php
    $sessionLoginViewPreviousUrl = $this->session->userdata('session_login_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
    
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title"><em class="icon ni ni-users-fill"></em> Login Description</h3>
                    <div class="nk-block-des text-soft">
                        <p>Login Description</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionLoginViewPreviousUrl)){ echo $sessionLoginViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="nk-block">
            <div class="card card-bordered">
                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $_SERVER['REQUEST_URI']; ?>"><em class="icon ni ni-user-fill-c"></em><span>Information</span></a>
                    </li>
                </ul>
                <div class="card-inner card-inner-lg">
                    <div class="nk-block">
                        <div class="nk-data data-list data-list-s2">
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Name</span>
                                    <span class="data-value">
                                        <?php echo $loginDescription['user_name']; ?> 
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Email</span>
                                    <span class="data-value">
                                        <?php echo $loginDescription['user_email']; ?> 
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Role</span>
                                    <span class="data-value text-soft">
                                        <?php echo $loginDescription['user_role']; ?> 
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Key</span>
                                    <span class="data-value">
                                       <?php echo $loginDescription['user_key']; ?> 
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Login</span>
                                    <span class="data-value">
                                        <?php echo $loginDescription['user_login']; ?> 
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Logout</span>
                                    <span class="data-value">
                                        <?php echo $loginDescription['user_logout']; ?> 
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Agent</span>
                                    <span class="data-value">
                                        <?php echo $loginDescription['user_agenet']; ?> 
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Ip Address</span>
                                    <span class="data-value">
                                        <?php echo $loginDescription['user_ip']; ?> 
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Status</span>
                                    <span class="data-value">
                                        <?php echo $loginDescription['user_status']; ?> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>