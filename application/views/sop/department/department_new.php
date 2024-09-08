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
                        <p>New Department</p>
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
                                        <option label="empty" value=""></option>
                                        <?php if(!empty($departmentData)){ ?>
                                            <?php foreach($departmentData as $data){ ?>
                                                <option value="<?php echo $data['department_id']; ?>"><?php echo $data['department_name']; ?></option>
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
                                <label class="form-label" for="department_permission[]">Department Permission *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="department_permission[]" multiple="multiple" data-placeholder="Select a permission" data-search="on" required>
                                        <option label="empty" value=""></option>
                                        <?php if(!empty($procedureData)){ ?>
                                            <?php foreach($procedureData as $data){ ?>
                                                <option value="<?php echo $data['sop_id']; ?>"><?php echo $data['sop_title']; ?> -> <?php echo $data['sop_department']; ?> - <?php echo $data['sop_created_by']; ?></option>
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