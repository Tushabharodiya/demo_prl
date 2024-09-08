<?php 
    $salaryID = $this->uri->segment(2);
    
    $sessionSalaryViewPreviousUrl = $this->session->userdata('session_salary_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Salary</h4>
                    <div class="nk-block-des text-soft">
                        <p>Detail Salary</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li><a onclick="createPDF()" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                <li class="nk-block-tools-opt d-block d-sm-block">
                                    <a href="<?php if(!empty($sessionSalaryViewPreviousUrl)){ echo $sessionSalaryViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="nk-block">
            <?php foreach($detailSalary as $data){ ?>
            <div class="invoice">
                <div id="element-to-pdf">
                    <div class="salary-slip">
                        <div class="invoice-brand">
                            <table>
                                <tr>
                                    <td colspan="4">
                                        <div class="left px-1">
                                            <p class="mb-0"><b>Syphnosys Technology Private Limited</b></p>
                                            <p class="mb-0"><b>CIN - U72900GJ2020PTC117330</b></p>
                                            <p class="mb-0">301, The Galleria,</p> 
                                            <p class="mb-0">Nr. Anupam Business Hub,</p> 
                                            <p class="mb-0">Yogi Chowk Road, Surat,</p> 
                                            <p class="mb-0">Gujarat 395010</p>
                                        </div>
                                        <div class="right mt-5 px-1">
                                            <a class="logo-link">
                                                <img class="logo-light logo-img" src="<?php echo base_url(); ?>source/images/logo.png" srcset="<?php echo base_url(); ?>source/images/logo2x.png 2x" alt="logo">
                                                <img class="logo-dark logo-img" src="<?php echo base_url(); ?>source/images/logo-dark.png" srcset="<?php echo base_url(); ?>source/images/logo-dark2x.png 2x" alt="logo-dark">
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                      <div class="left px-1">Salary Slip</div>
                                      <div class="right px-1"><b>(<?php $employeeCreateDate = $data['employee_create_date']; $date = str_replace('/', '-', $employeeCreateDate); echo date("F 'y",strtotime($date)); ?>)</b></div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w0"><div class="px-1">Employee Name</div></td>
                                    <td colspan="2"><div class="px-1"><?php echo $data['employeeData']['employee_first_name']; ?> <?php echo $data['employeeData']['employee_middle_name']; ?> <?php echo $data['employeeData']['employee_last_name']; ?></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><div class="px-1">Employee Address</div></td>
                                    <td colspan="2"><div class="px-1"><?php echo $data['employeeData']['employee_correspondence_address']; ?></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><div class="px-1">Employee ID</div></td>
                                    <td colspan="2"><div class="px-1">'<?php echo $data['employeeData']['employee_access_card_no']; ?></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><div class="px-1">Position</div></td>
                                    <td colspan="2"><div class="px-1"><?php echo $data['departmentData']['department_name']; ?></div></td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-center"><b>Payment Information</b></th>
                                    <th colspan="2" class="text-center"><b>Earnings</b></th>
                                </tr>
                                <tr>
                                    <td><div class="px-1">Working days</div></td>
                                    <td><div class="px-1">24</div></td>
                                    <td><div class="px-1">Basic</div></td>
                                    <?php if($data['employeeData']['employee_type'] == "intern"){ ?>
                                        <td><div class="px-1"><?php echo $data['employeeData']['employee_stipend']; ?></div></td>
                                    <?php } else if($data['employeeData']['employee_type'] == "employee"){ ?>
                                        <td><div class="px-1"><?php echo $data['employeeData']['employee_salary']; ?></div></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td><div class="px-1">Weekly off</div></td>
                                    <td><div class="px-1"><?php 
                                        $employeeCreateDate = $data['employee_create_date'];
                                        $date = str_replace('/', '-', $employeeCreateDate);
                                        $totalDays = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('Y', strtotime($date)));
                                        echo $totalDays - 24; 
                                    ?></div></td>
                                    <td><div class="px-1">Overtime</div></td>
                                    <td><div class="px-1"><?php echo $data['employee_overtime']; ?></div></td>
                                </tr>
                                <tr>
                                    <td><div class="px-1">Payable days</div></td>
                                    <td><div class="px-1"><?php echo $data['employee_payable_day']; ?></div></td>
                                    <td><div class="px-1">Bonus</div></td>
                                    <td><div class="px-1"><?php echo $data['employee_bonus']; ?></div></td>
                                </tr>
                                <tr>
                                    <td><div class="px-1">Overtime Days</div></td>
                                    <td><div class="px-1">0</div></td>
                                    <td><div class="px-1">Other Deduction</div></td>
                                    <td><div class="px-1"><?php echo $data['employee_other_deduction']; ?></div></td>
                                </tr>
                                <tr>
                                    <td><div class="px-1">Leave</div></td>
                                    <td><div class="px-1">0</div></td>
                                    <td><div class="px-1">Unpaid Leave Amount</div></td>
                                    <td><div class="px-1"><?php echo $data['employee_unpaid_leave_amount']; ?></div></td>
                                </tr>
                                <tr>
                                    <th><div class="px-1">Total Days</div></th>
                                    <th>
                                        <div class="px-1">
                                            <?php 
                                                $employeeCreateDate = $data['employee_create_date'];
                                                $date = str_replace('/', '-', $employeeCreateDate);
                                                $totalDays = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('Y', strtotime($date)));
                                                echo $totalDays; 
                                            ?>
                                        </div>
                                    </th>
                                    <th><div class="px-1">Total Earnings</div></th>
                                    <th>
                                        <div class="px-1">
                                            <?php 
                                                if($data['employeeData']['employee_type'] == "intern"){
                                                    $basicSalary = str_replace(',','', $data['employeeData']['employee_stipend']);
                                                } else if($data['employeeData']['employee_type'] == "employee"){
                                                    $basicSalary = str_replace(',','', $data['employeeData']['employee_salary']);
                                                }
                                	            $employeeOvertime = str_replace(',','', $data['employee_overtime']);
                                	            $employeeBonus = str_replace(',','', $data['employee_bonus']);
                                	            $employeeOtherDeduction = str_replace(',','', $data['employee_other_deduction']);
                                	            $employeeUnpaidLeaveAmount = str_replace(',','', $data['employee_unpaid_leave_amount']);
                                                $countEarnings = intval($basicSalary) + intval($employeeOvertime) + intval($employeeBonus) - intval($employeeOtherDeduction) - intval($employeeUnpaidLeaveAmount);
                	                            echo $totalEarnings = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $countEarnings);
                                            ?>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2"><div class="px-1">Net Salary</div></th>
                                    <th colspan="2">
                                        <div class="px-1">
                                            <?php
                                                if($data['employeeData']['employee_type'] == "intern"){
                                                    $basicSalary = $data['employeeData']['employee_stipend'];
                                                } else if($data['employeeData']['employee_type'] == "employee"){
                                                    $basicSalary = $data['employeeData']['employee_salary'];
                                                }
                                                $myNumber = str_replace(',', '', $basicSalary); 
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
                                                echo ucfirst(($points) ? $result . "Rupees  " . $points . " Paise" : $result . "Rupees ");
                                            ?>Only
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="4"><br><br><br><br><br><br></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><center><b>This is computer generated statement hence does not require a signature</b></center></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    function createPDF() {
        var element = document.getElementById('element-to-pdf');
        html2pdf(element, {
            margin: 0.5,
            filename: '<?php foreach($detailSalary as $data){ } echo $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name']; ?> - Salary Slip',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { scale: 2,  logging: true },
            jsPDF: { unit: 'in', format: 'A4', orientation: 'P' },
            class: createPDF
        });
    };
</script>