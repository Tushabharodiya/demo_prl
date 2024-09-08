<?php 
    $experienceID = $this->uri->segment(2);

    $sessionExperienceViewPreviousUrl = $this->session->userdata('session_experience_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Experience</h4>
                    <div class="nk-block-des text-soft">
                        <p>Detail Experience</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li><a href="<?php echo base_url(); ?>pdf-experience/<?php echo $experienceID; ?>" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionExperienceViewPreviousUrl)){ echo $sessionExperienceViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner">
                    <?php foreach($detailExperience as $data){ ?>
                        <div class="letter p-3"><?php 
                            $pageBreak = '<div style="page-break-before: always;"></div>';
                            
                            if($data['employeeData']['employee_gender'] == "Male"){ 
                                $employeeGenderCptMarital = "Mr"; 
                                $employeeGenderSmlPossessive = "his"; 
                                $employeeGenderSmlObjective = "him"; 
                                $employeeGenderCptSubjective = "He"; 
                                $employeeGenderSmlSubjective = "he";
                            } else if($data['employeeData']['employee_gender'] == "Female" && $data['employeeData']['employee_marital_status'] == "Unmarried"){ 
                                $employeeGenderCptMarital = "Ms"; 
                                $employeeGenderSmlPossessive = "her"; 
                                $employeeGenderSmlObjective = "her"; 
                                $employeeGenderCptSubjective = "She"; 
                                $employeeGenderSmlSubjective = "she";
                            } else if($data['employeeData']['employee_gender'] == "Female" && $data['employeeData']['employee_marital_status'] == "Married"){ 
                                $employeeGenderCptMarital = "Mrs"; 
                                $employeeGenderSmlPossessive = "her"; 
                                $employeeGenderSmlObjective = "her"; 
                                $employeeGenderCptSubjective = "She"; 
                                $employeeGenderSmlSubjective = "she";
                            } else if($data['employeeData']['employee_gender'] == "Female" && $data['employeeData']['employee_marital_status'] == "Engaged"){ 
                                $employeeGenderCptMarital = "Ms"; 
                                $employeeGenderSmlPossessive = "her"; 
                                $employeeGenderSmlObjective = "her"; 
                                $employeeGenderCptSubjective = "She"; 
                                $employeeGenderSmlSubjective = "she";
                            }
                            
                            echo str_replace(array(
                                "#[page_break]#",
                                "#[employee_department]#",
                                "#[employee_name]#",
                                "#[gen_cpt_marital]#",
                                "#[gen_sml_possessive]#",
                                "#[gen_sml_objective]#",
                                "#[gen_cpt_subjective]#",
                                "#[gen_sml_subjective]#",
                                "#[from_date]#",
                                "#[to_date]#",
                                "#[create_date]#",
                            ),array(
                                $pageBreak,
                                $data['departmentData']['department_name'], 
                                $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'], 
                                $employeeGenderCptMarital,
                                $employeeGenderSmlPossessive,
                                $employeeGenderSmlObjective,
                                $employeeGenderCptSubjective,
                                $employeeGenderSmlSubjective,
                                $data['from_date'], 
                                $data['to_date'], 
                                $data['create_date'],
                            ),$data['experience_letter']);
                        ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
    </div>
</div>