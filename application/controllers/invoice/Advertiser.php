<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Advertiser extends CI_Controller {
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
	
    public function advertiserNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(ADVERTISER_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('invoice/advertiser/advertiser_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'advertiser_name'=>$this->input->post('advertiser_name'),
                        'advertiser_address'=>$this->input->post('advertiser_address'),
                        'advertiser_project'=>$this->input->post('advertiser_project'),
                        'advertiser_status'=>$this->input->post('advertiser_status'),
                    );
                    $newDataEntry = $this->DataModel->insertData(ADVERTISER_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-advertiser');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function advertiserView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_advertiser_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_advertiser');
            }
            if(isset($_POST['submit_search'])){
                $searchAdvertiser = $this->input->post('search_advertiser');
                $this->session->set_userdata('session_advertiser', $searchAdvertiser);
            }
            $sessionAdvertiser = $this->session->userdata('session_advertiser');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_advertiser_status');
                redirect('view-advertiser');
            }
                
            $searchAdvertiserStatus = $this->input->post('search_advertiser_status');
            if($searchAdvertiserStatus === 'active' or $searchAdvertiserStatus == 'blocked'){
                $this->session->set_userdata('session_advertiser_status', $searchAdvertiserStatus);
            } else if($searchAdvertiserStatus === 'all'){
                $this->session->unset_userdata('session_advertiser_status');
            }
            $sessionAdvertiserStatus = $this->session->userdata('session_advertiser_status');
            
            $data = array();
            //get rows count
            $conditions['search_advertiser'] = $sessionAdvertiser;
            $conditions['search_advertiser_status'] = $sessionAdvertiserStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewAdvertiserData($conditions, ADVERTISER_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-advertiser');
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
            
            $advertiser = $this->DataModel->viewAdvertiserData($conditions, ADVERTISER_TABLE);
            $data['countAdvertiser'] = $this->DataModel->countAdvertiserData($conditions, ADVERTISER_TABLE);
            
            $data['viewAdvertiser'] = array();
            if(is_array($advertiser) || is_object($advertiser)){
                foreach($advertiser as $Row){
                    $dataArray = array();
                    $dataArray['advertiser_id'] = $Row['advertiser_id'];
                    $dataArray['advertiser_name'] = $Row['advertiser_name'];
                    $dataArray['advertiser_address'] = $Row['advertiser_address'];
                    $dataArray['advertiser_project'] = $Row['advertiser_project'];
                    $dataArray['advertiser_status'] = $Row['advertiser_status'];
                    array_push($data['viewAdvertiser'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('invoice/advertiser/advertiser_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function advertiserEdit($advertiserID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(ADVERTISER_ALIAS, "can_edit");
            if($isPermission){
                $advertiserID = urlDecodes($advertiserID);
                if(ctype_digit($advertiserID)){
                    $data['advertiserData'] = $this->DataModel->getData('advertiser_id = '.$advertiserID, ADVERTISER_TABLE);
                    if(!empty($data['advertiserData'])){
                        $this->load->view('header');
                        $this->load->view('invoice/advertiser/advertiser_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'advertiser_name'=>$this->input->post('advertiser_name'),
                            'advertiser_address'=>$this->input->post('advertiser_address'),
                            'advertiser_project'=>$this->input->post('advertiser_project'),
                            'advertiser_status'=>$this->input->post('advertiser_status'),
                        );
                        $editDataEntry = $this->DataModel->editData('advertiser_id = '.$advertiserID, ADVERTISER_TABLE, $editData);
                        if($editDataEntry){
                            $sessionAdvertiserViewPreviousUrl = $this->session->userdata('session_advertiser_view_previous_url');
                            if(!empty($sessionAdvertiserViewPreviousUrl)){
                                redirect($sessionAdvertiserViewPreviousUrl);
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
}
