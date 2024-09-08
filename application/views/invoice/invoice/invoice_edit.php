<?php 
    $sessionInvoiceViewPreviousUrl = $this->session->userdata('session_invoice_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Invoice</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Invoice</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionInvoiceViewPreviousUrl)){ echo $sessionInvoiceViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_number">Invoice Number *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="invoice_number" value="<?php echo $invoiceData['invoice_number']; ?>" placeholder="Enter invoice number" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="publisher_id">Publisher Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="publisher_id" data-placeholder="Select a publisher" data-search="on" required>
                                        <?php foreach($viewPublisher as $data){
                                            $selected = $data['publisher_id'] == $publisherData['publisher_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['publisher_id'].'" '.$selected.'>'.$data['publisher_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="advertiser_id">Advertiser Name *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="advertiser_id" data-placeholder="Select a advertiser" data-search="on" required>
                                        <?php foreach($viewAdvertiser as $data){
                                            $selected = $data['advertiser_id'] == $advertiserData['advertiser_id'] ? 'selected' : '';
                                            echo '<option value="'.$data['advertiser_id'].'" '.$selected.'>'.$data['advertiser_name'].'</option>'; 
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_generate_date">Invoice Generate Date *</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" class="form-control date-picker" name="invoice_generate_date" value="<?php echo $invoiceData['invoice_generate_date']; ?>" placeholder="Enter invoice generate date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_due_date">Invoice Due Date *</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right"> 
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" class="form-control date-picker" name="invoice_due_date" value="<?php echo $invoiceData['invoice_due_date']; ?>" placeholder="Enter invoice due date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_description">Invoice Description *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="invoice_description" value="<?php echo $invoiceData['invoice_description']; ?>" placeholder="Enter invoice description" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_hsn_code">Invoice HSN Code *</label>
                                <div class="form-control-wrap">
                                    <input type="number" minlength="4" maxlength="8" class="form-control" name="invoice_hsn_code" value="<?php echo $invoiceData['invoice_hsn_code']; ?>" placeholder="Enter invoice hsn code" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_quantity">Invoice Quantity *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="invoice_quantity" value="<?php echo $invoiceData['invoice_quantity']; ?>" placeholder="Enter invoice quantity" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_price">Invoice Price *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="invoice_price" value="<?php echo $invoiceData['invoice_price']; ?>" placeholder="Enter invoice price" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_sgst">Invoice SGST *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="invoice_sgst" value="<?php echo $invoiceData['invoice_sgst']; ?>" placeholder="Enter invoice sgst" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_cgst">Invoice CGST *</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" name="invoice_cgst" value="<?php echo $invoiceData['invoice_cgst']; ?>" placeholder="Enter invoice cgst" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="invoice_status">Invoice Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="invoice_status" data-placeholder="Select a status" required>
                                        <option value="active"<?php if($invoiceData['invoice_status'] =="active"){ echo "selected"; } else { echo ""; } ?>>Active</option> 
                                        <option value="blocked"<?php if($invoiceData['invoice_status'] =="blocked"){ echo "selected"; } else { echo ""; } ?>>Blocked</option>
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