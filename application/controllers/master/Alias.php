<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Alias extends CI_Controller {
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
    
    public function aliasNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $this->load->view('header');
                    $this->load->view('master/alias/alias_new');
                    $this->load->view('footer');
                    if($this->input->post('submit')){
                        $newData = array(
                            'alias_name'=>$this->input->post('alias_name'),
                            'alias_status'=>$this->input->post('alias_status')
                        );
                        $lastInsertID = $this->DataModel->insertData(PERMISSION_ALIAS_TABLE, $newData);
                        if($lastInsertID){
                            $editData = array(
                                'alias_position'=>$lastInsertID
                            );
                            $editDataEntry = $this->DataModel->editData('alias_id = '.$lastInsertID, PERMISSION_ALIAS_TABLE, $editData);
                            if($editDataEntry){
                                redirect('view-alias');  
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
            redirect('logout');
        }
    }

    public function aliasView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_alias_view_previous_url', current_url());

                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_alias');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchAlias = $this->input->post('search_alias');
                        $this->session->set_userdata('session_alias', $searchAlias);
                    }
                    $sessionAlias = $this->session->userdata('session_alias');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_alias_status');
                        redirect('view-alias');
                    }
                        
                    $searchAliasStatus = $this->input->post('search_alias_status');
                    if($searchAliasStatus === 'true' or $searchAliasStatus == 'false'){
                        $this->session->set_userdata('session_alias_status', $searchAliasStatus);
                    } else if($searchAliasStatus === 'all'){
                        $this->session->unset_userdata('session_alias_status');
                    }
                    $sessionAliasStatus = $this->session->userdata('session_alias_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_alias'] = $sessionAlias;
                    $conditions['search_alias_status'] = $sessionAliasStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewAliasData($conditions, PERMISSION_ALIAS_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-alias');
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
                    
                    $alias = $this->DataModel->viewAliasData($conditions, PERMISSION_ALIAS_TABLE);
                    $data['countAlias'] = $this->DataModel->countAliasData($conditions, PERMISSION_ALIAS_TABLE);
                    
                    $data['viewAlias'] = array();
                    if(is_array($alias) || is_object($alias)){
                        foreach($alias as $Row){
                            $dataArray = array();
                            $dataArray['alias_id'] = $Row['alias_id'];
                            $dataArray['alias_name'] = $Row['alias_name'];
                            $dataArray['alias_position'] = $Row['alias_position'];
                            $dataArray['alias_status'] = $Row['alias_status'];
                            $dataArray['permissionCount'] = $this->DataModel->countData('alias_id = '.$dataArray['alias_id'], PERMISSION_MASTER_TABLE);
                            array_push($data['viewAlias'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('master/alias/alias_view', $data);
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

    public function aliasEdit($aliasID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $aliasID = urlDecodes($aliasID);
                    if(ctype_digit($aliasID)){
                        $data['aliasData'] = $this->DataModel->getData('alias_id = '.$aliasID, PERMISSION_ALIAS_TABLE);
                        
                        if(!empty($data['aliasData'])){
                            $this->load->view('header');
                            $this->load->view('master/alias/alias_edit', $data);
                            $this->load->view('footer');
                        } else {
                            redirect('error');
                        }
                        if($this->input->post('submit')){
                            $editData = array(
                                'alias_name'=>$this->input->post('alias_name'),
                                'alias_position'=>$this->input->post('alias_position'),
                                'alias_status'=>$this->input->post('alias_status')
                            );
                            $editDataEntry = $this->DataModel->editData('alias_id = '.$aliasID, PERMISSION_ALIAS_TABLE, $editData);
            				if($editDataEntry){
            				    $sessionAliasViewPreviousUrl = $this->session->userdata('session_alias_view_previous_url');
                                if(!empty($sessionAliasViewPreviousUrl)){
                                    redirect($sessionAliasViewPreviousUrl);
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
