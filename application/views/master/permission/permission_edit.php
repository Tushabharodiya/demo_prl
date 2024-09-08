<?php 
    $sessionPermissionViewPreviousUrl = $this->session->userdata('session_permission_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Permission</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Permission</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionPermissionViewPreviousUrl)){ echo $sessionPermissionViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="alias_id">Alias Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="alias_id" data-placeholder="Select a alias" data-search="on" required>
                                        <?php foreach($viewAlias as $data){
                                            $selected = $data['alias_id'] == $aliasData['alias_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['alias_id'].'" '.$selected.'>'.$data['alias_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="permission_name">Permission Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="permission_name" value="<?php echo $permissionData['permission_name']; ?>" placeholder="Enter permission name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="permission_alias">Permission Alias *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="permission_alias" value="<?php echo $permissionData['permission_alias']; ?>" placeholder="Enter permission alias" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="permission_description">Permission Description *</label>
                                <div class="form-control-wrap">
                                    <textarea type="text" class="form-control" name="permission_description" placeholder="Enter permission description" required><?php echo $permissionData['permission_description']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="permission_position">Permission Position *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="permission_position" value="<?php echo $permissionData['permission_position']; ?>" placeholder="Enter permission position" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="permission_status">Permission Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="permission_status" data-placeholder="Select a status" required>
                                        <option value="true"<?php if($permissionData['permission_status'] =="true"){ echo "selected"; } else { echo ""; } ?>>True</option> 
                                        <option value="false"<?php if($permissionData['permission_status'] =="false"){ echo "selected"; } else { echo ""; } ?>>False</option>
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