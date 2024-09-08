<?php 
    $sessionSopUserProcedureViewPreviousUrl = $this->session->userdata('session_sop_user_procedure_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
         <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Procedure</h4>
                    <div class="nk-block-des text-soft">
                        <p>Information User Procedure</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionSopUserProcedureViewPreviousUrl)){ echo $sessionSopUserProcedureViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="nk-block">
            <?php foreach($infoUserProcedure as $data){ ?>
            <div class="row g-gs">
                <div class="col-md-12">
                    <div class="card card-bordered">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="user-card user-card-s2">
                                    <div class="user-info">
                                        <h5><?php echo $data['sop_department']; ?></h5>
                                        <span class="sub-text"><?php echo $data['sop_title']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <h6 class="overline-title mb-2">Short Details</h6>
                                <div class="row g-gs">
                                    <div class="col-md-4">
                                        <span class="sub-text">Created By:</span>
                                        <span><?php echo $data['sop_created_by']; ?></span>
                                    </div>
                                     <div class="col-md-4">
                                        <span class="sub-text">Approved By:</span>
                                        <span><?php echo $data['sop_approved_by']; ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="sub-text">Updated By:</span>
                                        <span><?php echo $data['sop_updated_by']; ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="sub-text">Purpose:</span>
                                        <span><?php echo $data['sop_purpose']; ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="sub-text">Outcomes:</span>
                                        <span><?php echo $data['sop_outcomes']; ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="sub-text">Responsibility:</span>
                                        <span><?php echo $data['sop_responsibility']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <article class="entry">
                                <div class="card-footer border text-muted mb-3">
                                    <h4>Procedure</h4>
                                </div>
                                <?php echo $data['sop_description']; ?>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <h6 class="overline-title mb-2">Tag Details</h6>
                            <div class="row g-gs">
                                <div class="col-md-12">
                                    <span><?php  
                                        echo str_replace( 
                                            array('[', ']', '{', '}', '"value":', '"', ","), 
                                            array(" ", " ", " ", " ", " ", " ", "&nbsp;&nbsp;&nbsp;"), 
                                            $data['sop_tag']
                                        ); 
                                    ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        
    </div>
</div>