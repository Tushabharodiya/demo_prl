<?php 
    $sessionWarningMailViewPreviousUrl = $this->session->userdata('session_warning_mail_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Warning Mail</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Warning Mail</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionWarningMailViewPreviousUrl)){ echo $sessionWarningMailViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                                                <option value="<?php echo $data['employee_id']; ?>"><?php echo $data['employee_first_name']; ?> <?php echo $data['employee_middle_name']; ?> <?php echo $data['employee_last_name']; ?></option>
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
                                <label class="form-label" for="warning_reason">Warning Reason *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="warning_reason" placeholder="Enter warning reason" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="warning_description">Warning Description *</label>
                                <div class="form-control-wrap">
                                    <textarea class="tinymce-default form-control" name="warning_description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="create_date">Create Date *</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" class="form-control date-picker" name="create_date" placeholder="Enter create date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
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