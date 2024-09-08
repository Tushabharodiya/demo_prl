<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Publisher extends CI_Controller {
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
	
    public function publisherNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(PUBLISHER_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('invoice/publisher/publisher_new');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'publisher_name'=>$this->input->post('publisher_name'),
                        'publisher_address'=>$this->input->post('publisher_address'),
                        'publisher_gst_number'=>$this->input->post('publisher_gst_number'),
                        'publisher_status'=>$this->input->post('publisher_status'),
                    );
                    $newDataEntry = $this->DataModel->insertData(PUBLISHER_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-publisher');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function publisherView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_publisher_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_publisher');
            }
            if(isset($_POST['submit_search'])){
                $searchPublisher = $this->input->post('search_publisher');
                $this->session->set_userdata('session_publisher', $searchPublisher);
            }
            $sessionPublisher = $this->session->userdata('session_publisher');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_publisher_status');
                redirect('view-publisher');
            }
                
            $searchPublisherStatus = $this->input->post('search_publisher_status');
            if($searchPublisherStatus === 'active' or $searchPublisherStatus == 'blocked'){
                $this->session->set_userdata('session_publisher_status', $searchPublisherStatus);
            } else if($searchPublisherStatus === 'all'){
                $this->session->unset_userdata('session_publisher_status');
            }
            $sessionPublisherStatus = $this->session->userdata('session_publisher_status');
            
            $data = array();
            //get rows count
            $conditions['search_publisher'] = $sessionPublisher;
            $conditions['search_publisher_status'] = $sessionPublisherStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewPublisherData($conditions, PUBLISHER_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-publisher');
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
            
            $publisher = $this->DataModel->viewPublisherData($conditions, PUBLISHER_TABLE);
            $data['countPublisher'] = $this->DataModel->countPublisherData($conditions, PUBLISHER_TABLE);
            
            $data['viewPublisher'] = array();
            if(is_array($publisher) || is_object($publisher)){
                foreach($publisher as $Row){
                    $dataArray = array();
                    $dataArray['publisher_id'] = $Row['publisher_id'];
                    $dataArray['publisher_name'] = $Row['publisher_name'];
                    $dataArray['publisher_address'] = $Row['publisher_address'];
                    $dataArray['publisher_gst_number'] = $Row['publisher_gst_number'];
                    $dataArray['publisher_status'] = $Row['publisher_status'];
                    array_push($data['viewPublisher'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('invoice/publisher/publisher_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function publisherEdit($publisherID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(PUBLISHER_ALIAS, "can_edit");
            if($isPermission){
                $publisherID = urlDecodes($publisherID);
                if(ctype_digit($publisherID)){
                    $data['publisherData'] = $this->DataModel->getData('publisher_id = '.$publisherID, PUBLISHER_TABLE);
                    if(!empty($data['publisherData'])){
                        $this->load->view('header');
                        $this->load->view('invoice/publisher/publisher_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'publisher_name'=>$this->input->post('publisher_name'),
                            'publisher_address'=>$this->input->post('publisher_address'),
                            'publisher_gst_number'=>$this->input->post('publisher_gst_number'),
                            'publisher_status'=>$this->input->post('publisher_status'),
                        );
                        $editDataEntry = $this->DataModel->editData('publisher_id = '.$publisherID, PUBLISHER_TABLE, $editData);
                        if($editDataEntry){
                            $sessionPublisherViewPreviousUrl = $this->session->userdata('session_publisher_view_previous_url');
                            if(!empty($sessionPublisherViewPreviousUrl)){
                                redirect($sessionPublisherViewPreviousUrl);
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
