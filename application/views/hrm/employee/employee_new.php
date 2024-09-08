<?php 
    $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Employee</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Employee</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionEmployeeViewPreviousUrl)){ echo $sessionEmployeeViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>

        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="nk-stepper stepper-init form-validate is-alter" id="stepper-two-factor-auth" enctype="multipart/form-data">
                    <div class="nk-stepper-content">
                        <div class="nk-stepper-steps stepper-steps">
                            <div class="nk-stepper-step">
                                <h6 class="title border-bottom mb-3 pb-2 ucap">Personal Details</h6>
                                <div class="row g-gs">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_first_name">Employee First Name *</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="employee_first_name" placeholder="Enter employee first name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_middle_name">Employee Middle Name *</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="employee_middle_name" placeholder="Enter employee middle name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_last_name">Employee Last Name *</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="employee_last_name" placeholder="Enter employee last name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="department_id">Employee Department *</label>
                                            <div class="form-control-wrap">
                                                <select class="form-control form-select js-select2" name="department_id" data-placeholder="Select a department" data-search="on" required>
                                                    <option label="empty" value=""></option>
                                                    <?php if(!empty($departmentData)){ ?>
                                                        <?php foreach($departmentData as $data){ ?>
                                                            <option value="<?php echo $data['department_id']; ?>"><?php echo $data['department_name']; ?></option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value="">Empty</option>
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_email">Employee Email *</label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-mail"></em>
                                                </div>
                                                <input type="email" class="form-control" name="employee_email" placeholder="Enter employee email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_correspondence_address">Employee Correspondence Address *</label>
                                            <div class="form-control-wrap">
                                                <textarea type="text" class="form-control" name="employee_correspondence_address" placeholder="Enter employee correspondence address" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_permanent_address">Employee Permanent Address *</label>
                                            <div class="form-control-wrap">
                                                <textarea type="text" class="form-control" name="employee_permanent_address" placeholder="Enter employee permanent address" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_telephone_no">Employee Telephone No *</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" name="employee_telephone_no" placeholder="Enter employee telephone no" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_mobile_no">Employee Mobile No *</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" name="employee_mobile_no" placeholder="Enter employee mobile no" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_birth_date">Employee Birth Date *</label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-calendar-alt"></em>
                                                </div>
                                                <input type="text" class="form-control date-picker" name="employee_birth_date" placeholder="Enter employee birth date" data-date-format="dd/mm/yyyy" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_blood_group">Employee Blood Group *</label>
                                            <div class="form-control-wrap">
                                                <select class="form-control form-select js-select2" name="employee_blood_group" data-placeholder="Select a group" required>
                                                    <option label="empty" value=""></option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="None">None</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_marital_status">Employee Marital Status *</label>
                                            <div class="form-control-wrap">
                                                <select class="form-control form-select js-select2" name="employee_marital_status" data-placeholder="Select a status" required>
                                                    <option label="empty" value=""></option>
                                                    <option value="Unmarried">Unmarried</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Engaged">Engaged</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_emergency_contact_name">Employee Emergency Contact Name *</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="employee_emergency_contact_name" placeholder="Enter employee emergency contact name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_emergency_contact_relation">Employee Emergency Contact Relation *</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="employee_emergency_contact_relation" placeholder="Enter employee emergency contact relation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_emergency_contact_no">Employee Emergency Contact No *</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" name="employee_emergency_contact_no" placeholder="Enter employee emergency contact no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-stepper-step">
                                <h6 class="title border-bottom mb-3 pb-2 ucap">Educational Details</h6>
                                <div id="educational_field">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="row g-gs">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_educational_degree">Employee Educational Degree *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_educational_degree[]" placeholder="Enter employee educational degree">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_educational_university_institute">Employee Educational University Institute *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_educational_university_institute[]" placeholder="Enter employee educational university institute">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_educational_start_year">Employee Educational Start Year *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="yearpicker" name="employee_educational_start_year[]" placeholder="Enter employee educational start year" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_educational_end_year">Employee Educational End Year *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="yearpicker" name="employee_educational_end_year[]" placeholder="Enter employee educational end year" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_educational_percentage_grade">Employee Educational Percentage Grade *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_educational_percentage_grade[]" placeholder="Enter employee educational percentage grade">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_educational_specialisation">Employee Educational Specialisation</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_educational_specialisation[]" placeholder="Enter employee educational specialisation">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <button type="button" class="btn btn-dim btn-sm btn-success" id="educational_add" name="educational_add"><em class="icon ni ni-plus-circle"></em><span>Add More</span></button>
                                </div>
                            </div>
                            <div class="nk-stepper-step">
                                <h6 class="title border-bottom mb-3 pb-2 ucap">Employeement Details</h6>
                                <div id="employeement_field">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="row g-gs">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_employeement_organisation">Employee Employeement Organisation *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_employeement_organisation[]" placeholder="Enter employee employeement organisation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_employeement_designation">Employee Employeement Designation *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_employeement_designation[]" placeholder="Enter employee employeement designation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_employeement_start_date">Employee Employeement Start Date *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="datepicker" name="employee_employeement_start_date[]" placeholder="Enter employee employeement start date" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_employeement_end_date">Employee Employeement End Date *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="datepicker" name="employee_employeement_end_date[]" placeholder="Enter employee employeement end date" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_employeement_annual_ctc">Employee Employeement Annual CTC *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_employeement_annual_ctc[]" placeholder="Enter employee employeement annual ctc">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-4">
                                    <button type="button" class="btn btn-dim btn-sm btn-success" id="employeement_add" name="employeement_add"><em class="icon ni ni-plus-circle"></em><span>Add More</span></button>
                                </div>
                            </div>
                            <div class="nk-stepper-step">
                                <h6 class="title border-bottom mb-3 pb-2 ucap">Family Details</h6>
                                <div id="family_field">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="row g-gs">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_family_member_name">Employee Family Member Name *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_family_member_name[]" placeholder="Enter employee family member name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_family_member_relation">Employee Family Member Relation *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_family_member_relation[]" placeholder="Enter employee family member relation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_family_member_occupation">Employee Family Member Occupation *</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_family_member_occupation[]" placeholder="Enter employee family member occupation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_family_member_birth_date">Employee Family Member Birth Date</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="datepicker" name="employee_family_member_birth_date[]" placeholder="Enter employee family member birth date" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-4">
                                    <button type="button" class="btn btn-dim btn-sm btn-success" id="family_add" name="family_add"><em class="icon ni ni-plus-circle"></em><span>Add More</span></button>
                                </div>
                            </div>
                            <div class="nk-stepper-step">
                                <h6 class="title border-bottom mb-3 pb-2 ucap">Professional Details</h6>
                                <div id="professional_field">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="row g-gs">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_professional_reference_name">Employee Professional Reference Name</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_professional_reference_name[]" placeholder="Enter employee professional reference name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_professional_reference_organisation">Employee Professional Reference Organisation</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_professional_reference_organisation[]" placeholder="Enter employee professional reference organisation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_professional_reference_designation">Employee Professional Reference Designation</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" name="employee_professional_reference_designation[]" placeholder="Enter employee professional reference designation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="employee_professional_reference_contact_no">Employee Professional Reference Contact No</label>
                                                        <div class="form-control-wrap">
                                                            <input type="number" class="form-control" name="employee_professional_reference_contact_no[]" placeholder="Enter employee professional reference contact no">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <button type="button" class="btn btn-dim btn-sm btn-success" id="professional_add" name="professional_add"><em class="icon ni ni-plus-circle"></em><span>Add More</span></button>
                                </div>
                            </div>
                            <div class="nk-stepper-step">
                                <h6 class="title border-bottom mb-3 pb-2 ucap">Declaration</h6>
                                <div class="row g-gs">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_place">Employee Place *</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="employee_place" placeholder="Enter employee place" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="employee_signature">Employee Signature *</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="employee_signature" placeholder="Enter employee signature" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nk-stepper-pagination pt-4 gx-4 gy-2 stepper-pagination">
                            <li class="step-prev"><button class="btn btn-dim btn-primary">Back</button></li>
                            <li class="step-next"><button class="btn btn-primary">Continue</button></li>
                            <li class="step-submit"><input type="submit" class="btn btn-primary submitBtn" name="submit" value="Save Informations"></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<script>
    $('body').on('focus',"#datepicker", function(){
        if( $(this).hasClass('hasDatepicker') === false ){
            $(this).datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format: 'dd/mm/yyyy'
            });
        }
    });

    $('body').on('focus',"#yearpicker", function(){
        if( $(this).hasClass('hasDatepicker') === false ){
            $(this).datepicker({
                clearBtn: true,
                autoclose: true, 
                minViewMode: 2,
                format: 'yyyy'
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){      
        var i=1;  
   
        $('#educational_add').click(function(){  
            i++;  
            $('#educational_field').append('<div id="row'+i+'" class="dynamic-added"><div class="card card-bordered mt-4"><div class="card-inner"><div class="row g-gs"><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_educational_degree">Employee Educational Degree</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_educational_degree[]" placeholder="Enter employee educational degree"></div></div></div><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_educational_university_institute">Employee Educational University Institute</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_educational_university_institute[]" placeholder="Enter employee educational university institute"></div></div></div><div class="col-sm-6"><div class="form-group"><label class="form-label" for="employee_educational_start_year">Employee Educational Start Year</label><div class="form-control-wrap"><input type="text" class="form-control" id="yearpicker" name="employee_educational_start_year[]" placeholder="Enter employee educational start year" autocomplete="off"></div></div></div><div class="col-sm-6"><div class="form-group"><label class="form-label" for="employee_educational_end_year">Educational Educational End Year</label><div class="form-control-wrap"><input type="text" class="form-control" id="yearpicker" name="employee_educational_end_year[]" placeholder="Enter employee educational end year" autocomplete="off"></div></div></div><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_educational_percentage_grade">Employee Educational Percentage Grade</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_educational_percentage_grade[]" placeholder="Enter employee educational percentage grade"></div></div></div><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_educational_specialisation">Employee Educational Specialisation</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_educational_specialisation[]" placeholder="Enter employee educational specialisation"></div></div></div></div><button type="button" class="btn btn-dim btn-sm btn-danger educational_btn_remove mt-4" id="'+i+'"  name="remove"><em class="icon ni ni-trash"></em><span>Remove</span></button></div></div></div>'
            );  
        });
        $(document).on('click', '.educational_btn_remove', function(){  
            var button_id = $(this).attr("id"); 
            var res = confirm('Are You Sure You Want To Delete This?');
            if(res==true){
                $('#row'+button_id+'').remove();  
                $('#'+button_id+'').remove();  
            }
        });

        $('#employeement_add').click(function(){  
            i++;  
            $('#employeement_field').append('<div id="row'+i+'" class="dynamic-added"><div class="card card-bordered mt-4"><div class="card-inner"><div class="row g-gs"><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_employeement_organisation">Employee Employeement Organisation</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_employeement_organisation[]" placeholder="Enter employee employeement organisation"></div></div></div><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_employeement_designation">Employee Employeement Designation</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_employeement_designation[]" placeholder="Enter employee employeement designation"></div></div></div><div class="col-sm-6"><div class="form-group"><label class="form-label" for="employee_employeement_start_date">Employee Employeement Start Date</label><div class="form-control-wrap"><input type="text" class="form-control" id="datepicker" name="employee_employeement_start_date[]" placeholder="Enter employee employeement start date" autocomplete="off"></div></div></div><div class="col-sm-6"><div class="form-group"><label class="form-label" for="employee_employeement_end_date">Employee Employeement End Date</label><div class="form-control-wrap"><input type="text" class="form-control" id="datepicker" name="employee_employeement_end_date[]" placeholder="Enter employee employeement end date" autocomplete="off"></div></div></div><div class="col-md-12"><div class="form-group"><label class="form-label" for="employee_employeement_annual_ctc">Employee Employeement Annual CTC</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_employeement_annual_ctc[]" placeholder="Enter employee employeement annual ctc"></div></div></div></div><button type="button" class="btn btn-dim btn-sm btn-danger employeement_btn_remove mt-4" id="'+i+'" name="remove"><em class="icon ni ni-trash"></em><span>Remove</span></button></div></div></div>'
            );  
        });
        $(document).on('click', '.employeement_btn_remove', function(){  
            var button_id = $(this).attr("id"); 
            var res = confirm('Are You Sure You Want To Delete This?');
            if(res==true){
                $('#row'+button_id+'').remove();  
                $('#'+button_id+'').remove();  
            }
        });

        $('#family_add').click(function(){  
            i++;  
            $('#family_field').append('<div id="row'+i+'" class="dynamic-added"><div class="card card-bordered mt-4"><div class="card-inner"><div class="row g-gs"><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_family_member_name">Employee Family Member Name</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_family_member_name[]" placeholder="Enter employee family member name"></div></div></div><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_family_member_relation">Employee Family Member Relation</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_family_member_relation[]" placeholder="Enter employee family member relation"></div></div></div><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_family_member_occupation">Employee Family Member Occupation</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_family_member_occupation[]" placeholder="Enter employee family member occupation"></div></div></div><div class="col-sm-6"><div class="form-group"><label class="form-label" for="employee_family_member_birth_date">Employee Family Member Birth Date</label><div class="form-control-wrap"><input type="text" class="form-control" id="datepicker" name="employee_family_member_birth_date[]" placeholder="Enter employee family member birth date" autocomplete="off"></div></div></div></div><button type="button" class="btn btn-dim btn-sm btn-danger family_btn_remove mt-4" id="'+i+'" name="remove"><em class="icon ni ni-trash"></em><span>Remove</span></button></div></div></div>'
            );  
        });
        $(document).on('click', '.family_btn_remove', function(){  
            var button_id = $(this).attr("id"); 
            var res = confirm('Are You Sure You Want To Delete This?');
            if(res==true){
                $('#row'+button_id+'').remove();  
                $('#'+button_id+'').remove();  
            }
        }); 

        $('#professional_add').click(function(){  
            i++;  
            $('#professional_field').append('<div id="row'+i+'" class="dynamic-added"><div class="card card-bordered mt-4"><div class="card-inner"><div class="row g-gs"><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_professional_reference_name">Employee Professional Reference Name</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_professional_reference_name[]" placeholder="Enter employee professional reference name"></div></div></div><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_professional_reference_organisation">Employee Professional Reference Organisation</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_professional_reference_organisation[]" placeholder="Enter employee professional reference organisation"></div></div></div><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_professional_reference_designation">Employee Professional Reference Designation</label><div class="form-control-wrap"><input type="text" class="form-control" name="employee_professional_reference_designation[]" placeholder="Enter employee professional reference designation"></div></div></div><div class="col-md-6"><div class="form-group"><label class="form-label" for="employee_professional_reference_contact_no">Employee Professional Reference Contact No</label><div class="form-control-wrap"><input type="number" class="form-control" name="employee_professional_reference_contact_no[]" placeholder="Enter employee professional reference contact no"></div></div></div></div><button type="button" class="btn btn-dim btn-sm btn-danger professional_btn_remove mt-4" id="'+i+'" name="remove"><em class="icon ni ni-trash"></em><span>Remove</span></button></div></div></div>'
            );  
        });
        $(document).on('click', '.professional_btn_remove', function(){  
            var button_id = $(this).attr("id"); 
            var res = confirm('Are You Sure You Want To Delete This?');
            if(res==true){
                $('#row'+button_id+'').remove();  
                $('#'+button_id+'').remove();  
            }
        });
    });
</script>