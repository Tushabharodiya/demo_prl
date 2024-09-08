<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Consent Letter"; ?></title>
    </head>
    <body>
        <main>
            <?php 
                $pageBreak = '<div style="page-break-before: always;"></div>';
                
                if(!empty($employeeData['employee_bank_name'])){
                    $employeeBankName = $employeeData['employee_bank_name'];
                } else {
                    $employeeBankName = " - ";
                }
                
                if(!empty($employeeData['employee_cheque_no'])){
                    $employeeChequeNo = $employeeData['employee_cheque_no'];
                } else {
                    $employeeChequeNo = " - ";
                }
                
                echo str_replace(array(
                    "#[page_break]#",
                    "#[employee_name]#",
                    "#[employee_bank_name]#",
                    "#[employee_cheque_no]#",
                    "#[employee_consent_name]#",
                    "#[create_date]#"
                ),array(
                    $pageBreak,
                    $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name'], 
                    $employeeBankName,
                    $employeeChequeNo,
                    $employeeData['employee_consent_name'],
                    $pdfConsent['create_date'], 
                ),$pdfConsent['consent_letter']);  
            ?>
        </main>
    </body>
</html>