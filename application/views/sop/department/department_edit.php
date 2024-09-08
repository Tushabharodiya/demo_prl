<?php 
    $sessionSopDepartmentViewPreviousUrl = $this->session->userdata('session_sop_department_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Department</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Department</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionSopDepartmentViewPreviousUrl)){ echo $sessionSopDepartmentViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="department_id">Department Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="department_id" data-placeholder="Select a department" data-search="on" required>
                                        <?php foreach($viewDepartment as $data){
                                            $selected = $data['department_id'] == $departmentData['department_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['department_id'].'" '.$selected.'>'.$data['department_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="department_permission[]">Department Permission *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="department_permission[]" multiple="multiple" data-placeholder="Select a permission" data-search="on" required>
                                        <?php foreach($procedureData as $data) { ?>
                                            <option value="<?php echo $data['sop_id']; ?>"
                                            <?php if(!empty($getDepartment)){
                                            $departmentPermissions = $getDepartment['department_permission'];
                                            $permissionArray = explode(",", $departmentPermissions);
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