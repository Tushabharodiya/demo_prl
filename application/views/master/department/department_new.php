<?php 
    $sessionDepartmentViewPreviousUrl = $this->session->userdata('session_department_view_previous_url');
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
                    <a href="<?php if(!empty($sessionDepartmentViewPreviousUrl)){ echo $sessionDepartmentViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="department_name">Department Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="department_name" placeholder="Enter department name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card card-bordered card-preview">
                                <?php if(!empty($permissionData)){ ?>
                                    <div class="card-inner">
                                        <div class="card-title-group align-start mb-2">
                                            <div class="card-title">
                                                <label class="form-label" for="department_permission">Select Department Permissions</label>
                                            </div>
                                        </div>
                                        <div class="example-alerts">
                                            <div class="row gy-4">
                                                <?php foreach($viewPermissionAlias as $data){ ?>
                                                    <div class="col-md-4">
                                                        <div id="accordion" class="accordion">
                                                            <div class="accordion-item">
                                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-item-<?php echo $data['alias_id']; ?>">
                                                                    <span class="title"><?php echo $data['alias_name']; ?></span>
                                                                    <span class="accordion-icon"></span>
                                                                </a>
                                                                <div class="accordion-body collapse" id="accordion-item-<?php echo $data['alias_id']; ?>" data-bs-parent="#accordion">
                                                                    <div class="accordion m-2">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-tranx">
                                                                                <thead>
                                                                                    <tr class="tb-tnx-head">
                                                                                        <th class="nk-tb-col" width="10%"><span>ID</span></th>
                                                                                        <th class="nk-tb-col" width="10%"><span>Check</span></th>
                                                                                        <th class="nk-tb-col" width="80%"><span>Name/Alias</span></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php foreach($data['permissionData'] as $data){ ?>
                                                                                        <tr class="nk-tb-item">
                                                                                            <td class="nk-tb-col">
                                                                                                <span class="sub-text"><?php echo $data['permission_id']; ?></span>
                                                                                            </td>
                                                                                            <td class="nk-tb-col nk-tb-col-check">
                                                                                                <div class="custom-control custom-control-sm custom-checkbox ">
                                                                                                    <input type="checkbox" class="custom-control-input" id="<?php echo $data['permission_id']; ?>" name="department_permission[]" value="<?php echo $data['permission_id']; ?>">
                                                                                                    <label class="custom-control-label" for="<?php echo $data['permission_id']; ?>"></label>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td class="nk-tb-col">
                                                                                                <div class="user-info">
                                                                                                    <span class="sub-text"><?php echo $data['permission_name']; ?></span>
                                                                                                    <span class="sub-text"><?php echo $data['permission_alias']; ?></span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="nk-block-content text-center p-4">
                                        <span class="sub-text">No data available in table</span>
                                    </div>
                                <?php } ?>
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