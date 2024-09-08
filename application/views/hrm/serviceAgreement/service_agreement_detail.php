<?php 
    $serviceAgreementID = $this->uri->segment(2);

    $sessionServiceAgreementViewPreviousUrl = $this->session->userdata('session_service_agreement_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Service Agreement</h4>
                    <div class="nk-block-des text-soft">
                        <p>Detail Service Agreement</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li><a href="<?php echo base_url(); ?>pdf-service-agreement/<?php echo $serviceAgreementID; ?>" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionServiceAgreementViewPreviousUrl)){ echo $sessionServiceAgreementViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
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
                    <?php foreach($detailServiceAgreement as $data){ ?>
                        <div class="letter p-3"><?php 
                            $pageBreak = '<div style="page-break-before: always;"></div>';
                            
                            if($data['employeeData']['employee_gender'] == "Male"){ 
                                $maritalStatus = "Son";
                            } else if($data['employeeData']['employee_gender'] == "Female" && $data['employeeData']['employee_marital_status'] == "Unmarried"){ 
                                $maritalStatus = "Daughter"; 
                            } else if($data['employeeData']['employee_gender'] == "Female" && $data['employeeData']['employee_marital_status'] == "Married"){ 
                                $maritalStatus = "Wife";
                            } else if($data['employeeData']['employee_gender'] == "Female" && $data['employeeData']['employee_marital_status'] == "Engaged"){ 
                                $maritalStatus = "Daughter"; 
                            }
                        
                            $employeeBirthDate = $data['employeeData']['employee_birth_date'];
                            $employeeAge = calculateAge($employeeBirthDate);
                            
                            if($data['employeeData']['employee_gender'] == "Male"){ 
                                $employeeGenderSmlPossessive = "his"; 
                                $employeeGenderSmlSubjective = "he"; 
                            } else if($data['employeeData']['employee_gender'] == "Female"){ 
                                $employeeGenderSmlPossessive = "her"; 
                                $employeeGenderSmlSubjective = "she"; 
                            } 
                            
                            $basicCompensation = $data['employeeData']['employee_compensation'];
                            $myNumber = str_replace(',', '', $basicCompensation); 
                            $number = floatval($myNumber);
                            $no = floor($number);
                            $point = round($number - $no, 2) * 100;
                            $hundred = null;
                            $digits_1 = strlen($no);
                            $i = 0;
                            $str = array();
                            $words = array('0' => '', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten', 
                                '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fourteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
                                '30' => 'thirty', '40' => 'forty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninety');
                            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
                            while ($i < $digits_1) {
                                $divider = ($i == 2) ? 10 : 100;
                                $number = floor($no % $divider);
                                $no = floor($no / $divider);
                                $i += ($divider == 10) ? 1 : 2;
                                if ($number) {
                                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                                    $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
                                } else $str[] = null;
                            }
                            $str = array_reverse($str);
                            $result = implode('', $str);
                            $points = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
                            $employeeCompensationWord = ucfirst(($points) ? $result . "Rupees  " . $points . " Paise" : $result . "Rupees ");
                            
                            echo str_replace(array(
                                "#[page_break]#",
                                "#[employee_department]#",
                                "#[employee_name]#",
                                "#[employee_first_name]#",
                                "#[employee_middle_name]#",
                                "#[employee_correspondence_address]#",
                                "#[employee_age]#",
                                "#[gen_cpt_marital]#",
                                "#[employee_qualification]#",
                                "#[employee_compensation]#",
                                "#[employee_compensation_word]#",
                                "#[gen_sml_possessive]#",
                                "#[gen_sml_subjective]#",
                                "#[director_name]#",
                                "#[create_date]#",
                            ),array(
                                $pageBreak,
                                $data['departmentData']['department_name'], 
                                $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'],
                                $data['employeeData']['employee_first_name'],
                                $data['employeeData']['employee_middle_name'],
                                $data['employeeData']['employee_correspondence_address'], 
                                $employeeAge,
                                $maritalStatus,
                                $data['employeeData']['employee_qualification'],
                                $data['employeeData']['employee_compensation'],
                                $employeeCompensationWord,
                                $employeeGenderSmlPossessive,
                                $employeeGenderSmlSubjective,
                                $data['director_name'],
                                $data['create_date'],
                            ),$data['service_agreement_letter']); 
                        ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
    </div>
</div>