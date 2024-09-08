<html>
    <head>
        <title><?php $fileName = $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name']; echo "$fileName - Offer Letter"; ?></title>
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
                
                $employeeStipend = $employeeData['employee_stipend']; 
                $myNumber = str_replace(',', '', $employeeStipend); 
                $number = $myNumber;
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
                $stipendWord = ($points) ? $result . "Rupees  " . $points . " Paise" : $result . "Rupees ";
                
                echo str_replace(array(
                    "#[page_break]#",
                    "#[employee_department]#",
                    "#[employee_name]#",
                    "#[employee_internship_month]#",
                    "#[employee_stipend]#",
                    "#[employee_stipend_word]#",
                    "#[reporting_date]#",
                    "#[reporting_time]#",
                    "#[create_date]#",
                ),array(
                    $pageBreak,
                    $departmentData['department_name'], 
                    $employeeData['employee_first_name'].' '.$employeeData['employee_middle_name'].' '.$employeeData['employee_last_name'], 
                    $employeeData['employee_internship_month'], 
                    $employeeData['employee_stipend'], 
                    $stipendWord,
                    $pdfInternOffer['reporting_date'],
                    $pdfInternOffer['reporting_time'],
                    $pdfInternOffer['create_date'], 
                ),$pdfInternOffer['intern_offer_letter']);
            ?>
        </main>
    </body>
</html>