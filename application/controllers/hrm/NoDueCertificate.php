<?php defined('BASEPATH') OR exit('No direct script access allowed');

class NoDueCertificate extends CI_Controller {
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
	
    public function noDueCertificateNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_NO_DUE_CERTIFICATE_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['offboardingLettersData'] = $this->DataModel->getData(null, HRM_OFFBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/noDueCertificate/no_due_certificate_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'no_due_certificate_letter'=>$data['offboardingLettersData']['employee_no_due_certificate_letter'],
                        'employee_settlement_salary'=>$this->input->post('employee_settlement_salary'),
                        'employee_encashment_salary'=>$this->input->post('employee_encashment_salary'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_NO_DUE_CERTIFICATE_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-no-due-certificate');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function noDueCertificateView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_no_due_certificate_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_no_due_certificate');
            }
            if(isset($_POST['submit_search'])){
                $searchNoDueCertificate = $this->input->post('search_no_due_certificate');
                $this->session->set_userdata('session_no_due_certificate', $searchNoDueCertificate);
            }
            $sessionNoDueCertificate = $this->session->userdata('session_no_due_certificate');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_no_due_certificate_status');
                redirect('view-no-due-certificate');
            }
                
            $searchNoDueCertificateStatus = $this->input->post('search_no_due_certificate_status');
            if($searchNoDueCertificateStatus == 'active' or $searchNoDueCertificateStatus == 'inactive'){
                $this->session->set_userdata('session_no_due_certificate_status', $searchNoDueCertificateStatus);
            } else if($searchNoDueCertificateStatus === 'all'){
                $this->session->unset_userdata('session_no_due_certificate_status');
            }
            $sessionNoDueCertificateStatus = $this->session->userdata('session_no_due_certificate_status');
            
            $data = array();
            //get rows count
            $conditions['search_no_due_certificate'] = $sessionNoDueCertificate;
            $conditions['search_no_due_certificate_status'] = $sessionNoDueCertificateStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewNoDueCertificateData($conditions, HRM_NO_DUE_CERTIFICATE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-no-due-certificate');
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
            
            $noDueCertificate = $this->DataModel->viewNoDueCertificateData($conditions, HRM_NO_DUE_CERTIFICATE_TABLE);
            $data['countNoDueCertificate'] = $this->DataModel->countNoDueCertificateData($conditions, HRM_NO_DUE_CERTIFICATE_TABLE);
            $data['countNoDueCertificateTrash'] = $this->DataModel->countNoDueCertificateTrashData($conditions, HRM_NO_DUE_CERTIFICATE_TABLE);
            
            $data['viewNoDueCertificate'] = array();
            if(is_array($noDueCertificate) || is_object($noDueCertificate)){
                foreach($noDueCertificate as $Row){
                    $dataArray = array();
                    $dataArray['no_due_certificate_id'] = $Row['no_due_certificate_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewNoDueCertificate'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/noDueCertificate/no_due_certificate_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function noDueCertificateDetail($noDueCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_NO_DUE_CERTIFICATE_ALIAS, "can_view");
            if($isPermission){
                $noDueCertificateID = urlDecodes($noDueCertificateID);
                if(ctype_digit($noDueCertificateID)){
            		$noDueCertificate = $this->DataModel->viewData(null, 'no_due_certificate_id = '.$noDueCertificateID, HRM_NO_DUE_CERTIFICATE_TABLE);
        	        $data['detailNoDueCertificate'] = array();
                    if(is_array($noDueCertificate) || is_object($noDueCertificate)){
                        foreach($noDueCertificate as $Row){
                            $dataArray = array();
                            $dataArray['no_due_certificate_id'] = $Row['no_due_certificate_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['no_due_certificate_letter'] = $Row['no_due_certificate_letter'];
                            $dataArray['employee_settlement_salary'] = $Row['employee_settlement_salary'];
                            $dataArray['employee_encashment_salary'] = $Row['employee_encashment_salary'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailNoDueCertificate'], $dataArray);
                        }
                    }
                    if($data['detailNoDueCertificate'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/noDueCertificate/no_due_certificate_detail', $data);
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
    
    public function noDueCertificatePdf($noDueCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_NO_DUE_CERTIFICATE_ALIAS, "can_view");
            if($isPermission){
                $noDueCertificateID = urlDecodes($noDueCertificateID);
                if(ctype_digit($noDueCertificateID)){
            		$data['pdfNoDueCertificate'] = $this->DataModel->getData('no_due_certificate_id = '.$noDueCertificateID, HRM_NO_DUE_CERTIFICATE_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfNoDueCertificate']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['pdfNoDueCertificate'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/noDueCertificate/no_due_certificate_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - No Due Certificate'.'.pdf', array("Attachment"=>0));
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
    
    public function noDueCertificateEdit($noDueCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_NO_DUE_CERTIFICATE_ALIAS, "can_edit");
            if($isPermission){
                $noDueCertificateID = urlDecodes($noDueCertificateID);
                if(ctype_digit($noDueCertificateID)){
                    $data['noDueCertificateData'] = $this->DataModel->getData('no_due_certificate_id = '.$noDueCertificateID, HRM_NO_DUE_CERTIFICATE_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['noDueCertificateData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['noDueCertificateData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/noDueCertificate/no_due_certificate_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'employee_settlement_salary'=>$this->input->post('employee_settlement_salary'),
                            'employee_encashment_salary'=>$this->input->post('employee_encashment_salary'),
                        );
                        $editDataEntry = $this->DataModel->editData('no_due_certificate_id = '.$noDueCertificateID, HRM_NO_DUE_CERTIFICATE_TABLE, $editData);
                        if($editDataEntry){
                            $sessionNoDueCertificateViewPreviousUrl = $this->session->userdata('session_no_due_certificate_view_previous_url');
                            if(!empty($sessionNoDueCertificateViewPreviousUrl)){
                                redirect($sessionNoDueCertificateViewPreviousUrl);
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
    
    public function noDueCertificateTrash($noDueCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $noDueCertificateID = urlDecodes($noDueCertificateID);
                    if(ctype_digit($noDueCertificateID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('no_due_certificate_id = '.$noDueCertificateID, HRM_NO_DUE_CERTIFICATE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_no_due_certificate_trash_success','Your no due certificate has been trash successfully!');
                            $sessionNoDueCertificateViewPreviousUrl = $this->session->userdata('session_no_due_certificate_view_previous_url');
                            if(!empty($sessionNoDueCertificateViewPreviousUrl)){
                                redirect($sessionNoDueCertificateViewPreviousUrl);
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
    
    public function noDueCertificateTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_no_due_certificate_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_no_due_certificate_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchNoDueCertificateTrash = $this->input->post('search_no_due_certificate_trash');
                        $this->session->set_userdata('session_no_due_certificate_trash', $searchNoDueCertificateTrash);
                    }
                    $sessionNoDueCertificateTrash = $this->session->userdata('session_no_due_certificate_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_no_due_certificate_trash_status');
                        redirect('view-trash-no-due-certificate');
                    }
                        
                    $searchNoDueCertificateTrashStatus = $this->input->post('search_no_due_certificate_trash_status');
                    if($searchNoDueCertificateTrashStatus == 'active' or $searchNoDueCertificateTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_no_due_certificate_trash_status', $searchNoDueCertificateTrashStatus);
                    } else if($searchNoDueCertificateTrashStatus === 'all'){
                        $this->session->unset_userdata('session_no_due_certificate_trash_status');
                    }
                    $sessionNoDueCertificateTrashStatus = $this->session->userdata('session_no_due_certificate_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_no_due_certificate_trash'] = $sessionNoDueCertificateTrash;
                    $conditions['search_no_due_certificate_trash_status'] = $sessionNoDueCertificateTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewNoDueCertificateTrashData($conditions, HRM_NO_DUE_CERTIFICATE_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-no-due-certificate');
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
                    
                    $noDueCertificate = $this->DataModel->viewNoDueCertificateTrashData($conditions, HRM_NO_DUE_CERTIFICATE_TABLE);
                    $data['countNoDueCertificate'] = $this->DataModel->countNoDueCertificateTrashData($conditions, HRM_NO_DUE_CERTIFICATE_TABLE);

                    $data['viewNoDueCertificate'] = array();
                    if(is_array($noDueCertificate) || is_object($noDueCertificate)){
                        foreach($noDueCertificate as $Row){
                            $dataArray = array();
                            $dataArray['no_due_certificate_id'] = $Row['no_due_certificate_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewNoDueCertificate'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/noDueCertificate/no_due_certificate_trash_view', $data);
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
    
    public function noDueCertificateRestore($noDueCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $noDueCertificateID = urlDecodes($noDueCertificateID);
                    if(ctype_digit($noDueCertificateID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('no_due_certificate_id = '.$noDueCertificateID, HRM_NO_DUE_CERTIFICATE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_no_due_certificate_restore_success','Your no due certificate has been restore successfully!');
                            $sessionNoDueCertificateTrashViewPreviousUrl = $this->session->userdata('session_no_due_certificate_trash_view_previous_url');
                            if(!empty($sessionNoDueCertificateTrashViewPreviousUrl)){
                                redirect($sessionNoDueCertificateTrashViewPreviousUrl);
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
    
    public function noDueCertificateDelete($noDueCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $noDueCertificateID = urlDecodes($noDueCertificateID);
                    if(ctype_digit($noDueCertificateID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('no_due_certificate_id = '.$noDueCertificateID, HRM_NO_DUE_CERTIFICATE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_no_due_certificate_delete_success','Your no due certificate has been delete successfully!');
                                    $sessionNoDueCertificateTrashViewPreviousUrl = $this->session->userdata('session_no_due_certificate_trash_view_previous_url');
                                    if(!empty($sessionNoDueCertificateTrashViewPreviousUrl)){
                                        redirect($sessionNoDueCertificateTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_no_due_certificate_delete_error','Your password are not matched! Please enter correct password');
                                $sessionNoDueCertificateTrashViewPreviousUrl = $this->session->userdata('session_no_due_certificate_trash_view_previous_url');
                                if(!empty($sessionNoDueCertificateTrashViewPreviousUrl)){
                                    redirect($sessionNoDueCertificateTrashViewPreviousUrl);
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
