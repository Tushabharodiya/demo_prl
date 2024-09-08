<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Consent extends CI_Controller {
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
	
    public function consentNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_CONSENT_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active" AND employee_consent_name != " "', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/consent/consent_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'consent_letter'=>$data['onboardingLettersData']['employee_consent_letter'],
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_CONSENT_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-consent');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function consentView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            
            $this->session->set_userdata('session_consent_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_consent');
            }
            if(isset($_POST['submit_search'])){
                $searchConsent = $this->input->post('search_consent');
                $this->session->set_userdata('session_consent', $searchConsent);
            }
            $sessionConsent = $this->session->userdata('session_consent');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_consent_status');
                redirect('view-consent');
            }

            $searchConsentStatus = $this->input->post('search_consent_status');
            if($searchConsentStatus == 'active' or $searchConsentStatus == 'inactive'){
                $this->session->set_userdata('session_consent_status', $searchConsentStatus);
            } else if($searchConsentStatus === 'all'){
                $this->session->unset_userdata('session_consent_status');
            }
            $sessionConsentStatus = $this->session->userdata('session_consent_status');
            
            $data = array();
            //get rows count
            $conditions['search_consent'] = $sessionConsent;
            $conditions['search_consent_status'] = $sessionConsentStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewConsentData($conditions, HRM_CONSENT_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-consent');
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
            
            $consent = $this->DataModel->viewConsentData($conditions, HRM_CONSENT_TABLE);
            $data['countConsent'] = $this->DataModel->countConsentData($conditions, HRM_CONSENT_TABLE);
            $data['countConsentTrash'] = $this->DataModel->countConsentTrashData($conditions, HRM_CONSENT_TABLE);
            
            $data['viewConsent'] = array();
            if(is_array($consent) || is_object($consent)){
                foreach($consent as $Row){
                    $dataArray = array();
                    $dataArray['consent_id'] = $Row['consent_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    array_push($data['viewConsent'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/consent/consent_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function consentDetail($consentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_CONSENT_ALIAS, "can_view");
            if($isPermission){
                $consentID = urlDecodes($consentID);
                if(ctype_digit($consentID)){
            		$consent = $this->DataModel->viewData(null, 'consent_id = '.$consentID, HRM_CONSENT_TABLE);
        	        $data['detailConsent'] = array();
                    if(is_array($consent) || is_object($consent)){
                        foreach($consent as $Row){
                            $dataArray = array();
                            $dataArray['consent_id'] = $Row['consent_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['consent_letter'] = $Row['consent_letter'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['detailConsent'], $dataArray);
                        }
                    }
                    if($data['detailConsent'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/consent/consent_detail', $data);
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
    
    public function consentPdf($consentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_CONSENT_ALIAS, "can_view");
            if($isPermission){
                $consentID = urlDecodes($consentID);
                if(ctype_digit($consentID)){
            		$data['pdfConsent'] = $this->DataModel->getData('consent_id = '.$consentID, HRM_CONSENT_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfConsent']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
        	        if($data['pdfConsent'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/consent/consent_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Consent Letter'.'.pdf', array("Attachment"=>0));
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
    
    public function consentEdit($consentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_CONSENT_ALIAS, "can_edit");
            if($isPermission){
                $consentID = urlDecodes($consentID);
                if(ctype_digit($consentID)){
                    $data['consentData'] = $this->DataModel->getData('consent_id = '.$consentID, HRM_CONSENT_TABLE);
                    
                	$data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active" AND employee_consent_name != " "', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['consentData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['consentData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/consent/consent_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('consent_id = '.$consentID, HRM_CONSENT_TABLE, $editData);
                        if($editDataEntry){
                            $sessionConsentViewPreviousUrl = $this->session->userdata('session_consent_view_previous_url');
                            if(!empty($sessionConsentViewPreviousUrl)){
                                redirect($sessionConsentViewPreviousUrl);
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
    
    public function consentTrash($consentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $consentID = urlDecodes($consentID);
                    if(ctype_digit($consentID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('consent_id = '.$consentID, HRM_CONSENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_consent_trash_success','Your consent has been trash successfully!');
                            $sessionConsentViewPreviousUrl = $this->session->userdata('session_consent_view_previous_url');
                            if(!empty($sessionConsentViewPreviousUrl)){
                                redirect($sessionConsentViewPreviousUrl);
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
    
    public function consentTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
            
                    $this->session->set_userdata('session_consent_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_consent_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchConsentTrash = $this->input->post('search_consent_trash');
                        $this->session->set_userdata('session_consent_trash', $searchConsentTrash);
                    }
                    $sessionConsentTrash = $this->session->userdata('session_consent_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_consent_trash_status');
                        redirect('view-trash-concent');
                    }
        
                    $searchConsentTrashStatus = $this->input->post('search_consent_trash_status');
                    if($searchConsentTrashStatus == 'active' or $searchConsentTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_consent_trash_status', $searchConsentTrashStatus);
                    } else if($searchConsentTrashStatus === 'all'){
                        $this->session->unset_userdata('session_consent_trash_status');
                    }
                    $sessionConsentTrashStatus = $this->session->userdata('session_consent_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_consent_trash'] = $sessionConsentTrash;
                    $conditions['search_consent_trash_status'] = $sessionConsentTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewConsentTrashData($conditions, HRM_CONSENT_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-consent');
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
                    
                    $consent = $this->DataModel->viewConsentTrashData($conditions, HRM_CONSENT_TABLE);
                    $data['countConsent'] = $this->DataModel->countConsentTrashData($conditions, HRM_CONSENT_TABLE);

                    $data['viewConsent'] = array();
                    if(is_array($consent) || is_object($consent)){
                        foreach($consent as $Row){
                            $dataArray = array();
                            $dataArray['consent_id'] = $Row['consent_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['viewConsent'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/consent/consent_trash_view', $data);
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
    
    public function consentRestore($consentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $consentID = urlDecodes($consentID);
                    if(ctype_digit($consentID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('consent_id = '.$consentID, HRM_CONSENT_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_consent_restore_success','Your consent has been restore successfully!');
                            $sessionConsentTrashViewPreviousUrl = $this->session->userdata('session_consent_trash_view_previous_url');
                            if(!empty($sessionConsentTrashViewPreviousUrl)){
                                redirect($sessionConsentTrashViewPreviousUrl);
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
    
    public function consentDelete($consentID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $consentID = urlDecodes($consentID);
                    if(ctype_digit($consentID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('consent_id = '.$consentID, HRM_CONSENT_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_consent_delete_success','Your consent has been delete successfully!');
                                    $sessionConsentTrashViewPreviousUrl = $this->session->userdata('session_consent_trash_view_previous_url');
                                    if(!empty($sessionConsentTrashViewPreviousUrl)){
                                        redirect($sessionConsentTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_consent_delete_error','Your password are not matched! Please enter correct password');
                                $sessionConsentTrashViewPreviousUrl = $this->session->userdata('session_consent_trash_view_previous_url');
                                if(!empty($sessionConsentTrashViewPreviousUrl)){
                                    redirect($sessionConsentTrashViewPreviousUrl);
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
