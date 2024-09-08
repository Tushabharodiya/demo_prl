<?php 
    $sessionSystemViewPreviousUrl = $this->session->userdata('session_system_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">System</h4>
                    <div class="nk-block-des text-soft">
                        <p>New System</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionSystemViewPreviousUrl)){ echo $sessionSystemViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="employee_id">Employee Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="employee_id" data-placeholder="Select a employee" data-search="on" required>
                                        <option label="empty" value=""></option>
                                        <?php if(!empty($employeeData)){ ?>
                                            <?php foreach($employeeData as $data){ ?>
                                                <option value="<?php echo $data['employee_id']; ?>"><?php echo $data['employee_first_name']; ?> <?php echo $data['employee_middle_name']; ?> <?php echo $data['employee_last_name']; ?> - <?php echo $data['employee_type']; ?></option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">Empty</option>
                                        <?php }  ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_name">System Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_name" placeholder="Enter system name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_password">System Password *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_password" placeholder="Enter system password" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_operating">System Operating *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_operating" placeholder="Enter system operating" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_ram">System Ram *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_ram" placeholder="Enter system ram" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_processor">System Processor *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_processor" placeholder="Enter system processor" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_ssd">System SSD *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_ssd" placeholder="Enter system ssd" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_hdd">System HDD *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_hdd" placeholder="Enter system hdd" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_version">System Version *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_version" placeholder="Enter system version" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_keyboard">System Keyboard *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_keyboard" placeholder="Enter system keyboard" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_mouse">System Mouse *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_mouse" placeholder="Enter system mouse" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="system_display">System Display *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="system_display" placeholder="Enter system display" required>
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