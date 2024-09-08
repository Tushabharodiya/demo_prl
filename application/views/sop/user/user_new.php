<?php 
    $sessionSopUserViewPreviousUrl = $this->session->userdata('session_sop_user_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">User</h4>
                    <div class="nk-block-des text-soft">
                        <p>New User</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionSopUserViewPreviousUrl)){ echo $sessionSopUserViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <?php if(!empty($this->session->userdata('session_sop_user_new'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                Sorry! You cant't insert user name !! Please before insert <a href="<?php echo base_url('new-sop-department');?>" class="alert-link"><?php echo $this->session->userdata('session_sop_user_new');?></a> <?php echo $this->session->unset_userdata('session_sop_user_new');?>
            </div>
        <?php } ?>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="user_id">User Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="user_id" data-placeholder="Select a user" data-search="on" required>
                                        <option label="empty" value=""></option>
                                        <?php if(!empty($userData)){ ?>
                                            <?php foreach($userData as $data){ ?>
                                                <option value="<?php echo $data['user_id']; ?>"><?php echo $data['user_name']; ?></option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Empty</option>
                                        <?php }  ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary submitBtn" name="submit" value="Save Informations">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>