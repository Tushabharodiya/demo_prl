<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Experience Letter"; ?></title>
        <style>
            @page{
                margin: 0.9in 0.5in 0.5in 0.6in;
            }
        </style>
    </head>
    <body>
        <header>
            <?php $imageData = file_get_contents(URL.'/source/images/logo-dark.png'); $image = 'data:image/' . ';base64,' . base64_encode($imageData); echo '<center><img src="'.$image.' width="220" height="40"></center>'; ?>
        </header>
        <main>
            <?php 
                $pageBreak = '<div style="page-break-before: always;"></div>';
                
                if($employeeData['employee_gender'] == "Male"){ 
                    $employeeGenderCptMarital = "Mr"; 
                    $employeeGenderSmlPossessive = "his"; 
                    $employeeGenderSmlObjective = "him"; 
                    $employeeGenderCptSubjective = "He"; 
                    $employeeGenderSmlSubjective = "he";
                } else if($employeeData['employee_gender'] == "Female" && $employeeData['employee_marital_status'] == "Unmarried"){ 
                    $employeeGenderCptMarital = "Ms"; 
                    $employeeGenderSmlPossessive = "her"; 
                    $employeeGenderSmlObjective = "her"; 
                    $employeeGenderCptSubjective = "She"; 
                    $employeeGenderSmlSubjective = "she";
                } else if($employeeData['employee_gender'] == "Female" && $employeeData['employee_marital_status'] == "Married"){ 
                    $employeeGenderCptMarital = "Mrs"; 
                    $employeeGenderSmlPossessive = "her"; 
                    $employeeGenderSmlObjective = "her"; 
                    $employeeGenderCptSubjective = "She"; 
                    $employeeGenderSmlSubjective = "she";
                } else if($employeeData['employee_gender'] == "Female" && $employeeData['employee_marital_status'] == "Engaged"){ 
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
                    $departmentData['department_name'], 
                    $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name'],
                    $employeeGenderCptMarital,
                    $employeeGenderSmlPossessive,
                    $employeeGenderSmlObjective,
                    $employeeGenderCptSubjective,
                    $employeeGenderSmlSubjective,
                    $pdfExperience['from_date'], 
                    $pdfExperience['to_date'], 
                    $pdfExperience['create_date'], 
                ),$pdfExperience['experience_letter']);
            ?>
        </main>
    </body>
</html>