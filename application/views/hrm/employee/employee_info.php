<?php
    $isEmployeePhotoEdit = checkPermission(HRM_EMPLOYEE_PHOTO_ALIAS, "can_edit");
    $isEmployeeReviewEdit = checkPermission(HRM_EMPLOYEE_REVIEW_ALIAS, "can_edit");
    
    $isHrView = checkPermission(HRM_EMPLOYEE_HR_REVIEW_ALIAS, "can_view");
    $isHrEdit = checkPermission(HRM_EMPLOYEE_HR_REVIEW_ALIAS, "can_edit");
    $isAdminView = checkPermission(HRM_EMPLOYEE_ADMIN_REVIEW_ALIAS, "can_view");
    $isAdminEdit = checkPermission(HRM_EMPLOYEE_ADMIN_REVIEW_ALIAS, "can_edit");
    $isTechnicalView = checkPermission(HRM_EMPLOYEE_TECHNICAL_REVIEW_ALIAS, "can_view");
    $isTechnicalEdit = checkPermission(HRM_EMPLOYEE_TECHNICAL_REVIEW_ALIAS, "can_edit");
    $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
?>
<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Employee</h4>
                    <div class="nk-block-des text-soft">
                        <p>Information Employee</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionEmployeeViewPreviousUrl)){ echo $sessionEmployeeViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <?php if(!empty($this->session->userdata('session_employee_info_employee_photo'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_info_employee_photo'); $this->session->unset_userdata('session_employee_info_employee_photo'); ?>
            </div>
        <?php } ?>
        
        <?php if(!empty($this->session->userdata('session_employee_info_employee_review'))){ ?>
            <div class="alert alert-success alert-icon">
                <em class="icon ni ni-alert-circle"></em> 
                <?php echo $this->session->userdata('session_employee_info_employee_review'); $this->session->unset_userdata('session_employee_info_employee_review'); ?>
            </div>
        <?php } ?>
        
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-md-4">
                    <div class="card card-bordered h-100">
                        <?php foreach($infoEmployee as $data){ ?>
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="team">
                                    <div class="user-card user-card-s2">
                                        <?php if(!empty($data['employee_photo'] && $data['employee_photo'] != "Unknown")){ ?>
                                            <div class="user-avatar lg bg-light">
                                                <a class="gallery-image popup-image" href="<?php echo base_url(); ?>uploads/hrm/employee_photo/<?php echo $data['employee_photo']; ?>">
                                                    <img src="<?php echo base_url(); ?>uploads/hrm/employee_photo/<?php echo $data['employee_photo']; ?>" class="rounded-circle" height="80" width="80">
                                                </a>
                                            </div>
                                        <?php } else if(!empty($data['employee_photo'] && $data['employee_photo'] == "Unknown")){ ?>
                                            <div class="user-avatar lg bg-light">
                                                <em class="icon ni ni-user-alt-fill"></em>
                                            </div>
                                        <?php } else { ?>
                                            <?php $color = assignFillColor($data['employee_id']); ?>
                                            <div class="user-avatar lg" style="background-color: <?php echo $color; ?>">
                                                <span><?php echo get_first_letters($data['employee_first_name']); echo get_first_letters($data['employee_last_name']); ?></span>
                                            </div>
                                        <?php } ?>
                                        <div class="user-info">
                                            <div class="badge bg-light rounded-pill ucap">Serial No : <?php echo $data['employee_serial_no']; ?></div>
                                            <h6><?php echo $data['employee_first_name']; ?> <?php echo $data['employee_middle_name']; ?> <?php echo $data['employee_last_name']; ?></h6>
                                            <span class="sub-text"><?php echo $data['departmentData']['department_name']; ?></span>
                                        </div>
                                    </div>
                                    <?php if($isEmployeePhotoEdit or $isEmployeeReviewEdit){ ?>
                                        <?php if($data['employee_status'] == 'draft' or $data['employee_status'] == 'active'){ ?>
                                            <div class="team-view mt-3">
                                                <?php if($isEmployeePhotoEdit){ ?>
                                                    <a data-bs-toggle="modal" data-bs-target="#photoModal" class="btn btn-round btn-outline-light w-150px"><span>Edit Profile</span></a>
                                                <?php } ?>
                                                <?php if($isEmployeeReviewEdit){ ?>
                                                    <a data-bs-toggle="modal" data-bs-target="#reviewModal" class="btn btn-round btn-outline-light w-150px ms-4"><span>Edit Review</span></a>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="card-inner">
                                <h6 class="overline-title mb-2">Personal Details</h6>
                                <div class="row g-gs">
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Email ID:</span>
                                        <span><?php if(!empty($data['employee_email'])){ echo $data['employee_email']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Correspondence Address:</span>
                                        <span><?php if(!empty($data['employee_correspondence_address'])){ echo $data['employee_correspondence_address']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Permanent Address:</span>
                                        <span><?php if(!empty($data['employee_permanent_address'])){ echo $data['employee_permanent_address']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Telephone No:</span>
                                        <span><?php if(!empty($data['employee_telephone_no'])){ echo $data['employee_telephone_no']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Mobile No:</span>
                                        <span><?php if(!empty($data['employee_mobile_no'])){ echo $data['employee_mobile_no']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Birth Date:</span>
                                        <span><?php if(!empty($data['employee_birth_date'])){ echo $data['employee_birth_date']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Marital Status:</span>
                                        <span><?php if(!empty($data['employee_marital_status'])){ echo $data['employee_marital_status']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Blood Group:</span>
                                        <span><?php if(!empty($data['employee_blood_group'])){ echo $data['employee_blood_group']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Emergency Contact Name:</span>
                                        <span><?php if(!empty($data['employee_emergency_contact_name'])){ echo $data['employee_emergency_contact_name']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Emergency Contact Relation:</span>
                                        <span><?php if(!empty($data['employee_emergency_contact_relation'])){ echo $data['employee_emergency_contact_relation']; } else { echo "-"; } ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="sub-text">Employee Emergency Contact No:</span>
                                        <span><?php if(!empty($data['employee_emergency_contact_no'])){ echo $data['employee_emergency_contact_no']; } else { echo "-"; } ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="photoModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Employee Photo</h5>
                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row gy-4">
                                                <div class="col-md-12">
                                                    <div class="form-control-wrap">
                                                        <label class="form-label" for="employee_photo">Employee Photo *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="no-image" name="no-image" value="<?php echo $data['employee_photo']; ?>"<?php if($data['employee_photo'] == "Unknown"){ ?> checked <?php } ?>>
                                                                        <label class="custom-control-label" for="no-image">No Image</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="file" class="form-control" id="file-uploader-image" name="employee_photo" value="<?php echo $data['employee_photo']; ?>">
                                                        </div>
                                                        <div id="feedback-image"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-primary submitBtn" id="submit-button" name="submit_photo" value="Update">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="reviewModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Employee Review</h5>
                                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <em class="icon ni ni-cross"></em>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row gy-4">
                                                <?php if(!empty($this->session->userdata['user_role'])){ ?> 
                                                    <?php if($this->session->userdata['user_role'] == "Super"){ ?>  
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="hr_review">HR Review</label>
                                                                <div class="form-control-wrap">
                                                                    <textarea class="form-control form-control-sm" name="hr_review" placeholder="Enter hr review"><?php echo $data['hr_review']; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="admin_review">Admin Review</label>
                                                                <div class="form-control-wrap">
                                                                    <textarea class="form-control form-control-sm" name="admin_review" placeholder="Enter admin review"><?php echo $data['admin_review']; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="technical_review">Technical Review</label>
                                                                <div class="form-control-wrap">
                                                                    <textarea class="form-control form-control-sm" name="technical_review" placeholder="Enter technical review"><?php echo $data['technical_review']; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="submit" class="btn btn-primary submitBtn" name="submit_review" value="Update">
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <?php if($isHrEdit or $isHrView or $isAdminEdit or $isAdminView or $isTechnicalEdit or $isTechnicalView){ ?>
                                                            <?php if($isHrEdit){ ?>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="hr_review">HR Review</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control form-control-sm" name="hr_review" placeholder="Enter hr review"><?php echo $data['hr_review']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } else if($isHrView){ ?>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="hr_review">HR Review</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control form-control-sm" placeholder="Enter hr review" readonly><?php echo $data['hr_review']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if($isAdminEdit){ ?>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="admin_review">Admin Review</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control form-control-sm" name="admin_review" placeholder="Enter admin review"><?php echo $data['admin_review']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } else if($isAdminView){ ?>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="admin_review">Admin Review</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control form-control-sm" placeholder="Enter admin review" readonly><?php echo $data['admin_review']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if($isTechnicalEdit){ ?>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="technical_review">Technical Review</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control form-control-sm" name="technical_review" placeholder="Enter technical review"><?php echo $data['technical_review']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } else if($isTechnicalView){ ?>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="technical_review">Technical Review</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control form-control-sm" placeholder="Enter technical review" readonly><?php echo $data['technical_review']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if($isHrEdit or $isAdminEdit or $isTechnicalEdit){ ?>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <input type="submit" class="btn btn-primary submitBtn" name="submit_review" value="Update">
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                        <div class="col-md-12">
                                                            <div class="card card-bordered p-3 bg-lighter text-center">
                                                                <span class="sub-text">You don't have permission to show the review employee's data</span>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="nk-block">
                                <h6 class="lead-text mb-3">Educational Details</h6>
                                <div class="table-responsive">
                                    <table class="table-tranx nk-tb-list nk-tb-ulist border round-sm">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                                <th class="nk-tb-col"><span>Degree</span></th>
                                                <th class="nk-tb-col"><span>University/Institute</span></th>
                                                <th class="nk-tb-col"><span>Start</span></th>
                                                <th class="nk-tb-col"><span>End</span></th>
                                                <th class="nk-tb-col"><span>Pr/Grade</span></th>
                                                <th class="nk-tb-col"><span>Specialisation</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($infoEmployee as $data){ 
                                            $employeeEducationalDegree = explode('#',$data['employee_educational_degree']);
                                            $employeeEducationalUniversityInstitute = explode('#',$data['employee_educational_university_institute']);
                                            $employeeEducationalStartYear = explode('#',$data['employee_educational_start_year']);
                                            $employeeEducationalEndYear = explode('#',$data['employee_educational_end_year']);
                                            $employeeEducationalPercentageGrade = explode('#',$data['employee_educational_percentage_grade']);
                                            $employeeEducationalSpecialisation = explode('#',$data['employee_educational_specialisation']);
                                            foreach($employeeEducationalDegree as $key => $value){ ?>
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEducationalDegree[$key])){ echo $employeeEducationalDegree[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEducationalUniversityInstitute[$key])){ echo $employeeEducationalUniversityInstitute[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEducationalStartYear[$key])){ echo $employeeEducationalStartYear[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEducationalEndYear[$key])){ echo $employeeEducationalEndYear[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEducationalPercentageGrade[$key])){ echo $employeeEducationalPercentageGrade[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEducationalSpecialisation[$key])){ echo $employeeEducationalSpecialisation[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                            </tr>
                                        <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="nk-block">
                                <h6 class="lead-text mb-3">Employeement Details (Past Organization)</h6>
                                <div class="table-responsive">
                                    <table class="table-tranx nk-tb-list nk-tb-ulist border round-sm">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                                <th class="nk-tb-col"><span>S.No</span></th>
                                                <th class="nk-tb-col"><span>Organisation</span></th>
                                                <th class="nk-tb-col"><span>Designation</span></th>
                                                <th class="nk-tb-col"><span>Start</span></th>
                                                <th class="nk-tb-col"><span>End</span></th>
                                                <th class="nk-tb-col"><span>Annual CTC</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($infoEmployee as $data){ 
                                            $i = 1;
                                            $employeeEmployeementOrganisation = explode('#',$data['employee_employeement_organisation']);
                                            $employeeEmployeementDesignation = explode('#',$data['employee_employeement_designation']);
                                            $employeeEmployeementStartDate = explode('#',$data['employee_employeement_start_date']);
                                            $employeeEmployeementEndDate = explode('#',$data['employee_employeement_end_date']);
                                            $employeeEmployeementAnnualCTC = explode('#',$data['employee_employeement_annual_ctc']);
                                            foreach($employeeEmployeementOrganisation as $key => $value){ ?>
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col">
                                                    <span><?php echo $i++; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEmployeementOrganisation[$key])){ echo $employeeEmployeementOrganisation[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEmployeementDesignation[$key])){ echo $employeeEmployeementDesignation[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEmployeementStartDate[$key])){ echo $employeeEmployeementStartDate[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEmployeementEndDate[$key])){ echo $employeeEmployeementEndDate[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeEmployeementAnnualCTC[$key])){ echo $employeeEmployeementAnnualCTC[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                            </tr>
                                        <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="nk-block">
                                <h6 class="lead-text mb-3">Family Details</h6>
                                <div class="table-responsive">
                                    <table class="table-tranx nk-tb-list nk-tb-ulist border round-sm">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                                <th class="nk-tb-col"><span>S.No</span></th>
                                                <th class="nk-tb-col"><span>Name</span></th>
                                                <th class="nk-tb-col"><span>Relation</span></th>
                                                <th class="nk-tb-col"><span>Occupation</span></th>
                                                <th class="nk-tb-col"><span>Date of Birth</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($infoEmployee as $data){ 
                                            $i = 1;
                                            $employeeFamilyMemberName = explode('#',$data['employee_family_member_name']);
                                            $employeeFamilyMemberRelation = explode('#',$data['employee_family_member_relation']);
                                            $employeeFamilyMemberOccupation = explode('#',$data['employee_family_member_occupation']);
                                            $employeeFamilyMemberBirthDate = explode('#',$data['employee_family_member_birth_date']);
                                            foreach($employeeFamilyMemberName as $key => $value){ ?>
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col">
                                                    <span><?php echo $i++; ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeFamilyMemberName[$key])){ echo $employeeFamilyMemberName[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeFamilyMemberRelation[$key])){ echo $employeeFamilyMemberRelation[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeFamilyMemberOccupation[$key])){ echo $employeeFamilyMemberOccupation[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeFamilyMemberBirthDate[$key])){ echo $employeeFamilyMemberBirthDate[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                            </tr>
                                        <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="nk-block">
                                <h6 class="lead-text mb-3">Professional References</h6>
                                <div class="table-responsive">
                                    <table class="table-tranx nk-tb-list nk-tb-ulist border round-sm">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head tb-tnx-head">
                                                <th class="nk-tb-col"><span>Name</span></th>
                                                <th class="nk-tb-col"><span>Organisation</span></th>
                                                <th class="nk-tb-col"><span>Designation</span></th>
                                                <th class="nk-tb-col"><span>Contact No</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($infoEmployee as $data){ 
                                            $employeeProfessionalReferenceName = explode('#',$data['employee_professional_reference_name']);
                                            $employeeProfessionalReferenceOrganisation = explode('#',$data['employee_professional_reference_organisation']);
                                            $employeeProfessionalReferenceDesignation = explode('#',$data['employee_professional_reference_designation']);
                                            $employeeProfessionalReferenceContactNo = explode('#',$data['employee_professional_reference_contact_no']);
                                            foreach($employeeProfessionalReferenceName as $key => $value){ ?>
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeProfessionalReferenceName[$key])){ echo $employeeProfessionalReferenceName[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeProfessionalReferenceOrganisation[$key])){ echo $employeeProfessionalReferenceOrganisation[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeProfessionalReferenceDesignation[$key])){ echo $employeeProfessionalReferenceDesignation[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <span><?php if(!empty($employeeProfessionalReferenceContactNo[$key])){ echo $employeeProfessionalReferenceContactNo[$key]; } else { echo "-"; } ?></span>
                                                </td>
                                            </tr>
                                        <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="nk-block">
                                <h6 class="lead-text mb-3">Declaration</h6>
                                <div class="nk-tb-list nk-tb-ulist">
                                    <?php foreach($infoEmployee as $data){ ?>
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-50">
                                            <span>Employee Created Date :</span>
                                        </div>
                                        <div class="nk-tb-col border round-sm w-50">
                                            <span><?php if(!empty($data['employee_created_date'])){ echo $data['employee_created_date']; } else { echo "-"; } ?></span>
                                        </div>
                                    </div>
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-50">
                                            <span>Employee Place :</span>
                                        </div>
                                        <div class="nk-tb-col border round-sm w-50">
                                            <span><?php if(!empty($data['employee_place'])){ echo $data['employee_place']; } else { echo "-"; } ?></span>
                                        </div>
                                    </div>
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-50">
                                            <span>Employee Signature :</span>
                                        </div>
                                        <div class="nk-tb-col border round-sm w-50">
                                            <span><?php if(!empty($data['employee_signature'])){ echo $data['employee_signature']; } else { echo "-"; } ?></span>
                                        </div>
                                    </div>
                                    <?php }  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="nk-block">
                                <h6 class="lead-text mb-3">Review Details</h6>
                                <div class="row g-3">
                                    <div class="col-4">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="d-flex">
                                                    <div class="user-avatar bg-purple me-3">
                                                        <span><div class="icon-circle icon-circle-lg">
                                                            <?php if($data['is_employee'] == 'pending'){ ?>
                                                                <em class="icon ni ni-star"></em>
                                                            <?php } ?>
                                                            <?php if($data['is_employee'] == 'selected'){ ?>
                                                                <em class="icon ni ni-star-fill"></em>
                                                            <?php } ?>
                                                            <?php if($data['is_employee'] == 'rejected'){ ?>
                                                                <em class="icon ni ni-star-half-fill"></em>
                                                            <?php } ?>
                                                        </div></span>
                                                    </div>
                                                    <div class="fake-class">
                                                        <h6 class="mt-0 d-flex align-center"><span>HR Review</span></h6>
                                                        <p class="text-soft"><?php if(!empty($data['hr_review'])){ echo $data['hr_review']; } else { echo "-"; } ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner">
                                                <div class="d-flex">
                                                    <div class="user-avatar me-3">
                                                        <span><div class="icon-circle icon-circle-lg bg-orange">
                                                            <?php if($data['is_employee'] == 'pending'){ ?>
                                                                <em class="icon ni ni-star"></em>
                                                            <?php } ?>
                                                            <?php if($data['is_employee'] == 'selected'){ ?>
                                                                <em class="icon ni ni-star-fill"></em>
                                                            <?php } ?>
                                                            <?php if($data['is_employee'] == 'rejected'){ ?>
                                                                <em class="icon ni ni-star-half-fill"></em>
                                                            <?php } ?>
                                                        </div></span>
                                                    </div>
                                                    <div class="fake-class">
                                                        <h6 class="mt-0 d-flex align-center"><span>Admin Review</span></h6>
                                                        <p class="text-soft"><?php if(!empty($data['admin_review'])){ echo $data['admin_review']; } else { echo "-"; } ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner">
                                                <div class="d-flex">
                                                    <div class="user-avatar me-3">
                                                        <span><div class="icon-circle icon-circle-lg bg-indigo">
                                                            <?php if($data['is_employee'] == 'pending'){ ?>
                                                                <em class="icon ni ni-star"></em>
                                                            <?php } ?>
                                                            <?php if($data['is_employee'] == 'selected'){ ?>
                                                                <em class="icon ni ni-star-fill"></em>
                                                            <?php } ?>
                                                            <?php if($data['is_employee'] == 'rejected'){ ?>
                                                                <em class="icon ni ni-star-half-fill"></em>
                                                            <?php } ?>
                                                        </div></span>
                                                    </div>
                                                    <div class="fake-class">
                                                        <h6 class="mt-0 d-flex align-center"><span>Technical Review</span></h6>
                                                        <p class="text-soft"><?php if(!empty($data['technical_review'])){ echo $data['technical_review']; } else { echo "-"; } ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($data['is_employee'] == 'selected'){ ?>
                    <div class="col-md-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="nk-block">
                                    <h6 class="lead-text mb-3">Basic Details</h6>
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Is Employee :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php 
                                                    if(!empty($data['is_employee'])){
                                                        $isEmployee = '';
                                                        if($data['is_employee'] == 'pending'){
                                                            $isEmployee.= '<span class="tb-status text-warning">Pending</span>';
                                                        } else if($data['is_employee'] == 'selected'){
                                                            $isEmployee.= '<span class="tb-status text-success">Selected</span>';
                                                        } else if($data['is_employee'] == 'rejected'){
                                                            $isEmployee.= '<span class="tb-status text-danger">Rejected</span>';
                                                        }
                                                        echo $isEmployee; 
                                                    } else {
                                                        echo "-";
                                                    }
                                                ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Ref From :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_ref_from'])){ echo $data['employee_ref_from']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Joining Date :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_joining_date'])){ echo $data['employee_joining_date']; } else { echo "-"; } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Access Card No :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_access_card_no'])){ echo $data['employee_access_card_no']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Qualification :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_qualification'])){ echo $data['employee_qualification']; } else { echo "-"; } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Gender :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_gender'])){ echo $data['employee_gender']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Pan Front Image :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_pan_front_image'])){ ?>
                                                    <img src="<?php echo base_url();?>uploads/hrm/employee_pan_front_image/<?php echo $data['employee_pan_front_image']; ?>" width="100" height="100">
                                                <?php } else { ?>
                                                    <?php echo "-"; ?>
                                                <?php } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Pan Back Image :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_pan_back_image'])){ ?>
                                                    <img src="<?php echo base_url();?>uploads/hrm/employee_pan_back_image/<?php echo $data['employee_pan_back_image']; ?>" width="100" height="100">
                                                <?php } else { ?>
                                                    <?php echo "-"; ?>
                                                <?php } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Aadhar Front Image :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_aadhar_front_image'])){ ?>
                                                    <img src="<?php echo base_url();?>uploads/hrm/employee_aadhar_front_image/<?php echo $data['employee_aadhar_front_image']; ?>" width="100" height="100">
                                                <?php } else { ?>
                                                    <?php echo "-"; ?>
                                                <?php } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Aadhar Back Image :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_aadhar_back_image'])){ ?>
                                                    <img src="<?php echo base_url();?>uploads/hrm/employee_aadhar_back_image/<?php echo $data['employee_aadhar_back_image']; ?>" width="100" height="100">
                                                <?php } else { ?>
                                                    <?php echo "-"; ?>
                                                <?php } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Residential Proof Image :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_residential_proof_image'])){ ?>
                                                    <img src="<?php echo base_url();?>uploads/hrm/employee_residential_proof_image/<?php echo $data['employee_residential_proof_image']; ?>" width="100" height="100">
                                                <?php } else { ?>
                                                    <?php echo "-"; ?>
                                                <?php } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Status :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php 
                                                    if(!empty($data['employee_status'])){
                                                        $employeeStatus = '';
                                                        if($data['employee_status'] == 'draft'){
                                                            $employeeStatus.= '<span class="tb-status text-primary">Draft</span>';
                                                        } else if($data['employee_status'] == 'active'){
                                                            $employeeStatus.= '<span class="tb-status text-success">Active</span>';
                                                        } else if($data['employee_status'] == 'inactive'){
                                                            $employeeStatus.= '<span class="tb-status text-danger">Inactive</span>';
                                                        }
                                                        echo $employeeStatus; 
                                                    } else {
                                                        echo "-";
                                                    }
                                                ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($data['is_employee'] == 'rejected'){ ?>
                    <div class="col-md-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="nk-block">
                                    <h6 class="lead-text mb-3">Basic Details</h6>
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Is Employee :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php 
                                                    if(!empty($data['is_employee'])){
                                                        $isEmployee = '';
                                                        if($data['is_employee'] == 'pending'){
                                                            $isEmployee.= '<span class="tb-status text-warning">Pending</span>';
                                                        } else if($data['is_employee'] == 'selected'){
                                                            $isEmployee.= '<span class="tb-status text-success">Selected</span>';
                                                        } else if($data['is_employee'] == 'rejected'){
                                                            $isEmployee.= '<span class="tb-status text-danger">Rejected</span>';
                                                        }
                                                        echo $isEmployee; 
                                                    } else {
                                                        echo "-";
                                                    }
                                                ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Ref From :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_ref_from'])){ echo $data['employee_ref_from']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Status :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php 
                                                    if(!empty($data['employee_status'])){
                                                        $employeeStatus = '';
                                                        if($data['employee_status'] == 'draft'){
                                                            $employeeStatus.= '<span class="tb-status text-primary">Draft</span>';
                                                        } else if($data['employee_status'] == 'active'){
                                                            $employeeStatus.= '<span class="tb-status text-success">Active</span>';
                                                        } else if($data['employee_status'] == 'inactive'){
                                                            $employeeStatus.= '<span class="tb-status text-danger">Inactive</span>';
                                                        }
                                                        echo $employeeStatus; 
                                                    } else {
                                                        echo "-";
                                                    }
                                                ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($data['employee_type'] == 'intern'){ ?>
                    <div class="col-md-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="nk-block">
                                    <h6 class="lead-text mb-3">Intern Details</h6>
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Type :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php 
                                                    if(!empty($data['employee_type'])){
                                                        $employeeType = '';
                                                        if($data['employee_type'] == 'intern'){
                                                            $employeeType.= '<span class="tb-status text-primary">Intern</span>';
                                                        } else if($data['employee_type'] == 'employee'){
                                                            $employeeType.= '<span class="tb-status text-info">Employee</span>';
                                                        }
                                                        echo $employeeType; 
                                                    } else {
                                                        echo "-";
                                                    }
                                                ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Internship Month :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_internship_month'])){ echo $data['employee_internship_month']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Stipend :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_stipend'])){ echo $data['employee_stipend']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else if(!empty($data['employee_internship_month']) or !empty($data['employee_stipend'])){ ?>
                    <div class="col-md-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="nk-block">
                                    <h6 class="lead-text mb-3">Intern Details</h6>
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Internship Month :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_internship_month'])){ echo $data['employee_internship_month']; } else { echo "-"; } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Stipend :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_stipend'])){ echo $data['employee_stipend']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($data['employee_type'] == 'employee'){ ?>
                    <div class="col-md-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="nk-block">
                                    <h6 class="lead-text mb-3">Employee Details</h6>
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Type :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php 
                                                    if(!empty($data['employee_type'])){
                                                        $employeeType = '';
                                                        if($data['employee_type'] == 'intern'){
                                                            $employeeType.= '<span class="tb-status text-primary">Intern</span>';
                                                        } else if($data['employee_type'] == 'employee'){
                                                            $employeeType.= '<span class="tb-status text-info">Employee</span>';
                                                        }
                                                        echo $employeeType; 
                                                    } else {
                                                        echo "-";
                                                    }
                                                ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Contract Date :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_contract_date'])){ echo $data['employee_contract_date']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Compensation :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_compensation'])){ echo $data['employee_compensation']; } else { echo "-"; } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Salary :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_salary'])){ echo $data['employee_salary']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Bank Name :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_bank_name'])){ echo $data['employee_bank_name']; } else { echo "-"; } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Account No :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_account_no'])){ echo $data['employee_account_no']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Cheque No :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_cheque_no'])){ echo $data['employee_cheque_no']; } else { echo "-"; } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Consent Name :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_consent_name'])){ echo $data['employee_consent_name']; } else { echo "-"; } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Cheque Image :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_cheque_image'])){ ?>
                                                    <img src="<?php echo base_url();?>uploads/hrm/employee_cheque_image/<?php echo $data['employee_cheque_image']; ?>" width="100" height="100">
                                                <?php } else { ?>
                                                    <?php echo "-"; ?>
                                                <?php } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Experience Certificate Image :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_experience_certificate_image'])){ ?>
                                                    <img src="<?php echo base_url();?>uploads/hrm/employee_experience_certificate_image/<?php echo $data['employee_experience_certificate_image']; ?>" width="100" height="100">
                                                <?php } else { ?>
                                                    <?php echo "-"; ?>
                                                <?php } ?></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Relieving Letter Image :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_relieving_letter_image'])){ ?>
                                                    <img src="<?php echo base_url();?>uploads/hrm/employee_relieving_letter_image/<?php echo $data['employee_relieving_letter_image']; ?>" width="100" height="100">
                                                <?php } else { ?>
                                                    <?php echo "-"; ?>
                                                <?php } ?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col nk-tb-item nk-tb-head tb-tnx-head border round-sm w-25">
                                                <span>Employee Salary Slip Image :</span>
                                            </div>
                                            <div class="nk-tb-col border round-sm w-25">
                                                <span><?php if(!empty($data['employee_salary_slip_image'])){ ?>
                                                    <img src="<?php echo base_url();?>uploads/hrm/employee_salary_slip_image/<?php echo $data['employee_salary_slip_image']; ?>" width="100" height="100">
                                                <?php } else { ?>
                                                    <?php echo "-"; ?>
                                                <?php } ?></span>
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
        
    </div>
</div>

<script>
    const fileUploaderImage = document.getElementById('file-uploader-image');
    const feedbackImage = document.getElementById('feedback-image');
    const submitButton = document.getElementById('submit-button');

    fileUploaderImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF  or WEBP image. </span>`;
                submitButton.style.display = 'none';
                return;
            } else {
                feedbackImage.innerHTML = ` `;
                submitButton.style.display = 'block';
                return;
            } 
        }
    });
</script>