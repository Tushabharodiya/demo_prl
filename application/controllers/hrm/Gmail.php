<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gmail extends CI_Controller {
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
	
    public function gmailNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_GMAIL_ALIAS, "can_add");
            if($isPermission){
                $data['employeeData'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/gmail/gmail_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'employee_id'=>$this->input->post('employee_id'),
                        'gmail_mail_id'=>$this->input->post('gmail_mail_id'),
                        'gmail_password'=>$this->input->post('gmail_password'),
                        'figma_password'=>$this->input->post('figma_password'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_GMAIL_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-gmail');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function gmailView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_gmail_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_gmail');
            }
            if(isset($_POST['submit_search'])){
                $searchGmail = $this->input->post('search_gmail');
                $this->session->set_userdata('session_gmail', $searchGmail);
            }
            $sessionGmail = $this->session->userdata('session_gmail');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_gmail_status');
                redirect('view-gmail');
            }
            
            $searchGmailStatus = $this->input->post('search_gmail_status');
            if($searchGmailStatus === 'active' or $searchGmailStatus == 'inactive'){
                $this->session->set_userdata('session_gmail_status', $searchGmailStatus);
            } else if($searchGmailStatus === 'all'){
                $this->session->unset_userdata('session_gmail_status');
            }
            $sessionGmailStatus = $this->session->userdata('session_gmail_status');
            
            $data = array();
            //get rows count
            $conditions['search_gmail'] = $sessionGmail;
            $conditions['search_gmail_status'] = $sessionGmailStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewGmailData($conditions, HRM_GMAIL_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-gmail');
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
            
            $gmail = $this->DataModel->viewGmailData($conditions, HRM_GMAIL_TABLE);
            $data['countGmail'] = $this->DataModel->countGmailData($conditions, HRM_GMAIL_TABLE);
            $data['countGmailTrash'] = $this->DataModel->countGmailTrashData($conditions, HRM_GMAIL_TABLE);
            
            $data['viewGmail'] = array();
            if(is_array($gmail) || is_object($gmail)){
                foreach($gmail as $Row){
                    $dataArray = array();
                    $dataArray['gmail_id'] = $Row['gmail_id'];
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['gmail_mail_id'] = $Row['gmail_mail_id'];
                    $dataArray['gmail_password'] = $Row['gmail_password'];
                    $dataArray['figma_password'] = $Row['figma_password'];
                    $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewGmail'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/gmail/gmail_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function gmailEdit($gmailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_GMAIL_ALIAS, "can_edit");
            if($isPermission){
                $gmailID = urlDecodes($gmailID);
                if(ctype_digit($gmailID)){
                    $data['gmailData'] = $this->DataModel->getData('gmail_id = '.$gmailID, HRM_GMAIL_TABLE);
                    
                    $data['viewEmployee'] = $this->DataModel->viewData('employee_id '.'DESC', 'is_employee = "selected" AND employee_status = "active"', HRM_EMPLOYEE_TABLE);
                    $employeeID = $data['gmailData']['employee_id'];
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);

                    if(!empty($data['gmailData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/gmail/gmail_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'employee_id'=>$this->input->post('employee_id'),
                            'gmail_mail_id'=>$this->input->post('gmail_mail_id'),
                            'gmail_password'=>$this->input->post('gmail_password'),
                            'figma_password'=>$this->input->post('figma_password'),
                        );
                        $editDataEntry = $this->DataModel->editData('gmail_id = '.$gmailID, HRM_GMAIL_TABLE, $editData);
                        if($editDataEntry){
                            $sessionGmailViewPreviousUrl = $this->session->userdata('session_gmail_view_previous_url');
                            if(!empty($sessionGmailViewPreviousUrl)){
                                redirect($sessionGmailViewPreviousUrl);
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
    
    public function gmailTrash($gmailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $gmailID = urlDecodes($gmailID);
                    if(ctype_digit($gmailID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('gmail_id = '.$gmailID, HRM_GMAIL_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_gmail_trash_success','Your gmail has been trash successfully!');
                            $sessionGmailViewPreviousUrl = $this->session->userdata('session_gmail_view_previous_url');
                            if(!empty($sessionGmailViewPreviousUrl)){
                                redirect($sessionGmailViewPreviousUrl);
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
    
    public function gmailTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_gmail_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_gmail_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchGmailTrash = $this->input->post('search_gmail_trash');
                        $this->session->set_userdata('session_gmail_trash', $searchGmailTrash);
                    }
                    $sessionGmailTrash = $this->session->userdata('session_gmail_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_gmail_trash_status');
                        redirect('view-trash-gmail');
                    }
                    
                    $searchGmailTrashStatus = $this->input->post('search_gmail_trash_status');
                    if($searchGmailTrashStatus === 'active' or $searchGmailTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_gmail_trash_status', $searchGmailTrashStatus);
                    } else if($searchGmailTrashStatus === 'all'){
                        $this->session->unset_userdata('session_gmail_trash_status');
                    }
                    $sessionGmailTrashStatus = $this->session->userdata('session_gmail_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_gmail_trash'] = $sessionGmailTrash;
                    $conditions['search_gmail_trash_status'] = $sessionGmailTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewGmailTrashData($conditions, HRM_GMAIL_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-gmail');
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
                    
                    $gmail = $this->DataModel->viewGmailTrashData($conditions, HRM_GMAIL_TABLE);
                    $data['countGmail'] = $this->DataModel->countGmailTrashData($conditions, HRM_GMAIL_TABLE);
        
                    $data['viewGmail'] = array();
                    if(is_array($gmail) || is_object($gmail)){
                        foreach($gmail as $Row){
                            $dataArray = array();
                            $dataArray['gmail_id'] = $Row['gmail_id'];
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['gmail_mail_id'] = $Row['gmail_mail_id'];
                            $dataArray['gmail_password'] = $Row['gmail_password'];
                            $dataArray['figma_password'] = $Row['figma_password'];
                            $dataArray['employeeData'] = $this->DataModel->getData('employee_id = '.$dataArray['employee_id'], HRM_EMPLOYEE_TABLE);
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['employeeData']['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewGmail'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/gmail/gmail_trash_view', $data);
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
    
    public function gmailRestore($gmailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $gmailID = urlDecodes($gmailID);
                    if(ctype_digit($gmailID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('gmail_id = '.$gmailID, HRM_GMAIL_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_gmail_restore_success','Your gmail has been restore successfully!');
                            $sessionGmailTrashViewPreviousUrl = $this->session->userdata('session_gmail_trash_view_previous_url');
                            if(!empty($sessionGmailTrashViewPreviousUrl)){
                                redirect($sessionGmailTrashViewPreviousUrl);
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
    
    public function gmailDelete($gmailID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $gmailID = urlDecodes($gmailID);
                    if(ctype_digit($gmailID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('gmail_id = '.$gmailID, HRM_GMAIL_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_gmail_delete_success','Your gmail has been delete successfully!');
                                    $sessionGmailTrashViewPreviousUrl = $this->session->userdata('session_gmail_trash_view_previous_url');
                                    if(!empty($sessionGmailTrashViewPreviousUrl)){
                                        redirect($sessionGmailTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_gmail_delete_error','Your password are not matched! Please enter correct password');
                                $sessionGmailTrashViewPreviousUrl = $this->session->userdata('session_gmail_trash_view_previous_url');
                                if(!empty($sessionGmailTrashViewPreviousUrl)){
                                    redirect($sessionGmailTrashViewPreviousUrl);
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
