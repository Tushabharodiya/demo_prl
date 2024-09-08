<?php
    $isHolidayAdd = checkPermission(HRM_HOLIDAY_ALIAS, "can_add");
    $isHolidayView = checkPermission(HRM_HOLIDAY_ALIAS, "can_view");
    $isHolidayEdit = checkPermission(HRM_HOLIDAY_ALIAS, "can_edit");
    $isHolidayDelete = checkPermission(HRM_HOLIDAY_ALIAS, "can_delete");

    $sessionHolidayViewPreviousUrl = $this->session->userdata('session_holiday_view_previous_url');

    $sessionHoliday = $this->session->userdata('session_holiday');
    $sessionHolidayType = $this->session->userdata('session_holiday_type');
    $sessionHolidayStartDate = $this->session->userdata('session_holiday_start_date');
    $sessionHolidayEndDate = $this->session->userdata('session_holiday_end_date');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Holiday</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isHolidayView){ ?>
                            <p><?php echo "You have total $countHoliday holidays."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isHolidayView){ ?>
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
                                                                    <select class="form-control form-select" id="search-type" name="search_holiday_type" data-placeholder="Select a type">
                                                                        <?php $str='';
                                                                            if(!empty($sessionHolidayType == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionHolidayType == 'upcoming')){
                                                                                $str.='selected';
                                                                        } ?> <option value="upcoming"<?php echo $str; ?>>Upcoming</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionHolidayType == 'completed')){
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
                                                                            <input type="text" class="form-control date-picker" name="search_holiday_start_date" value="<?php if(!empty($sessionHolidayStartDate)){ echo $sessionHolidayStartDate; } ?>" placeholder="Enter start date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                                                            <div class="input-group-addon">TO</div>
                                                                            <input type="text" class="form-control date-picker" name="search_holiday_end_date" value="<?php if(!empty($sessionHolidayEndDate)){ echo $sessionHolidayEndDate; } ?>" placeholder="Enter end date" data-date-format="dd/mm/yyyy" autocomplete="off">
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
                                <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                        <li><a href="<?php echo base_url(); ?>view-trash-holiday" class="btn btn-white btn-outline-light"><em class="icon ni ni-trash-fill"></em><span>Trash <sup><?php echo $countHolidayTrash; ?></sup></span></a></li>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($isHolidayAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-holiday" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isHolidayView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_holiday" value="<?php if(!empty($sessionHoliday)){ echo $sessionHoliday; } ?>" placeholder="Search..." autocomplete="off">
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
        
        <?php if(!empty($this->session->userdata('session_holiday_trash_success'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_holiday_trash_success'); $this->session->unset_userdata('session_holiday_trash_success'); ?>
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
                                    <?php if($isHolidayView){ ?>
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
                                                            <?php if($isHolidayEdit){ ?>
                                                                <li class="nk-tb-action">
                                                                    <a href="<?php echo base_url(); ?>edit-holiday/<?php echo urlEncodes($data['holiday_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                        <em class="icon ni ni-edit-fill"></em>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if(!empty($this->session->userdata['user_role'])){ ?>
                                                                <?php if($this->session->userdata['user_role'] == "Super"){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a data-bs-toggle="modal" data-bs-target="#trashModal<?php echo urlEncodes($data['holiday_id']);?>" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top" title="Trash">
                                                                            <em class="icon ni ni-trash-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" tabindex="-1" id="trashModal<?php echo urlEncodes($data['holiday_id']);?>">
                                                    <div class="modal-dialog modal-dialog-top" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Trash Holiday</h5>
                                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <em class="icon ni ni-cross"></em>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to trash <?php echo $data['holiday_name'];?>?</p>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <span class="sub-text"><a href="<?php echo base_url(); ?>trash-holiday/<?php echo urlEncodes($data['holiday_id']); ?>" class="btn btn-sm btn-warning submitBtn">Trash</a></span>
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
            <?php if($isHolidayView){ ?>
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
            url: '<?= base_url('view-holiday'); ?>',
            type: 'POST',
            data: { search_holiday_type: selectedType },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>