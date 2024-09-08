<?php defined('BASEPATH') OR exit('No direct script access allowed');

class HrPolicy extends CI_Controller {
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
	
    public function hrPolicyNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_HR_POLICY_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/hrPolicy/hr_policy_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'hr_policy_letter'=>$data['onboardingLettersData']['employee_hr_policy_letter'],
                        'effective_date'=>$this->input->post('effective_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_HR_POLICY_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-hr-policy');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function hrPolicyView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_hr_policy_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_hr_policy');
            }
            if(isset($_POST['submit_search'])){
                $searchHrPolicy = $this->input->post('search_hr_policy');
                $this->session->set_userdata('session_hr_policy', $searchHrPolicy);
            }
            $sessionHrPolicy = $this->session->userdata('session_hr_policy');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_hr_policy_type');
                $this->session->unset_userdata('session_hr_policy_status');
                redirect('view-hr-policy');
            }
            
            $searchHrPolicyType = $this->input->post('search_hr_policy_type');
            if($searchHrPolicyType == 'intern' or $searchHrPolicyType == 'employee'){
                $this->session->set_userdata('session_hr_policy_type', $searchHrPolicyType);
            } else if($searchHrPolicyType === 'all'){
                $this->session->unset_userdata('session_hr_policy_type');
            }
            $sessionHrPolicyType = $this->session->userdata('session_hr_policy_type');
            
            $searchHrPolicyStatus = $this->input->post('search_hr_policy_status');
            if($searchHrPolicyStatus == 'active' or $searchHrPolicyStatus == 'inactive'){
                $this->session->set_userdata('session_hr_policy_status', $searchHrPolicyStatus);
            } else if($searchHrPolicyStatus === 'all'){
                $this->session->unset_userdata('session_hr_policy_status');
            }
            $sessionHrPolicyStatus = $this->session->userdata('session_hr_policy_status');
            
            $data = array();
            //get rows count
            $conditions['search_hr_policy'] = $sessionHrPolicy;
            $conditions['search_hr_policy_type'] = $sessionHrPolicyType;
            $conditions['search_hr_policy_status'] = $sessionHrPolicyStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewHrPolicyData($conditions, HRM_HR_POLICY_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-hr-policy');
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
            
            $hrPolicy = $this->DataModel->viewHrPolicyData($conditions, HRM_HR_POLICY_TABLE);
            $data['countHrPolicy'] = $this->DataModel->countHrPolicyData($conditions, HRM_HR_POLICY_TABLE);
            $data['countHrPolicyTrash'] = $this->DataModel->countHrPolicyTrashData($conditions, HRM_HR_POLICY_TABLE);
            
            $data['viewHrPolicy'] = array();
            if(is_array($hrPolicy) || is_object($hrPolicy)){
                foreach($hrPolicy as $Row){
                    $dataArray = array();
                    $dataArray['hr_policy_id'] = $Row['hr_policy_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['effective_date'] = $Row['effective_date'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    array_push($data['viewHrPolicy'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/hrPolicy/hr_policy_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function hrPolicyDetail($hrPolicyID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_HR_POLICY_ALIAS, "can_view");
            if($isPermission){
                $hrPolicyID = urlDecodes($hrPolicyID);
                if(ctype_digit($hrPolicyID)){
            		$hrPolicy = $this->DataModel->viewData(null, 'hr_policy_id = '.$hrPolicyID, HRM_HR_POLICY_TABLE);
        	        $data['detailHrPolicy'] = array();
                    if(is_array($hrPolicy) || is_object($hrPolicy)){
                        foreach($hrPolicy as $Row){
                            $dataArray = array();
                            $dataArray['hr_policy_id'] = $Row['hr_policy_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['hr_policy_letter'] = $Row['hr_policy_letter'];
                            $dataArray['effective_date'] = $Row['effective_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['detailHrPolicy'], $dataArray);
                        }
                    }
                    if($data['detailHrPolicy'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/hrPolicy/hr_policy_detail', $data);
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
    
    public function hrPolicyPdf($hrPolicyID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_HR_POLICY_ALIAS, "can_view");
            if($isPermission){
                $hrPolicyID = urlDecodes($hrPolicyID);
                if(ctype_digit($hrPolicyID)){
            		$data['pdfHrPolicy'] = $this->DataModel->getData('hr_policy_id = '.$hrPolicyID, HRM_HR_POLICY_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfHrPolicy']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
        	        if($data['pdfHrPolicy'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/hrPolicy/hr_policy_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - HR POLICY'.'.pdf', array("Attachment"=>0));
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
    
    public function hrPolicyEdit($hrPolicyID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_HR_POLICY_ALIAS, "can_edit");
            if($isPermission){
                $hrPolicyID = urlDecodes($hrPolicyID);
                if(ctype_digit($hrPolicyID)){
                    $data['hrPolicyData'] = $this->DataModel->getData('hr_policy_id = '.$hrPolicyID, HRM_HR_POLICY_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['hrPolicyData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['hrPolicyData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/hrPolicy/hr_policy_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'effective_date'=>$this->input->post('effective_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('hr_policy_id = '.$hrPolicyID, HRM_HR_POLICY_TABLE, $editData);
                        if($editDataEntry){
                            $sessionHrPolicyViewPreviousUrl = $this->session->userdata('session_hr_policy_view_previous_url');
                            if(!empty($sessionHrPolicyViewPreviousUrl)){
                                redirect($sessionHrPolicyViewPreviousUrl);
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
    
    public function hrPolicyTrash($hrPolicyID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $hrPolicyID = urlDecodes($hrPolicyID);
                    if(ctype_digit($hrPolicyID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('hr_policy_id = '.$hrPolicyID, HRM_HR_POLICY_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_hr_policy_trash_success','Your hr policy has been trash successfully!');
                            $sessionHrPolicyViewPreviousUrl = $this->session->userdata('session_hr_policy_view_previous_url');
                            if(!empty($sessionHrPolicyViewPreviousUrl)){
                                redirect($sessionHrPolicyViewPreviousUrl);
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
    
    public function hrPolicyTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_hr_policy_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_hr_policy_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchHrPolicyTrash = $this->input->post('search_hr_policy_trash');
                        $this->session->set_userdata('session_hr_policy_trash', $searchHrPolicyTrash);
                    }
                    $sessionHrPolicyTrash = $this->session->userdata('session_hr_policy_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_hr_policy_trash_type');
                        $this->session->unset_userdata('session_hr_policy_trash_status');
                        redirect('view-trash-hr-policy');
                    }
                    
                    $searchHrPolicyTrashType = $this->input->post('search_hr_policy_trash_type');
                    if($searchHrPolicyTrashType == 'intern' or $searchHrPolicyTrashType == 'employee'){
                        $this->session->set_userdata('session_hr_policy_trash_type', $searchHrPolicyTrashType);
                    } else if($searchHrPolicyTrashType === 'all'){
                        $this->session->unset_userdata('session_hr_policy_trash_type');
                    }
                    $sessionHrPolicyTrashType = $this->session->userdata('session_hr_policy_trash_type');
                    
                    $searchHrPolicyTrashStatus = $this->input->post('search_hr_policy_trash_status');
                    if($searchHrPolicyTrashStatus == 'active' or $searchHrPolicyTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_hr_policy_trash_status', $searchHrPolicyTrashStatus);
                    } else if($searchHrPolicyTrashStatus === 'all'){
                        $this->session->unset_userdata('session_hr_policy_trash_status');
                    }
                    $sessionHrPolicyTrashStatus = $this->session->userdata('session_hr_policy_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_hr_policy_trash'] = $sessionHrPolicyTrash;
                    $conditions['search_hr_policy_trash_type'] = $sessionHrPolicyTrashType;
                    $conditions['search_hr_policy_trash_status'] = $sessionHrPolicyTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewHrPolicyTrashData($conditions, HRM_HR_POLICY_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-hr-policy');
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
                    
                    $hrPolicy = $this->DataModel->viewHrPolicyTrashData($conditions, HRM_HR_POLICY_TABLE);
                    $data['countHrPolicy'] = $this->DataModel->countHrPolicyTrashData($conditions, HRM_HR_POLICY_TABLE);

                    $data['viewHrPolicy'] = array();
                    if(is_array($hrPolicy) || is_object($hrPolicy)){
                        foreach($hrPolicy as $Row){
                            $dataArray = array();
                            $dataArray['hr_policy_id'] = $Row['hr_policy_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['effective_date'] = $Row['effective_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            array_push($data['viewHrPolicy'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/hrPolicy/hr_policy_trash_view', $data);
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
    
    public function hrPolicyRestore($hrPolicyID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $hrPolicyID = urlDecodes($hrPolicyID);
                    if(ctype_digit($hrPolicyID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('hr_policy_id = '.$hrPolicyID, HRM_HR_POLICY_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_hr_policy_restore_success','Your hr policy has been restore successfully!');
                            $sessionHrPolicyTrashViewPreviousUrl = $this->session->userdata('session_hr_policy_trash_view_previous_url');
                            if(!empty($sessionHrPolicyTrashViewPreviousUrl)){
                                redirect($sessionHrPolicyTrashViewPreviousUrl);
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
    
    public function hrPolicyDelete($hrPolicyID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $hrPolicyID = urlDecodes($hrPolicyID);
                    if(ctype_digit($hrPolicyID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('hr_policy_id = '.$hrPolicyID, HRM_HR_POLICY_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_hr_policy_delete_success','Your hr policy has been delete successfully!');
                                    $sessionHrPolicyTrashViewPreviousUrl = $this->session->userdata('session_hr_policy_trash_view_previous_url');
                                    if(!empty($sessionHrPolicyTrashViewPreviousUrl)){
                                        redirect($sessionHrPolicyTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_hr_policy_delete_error','Your password are not matched! Please enter correct password');
                                $sessionHrPolicyTrashViewPreviousUrl = $this->session->userdata('session_hr_policy_trash_view_previous_url');
                                if(!empty($sessionHrPolicyTrashViewPreviousUrl)){
                                    redirect($sessionHrPolicyTrashViewPreviousUrl);
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
