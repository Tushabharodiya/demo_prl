<?php 
    $sessionAdvertiserViewPreviousUrl = $this->session->userdata('session_advertiser_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Advertiser</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Advertiser</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionAdvertiserViewPreviousUrl)){ echo $sessionAdvertiserViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="advertiser_name">Advertiser Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="advertiser_name" placeholder="Enter advertiser name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="advertiser_address">Advertiser Address *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="advertiser_address" placeholder="Enter advertiser address" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                    <label class="form-label" for="advertiser_project">Advertiser Project *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="advertiser_project" placeholder="Enter advertiser project" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="advertiser_status">Advertiser Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="advertiser_status" data-placeholder="Select a status" required>
                                        <option label="empty" value=""></option>
                                        <option value="blocked">Blocked</option>
                                        <option value="active">Active</option>
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