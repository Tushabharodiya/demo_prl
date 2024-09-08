<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Procedure extends CI_Controller {
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
	
    public function procedureNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(SOP_PROCEDURE_ALIAS, "can_add");
            if($isPermission){
                $this->load->view('header');
                $this->load->view('sop/procedure/procedure_new'); 
                $this->load->view('footer'); 
                if($this->input->post('submit')){
                    $newData = array(
                        'sop_title'=>$this->input->post('sop_title'),
                        'sop_description'=>$this->input->post('sop_description'),
                        'sop_department'=>$this->input->post('sop_department'),
                        'sop_purpose'=>$this->input->post('sop_purpose'),
                        'sop_outcomes'=>$this->input->post('sop_outcomes'),
                        'sop_responsibility'=>$this->input->post('sop_responsibility'),
                        'sop_created_by'=>$this->session->userdata['user_email'],
                        'sop_approved_by'=>'-',
                        'sop_updated_by'=>'-',
                        'sop_tag'=>$this->input->post('sop_tag'),
                        'sop_status'=>$this->input->post('sop_status'),
                        'trash_status'=>'false',
                    );
                    $sopID = $this->DataModel->insertData(SOP_PROCEDURE_TABLE, $newData);
                    if($sopID){
                        if(!empty($_FILES['sop_image']['name'])){ 
                            $filesCount = count($_FILES['sop_image']['name']); 
                            for($i = 0; $i < $filesCount; $i++){ 
                                $_FILES['file']['name']     = $_FILES['sop_image']['name'][$i]; 
                                $_FILES['file']['type']     = $_FILES['sop_image']['type'][$i]; 
                                $_FILES['file']['tmp_name'] = $_FILES['sop_image']['tmp_name'][$i]; 
                                $_FILES['file']['error']    = $_FILES['sop_image']['error'][$i]; 
                                $_FILES['file']['size']     = $_FILES['sop_image']['size'][$i]; 
                             
                                $uploadPath = 'uploads/sop/procedure/images/'; 
                                $config['upload_path'] = $uploadPath; 
                                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                                $config['file_name'] = timeStamp();
                             
                                $this->load->library('upload', $config); 
                                $this->upload->initialize($config); 
                             
                                if($this->upload->do_upload('file')){ 
                                    $fileData = $this->upload->data(); 
                                    $uploadData[$i]['sop_id'] = $sopID; 
                                    $uploadData[$i]['sop_image'] = $fileData['file_name']; 
                                    $uploadData[$i]['uploaded_on'] = timeZone(); 
                                } 
                            } 
                            $errorUpload = !empty($errorUpload)?' Upload Error: '.trim($errorUpload, ' | '):''; 
                            if(!empty($uploadData)){ 
                                $insertImage = $this->DataModel->insertImage($uploadData); 
                                redirect('view-sop-procedure'); 
                            } 
                        } 
                        redirect('view-sop-procedure');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function procedureView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_sop_procedure_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_sop_procedure');
            }
            if(isset($_POST['submit_search'])){
                $searchSopProcedure = $this->input->post('search_sop_procedure');
                $this->session->set_userdata('session_sop_procedure', $searchSopProcedure);
            }
            $sessionSopProcedure = $this->session->userdata('session_sop_procedure');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_sop_procedure_status');
                redirect('view-sop-procedure');
            }
                
            $searchSopProcedureStatus = $this->input->post('search_sop_procedure_status');
            if($searchSopProcedureStatus === 'true' or $searchSopProcedureStatus == 'false'){
                $this->session->set_userdata('session_sop_procedure_status', $searchSopProcedureStatus);
            } else if($searchSopProcedureStatus === 'all'){
                $this->session->unset_userdata('session_sop_procedure_status');
            }
            $sessionSopProcedureStatus = $this->session->userdata('session_sop_procedure_status');
            
            $data = array();
            //get rows count
            $conditions['search_sop_procedure'] = $sessionSopProcedure;
            $conditions['search_sop_procedure_status'] = $sessionSopProcedureStatus;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewProcedureData($conditions, SOP_PROCEDURE_TABLE);
    
            //pagination config
            $config['base_url']    = site_url('view-sop-procedure');
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
            
            $procedure = $this->DataModel->viewProcedureData($conditions, SOP_PROCEDURE_TABLE);
            $data['countProcedure'] = $this->DataModel->countProcedureData($conditions, SOP_PROCEDURE_TABLE);
            $data['countProcedureTrash'] = $this->DataModel->countProcedureTrashData($conditions, SOP_PROCEDURE_TABLE);
            
            $data['viewProcedure'] = array();
            if(is_array($procedure) || is_object($procedure)){
                foreach($procedure as $Row){
                    $dataArray = array();
                    $dataArray['sop_id'] = $Row['sop_id'];
                    $dataArray['sop_title'] = $Row['sop_title'];
                    $dataArray['sop_department'] = $Row['sop_department'];
                    $dataArray['sop_created_by'] = $Row['sop_created_by'];
                    $dataArray['sop_status'] = $Row['sop_status'];
                    array_push($data['viewProcedure'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('sop/procedure/procedure_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function imageInfo($sopID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(SOP_PROCEDURE_ALIAS, "can_view");
            if($isPermission){
                $sopID = urlDecodes($sopID);
                if(ctype_digit($sopID)){
                    if(!empty($sopID)){ 
                        $data['imageData'] = $this->DataModel->getRows($sopID); 
                        $data['sop_title'] = $data['imageData']['sop_title']; 
                        $this->load->view('header');
                        $this->load->view('sop/procedure/image_info', $data);
                        $this->load->view('footer');
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
    
    public function imageDelete(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(SOP_PROCEDURE_ALIAS, "can_delete");
            if($isPermission){ 
                $status  = 'err';  
                if($this->input->post('image_id')){ 
                    $imageID = $this->input->post('image_id'); 
                    $imgData = $this->DataModel->getImgRow($imageID); 
                    $con = array('image_id' => $imageID); 
                    $delete = $this->DataModel->deleteImage($con); 
                    if($delete){ 
                        @unlink('uploads/sop/procedure/images/'.$imgData['sop_image']);  
                        $status = 'ok';  
                    } 
                } 
                echo $status;die;
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function procedureInfo($sopID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(SOP_PROCEDURE_ALIAS, "can_view");
            if($isPermission){
                $sopID = urlDecodes($sopID);
                if(ctype_digit($sopID)){
                    $data['infoProcedure'] = $this->DataModel->viewData(null, 'sop_id = '.$sopID, SOP_PROCEDURE_TABLE);
                    if($data['infoProcedure'] != null){
            	        $this->load->view('header');
                		$this->load->view('sop/procedure/procedure_info', $data);
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
    
    public function procedureEdit($sopID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(SOP_PROCEDURE_ALIAS, "can_edit");
            if($isPermission){
                $sopID = urlDecodes($sopID);
                if(ctype_digit($sopID)){
                    $data['superUserData'] = $this->DataModel->getData('user_id = '.$this->session->userdata['user_id'], SUPER_USER_TABLE);
                    if($data['superUserData']){
                        $sopApprovedBy = $data['superUserData']['user_email'];   
                    } else {
                        $sopApprovedBy = "-";
                    }
                    
                    $data['imageData'] = $this->DataModel->getRows($sopID);
                    $data['procedureData'] = $this->DataModel->getData('sop_id = '.$sopID, SOP_PROCEDURE_TABLE);
                    if(!empty($data['procedureData'])){
                        $this->load->view('header');
                        $this->load->view('sop/procedure/procedure_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'sop_title'=>$this->input->post('sop_title'),
                            'sop_description'=>$this->input->post('sop_description'),
                            'sop_department'=>$this->input->post('sop_department'),
                            'sop_purpose'=>$this->input->post('sop_purpose'),
                            'sop_outcomes'=>$this->input->post('sop_outcomes'),
                            'sop_responsibility'=>$this->input->post('sop_responsibility'),
                            'sop_approved_by'=>$sopApprovedBy,
                            'sop_updated_by'=>$this->session->userdata['user_email'],
                            'sop_tag'=>$this->input->post('sop_tag'),
                            'sop_status'=>$this->input->post('sop_status'),
                        );
                        $newSopID = $this->DataModel->editData('sop_id = '.$sopID, SOP_PROCEDURE_TABLE, $editData);
                        if($newSopID){
                            if(!empty($_FILES['sop_image']['name'])){ 
                                $filesCount = count($_FILES['sop_image']['name']); 
                                for($i = 0; $i < $filesCount; $i++){ 
                                    $_FILES['file']['name']     = $_FILES['sop_image']['name'][$i]; 
                                    $_FILES['file']['type']     = $_FILES['sop_image']['type'][$i]; 
                                    $_FILES['file']['tmp_name'] = $_FILES['sop_image']['tmp_name'][$i]; 
                                    $_FILES['file']['error']    = $_FILES['sop_image']['error'][$i]; 
                                    $_FILES['file']['size']     = $_FILES['sop_image']['size'][$i]; 
                                 
                                    $uploadPath = 'uploads/sop/procedure/images/'; 
                                    $config['upload_path'] = $uploadPath; 
                                    $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                                    $config['file_name'] = timeStamp();
                                 
                                    $this->load->library('upload', $config); 
                                    $this->upload->initialize($config); 
                                 
                                    if($this->upload->do_upload('file')){ 
                                        $fileData = $this->upload->data(); 
                                        $uploadData[$i]['sop_id'] = $sopID; 
                                        $uploadData[$i]['sop_image'] = $fileData['file_name']; 
                                        $uploadData[$i]['uploaded_on'] = timeZone(); 
                                    } 
                                } 
                                $errorUpload = !empty($errorUpload)?' Upload Error: '.trim($errorUpload, ' | '):''; 
                                if(!empty($uploadData)){ 
                                    $insertImage = $this->DataModel->insertImage($uploadData); 
                                    $sessionSopProcedureViewPreviousUrl = $this->session->userdata('session_sop_procedure_view_previous_url');
                                    if(!empty($sessionSopProcedureViewPreviousUrl)){
                                        redirect($sessionSopProcedureViewPreviousUrl);
                                    }
                                } 
                            }
                            $sessionSopProcedureViewPreviousUrl = $this->session->userdata('session_sop_procedure_view_previous_url');
                            if(!empty($sessionSopProcedureViewPreviousUrl)){
                                redirect($sessionSopProcedureViewPreviousUrl);
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
    
    public function procedureTrash($sopID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $sopID = urlDecodes($sopID);
                    if(ctype_digit($sopID)){
                        $departmentData = $this->DataModel->viewData(null, 'FIND_IN_SET('.$sopID.', department_permission)', SOP_DEPARTMENT_TABLE);
                        $departmentDataFound = null;
                        if($departmentData){
                            foreach($departmentData as $departmentRow){
                                $departmentSopIDs = $departmentRow['department_permission'];
                                $departmentSopArray = explode(",",$departmentSopIDs);
                                foreach($departmentSopArray as $row){
                                    $departmentSopID = $row;
                                    for($x = $departmentSopID; $x == $sopID; $x++){
                                        $departmentDataFound = true;
                                    } 
                                }
                            }
                        }
                        
                        $userData = $this->DataModel->viewData(null, 'FIND_IN_SET('.$sopID.', user_permission)', SOP_USER_TABLE);
                        $userDataFound = null;
                        if($userData){
                            foreach($userData as $userRow){
                                $userSopIDs = $userRow['user_permission'];
                                $userSopArray = explode(",",$userSopIDs);
                                foreach($userSopArray as $row){
                                    $userSopID = $row;
                                    for($x = $userSopID; $x == $sopID; $x++){
                                        $userDataFound = true;
                                    } 
                                }
                            }
                        }
    
                        $imageData = $this->DataModel->getData('sop_id = '.$sopID, SOP_IMAGE_TABLE);
                        
                        if($departmentDataFound === true){
                            $this->session->set_userdata('session_sop_procedure_trash_sop_department', "You can't trash the procedure!");
                            $sessionSopProcedureViewPreviousUrl = $this->session->userdata('session_sop_procedure_view_previous_url');
                            if(!empty($sessionSopProcedureViewPreviousUrl)){
                                redirect($sessionSopProcedureViewPreviousUrl);
                            }
                        } else if($userDataFound === true){
                            $this->session->set_userdata('session_sop_procedure_trash_sop_user', "You can't trash the procedure!");
                            $sessionSopProcedureViewPreviousUrl = $this->session->userdata('session_sop_procedure_view_previous_url');
                            if(!empty($sessionSopProcedureViewPreviousUrl)){
                                redirect($sessionSopProcedureViewPreviousUrl);
                            }
                        } else if(!empty($imageData)) {
                            $url = 'info-sop-image/' . urlEncodes($sopID);
                            $this->session->set_userdata('session_sop_procedure_trash_sop_image', "You can't trash the procedure! Please delete <a href='" . base_url($url) . "' class='alert-link'>sop image</a> before trashing procedure ");
                            $sessionSopProcedureViewPreviousUrl = $this->session->userdata('session_sop_procedure_view_previous_url');
                            if(!empty($sessionSopProcedureViewPreviousUrl)){
                                redirect($sessionSopProcedureViewPreviousUrl);
                            }
                        } else {
                            $editData = array(
                                'trash_status'=>'true',
                            );
                            $editDataEntry = $this->DataModel->editData('sop_id = '.$sopID, SOP_PROCEDURE_TABLE, $editData);
                            if($editDataEntry){
                                $this->session->set_userdata('session_sop_procedure_trash_success','Your procedure has been trash successfully!');
                                $sessionSopProcedureViewPreviousUrl = $this->session->userdata('session_sop_procedure_view_previous_url');
                                if(!empty($sessionSopProcedureViewPreviousUrl)){
                                    redirect($sessionSopProcedureViewPreviousUrl);
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
    
    public function procedureTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_sop_procedure_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_sop_procedure_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchSopProcedureTrash = $this->input->post('search_sop_procedure_trash');
                        $this->session->set_userdata('session_sop_procedure_trash', $searchSopProcedureTrash);
                    }
                    $sessionSopProcedureTrash = $this->session->userdata('session_sop_procedure_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_sop_procedure_trash_status');
                        redirect('view-trash-sop-procedure');
                    }
                        
                    $searchSopProcedureTrashStatus = $this->input->post('search_sop_procedure_trash_status');
                    if($searchSopProcedureTrashStatus === 'true' or $searchSopProcedureTrashStatus == 'false'){
                        $this->session->set_userdata('session_sop_procedure_trash_status', $searchSopProcedureTrashStatus);
                    } else if($searchSopProcedureTrashStatus === 'all'){
                        $this->session->unset_userdata('session_sop_procedure_trash_status');
                    }
                    $sessionSopProcedureTrashStatus = $this->session->userdata('session_sop_procedure_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_sop_procedure_trash'] = $sessionSopProcedureTrash;
                    $conditions['search_sop_procedure_trash_status'] = $sessionSopProcedureTrashStatus;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewProcedureTrashData($conditions, SOP_PROCEDURE_TABLE);
            
                    //pagination config
                    $config['base_url']    = site_url('view-trash-sop-procedure');
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
                    
                    $procedure = $this->DataModel->viewProcedureTrashData($conditions, SOP_PROCEDURE_TABLE);
                    $data['countProcedure'] = $this->DataModel->countProcedureTrashData($conditions, SOP_PROCEDURE_TABLE);

                    $data['viewProcedure'] = array();
                    if(is_array($procedure) || is_object($procedure)){
                        foreach($procedure as $Row){
                            $dataArray = array();
                            $dataArray['sop_id'] = $Row['sop_id'];
                            $dataArray['sop_title'] = $Row['sop_title'];
                            $dataArray['sop_department'] = $Row['sop_department'];
                            $dataArray['sop_created_by'] = $Row['sop_created_by'];
                            $dataArray['sop_status'] = $Row['sop_status'];
                            array_push($data['viewProcedure'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('sop/procedure/procedure_trash_view', $data);
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
    
    public function procedureRestore($sopID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $sopID = urlDecodes($sopID);
                    if(ctype_digit($sopID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('sop_id = '.$sopID, SOP_PROCEDURE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_sop_procedure_restore_success','Your procedure has been restore successfully!');
                            $sessionSopProcedureTrashViewPreviousUrl = $this->session->userdata('session_sop_procedure_trash_view_previous_url');
                            if(!empty($sessionSopProcedureTrashViewPreviousUrl)){
                                redirect($sessionSopProcedureTrashViewPreviousUrl);
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
    
    public function procedureDelete($sopID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $sopID = urlDecodes($sopID);
                    if(ctype_digit($sopID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                $resultDataEntry = $this->DataModel->deleteData('sop_id = '.$sopID, SOP_PROCEDURE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_sop_procedure_delete_success','Your procedure has been delete successfully!');
                                    $sessionSopProcedureTrashViewPreviousUrl = $this->session->userdata('session_sop_procedure_trash_view_previous_url');
                                    if(!empty($sessionSopProcedureTrashViewPreviousUrl)){
                                        redirect($sessionSopProcedureTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_sop_procedure_delete_error','Your password are not matched! Please enter correct password');
                                $sessionSopProcedureTrashViewPreviousUrl = $this->session->userdata('session_sop_procedure_trash_view_previous_url');
                                if(!empty($sessionSopProcedureTrashViewPreviousUrl)){
                                    redirect($sessionSopProcedureTrashViewPreviousUrl);
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
