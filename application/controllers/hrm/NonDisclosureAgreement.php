<?php defined('BASEPATH') OR exit('No direct script access allowed');

class NonDisclosureAgreement extends CI_Controller {
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
	
    public function nonDisclosureAgreementNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/nonDisclosureAgreement/non_disclosure_agreement_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'non_disclosure_agreement_letter'=>$data['onboardingLettersData']['employee_non_disclosure_agreement_letter'],
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_NON_DISCLOSURE_AGREEMENT_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-non-disclosure-agreement');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function nonDisclosureAgreementView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_non_disclosure_agreement_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_non_disclosure_agreement');
            }
            if(isset($_POST['submit_search'])){
                $searchNonDisclosureAgreement = $this->input->post('search_non_disclosure_agreement');
                $this->session->set_userdata('session_non_disclosure_agreement', $searchNonDisclosureAgreement);
            }
            $sessionNonDisclosureAgreement = $this->session->userdata('session_non_disclosure_agreement');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_non_disclosure_agreement_type');
                $this->session->unset_userdata('session_non_disclosure_agreement_status');
                redirect('view-non-disclosure-agreement');
            }
            
            $searchNonDisclosureAgreementType = $this->input->post('search_non_disclosure_agreement_type');
            if($searchNonDisclosureAgreementType == 'intern' or $searchNonDisclosureAgreementType == 'employee'){
                $this->session->set_userdata('session_non_disclosure_agreement_type', $searchNonDisclosureAgreementType);
            } else if($searchNonDisclosureAgreementType === 'all'){
                $this->session->unset_userdata('session_non_disclosure_agreement_type');
            }
            $sessionNonDisclosureAgreementType = $this->session->userdata('session_non_disclosure_agreement_type');
            
            $searchNonDisclosureAgreementStatus = $this->input->post('search_non_disclosure_agreement_status');
            if($searchNonDisclosureAgreementStatus == 'active' or $searchNonDisclosureAgreementStatus == 'inactive'){
                $this->session->set_userdata('session_non_disclosure_agreement_status', $searchNonDisclosureAgreementStatus);
            } else if($searchNonDisclosureAgreementStatus === 'all'){
                $this->session->unset_userdata('session_non_disclosure_agreement_status');
            }
            $sessionNonDisclosureAgreementStatus = $this->session->userdata('session_non_disclosure_agreement_status');
            
            $data = array();
            //get rows count
            $conditions['search_non_disclosure_agreement'] = $sessionNonDisclosureAgreement;
            $conditions['search_non_disclosure_agreement_type'] = $sessionNonDisclosureAgreementType;
            $conditions['search_non_disclosure_agreement_status'] = $sessionNonDisclosureAgreementStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewNonDisclosureAgreementData($conditions, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-non-disclosure-agreement');
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
            
            $nonDisclosureAgreement = $this->DataModel->viewNonDisclosureAgreementData($conditions, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
            $data['countNonDisclosureAgreement'] = $this->DataModel->countNonDisclosureAgreementData($conditions, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
            $data['countNonDisclosureAgreementTrash'] = $this->DataModel->countNonDisclosureAgreementTrashData($conditions, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
            
            $data['viewNonDisclosureAgreement'] = array();
            if(is_array($nonDisclosureAgreement) || is_object($nonDisclosureAgreement)){
                foreach($nonDisclosureAgreement as $Row){
                    $dataArray = array();
                    $dataArray['employee_nda_id'] = $Row['employee_nda_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewNonDisclosureAgreement'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/nonDisclosureAgreement/non_disclosure_agreement_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function nonDisclosureAgreementDetail($employeeNdaID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_view");
            if($isPermission){
                $employeeNdaID = urlDecodes($employeeNdaID);
                if(ctype_digit($employeeNdaID)){
            		$nonDisclosureAgreement = $this->DataModel->viewData(null, 'employee_nda_id = '.$employeeNdaID, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
        	        $data['detailNonDisclosureAgreement'] = array();
                    if(is_array($nonDisclosureAgreement) || is_object($nonDisclosureAgreement)){
                        foreach($nonDisclosureAgreement as $Row){
                            $dataArray = array();
                            $dataArray['employee_nda_id'] = $Row['employee_nda_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['non_disclosure_agreement_letter'] = $Row['non_disclosure_agreement_letter'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['detailNonDisclosureAgreement'], $dataArray);
                        }
                    }
                    if($data['detailNonDisclosureAgreement'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/nonDisclosureAgreement/non_disclosure_agreement_detail', $data);
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
    
    public function nonDisclosureAgreementPdf($employeeNdaID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_view");
            if($isPermission){
                $employeeNdaID = urlDecodes($employeeNdaID);
                if(ctype_digit($employeeNdaID)){
            		$data['pdfNonDisclosureAgreement'] = $this->DataModel->getData('employee_nda_id = '.$employeeNdaID, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfNonDisclosureAgreement']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['pdfNonDisclosureAgreement'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/nonDisclosureAgreement/non_disclosure_agreement_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Non Disclosure Agreement'.'.pdf', array("Attachment"=>0));
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
    
    public function nonDisclosureAgreementEdit($employeeNdaID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_NON_DISCLOSURE_AGREEMENT_ALIAS, "can_edit");
            if($isPermission){
                $employeeNdaID = urlDecodes($employeeNdaID);
                if(ctype_digit($employeeNdaID)){
                    $data['nonDisclosureAgreementData'] = $this->DataModel->getData('employee_nda_id = '.$employeeNdaID, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['nonDisclosureAgreementData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['nonDisclosureAgreementData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/nonDisclosureAgreement/non_disclosure_agreement_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('employee_nda_id = '.$employeeNdaID, HRM_NON_DISCLOSURE_AGREEMENT_TABLE, $editData);
                        if($editDataEntry){
                            $sessionNonDisclosureAgreementViewPreviousUrl = $this->session->userdata('session_non_disclosure_agreement_view_previous_url');
                            if(!empty($sessionNonDisclosureAgreementViewPreviousUrl)){
                                redirect($sessionNonDisclosureAgreementViewPreviousUrl);
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
    
    public function nonDisclosureAgreementTrash($employeeNdaID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $employeeNdaID = urlDecodes($employeeNdaID);
                    if(ctype_digit($employeeNdaID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('employee_nda_id = '.$employeeNdaID, HRM_NON_DISCLOSURE_AGREEMENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_non_disclosure_agreement_trash_success','Your non disclosure agreement has been trash successfully!');
                            $sessionNonDisclosureAgreementViewPreviousUrl = $this->session->userdata('session_non_disclosure_agreement_view_previous_url');
                            if(!empty($sessionNonDisclosureAgreementViewPreviousUrl)){
                                redirect($sessionNonDisclosureAgreementViewPreviousUrl);
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
    
    public function nonDisclosureAgreementTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_non_disclosure_agreement_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_non_disclosure_agreement_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchNonDisclosureAgreementTrash = $this->input->post('search_non_disclosure_agreement_trash');
                        $this->session->set_userdata('session_non_disclosure_agreement_trash', $searchNonDisclosureAgreementTrash);
                    }
                    $sessionNonDisclosureAgreementTrash = $this->session->userdata('session_non_disclosure_agreement_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_non_disclosure_agreement_trash_type');
                        $this->session->unset_userdata('session_non_disclosure_agreement_trash_status');
                        redirect('view-trash-non-disclosure-agreement');
                    }
                    
                    $searchNonDisclosureAgreementTrashType = $this->input->post('search_non_disclosure_agreement_trash_type');
                    if($searchNonDisclosureAgreementTrashType == 'intern' or $searchNonDisclosureAgreementTrashType == 'employee'){
                        $this->session->set_userdata('session_non_disclosure_agreement_trash_type', $searchNonDisclosureAgreementTrashType);
                    } else if($searchNonDisclosureAgreementTrashType === 'all'){
                        $this->session->unset_userdata('session_non_disclosure_agreement_trash_type');
                    }
                    $sessionNonDisclosureAgreementTrashType = $this->session->userdata('session_non_disclosure_agreement_trash_type');
                    
                    $searchNonDisclosureAgreementTrashStatus = $this->input->post('search_non_disclosure_agreement_trash_status');
                    if($searchNonDisclosureAgreementTrashStatus == 'active' or $searchNonDisclosureAgreementTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_non_disclosure_agreement_trash_status', $searchNonDisclosureAgreementTrashStatus);
                    } else if($searchNonDisclosureAgreementTrashStatus === 'all'){
                        $this->session->unset_userdata('session_non_disclosure_agreement_trash_status');
                    }
                    $sessionNonDisclosureAgreementTrashStatus = $this->session->userdata('session_non_disclosure_agreement_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_non_disclosure_agreement_trash'] = $sessionNonDisclosureAgreementTrash;
                    $conditions['search_non_disclosure_agreement_trash_type'] = $sessionNonDisclosureAgreementTrashType;
                    $conditions['search_non_disclosure_agreement_trash_status'] = $sessionNonDisclosureAgreementTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewNonDisclosureAgreementTrashData($conditions, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-non-disclosure-agreement');
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
                    
                    $nonDisclosureAgreement = $this->DataModel->viewNonDisclosureAgreementTrashData($conditions, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
                    $data['countNonDisclosureAgreement'] = $this->DataModel->countNonDisclosureAgreementTrashData($conditions, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);

                    $data['viewNonDisclosureAgreement'] = array();
                    if(is_array($nonDisclosureAgreement) || is_object($nonDisclosureAgreement)){
                        foreach($nonDisclosureAgreement as $Row){
                            $dataArray = array();
                            $dataArray['employee_nda_id'] = $Row['employee_nda_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewNonDisclosureAgreement'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/nonDisclosureAgreement/non_disclosure_agreement_trash_view', $data);
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
    
    public function nonDisclosureAgreementRestore($employeeNdaID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $employeeNdaID = urlDecodes($employeeNdaID);
                    if(ctype_digit($employeeNdaID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('employee_nda_id = '.$employeeNdaID, HRM_NON_DISCLOSURE_AGREEMENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_non_disclosure_agreement_restore_success','Your non disclosure agreement has been restore successfully!');
                            $sessionNonDisclosureAgreementTrashViewPreviousUrl = $this->session->userdata('session_non_disclosure_agreement_trash_view_previous_url');
                            if(!empty($sessionNonDisclosureAgreementTrashViewPreviousUrl)){
                                redirect($sessionNonDisclosureAgreementTrashViewPreviousUrl);
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
    
    public function nonDisclosureAgreementDelete($employeeNdaID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $employeeNdaID = urlDecodes($employeeNdaID);
                    if(ctype_digit($employeeNdaID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('employee_nda_id = '.$employeeNdaID, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_non_disclosure_agreement_delete_success','Your non disclosure agreement has been delete successfully!');
                                    $sessionNonDisclosureAgreementTrashViewPreviousUrl = $this->session->userdata('session_non_disclosure_agreement_trash_view_previous_url');
                                    if(!empty($sessionNonDisclosureAgreementTrashViewPreviousUrl)){
                                        redirect($sessionNonDisclosureAgreementTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_non_disclosure_agreement_delete_error','Your password are not matched! Please enter correct password');
                                $sessionNonDisclosureAgreementTrashViewPreviousUrl = $this->session->userdata('session_non_disclosure_agreement_trash_view_previous_url');
                                if(!empty($sessionNonDisclosureAgreementTrashViewPreviousUrl)){
                                    redirect($sessionNonDisclosureAgreementTrashViewPreviousUrl);
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
