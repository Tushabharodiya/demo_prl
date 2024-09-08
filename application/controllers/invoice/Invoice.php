<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {
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
	
    public function invoiceNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(INVOICE_ALIAS, "can_add");
            if($isPermission){
                $data['publisherData'] = $this->DataModel->viewData(null, null, PUBLISHER_TABLE);
                $data['advertiserData'] = $this->DataModel->viewData(null, null, ADVERTISER_TABLE);
                $this->load->view('header');
                $this->load->view('invoice/invoice/invoice_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'invoice_number'=>$this->input->post('invoice_number'),
			    		'publisher_id'=>$this->input->post('publisher_id'),
			    		'advertiser_id'=>$this->input->post('advertiser_id'),
			    		'invoice_generate_date'=>$this->input->post('invoice_generate_date'),
			    		'invoice_due_date'=>$this->input->post('invoice_due_date'),
			    		'invoice_description'=>$this->input->post('invoice_description'),
			    		'invoice_hsn_code'=>$this->input->post('invoice_hsn_code'),
			    		'invoice_quantity'=>$this->input->post('invoice_quantity'),
			    		'invoice_price'=>$this->input->post('invoice_price'),
			    		'invoice_sgst'=>$this->input->post('invoice_sgst'),
			    		'invoice_cgst'=>$this->input->post('invoice_cgst'),
			    		'invoice_status'=>$this->input->post('invoice_status'),
			    		'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(INVOICE_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-invoice');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function invoiceView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_invoice_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_invoice');
            }
            if(isset($_POST['submit_search'])){
                $searchInvoice = $this->input->post('search_invoice');
                $this->session->set_userdata('session_invoice', $searchInvoice);
            }
            $sessionInvoice = $this->session->userdata('session_invoice');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_invoice_status');
                redirect('view-invoice');
            }
                
            $searchInvoiceStatus = $this->input->post('search_invoice_status');
            if($searchInvoiceStatus === 'active' or $searchInvoiceStatus == 'blocked'){
                $this->session->set_userdata('session_invoice_status', $searchInvoiceStatus);
            } else if($searchInvoiceStatus === 'all'){
                $this->session->unset_userdata('session_invoice_status');
            }
            $sessionInvoiceStatus = $this->session->userdata('session_invoice_status');
            
            $data = array();
            //get rows count
            $conditions['search_invoice'] = $sessionInvoice;
            $conditions['search_invoice_status'] = $sessionInvoiceStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewInvoiceData($conditions, INVOICE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-invoice');
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
            
            $invoice = $this->DataModel->viewInvoiceData($conditions, INVOICE_TABLE);
            $data['countInvoice'] = $this->DataModel->countInvoiceData($conditions, INVOICE_TABLE);
            $data['countInvoiceTrash'] = $this->DataModel->countInvoiceTrashData($conditions, INVOICE_TABLE);
            
            $data['viewInvoice'] = array();
            if(is_array($invoice) || is_object($invoice)){
                foreach($invoice as $Row){
                    $dataArray = array();
                    $dataArray['invoice_id'] = $Row['invoice_id'];
                    $dataArray['invoice_number'] = $Row['invoice_number'];
                    $dataArray['advertiser_id'] = $Row['advertiser_id'];
                    $dataArray['invoice_generate_date'] = $Row['invoice_generate_date'];
                    $dataArray['invoice_due_date'] = $Row['invoice_due_date'];
                    $dataArray['invoice_price'] = $Row['invoice_price'];
                    $dataArray['invoice_status'] = $Row['invoice_status'];
                    $dataArray['advertiserData'] = $this->DataModel->getData('advertiser_id = '.$dataArray['advertiser_id'], ADVERTISER_TABLE);
                    array_push($data['viewInvoice'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('invoice/invoice/invoice_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function invoiceDetail($invoiceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(INVOICE_ALIAS, "can_view");
            if($isPermission){
                $invoiceID = urlDecodes($invoiceID);
                if(ctype_digit($invoiceID)){
            		$invoice = $this->DataModel->viewData(null, 'invoice_id = '.$invoiceID, INVOICE_TABLE);
        	        $data['detailInvoice'] = array();
                    if(is_array($invoice) || is_object($invoice)){
                        foreach($invoice as $Row){
                            $dataArray = array();
                            $dataArray['invoice_id'] = $Row['invoice_id'];
                            $dataArray['invoice_number'] = $Row['invoice_number'];
                            $dataArray['publisher_id'] = $Row['publisher_id'];
                            $dataArray['advertiser_id'] = $Row['advertiser_id'];
                            $dataArray['invoice_generate_date'] = $Row['invoice_generate_date'];
                            $dataArray['invoice_due_date'] = $Row['invoice_due_date'];
                            $dataArray['invoice_description'] = $Row['invoice_description'];
                            $dataArray['invoice_hsn_code'] = $Row['invoice_hsn_code'];
                            $dataArray['invoice_quantity'] = $Row['invoice_quantity'];
                            $dataArray['invoice_price'] = $Row['invoice_price'];
                            $dataArray['invoice_sgst'] = $Row['invoice_sgst'];
                            $dataArray['invoice_cgst'] = $Row['invoice_cgst'];
                            $dataArray['publisherData'] = $this->DataModel->getData('publisher_id = '.$dataArray['publisher_id'], PUBLISHER_TABLE);
	                        $dataArray['advertiserData'] = $this->DataModel->getData('advertiser_id = '.$dataArray['advertiser_id'], ADVERTISER_TABLE);
                            array_push($data['detailInvoice'], $dataArray);
                        }
                    }
                    if($data['detailInvoice'] != null){
            	        $this->load->view('header');
                		$this->load->view('invoice/invoice/invoice_detail', $data);
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
    
    public function invoiceEdit($invoiceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(INVOICE_ALIAS, "can_edit");
            if($isPermission){
                $invoiceID = urlDecodes($invoiceID);
                if(ctype_digit($invoiceID)){
                    $data['invoiceData'] = $this->DataModel->getData('invoice_id = '.$invoiceID, INVOICE_TABLE);
                    
                    $data['viewPublisher'] = $this->DataModel->viewData(null, null, PUBLISHER_TABLE);
                    $publisherID = $data['invoiceData']['publisher_id'];
                    $data['publisherData'] = $this->DataModel->getData('publisher_id = '.$publisherID, PUBLISHER_TABLE);

                    $data['viewAdvertiser'] = $this->DataModel->viewData(null, null, ADVERTISER_TABLE);
                    $advertiserID = $data['invoiceData']['advertiser_id'];
                    $data['advertiserData'] = $this->DataModel->getData('advertiser_id = '.$advertiserID, ADVERTISER_TABLE);
                    
                    if(!empty($data['invoiceData'])){
                        $this->load->view('header');
                        $this->load->view('invoice/invoice/invoice_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'invoice_number'=>$this->input->post('invoice_number'),
    			    		'publisher_id'=>$this->input->post('publisher_id'),
    			    		'advertiser_id'=>$this->input->post('advertiser_id'),
    			    		'invoice_generate_date'=>$this->input->post('invoice_generate_date'),
    			    		'invoice_due_date'=>$this->input->post('invoice_due_date'),
    			    		'invoice_description'=>$this->input->post('invoice_description'),
    			    		'invoice_hsn_code'=>$this->input->post('invoice_hsn_code'),
    			    		'invoice_quantity'=>$this->input->post('invoice_quantity'),
    			    		'invoice_price'=>$this->input->post('invoice_price'),
    			    		'invoice_sgst'=>$this->input->post('invoice_sgst'),
    			    		'invoice_cgst'=>$this->input->post('invoice_cgst'),
    			    		'invoice_status'=>$this->input->post('invoice_status'),
                        );
                        $editDataEntry = $this->DataModel->editData('invoice_id = '.$invoiceID, INVOICE_TABLE, $editData);
                        if($editDataEntry){
                            $sessionInvoiceViewPreviousUrl = $this->session->userdata('session_invoice_view_previous_url');
                            if(!empty($sessionInvoiceViewPreviousUrl)){
                                redirect($sessionInvoiceViewPreviousUrl);
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
    
    public function invoiceTrash($invoiceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $invoiceID = urlDecodes($invoiceID);
                    if(ctype_digit($invoiceID)){
                        $editData = array(
                            'trash_status'=>'true',
                        );
                        $editDataEntry = $this->DataModel->editData('invoice_id = '.$invoiceID, INVOICE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_invoice_trash_success','Your invoice has been trash successfully!');
                            $sessionInvoiceViewPreviousUrl = $this->session->userdata('session_invoice_view_previous_url');
                            if(!empty($sessionInvoiceViewPreviousUrl)){
                                redirect($sessionInvoiceViewPreviousUrl);
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
    
    public function invoiceTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    
                    $this->session->set_userdata('session_invoice_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_invoice_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchInvoiceTrash = $this->input->post('search_invoice_trash');
                        $this->session->set_userdata('session_invoice_trash', $searchInvoiceTrash);
                    }
                    $sessionInvoiceTrash = $this->session->userdata('session_invoice_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_invoice_trash_status');
                        redirect('view-trash-invoice');
                    }
                        
                    $searchInvoiceTrashStatus = $this->input->post('search_invoice_trash_status');
                    if($searchInvoiceTrashStatus === 'active' or $searchInvoiceTrashStatus == 'blocked'){
                        $this->session->set_userdata('session_invoice_trash_status', $searchInvoiceTrashStatus);
                    } else if($searchInvoiceTrashStatus === 'all'){
                        $this->session->unset_userdata('session_invoice_trash_status');
                    }
                    $sessionInvoiceTrashStatus = $this->session->userdata('session_invoice_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_invoice_trash'] = $sessionInvoiceTrash;
                    $conditions['search_invoice_trash_status'] = $sessionInvoiceTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewInvoiceTrashData($conditions, INVOICE_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-invoice');
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
                    
                    $invoice = $this->DataModel->viewInvoiceTrashData($conditions, INVOICE_TABLE);
                    $data['countInvoice'] = $this->DataModel->countInvoiceTrashData($conditions, INVOICE_TABLE);
                    
                    $data['viewInvoice'] = array();
                    if(is_array($invoice) || is_object($invoice)){
                        foreach($invoice as $Row){
                            $dataArray = array();
                            $dataArray['invoice_id'] = $Row['invoice_id'];
                            $dataArray['invoice_number'] = $Row['invoice_number'];
                            $dataArray['advertiser_id'] = $Row['advertiser_id'];
                            $dataArray['invoice_generate_date'] = $Row['invoice_generate_date'];
                            $dataArray['invoice_due_date'] = $Row['invoice_due_date'];
                            $dataArray['invoice_price'] = $Row['invoice_price'];
                            $dataArray['invoice_status'] = $Row['invoice_status'];
                            $dataArray['advertiserData'] = $this->DataModel->getData('advertiser_id = '.$dataArray['advertiser_id'], ADVERTISER_TABLE);
                            array_push($data['viewInvoice'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('invoice/invoice/invoice_trash_view', $data);
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
    
    public function invoiceRestore($invoiceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $invoiceID = urlDecodes($invoiceID);
                    if(ctype_digit($invoiceID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('invoice_id = '.$invoiceID, INVOICE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_invoice_restore_success','Your invoice has been restore successfully!');
                            $sessionInvoiceTrashViewPreviousUrl = $this->session->userdata('session_invoice_trash_view_previous_url');
                            if(!empty($sessionInvoiceTrashViewPreviousUrl)){
                                redirect($sessionInvoiceTrashViewPreviousUrl);
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
    
    public function invoiceDelete($invoiceID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $invoiceID = urlDecodes($invoiceID);
                    if(ctype_digit($invoiceID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('invoice_id = '.$invoiceID, INVOICE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_invoice_delete_success','Your invoice has been delete successfully!');
                                    $sessionInvoiceTrashViewPreviousUrl = $this->session->userdata('session_invoice_trash_view_previous_url');
                                    if(!empty($sessionInvoiceTrashViewPreviousUrl)){
                                        redirect($sessionInvoiceTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_invoice_delete_error','Your password are not matched! Please enter correct password');
                                $sessionInvoiceTrashViewPreviousUrl = $this->session->userdata('session_invoice_trash_view_previous_url');
                                if(!empty($sessionInvoiceTrashViewPreviousUrl)){
                                    redirect($sessionInvoiceTrashViewPreviousUrl);
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
