<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
    
    if(!function_exists('timeZone')){
        function timeZone(){
            date_default_timezone_set('Asia/Kolkata');
            $timestamp = date("d/m/Y h:i:s A");
            return $timestamp;
        }
    }
    
    if(!function_exists('timeStamp')){
        function timeStamp(){
            date_default_timezone_set('Asia/Kolkata');
            $timestamp = date("dmYhis");
            return $timestamp;
        }
    }
    
    if(!function_exists('todayDate')){
        function todayDate(){
            date_default_timezone_set('Asia/Kolkata');
            $todayDate = date("d/m/Y");
            return $todayDate;
        }
    }
    
    if(!function_exists('currentTime')){
        function currentTime(){
            date_default_timezone_set('Asia/Kolkata');
            $currentTime = date("H:i");
            return $currentTime;
        }
    }
    
    if(!function_exists('checkAuth')){
        function checkAuth(){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
            if(!empty($ci->session->userdata['user_key'])){ 
                if($ci->session->userdata['auth_key'] == AUTH_KEY){
                    $userKey = $ci->session->userdata['user_key'];
                    $userRole = $ci->session->userdata['user_role'];
                    if($userRole == "Super"){
                        $userData = $ci->DataModel->getData('user_key = '.$userKey, SUPER_USER_TABLE);
                    } else {
                        $userData = $ci->DataModel->getData('user_key = '.$userKey, MASTER_USER_TABLE);
                    }
                    if($userData){
                        $isLogin = $userData['is_login'];
                    } else {
                        redirect('error');
                    }
                } else {
                    redirect('error');
                }
            } else {
                redirect('error');
            }
            return $isLogin;
        }
    }
    
    if (!function_exists('urlEncodes')){
        function urlEncodes($dataID = 0){
            date_default_timezone_set("Asia/Kolkata");
            if($dataID != null){
                $uniqKey = 0710;
                $dateString = $uniqKey.''.date('iH').''.$dataID;
                $dataLength = strlen($dateString);
                $encodeArray = array();
                $arrayKey = array('0'=>'5846ca', '1'=>'c56da5', '2'=>'69adc4', '3'=>'a56f49', '4'=>'6adc26', '5'=>'5a89db', '6'=>'d5487c', '7'=>'ac56df', '8'=>'ac658c', '9'=>'75dca8');
                for($i = 0; $i < $dataLength; $i++){   
                    array_push($encodeArray, $arrayKey[$dateString[$i]]);
                }
                $encodeURL = implode("xe", $encodeArray); 
            } else {
                $encodeURL = null;
            }
            return $encodeURL;
        }
    }
    
    if(!function_exists('urlDecodes')){
        function urlDecodes($dataURL = 0){
            date_default_timezone_set("Asia/Kolkata");
            if($dataURL != null or !empty($dataURL)){
                $dataArray = explode("xe", $dataURL);
                $dataLength = count($dataArray);
                $decodeArray = array();
                $arrayKey = array('0'=>'5846ca', '1'=>'c56da5', '2'=>'69adc4', '3'=>'a56f49', '4'=>'6adc26', '5'=>'5a89db', '6'=>'d5487c', '7'=>'ac56df', '8'=>'ac658c', '9'=>'75dca8');
                for($i = 0; $i < $dataLength; $i++){   
                    $dataKey = array_search($dataArray[$i], $arrayKey);
                    array_push($decodeArray, $dataKey);
                }
                $decodeURL = substr(implode("", $decodeArray), 7);
            } else {
                $decodeURL = null;
            }
            return $decodeURL;
        }
    }
    
    if(!function_exists('checkPermission')){
        function checkPermission($dataAlias, $userRights){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
            $isLogin = checkAuth();
            if($isLogin == "True"){
                if($ci->session->userdata['user_role'] == "Super"){
                    $type = 1;
                } else {
                    $userData = $ci->DataModel->getData('user_key = '.$ci->session->userdata['user_key'], MASTER_USER_TABLE);
                    $permissionData = $ci->DataModel->getPermissionData($userData['user_id'], $dataAlias, PERMISSION_USER_TABLE);
                    if($permissionData){
                        if($userRights == "can_add"){
                            $type = $permissionData['can_add'];
                        } else if($userRights == "can_view"){
                            $type = $permissionData['can_view'];
                        } else if($userRights == "can_edit"){
                            $type = $permissionData['can_edit'];
                        } else if($userRights == "can_delete"){
                            $type = $permissionData['can_delete'];
                        } else {
                            $type = 0;
                        }
                    } else {
                        $type = 0;
                    }
                }
                return $type;
            } else {
                redirect('logout');
            }
        }
    }
    
    if(!function_exists('getconfig')){
        function getconfig(){
            $s3Client = new S3Client([
                'version' => 'latest',
                'region'  => S3_REGION,
                'credentials' => [
                    'key'    => S3_KEY,
                    'secret' => S3_SECRET
                ]            
            ]);
            return $s3Client;
        }
    }

    if(!function_exists('uniqueKey')){
        function uniqueKey(){
            date_default_timezone_set("Asia/Kolkata");
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for($i = 0; $i < 4; $i++){
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $uniqueKey =  $randomString.''.strtolower(date('dmYhis'));
            return $uniqueKey;
        }
    }
    
    if(!function_exists('newBucketObject')){
        function newKeyboardBucketObject($objectName, $objectCode, $objectTemp, $objectPath){
            $ci =& get_instance();
            $ci->load->database();
            $isLogin = checkAuth();
            if($isLogin == "True"){ 
                date_default_timezone_set("Asia/Kolkata");
                $s3Client = getconfig();
                $extObject = explode(".", $objectName);
                $newObject = end($extObject);
                $objectName = $objectCode.'.'.$newObject;
                $result = $s3Client->putObject([
                    'Bucket' => BUCKET_NAME,
                    'Key'    => $objectPath.$objectName,
                    'SourceFile' => $objectTemp,
                    'ACL'    => 'public-read', 
                ]);
                return $result->get('ObjectURL');
            } else {
                redirect('logout');
            }
        }
    }
    
    if(!function_exists('assignFillColor')){
        function assignFillColor($fillColorID){
            $fillColors = ['#798bff','#1ee0ac','#09c2de','#e85347','#816bff','#1f2b3a','#f4bd0e','#559bfb','#ff63a5','#2c3782','#6576ff','#ffa353','#20c997','#1676fb'];
            $fillColorindex = $fillColorID % count($fillColors);
            return $fillColors[$fillColorindex];
        }
    }
    
    if(!function_exists('assignDimColor')){
        function assignDimColor($dimColorID){
            $dimColors = ['primary','secondary','azure','danger','success','info','indigo','warning','blue','pink','dark','orange','teal','gray','purple'];
            $dimColorindex = $dimColorID % count($dimColors);
            return $dimColors[$dimColorindex];
        }
    }
    
    if(!function_exists('generateUniqueKey')){
        function generateUniqueKey($length = 10){
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        
            $key = '';
            $maxIndex = strlen($characters) - 1;
        
            for($i = 0; $i < $length; $i++){
                $randomIndex = mt_rand(0, $maxIndex);
                $key .= $characters[$randomIndex];
            }
            return $key;
        }
    }
    
    if(!function_exists('calculateAge')){
        function calculateAge($birthDate){
            $birthDate = DateTime::createFromFormat('d/m/Y', $birthDate)->format('Y-m-d');
            
            $birthDate = new DateTime($birthDate);
            $currentDate = new DateTime();
            
            $age = $currentDate->diff($birthDate)->y;
            
            return $age;
        }
    }
    
    if(!function_exists('startDate')){
        function startDate(){
            $startYear = date('Y');
            
            $startDateObj = new DateTime("$startYear-04-01");
            
            return $startDateObj->format('d/m/Y');
        }
    }
    
    if(!function_exists('endDate')){
        function endDate(){
            $endYear = date('Y', strtotime('+1 year'));
            
            $endDateObj = new DateTime("$endYear-04-01");
            $endDateObj->modify('-1 day');
            
            return $endDateObj->format('d/m/Y');
        }
    }
    
    if(!function_exists('calculateWorkingDays')){
        function calculateWorkingDays($month, $year){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
    
            $holiday = $ci->DataModel->viewData(null, null, HRM_HOLIDAY_TABLE);
            $holidays = array();
            foreach($holiday as $data){
                $holidays[] = $data['holiday_date'];
            }

            $currentMonth = $month;
            $currentYear = $year;
    
            $workingDays = 0;
    
            $firstDayOfMonth = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
            $lastDayOfMonth = mktime(0, 0, 0, $currentMonth + 1, 0, $currentYear);
    
            for($i = $firstDayOfMonth; $i <= $lastDayOfMonth; $i += 86400){
                $dayOfWeek = date('w', $i); 
                $dateStr = date('d/m/Y', $i); 

                if($dayOfWeek != 0 && 
                    !in_array($dateStr, $holidays) && 
                    !(date('d', $i) <= 7 && $dayOfWeek == 6) && 
                    !(date('d', $i) > 14 && date('d', $i) <= 21 && $dayOfWeek == 6)){
                    $workingDays++;
                }
            }
            return $workingDays;
        }
    }
    
    if(!function_exists('calculateWorkingDaysBetweenDates')){
        function calculateWorkingDaysBetweenDates($startDate, $endDate){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
    
            $holiday = $ci->DataModel->viewData(null, null, HRM_HOLIDAY_TABLE);
            $holidays = array();
            foreach($holiday as $data){
                $holidays[] = $data['holiday_date'];
            }
    
            $startTimestamp = strtotime(str_replace('/', '-', $startDate));
            $endTimestamp = strtotime(str_replace('/', '-', $endDate));
    
            $workingDays = 0;
    
            for($i = $startTimestamp; $i <= $endTimestamp; $i += 86400){
                $dayOfWeek = date('w', $i); 
                $dateStr = date('d/m/Y', $i); 
    
                if($dayOfWeek != 0 && 
                    !in_array($dateStr, $holidays) && 
                    !(date('d', $i) <= 7 && $dayOfWeek == 6) && 
                    !(date('d', $i) > 14 && date('d', $i) <= 21 && $dayOfWeek == 6)){
                    $workingDays++;
                }
            }
            return $workingDays;
        }
    }
    
    if(!function_exists('calculateLeaveDays')){
        function calculateLeaveDays($leaveFromDate, $leaveToDate){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
    
            $holiday = $ci->DataModel->viewData(null, null, HRM_HOLIDAY_TABLE);
            $holidays = array();
            foreach($holiday as $data){
                $holidays[] = $data['holiday_date'];
            }
    
            $fromDate = DateTime::createFromFormat('d/m/Y', $leaveFromDate);
            $toDate = DateTime::createFromFormat('d/m/Y', $leaveToDate);
    
            if($fromDate && $toDate){
                $interval = $toDate->diff($fromDate);
                $daysDiff = $interval->days + 1;
    
                $totalLeaveDays = 0;
                $date = clone $fromDate;
    
                while($date <= $toDate){
                    $day = $date->format('w'); 
                    $dateInMonth = $date->format('j'); 
    
                    if($day == 0){
                        $date->modify('+1 day');
                        continue;
                    }
    
                    if($day == 6){
                        $weekOfMonth = ceil($dateInMonth / 7);
                        if($weekOfMonth == 1 || $weekOfMonth == 3){
                            $date->modify('+1 day');
                            continue;
                        }
                    }
    
                    $dateString = $date->format('d/m/Y');
                    if(in_array($dateString, $holidays)){
                        $date->modify('+1 day');
                        continue;
                    }
    
                    $totalLeaveDays++;
                    $date->modify('+1 day');
                }
                return $totalLeaveDays;
            }
            return 0;
        }
    }

    if(!function_exists('calculateAbsentLeaveDays')){
        function calculateAbsentLeaveDays($joiningDate){
            $ci =& get_instance(); 
            $ci->load->database();
            $ci->load->model('DataModel');
    
            $startDate = startDate();
            $currentDate = date('d/m/Y');
    
            $startDate = DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $currentDate = DateTime::createFromFormat('d/m/Y', $currentDate)->format('Y-m-d');
            $joiningDate = DateTime::createFromFormat('d/m/Y', $joiningDate)->format('Y-m-d');
    
            $startDateTime = new DateTime($startDate);
            $currentDateTime = new DateTime($currentDate);
            $joiningDateTime = new DateTime($joiningDate);
            
            if($joiningDateTime > $startDateTime){
                $startDateTime = $joiningDateTime;
            }
    
            $attendance = $ci->DataModel->viewData(null, 'user_id = "' . $ci->session->userdata['user_id'] . '"', HRM_ATTENDANCE_TABLE);
            $attendanceDates = array_map(function($data){
                return DateTime::createFromFormat('d/m/Y', $data['working_date'])->format('Y-m-d');
            }, $attendance);
    
            $leaves = $ci->DataModel->viewData(null, 'user_id = "' . $ci->session->userdata['user_id'] . '" AND leave_type = "full" AND is_leave = "approved"', HRM_LEAVE_TABLE);
    
            $holidays = $ci->DataModel->viewData(null, null, HRM_HOLIDAY_TABLE);
            $holidayDates = array_map(function($data){
                return DateTime::createFromFormat('d/m/Y', $data['holiday_date'])->format('Y-m-d');
            }, $holidays);
    
            $absentDaysCount = 0;
    
            while($startDateTime <= $currentDateTime){
                $dayOfWeek = $startDateTime->format('w'); 
                $dayOfMonth = $startDateTime->format('j'); 
                $currentDateStr = $startDateTime->format('Y-m-d'); 
    
                $isInLeaveRange = false;
                foreach($leaves as $leave){
                    $leaveFromDate = DateTime::createFromFormat('d/m/Y', $leave['leave_from_date'])->format('Y-m-d');
                    $leaveToDate = DateTime::createFromFormat('d/m/Y', $leave['leave_to_date'])->format('Y-m-d');
                    
                    if($currentDateStr >= $leaveFromDate && $currentDateStr <= $leaveToDate){
                        $isInLeaveRange = true;
                        break;
                    }
                }
    
                if ($dayOfWeek != 0 && 
                    !($dayOfWeek == 6 && ($dayOfMonth <= 7 || ($dayOfMonth > 14 && $dayOfMonth <= 21))) && 
                    !in_array($currentDateStr, $attendanceDates) && 
                    !$isInLeaveRange &&
                    !in_array($currentDateStr, $holidayDates)){
                    $absentDaysCount++;
                }
                $startDateTime->modify('+1 day');
            }
            return $absentDaysCount;
        }
    }
    
    if(!function_exists('calculateAbsentLeaveDaysBetweenDates')){
        function calculateAbsentLeaveDaysBetweenDates($joiningDate, $startDate, $currentDate, $userID){
            $ci =& get_instance(); 
            $ci->load->database();
            $ci->load->model('DataModel');
    
            $startDate = DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $currentDate = DateTime::createFromFormat('d/m/Y', $currentDate)->format('Y-m-d');
            $joiningDate = DateTime::createFromFormat('d/m/Y', $joiningDate)->format('Y-m-d');
    
            $startDateTime = new DateTime($startDate);
            $currentDateTime = new DateTime($currentDate);
            $joiningDateTime = new DateTime($joiningDate);
            
            if($joiningDateTime > $startDateTime){
                $startDateTime = $joiningDateTime;
            }
    
            $attendance = $ci->DataModel->viewData(null, 'user_id = "' . $userID . '"', HRM_ATTENDANCE_TABLE);
            $attendanceDates = array_map(function($data){
                return DateTime::createFromFormat('d/m/Y', $data['working_date'])->format('Y-m-d');
            }, $attendance);
    
            $leaves = $ci->DataModel->viewData(null, 'user_id = "' . $userID . '" AND leave_type = "full" AND is_leave = "approved"', HRM_LEAVE_TABLE);
    
            $holidays = $ci->DataModel->viewData(null, null, HRM_HOLIDAY_TABLE);
            $holidayDates = array_map(function($data){
                return DateTime::createFromFormat('d/m/Y', $data['holiday_date'])->format('Y-m-d');
            }, $holidays);
    
            $absentDaysCount = 0;
    
            while($startDateTime <= $currentDateTime){
                $dayOfWeek = $startDateTime->format('w'); 
                $dayOfMonth = $startDateTime->format('j'); 
                $currentDateStr = $startDateTime->format('Y-m-d'); 
    
                $isInLeaveRange = false;
                foreach($leaves as $leave){
                    $leaveFromDate = DateTime::createFromFormat('d/m/Y', $leave['leave_from_date'])->format('Y-m-d');
                    $leaveToDate = DateTime::createFromFormat('d/m/Y', $leave['leave_to_date'])->format('Y-m-d');
                    
                    if($currentDateStr >= $leaveFromDate && $currentDateStr <= $leaveToDate){
                        $isInLeaveRange = true;
                        break;
                    }
                }
    
                if ($dayOfWeek != 0 && 
                    !($dayOfWeek == 6 && ($dayOfMonth <= 7 || ($dayOfMonth > 14 && $dayOfMonth <= 21))) && 
                    !in_array($currentDateStr, $attendanceDates) && 
                    !$isInLeaveRange &&
                    !in_array($currentDateStr, $holidayDates)){
                    $absentDaysCount++;
                }
                $startDateTime->modify('+1 day');
            }
            return $absentDaysCount;
        }
    }
    
    if(!function_exists('calculateBalanceLeaveDays')){
        function calculateBalanceLeaveDays($joiningDate, $leavingDate){
            $ci = &get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
    
            $startYear = date('Y');
            $endYear = date('Y', strtotime('+1 year'));
            $startDateObj = new DateTime("$startYear-04-01");
            $endDateObj = new DateTime("$endYear-04-01");
            $endDateObj->modify('-1 day');
    
            $todayDateObj = new DateTime('today');
            $todayYear = $todayDateObj->format('Y');
            $todayMonth = $todayDateObj->format('m');
    
            $currentMonthEndDateObj = new DateTime("$todayYear-$todayMonth-01");
            $currentMonthEndDateObj->modify('last day of this month');
            if($currentMonthEndDateObj > $endDateObj){
                $currentMonthEndDateObj = $endDateObj;
            }
    
            $joiningDateObj = DateTime::createFromFormat('d/m/Y', $joiningDate);
            if(!$joiningDateObj){
                return 0; 
            }
    
            if(!empty($leavingDate)){
                $leavingDateObj = DateTime::createFromFormat('d/m/Y', $leavingDate);
                if($leavingDateObj->format('m') == $todayMonth){
                    $attendance = $ci->DataModel->countData('user_id = "' . $ci->session->userdata['user_id'] . '" AND MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "' . $todayMonth . '" AND YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "' . $todayYear . '"', HRM_ATTENDANCE_TABLE);
    
                    if($attendance >= 19){
                        return calculateMonths($joiningDateObj, $currentMonthEndDateObj, $startDateObj, $endDateObj, true);
                    } else {
                        return calculateMonths($joiningDateObj, $currentMonthEndDateObj, $startDateObj, $endDateObj, false);
                    }
                }
            }
            return calculateMonths($joiningDateObj, $currentMonthEndDateObj, $startDateObj, $endDateObj, true);
        }
    
        function calculateMonths($joiningDateObj, $currentMonthEndDateObj, $startDateObj, $endDateObj, $addExtraMonth){
            if($joiningDateObj >= $startDateObj && $joiningDateObj <= $endDateObj){
                if($joiningDateObj->format('d') < 11){
                    $interval = $joiningDateObj->diff($currentMonthEndDateObj);
                    $totalMonths = ($interval->y * 12) + $interval->m + ($addExtraMonth ? 1 : 0);
                } else {
                    $interval = $joiningDateObj->diff($currentMonthEndDateObj);
                    $totalMonths = ($interval->y * 12) + $interval->m + ($addExtraMonth ? 0 : -1);
                }
            } else {
                $interval = $startDateObj->diff($currentMonthEndDateObj);
                $totalMonths = ($interval->y * 12) + $interval->m + ($addExtraMonth ? 1 : 0);
            }
            return $totalMonths;
        }
    }
    
    if(!function_exists('calculateBalanceLeaveDaysBetweenDates')){
        function calculateBalanceLeaveDaysBetweenDates($joiningDate, $leavingDate, $startDateFilter, $endDateFilter, $userID){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
    
            $startDateObj = DateTime::createFromFormat('d/m/Y', $startDateFilter);
            $endDateObj = DateTime::createFromFormat('d/m/Y', $endDateFilter);
            
            $todayDateObj = new DateTime('today');
            $todayYear = $todayDateObj->format('Y');
            $todayMonth = $todayDateObj->format('m');
            
            if(!empty($leavingDate)){
                $leavingDateObj = DateTime::createFromFormat('d/m/Y', $leavingDate);
                $leavingMonth = $leavingDateObj->format('m');
    
                if($leavingMonth == $todayMonth){
                    $attendance = $ci->DataModel->countData('user_id = "' . $userID . '" AND MONTH(STR_TO_DATE(working_date, "%d/%m/%Y")) = "' . date('m') . '" AND YEAR(STR_TO_DATE(working_date, "%d/%m/%Y")) = "' . date('Y') . '"', HRM_ATTENDANCE_TABLE);
    
                    if($attendance >= 19){
                        return calculateMonthsBetweenDates($joiningDate, $startDateObj, $endDateObj, $todayYear, $todayMonth, $endDateObj);
                    } else {
                        return calculateMonthsBetweenDates($joiningDate, $startDateObj, $endDateObj, $todayYear, $todayMonth, $endDateObj, false);
                    }
                } else {
                    return calculateMonthsBetweenDates($joiningDate, $startDateObj, $endDateObj, $todayYear, $todayMonth, $endDateObj);
                }
            } else {
                return calculateMonthsBetweenDates($joiningDate, $startDateObj, $endDateObj, $todayYear, $todayMonth, $endDateObj);
            }
        }
    
        function calculateMonthsBetweenDates($joiningDate, $startDateObj, $endDateObj, $todayYear, $todayMonth, $endDateObjLocal, $addMonth = true){
            $joiningDateObj = DateTime::createFromFormat('d/m/Y', $joiningDate);
            
            $currentMonthEndDateObj = new DateTime("$todayYear-$todayMonth-01");
            $currentMonthEndDateObj->modify('last day of this month');
    
            if($currentMonthEndDateObj > $endDateObjLocal){
                $currentMonthEndDateObj = $endDateObjLocal; 
            }
    
            if($joiningDateObj >= $startDateObj && $joiningDateObj <= $endDateObjLocal){
                if($joiningDateObj->format('d') < 11){
                    $interval = $joiningDateObj->diff($currentMonthEndDateObj);
                    $totalMonths = ($interval->y * 12) + $interval->m + ($addMonth ? 1 : 0); 
                } else {
                    $interval = $joiningDateObj->diff($currentMonthEndDateObj);
                    $totalMonths = ($interval->y * 12) + $interval->m - ($addMonth ? 0 : 1); 
                }
            } else {
                $interval = $startDateObj->diff($currentMonthEndDateObj);
                $totalMonths = ($interval->y * 12) + $interval->m + ($addMonth ? 1 : 0); 
            }
            return $totalMonths;
        }
    }

    if(!function_exists('calculateUpcomingBirthday')){
        function calculateUpcomingBirthday(){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
            
            $currentDate = date('d/m/Y');
            $currentDateObj = DateTime::createFromFormat('d/m/Y', $currentDate);
            
            $birthDateObj = clone $currentDateObj;
            $birthDateObj->modify('+15 days');
            
            $startDate = $currentDateObj->format('d/m/Y');
            $endDate = $birthDateObj->format('d/m/Y');
            
            $startDayMonth = DateTime::createFromFormat('d/m/Y', $startDate)->format('m-d');
            $endDayMonth = DateTime::createFromFormat('d/m/Y', $endDate)->format('m-d');

            $employee = $ci->DataModel->viewData('employee_birth_date '.'DESC', 'employee_status = "active" AND is_employee = "selected" AND ' . "DATE_FORMAT(STR_TO_DATE(employee_birth_date, '%d/%m/%Y'), '%m-%d') BETWEEN '$startDayMonth' AND '$endDayMonth'", HRM_EMPLOYEE_TABLE);
            return $employee;
        }
    }
    
    if(!function_exists('viewUpcomingWorkAnniversary')){
        function viewUpcomingWorkAnniversary(){
            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('DataModel');
            
            $currentDate = date('d/m/Y');
            $currentDateObj = DateTime::createFromFormat('d/m/Y', $currentDate);
            
            $contractDateObj = clone $currentDateObj;
            $contractDateObj->modify('+15 days');
            
            $startDate = $currentDateObj->format('d/m/Y');
            $endDate = $contractDateObj->format('d/m/Y');
            
            $startDayMonth = DateTime::createFromFormat('d/m/Y', $startDate)->format('m-d');
            $endDayMonth = DateTime::createFromFormat('d/m/Y', $endDate)->format('m-d');

            $employee = $ci->DataModel->viewData('employee_contract_date '.'DESC', 'employee_status = "active" AND is_employee = "selected" AND ' . "DATE_FORMAT(STR_TO_DATE(employee_contract_date, '%d/%m/%Y'), '%m-%d') BETWEEN '$startDayMonth' AND '$endDayMonth'", HRM_EMPLOYEE_TABLE);
            return $employee;
        }
    }