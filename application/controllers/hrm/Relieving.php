<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Relieving extends CI_Controller {
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
	
    public function relievingNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_RELIEVING_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $data['offboardingLettersData'] = $this->DataModel->getData(null, HRM_OFFBOARDING_LETTERS_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/relieving/relieving_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'relieving_letter'=>$data['offboardingLettersData']['employee_relieving_letter'],
                        'from_date'=>$this->input->post('from_date'),
                        'to_date'=>$this->input->post('to_date'),
                        'effective_date'=>$this->input->post('effective_date'),
                        'create_date'=>$this->input->post('create_date'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_RELIEVING_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-relieving');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function relievingView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_relieving_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_relieving');
            }
            if(isset($_POST['submit_search'])){
                $searchRelieving = $this->input->post('search_relieving');
                $this->session->set_userdata('session_relieving', $searchRelieving);
            }
            $sessionRelieving = $this->session->userdata('session_relieving');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_relieving_status');
                redirect('view-relieving');
            }
                
            $searchRelievingStatus = $this->input->post('search_relieving_status');
            if($searchRelievingStatus == 'active' or $searchRelievingStatus == 'inactive'){
                $this->session->set_userdata('session_relieving_status', $searchRelievingStatus);
            } else if($searchRelievingStatus === 'all'){
                $this->session->unset_userdata('session_relieving_status');
            }
            $sessionRelievingStatus = $this->session->userdata('session_relieving_status');
            
            $data = array();
            //get rows count
            $conditions['search_relieving'] = $sessionRelieving;
            $conditions['search_relieving_status'] = $sessionRelievingStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewRelievingData($conditions, HRM_RELIEVING_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-relieving');
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
            
            $relieving = $this->DataModel->viewRelievingData($conditions, HRM_RELIEVING_TABLE);
            $data['countRelieving'] = $this->DataModel->countRelievingData($conditions, HRM_RELIEVING_TABLE);
            $data['countRelievingTrash'] = $this->DataModel->countRelievingTrashData($conditions, HRM_RELIEVING_TABLE);
            
            $data['viewRelieving'] = array();
            if(is_array($relieving) || is_object($relieving)){
                foreach($relieving as $Row){
                    $dataArray = array();
                    $dataArray['relieving_id'] = $Row['relieving_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['create_date'] = $Row['create_date'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewRelieving'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/relieving/relieving_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function relievingDetail($relievingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_RELIEVING_ALIAS, "can_view");
            if($isPermission){
                $relievingID = urlDecodes($relievingID);
                if(ctype_digit($relievingID)){
            		$relieving = $this->DataModel->viewData(null, 'relieving_id = '.$relievingID, HRM_RELIEVING_TABLE);
        	        $data['detailRelieving'] = array();
                    if(is_array($relieving) || is_object($relieving)){
                        foreach($relieving as $Row){
                            $dataArray = array();
                            $dataArray['relieving_id'] = $Row['relieving_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['relieving_letter'] = $Row['relieving_letter'];
                            $dataArray['from_date'] = $Row['from_date'];
                            $dataArray['to_date'] = $Row['to_date'];
                            $dataArray['effective_date'] = $Row['effective_date'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['detailRelieving'], $dataArray);
                        }
                    }
                    if($data['detailRelieving'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/relieving/relieving_detail', $data);
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
    
    public function relievingPdf($relievingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_RELIEVING_ALIAS, "can_view");
            if($isPermission){
                $relievingID = urlDecodes($relievingID);
                if(ctype_digit($relievingID)){
            		$data['pdfRelieving'] = $this->DataModel->getData('relieving_id = '.$relievingID, HRM_RELIEVING_TABLE);
            		
        	        $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', null, HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['pdfRelieving']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$data['employeeData']['department_id'], DEPARTMENT_TABLE);
                    
        	        if($data['pdfRelieving'] != null){
        	            ob_start();
                        $html = $this->load->view('hrm/relieving/relieving_pdf', $data, TRUE);
                        $this->load->library('pdf');
                        $this->dompdf->loadHtml($html);
                        $this->dompdf->setPaper('A4', 'Portrait');
                        $this->dompdf->render();
                        $fileName  = $data['employeeData']['employee_first_name'].' '.$data['employeeData']['employee_middle_name'].' '.$data['employeeData']['employee_last_name'];
                        $this->dompdf->stream($fileName.' - Relieving Letter'.'.pdf', array("Attachment"=>0));
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
    
    public function relievingEdit($relievingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_RELIEVING_ALIAS, "can_edit");
            if($isPermission){
                $relievingID = urlDecodes($relievingID);
                if(ctype_digit($relievingID)){
                    $data['relievingData'] = $this->DataModel->getData('relieving_id = '.$relievingID, HRM_RELIEVING_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_type = "employee" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['relievingData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if(!empty($data['relievingData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/relieving/relieving_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'from_date'=>$this->input->post('from_date'),
                            'to_date'=>$this->input->post('to_date'),
                            'effective_date'=>$this->input->post('effective_date'),
                            'create_date'=>$this->input->post('create_date'),
                        );
                        $editDataEntry = $this->DataModel->editData('relieving_id = '.$relievingID, HRM_RELIEVING_TABLE, $editData);
                        if($editDataEntry){
                            $sessionRelievingViewPreviousUrl = $this->session->userdata('session_relieving_view_previous_url');
                            if(!empty($sessionRelievingViewPreviousUrl)){
                                redirect($sessionRelievingViewPreviousUrl);
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
    
    public function relievingTrash($relievingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $relievingID = urlDecodes($relievingID);
                    if(ctype_digit($relievingID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('relieving_id = '.$relievingID, HRM_RELIEVING_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_relieving_trash_success','Your relieving has been trash successfully!');
                            $sessionRelievingViewPreviousUrl = $this->session->userdata('session_relieving_view_previous_url');
                            if(!empty($sessionRelievingViewPreviousUrl)){
                                redirect($sessionRelievingViewPreviousUrl);
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
    
    public function relievingTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_relieving_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_relieving_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchRelievingTrash = $this->input->post('search_relieving_trash');
                        $this->session->set_userdata('session_relieving_trash', $searchRelievingTrash);
                    }
                    $sessionRelievingTrash = $this->session->userdata('session_relieving_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_relieving_trash_status');
                        redirect('view-trash-relieving');
                    }
                        
                    $searchRelievingTrashStatus = $this->input->post('search_relieving_trash_status');
                    if($searchRelievingTrashStatus == 'active' or $searchRelievingTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_relieving_trash_status', $searchRelievingTrashStatus);
                    } else if($searchRelievingTrashStatus === 'all'){
                        $this->session->unset_userdata('session_relieving_trash_status');
                    }
                    $sessionRelievingTrashStatus = $this->session->userdata('session_relieving_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_relieving_trash'] = $sessionRelievingTrash;
                    $conditions['search_relieving_trash_status'] = $sessionRelievingTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewRelievingTrashData($conditions, HRM_RELIEVING_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-relieving');
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
                    
                    $relieving = $this->DataModel->viewRelievingTrashData($conditions, HRM_RELIEVING_TABLE);
                    $data['countRelieving'] = $this->DataModel->countRelievingTrashData($conditions, HRM_RELIEVING_TABLE);

                    $data['viewRelieving'] = array();
                    if(is_array($relieving) || is_object($relieving)){
                        foreach($relieving as $Row){
                            $dataArray = array();
                            $dataArray['relieving_id'] = $Row['relieving_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['create_date'] = $Row['create_date'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewRelieving'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/relieving/relieving_trash_view', $data);
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
    
    public function relievingRestore($relievingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $relievingID = urlDecodes($relievingID);
                    if(ctype_digit($relievingID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('relieving_id = '.$relievingID, HRM_RELIEVING_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_relieving_restore_success','Your relieving has been restore successfully!');
                            $sessionRelievingTrashViewPreviousUrl = $this->session->userdata('session_relieving_trash_view_previous_url');
                            if(!empty($sessionRelievingTrashViewPreviousUrl)){
                                redirect($sessionRelievingTrashViewPreviousUrl);
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
    
    public function relievingDelete($relievingID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $relievingID = urlDecodes($relievingID);
                    if(ctype_digit($relievingID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('relieving_id = '.$relievingID, HRM_RELIEVING_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_relieving_delete_success','Your relieving has been delete successfully!');
                                    $sessionRelievingTrashViewPreviousUrl = $this->session->userdata('session_relieving_trash_view_previous_url');
                                    if(!empty($sessionRelievingTrashViewPreviousUrl)){
                                        redirect($sessionRelievingTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_relieving_delete_error','Your password are not matched! Please enter correct password');
                                $sessionRelievingTrashViewPreviousUrl = $this->session->userdata('session_relieving_trash_view_previous_url');
                                if(!empty($sessionRelievingTrashViewPreviousUrl)){
                                    redirect($sessionRelievingTrashViewPreviousUrl);
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
