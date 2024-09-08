<?php 
    $sessionReportingEmployeeViewPreviousUrl = $this->session->userdata('session_reporting_employee_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Reporting</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Reporting</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionReportingEmployeeViewPreviousUrl)){ echo $sessionReportingEmployeeViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="reporting_project_name">Reporting Project Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control js-tagify tagify" name="reporting_project_name" placeholder="Enter reporting project name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="reporting_task">Reporting Task *</label>
                                <div class="form-control-wrap">
                                    <textarea type="text" class="form-control tinymce-default" name="reporting_task" placeholder="Enter reporting task" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="reporting_progress">Reporting Progress *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="reporting_progress" placeholder="Enter reporting progress" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="reporting_type">Reporting Type *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="reporting_type" data-placeholder="Select a type" required>
                                        <option label="empty" value=""></option>
                                        <option value="inprogress">Inprogress</option>
                                        <option value="completed">Completed</option>
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