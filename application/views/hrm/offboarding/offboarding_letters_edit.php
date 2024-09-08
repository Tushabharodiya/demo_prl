<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Offboarding Letters</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Offboarding Letters</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <?php if($param === 'vvcAX9Xtq0'){ ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="employee_no_due_certificate_letter">Employee No Due Certificate Letter *</label>
                                    <div class="form-control-wrap">
                                        <textarea class="tinymce-default form-control" name="employee_no_due_certificate_letter" required><?php echo $offboardingLettersData['employee_no_due_certificate_letter']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } else if($param === 'ZyC8C04vgG'){ ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="employee_relieving_letter">Employee Relieving Letter *</label>
                                    <div class="form-control-wrap">
                                        <textarea class="tinymce-default form-control" name="employee_relieving_letter" required><?php echo $offboardingLettersData['employee_relieving_letter']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } else if($param === 'EKhMYxkeLZ'){ ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="employee_experience_letter">Employee Experience Letter *</label>
                                    <div class="form-control-wrap">
                                        <textarea class="tinymce-default form-control" name="employee_experience_letter" required><?php echo $offboardingLettersData['employee_experience_letter']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } else if($param === 'C1IFWYxhVw'){ ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="employee_termination_letter">Employee Termination Letter *</label>
                                    <div class="form-control-wrap">
                                        <textarea class="tinymce-default form-control" name="employee_termination_letter" required><?php echo $offboardingLettersData['employee_termination_letter']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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