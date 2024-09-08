<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ip extends CI_Controller {
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
    
    public function ipNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $this->load->view('header');
                    $this->load->view('master/ip/ip_new');
                    $this->load->view('footer');
                    if($this->input->post('submit')){
                        $dataStartTime = $this->input->post('data_start_time');
                        $dataEndTime = $this->input->post('data_end_time');
                        $newData = array(
                            'data_name'=>$this->input->post('data_name'),
                            'data_ip'=>$this->input->post('data_ip'),
                            'data_email'=>$this->session->userdata['user_email'],
                            'data_time'=>timeZone(),
                            'data_start_time'=>date('H:i', strtotime($dataStartTime)),
                            'data_end_time'=>date('H:i', strtotime($dataEndTime)),
                            'data_status'=>'active',
                            'trash_status'=>'false',
                        );
                        $newDataEntry = $this->DataModel->insertData(IP_TABLE, $newData);
                        if($newDataEntry){
                          redirect('view-ip');  
                        }
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

    public function ipView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_ip_view_previous_url', current_url());

                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_ip');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchIp = $this->input->post('search_ip');
                        $this->session->set_userdata('session_ip', $searchIp);
                    }
                    $sessionIp = $this->session->userdata('session_ip');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_ip_status');
                        redirect('view-ip');
                    }
                    
                    $searchIpStatus = $this->input->post('search_ip_status');
                    if($searchIpStatus === 'active' or $searchIpStatus == 'blocked'){
                        $this->session->set_userdata('session_ip_status', $searchIpStatus);
                    } else if($searchIpStatus === 'all'){
                        $this->session->unset_userdata('session_ip_status');
                    }
                    $sessionIpStatus = $this->session->userdata('session_ip_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_ip'] = $sessionIp;
                    $conditions['search_ip_status'] = $sessionIpStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewIpData($conditions, IP_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-ip');
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
                    
                    $ip = $this->DataModel->viewIpData($conditions, IP_TABLE);
                    $data['countIp'] = $this->DataModel->countIpData($conditions, IP_TABLE);
                    $data['countIpTrash'] = $this->DataModel->countIpTrashData($conditions, IP_TABLE);

                    $data['viewIp'] = array();
                    if(is_array($ip) || is_object($ip)){
                        foreach($ip as $Row){
                            $dataArray = array();
                            $dataArray['data_id'] = $Row['data_id'];
                            $dataArray['data_name'] = $Row['data_name'];
                            $dataArray['data_ip'] = $Row['data_ip'];
                            $dataArray['data_email'] = $Row['data_email'];
                            $dataArray['data_time'] = $Row['data_time'];
                            $dataArray['data_start_time'] = $Row['data_start_time'];
                            $dataArray['data_end_time'] = $Row['data_end_time'];
                            $dataArray['data_status'] = $Row['data_status'];
                            array_push($data['viewIp'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/ip/ip_view', $data);
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
    
    public function ipEdit($dataID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $dataID = urlDecodes($dataID);
                    if(ctype_digit($dataID)){
                        $data['ipData'] = $this->DataModel->getData('data_id = '.$dataID, IP_TABLE);
                        if(!empty($data['ipData'])){
                            $this->load->view('header');
                            $this->load->view('master/ip/ip_edit', $data);
                            $this->load->view('footer');
                        } else {
                            redirect('error');
                        }
                        if($this->input->post('submit')){
                            $dataStartTime = $this->input->post('data_start_time');
                            $dataEndTime = $this->input->post('data_end_time');
                            $editData = array(
                                'data_name'=>$this->input->post('data_name'),
                                'data_ip'=>$this->input->post('data_ip'),
                                'data_email'=>$this->session->userdata['user_email'],
                                'data_time'=>timeZone(),
                                'data_start_time'=>date('H:i', strtotime($dataStartTime)),
                                'data_end_time'=>date('H:i', strtotime($dataEndTime)),
                                'data_status'=>$this->input->post('data_status')
                            );
                            $editDataEntry = $this->DataModel->editData('data_id = '.$dataID, IP_TABLE, $editData);
            				if($editDataEntry){
            					$sessionIpViewPreviousUrl = $this->session->userdata('session_ip_view_previous_url');
                                if(!empty($sessionIpViewPreviousUrl)){
                                    redirect($sessionIpViewPreviousUrl);
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
    
    public function ipTrash($dataID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $dataID = urlDecodes($dataID);
                    if(ctype_digit($dataID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('data_id = '.$dataID, IP_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_ip_trash_success','Your ip has been trash successfully!');
                            $sessionIpViewPreviousUrl = $this->session->userdata('session_ip_view_previous_url');
                            if(!empty($sessionIpViewPreviousUrl)){
                                redirect($sessionIpViewPreviousUrl);
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
    
    public function ipTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_ip_trash_view_previous_url', current_url());

                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_ip_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchIpTrash = $this->input->post('search_ip_trash');
                        $this->session->set_userdata('session_ip_trash', $searchIpTrash);
                    }
                    $sessionIpTrash = $this->session->userdata('session_ip_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_ip_trash_status');
                        redirect('view-trash-ip');
                    }
                    
                    $searchIpTrashStatus = $this->input->post('search_ip_trash_status');
                    if($searchIpTrashStatus === 'active' or $searchIpTrashStatus == 'blocked'){
                        $this->session->set_userdata('session_ip_trash_status', $searchIpTrashStatus);
                    } else if($searchIpTrashStatus === 'all'){
                        $this->session->unset_userdata('session_ip_trash_status');
                    }
                    $sessionIpTrashStatus = $this->session->userdata('session_ip_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_ip_trash'] = $sessionIpTrash;
                    $conditions['search_ip_trash_status'] = $sessionIpTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewIpTrashData($conditions, IP_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-ip');
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
                    
                    $ip = $this->DataModel->viewIpTrashData($conditions, IP_TABLE);
                    $data['countIp'] = $this->DataModel->countIpTrashData($conditions, IP_TABLE);

                    $data['viewIp'] = array();
                    if(is_array($ip) || is_object($ip)){
                        foreach($ip as $Row){
                            $dataArray = array();
                            $dataArray['data_id'] = $Row['data_id'];
                            $dataArray['data_name'] = $Row['data_name'];
                            $dataArray['data_ip'] = $Row['data_ip'];
                            $dataArray['data_email'] = $Row['data_email'];
                            $dataArray['data_time'] = $Row['data_time'];
                            $dataArray['data_start_time'] = $Row['data_start_time'];
                            $dataArray['data_end_time'] = $Row['data_end_time'];
                            $dataArray['data_status'] = $Row['data_status'];
                            array_push($data['viewIp'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/ip/ip_trash_view', $data);
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
    
    public function ipRestore($dataID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $dataID = urlDecodes($dataID);
                    if(ctype_digit($dataID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('data_id = '.$dataID, IP_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_ip_restore_success','Your ip has been restore successfully!');
                            $sessionIpTrashViewPreviousUrl = $this->session->userdata('session_ip_trash_view_previous_url');
                            if(!empty($sessionIpTrashViewPreviousUrl)){
                                redirect($sessionIpTrashViewPreviousUrl);
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
    
    public function ipDelete($dataID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $dataID = urlDecodes($dataID);
                    if(ctype_digit($dataID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('data_id = '.$dataID, IP_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_ip_delete_success','Your ip has been delete successfully!');
                                    $sessionIpTrashViewPreviousUrl = $this->session->userdata('session_ip_trash_view_previous_url');
                                    if(!empty($sessionIpTrashViewPreviousUrl)){
                                        redirect($sessionIpTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_ip_delete_error','Your password are not matched! Please enter correct password');
                                $sessionIpTrashViewPreviousUrl = $this->session->userdata('session_ip_trash_view_previous_url');
                                if(!empty($sessionIpTrashViewPreviousUrl)){
                                    redirect($sessionIpTrashViewPreviousUrl);
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