<?php
    $isReportingEmployeeAdd = checkPermission(HRM_REPORTING_EMPLOYEE_ALIAS, "can_add");
    $isReportingEmployeeView = checkPermission(HRM_REPORTING_EMPLOYEE_ALIAS, "can_view");
    $isReportingEmployeeEdit = checkPermission(HRM_REPORTING_EMPLOYEE_ALIAS, "can_edit");
    
    $sessionReportingEmployeeViewPreviousUrl = $this->session->userdata('session_reporting_employee_view_previous_url');

    $sessionReportingEmployee = $this->session->userdata('session_reporting_employee');
    $sessionReportingEmployeeType = $this->session->userdata('session_reporting_employee_type');
    $sessionReportingEmployeeReportingStartDate = $this->session->userdata('session_reporting_employee_reporting_start_date');
    $sessionReportingEmployeeReportingEndDate = $this->session->userdata('session_reporting_employee_reporting_end_date');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">

        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title page-title">Reporting</h4>
                    <div class="nk-block-des text-soft">
                        <?php if($isReportingEmployeeView){ ?>
                            <p><?php echo "You have total $countReporting reportings."; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <?php if($isReportingEmployeeView){ ?>
                                    <li>
                                        <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                            <div class="dropdown">
                                                <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered By</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter Reporting</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Type</label>
                                                                    <select class="form-control form-select" id="search-type" name="search_reporting_employee_type" data-placeholder="Select a type">
                                                                        <?php $str='';
                                                                            if(!empty($sessionReportingEmployeeType == 'all')){
                                                                                $str.='selected';
                                                                        } ?> <option value="all"<?php echo $str; ?>>All</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionReportingEmployeeType == 'inprogress')){
                                                                                $str.='selected';
                                                                        } ?> <option value="inprogress"<?php echo $str; ?>>Inprogress</option>
                                                                        <?php $str='';
                                                                            if(!empty($sessionReportingEmployeeType == 'completed')){
                                                                                $str.='selected';
                                                                        } ?> <option value="completed"<?php echo $str; ?>>Completed</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Reporting From Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="input-daterange date-picker-range input-group">
                                                                            <input type="text" class="form-control date-picker" name="search_reporting_employee_reporting_start_date" value="<?php if(!empty($sessionReportingEmployeeReportingStartDate)){ echo $sessionReportingEmployeeReportingStartDate; } ?>" placeholder="Enter start date" data-date-format="dd/mm/yyyy" autocomplete="off">
                                                                            <div class="input-group-addon">TO</div>
                                                                            <input type="text" class="form-control date-picker" name="search_reporting_employee_reporting_end_date" value="<?php if(!empty($sessionReportingEmployeeReportingEndDate)){ echo $sessionReportingEmployeeReportingEndDate; } ?>" placeholder="Enter end date" data-date-format="dd/mm/yyyy" autocomplete="off">
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
                                <?php if($isReportingEmployeeAdd){ ?>
                                    <li class="nk-block-tools-opt d-block d-sm-block">
                                        <a href="<?php echo base_url(); ?>new-employee-reporting" class="btn btn-primary"><em class="icon ni ni-plus"></em></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($isReportingEmployeeView){ ?>
            <div class="nk-search-box mt-0">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg" name="search_reporting_employee" value="<?php if(!empty($sessionReportingEmployee)){ echo $sessionReportingEmployee; } ?>" placeholder="Search..." autocomplete="off">
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
                                            <th class="nk-tb-col" width="20%"><span>Project</span></th>
                                            <th class="nk-tb-col" width="30%"><span>Task</span></th>
                                            <th class="nk-tb-col" width="10%"><span>Date</span></th>
                                            <th class="nk-tb-col" width="18%"><span>Progress</span></th>
                                            <th class="nk-tb-col" width="7%"><span>Type</span></th>
                                            <th class="nk-tb-col text-end" width="5%"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <?php if($isReportingEmployeeView){ ?>
                                        <?php if(!empty($viewReporting)){ ?>
                                            <tbody>
                                                <?php foreach($viewReporting as $data){ ?>
                                                    <tr class="tb-tnx-item">
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['reporting_id']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="tb-lead"><?php  
                                                                echo str_replace( 
                                                                    array('[', ']', '{', '}', '"value":', '"', ","), 
                                                                    array(" ", " ", " ", " ", " ", " ", "<br>"), 
                                                                    $data['reporting_project_name']
                                                                ); 
                                                            ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php 
                                                                $reportingTask = strip_tags($data['reporting_task']);
                                                                if(strlen($reportingTask) > 55){
                                                                    echo substr($reportingTask, 0, 55);
                                                                } else {
                                                                    echo $reportingTask;
                                                                }
                                                            ?></span>
                                                            <?php if(strlen($reportingTask) > 55){ ?>
                                                                <a data-bs-toggle="modal" data-bs-target="#taskModal<?php echo $data['reporting_id'];?>" class="sub-text text-primary">Read More</a>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span class="sub-text"><?php echo $data['reporting_date']; ?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <div class="project-list-progress">
                                                                <div class="progress progress-pill progress-md bg-light">
                                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" data-progress="<?php echo $data['reporting_progress'];?>" style="width: <?php echo $data['reporting_progress'];?>%;"></div>
                                                                </div>
                                                                <div class="project-progress-percent"><?php echo $data['reporting_progress'];?>%</div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <span><?php 
                                                                if(!empty($data['reporting_type'])){
                                                                    $reportingType = '';
                                                                    if($data['reporting_type'] == 'inprogress'){
                                                                        $reportingType.= '<span class="badge badge-dim bg-warning"><em class="icon ni ni-alert-circle"></em><span>Inprogress</span></span>';
                                                                    } else if($data['reporting_type'] == 'completed'){
                                                                        $reportingType.= '<span class="badge badge-dim bg-success"><em class="icon ni ni-check-circle"></em><span>Completed</span></span>';
                                                                    } 
                                                                    echo $reportingType; 
                                                                } else {
                                                                    echo "-";
                                                                }
                                                            ?></span>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-1">
                                                                <?php if($isReportingEmployeeEdit){ ?>
                                                                    <li class="nk-tb-action">
                                                                        <a href="<?php echo base_url(); ?>edit-employee-reporting/<?php echo urlEncodes($data['reporting_id']); ?>" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                            <em class="icon ni ni-edit-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade zoom" tabindex="-1" id="taskModal<?php echo $data['reporting_id'];?>">
                                                        <div class="modal-dialog modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><?php echo $data['reporting_id'];?></h5>
                                                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                        <em class="icon ni ni-cross"></em>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="lists"><p><?php echo $data['reporting_task'];?></p></div>
                                                                </div>
                                                                <div class="modal-footer bg-light">
                                                                    <span class="sub-text"><?php echo $data['employeeData']['employee_first_name']; ?> <?php echo $data['employeeData']['employee_middle_name']; ?> <?php echo $data['employeeData']['employee_last_name']; ?></span>
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
                                                        <span class="sub-text">You don't have permission to show the reporting's data</span>
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
            <?php if($isReportingEmployeeView){ ?>
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
            url: '<?= base_url('view-employee-reporting'); ?>',
            type: 'POST',
            data: { search_reporting_employee_type: selectedType },
            success: function() {
                window.location.href=window.location.href;
            }
        });
    });
</script>