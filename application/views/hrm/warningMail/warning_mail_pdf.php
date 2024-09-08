<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Warning Mail"; ?></title>
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
                    "#[employee_name]#",
                    "#[warning_reason]#",
                    "#[warning_description]#",
                    "#[create_date]#",
                    ),array(
                        $pageBreak,
                        $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name'], 
                        $pdfWarningMail['warning_reason'],
                        $pdfWarningMail['warning_description'],
                        $pdfWarningMail['create_date'],
                    ),$pdfWarningMail['warning_letter']
                );   
            ?>
        </main>
    </body>
</html>