<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Non Disclosure Agreement"; ?></title>
        <style>
            @page{
                margin: 0.9in 0.5in 1.4in 0.6in;
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
                    <td><strong>Name:</strong> <?php echo $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; ?></td>
                    <td><strong>Date :</strong> <?php echo date("d/m/Y"); ?></td>
                </tr>
                <tr>
                    <td><strong>Sign:</strong></td>
                    <td><strong>Place:</strong> Surat, Gujarat, India</td>
                </tr>
            </table>
        </footer>
        <main>
            <?php 
                $pageBreak = '<div style="page-break-before: always;"></div>';
                
                echo str_replace(array(
                    "#[page_break]#",
                    "#[employee_name]#"
                ),array(
                    $pageBreak,
                    $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']
                ),$pdfNonDisclosureAgreement['non_disclosure_agreement_letter']);
            ?>
        </main>
    </body>
</html>
