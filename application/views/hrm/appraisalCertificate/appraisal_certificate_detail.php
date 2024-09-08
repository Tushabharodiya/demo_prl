<?php 
    $appraisalCertificateID = $this->uri->segment(2);
    
    $sessionAppraisalCertificateViewPreviousUrl = $this->session->userdata('session_appraisal_certificate_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Appraisal Certificate</h4>
                    <div class="nk-block-des text-soft">
                        <p>Detail Appraisal Certificate</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li><a href="<?php echo base_url(); ?>pdf-appraisal-certificate/<?php echo $appraisalCertificateID; ?>" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionAppraisalCertificateViewPreviousUrl)){ echo $sessionAppraisalCertificateViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner">
                    <?php foreach($detailAppraisalCertificate as $data){ ?>
                        <div class="letter p-3"><?php 
                            $pageBreak = '<div style="page-break-before: always;"></div>';
                            
                            echo str_replace(array(
                                "#[page_break]#",
                                "#[employee_department]#",
                                "#[employee_name]#",
                                "#[employee_salary]#",
                                "#[create_date]#",
                            ),array(
                                $pageBreak,
                                $data['departmentData']['department_name'], 
                                $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'], 
                                $data['employeeData']['employee_salary'],
                                $data['create_date'],
                            ),$data['appraisal_certificate_letter']);
                        ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
    </div>
</div>