<?php 
    $sessionHolidayViewPreviousUrl = $this->session->userdata('session_holiday_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Holiday</h4>
                    <div class="nk-block-des text-soft">
                        <p>Edit Holiday</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionHolidayViewPreviousUrl)){ echo $sessionHolidayViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="holiday_name">Holiday Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="holiday_name" value="<?php echo $holidayData['holiday_name']; ?>" placeholder="Enter holiday name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="holiday_date">Holiday Date *</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-calendar-alt"></em>
                                    </div>
                                    <input type="text" class="form-control date-picker" name="holiday_date" value="<?php echo $holidayData['holiday_date']; ?>" placeholder="Enter holiday date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="holiday_type">Holiday Type *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="holiday_type" data-placeholder="Select a type" required>
                                        <option value="upcoming"<?php if($holidayData['holiday_type'] =="upcoming"){ echo "selected"; } else { echo ""; } ?>>Upcoming</option> 
                                        <option value="completed"<?php if($holidayData['holiday_type'] =="completed"){ echo "selected"; } else { echo ""; } ?>>Completed</option>
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