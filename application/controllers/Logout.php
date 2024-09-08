<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index(){
	    if(!empty($this->session->userdata['user_role'])){ 
            if($this->session->userdata['user_role'] == "Super"){
                $userID = $this->session->userdata['user_id'];
                $editUserMasterData = array(
        		    'user_logout' => timeZone(),
            		'is_login' => 'False',
        		);
        		$editLoginData = array(
        		    'user_logout' => timeZone(),
        		);
        		$editUserMasterDataEntry = $this->LoginModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editUserMasterData);
        		$editLoginDataEntry = $this->LoginModel->editData('user_id = '.$userID, LOGIN_DATA_TABLE, $editLoginData);
        	    $this->session->sess_destroy();
        		redirect('login'); 
            } else {
                $userID = $this->session->userdata['user_id'];
        	    $attendanceData = $this->DataModel->getData('user_id = "'.$userID.'" And working_date="'.todayDate().'"', HRM_ATTENDANCE_TABLE);
        	    if(isset($attendanceData['punch_status']) && ($attendanceData['punch_status'] == 'none' || $attendanceData['punch_status'] == 'false')){
        	        $this->session->set_userdata('session_logout_attendance_employee_dashboard_punch_out_error',"You can't logout! Please punch out attendance before logout");
        	        redirect('employee-dashboard');
        	    } else {
        	        $editUserMasterData = array(
            		    'user_logout' => timeZone(),
                		'is_login' => 'False',
            		);
            		$editLoginData = array(
            		    'user_logout' => timeZone(),
            		);
            		$editUserMasterDataEntry = $this->LoginModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editUserMasterData);
            		$editLoginDataEntry = $this->LoginModel->editData('user_id = '.$userID, LOGIN_DATA_TABLE, $editLoginData);
            	    $this->session->sess_destroy();
            		redirect('login'); 
        	    }
            }
	    } else {
            redirect('error');
        }
	}
	
	function logoutActivity(){
	    $this->session->sess_destroy();
		redirect('login'); 
		
	}
	
	public function userLogout($userID = 0){
	    $isLogin = checkAuth();
	    if($isLogin == "True"){
	        $isPermission = checkPermission(USER_LOGOUT_ALIAS, "can_edit");
            if($isPermission){
        	    $userID = urlDecodes($userID);
        	    if(ctype_digit($userID)){
        			$editUserMasterData = array(
        			    'user_logout' => timeZone(),
                		'is_login' => 'False',
        			);
        			$editLoginData = array(
        			    'user_logout' => timeZone(),
        			);
        			$editUserMasterDataEntry = $this->LoginModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editUserMasterData);
        			$editLoginDataEntry = $this->LoginModel->editData('user_id = '.$userID, LOGIN_DATA_TABLE, $editLoginData);
        			redirect('login');
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
}
