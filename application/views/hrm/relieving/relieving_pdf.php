<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Relieving Letter"; ?></title>
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
                } else if($employeeData['employee_gender'] == "Female" && $employeeData['employee_marital_status'] == "Unmarried"){ 
                    $employeeGenderCptSubjective = "She"; 
                    $employeeGenderSmlPossessive = "her"; 
                } else if($employeeData['employee_gender'] == "Female" && $employeeData['employee_marital_status'] == "Married"){ 
                    $employeeGenderCptSubjective = "She"; 
                    $employeeGenderSmlPossessive = "her"; 
                } else if($employeeData['employee_gender'] == "Female" && $employeeData['employee_marital_status'] == "Engaged"){ 
                    $employeeGenderCptSubjective = "She"; 
                    $employeeGenderSmlPossessive = "her"; 
                }
             
                echo str_replace(array(
                    "#[page_break]#",
                    "#[employee_department]#",
                    "#[employee_name]#",
                    "#[gen_cpt_subjective]#",
                    "#[gen_sml_possessive]#",
                    "#[from_date]#",
                    "#[to_date]#",
                    "#[effective_date]#",
                    "#[create_date]#",
                ),array(
                    $pageBreak,
                    $departmentData['department_name'], 
                    $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name'], 
                    $employeeGenderCptSubjective,
                    $employeeGenderSmlPossessive,
                    $pdfRelieving['from_date'], 
                    $pdfRelieving['to_date'], 
                    $pdfRelieving['effective_date'],
                    $pdfRelieving['create_date'], 
                ),$pdfRelieving['relieving_letter']); 
            ?>
        </main>
    </body>
</html>