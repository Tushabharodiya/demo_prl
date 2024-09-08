<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
    
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title"><em class="icon ni ni-users-fill"></em> My Profile</h3>
                    <div class="nk-block-des text-soft">
                        <p>You have full control to manage your own account setting</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <?php if(!empty($this->session->userdata['user_role'])){ ?>
                        <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                            <a href="<?php echo base_url(); ?>dashboard" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                        <?php } else { ?>
                            <a href="<?php echo base_url(); ?>employee-dashboard" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="nk-block">
            <div class="card card-bordered">
                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $_SERVER['REQUEST_URI']; ?>"><em class="icon ni ni-user-fill-c"></em><span>Personal</span></a>
                    </li>
                </ul>
                <div class="card-inner card-inner-lg">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title">Personal Information</h4>
                            <div class="nk-block-des">
                                <p>Basic info, like your name and email, that you use on <?php echo TITLE; ?>.</p>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="nk-data data-list data-list-s2">
                            <div class="data-head">
                                <h6 class="overline-title">Basics</h6>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Name</span>
                                    <span class="data-value">
                                        <?php if($this->session->userdata != null){ ?> 
                                            <?php echo $this->session->userdata['user_name']; ?> 
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Email</span>
                                    <span class="data-value">
                                        <?php if($this->session->userdata != null){ ?> 
                                            <?php echo $this->session->userdata['user_email']; ?> 
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Role</span>
                                    <span class="data-value text-soft">
                                        <?php if($this->session->userdata != null){ ?> 
                                            <?php echo $this->session->userdata['user_role']; ?> 
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">User Login</span>
                                    <span class="data-value">
                                        <?php if($this->session->userdata != null){ ?> 
                                            <?php echo $this->session->userdata['user_login']; ?> 
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Is Login</span>
                                    <span class="data-value">
                                        <?php if($this->session->userdata != null){ ?> 
                                            <?php echo $this->session->userdata['is_login']; ?> 
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="data-col">
                                    <span class="data-label">Status</span>
                                    <span class="data-value">
                                        <?php if($this->session->userdata != null){ ?> 
                                            <?php echo $this->session->userdata['user_status']; ?> 
                                        <?php } ?>
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