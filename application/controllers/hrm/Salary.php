<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends CI_Controller {
    function __construct() {
		parent::__construct();

		if ($this->session->userdata('auth_key') != AUTH_KEY){ 
            redirect('login');
        }
	}
	
	public function index(){
        $this->load->view('header');
        $this->load->view('error');
        $this->load->view('footer');
    }
	
    public function salaryNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SALARY_ALIAS, "can_add");
            if($isPermission){
                if(isset($_POST['reset_filter'])){
                    $this->session->unset_userdata('session_salary_start_date');
                    $this->session->unset_userdata('session_salary_end_date');
                    redirect('new-salary');
                }
                
                if(isset($_POST['submit_filter'])){
                    $searchSalaryStartDate = $this->input->post('search_salary_start_date');
                    $searchSalaryEndDate = $this->input->post('search_salary_end_date');

                    $this->session->set_userdata('session_salary_start_date', $searchSalaryStartDate);
                    $this->session->set_userdata('session_salary_end_date', $searchSalaryEndDate);
                }
                $sessionSalaryStartDate = $this->session->userdata('session_salary_start_date');
                $sessionSalaryEndDate = $this->session->userdata('session_salary_end_date');
                
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/salary/salary_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $employeeID = $this->input->post('employee_id');
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, MASTER_USER_TABLE);
                    $data['userData'] = $this->DataModel->getData('user_id = '.$data['employeeData']['user_id'], MASTER_USER_TABLE);
                    
                    $startDate = DateTime::createFromFormat('d/m/Y', $sessionSalaryStartDate);
                    $startMonth = $startDate->format('m'); 
                    $startYear = $startDate->format('Y'); 
                    
                    $data['workingDays'] = calculateWorkingDays($startMonth, $startYear);
                    
                    $data['workedDays'] = $this->DataModel->countAttendanceEmployeeDashboardHoursData('user_id = "'.$data['userData']['user_id'].'" And MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.$startMonth.'" And YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.$startYear.'"', HRM_ATTENDANCE_TABLE);
                    
                    $data['workingHours'] = calculateWorkingDays($startMonth,$startYear) * WORKING_HOURS.":00" ;
                    
                    $workedHoursData = $this->DataModel->getAttendanceEmployeeDashboardHoursData('working_hours', 'user_id = "'.$data['userData']['user_id'].'" And MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.$startMonth.'" And YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.$startYear.'"', HRM_ATTENDANCE_TABLE);
        			if(!empty($workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'])){
        			    $workingHours = $workedHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_hours`)))'];
                        $workedTimeParts = explode(':', $workingHours);
                        $workedTimeFormatted = $workedTimeParts[0] . ':' . $workedTimeParts[1];
                        $data['workedHours'] = $workedTimeFormatted;
        			} else {
        			    $data['workedHours'] = "00:00";
        			}
        			
        			$overtimeHoursData = $this->DataModel->getAttendanceEmployeeDashboardHoursData('working_overtime_hours', 'user_id = "'.$data['userData']['user_id'].'" And MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.$startMonth.'" And YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.$startYear.'"', HRM_ATTENDANCE_TABLE);
        			if(!empty($overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'])){
        			    $workingOvertimeHours = $overtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_overtime_hours`)))'];
                        $overTimeParts = explode(':', $workingOvertimeHours);
                        $overTimeFormatted = $overTimeParts[0] . ':' . $overTimeParts[1];
                        $data['overtimeHours'] = $overTimeFormatted;
        			} else {
        			    $data['overtimeHours'] = "00:00";
        			}
        			
        			$belowtimeHoursData = $this->DataModel->getAttendanceEmployeeDashboardHoursData('working_belowtime_hours', 'user_id = "'.$data['userData']['user_id'].'" And MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.$startMonth.'" And YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "'.$startYear.'"', HRM_ATTENDANCE_TABLE);
        			if(!empty($belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'])){
        			    $workingBelowtimeHours = $belowtimeHoursData['SEC_TO_TIME(SUM(TIME_TO_SEC(`working_belowtime_hours`)))'];
                        $belowTimeParts = explode(':', $workingBelowtimeHours);
                        $belowTimeFormatted = $belowTimeParts[0] . ':' . $belowTimeParts[1];
                        $data['belowtimeHours'] = $belowTimeFormatted;
        			} else {
        			    $data['belowtimeHours'] = "00:00";
        			}
			
                    $newData = array(
                        'employee_id'=>$employeeID,
                        'employee_working_day'=>$data['workingDays'],
                        'employee_worked_day'=>$data['workedDays'],
                        'employee_working_hours'=>$data['workingHours'],
                        'employee_worked_hours'=>$data['workedHours'],
                        'employee_overtime_hours'=>$data['overtimeHours'],
                        'employee_belowtime_hours'=>$data['belowtimeHours'],
                        'employee_bonus'=>$this->input->post('employee_bonus'),
                        'employee_other_deduction'=>$this->input->post('employee_other_deduction'),
                        'employee_create_date'=>$this->input->post('employee_create_date'),
                        'is_email'=>'pending',
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_SALARY_TABLE, $newData);
                    if($newDataEntry){
                        $this->session->unset_userdata('session_salary_start_date');
                        $this->session->unset_userdata('session_salary_end_date');
                        redirect('view-salary');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function salaryView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_salary_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_salary');
            }
            if(isset($_POST['submit_search'])){
                $searchSalary = $this->input->post('search_salary');
                $this->session->set_userdata('session_salary', $searchSalary);
            }
            $sessionSalary = $this->session->userdata('session_salary');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_salary_email');
                $this->session->unset_userdata('session_salary_type');
                $this->session->unset_userdata('session_salary_status');
                redirect('view-salary');
            }
                
            $searchSalaryEmail = $this->input->post('search_salary_email');
            if($searchSalaryEmail === 'pending' or $searchSalaryEmail == 'sending'){
                $this->session->set_userdata('session_salary_email', $searchSalaryEmail);
            } else if($searchSalaryEmail === 'all'){
                $this->session->unset_userdata('session_salary_email');
            }
            $sessionSalaryEmail = $this->session->userdata('session_salary_email');
            
            $searchSalaryType = $this->input->post('search_salary_type');
            if($searchSalaryType === 'intern' or $searchSalaryType == 'employee'){
                $this->session->set_userdata('session_salary_type', $searchSalaryType);
            } else if($searchSalaryType === 'all'){
                $this->session->unset_userdata('session_salary_type');
            }
            $sessionSalaryType = $this->session->userdata('session_salary_type');
            
            $searchSalaryStatus = $this->input->post('search_salary_status');
            if($searchSalaryStatus === 'active' or $searchSalaryStatus == 'inactive'){
                $this->session->set_userdata('session_salary_status', $searchSalaryStatus);
            } else if($searchSalaryStatus === 'all'){
                $this->session->unset_userdata('session_salary_status');
            }
            $sessionSalaryStatus = $this->session->userdata('session_salary_status');
            
            $data = array();
            //get rows count
            $conditions['search_salary'] = $sessionSalary;
            $conditions['search_salary_email'] = $sessionSalaryEmail;
            $conditions['search_salary_type'] = $sessionSalaryType;
            $conditions['search_salary_status'] = $sessionSalaryStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewSalaryData($conditions, HRM_SALARY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-salary');
            $config['uri_segment'] = 2;
            $config['total_rows']  = $totalRec;
            $config['per_page']    = 10;
            
            //styling
            $config['num_tag_open'] = '<li class="page-item page-link">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active page-item"><a href="javascript:void(0);" class="page-link" >';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_link'] = '&raquo';
            $config['prev_link'] = '&laquo';
            $config['next_tag_open'] = '<li class="pg-next page-item page-link">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="pg-prev page-item page-link">';
            $config['prev_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item page-link">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item page-link">';
            $config['last_tag_close'] = '</li>';
            
            //initialize pagination library
            $this->pagination->initialize($config);
            
            //define offset
            $page = $this->uri->segment(2);
            $offset = !$page?0:$page;
            
            //get rows
            $conditions['returnType'] = '';
            $conditions['start'] = $offset;
            $conditions['limit'] = 10;
            
            $salary = $this->DataModel->viewSalaryData($conditions, HRM_SALARY_TABLE);
            $data['countSalary'] = $this->DataModel->countSalaryData($conditions, HRM_SALARY_TABLE);
            $data['countSalaryTrash'] = $this->DataModel->countSalaryTrashData($conditions, HRM_SALARY_TABLE);
            
            $data['viewSalary'] = array();
            if(is_array($salary) || is_object($salary)){
                foreach($salary as $Row){
                    $dataArray = array();
                    $dataArray['salary_id'] = $Row['salary_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['employee_create_date'] = $Row['employee_create_date'];
                    $dataArray['is_email'] = $Row['is_email'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewSalary'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/salary/salary_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function salaryEmail($salaryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SALARY_EMAIL_ALIAS, "can_edit");
            if($isPermission){
                $salaryID = urlDecodes($salaryID);
                if(ctype_digit($salaryID)){
            		$data['emailSalary'] = $this->DataModel->getData('salary_id = '.$salaryID, HRM_SALARY_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['emailSalary']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);

        	        if($data['emailSalary'] != null){
        	            $employeeEmail  = $data['employeeData']['employee_email'];
        	            
        	            $employeeCreateDate  = $data['emailSalary']['employee_create_date'];
        	            $employeeCreateMonth = date("F 'y",strtotime(str_replace('/', '-', $employeeCreateDate)));
        	            $totalDays = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime(str_replace('/', '-', $data['emailSalary']['employee_create_date']))), date('Y', strtotime(str_replace('/', '-', $data['emailSalary']['employee_create_date']))));
                        
                        $weeklyOffDays = $totalDays - 24;
                        
        	            $employeeSalary = str_replace(',','', $data['employeeData']['employee_salary']);
        	            $employeeOvertime = str_replace(',','', $data['emailSalary']['employee_overtime']);
        	            $employeeBonus = str_replace(',','', $data['emailSalary']['employee_bonus']);
        	            $employeeOtherDeduction = str_replace(',','', $data['emailSalary']['employee_other_deduction']);
        	            $employeeUnpaidLeaveAmount = str_replace(',','', $data['emailSalary']['employee_unpaid_leave_amount']);
        	            $countEarnings = intval($employeeSalary) + intval($employeeOvertime) + intval($employeeBonus) - intval($employeeOtherDeduction) - intval($employeeUnpaidLeaveAmount);
        	            $totalEarnings = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $countEarnings);

        	            $employeeSalary = $data['employeeData']['employee_salary']; 
                        $myNumber = str_replace(',', '', $employeeSalary); 
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
                        $salaryWord = ($points) ? $result . "Rupees  " . $points . " Paise" : $result . "Rupees ";
                        
                        $imageData = file_get_contents(URL.'/source/images/logo-dark.png');
                        $image = 'data:image/' . ';base64,' . base64_encode($imageData);
                        
                        ob_start();
                        include('pdf.php');
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'] . '.pdf';
                        $htmlCode = '<div class="salary-slip"><table>
                        <tr>
                            <td colspan="4">
                                <span>Syphnosys Technology Private Limited</span><br>
                                <span>CIN - U72900GJ2020PTC117330</span><br>
                                <span>301, The Galleria,</span><br>
                                <span>Nr. Anupam Business Hub,</span><br>
                                <span>Yogi Chowk Road, Surat,</span><br>
                                <span>Gujarat 395010</span>
                                <span class="float-right"><img src="'.$image.'" width="130" height="40"></span>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4">
                                <span>Salary Slip</span>
                                <span class="right-content">('.$employeeCreateMonth.')</span>
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2" class="w0">Employee Name</td>
                            <td colspan="2">'.$data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'].'</td>
                        </tr>
                        <tr>
                            <td colspan="2">Employee Address</td>
                            <td colspan="2">'.$data['employeeData']['employee_correspondence_address'].'</td>
                        </tr>
                        <tr>
                            <td colspan="2">Employee ID</td>
                            <td colspan="2">'."'".''.$data['employeeData']['employee_id'].'</td>
                        </tr>
                        <tr>
                            <td colspan="2">Position</td>
                            <td colspan="2">'.$data['departmentData']['department_name'].'</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center">Payment Information</th>
                            <th colspan="2" class="text-center">Earnings</th>
                        </tr>
                        <tr>
                            <td>Working days</td>
                            <td>24</td>
                            <td>Basic</td>
                            <td>'.$data['employeeData']['employee_salary'].'</td>
                        </tr>
                        <tr>
                            <td>Weekly off</td>
                            <th>'.$weeklyOffDays.'</th>
                            <td>Overtime</td>
                            <td>'.$data['emailSalary']['employee_overtime'].'</td>
                        </tr>
                        <tr>
                            <td>Payable days</td>
                            <td>'.$data['emailSalary']['employee_payable_day'].'</td>
                            <td>Bonus</td>
                            <td>'.$data['emailSalary']['employee_bonus'].'</td>
                        </tr>
                        <tr>
                            <td>Overtime Days</td>
                            <td>0</td>
                            <td>Other Deduction</td>
                            <td>'.$data['emailSalary']['employee_other_deduction'].'</td>
                        </tr>
                        <tr>
                            <td>Leave</td>
                            <td>0</td>
                            <td>Unpaid Leave Amount</td>
                            <td>'.$data['emailSalary']['employee_unpaid_leave_amount'].'</td>
                        </tr>
                        <tr>
                            <th>Total Days</th>
                            <th>'.$totalDays.'</th>
                            <th>Total Earnings</th>
                            <th>'.$totalEarnings.'</th>
                        </tr>
                        <tr>
                            <th colspan="2">Net Salary</th>
                            <th colspan="2">'.ucfirst($salaryWord).' Only</th>
                        </tr>
                        <tr>
                            <td colspan="4"><br><br><br><br><br><br></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-center"><b>This is a computer generated statement hence does not require a signature</b></td>
                        </tr>
                        </table></div>';
                        $pdf = new Pdf();
                        ob_end_clean();
                        $pdf->load_html($htmlCode);
                        $pdf->render();
                        $file = $pdf->output();
                        file_put_contents($fileName, $file);
                        require 'class/class.phpmailer.php';
                        $mail = new PHPMailer;
                        $mail->IsSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->Port = '465';
                        $mail->SMTPAuth = true;
                        $mail->Username = USER_EMAIL;
                        $mail->Password = USER_PASSWORD; 
                        $mail->SMTPSecure = 'ssl';
                        $mail->From = USER_EMAIL;
                        $mail->FromName = USER_NAME;
                        $mail->AddAddress($employeeEmail);
                        $mail->WordWrap = 50;
                        $mail->IsHTML(true);
                        $mail->AddAttachment($fileName);
                        $mail->Subject = 'Salary Slip for '.$employeeCreateMonth;
                        $mail->Body = 'Hello,<br>Hope you are doing well!<br><br>Kindly find the attachment for the salary slip for the month of '.$employeeCreateMonth.', If there is any question/ query you can contact the HR department.';
                        $mail->Body .= '<br><br><br><br>--<br>Regards,<br>HR Manager<br>+91 99257 27373<br>Syphnosys Technology Private Limited';
                        if($mail->Send()){
                            unlink($fileName);
                            $editData = array(
                                'is_email'=>'sending'
                            );
                            $editDataEntry = $this->DataModel->editData('salary_id = '.$salaryID, HRM_SALARY_TABLE, $editData);
                            $this->session->set_userdata("session_salary_email_success","Your mail has been sent successfully!");
                            
                            $sessionSalaryViewPreviousUrl = $this->session->userdata('session_salary_view_previous_url');
                            if(!empty($sessionSalaryViewPreviousUrl)){
                                redirect($sessionSalaryViewPreviousUrl);
                            }
                        } else {
                            unlink($fileName);
                            $this->session->set_userdata('session_salary_email_error','There is error in sending mail! Please try again later');
                            
                            $sessionSalaryViewPreviousUrl = $this->session->userdata('session_salary_view_previous_url');
                            if(!empty($sessionSalaryViewPreviousUrl)){
                                redirect($sessionSalaryViewPreviousUrl);
                            }
                        }
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function salaryDetail($salaryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SALARY_ALIAS, "can_view");
            if($isPermission){
                $salaryID = urlDecodes($salaryID);
                if(ctype_digit($salaryID)){
            		$salary = $this->DataModel->viewData(null, 'salary_id = '.$salaryID, HRM_SALARY_TABLE);
        	        $data['detailSalary'] = array();
                    if(is_array($salary) || is_object($salary)){
                        foreach($salary as $Row){
                            $dataArray = array();
                            $dataArray['salary_id'] = $Row['salary_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['employee_payable_day'] = $Row['employee_payable_day'];
                            $dataArray['employee_overtime'] = $Row['employee_overtime'];
                            $dataArray['employee_bonus'] = $Row['employee_bonus'];
                            $dataArray['employee_other_deduction'] = $Row['employee_other_deduction'];
                            $dataArray['employee_unpaid_leave_amount'] = $Row['employee_unpaid_leave_amount'];
                            $dataArray['employee_create_date'] = $Row['employee_create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailSalary'], $dataArray);
                        }
                    }
                    if($data['detailSalary'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/salary/salary_detail', $data);
                		$this->load->view('footer');
            	    } else {
            	        redirect('error');
            	    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function salaryEdit($salaryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_SALARY_ALIAS, "can_edit");
            if($isPermission){
                $salaryID = urlDecodes($salaryID);
                if(ctype_digit($salaryID)){
                    $data['salaryData'] = $this->DataModel->getData('salary_id = '.$salaryID, HRM_SALARY_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['salaryData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);

                    if(!empty($data['salaryData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/salary/salary_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'employee_payable_day'=>$this->input->post('employee_payable_day'),
                            'employee_overtime'=>$this->input->post('employee_overtime'),
                            'employee_bonus'=>$this->input->post('employee_bonus'),
                            'employee_other_deduction'=>$this->input->post('employee_other_deduction'),
                            'employee_unpaid_leave_amount'=>$this->input->post('employee_unpaid_leave_amount'),
                            'employee_create_date'=>$this->input->post('employee_create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('salary_id = '.$salaryID, HRM_SALARY_TABLE, $editData);
                        if($editDataEntry){
                            $sessionSalaryViewPreviousUrl = $this->session->userdata('session_salary_view_previous_url');
                            if(!empty($sessionSalaryViewPreviousUrl)){
                                redirect($sessionSalaryViewPreviousUrl);
                            }
                        }
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function salaryTrash($salaryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $salaryID = urlDecodes($salaryID);
                    if(ctype_digit($salaryID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('salary_id = '.$salaryID, HRM_SALARY_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_salary_trash_success','Your salary has been trash successfully!');
                            $sessionSalaryViewPreviousUrl = $this->session->userdata('session_salary_view_previous_url');
                            if(!empty($sessionSalaryViewPreviousUrl)){
                                redirect($sessionSalaryViewPreviousUrl);
                            }
                        }
                    } else {
                        redirect('error');
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function salaryTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_salary_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_salary_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchSalaryTrash = $this->input->post('search_salary_trash');
                        $this->session->set_userdata('session_salary_trash', $searchSalaryTrash);
                    }
                    $sessionSalaryTrash = $this->session->userdata('session_salary_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_salary_trash_email');
                        $this->session->unset_userdata('session_salary_trash_type');
                        $this->session->unset_userdata('session_salary_trash_status');
                        redirect('view-trash-salary');
                    }
                        
                    $searchSalaryTrashEmail = $this->input->post('search_salary_trash_email');
                    if($searchSalaryTrashEmail === 'pending' or $searchSalaryTrashEmail == 'sending'){
                        $this->session->set_userdata('session_salary_trash_email', $searchSalaryTrashEmail);
                    } else if($searchSalaryTrashEmail === 'all'){
                        $this->session->unset_userdata('session_salary_trash_email');
                    }
                    $sessionSalaryTrashEmail = $this->session->userdata('session_salary_trash_email');
                    
                    $searchSalaryTrashType = $this->input->post('search_salary_trash_type');
                    if($searchSalaryTrashType === 'intern' or $searchSalaryTrashType == 'employee'){
                        $this->session->set_userdata('session_salary_trash_type', $searchSalaryTrashType);
                    } else if($searchSalaryTrashType === 'all'){
                        $this->session->unset_userdata('session_salary_trash_type');
                    }
                    $sessionSalaryTrashType = $this->session->userdata('session_salary_trash_type');
                    
                    $searchSalaryTrashStatus = $this->input->post('search_salary_trash_status');
                    if($searchSalaryTrashStatus === 'active' or $searchSalaryTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_salary_trash_status', $searchSalaryTrashStatus);
                    } else if($searchSalaryTrashStatus === 'all'){
                        $this->session->unset_userdata('session_salary_trash_status');
                    }
                    $sessionSalaryTrashStatus = $this->session->userdata('session_salary_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_salary_trash'] = $sessionSalaryTrash;
                    $conditions['search_salary_trash_email'] = $sessionSalaryTrashEmail;
                    $conditions['search_salary_trash_type'] = $sessionSalaryTrashType;
                    $conditions['search_salary_trash_status'] = $sessionSalaryTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewSalaryTrashData($conditions, HRM_SALARY_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-salary');
                    $config['uri_segment'] = 2;
                    $config['total_rows']  = $totalRec;
                    $config['per_page']    = 10;
                    
                    //styling
                    $config['num_tag_open'] = '<li class="page-item page-link">';
                    $config['num_tag_close'] = '</li>';
                    $config['cur_tag_open'] = '<li class="active page-item"><a href="javascript:void(0);" class="page-link" >';
                    $config['cur_tag_close'] = '</a></li>';
                    $config['next_link'] = '&raquo';
                    $config['prev_link'] = '&laquo';
                    $config['next_tag_open'] = '<li class="pg-next page-item page-link">';
                    $config['next_tag_close'] = '</li>';
                    $config['prev_tag_open'] = '<li class="pg-prev page-item page-link">';
                    $config['prev_tag_close'] = '</li>';
                    $config['first_tag_open'] = '<li class="page-item page-link">';
                    $config['first_tag_close'] = '</li>';
                    $config['last_tag_open'] = '<li class="page-item page-link">';
                    $config['last_tag_close'] = '</li>';
                    
                    //initialize pagination library
                    $this->pagination->initialize($config);
                    
                    //define offset
                    $page = $this->uri->segment(2);
                    $offset = !$page?0:$page;
                    
                    //get rows
                    $conditions['returnType'] = '';
                    $conditions['start'] = $offset;
                    $conditions['limit'] = 10;
                    
                    $salary = $this->DataModel->viewSalaryTrashData($conditions, HRM_SALARY_TABLE);
                    $data['countSalary'] = $this->DataModel->countSalaryTrashData($conditions, HRM_SALARY_TABLE);
        
                    $data['viewSalary'] = array();
                    if(is_array($salary) || is_object($salary)){
                        foreach($salary as $Row){
                            $dataArray = array();
                            $dataArray['salary_id'] = $Row['salary_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['employee_create_date'] = $Row['employee_create_date'];
                            $dataArray['is_email'] = $Row['is_email'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewSalary'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/salary/salary_trash_view', $data);
                    $this->load->view('footer');
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function salaryRestore($salaryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $salaryID = urlDecodes($salaryID);
                    if(ctype_digit($salaryID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('salary_id = '.$salaryID, HRM_SALARY_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_salary_restore_success','Your salary has been restore successfully!');
                            $sessionSalaryTrashViewPreviousUrl = $this->session->userdata('session_salary_trash_view_previous_url');
                            if(!empty($sessionSalaryTrashViewPreviousUrl)){
                                redirect($sessionSalaryTrashViewPreviousUrl);
                            }
                        }
                    } else {
                        redirect('error');
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function salaryDelete($salaryID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $salaryID = urlDecodes($salaryID);
                    if(ctype_digit($salaryID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('salary_id = '.$salaryID, HRM_SALARY_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_salary_delete_success','Your salary has been delete successfully!');
                                    $sessionSalaryTrashViewPreviousUrl = $this->session->userdata('session_salary_trash_view_previous_url');
                                    if(!empty($sessionSalaryTrashViewPreviousUrl)){
                                        redirect($sessionSalaryTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_salary_delete_error','Your password are not matched! Please enter correct password');
                                $sessionSalaryTrashViewPreviousUrl = $this->session->userdata('session_salary_trash_view_previous_url');
                                if(!empty($sessionSalaryTrashViewPreviousUrl)){
                                    redirect($sessionSalaryTrashViewPreviousUrl);
                                }
                            }
                        }
                    } else {
                        redirect('error');
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
}
