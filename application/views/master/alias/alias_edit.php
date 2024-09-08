<?php 
    $sessionAliasViewPreviousUrl = $this->session->userdata('session_alias_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Alias</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Alias</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionAliasViewPreviousUrl)){ echo $sessionAliasViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="alias_name">Alias Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="alias_name" value="<?php echo $aliasData['alias_name']; ?>" placeholder="Enter alias name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="alias_position">Alias Position *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="alias_position" value="<?php echo $aliasData['alias_position']; ?>" placeholder="Enter alias position" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="alias_status">Alias Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="alias_status" data-placeholder="Select a status" required>
                                        <option value="true"<?php if($aliasData['alias_status'] =="true"){ echo "selected"; } else { echo ""; } ?>>True</option> 
                                        <option value="false"<?php if($aliasData['alias_status'] =="false"){ echo "selected"; } else { echo ""; } ?>>False</option>
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