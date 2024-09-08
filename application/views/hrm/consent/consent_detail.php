<?php 
    $consentID = $this->uri->segment(2);

    $sessionConsentViewPreviousUrl = $this->session->userdata('session_consent_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Consent</h4>
                    <div class="nk-block-des text-soft">
                        <p>Detail Consent</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li><a href="<?php echo base_url(); ?>pdf-consent/<?php echo $consentID; ?>" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionConsentViewPreviousUrl)){ echo $sessionConsentViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                    <?php foreach($detailConsent as $data){ ?>
                        <div class="letter p-3"><?php 
                            $pageBreak = '<div style="page-break-before: always;"></div>';
                            
                            if(!empty($data['employeeData']['employee_bank_name'])){
                                $employeeBankName = $data['employeeData']['employee_bank_name'];
                            } else {
                                $employeeBankName = " - ";
                            }
                            
                            if(!empty($data['employeeData']['employee_cheque_no'])){
                                $employeeChequeNo = $data['employeeData']['employee_cheque_no'];
                            } else {
                                $employeeChequeNo = " - ";
                            }
                            
                            echo str_replace(array(
                                "#[page_break]#",
                                "#[employee_name]#",
                                "#[employee_bank_name]#",
                                "#[employee_cheque_no]#",
                                "#[employee_consent_name]#",
                                "#[create_date]#"
                            ),array(
                                $pageBreak,
                                $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'], 
                                $employeeBankName, 
                                $employeeChequeNo, 
                                $data['employeeData']['employee_consent_name'],
                                $data['create_date'],
                            ),$data['consent_letter']);
                        ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
    </div>
</div>