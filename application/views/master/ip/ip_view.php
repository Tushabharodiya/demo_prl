<?php
    $sessionIpViewPreviousUrl = $this->session->userdata('session_ip_view_previous_url');
    
    $sessionIp = $this->session->userdata('session_ip');
    $sessionIpStatus = $this->session->userdata('session_ip_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-shield-half"></em> Allowed Ip</h4>
                    <div class="nk-block-des text-soft">
                        <p><?php echo "You have total $countIp ips."; ?></p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li>
                                    <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                        <div class="dropdown">
                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">Filter Ip</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_ip_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionIpStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionIpStatus == 'active')){
                                                                            $str.='selected';
                                                                    } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionIpStatus == 'blocked')){
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
                                <li><a href="<?php echo base_url(); ?>view-trash-ip" class="btn btn-white btn-outline-light"><em class="icon ni ni-trash-fill"></em><span>Trash <sup><?php echo $countIpTrash; ?></sup></span></a></li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>new-ip" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nk-search-box mt-0">
            <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg" name="search_ip" value="<?php if(!empty($sessionIp)){ echo $sessionIp; } ?>" placeholder="Search..." autocomplete="off">
                        <div class="form-icon form-icon-right">
                            <em class="icon ni ni-search"></em>
                        </div>
                        <input type="submit" class="btn btn-sm btn-info d-none" name="submit_search" value="Filter">
                        <input type="submit" class="btn btn-sm btn-secondary d-none" name="reset_search" value="Reset">
                    </div>
                </div>
            </form>
        </div>
        
        <?php if(!empty($this->session->userdata('session_ip_trash_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_ip_trash_success'); $this->session->unset_userdata('session_ip_trash_success'); ?>
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
                                        <th class="nk-tb-col" width="5%"><span>ID</span></th>
                                        <th class="nk-tb-col" width="18%"><span>Name</span></th>
                                        <th class="nk-tb-col" width="12%"><span>Ip</span></th>
                                        <th class="nk-tb-col" width="20%"><span>Email</span></th>
                                        <th class="nk-tb-col" width="18%"><span>Time</span></th>
                                        <th class="nk-tb-col" width="7%"><span>Start</span></th>
                                        <th class="nk-tb-col" width="7%"><span>End</span></th>
                                        <th class="nk-tb-col" width="8%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="5%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if(!empty($viewIp)){ ?>
                                    <tbody>
                                        <?php foreach($viewIp as $data){ ?>
                                        <tr class="tb-tnx-item">
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['data_id']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['data_name']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['data_ip']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['data_email']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['data_time']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['data_start_time']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['data_end_time']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                               <span><?php 
                                                    $dataStatus = '';
                                                    if($data['data_status'] == 'active'){
                                                        $dataStatus.= '<span class="tb-status text-success">Active</span>';
                                                    } else if($data['data_status'] == 'blocked'){
                                                        $dataStatus.= '<span class="tb-status text-danger">Blocked</span>';
                                                    }
                                                    echo $dataStatus; 
                                                ?></span>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li class="nk-tb-action">
                                                        <a href="<?php echo base_url(); ?>edit-ip/<?php echo urlEncodes($data['data_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <em class="icon ni ni-edit-fill"></em>
                                                        </a>
                                                    </li>
                                                    <li class="nk-tb-action">
                                                        <a data-bs-toggle="modal" data-bs-target="#trashModal<?php echo urlEncodes($data['data_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Trash">
                                                            <em class="icon ni ni-trash-fill"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <div class="modal fade" tabindex="-1" id="trashModal<?php echo urlEncodes($data['data_id']);?>">
                                            <div class="modal-dialog modal-dialog-top" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Trash Allowed Ip</h5>
                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <em class="icon ni ni-cross"></em>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to trash <?php echo $data['data_name'];?>?</p>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <span class="sub-text"><a href="<?php echo base_url(); ?>trash-ip/<?php echo urlEncodes($data['data_id']); ?>" class="btn btn-sm btn-warning submitBtn">Trash</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </tbody>
                                <?php } else { ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="9">
                                                <div class="nk-block-content text-center p-3">
                                                    <span class="sub-text">No data available in table</span>
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
            <ul class="pagination justify-content-center justify-content-md-center mt-3">
                <?php echo $this->pagination->create_links(); ?>
            </ul>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        $.ajax({
            url: '<?= base_url('view-ip'); ?>',
            type: 'POST',
            data: { search_ip_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>