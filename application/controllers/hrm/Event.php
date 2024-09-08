<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
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
    
    public function eventNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EVENT_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('hrm/event/event_view');
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $newData = array(
                        'event_title'=>$this->input->post('event_title'),
                        'event_start_date'=>$this->input->post('event_start_date'),
                        'event_end_date'=>$this->input->post('event_end_date'),
                        'event_start_time'=>$this->input->post('event_start_time'),
                        'event_end_time'=>$this->input->post('event_end_time'),
                        'event_description'=>$this->input->post('event_description'),
                        'event_category'=>$this->input->post('event_category'),
                        'event_post'=>$this->input->post('event_post'),
                        'event_type'=>$this->input->post('event_type'),
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_EVENT_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-event');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function eventView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $event = $this->DataModel->viewData('event_id '.'DESC','MONTH(STR_TO_DATE(event_start_date, "%d/%m/%Y")) = '.date('m').' And YEAR(STR_TO_DATE(event_start_date, "%d/%m/%Y")) = '.date('Y').'', HRM_EVENT_TABLE);
            
            $data['viewEvent'] = array();
            if(is_array($event) || is_object($event)){
                foreach($event as $Row){
                    $dataArray = array();
                    $dataArray['event_id'] = $Row['event_id'];
                    $dataArray['event_title'] = $Row['event_title'];
                    $dataArray['event_start_date'] = $Row['event_start_date'];
                    $dataArray['event_end_date'] = $Row['event_end_date'];
                    $dataArray['event_start_time'] = $Row['event_start_time'];
                    $dataArray['event_end_time'] = $Row['event_end_time'];
                    $dataArray['event_description'] = $Row['event_description'];
                    $dataArray['event_category'] = $Row['event_category'];
                    $dataArray['event_post'] = $Row['event_post'];
                    $dataArray['event_type'] = $Row['event_type'];
                    array_push($data['viewEvent'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/event/event_view', $data);
            $this->load->view('footer');
            
            $isPermissionEventAdd = checkPermission(HRM_EVENT_ALIAS, "can_add");
            
            if($this->input->post('submit_event_new')){
                if($isPermissionEventAdd){
                    $newData = array(
                        'event_title'=>$this->input->post('event_title'),
                        'event_start_date'=>$this->input->post('event_start_date'),
                        'event_end_date'=>$this->input->post('event_end_date'),
                        'event_start_time'=>$this->input->post('event_start_time'),
                        'event_end_time'=>$this->input->post('event_end_time'),
                        'event_description'=>$this->input->post('event_description'),
                        'event_category'=>$this->input->post('event_category'),
                        'event_post'=>implode(",",$this->input->post('event_post[]')),
                        'event_type'=>$this->input->post('event_type'),
                        'trash_status'=> 'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_EVENT_TABLE, $newData);
                    if($newDataEntry){
                        $this->session->set_userdata('session_event_view_new_success','Your event has been added successfully!');
                        redirect('view-event');
                    }
                } else {
                    redirect('permission-denied');
                }
            }
        } else {
            redirect('logout');
        }
    }
}
