<?php
    $sessionHolidayViewPreviousUrl = $this->session->userdata('session_holiday_view_previous_url');
    $sessionHolidayTrashViewPreviousUrl = $this->session->userdata('session_holiday_trash_view_previous_url');

    $sessionHolidayTrash = $this->session->userdata('session_holiday_trash');
    $sessionHolidayTrashType = $this->session->userdata('session_holiday_trash_type');
    $sessionHolidayTrashStartDate = $this->session->userdata('session_holiday_trash_start_date');
    $sessionHolidayTrashEndDate = $this->session->userdata('session_holiday_trash_end_date');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Holiday</h4>
                    <div class="nk-block-des text-soft">
                        <?php if(!empty($this->session->userdata['user_role'])){ ?>
                            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                <p><?php echo "You have total $countHoliday holidays."; ?></p>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                        <li>
                                            <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                <div class="dropdown">
                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                    <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                        <div class="dropdown-head">
                                                            <span class="sub-title dropdown-title">Filter Holiday</span>
                                                        </div>
                                                        <div class="dropdown-body dropdown-body-rg">
                                                            <div class="row gx-6 gy-3">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">Type</label>
                                                                        <select class="form-control form-select" id="search-type" name="search_holiday_trash_type" data-placeholder="Select a type">
                                                                            <?php $str='';
                                                                                if(!empty($sessionHolidayTrashType == 'all')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionHolidayTrashType == 'upcoming')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="upcoming"<?php echo $str; ?>>Upcoming</option>
                                                                            <?php $str='';
                                                                                if(!empty($sessionHolidayTrashType == 'completed')){
                                                                                    $str.='selected';
                                                                            } ?> <option value="completed"<?php echo $str; ?>>Completed</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">Holiday Date</label>
                                                                        <div class="form-control-wrap">
                                                                            <div class="input-daterange date-picker-range input-group">
                                                                                <input type="text" class="form-control date-picker" name="search_holiday_trash_start_date" value="<?php if(!empty($sessionHolidayTrashStartDate)){ echo $sessionHolidayTrashStartDate; } ?>" placeholder="Enter start date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                                                                <div class="input-group-addon">TO</div>
                                                                                <input type="text" class="form-control date-picker" name="search_holiday_trash_end_date" value="<?php if(!empty($sessionHolidayTrashEndDate)){ echo $sessionHolidayTrashEndDate; } ?>" placeholder="Enter end date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-foot between">
                                                            <input type="submit" class="btn btn-sm btn-dim btn-secondary" name="reset_filter" value="Reset Filter">
                                                            <input type="submit" class="btn btn-sm btn-dim btn-info" name="submit_filter" value="Submit Filter">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                                <li><a href="<?php if(!empty($sessionHolidayViewPreviousUrl)){ echo $sessionHolidayViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if(!empty($this->session->userdata['user_role'])){ ?>
            <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                <div class="nk-search-box mt-0">
                    <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-lg" name="search_holiday_trash" value="<?php if(!empty($sessionHolidayTrash)){ echo $sessionHolidayTrash; } ?>" placeholder="Search..." autocomplete="off">
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
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_holiday_restore_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_holiday_restore_success'); $this->session->unset_userdata('session_holiday_restore_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_holiday_delete_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_holiday_delete_success'); $this->session->unset_userdata('session_holiday_delete_success'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_holiday_delete_error'))){ ?>
            <div class="alert alert-danger alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_holiday_delete_error'); $this->session->unset_userdata('session_holiday_delete_error'); ?>
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
                                            <th class="nk-tb-col" width="50%"><span>Name</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Date</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Day</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Type</span></th>
                                            <th class="nk-tb-col text-end" width="10%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                        <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                            <?php if(!empty($viewHoliday)){ ?>
                                                <tbody>
                                                    <?php foreach($viewHoliday as $data){ ?>
                                                    <tr class="tb-tnx-item">
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['holiday_id']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['holiday_name']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['holiday_date']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['holiday_day']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span><?php 
                                                                if(!empty($data['holiday_type'])){
                                                                    $holidayType = '';
                                                                    if($data['holiday_type'] == 'upcoming'){
                                                                        $holidayType.= '<span class="badge badge-dim bg-info"><em class="icon ni ni-alert-circle"></em><span>Upcoming</span></span>';
                                                                    } else if($data['holiday_type'] == 'completed'){
                                                                        $holidayType.= '<span class="badge badge-dim bg-success"><em class="icon ni ni-check-circle"></em><span>Completed</span></span>';
                                                                    }
                                                                    echo $holidayType; 
                                                                } else {
                                                                    echo "-";
                                                                }
                                                            ?></span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                        <li class="nk-tb-action">
                                                                            <a data-bs-toggle="modal" data-bs-target="#restoreModal<?php echo urlEncodes($data['holiday_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Restore">
                                                                                <em class="icon ni ni-undo"></em>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                        <li class="nk-tb-action">
                                                                            <a data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo urlEncodes($data['holiday_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                                <em class="icon ni ni-trash-fill"></em>
                                                                            </a>
                                                                        </li>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" tabindex="-1" id="restoreModal<?php echo urlEncodes($data['holiday_id']);?>">
                                                        <div class="modal-dialog modal-dialog-top" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Restore Holiday</h5>
                                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <em class="icon ni ni-cross"></em>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to restore <?php echo $data['holiday_name'];?>?</p>
                                                                </div>
                                                                <div class="modal-footer bg-light">
                                                                    <span class="sub-text"><a href="<?php echo base_url(); ?>restore-holiday/<?php echo urlEncodes($data['holiday_id']); ?>" class="btn btn-sm btn-primary submitBtn">Restore</a></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" tabindex="-1" id="deleteModal<?php echo urlEncodes($data['holiday_id']);?>">
                                                        <div class="modal-dialog modal-dialog-top" role="document">
                                                            <div class="modal-content">
                                                                <form action="<?php echo base_url(); ?>delete-holiday/<?php echo urlEncodes($data['holiday_id']); ?>" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Delete Holiday</h5>
                                                                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <em class="icon ni ni-cross"></em>
                                                                        </a>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row g-gs">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <div class="form-label-group">
                                                                                        <label class="form-label" for="password">Are you sure you want to permanently delete <?php echo $data['holiday_name'];?>?</label>
                                                                                    </div>
                                                                                    <div class="form-control-wrap">
                                                                                        <a tabindex="-1" href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-icon form-icon-right passcode-switch" data-target="password<?php echo $data['holiday_id'];?>">
                                                                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                                        </a>
                                                                                        <input autocomplete="new-password" type="password" class="form-control" id="password<?php echo $data['holiday_id'];?>" name="password" placeholder="Enter admin password" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer bg-light">
                                                                        <span class="sub-text"><input type="submit" class="btn btn-sm btn-danger submitBtn" name="submit" value="Delete"></span>
                                                                    </div>
                                                                </form>
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
                                                            <span class="sub-text">You don't have permission to show the holiday's data</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8">
                                                    <div class="nk-block-content text-center p-3">
                                                        <span class="sub-text">You don't have permission to show the holiday's data</span>
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
            <?php if(!empty($this->session->userdata['user_role'])){ ?>
                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                    <ul class="pagination justify-content-center justify-content-md-center mt-3">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                <?php } ?>
            <?php } ?>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('search-type').addEventListener('change', function() {
        var selectedType = this.value;
        $.ajax({
            url: '<?= base_url('view-trash-holiday'); ?>',
            type: 'POST',
            data: { search_holiday_trash_type: selectedType },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>