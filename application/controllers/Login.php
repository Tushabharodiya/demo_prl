<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
	} 

	public function index(){ 
	    $this->session->set_userdata('theme_mode', "light");
	    
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|max_length[50]');
		$this->form_validation->set_rules('user_password', 'Password', 'trim|required|max_length[20]');
		$this->form_validation->set_error_delimiters('','');
	
		if ($this->form_validation->run() == FALSE){
			$data['error'] = "";
			$this->load->view('login', $data);                        
		} else {
			$userData = array(
				'user_email' => $this->input->post('user_email'),
				'user_password' => md5($this->input->post('user_password'))
			);
			$superUser = $this->LoginModel->checkLogin(SUPER_USER_TABLE, $userData);
			$masterUser = $this->LoginModel->checkLogin(MASTER_USER_TABLE, $userData);
			if($superUser){
				$sessionData = array(
					'user_id' => $superUser['user_id'],
					'user_name' => $superUser['user_name'],
					'user_email' => $superUser['user_email'],
					'user_role' => $superUser['user_role'],
					'user_key' => $superUser['user_key'],
					'user_login' => $superUser['user_login'],
					'is_login' => $superUser['is_login'],
					'user_status' => $superUser['user_status'],
					'panelLog' => 'FALSE',
				);
				$this->session->set_userdata($sessionData);
				redirect('confirmOTP');
			} else if ($masterUser){
			    $IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
			    $ipData = $this->LoginModel->checkIP($IP_ADDRESS, IP_TABLE);
			    if(!empty($ipData)){
			        date_default_timezone_set('Asia/Kolkata'); 
			        $currentTime = date('H:i');
    			    $startTime = $ipData['data_start_time'];
    			    $endTime = $ipData['data_end_time'];
    			    if($currentTime >= $startTime && $currentTime <= $endTime){
    			        $sessionData = array(
        					'user_id' => $masterUser['user_id'],
        					'employee_id' => $masterUser['employee_id'],
        					'user_name' => $masterUser['user_name'],
        					'user_email' => $masterUser['user_email'],
        					'user_role' => $masterUser['user_role'],
        					'user_login' => $masterUser['user_login'],
        					'is_login' => $masterUser['is_login'],
        					'user_status' => $masterUser['user_status'],
        					'user_key' => $masterUser['user_key'],
        					'panelLog' => 'FALSE',
        					'current_date' => todayDate(),
        				);
        				$this->session->set_userdata($sessionData);
        				redirect('confirmOTP');
    			    } else {
    			        redirect('time-denied');
    			    }
			    } else {
			        redirect('ip-denied');
			    }
			} else {
				$errordata['error'] = "Incorrect email or password";
				$this->load->view('login',$errordata);
			}
		}
	}
	
	public function confirmOTP(){ 
		if($this->session->userdata['user_role'] == "Super"){
			$confirmOTP = $this->input->post('confirm_otp');
			if($confirmOTP == OTP){
				$sessionData = array(
	    			'panelLog' => 'TRUE',
	    			'auth_key' => AUTH_KEY
				);
				$userID = $this->session->userdata['user_id'];
				$userRole = $this->session->userdata['user_role'];
				$editData = array(
					'user_login'  => timeZone(),
					'is_login' => 'True'
				);
				$isLogin = $this->LoginModel->editData('user_id = '.$userID, SUPER_USER_TABLE, $editData);
				if($isLogin){
					$this->session->set_userdata($sessionData);
					$newData = array(
                        'user_id' => $this->session->userdata['user_id'],
					    'user_name' => $this->session->userdata['user_name'],
					    'user_email' => $this->session->userdata['user_email'],
					    'user_role' => $this->session->userdata['user_role'],
					    'user_key' => $this->session->userdata['user_key'],
					    'user_login' => timeZone(),
					    'user_logout' => '-',
					    'user_agenet' => $_SERVER['HTTP_USER_AGENT'],
					    'user_ip' => $_SERVER['REMOTE_ADDR'],
					    'user_status' => $this->session->userdata['user_status'],
					    'trash_status'=>'false',
                    );
                    $newDataEntry = $this->LoginModel->insertData(LOGIN_DATA_TABLE, $newData);
                    if($newDataEntry){
                        redirect('dashboard');  
                    }
				}
			} else {
				redirect('login');
			}
		} else {
			$confirmOTP = $this->input->post('confirm_otp');
			if($confirmOTP == OTP){
				$sessionData = array(
	    			'panelLog' => 'TRUE',
	    			'auth_key' => AUTH_KEY
				);
				$userID = $this->session->userdata['user_id'];
				$userRole = $this->session->userdata['user_role'];
				$editData = array(
					'user_login' => timeZone(),
					'user_logout' => '-',
					'is_login' => 'True',
					'login_ip' => $_SERVER['REMOTE_ADDR']
				);
				$isLogin = $this->LoginModel->editData('user_id = '.$userID, MASTER_USER_TABLE, $editData);
				if($isLogin){
				    $this->session->set_userdata($sessionData);
					$newData = array(
                        'user_id' => $this->session->userdata['user_id'],
					    'user_name' => $this->session->userdata['user_name'],
					    'user_email' => $this->session->userdata['user_email'],
					    'user_role' => $this->session->userdata['user_role'],
					    'user_key' => $this->session->userdata['user_key'],
					    'user_login' => timeZone(),
					    'user_logout' => '-',
					    'user_agenet' => $_SERVER['HTTP_USER_AGENT'],
					    'user_ip' => $_SERVER['REMOTE_ADDR'],
					    'user_status' => $this->session->userdata['user_status'],
					    'trash_status'=>'false',
                    );
                    $newDataEntry = $this->LoginModel->insertData(LOGIN_DATA_TABLE, $newData);
                    if($newDataEntry){
                        redirect('employee-dashboard');  
                    }
				}
			} else {
				redirect('login');
			}
		}
	}
}
