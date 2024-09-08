<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Onboarding extends CI_Controller {
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
	
	public function onboardingLettersEdit($onboardingLetterID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_ONBOARDING_LETTERS_ALIAS, "can_edit");
            if($isPermission){
                $onboardingLetterID = urlDecodes($onboardingLetterID);
                if(ctype_digit($onboardingLetterID)){
                    $data['onboardingLettersData'] = $this->DataModel->getData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE);
                    $data['param'] = $this->input->get('param');
                    if(!empty($data['onboardingLettersData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/onboarding/onboarding_letters_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        if($data['param'] == 'w1X1ASLRj6'){
                            $editData = array(
                                'intern_offer_letter'=>$this->input->post('intern_offer_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=w1X1ASLRj6');
                            }
                        } else if($data['param'] == 'mpoUzGzAhJ'){
                            $editData = array(
                                'internship_certificate_letter'=>$this->input->post('internship_certificate_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=mpoUzGzAhJ');
                            }
                        } else if($data['param'] == 'CPym8M3Utz'){
                            $editData = array(
                                'employee_offer_letter'=>$this->input->post('employee_offer_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=CPym8M3Utz');
                            }
                        } else if($data['param'] == 'uc5E51X0JI'){
                            $editData = array(
                                'employee_appraisal_certificate_letter'=>$this->input->post('employee_appraisal_certificate_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=uc5E51X0JI');
                            }
                        } else if($data['param'] == 'wNVjmEb8uc'){
                            $editData = array(
                                'employee_warning_letter'=>$this->input->post('employee_warning_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=wNVjmEb8uc');
                            }
                        } else if($data['param'] == '9L6yXxjDwb'){
                            $editData = array(
                                'employee_appointment_letter'=>$this->input->post('employee_appointment_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=9L6yXxjDwb');
                            }
                        } else if($data['param'] == 'pBDy29Uv91'){
                            $editData = array(
                                'employee_hr_policy_letter'=>$this->input->post('employee_hr_policy_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=pBDy29Uv91');
                            }
                        } else if($data['param'] == 'eUu1LYeZvN'){
                            $editData = array(
                                'employee_declaration_letter'=>$this->input->post('employee_declaration_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=eUu1LYeZvN');
                            }
                        } else if($data['param'] == 'YslfKa8v2R'){
                            $editData = array(
                                'employee_consent_letter'=>$this->input->post('employee_consent_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=YslfKa8v2R');
                            }
                        } else if($data['param'] == 'xrIeDIEHW7'){
                            $editData = array(
                                'employee_non_disclosure_agreement_letter'=>$this->input->post('employee_non_disclosure_agreement_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=xrIeDIEHW7');
                            }
                        } else if($data['param'] == 'Z9oA8eqyI3'){
                            $editData = array(
                                'employee_service_agreement_letter'=>$this->input->post('employee_service_agreement_letter')
                            );
                            $editDataEntry = $this->DataModel->editData('onboarding_letter_id = '.$onboardingLetterID, HRM_ONBOARDING_LETTERS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('edit-onboarding-letters/' . urlEncodes($onboardingLetterID) . '?param=Z9oA8eqyI3');
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