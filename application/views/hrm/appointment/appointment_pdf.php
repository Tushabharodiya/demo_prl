<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Appointment Letter"; ?></title>
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
                    $employeeGenderCptSubjective = "He"; 
                    $employeeGenderSmlPossessive = "his"; 
                    $employeeGenderCptPossessive = "His"; 
                    $employeeGenderCptObjective = "Him"; 
                } else if($employeeData['employee_gender'] == "Female"){ 
                    $employeeGenderCptSubjective = "She"; 
                    $employeeGenderSmlPossessive = "her"; 
                    $employeeGenderCptPossessive = "Her"; 
                    $employeeGenderCptObjective = "Her";
                }
        
                echo str_replace(array(
                    "#[page_break]#",
                    "#[employee_department]#",
                    "#[employee_name]#",
                    "#[employee_correspondence_address]#",
                    "#[employee_salary]#",
                    "#[gen_cpt_subjective]#",
                    "#[gen_sml_possessive]#",
                    "#[gen_cpt_possessive]#",
                    "#[gen_cpt_objective]#",
                    "#[effective_date]#",
                    "#[create_date]#",
                ),array(
                    $pageBreak,
                    $departmentData['department_name'], 
                    $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name'], 
                    $employeeData['employee_correspondence_address'], 
                    $employeeData['employee_salary'],
                    $employeeGenderCptSubjective,
                    $employeeGenderSmlPossessive,
                    $employeeGenderCptPossessive,
                    $employeeGenderCptObjective,
                    $pdfAppointment['effective_date'],
                    $pdfAppointment['create_date'], 
                ),$pdfAppointment['appointment_letter']); 
            ?>
        </main>
    </body>
</html>