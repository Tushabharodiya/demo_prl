<?php
    $sessionAliasViewPreviousUrl = $this->session->userdata('session_alias_view_previous_url');
    
    $sessionAlias = $this->session->userdata('session_alias');
    $sessionAliasStatus = $this->session->userdata('session_alias_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-shield-half"></em> All Alias</h4>
                    <div class="nk-block-des text-soft">
                        <p><?php echo "You have total $countAlias aliases."; ?></p>
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
                                                    <span class="sub-title dropdown-title">Filter Alias</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_alias_status" data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAliasStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAliasStatus == 'true')){
                                                                            $str.='selected';
                                                                    } ?> <option value="true"<?php echo $str; ?>>True</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAliasStatus == 'false')){
                                                                            $str.='selected';
                                                                    } ?> <option value="false"<?php echo $str; ?>>False</option>
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
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php echo base_url(); ?>new-alias" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
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
                        <input type="text" class="form-control form-control-lg" name="search_alias" value="<?php if(!empty($sessionAlias)){ echo $sessionAlias; } ?>" placeholder="Search..." autocomplete="off">
                        <div class="form-icon form-icon-right">
                            <em class="icon ni ni-search"></em>
                        </div>
                        <input type="submit" class="btn btn-sm btn-info d-none" name="submit_search" value="Filter">
                        <input type="submit" class="btn btn-sm btn-secondary d-none" name="reset_search" value="Reset">
                    </div>
                </div>
            </form>
        </div>

        <div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table table-tranx">
                                <thead>
                                    <tr class="tb-tnx-head">
                                        <th class="nk-tb-col" width="15%"><span>Position</span></th>
                                        <th class="nk-tb-col" width="55%"><span>Name</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Count</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if(!empty($viewAlias)){ ?>
                                    <tbody>
                                        <?php foreach($viewAlias as $data){ ?>
                                        <tr class="tb-tnx-item">
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['alias_position']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['alias_name']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['permissionCount']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                               <span><?php 
                                                    $aliasStatus = '';
                                                    if($data['alias_status'] == 'true'){
                                                        $aliasStatus.= '<span class="tb-status text-success">True</span>';
                                                    } else if($data['alias_status'] == 'false'){
                                                        $aliasStatus.= '<span class="tb-status text-danger">False</span>';
                                                    }
                                                    echo $aliasStatus; 
                                                ?></span>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li class="nk-tb-action">
                                                        <a href="<?php echo base_url(); ?>view-alias-permission/<?php echo urlEncodes($data['alias_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Alias Permission">
                                                            <em class="icon ni ni-eye-fill"></em>
                                                        </a>
                                                    </li>
                                                    <li class="nk-tb-action">
                                                        <a href="<?php echo base_url(); ?>edit-alias/<?php echo urlEncodes($data['alias_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Alias Edit">
                                                            <em class="icon ni ni-edit-fill"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                <?php } else { ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
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
            url: '<?= base_url('view-alias'); ?>',
            type: 'POST',
            data: { search_alias_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>