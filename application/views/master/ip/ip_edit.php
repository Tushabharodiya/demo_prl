<?php 
    $sessionIpViewPreviousUrl = $this->session->userdata('session_ip_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Allowed Ip</h4>
                    <div class="nk-block-des text-soft">
                        <p>You can add, edit and remove IP Addresses as you want. <span class="text-primary">Current IP is - <?php echo $_SERVER['REMOTE_ADDR']; ?></span></p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionIpViewPreviousUrl)){ echo $sessionIpViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="data_name">IP Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="data_name" value="<?php echo $ipData['data_name']; ?>" placeholder="Enter data name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="data_ip">IP Address *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="data_ip" value="<?php echo $ipData['data_ip']; ?>" placeholder="Enter ip address" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="data_start_time">Data Start Time *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control time-picker" name="data_start_time" value="<?php echo $ipData['data_start_time']; ?>" placeholder="Enter data start time" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="data_end_time">Data End Time *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control time-picker" name="data_end_time" value="<?php echo $ipData['data_end_time']; ?>" placeholder="Enter data end time" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="data_status">Data Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="data_status" data-placeholder="Select a status" required>
                                        <option value="active"<?php if($ipData['data_status'] =="active"){ echo "selected"; } else { echo ""; } ?>>Active</option> 
                                        <option value="blocked"<?php if($ipData['data_status'] =="blocked"){ echo "selected"; } else { echo ""; } ?>>Blocked</option>
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