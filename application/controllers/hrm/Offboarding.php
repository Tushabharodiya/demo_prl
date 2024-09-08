<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Offboarding extends CI_Controller {
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
	
    public function offboardingLettersEdit($offboardingLetterID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_OFFBOARDING_LETTERS_ALIAS, "can_edit");
            if($isPermission){
                $offboardingLetterID = urlDecodes($offboardingLetterID);
                if(ctype_digit($offboardingLetterID)){
                    $data['offboardingLettersData'] = $this->DataModel->getData('offboarding_letter_id = '.$offboardingLetterID, HRM_OFFBOARDING_LETTERS_TABLE);
                    $data['param'] = $this->input->get('param');
                    if(!empty($data['offboardingLettersData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/offboarding/offboarding_letters_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        if($data['param'] == 'vvcAX9Xtq0'){
                            $editData = array(
                                'employee_no_due_certificate_letter'=>$this->input->post('employee_no_due_certificate_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('offboarding_letter_id = '.$offboardingLetterID, HRM_OFFBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-offboarding-letters/' . urlEncodes($offboardingLetterID) . '?param=vvcAX9Xtq0');
                            }
                        } else if($data['param'] == 'ZyC8C04vgG'){
                            $editData = array(
                                'employee_relieving_letter'=>$this->input->post('employee_relieving_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('offboarding_letter_id = '.$offboardingLetterID, HRM_OFFBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-offboarding-letters/' . urlEncodes($offboardingLetterID) . '?param=ZyC8C04vgG');
                            }
                        } else if($data['param'] == 'EKhMYxkeLZ'){
                            $editData = array(
                                'employee_experience_letter'=>$this->input->post('employee_experience_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('offboarding_letter_id = '.$offboardingLetterID, HRM_OFFBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-offboarding-letters/' . urlEncodes($offboardingLetterID) . '?param=EKhMYxkeLZ');
                            }
                        } else if($data['param'] == 'C1IFWYxhVw'){
                            $editData = array(
                                'employee_termination_letter'=>$this->input->post('employee_termination_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('offboarding_letter_id = '.$offboardingLetterID, HRM_OFFBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-offboarding-letters/' . urlEncodes($offboardingLetterID) . '?param=C1IFWYxhVw');
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
}