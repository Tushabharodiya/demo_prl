<?php
    $isAppraisalCertificateAdd = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_add");
    $isAppraisalCertificateView = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_view");
    $isAppraisalCertificateEmailEdit = checkPermission(HRM_APPRAISAL_CERTIFICATE_EMAIL_ALIAS, "can_edit");
    $isAppraisalCertificateEdit = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_edit");
    $isAppraisalCertificateDelete = checkPermission(HRM_APPRAISAL_CERTIFICATE_ALIAS, "can_delete");
    
    $sessionAppraisalCertificateViewPreviousUrl = $this->session->userdata('session_appraisal_certificate_view_previous_url');

    $sessionAppraisalCertificate = $this->session->userdata('session_appraisal_certificate');
    $sessionAppraisalCertificateEmail = $this->session->userdata('session_appraisal_certificate_email');
    $sessionAppraisalCertificateStatus = $this->session->userdata('session_appraisal_certificate_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Appraisal Certificate</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isAppraisalCertificateView){ ?>
                            <p><?php echo "You have total $countAppraisalCertificate appraisal certificates."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isAppraisalCertificateView){ ?>
                                    <li>
                                        <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="dropdown">
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter Appraisal Certificate</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Email</label>
                                                                    <select class="form-control form-select" id="search-email" name="search_appraisal_certificate_email" data-placeholder="Select a email">
                                                                        <?php $str='';
                                                                            if(!empty($sessionAppraisalCertificateEmail == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAppraisalCertificateEmail == 'pending')){
                                                                                $str.='selected';
                                                                        } ?> <option value="pending"<?php echo $str; ?>>Pending</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAppraisalCertificateEmail == 'sending')){
                                                                                $str.='selected';
                                                                        } ?> <option value="sending"<?php echo $str; ?>>Sending</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                    <select class="form-control form-select" id="search-status" name="search_appraisal_certificate_status" data-placeholder="Select a status">
                                                                        <?php $str='';
                                                                            if(!empty($sessionAppraisalCertificateStatus == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAppraisalCertificateStatus == 'active')){
                                                                                $str.='selected';
                                                                        } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionAppraisalCertificateStatus == 'inactive')){
                                                                                $str.='selected';
                                                                        } ?> <option value="inactive"<?php echo $str; ?>>Inactive</option>
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
                                        <li><a href="<?php echo base_url(); ?>view-trash-appraisal-certificate" class="btn btn-white btn-outline-light"><em class="icon ni ni-trash-fill"></em><span>Trash <sup><?php echo $countAppraisalCertificateTrash; ?></sup></span></a></li>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($isAppraisalCertificateAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-appraisal-certificate" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isAppraisalCertificateView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_appraisal_certificate" value="<?php if(!empty($sessionAppraisalCertificate)){ echo $sessionAppraisalCertificate; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_appraisal_certificate_trash_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_appraisal_certificate_trash_success'); $this->session->unset_userdata('session_appraisal_certificate_trash_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_appraisal_certificate_email_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_appraisal_certificate_email_success'); $this->session->unset_userdata('session_appraisal_certificate_email_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_appraisal_certificate_email_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_appraisal_certificate_email_error'); $this->session->unset_userdata('session_appraisal_certificate_email_error'); ?>
            </div>
        <?php } ?>

        <div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner p-0">
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="table-responsive">
                                <table class="table table-tranx">
                                    <thead>
                                        <tr class="tb-tnx-head">
                                            <th class="nk-tb-col" width="10%"><span>ID</span></th>
                                            <th class="nk-tb-col" width="30%"><span>Employee</span></th>
                                            <th class="nk-tb-col" width="18%"><span>Department</span></th>
                                            <th class="nk-tb-col" width="12%"><span>Create Date</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Is Email</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                            <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if($isAppraisalCertificateView){ ?>
                                        <?php if(!empty($viewAppraisalCertificate)){ ?>
                                            <tbody>
                                                <?php foreach($viewAppraisalCertificate as $data){ ?>
                                                <tr class="tb-tnx-item">
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['appraisal_certificate_id']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <?php if(!empty($data['employeeData']['employee_photo'] && $data['employeeData']['employee_photo'] != "Unknown")){ ?>
                                                                <div class="user-avatar bg-light">
                                                                    <a class="gallery-image popup-image" href="<?php echo base_url();?>uploads/hrm/employee_photo/<?php echo $data['employeeData']['employee_photo']; ?>">
                                                                        <img src="<?php echo base_url();?>uploads/hrm/employee_photo/<?php echo $data['employeeData']['employee_photo']; ?>" class="rounded-circle" height="40" width="40">
                                                                    </a>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="user-avatar bg-light">
                                                                    <em class="icon ni ni-user-alt-fill"></em>
                                                                </div>
                                                            <?php } ?>
                                                            <a href="<?php echo base_url(); ?>detail-appraisal-certificate/<?php echo urlEncodes($data['appraisal_certificate_id']); ?>">
                                                                <div class="user-info ms-3">
                                                                    <span class="tb-lead"><?php echo $data['employeeData']['employee_first_name']; ?> <?php echo $data['employeeData']['employee_middle_name']; ?> <?php echo $data['employeeData']['employee_last_name']; ?></span>
                                                                    <span><?php echo $data['employeeData']['employee_email']; ?></span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['departmentData']['department_name']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['create_date']; ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?php 
                                                            if(!empty($data['is_email'])){
                                                                $isEmail = '';
                                                                if($data['is_email'] == 'pending'){
                                                                    $isEmail.= '<em class="icon text-warning ni ni-alarm-alt"></em><span class="tb-status text-warning">Pending</span>';
                                                                } else if($data['is_email'] == 'sending'){
                                                                    $isEmail.= '<em class="icon text-success ni ni-check-circle"></em><span class="tb-status text-success">Sending</span>';
                                                                }
                                                                echo $isEmail; 
                                                            } else {
                                                                echo "-";
                                                            }
                                                        ?></span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span><?php 
                                                            $employeeStatus = '';
                                                            if($data['employeeData']['employee_status'] == 'draft'){
                                                                $employeeStatus.= '<span class="tb-status text-primary">Draft</span>';
                                                            } else if($data['employeeData']['employee_status'] == 'active'){
                                                                $employeeStatus.= '<span class="tb-status text-success">Active</span>';
                                                            } else if($data['employeeData']['employee_status'] == 'inactive'){
                                                                $employeeStatus.= '<span class="tb-status text-danger">Inactive</span>';
                                                            }
                                                            echo $employeeStatus; 
                                                        ?></span>
                                                    </td>
                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <?php if($isAppraisalCertificateEmailEdit){ ?>
                                                                <?php if($data['employeeData']['employee_status'] == 'active'){ ?>
                                                                    <?php if($data['is_email'] == 'pending'){ ?>
                                                                        <li class="nk-tb-action">
                                                                            <a data-bs-toggle="modal" data-bs-target="#emailModal<?php echo urlEncodes($data['appraisal_certificate_id']);?>" class="btn btn-trigger btn-icon text-warning" data-toggle="tooltip" data-placement="top" title="Send Email">
                                                                                <em class="icon ni ni-mail-fill"></em>
                                                                            </a>
                                                                        </li>
                                                                    <?php } else { ?>
                                                                        <li class="nk-tb-action">
                                                                            <a data-bs-toggle="modal" data-bs-target="#emailModal<?php echo urlEncodes($data['appraisal_certificate_id']);?>" class="btn btn-trigger btn-icon text-success" data-toggle="tooltip" data-placement="top" title="Send Email">
                                                                                <em class="icon ni ni-mail-fill"></em>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <?php if($isAppraisalCertificateEdit){ ?>
                                                                <?php if($data['employeeData']['employee_status'] == 'active'){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a href="<?php echo base_url(); ?>edit-appraisal-certificate/<?php echo urlEncodes($data['appraisal_certificate_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                            <em class="icon ni ni-edit-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a data-bs-toggle="modal" data-bs-target="#trashModal<?php echo urlEncodes($data['appraisal_certificate_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Trash">
                                                                            <em class="icon ni ni-trash-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" tabindex="-1" id="emailModal<?php echo urlEncodes($data['appraisal_certificate_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Email Appraisal Certificate</h5>
                                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to send email <?php echo $data['employeeData']['employee_first_name'];?>?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>email-appraisal-certificate/<?php echo urlEncodes($data['appraisal_certificate_id']); ?>" class="btn btn-sm btn-success submitBtn">Send</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" tabindex="-1" id="trashModal<?php echo urlEncodes($data['appraisal_certificate_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Trash Appraisal Certificate</h5>
                                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to trash <?php echo $data['employeeData']['employee_first_name']; ?>?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>trash-appraisal-certificate/<?php echo urlEncodes($data['appraisal_certificate_id']); ?>" class="btn btn-sm btn-warning submitBtn">Trash</a></span>
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
                                                        <span class="sub-text">You don't have permission to show the appraisal certificate's data</span>
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
            </div>
            <?php if($isAppraisalCertificateView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-email').addEventListener('change', function() {
        var selectedEmail = this.value;
        $.ajax({
            url: '<?= base_url('view-appraisal-certificate'); ?>',
            type: 'POST',
            data: { search_appraisal_certificate_email: selectedEmail },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>

<script>
    document.getElementById('search-status').addEventListener('change', function() {
        var selectedStatus = this.value;
        $.ajax({
            url: '<?= base_url('view-appraisal-certificate'); ?>',
            type: 'POST',
            data: { search_appraisal_certificate_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>