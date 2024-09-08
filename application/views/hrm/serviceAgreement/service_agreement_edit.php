<?php 
    $sessionServiceAgreementViewPreviousUrl = $this->session->userdata('session_service_agreement_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Service Agreement</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Service Agreement</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionServiceAgreementViewPreviousUrl)){ echo $sessionServiceAgreementViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                                <label class="form-label" for="director_name">Director Name *</label>
                                <div class="form-control-wrap">
                                    <ul class="nk-kycfm-control-list g-3">
                                        <li class="nk-kycfm-control-item">
                                            <input type="radio" class="nk-kycfm-control" id="<?php echo DIRECTOR_1_NAME; ?>" name="director_name" value="<?php echo DIRECTOR_1_ADDRESS; ?>" <?php if($serviceAgreementData['director_name'] == DIRECTOR_1_ADDRESS){ ?> checked <?php } ?> required>
                                            <label class="nk-kycfm-label" for="<?php echo DIRECTOR_1_NAME; ?>"><em class="icon ni ni-file-docs"></em><span class="nk-kycfm-label-text"><?php echo DIRECTOR_1_NAME; ?></span></label>
                                        </li>
                                        <li class="nk-kycfm-control-item">
                                            <input type="radio" class="nk-kycfm-control" id="<?php echo DIRECTOR_2_NAME; ?>" name="director_name" value="<?php echo DIRECTOR_2_ADDRESS; ?>" <?php if($serviceAgreementData['director_name'] == DIRECTOR_2_ADDRESS){ ?> checked <?php } ?> required>
                                            <label class="nk-kycfm-label" for="<?php echo DIRECTOR_2_NAME; ?>"><em class="icon ni ni-file-docs"></em><span class="nk-kycfm-label-text"><?php echo DIRECTOR_2_NAME; ?></span></label>
                                        </li>
                                    </ul>
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
                                    <input type="text" class="form-control date-picker" name="create_date" value="<?php echo $serviceAgreementData['create_date']; ?>" placeholder="Enter create date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
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