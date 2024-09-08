<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Service Agreement"; ?></title>
        <style>
            @page{
                margin: 0.9in 0.5in 1.5in 0.6in;
            }
            footer table {
                border-collapse: collapse;
                width: 100%;
            }
            footer tr {
                text-align: left; 
            }
            footer td, th {
                border: 1px solid #dbdfea;
                padding: 15px; 
                line-height: 1.1;
                width:50%;
            }
        </style>
    </head>
    <body>
        <header>
            <?php $imageData = file_get_contents(URL.'/source/images/logo-dark.png'); $image = 'data:image/' . ';base64,' . base64_encode($imageData); echo '<center><img src="'.$image.' width="220" height="40"></center>'; ?>
        </header>
        <footer>
            <table>
                <tr>
                    <td rowspan="2"></td>
                    <td><strong>Sign:</strong></td>
                </tr>
                <tr>
                    <td><strong>Name:</strong> <?php echo $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; ?></td>
                </tr>
            </table>
        </footer>
        <main>
            <?php
                $pageBreak = '<div style="page-break-before: always;"></div>';
                
                if($employeeData['employee_gender'] == "Male"){ 
                    $maritalStatus = "Son";
                } else if($employeeData['employee_gender'] == "Female" && $employeeData['employee_marital_status'] == "Unmarried"){ 
                    $maritalStatus = "Daughter"; 
                } else if($employeeData['employee_gender'] == "Female" && $employeeData['employee_marital_status'] == "Married"){ 
                    $maritalStatus = "Wife";
                } else if($employeeData['employee_gender'] == "Female" && $employeeData['employee_marital_status'] == "Engaged"){ 
                    $maritalStatus = "Daughter"; 
                }
                
                $employeeBirthDate = $employeeData['employee_birth_date'];
                $employeeAge = calculateAge($employeeBirthDate);
                
                if($employeeData['employee_gender'] == "Male"){ 
                    $employeeGenderSmlPossessive = "his"; 
                    $employeeGenderSmlSubjective = "he"; 
                } else if($employeeData['employee_gender'] == "Female"){ 
                    $employeeGenderSmlPossessive = "her"; 
                    $employeeGenderSmlSubjective = "she"; 
                } 
                
                $basicCompensation = $employeeData['employee_compensation'];
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
                    $departmentData['department_name'], 
                    $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name'],
                    $employeeData['employee_first_name'],
                    $employeeData['employee_middle_name'],
                    $employeeData['employee_correspondence_address'],
                    $employeeAge,
                    $maritalStatus,
                    $employeeData['employee_qualification'],
                    $employeeData['employee_compensation'],
                    $employeeCompensationWord,
                    $employeeGenderSmlPossessive,
                    $employeeGenderSmlSubjective,
                    $pdfServiceAgreement['director_name'],
                    $pdfServiceAgreement['create_date'],
                ),$pdfServiceAgreement['service_agreement_letter']); 
            ?>
        </main>
    </body>
</html>