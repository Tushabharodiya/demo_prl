<?php
    $isInvoiceAdd = checkPermission(INVOICE_ALIAS, "can_add");
    $isInvoiceView = checkPermission(INVOICE_ALIAS, "can_view");
    $isInvoiceEdit = checkPermission(INVOICE_ALIAS, "can_edit");
    $isInvoiceDelete = checkPermission(INVOICE_ALIAS, "can_delete");

    $sessionInvoiceViewPreviousUrl = $this->session->userdata('session_invoice_view_previous_url');

    $sessionInvoice = $this->session->userdata('session_invoice');
    $sessionInvoiceStatus = $this->session->userdata('session_invoice_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Invoice</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isInvoiceView){ ?>
                            <p><?php echo "You have total $countInvoice invoices."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isInvoiceView){ ?>
                                    <li>
                                        <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="dropdown">
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter Invoice</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                    <select class="form-control form-select" id="search-status" name="search_invoice_status" data-placeholder="Select a status">
                                                                        <?php $str='';
                                                                            if(!empty($sessionInvoiceStatus == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionInvoiceStatus == 'active')){
                                                                                $str.='selected';
                                                                        } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionInvoiceStatus == 'blocked')){
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
                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                        <li><a href="<?php echo base_url(); ?>view-trash-invoice" class="btn btn-white btn-outline-light"><em class="icon ni ni-trash-fill"></em><span>Trash <sup><?php echo $countInvoiceTrash; ?></sup></span></a></li>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($isInvoiceAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-invoice" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isInvoiceView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_invoice" value="<?php if(!empty($sessionInvoice)){ echo $sessionInvoice; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_invoice_trash_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <p><?php echo $this->session->userdata('session_invoice_trash_success'); $this->session->unset_userdata('session_invoice_trash_success'); ?></p>
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
                                        <th class="nk-tb-col" width="30%"><span>Bill For</span></th>
                                        <th class="nk-tb-col" width="15%"><span>Generate Date</span></th>
                                        <th class="nk-tb-col" width="15%"><span>Due Date</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Price</span></th>
                                        <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                        <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                    </tr>
                                </thead>
                                <?php if($isInvoiceView){ ?>
                                    <?php if(!empty($viewInvoice)){ ?>
                                        <tbody>
                                            <?php foreach($viewInvoice as $data){ ?>
                                            <tr class="tb-tnx-item">
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><a href="<?php echo base_url(); ?>detail-invoice/<?php echo urlEncodes($data['invoice_id']); ?>"><?php echo $data['invoice_id']; ?></a></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php 
                                                        $advertiserName = $data['advertiserData']['advertiser_name'];
                                                        if(strlen($advertiserName) > 40){
                                                            echo substr($advertiserName, 0, 40);
                                                        } else {
                                                            echo $advertiserName;
                                                        }
                                                    ?></span>
                                                    <?php if(strlen($advertiserName) > 40){ ?>
                                                        <a data-bs-toggle="modal" data-bs-target="#modalNameZoom<?php echo $data['invoice_id'];?>" class="sub-text text-primary">Read More</a>
                                                    <?php } ?>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['invoice_generate_date']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['invoice_due_date']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span class="sub-text"><?php echo $data['invoice_price']; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                   <span><?php 
                                                        $invoiceStatus = '';
                                                        if($data['invoice_status'] == 'active'){
                                                            $invoiceStatus.= '<span class="tb-status text-success">Active</span>';
                                                        } else if($data['invoice_status'] == 'blocked'){
                                                            $invoiceStatus.= '<span class="tb-status text-danger">Blocked</span>';
                                                        } 
                                                        echo $invoiceStatus; 
                                                    ?></span>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <?php if($isInvoiceView){ ?>
                                                            <li class="nk-tb-action">
                                                                <a href="<?php echo base_url(); ?>detail-invoice/<?php echo urlEncodes($data['invoice_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                                    <em class="icon ni ni-report-profit"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if($isInvoiceEdit){ ?>
                                                            <li class="nk-tb-action">
                                                                <a href="<?php echo base_url(); ?>edit-invoice/<?php echo urlEncodes($data['invoice_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                    <em class="icon ni ni-edit-fill"></em>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a data-bs-toggle="modal" data-bs-target="#trashModal<?php echo urlEncodes($data['invoice_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Trash">
                                                                        <em class="icon ni ni-trash-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <div class="modal fade zoom" tabindex="-1" id="modalNameZoom<?php echo $data['invoice_id'];?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $data['invoice_id'];?></h5>
                                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><?php echo $data['advertiserData']['advertiser_name'];?></p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><?php echo $data['invoice_status'];?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" tabindex="-1" id="trashModal<?php echo urlEncodes($data['invoice_id']);?>">
                                                <div class="modal-dialog modal-dialog-top" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Trash Invoice</h5>
                                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <em class="icon ni ni-cross"></em>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to trash <?php echo $data['invoice_number'];?>?</p>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <span class="sub-text"><a href="<?php echo base_url(); ?>trash-invoice/<?php echo urlEncodes($data['invoice_id']); ?>" class="btn btn-sm btn-warning submitBtn">Trash</a></span>
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
                                                    <span class="sub-text">You don't have permission to show the invoice's data</span>
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
            <?php if($isInvoiceView){ ?>
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
            url: '<?= base_url('view-invoice'); ?>',
            type: 'POST',
            data: { search_invoice_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>