<?php 
    $sessionNoDueCertificateViewPreviousUrl = $this->session->userdata('session_no_due_certificate_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">No Due Certificate</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit No Due Certificate</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionNoDueCertificateViewPreviousUrl)){ echo $sessionNoDueCertificateViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                                            echo '<option value="'.$data['employee_id'].'" '.$selected.'>'.$data['employee_first_name'].' '.$data['employee_middle_name'].' '.$data['employee_last_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="employee_settlement_salary">Employee Settlement Salary *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="employee_settlement_salary" value="<?php echo $noDueCertificateData['employee_settlement_salary']; ?>" placeholder="Enter employee settlement salary" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="employee_encashment_salary">Employee Encashment Salary *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="employee_encashment_salary" value="<?php echo $noDueCertificateData['employee_encashment_salary']; ?>" placeholder="Enter employee encashment salary" required>
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