<?php
    $aliasID = $this->uri->segment(2);

    $sessionAliasViewPreviousUrl = $this->session->userdata('session_alias_view_previous_url');
    $sessionPermissionViewPreviousUrl = $this->session->userdata('session_permission_view_previous_url');
    
    $sessionAliasPermission = $this->session->userdata('session_alias_permission');
    $sessionAliasPermissionStatus = $this->session->userdata('session_alias_permission_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title"><em class="icon ni ni-shield-half"></em> All Alias Permission</h4>
                    <div class="nk-block-des text-soft">
                        <p><?php echo "You have total $countAliasPermission alias permissions."; ?></p>
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
                                                    <span class="sub-title dropdown-title">Filter Alias Permission</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="overline-title overline-title-alt">Status</label>
                                                                <select class="form-control form-select" id="search-status" name="search_alias_permission_status" data-id="<?php echo $aliasID; ?>"  data-placeholder="Select a status">
                                                                    <?php $str='';
                                                                        if(!empty($sessionAliasPermissionStatus == 'all')){
                                                                            $str.='selected';
                                                                    } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAliasPermissionStatus == 'true')){
                                                                            $str.='selected';
                                                                    } ?> <option value="true"<?php echo $str; ?>>True</option>
                                                                    <?php $str='';
                                                                        if(!empty($sessionAliasPermissionStatus == 'false')){
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
                                    <a href="<?php echo base_url(); ?>new-permission" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                </li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionAliasViewPreviousUrl)){ echo $sessionAliasViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                        <input type="text" class="form-control form-control-lg" name="search_alias_permission" value="<?php if(!empty($sessionAliasPermission)){ echo $sessionAliasPermission; } ?>" placeholder="Search..." autocomplete="off">
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
                                        <th class="nk-tb-col" width="15%"><span>ID</span></th>
                                        <th class="nk-tb-col" width="33%"><span>Name</span></th>
                                        <th class="nk-tb-col" width="32%"><span>Alias</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if(!empty($viewAliasPermission)){ ?>
                                    <tbody>
                                        <?php foreach($viewAliasPermission as $data){ ?>
                                        <tr class="tb-tnx-item">
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['permission_id']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['permission_name']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                                <span class="sub-text"><?php echo $data['permission_alias']; ?></span>
                                            </td>
                                            <td class="nk-tb-col">
                                               <span><?php 
                                                    $permissionStatus = '';
                                                    if($data['permission_status'] == 'true'){
                                                        $permissionStatus.= '<span class="tb-status text-success">True</span>';
                                                    } else if($data['permission_status'] == 'false'){
                                                        $permissionStatus.= '<span class="tb-status text-danger">False</span>';
                                                    }
                                                    echo $permissionStatus; 
                                                ?></span>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li class="nk-tb-action">
                                                        <a data-bs-toggle="modal" data-bs-target="#modalZoom" data-id="<?= $data['permission_id']; ?>" data-description="<?= $data['permission_description']; ?>" data-status="<?= $data['permission_status']; ?>" class="open-modal btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Quick View">
                                                            <em class="icon ni ni-focus"></em>
                                                        </a>
                                                    </li>
                                                    <li class="nk-tb-action">
                                                        <a href="<?php echo base_url(); ?>edit-permission/<?php echo urlEncodes($data['permission_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Permission Edit">
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
        var aliasID = $(this).data('id');
        $.ajax({
            url: '<?= base_url('view-alias-permission'); ?>/' + aliasID,
            type: 'POST',
            data: { search_alias_permission_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<div class="modal fade zoom" tabindex="-1" id="modalZoom">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Modal Title</h5>
                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <p id="modalContent">Modal Content</p>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text" id="modalFooter">Modal Footer Text</span>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.open-modal').click(function(){
            var permissionId = $(this).data('id');
            var permissionDescription = $(this).data('description');
            var permissionStatus = $(this).data('status');

            $('#modalTitle').text(permissionId);
            $('#modalContent').text(permissionDescription);
            $('#modalFooter').text(permissionStatus);

            $('#modalZoom').modal('show');
        });
    });
</script>