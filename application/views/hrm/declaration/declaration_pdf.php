<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Declaration"; ?></title>
    </head>
    <body>
        <main>
            <?php 
                $pageBreak = '<div style="page-break-before: always;"></div>';
                
                echo str_replace(array(
                    "#[page_break]#",
                    "#[employee_name]#",
                    "#[create_date]#"
                ),array(
                    $pageBreak,
                    $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name'], 
                    $pdfDeclaration['create_date'],
                ),$pdfDeclaration['declaration_letter']); 
            ?>
        </main>
    </body>
</html>
