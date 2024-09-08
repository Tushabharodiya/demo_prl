<?php 
    $invoiceID = $this->uri->segment(2);
    
    $sessionInvoiceViewPreviousUrl = $this->session->userdata('session_invoice_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
    <?php foreach($detailInvoice as $data){ ?>
    
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Invoice <strong class="text-primary small"><?php echo $data['invoice_id']; ?></strong></h3>
                    <div class="nk-block-des text-soft">
                        <ul class="list-inline">
                            <li>Created At: <span class="text-base"><?php echo $data['invoice_generate_date']; ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li><a onclick="createPDF()" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionInvoiceViewPreviousUrl)){ echo $sessionInvoiceViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nk-block">
            <div class="invoice">
                <div class="invoice-wrap p-1">
                    <div id="element-to-pdf">
                        <div class="p-5">
                            <div class="invoice-brand mt-3">
                                <div class="invoice-contact">
                                    <div class="invoice-contact-info">
                                        <h5 class="title"><?php echo $data['publisherData']['publisher_name']; ?></h5>
                                        <ul class="list-plain">
                                            <li><em class="icon ni ni-map-pin-fill"></em><span><?php echo $data['publisherData']['publisher_address']; ?></span></li>
                                            <li><em class="icon ni ni-task"></em><span>GST No - <?php echo $data['publisherData']['publisher_gst_number']; ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-head mt-3">
                                <div class="invoice-contact">
                                    <span class="overline-title">Invoice To</span>
                                    <div class="invoice-contact-info">
                                        <h5 class="title"><?php echo $data['advertiserData']['advertiser_name']; ?></h5>
                                        <ul class="list-plain">
                                            <li><em class="icon ni ni-map-pin-fill"></em><span><?php echo $data['advertiserData']['advertiser_address']; ?></span></li>
                                            <li><em class="icon ni ni-task"></em><span><?php echo $data['advertiserData']['advertiser_project']; ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="invoice-desc">
                                    <h4 class="title">Invoice</h4>
                                    <ul class="list-plain">
                                        <li class="invoice-id"><span>Invoice ID</span>:<span><?php echo $data['invoice_number']; ?></span></li>
                                        <li class="invoice-date"><span>Date</span>:<span><?php echo $data['invoice_due_date']; ?></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-bills mt-3">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="w-150px">HSN Code</th>
                                                <th class="w-60">Description</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $data['invoice_hsn_code']; ?></td>
                                                <td><?php echo $data['invoice_description']; ?></td>
                                                <td><?php echo $data['invoice_price']; ?></td>
                                                <td><?php echo $data['invoice_quantity']; ?></td>
                                                <td><?php echo $data['invoice_price'] * $data['invoice_quantity']; ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2">Subtotal</td>
                                                <td><?php echo $data['invoice_price'] * $data['invoice_quantity']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2">SGST</td>
                                                <td><?php echo $data['invoice_sgst']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2">CGST</td>
                                                <td><?php echo $data['invoice_cgst']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2">Grand Total</td>
                                                <td><?php echo $data['invoice_price'] * $data['invoice_quantity'] + $data['invoice_sgst'] + $data['invoice_cgst']; ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <?php } ?>  
    </div>
</div>

<script type="text/javascript">
    function createPDF() {
        var element = document.getElementById('element-to-pdf');
        html2pdf(element, {
            padding:0,
            filename: '<?php echo $data['publisherData']['publisher_name']; ?> - Invoice',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { scale: 2,  logging: true },
            jsPDF: { unit: 'in', format: 'A4', orientation: 'L' },
            class: createPDF
        });
    };
</script>