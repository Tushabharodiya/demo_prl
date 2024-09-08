<?php 
    $sessionSalaryViewPreviousUrl = $this->session->userdata('session_salary_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Salary</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Salary</p>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="employee_id">Employee Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="employee_id" data-placeholder="Select a employee" data-search="on" required>
                                        <?php foreach($viewEmployee as $data){
                                            $selected = $data['employee_id'] == $employeeData['employee_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['employee_id'].'" '.$selected.'>'.$data['employee_first_name'].' '.$data['employee_middle_name'].' '.$data['employee_last_name'].' - '.$data['employee_type'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="employee_payable_day">Employee Payable Day *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="employee_payable_day" value="<?php echo $salaryData['employee_payable_day']; ?>" placeholder="Enter employee payable day" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="employee_overtime">Employee Overtime *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="employee_overtime" value="<?php echo $salaryData['employee_overtime']; ?>" placeholder="Enter employee overtime" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="employee_bonus">Employee Bonus *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="employee_bonus" value="<?php echo $salaryData['employee_bonus']; ?>" placeholder="Enter employee bonus" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="employee_other_deduction">Employee Other Deduction *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="employee_other_deduction" value="<?php echo $salaryData['employee_other_deduction']; ?>" placeholder="Enter employee other deduction" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="employee_unpaid_leave_amount">Employee Unpaid Leave Amount *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="employee_unpaid_leave_amount" value="<?php echo $salaryData['employee_unpaid_leave_amount']; ?>" placeholder="Enter employee unpaid leave amount" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="employee_create_date">Employee Create Date *</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" class="form-control date-picker" name="employee_create_date" value="<?php echo $salaryData['employee_create_date']; ?>" placeholder="Enter employee create date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
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