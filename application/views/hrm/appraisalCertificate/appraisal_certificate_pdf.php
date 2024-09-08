<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Appraisal Certificate"; ?></title>
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
             
                echo str_replace(array(
                    "#[page_break]#",
                    "#[employee_department]#",
                    "#[employee_name]#",
                    "#[employee_salary]#",
                    "#[create_date]#",
                    ),array(
                        $pageBreak,
                        $departmentData['department_name'], 
                        $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name'], 
                        $employeeData['employee_salary'],
                        $pdfAppraisalCertificate['create_date'],
                    ),$pdfAppraisalCertificate['appraisal_certificate_letter']
                );   
            ?>
        </main>
    </body>
</html>