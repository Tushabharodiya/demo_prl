<?php
    $isAdvertiserAdd = checkPermission(ADVERTISER_ALIAS, "can_add");
    $isAdvertiserView = checkPermission(ADVERTISER_ALIAS, "can_view");
    $isAdvertiserEdit = checkPermission(ADVERTISER_ALIAS, "can_edit");
    $isAdvertiserDelete = checkPermission(ADVERTISER_ALIAS, "can_delete");

    $sessionAdvertiserViewPreviousUrl = $this->session->userdata('session_advertiser_view_previous_url');

    $sessionAdvertiser = $this->session->userdata('session_advertiser');
    $sessionAdvertiserStatus = $this->session->userdata('session_advertiser_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Advertiser</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isAdvertiserView){ ?>
                            <p><?php echo "You have total $countAdvertiser advertisers."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isAdvertiserView){ ?>
                                    <li>
                                        <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="dropdown">
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter Advertiser</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                    <select class="form-control form-select" id="search-status" name="search_advertiser_status" data-placeholder="Select a status">
                                                                        <?php $str='';
                                                                            if(!empty($sessionAdvertiserStatus == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAdvertiserStatus == 'active')){
                                                                                $str.='selected';
                                                                        } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAdvertiserStatus == 'blocked')){
                                                                                $str.='selected';
                                                                        } ?> <option value="blocked"<?php echo $str; ?>>Blocked</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-foot between">
                                                        <input type="submit" class="btn btn-sm btn-dim btn-secondary" name="reset_filter" value="Reset Filter">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                <?php } ?>
                                <?php if($isAdvertiserAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-advertiser" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isAdvertiserView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_advertiser" value="<?php if(!empty($sessionAdvertiser)){ echo $sessionAdvertiser; } ?>" placeholder="Search..." autocomplete="off">
                            <div class="form-icon form-icon-right">
                                <em class="icon ni ni-search"></em>
                            </div>
                            <input type="submit" class="btn btn-sm btn-info d-none" name="submit_search" value="Filter">
                            <input type="submit" class="btn btn-sm btn-secondary d-none" name="reset_search" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>

        <div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table table-tranx">
                                <thead>
                                    <tr class="tb-tnx-head">
                                        <th class="nk-tb-col" width="10%"><span>ID</span></th>
                                        <th class="nk-tb-col" width="25%"><span>Name</span></th>
                                        <th class="nk-tb-col" width="25%"><span>Address</span></th>
                                        <th class="nk-tb-col" width="25%"><span>Project</span></th>
                                        <th class="nk-tb-col" width="8%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="7%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if($isAdvertiserView){ ?>
                                    <?php if(!empty($viewAdvertiser)){ ?>
                                        <tbody>
                                            <?php foreach($viewAdvertiser as $data){ ?>
                                            <tr class="tb-tnx-item">
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['advertiser_id']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php 
                                                        $advertiserName = $data['advertiser_name'];
                                                        if(strlen($advertiserName) > 30){
                                                            echo substr($advertiserName, 0, 30);
                                                        } else {
                                                            echo $advertiserName;
                                                        }
                                                    ?></span>
                                                    <?php if(strlen($advertiserName) > 30){ ?>
                                                        <a data-bs-toggle="modal" data-bs-target="#modalNameZoom<?php echo $data['advertiser_id'];?>" class="sub-text text-primary">Read More</a>
                                                    <?php } ?>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php 
                                                        $advertiserAddress = $data['advertiser_address'];
                                                        if(strlen($advertiserAddress) > 30){
                                                            echo substr($advertiserAddress, 0, 30);
                                                        } else {
                                                            echo $advertiserAddress;
                                                        }
                                                    ?></span>
                                                    <?php if(strlen($advertiserAddress) > 30){ ?>
                                                        <a data-bs-toggle="modal" data-bs-target="#modalAddressZoom<?php echo $data['advertiser_id'];?>" class="sub-text text-primary">Read More</a>
                                                    <?php } ?>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php 
                                                        $advertiserProject = $data['advertiser_project'];
                                                        if(strlen($advertiserProject) > 30){
                                                            echo substr($advertiserProject, 0, 30);
                                                        } else {
                                                            echo $advertiserProject;
                                                        }
                                                    ?></span>
                                                    <?php if(strlen($advertiserProject) > 30){ ?>
                                                        <a data-bs-toggle="modal" data-bs-target="#modalProjectZoom<?php echo $data['advertiser_id'];?>" class="sub-text text-primary">Read More</a>
                                                    <?php } ?>
                                                </td>
                                                <td class="nk-tb-col">
                                                   <span><?php 
                                                        $advertiserStatus = '';
                                                        if($data['advertiser_status'] == 'active'){
                                                            $advertiserStatus.= '<span class="tb-status text-success">Active</span>';
                                                        } else if($data['advertiser_status'] == 'blocked'){
                                                            $advertiserStatus.= '<span class="tb-status text-danger">Blocked</span>';
                                                        } 
                                                        echo $advertiserStatus; 
                                                    ?></span>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <?php if($isAdvertiserEdit){ ?>
                                                            <li class="nk-tb-action">
                                                                <a href="<?php echo base_url(); ?>edit-advertiser/<?php echo urlEncodes($data['advertiser_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                    <em class="icon ni ni-edit-fill"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <div class="modal fade zoom" tabindex="-1" id="modalNameZoom<?php echo $data['advertiser_id'];?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $data['advertiser_id'];?></h5>
                                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><?php echo $data['advertiser_name'];?></p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><?php echo $data['advertiser_status'];?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade zoom" tabindex="-1" id="modalAddressZoom<?php echo $data['advertiser_id'];?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $data['advertiser_id'];?></h5>
                                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><?php echo $data['advertiser_address'];?></p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><?php echo $data['advertiser_status'];?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade zoom" tabindex="-1" id="modalProjectZoom<?php echo $data['advertiser_id'];?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $data['advertiser_id'];?></h5>
                                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><?php echo $data['advertiser_project'];?></p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><?php echo $data['advertiser_status'];?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </tbody>
                                    <?php } else { ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">No data available in table</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <div class="nk-block-content text-center p-3">
                                                    <span class="sub-text">You don't have permission to show the advertiser's data</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($isAdvertiserView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        $.ajax({
            url: '<?= base_url('view-advertiser'); ?>',
            type: 'POST',
            data: { search_advertiser_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>