<?php defined('BASEPATH') OR exit('No direct script access allowed');

class InternshipCertificate extends CI_Controller {
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
	
    public function internshipCertificateNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_INTERNSHIP_CERTIFICATE_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "intern" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['onboardingLettersData'] = $this->DataModel->getData(null, HRM_ONBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/internshipCertificate/internship_cerificate_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'internship_certificate_letter'=>$data['onboardingLettersData']['internship_certificate_letter'],
                        'from_date'=>$this->input->post('from_date'),
                        'to_date'=>$this->input->post('to_date'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_INTERNSHIP_CERTIFICATE_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-internship-certificate');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function internshipCertificateView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_internship_certificate_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_internship_certificate');
            }
            if(isset($_POST['submit_search'])){
                $searchInternshipCertificate = $this->input->post('search_internship_certificate');
                $this->session->set_userdata('session_internship_certificate', $searchInternshipCertificate);
            }
            $sessionInternshipCertificate = $this->session->userdata('session_internship_certificate');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_internship_certificate_status');
                redirect('view-internship-certificate');
            }
                
            $searchInternshipCertificateStatus = $this->input->post('search_internship_certificate_status');
            if($searchInternshipCertificateStatus == 'active' or $searchInternshipCertificateStatus == 'inactive'){
                $this->session->set_userdata('session_internship_certificate_status', $searchInternshipCertificateStatus);
            } else if($searchInternshipCertificateStatus === 'all'){
                $this->session->unset_userdata('session_internship_certificate_status');
            }
            $sessionInternshipCertificateStatus = $this->session->userdata('session_internship_certificate_status');
            
            $data = array();
            //get rows count
            $conditions['search_internship_certificate'] = $sessionInternshipCertificate;
            $conditions['search_internship_certificate_status'] = $sessionInternshipCertificateStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewInternshipCertificateData($conditions, HRM_INTERNSHIP_CERTIFICATE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-internship-certificate');
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
            
            $internshipCertificate = $this->DataModel->viewInternshipCertificateData($conditions, HRM_INTERNSHIP_CERTIFICATE_TABLE);
            $data['countInternshipCertificate'] = $this->DataModel->countInternshipCertificateData($conditions, HRM_INTERNSHIP_CERTIFICATE_TABLE);
            $data['countInternshipCertificateTrash'] = $this->DataModel->countInternshipCertificateTrashData($conditions, HRM_INTERNSHIP_CERTIFICATE_TABLE);
            
            $data['viewInternshipCertificate'] = array();
            if(is_array($internshipCertificate) || is_object($internshipCertificate)){
                foreach($internshipCertificate as $Row){
                    $dataArray = array();
                    $dataArray['internship_certificate_id'] = $Row['internship_certificate_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewInternshipCertificate'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/internshipCertificate/internship_certificate_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function internshipCertificateDetail($internshipCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_INTERNSHIP_CERTIFICATE_ALIAS, "can_view");
            if($isPermission){
                $internshipCertificateID = urlDecodes($internshipCertificateID);
                if(ctype_digit($internshipCertificateID)){
            		$internshipCertificate = $this->DataModel->viewData(null, 'internship_certificate_id = '.$internshipCertificateID, HRM_INTERNSHIP_CERTIFICATE_TABLE);
        	        $data['detailInternshipCertificate'] = array();
                    if(is_array($internshipCertificate) || is_object($internshipCertificate)){
                        foreach($internshipCertificate as $Row){
                            $dataArray = array();
                            $dataArray['internship_certificate_id'] = $Row['internship_certificate_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['internship_certificate_letter'] = $Row['internship_certificate_letter'];
                            $dataArray['from_date'] = $Row['from_date'];
                            $dataArray['to_date'] = $Row['to_date'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailInternshipCertificate'], $dataArray);
                        }
                    }
                    if($data['detailInternshipCertificate'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/internshipCertificate/internship_certificate_detail', $data);
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
    
    public function internshipCertificatePdf($internshipCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_INTERNSHIP_CERTIFICATE_ALIAS, "can_view");
            if($isPermission){
                $internshipCertificateID = urlDecodes($internshipCertificateID);
                if(ctype_digit($internshipCertificateID)){
            		$data['pdfInternshipCertificate'] = $this->DataModel->getData('internship_certificate_id = '.$internshipCertificateID, HRM_INTERNSHIP_CERTIFICATE_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfInternshipCertificate']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
                    if($data['pdfInternshipCertificate'] != null){
                        ob_start();
                        $html = $this->load->view('hrm/internshipCertificate/internship_certificate_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Internship Certificate'.'.pdf', array("Attachment"=>0));
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
    
    public function internshipCertificateEdit($internshipCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_INTERNSHIP_CERTIFICATE_ALIAS, "can_edit");
            if($isPermission){
                $internshipCertificateID = urlDecodes($internshipCertificateID);
                if(ctype_digit($internshipCertificateID)){
                    $data['internshipCertificateData'] = $this->DataModel->getData('internship_certificate_id = '.$internshipCertificateID, HRM_INTERNSHIP_CERTIFICATE_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "intern" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['internshipCertificateData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['internshipCertificateData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/internshipCertificate/internship_certificate_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'from_date'=>$this->input->post('from_date'),
                            'to_date'=>$this->input->post('to_date'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('internship_certificate_id = '.$internshipCertificateID, HRM_INTERNSHIP_CERTIFICATE_TABLE, $editData);
                        if($editDataEntry){
                            $sessionInternshipCertificateViewPreviousUrl = $this->session->userdata('session_internship_certificate_view_previous_url');
                            if(!empty($sessionInternshipCertificateViewPreviousUrl)){
                                redirect($sessionInternshipCertificateViewPreviousUrl);
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
    
    public function internshipCertificateTrash($internshipCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $internshipCertificateID = urlDecodes($internshipCertificateID);
                    if(ctype_digit($internshipCertificateID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('internship_certificate_id = '.$internshipCertificateID, HRM_INTERNSHIP_CERTIFICATE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_internship_certificate_trash_success','Your internship certificate has been trash successfully!');
                            $sessionInternshipCertificateViewPreviousUrl = $this->session->userdata('session_internship_certificate_view_previous_url');
                            if(!empty($sessionInternshipCertificateViewPreviousUrl)){
                                redirect($sessionInternshipCertificateViewPreviousUrl);
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
    
    public function internshipCertificateTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_internship_certificate_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_internship_certificate_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchInternshipCertificateTrash = $this->input->post('search_internship_certificate_trash');
                        $this->session->set_userdata('session_internship_certificate_trash', $searchInternshipCertificateTrash);
                    }
                    $sessionInternshipCertificateTrash = $this->session->userdata('session_internship_certificate_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_internship_certificate_trash_status');
                        redirect('view-trash-internship-certificate');
                    }
                        
                    $searchInternshipCertificateTrashStatus = $this->input->post('search_internship_certificate_trash_status');
                    if($searchInternshipCertificateTrashStatus == 'active' or $searchInternshipCertificateTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_internship_certificate_trash_status', $searchInternshipCertificateTrashStatus);
                    } else if($searchInternshipCertificateTrashStatus === 'all'){
                        $this->session->unset_userdata('session_internship_certificate_trash_status');
                    }
                    $sessionInternshipCertificateTrashStatus = $this->session->userdata('session_internship_certificate_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_internship_certificate_trash'] = $sessionInternshipCertificateTrash;
                    $conditions['search_internship_certificate_trash_status'] = $sessionInternshipCertificateTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewInternshipCertificateTrashData($conditions, HRM_INTERNSHIP_CERTIFICATE_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-internship-certificate');
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
                    
                    $internshipCertificate = $this->DataModel->viewInternshipCertificateTrashData($conditions, HRM_INTERNSHIP_CERTIFICATE_TABLE);
                    $data['countInternshipCertificate'] = $this->DataModel->countInternshipCertificateTrashData($conditions, HRM_INTERNSHIP_CERTIFICATE_TABLE);

                    $data['viewInternshipCertificate'] = array();
                    if(is_array($internshipCertificate) || is_object($internshipCertificate)){
                        foreach($internshipCertificate as $Row){
                            $dataArray = array();
                            $dataArray['internship_certificate_id'] = $Row['internship_certificate_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewInternshipCertificate'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/internshipCertificate/internship_certificate_trash_view', $data);
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
    
    public function internshipCertificateRestore($internshipCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $internshipCertificateID = urlDecodes($internshipCertificateID);
                    if(ctype_digit($internshipCertificateID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('internship_certificate_id = '.$internshipCertificateID, HRM_INTERNSHIP_CERTIFICATE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_internship_certificate_restore_success','Your internship certificate has been restore successfully!');
                            $sessionInternshipCertificateTrashViewPreviousUrl = $this->session->userdata('session_internship_certificate_trash_view_previous_url');
                            if(!empty($sessionInternshipCertificateTrashViewPreviousUrl)){
                                redirect($sessionInternshipCertificateTrashViewPreviousUrl);
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
    
    public function internshipCertificateDelete($internshipCertificateID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $internshipCertificateID = urlDecodes($internshipCertificateID);
                    if(ctype_digit($internshipCertificateID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('internship_certificate_id = '.$internshipCertificateID, HRM_INTERNSHIP_CERTIFICATE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_internship_certificate_delete_success','Your internship certificate has been delete successfully!');
                                    $sessionInternshipCertificateTrashViewPreviousUrl = $this->session->userdata('session_internship_certificate_trash_view_previous_url');
                                    if(!empty($sessionInternshipCertificateTrashViewPreviousUrl)){
                                        redirect($sessionInternshipCertificateTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_internship_certificate_delete_error','Your password are not matched! Please enter correct password');
                                $sessionInternshipCertificateTrashViewPreviousUrl = $this->session->userdata('session_internship_certificate_trash_view_previous_url');
                                if(!empty($sessionInternshipCertificateTrashViewPreviousUrl)){
                                    redirect($sessionInternshipCertificateTrashViewPreviousUrl);
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
