<?php 
    $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">User</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit User</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionUserViewPreviousUrl)){ echo $sessionUserViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="employee_id">User Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="employee_id" data-placeholder="Select a user" data-search="on" required>
                                        <?php foreach($viewEmployee as $data){
                                            $selected = $data['employee_id'] == $employeeData['employee_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['employee_id'].'" '.$selected.'>'.$data['employee_first_name'].' '.$data['employee_last_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="department_id">Department Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="department_id" data-search="on">
                                        <option value="<?php echo $departmentData['department_id']; ?>"><?php echo $departmentData['department_name']; ?></option>
                                        <?php foreach($viewDepartment as $data){ ?>
                                            <option value="<?php echo $data['department_id']; ?>"><?php echo $data['department_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="user_email">User Email *</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-mail"></em>
                                    </div>
                                    <input type="email" class="form-control" name="user_email" value="<?php echo $userMasterData['user_email']; ?>" placeholder="Enter user email" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="user_password">User Password *</label>
                                <div class="form-control-wrap">
                                    <a tabindex="-1" href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-icon form-icon-right passcode-switch" data-target="password">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                    <input autocomplete="new-password" type="password" class="form-control" id="password" name="user_password" placeholder="Enter user password">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="user_status">User Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="user_status" data-placeholder="Select a status" required>
                                        <option value="active"<?php if($userMasterData['user_status'] =="active"){ echo "selected"; } else { echo ""; } ?>>Active</option> 
                                        <option value="blocked"<?php if($userMasterData['user_status'] =="blocked"){ echo "selected"; } else { echo ""; } ?>>Blocked</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary submitBtn" name="submit" value="Update">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>