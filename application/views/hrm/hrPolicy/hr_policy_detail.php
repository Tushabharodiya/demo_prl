<?php 
    $hrPolicyID = $this->uri->segment(2);

    $sessionHrPolicyViewPreviousUrl = $this->session->userdata('session_hr_policy_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">HR Policy</h4>
                    <div class="nk-block-des text-soft">
                        <p>Detail HR Policy</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li><a href="<?php echo base_url(); ?>pdf-hr-policy/<?php echo $hrPolicyID; ?>" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionHrPolicyViewPreviousUrl)){ echo $sessionHrPolicyViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                    <?php foreach($detailHrPolicy as $data){ ?>
                        <div class="letter p-3"><?php 
                            $pageBreak = '<div style="page-break-before: always;"></div>';
                            
                            echo str_replace(array(
                                "#[page_break]#",
                                "#[effective_date]#"
                            ),array(
                                $pageBreak,
                                $data['effective_date'] 
                            ),$data['hr_policy_letter']); 
                        ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
    </div>
</div>