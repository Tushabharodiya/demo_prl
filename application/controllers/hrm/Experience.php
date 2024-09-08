<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Experience extends CI_Controller {
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
	
    public function experienceNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EXPERIENCE_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['offboardingLettersData'] = $this->DataModel->getData(null, HRM_OFFBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/experience/experience_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'experience_letter'=>$data['offboardingLettersData']['employee_experience_letter'],
                        'from_date'=>$this->input->post('from_date'),
                        'to_date'=>$this->input->post('to_date'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_EXPERIENCE_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-experience');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function experienceView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_experience_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_experience');
            }
            if(isset($_POST['submit_search'])){
                $searchExperience = $this->input->post('search_experience');
                $this->session->set_userdata('session_experience', $searchExperience);
            }
            $sessionExperience = $this->session->userdata('session_experience');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_experience_status');
                redirect('view-experience');
            }
                
            $searchExperienceStatus = $this->input->post('search_experience_status');
            if($searchExperienceStatus == 'active' or $searchExperienceStatus == 'inactive'){
                $this->session->set_userdata('session_experience_status', $searchExperienceStatus);
            } else if($searchExperienceStatus === 'all'){
                $this->session->unset_userdata('session_experience_status');
            }
            $sessionExperienceStatus = $this->session->userdata('session_experience_status');
            
            $data = array();
            //get rows count
            $conditions['search_experience'] = $sessionExperience;
            $conditions['search_experience_status'] = $sessionExperienceStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewExperienceData($conditions, HRM_EXPERIENCE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-experience');
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
            
            $experience = $this->DataModel->viewExperienceData($conditions, HRM_EXPERIENCE_TABLE);
            $data['countExperience'] = $this->DataModel->countExperienceData($conditions, HRM_EXPERIENCE_TABLE);
            $data['countExperienceTrash'] = $this->DataModel->countExperienceTrashData($conditions, HRM_EXPERIENCE_TABLE);
            
            $data['viewExperience'] = array();
            if(is_array($experience) || is_object($experience)){
                foreach($experience as $Row){
                    $dataArray = array();
                    $dataArray['experience_id'] = $Row['experience_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewExperience'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/experience/experience_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function experienceDetail($experienceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EXPERIENCE_ALIAS, "can_view");
            if($isPermission){
                $experienceID = urlDecodes($experienceID);
                if(ctype_digit($experienceID)){
            		$experience = $this->DataModel->viewData(null, 'experience_id = '.$experienceID, HRM_EXPERIENCE_TABLE);
        	        $data['detailExperience'] = array();
                    if(is_array($experience) || is_object($experience)){
                        foreach($experience as $Row){
                            $dataArray = array();
                            $dataArray['experience_id'] = $Row['experience_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['experience_letter'] = $Row['experience_letter'];
                            $dataArray['from_date'] = $Row['from_date'];
                            $dataArray['to_date'] = $Row['to_date'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailExperience'], $dataArray);
                        }
                    }
                    if($data['detailExperience'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/experience/experience_detail', $data);
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
    
    public function experiencePdf($experienceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EXPERIENCE_ALIAS, "can_view");
            if($isPermission){
                $experienceID = urlDecodes($experienceID);
                if(ctype_digit($experienceID)){
            		$data['pdfExperience'] = $this->DataModel->getData('experience_id = '.$experienceID, HRM_EXPERIENCE_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfExperience']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['pdfExperience'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/experience/experience_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Experience Letter'.'.pdf', array("Attachment"=>0));
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
    
    public function experienceEdit($experienceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EXPERIENCE_ALIAS, "can_edit");
            if($isPermission){
                $experienceID = urlDecodes($experienceID);
                if(ctype_digit($experienceID)){
                    $data['experienceData'] = $this->DataModel->getData('experience_id = '.$experienceID, HRM_EXPERIENCE_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['experienceData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['experienceData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/experience/experience_edit', $data);
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
                        $editDataEntry = $this->DataModel->editData('experience_id = '.$experienceID, HRM_EXPERIENCE_TABLE, $editData);
                        if($editDataEntry){
                            $sessionExperienceViewPreviousUrl = $this->session->userdata('session_experience_view_previous_url');
                            if(!empty($sessionExperienceViewPreviousUrl)){
                                redirect($sessionExperienceViewPreviousUrl);
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
    
    public function experienceTrash($experienceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $experienceID = urlDecodes($experienceID);
                    if(ctype_digit($experienceID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('experience_id = '.$experienceID, HRM_EXPERIENCE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_experience_trash_success','Your experience has been trash successfully!');
                            $sessionExperienceViewPreviousUrl = $this->session->userdata('session_experience_view_previous_url');
                            if(!empty($sessionExperienceViewPreviousUrl)){
                                redirect($sessionExperienceViewPreviousUrl);
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
    
    public function experienceTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_experience_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_experience_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchExperienceTrash = $this->input->post('search_experience_trash');
                        $this->session->set_userdata('session_experience_trash', $searchExperienceTrash);
                    }
                    $sessionExperienceTrash = $this->session->userdata('session_experience_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_experience_trash_status');
                        redirect('view-trash-experience');
                    }
                        
                    $searchExperienceTrashStatus = $this->input->post('search_experience_trash_status');
                    if($searchExperienceTrashStatus == 'active' or $searchExperienceTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_experience_trash_status', $searchExperienceTrashStatus);
                    } else if($searchExperienceTrashStatus === 'all'){
                        $this->session->unset_userdata('session_experience_trash_status');
                    }
                    $sessionExperienceTrashStatus = $this->session->userdata('session_experience_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_experience_trash'] = $sessionExperienceTrash;
                    $conditions['search_experience_trash_status'] = $sessionExperienceTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewExperienceTrashData($conditions, HRM_EXPERIENCE_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-experience');
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
                    
                    $experience = $this->DataModel->viewExperienceTrashData($conditions, HRM_EXPERIENCE_TABLE);
                    $data['countExperience'] = $this->DataModel->countExperienceTrashData($conditions, HRM_EXPERIENCE_TABLE);

                    $data['viewExperience'] = array();
                    if(is_array($experience) || is_object($experience)){
                        foreach($experience as $Row){
                            $dataArray = array();
                            $dataArray['experience_id'] = $Row['experience_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewExperience'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/experience/experience_trash_view', $data);
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
    
    public function experienceRestore($experienceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $experienceID = urlDecodes($experienceID);
                    if(ctype_digit($experienceID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('experience_id = '.$experienceID, HRM_EXPERIENCE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_experience_restore_success','Your experience has been restore successfully!');
                            $sessionExperienceTrashViewPreviousUrl = $this->session->userdata('session_experience_trash_view_previous_url');
                            if(!empty($sessionExperienceTrashViewPreviousUrl)){
                                redirect($sessionExperienceTrashViewPreviousUrl);
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
    
    public function experienceDelete($experienceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $experienceID = urlDecodes($experienceID);
                    if(ctype_digit($experienceID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('experience_id = '.$experienceID, HRM_EXPERIENCE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_experience_delete_success','Your experience has been delete successfully!');
                                    $sessionExperienceTrashViewPreviousUrl = $this->session->userdata('session_experience_trash_view_previous_url');
                                    if(!empty($sessionExperienceTrashViewPreviousUrl)){
                                        redirect($sessionExperienceTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_experience_delete_error','Your password are not matched! Please enter correct password');
                                $sessionExperienceTrashViewPreviousUrl = $this->session->userdata('session_experience_trash_view_previous_url');
                                if(!empty($sessionExperienceTrashViewPreviousUrl)){
                                    redirect($sessionExperienceTrashViewPreviousUrl);
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
