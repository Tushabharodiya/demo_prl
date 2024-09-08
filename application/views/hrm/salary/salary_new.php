<?php 
    $sessionSalaryViewPreviousUrl = $this->session->userdata('session_salary_view_previous_url');
    
    $sessionSalaryStartDate = $this->session->userdata('session_salary_start_date');
    $sessionSalaryEndDate = $this->session->userdata('session_salary_end_date');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Salary</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Salary</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionSalaryViewPreviousUrl)){ echo $sessionSalaryViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="input-daterange date-picker-range input-group">
                                        <input type="text" class="form-control date-picker" name="search_salary_start_date" value="<?php if(!empty($sessionSalaryStartDate)){ echo $sessionSalaryStartDate; } ?>" placeholder="Enter start date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                        <div class="input-group-addon">TO</div>
                                        <input type="text" class="form-control date-picker" name="search_salary_end_date" value="<?php if(!empty($sessionSalaryEndDate)){ echo $sessionSalaryEndDate; } ?>" placeholder="Enter end date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="submit" class="btn btn-md btn-dim btn-secondary" name="reset_filter" value="Reset Filter">
                                <input type="submit" class="btn btn-md btn-dim btn-info" name="submit_filter" value="Submit Filter">
                            </div>
                        </div>
                        <?php if(!empty($sessionSalaryStartDate && !empty($sessionSalaryEndDate))){ ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="employee_id">Employee Name *</label>
                                    <div class="form-control-wrap">
                                        <select class="form-control form-select js-select2" name="employee_id" data-placeholder="Select a employee" data-search="on">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="employee_bonus">Employee Bonus *</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="employee_bonus" value="0" placeholder="Enter employee bonus" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="employee_other_deduction">Employee Other Deduction *</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="employee_other_deduction" value="0" placeholder="Enter employee other deduction" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="employee_create_date">Employee Create Date *</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-calendar-alt"></em>
                                        </div>
                                        <input type="text" class="form-control date-picker" name="employee_create_date" placeholder="Enter employee create date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary submitBtn salary-btn" name="submit" value="Save Informations">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>