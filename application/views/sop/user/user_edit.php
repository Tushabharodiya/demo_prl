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
                        <p>Edit User</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionSopUserViewPreviousUrl)){ echo $sessionSopUserViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="user_id">User Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="user_id" data-placeholder="Select a user" data-search="on" required>
                                        <?php foreach($viewUser as $data){
                                            $selected = $data['user_id'] == $userData['user_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['user_id'].'" '.$selected.'>'.$data['user_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="user_permission[]">User Permission *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="user_permission[]" multiple="multiple" data-placeholder="Select a permission" data-search="on" required>
                                        <?php foreach($procedureData as $data) { ?>
                                            <option value="<?php echo $data['sop_id']; ?>"
                                            <?php if(!empty($getUser)){
                                            $userPermissions = $getUser['user_permission'];
                                            $permissionArray = explode(",", $userPermissions);
                                            foreach($permissionArray as $row){
                                                $sopID = $row;
                                                if($sopID == $data['sop_id']){ ?>
                                                    selected
                                            <?php } } } ?> >
                                            <?php echo $data['sop_title']; ?> -> <?php echo $data['sop_department']; ?> - <?php echo $data['sop_created_by']; ?></option>
                                        <?php } ?>
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