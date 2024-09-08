<?php
    $isNonDisclosureAgreementAdd = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_add");
    $isNonDisclosureAgreementView = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_view");
    $isNonDisclosureAgreementEdit = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_edit");
    $isNonDisclosureAgreementDelete = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_delete");

    $sessionNonDisclosureAgreementViewPreviousUrl = $this->session->userdata('session_non_disclosure_agreement_view_previous_url');

    $sessionNonDisclosureAgreement = $this->session->userdata('session_non_disclosure_agreement');
    $sessionNonDisclosureAgreementType = $this->session->userdata('session_non_disclosure_agreement_type');
    $sessionNonDisclosureAgreementStatus = $this->session->userdata('session_non_disclosure_agreement_status');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Non Disclosure Agreement</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isNonDisclosureAgreementView){ ?>
                            <p><?php echo "You have total $countNonDisclosureAgreement non disclosure agreement."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isNonDisclosureAgreementView){ ?>
                                    <li>
                                        <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="dropdown">
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter Non Disclosure Agreement</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Type</label>
                                                                    <select class="form-control form-select" id="search-type" name="search_non_disclosure_agreement_type" data-placeholder="Select a type">
                                                                        <?php $str='';
                                                                            if(!empty($sessionNonDisclosureAgreementType == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionNonDisclosureAgreementType == 'intern')){
                                                                                $str.='selected';
                                                                        } ?> <option value="intern"<?php echo $str; ?>>Intern</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionNonDisclosureAgreementType == 'employee')){
                                                                                $str.='selected';
                                                                        } ?> <option value="employee"<?php echo $str; ?>>Employee</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                    <select class="form-control form-select" id="search-status" name="search_non_disclosure_agreement_status" data-placeholder="Select a status">
                                                                        <?php $str='';
                                                                            if(!empty($sessionNonDisclosureAgreementStatus == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionNonDisclosureAgreementStatus == 'active')){
                                                                                $str.='selected';
                                                                        } ?> <option value="active"<?php echo $str; ?>>Active</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionNonDisclosureAgreementStatus == 'inactive')){
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
                                        <li><a href="<?php echo base_url(); ?>view-trash-non-disclosure-agreement" class="btn btn-white btn-outline-light"><em class="icon ni ni-trash-fill"></em><span>Trash <sup><?php echo $countNonDisclosureAgreementTrash; ?></sup></span></a></li>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($isNonDisclosureAgreementAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-non-disclosure-agreement" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isNonDisclosureAgreementView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_non_disclosure_agreement" value="<?php if(!empty($sessionNonDisclosureAgreement)){ echo $sessionNonDisclosureAgreement; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_non_disclosure_agreement_trash_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_non_disclosure_agreement_trash_success'); $this->session->unset_userdata('session_non_disclosure_agreement_trash_success'); ?>
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
                                            <th class="nk-tb-col" width="10%"><span>Type</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Status</span></th>
                                            <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if($isNonDisclosureAgreementView){ ?>
                                        <?php if(!empty($viewNonDisclosureAgreement)){ ?>
                                            <tbody>
                                                <?php foreach($viewNonDisclosureAgreement as $data){ ?>
                                                <tr class="tb-tnx-item">
                                                    <td class="nk-tb-col">
                                                        <span class="sub-text"><?php echo $data['employee_nda_id']; ?></span>
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
                                                            <a href="<?php echo base_url(); ?>detail-non-disclosure-agreement/<?php echo urlEncodes($data['employee_nda_id']); ?>">
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
                                                            if(!empty($data['employeeData']['employee_type'])){
                                                                $employeeType = '';
                                                                if($data['employeeData']['employee_type'] == 'intern'){
                                                                    $employeeType.= '<span class="tb-status text-primary">Intern</span>';
                                                                } else if($data['employeeData']['employee_type'] == 'employee'){
                                                                    $employeeType.= '<span class="tb-status text-info">Employee</span>';
                                                                }
                                                                echo $employeeType; 
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
                                                            <?php if($isNonDisclosureAgreementEdit){ ?>
                                                                <?php if($data['employeeData']['employee_status'] == 'active'){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a href="<?php echo base_url(); ?>edit-non-disclosure-agreement/<?php echo urlEncodes($data['employee_nda_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                            <em class="icon ni ni-edit-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a data-bs-toggle="modal" data-bs-target="#trashModal<?php echo urlEncodes($data['employee_nda_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Trash">
                                                                            <em class="icon ni ni-trash-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" tabindex="-1" id="trashModal<?php echo urlEncodes($data['employee_nda_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Trash Non Disclosure Agreement</h5>
                                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to trash <?php echo $data['employeeData']['employee_first_name']; ?>?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>trash-non-disclosure-agreement/<?php echo urlEncodes($data['employee_nda_id']); ?>" class="btn btn-sm btn-warning">Trash</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </tbody>
                                        <?php } else { ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="7">
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
                                                <td colspan="7">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">You don't have permission to show the non disclosure agreement's data</span>
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
            <?php if($isNonDisclosureAgreementView){ ?>
                <ul class="pagination justify-content-center justify-content-md-center mt-3">
                    <?php echo $this->pagination->create_links(); ?>
                </ul>
            <?php } ?>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-type').addEventListener('change', function() {
        var selectedType = this.value;
        $.ajax({
            url: '<?= base_url('view-non-disclosure-agreement'); ?>',
            type: 'POST',
            data: { search_non_disclosure_agreement_type: selectedType },
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
            url: '<?= base_url('view-non-disclosure-agreement'); ?>',
            type: 'POST',
            data: { search_non_disclosure_agreement_status: selectedStatus },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>