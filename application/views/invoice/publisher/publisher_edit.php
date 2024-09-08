<?php 
    $sessionPublisherViewPreviousUrl = $this->session->userdata('session_publisher_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Publisher</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Publisher</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionPublisherViewPreviousUrl)){ echo $sessionPublisherViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="publisher_name">Publisher Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="publisher_name" value="<?php echo $publisherData['publisher_name']; ?>" placeholder="Enter publisher name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="publisher_address">Publisher Address *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="publisher_address" value="<?php echo $publisherData['publisher_address']; ?>" placeholder="Enter publisher address" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="publisher_gst_number">Publisher GST Number *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="publisher_gst_number" value="<?php echo $publisherData['publisher_gst_number']; ?>" placeholder="Enter publisher gst number" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="publisher_status">Publisher Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="publisher_status" data-placeholder="Select a status" required>
                                        <option value="active"<?php if($publisherData['publisher_status'] =="active"){ echo "selected"; } else { echo ""; } ?>>Active</option> 
                                        <option value="blocked"<?php if($publisherData['publisher_status'] =="blocked"){ echo "selected"; } else { echo ""; } ?>>Blocked</option>
                                    </select>
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