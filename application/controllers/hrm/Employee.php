<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
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
	
    public function employeeNew(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_ALIAS, "can_add");
            if($isPermission){
                $data['departmentData'] = $this->DataModel->viewData(null, null, DEPARTMENT_TABLE);
                $this->load->view('header');
                $this->load->view('hrm/employee/employee_new', $data);
                $this->load->view('footer');
                if($this->input->post('submit')){
                    $serialNoData = $this->DataModel->getSerialNoData();
                    $employeeSerialNo = $serialNoData ? $serialNoData + 1 : 1;
                    
                    $newData = array(
                        'department_id'=>$this->input->post('department_id'),
                        'employee_serial_no'=>$employeeSerialNo,
                        'employee_first_name'=>$this->input->post('employee_first_name'),
                        'employee_middle_name'=>$this->input->post('employee_middle_name'),
                        'employee_last_name'=>$this->input->post('employee_last_name'),
                        'employee_email'=>$this->input->post('employee_email'),
                        'employee_correspondence_address'=>$this->input->post('employee_correspondence_address'),
                        'employee_permanent_address'=>$this->input->post('employee_permanent_address'),
                        'employee_telephone_no'=>$this->input->post('employee_telephone_no'),
                        'employee_mobile_no'=>$this->input->post('employee_mobile_no'),
                        'employee_birth_date'=>$this->input->post('employee_birth_date'),
                        'employee_blood_group'=>$this->input->post('employee_blood_group'),
                        'employee_marital_status'=>$this->input->post('employee_marital_status'),
                        'employee_emergency_contact_name'=>$this->input->post('employee_emergency_contact_name'),
                        'employee_emergency_contact_relation'=>$this->input->post('employee_emergency_contact_relation'),
                        'employee_emergency_contact_no'=>$this->input->post('employee_emergency_contact_no'),
                        'employee_educational_degree'=>implode("#",$this->input->post('employee_educational_degree')),
                        'employee_educational_university_institute'=>implode("#",$this->input->post('employee_educational_university_institute')),
                        'employee_educational_start_year'=>implode("#",$this->input->post('employee_educational_start_year')),
                        'employee_educational_end_year'=>implode("#",$this->input->post('employee_educational_end_year')),
                        'employee_educational_percentage_grade'=>implode("#",$this->input->post('employee_educational_percentage_grade')),
                        'employee_educational_specialisation'=>implode("#",$this->input->post('employee_educational_specialisation')),
                        'employee_employeement_organisation'=>implode("#",$this->input->post('employee_employeement_organisation')),
                        'employee_employeement_designation'=>implode("#",$this->input->post('employee_employeement_designation')),
                        'employee_employeement_start_date'=>implode("#",$this->input->post('employee_employeement_start_date')),
                        'employee_employeement_end_date'=>implode("#",$this->input->post('employee_employeement_end_date')),
                        'employee_employeement_annual_ctc'=>implode("#",$this->input->post('employee_employeement_annual_ctc')),
                        'employee_family_member_name'=>implode("#",$this->input->post('employee_family_member_name')),
                        'employee_family_member_relation'=>implode("#",$this->input->post('employee_family_member_relation')),
                        'employee_family_member_occupation'=>implode("#",$this->input->post('employee_family_member_occupation')),
                        'employee_family_member_birth_date'=>implode("#",$this->input->post('employee_family_member_birth_date')),
                        'employee_professional_reference_name'=>implode("#",$this->input->post('employee_professional_reference_name')),
                        'employee_professional_reference_organisation'=>implode("#",$this->input->post('employee_professional_reference_organisation')),
                        'employee_professional_reference_designation'=>implode("#",$this->input->post('employee_professional_reference_designation')),
                        'employee_professional_reference_contact_no'=>implode("#",$this->input->post('employee_professional_reference_contact_no')),
                        'employee_created_date'=>todayDate(),
                        'employee_place'=>$this->input->post('employee_place'),
                        'employee_signature'=>$this->input->post('employee_signature'),
                        'is_employee'=>'pending',
                        'employee_status'=>'draft',
                        'trash_status'=>'false',
                    );
                    $newDataEntry = $this->DataModel->insertData(HRM_EMPLOYEE_TABLE, $newData);
                    if($newDataEntry){
                        redirect('view-employee');  
                    }
                }
            } else {
                redirect('permission-denied');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function employeeView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){

            $this->session->set_userdata('session_employee_view_previous_url', current_url());

            if(isset($_POST['reset_search'])){
                $this->session->unset_userdata('session_employee');
            }
            if(isset($_POST['submit_search'])){
                $searchEmployee = $this->input->post('search_employee');
                $this->session->set_userdata('session_employee', $searchEmployee);
            }
            $sessionEmployee = $this->session->userdata('session_employee');
            
            if(isset($_POST['reset_filter'])){
                $this->session->unset_userdata('session_employee_is_employee');
                $this->session->unset_userdata('session_employee_type');
                $this->session->unset_userdata('session_employee_status');
                $this->session->unset_userdata('session_employee_created_start_date');
                $this->session->unset_userdata('session_employee_created_end_date');
                redirect('view-employee');
            }
            if(isset($_POST['submit_filter'])){
                $searchEmployeeCreatedStartDate = $this->input->post('search_employee_created_start_date');
                $searchEmployeeCreatedEndDate = $this->input->post('search_employee_created_end_date');
                
                $this->session->set_userdata('session_employee_created_start_date', $searchEmployeeCreatedStartDate);
                $this->session->set_userdata('session_employee_created_end_date', $searchEmployeeCreatedEndDate);
            }
            $sessionEmployeeCreatedStartDate = $this->session->userdata('session_employee_created_start_date');
            $sessionEmployeeCreatedEndDate = $this->session->userdata('session_employee_created_end_date');
            
            $searchEmployeeIsEmployee = $this->input->post('search_employee_is_employee');
            if($searchEmployeeIsEmployee === 'pending' or $searchEmployeeIsEmployee == 'selected' or $searchEmployeeIsEmployee == 'rejected'){
                $this->session->set_userdata('session_employee_is_employee', $searchEmployeeIsEmployee);
            } else if($searchEmployeeIsEmployee === 'all'){
                $this->session->unset_userdata('session_employee_is_employee');
            }
            $sessionEmployeeIsEmployee = $this->session->userdata('session_employee_is_employee');
            
            $searchEmployeeType = $this->input->post('search_employee_type');
            if($searchEmployeeType === 'intern' or $searchEmployeeType == 'employee'){
                $this->session->set_userdata('session_employee_type', $searchEmployeeType);
            } else if($searchEmployeeType === 'all'){
                $this->session->unset_userdata('session_employee_type');
            }
            $sessionEmployeeType = $this->session->userdata('session_employee_type');

            $searchEmployeeStatus = $this->input->post('search_employee_status');
            if($searchEmployeeStatus === 'draft' or $searchEmployeeStatus == 'active' or $searchEmployeeStatus == 'inactive'){
                $this->session->set_userdata('session_employee_status', $searchEmployeeStatus);
            } else if($searchEmployeeStatus === 'all'){
                $this->session->unset_userdata('session_employee_status');
            }
            $sessionEmployeeStatus = $this->session->userdata('session_employee_status');
            
            $data = array();
            //get rows count
            $conditions['search_employee'] = $sessionEmployee;
            $conditions['search_employee_is_employee'] = $sessionEmployeeIsEmployee;
            $conditions['search_employee_type'] = $sessionEmployeeType;
            $conditions['search_employee_status'] = $sessionEmployeeStatus;
            $conditions['search_employee_created_start_date'] = $sessionEmployeeCreatedStartDate;
            $conditions['search_employee_created_end_date'] = $sessionEmployeeCreatedEndDate;
            $conditions['returnType'] = 'count';
            
            $totalRec = $this->DataModel->viewEmployeeData($conditions, HRM_EMPLOYEE_TABLE);

            //pagination config
            $config['base_url']    = site_url('view-employee');
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
            
            $employee = $this->DataModel->viewEmployeeData($conditions, HRM_EMPLOYEE_TABLE);
            $data['countEmployee'] = $this->DataModel->countEmployeeData($conditions, HRM_EMPLOYEE_TABLE);
            $data['countEmployeeTrash'] = $this->DataModel->countEmployeeTrashData($conditions, HRM_EMPLOYEE_TABLE);

            $data['viewEmployee'] = array();
            if(is_array($employee) || is_object($employee)){
                foreach($employee as $Row){
                    $dataArray = array();
                    $dataArray['employee_id'] = $Row['employee_id'];
                    $dataArray['department_id'] = $Row['department_id'];
                    $dataArray['employee_first_name'] = $Row['employee_first_name'];
                    $dataArray['employee_middle_name'] = $Row['employee_middle_name'];
                    $dataArray['employee_last_name'] = $Row['employee_last_name'];
                    $dataArray['employee_email'] = $Row['employee_email'];
                    $dataArray['employee_photo'] = $Row['employee_photo'];
                    $dataArray['employee_mobile_no'] = $Row['employee_mobile_no'];
                    $dataArray['employee_created_date'] = $Row['employee_created_date'];
                    $dataArray['hr_review'] = $Row['hr_review'];
                    $dataArray['admin_review'] = $Row['admin_review'];
                    $dataArray['technical_review'] = $Row['technical_review'];
                    $dataArray['is_employee'] = $Row['is_employee'];
                    $dataArray['employee_ref_from'] = $Row['employee_ref_from'];
                    $dataArray['employee_joining_date'] = $Row['employee_joining_date'];
                    $dataArray['employee_leaving_date'] = $Row['employee_leaving_date'];
                    $dataArray['employee_access_card_no'] = $Row['employee_access_card_no'];
                    $dataArray['employee_qualification'] = $Row['employee_qualification'];
                    $dataArray['employee_gender'] = $Row['employee_gender'];
                    $dataArray['employee_pan_front_image'] = $Row['employee_pan_front_image'];
                    $dataArray['employee_pan_back_image'] = $Row['employee_pan_back_image'];
                    $dataArray['employee_aadhar_front_image'] = $Row['employee_aadhar_front_image'];
                    $dataArray['employee_aadhar_back_image'] = $Row['employee_aadhar_back_image'];
                    $dataArray['employee_residential_proof_image'] = $Row['employee_residential_proof_image'];
                    $dataArray['employee_type'] = $Row['employee_type'];
                    $dataArray['employee_internship_month'] = $Row['employee_internship_month'];
                    $dataArray['employee_stipend'] = $Row['employee_stipend'];
                    $dataArray['employee_contract_date'] = $Row['employee_contract_date'];
                    $dataArray['employee_compensation'] = $Row['employee_compensation'];
                    $dataArray['employee_salary'] = $Row['employee_salary'];
                    $dataArray['employee_bank_name'] = $Row['employee_bank_name'];
                    $dataArray['employee_account_no'] = $Row['employee_account_no'];
                    $dataArray['employee_cheque_no'] = $Row['employee_cheque_no'];
                    $dataArray['employee_consent_name'] = $Row['employee_consent_name'];
                    $dataArray['employee_cheque_image'] = $Row['employee_cheque_image'];
                    $dataArray['employee_experience_certificate_image'] = $Row['employee_experience_certificate_image'];
                    $dataArray['employee_relieving_letter_image'] = $Row['employee_relieving_letter_image'];
                    $dataArray['employee_salary_slip_image'] = $Row['employee_salary_slip_image'];
                    $dataArray['employee_status'] = $Row['employee_status'];
                    $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                    array_push($data['viewEmployee'], $dataArray);
                }
            }
            $this->load->view('header');
            $this->load->view('hrm/employee/employee_view', $data);
            $this->load->view('footer');
        } else {
            redirect('logout');
        }
    }
    
    public function employeeSelectionEdit($employeeID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_SELECTION_ALIAS, "can_edit");
            if($isPermission){
                $employeeID = urlDecodes($employeeID);
                if(ctype_digit($employeeID)){
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    if($this->input->post('submit_selection')){
                        if(!empty($_FILES['employee_pan_front_image']['name'])){
                            $config['upload_path'] = 'uploads/hrm/employee_pan_front_image/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                            $config['file_name'] = timeStamp();
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('employee_pan_front_image')){
                                if(!empty($data['employeeData']['employee_pan_front_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_pan_front_image/'.$data['employeeData']['employee_pan_front_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $uploadData = $this->upload->data();
                                $employeePanFrontImage = $uploadData['file_name'];
                            } else {
                                $employeePanFrontImage = $data['employeeData']['employee_pan_front_image'];
                            }
                        } else {
                            $employeePanFrontImage = $data['employeeData']['employee_pan_front_image'];
                        }
                        
                        if(!empty($_FILES['employee_pan_back_image']['name'])){
                            $config['upload_path'] = 'uploads/hrm/employee_pan_back_image/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                            $config['file_name'] = timeStamp();
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('employee_pan_back_image')){
                                if(!empty($data['employeeData']['employee_pan_back_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_pan_back_image/'.$data['employeeData']['employee_pan_back_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $uploadData = $this->upload->data();
                                $employeePanBackImage = $uploadData['file_name'];
                            } else {
                                $employeePanBackImage = $data['employeeData']['employee_pan_back_image'];
                            }
                        } else {
                            $employeePanBackImage = $data['employeeData']['employee_pan_back_image'];
                        }
                        
                        if(!empty($_FILES['employee_aadhar_front_image']['name'])){
                            $config['upload_path'] = 'uploads/hrm/employee_aadhar_front_image/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                            $config['file_name'] = timeStamp();
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('employee_aadhar_front_image')){
                                if(!empty($data['employeeData']['employee_aadhar_front_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_aadhar_front_image/'.$data['employeeData']['employee_aadhar_front_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $uploadData = $this->upload->data();
                                $employeeAadharFrontImage = $uploadData['file_name'];
                            } else {
                                $employeeAadharFrontImage = $data['employeeData']['employee_aadhar_front_image'];
                            }
                        } else {
                            $employeeAadharFrontImage = $data['employeeData']['employee_aadhar_front_image'];
                        }
                        
                        if(!empty($_FILES['employee_aadhar_back_image']['name'])){
                            $config['upload_path'] = 'uploads/hrm/employee_aadhar_back_image/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                            $config['file_name'] = timeStamp();
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('employee_aadhar_back_image')){
                                if(!empty($data['employeeData']['employee_aadhar_back_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_aadhar_back_image/'.$data['employeeData']['employee_aadhar_back_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $uploadData = $this->upload->data();
                                $employeeAadharBackImage = $uploadData['file_name'];
                            } else {
                                $employeeAadharBackImage = $data['employeeData']['employee_aadhar_back_image'];
                            }
                        } else {
                            $employeeAadharBackImage = $data['employeeData']['employee_aadhar_back_image'];
                        }
                        
                        if(!empty($_FILES['employee_residential_proof_image']['name'])){
                            $config['upload_path'] = 'uploads/hrm/employee_residential_proof_image/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                            $config['file_name'] = timeStamp();
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('employee_residential_proof_image')){
                                if(!empty($data['employeeData']['employee_residential_proof_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_residential_proof_image/'.$data['employeeData']['employee_residential_proof_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $uploadData = $this->upload->data();
                                $employeeResidentialProofImage = $uploadData['file_name'];
                            } else {
                                $employeeResidentialProofImage = $data['employeeData']['employee_residential_proof_image'];
                            }
                        } else {
                            $employeeResidentialProofImage = $data['employeeData']['employee_residential_proof_image'];
                        }
                        
                        if(!empty($_FILES['employee_cheque_image']['name'])){
                            $config['upload_path'] = 'uploads/hrm/employee_cheque_image/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                            $config['file_name'] = timeStamp();
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('employee_cheque_image')){
                                if(!empty($data['employeeData']['employee_cheque_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_cheque_image/'.$data['employeeData']['employee_cheque_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $uploadData = $this->upload->data();
                                $employeeChequeImage = $uploadData['file_name'];
                            } else {
                                $employeeChequeImage = $data['employeeData']['employee_cheque_image'];
                            }
                        } else {
                            $employeeChequeImage = $data['employeeData']['employee_cheque_image'];
                        }
                        
                        
                        if(!empty($_FILES['employee_experience_certificate_image']['name'])){
                            $config['upload_path'] = 'uploads/hrm/employee_experience_certificate_image/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                            $config['file_name'] = timeStamp();
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('employee_experience_certificate_image')){
                                if(!empty($data['employeeData']['employee_experience_certificate_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_experience_certificate_image/'.$data['employeeData']['employee_experience_certificate_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $uploadData = $this->upload->data();
                                $employeeExperienceCertificateImage = $uploadData['file_name'];
                            } else {
                                $employeeExperienceCertificateImage = $data['employeeData']['employee_experience_certificate_image'];
                            }
                        } else {
                            $employeeExperienceCertificateImage = $data['employeeData']['employee_experience_certificate_image'];
                        }
                        
                        if(!empty($_FILES['employee_relieving_letter_image']['name'])){
                            $config['upload_path'] = 'uploads/hrm/employee_relieving_letter_image/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                            $config['file_name'] = timeStamp();
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('employee_relieving_letter_image')){
                                if(!empty($data['employeeData']['employee_relieving_letter_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_relieving_letter_image/'.$data['employeeData']['employee_relieving_letter_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $uploadData = $this->upload->data();
                                $employeeRelievingLetterImage = $uploadData['file_name'];
                            } else {
                                $employeeRelievingLetterImage = $data['employeeData']['employee_relieving_letter_image'];
                            }
                        } else {
                            $employeeRelievingLetterImage = $data['employeeData']['employee_relieving_letter_image'];
                        }
                        
                        if(!empty($_FILES['employee_salary_slip_image']['name'])){
                            $config['upload_path'] = 'uploads/hrm/employee_salary_slip_image/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                            $config['file_name'] = timeStamp();
                            $this->load->library('upload',$config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('employee_salary_slip_image')){
                                if(!empty($data['employeeData']['employee_salary_slip_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_salary_slip_image/'.$data['employeeData']['employee_salary_slip_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $uploadData = $this->upload->data();
                                $employeeSalarySlipImage = $uploadData['file_name'];
                            } else {
                                $employeeSalarySlipImage = $data['employeeData']['employee_salary_slip_image'];
                            }
                        } else {
                            $employeeSalarySlipImage = $data['employeeData']['employee_salary_slip_image'];
                        }
                        
                        $editData = array(
                            'is_employee'=>$this->input->post('is_employee'),
                            'employee_ref_from'=>$this->input->post('employee_ref_from'),
                            'employee_joining_date'=>$this->input->post('employee_joining_date'),
                            'employee_access_card_no'=>$this->input->post('employee_access_card_no'),
                            'employee_qualification'=>$this->input->post('employee_qualification'),
                            'employee_gender'=>$this->input->post('employee_gender'),
                            'employee_pan_front_image'=>$employeePanFrontImage,
                            'employee_pan_back_image'=>$employeePanBackImage,
                            'employee_aadhar_front_image'=>$employeeAadharFrontImage,
                            'employee_aadhar_back_image'=>$employeeAadharBackImage,
                            'employee_residential_proof_image'=>$employeeResidentialProofImage,
                            'employee_type'=>$this->input->post('employee_type'),
                            'employee_internship_month'=>$this->input->post('employee_internship_month'),
                            'employee_stipend'=>$this->input->post('employee_stipend'),
                            'employee_contract_date'=>$this->input->post('employee_contract_date'),
                            'employee_compensation'=>$this->input->post('employee_compensation'),
                            'employee_salary'=>$this->input->post('employee_salary'),
                            'employee_bank_name'=>$this->input->post('employee_bank_name'),
                            'employee_account_no'=>$this->input->post('employee_account_no'),
                            'employee_cheque_no'=>$this->input->post('employee_cheque_no'),
                            'employee_consent_name'=>$this->input->post('employee_consent_name'),
                            'employee_cheque_image'=>$employeeChequeImage,
                            'employee_experience_certificate_image'=>$employeeExperienceCertificateImage,
                            'employee_relieving_letter_image'=>$employeeRelievingLetterImage,
                            'employee_salary_slip_image'=>$employeeSalarySlipImage,
                        );
                        $editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
                        if($editDataEntry){
                            if($this->input->post('is_employee') == 'selected'){
                                $this->session->set_userdata('session_employee_selection_edit_is_employee_selected', "Your employee has been selection successfully!");
                            } else if($this->input->post('is_employee') == 'rejected'){
                                $this->session->set_userdata('session_employee_selection_edit_is_employee_rejected', "Your employee has been rejection successfully!");
                            }
                            
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        }
                    }
                    if($this->input->post('reset_selection')){
                        if(!empty($data['employeeData']['employee_pan_front_image'])){
                            $imagePath = FCPATH.'uploads/hrm/employee_pan_front_image/'.$data['employeeData']['employee_pan_front_image'];
                            if(file_exists($imagePath)){
                                unlink($imagePath);
                            }
                        }
                        
                        if(!empty($data['employeeData']['employee_pan_back_image'])){
                            $imagePath = FCPATH.'uploads/hrm/employee_pan_back_image/'.$data['employeeData']['employee_pan_back_image'];
                            if(file_exists($imagePath)){
                                unlink($imagePath);
                            }
                        }
                        
                        if(!empty($data['employeeData']['employee_aadhar_front_image'])){
                            $imagePath = FCPATH.'uploads/hrm/employee_aadhar_front_image/'.$data['employeeData']['employee_aadhar_front_image'];
                            if(file_exists($imagePath)){
                                unlink($imagePath);
                            }
                        }
                        
                        if(!empty($data['employeeData']['employee_aadhar_back_image'])){
                            $imagePath = FCPATH.'uploads/hrm/employee_aadhar_back_image/'.$data['employeeData']['employee_aadhar_back_image'];
                            if(file_exists($imagePath)){
                                unlink($imagePath);
                            }
                        }
                        
                        if(!empty($data['employeeData']['employee_residential_proof_image'])){
                            $imagePath = FCPATH.'uploads/hrm/employee_residential_proof_image/'.$data['employeeData']['employee_residential_proof_image'];
                            if(file_exists($imagePath)){
                                unlink($imagePath);
                            }
                        }
                        
                        if(!empty($data['employeeData']['employee_cheque_image'])){
                            $imagePath = FCPATH.'uploads/hrm/employee_cheque_image/'.$data['employeeData']['employee_cheque_image'];
                            if(file_exists($imagePath)){
                                unlink($imagePath);
                            }
                        }
                        
                        if(!empty($data['employeeData']['employee_experience_certificate_image'])){
                            $imagePath = FCPATH.'uploads/hrm/employee_experience_certificate_image/'.$data['employeeData']['employee_experience_certificate_image'];
                            if(file_exists($imagePath)){
                                unlink($imagePath);
                            }
                        }
                        
                        if(!empty($data['employeeData']['employee_relieving_letter_image'])){
                            $imagePath = FCPATH.'uploads/hrm/employee_relieving_letter_image/'.$data['employeeData']['employee_relieving_letter_image'];
                            if(file_exists($imagePath)){
                                unlink($imagePath);
                            }
                        }
                        
                        if(!empty($data['employeeData']['employee_salary_slip_image'])){
                            $imagePath = FCPATH.'uploads/hrm/employee_salary_slip_image/'.$data['employeeData']['employee_salary_slip_image'];
                            if(file_exists($imagePath)){
                                unlink($imagePath);
                            }
                        }
                                
                        $editData = array(
                            'is_employee'=>'pending',
                            'employee_ref_from'=>'',
                            'employee_joining_date'=>'',
                            'employee_access_card_no'=>'',
                            'employee_qualification'=>'',
                            'employee_gender'=>'',
                            'employee_pan_front_image'=>'',
                            'employee_pan_back_image'=>'',
                            'employee_aadhar_front_image'=>'',
                            'employee_aadhar_back_image'=>'',
                            'employee_residential_proof_image'=>'',
                            'employee_type'=>'',
                            'employee_internship_month'=>'',
                            'employee_stipend'=>'',
                            'employee_contract_date'=>'',
                            'employee_compensation'=>'',
                            'employee_salary'=>'',
                            'employee_bank_name'=>'',
                            'employee_account_no'=>'',
                            'employee_cheque_no'=>'',
                            'employee_consent_name'=>'',
                            'employee_cheque_image'=>'',
                            'employee_experience_certificate_image'=>'',
                            'employee_relieving_letter_image'=>'',
                            'employee_salary_slip_image'=>'',
                        );
                        $editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_employee_selection_edit_reset', "Your employee has been reset successfully!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
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
    
    public function employeeStatusEdit($employeeID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission1 = checkPermission(HRM_EMPLOYEE_INACTIVE_ALIAS, "can_edit");
            $isPermission2 = checkPermission(HRM_EMPLOYEE_ACTIVE_ALIAS, "can_edit");
            $employeeID = urlDecodes($employeeID);
            if(ctype_digit($employeeID)){
                $employeeData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                if($employeeData['employee_status'] == "active"){
                    if($isPermission1){
        	            $editData = array(
                		    'employee_status'=>'inactive',
            		    );
                    } else {
                        redirect('permission-denied');
                    }
    	        } else {
    	            if($isPermission2){
    	                $editData = array(
                		    'employee_status'=>'active',
            		    );
    	            } else {
                        redirect('permission-denied');
                    }
    	        }
    			$editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
				if($editDataEntry){
				    if($employeeData['employee_status'] == "active"){
				        $this->session->set_userdata('session_employee_status_edit_inactive', "Your employee has been inactive successfully!");
				    } else if($employeeData['employee_status'] == "inactive"){
				        $this->session->set_userdata('session_employee_status_edit_active', "Your employee has been active successfully!");
				    }
					$sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                    if(!empty($sessionEmployeeViewPreviousUrl)){
                        redirect($sessionEmployeeViewPreviousUrl);
                    }
				}
            } else {
                redirect('error');
            }
        } else {
            redirect('logout');
        }
    }
    
    public function employeeNoticePeriodEdit($employeeID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_ALIAS, "can_edit");
            if($isPermission){
                $employeeID = urlDecodes($employeeID);
                if(ctype_digit($employeeID)){
                   $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    if($this->input->post('submit_notice_period')){
                        $editData = array(
                            'employee_leaving_date'=>todayDate(),
                        );
                        $editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
                        if($editDataEntry){
        				    $this->session->set_userdata('session_employee_notice_period_edit_leaving_date_submit', "Your employee notice period has been start successfully!");
        					$sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        }
                    }
                    if($this->input->post('cancel_notice_period')){
                        $editData = array(
                            'employee_leaving_date'=>'',
                        );
                        $editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
                        if($editDataEntry){
        				    $this->session->set_userdata('session_employee_notice_period_edit_leaving_date_cancel', "Your employee notice period has been cancel successfully!");
        					$sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
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
    
    public function employeeInfo($employeeID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_ALIAS, "can_view");
            if($isPermission){
                $employeeID = urlDecodes($employeeID);
                if(ctype_digit($employeeID)){
            		$employee = $this->DataModel->viewData(null, 'employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
        	        $data['infoEmployee'] = array();
                    if(is_array($employee) || is_object($employee)){
                        foreach($employee as $Row){
                            $dataArray = array();
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['department_id'] = $Row['department_id'];
                            $dataArray['employee_serial_no'] = $Row['employee_serial_no'];
                            $dataArray['employee_first_name'] = $Row['employee_first_name'];
                            $dataArray['employee_middle_name'] = $Row['employee_middle_name'];
                            $dataArray['employee_last_name'] = $Row['employee_last_name'];
                            $dataArray['employee_email'] = $Row['employee_email'];
                            $dataArray['employee_photo'] = $Row['employee_photo'];
                            $dataArray['employee_correspondence_address'] = $Row['employee_correspondence_address'];
                            $dataArray['employee_permanent_address'] = $Row['employee_permanent_address'];
                            $dataArray['employee_telephone_no'] = $Row['employee_telephone_no'];
                            $dataArray['employee_mobile_no'] = $Row['employee_mobile_no'];
                            $dataArray['employee_birth_date'] = $Row['employee_birth_date'];
                            $dataArray['employee_blood_group'] = $Row['employee_blood_group'];
                            $dataArray['employee_marital_status'] = $Row['employee_marital_status'];
                            $dataArray['employee_emergency_contact_name'] = $Row['employee_emergency_contact_name'];
                            $dataArray['employee_emergency_contact_relation'] = $Row['employee_emergency_contact_relation'];
                            $dataArray['employee_emergency_contact_no'] = $Row['employee_emergency_contact_no'];
                            $dataArray['employee_educational_degree'] = $Row['employee_educational_degree'];
                            $dataArray['employee_educational_university_institute'] = $Row['employee_educational_university_institute'];
                            $dataArray['employee_educational_start_year'] = $Row['employee_educational_start_year'];
                            $dataArray['employee_educational_end_year'] = $Row['employee_educational_end_year'];
                            $dataArray['employee_educational_percentage_grade'] = $Row['employee_educational_percentage_grade'];
                            $dataArray['employee_educational_specialisation'] = $Row['employee_educational_specialisation'];
                            $dataArray['employee_employeement_organisation'] = $Row['employee_employeement_organisation'];
                            $dataArray['employee_employeement_designation'] = $Row['employee_employeement_designation'];
                            $dataArray['employee_employeement_start_date'] = $Row['employee_employeement_start_date'];
                            $dataArray['employee_employeement_end_date'] = $Row['employee_employeement_end_date'];
                            $dataArray['employee_employeement_annual_ctc'] = $Row['employee_employeement_annual_ctc'];
                            $dataArray['employee_family_member_name'] = $Row['employee_family_member_name'];
                            $dataArray['employee_family_member_relation'] = $Row['employee_family_member_relation'];
                            $dataArray['employee_family_member_occupation'] = $Row['employee_family_member_occupation'];
                            $dataArray['employee_family_member_birth_date'] = $Row['employee_family_member_birth_date'];
                            $dataArray['employee_professional_reference_name'] = $Row['employee_professional_reference_name'];
                            $dataArray['employee_professional_reference_organisation'] = $Row['employee_professional_reference_organisation'];
                            $dataArray['employee_professional_reference_designation'] = $Row['employee_professional_reference_designation'];
                            $dataArray['employee_professional_reference_contact_no'] = $Row['employee_professional_reference_contact_no'];
                            $dataArray['employee_created_date'] = $Row['employee_created_date'];
                            $dataArray['employee_place'] = $Row['employee_place'];
                            $dataArray['employee_signature'] = $Row['employee_signature'];
                            $dataArray['hr_review'] = $Row['hr_review'];
                            $dataArray['admin_review'] = $Row['admin_review'];
                            $dataArray['technical_review'] = $Row['technical_review'];
                            $dataArray['is_employee'] = $Row['is_employee'];
                            $dataArray['employee_ref_from'] = $Row['employee_ref_from'];
                            $dataArray['employee_joining_date'] = $Row['employee_joining_date'];
                            $dataArray['employee_access_card_no'] = $Row['employee_access_card_no'];
                            $dataArray['employee_qualification'] = $Row['employee_qualification'];
                            $dataArray['employee_gender'] = $Row['employee_gender'];
                            $dataArray['employee_pan_front_image'] = $Row['employee_pan_front_image'];
                            $dataArray['employee_pan_back_image'] = $Row['employee_pan_back_image'];
                            $dataArray['employee_aadhar_front_image'] = $Row['employee_aadhar_front_image'];
                            $dataArray['employee_aadhar_back_image'] = $Row['employee_aadhar_back_image'];
                            $dataArray['employee_residential_proof_image'] = $Row['employee_residential_proof_image'];
                            $dataArray['employee_type'] = $Row['employee_type'];
                            $dataArray['employee_internship_month'] = $Row['employee_internship_month'];
                            $dataArray['employee_stipend'] = $Row['employee_stipend'];
                            $dataArray['employee_contract_date'] = $Row['employee_contract_date'];
                            $dataArray['employee_compensation'] = $Row['employee_compensation'];
                            $dataArray['employee_salary'] = $Row['employee_salary'];
                            $dataArray['employee_bank_name'] = $Row['employee_bank_name'];
                            $dataArray['employee_account_no'] = $Row['employee_account_no'];
                            $dataArray['employee_cheque_no'] = $Row['employee_cheque_no'];
                            $dataArray['employee_consent_name'] = $Row['employee_consent_name'];
                            $dataArray['employee_cheque_image'] = $Row['employee_cheque_image'];
                            $dataArray['employee_experience_certificate_image'] = $Row['employee_experience_certificate_image'];
                            $dataArray['employee_relieving_letter_image'] = $Row['employee_relieving_letter_image'];
                            $dataArray['employee_salary_slip_image'] = $Row['employee_salary_slip_image'];
                            $dataArray['employee_status'] = $Row['employee_status'];
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                            array_push($data['infoEmployee'], $dataArray);
                        }
                    }
                    
                    $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                    
                    if($this->input->post('submit_photo')){
                        $isPermissionEmployeePhoto = checkPermission(HRM_EMPLOYEE_PHOTO_ALIAS, "can_edit");
                        if($isPermissionEmployeePhoto){
                            if($this->input->post('submit_photo')){
                                if(!empty($_FILES['employee_photo']['name'])){
                                    $config['upload_path'] = 'uploads/hrm/employee_photo/';
                                    $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                                    $config['file_name'] = timeStamp();
                                    $this->load->library('upload',$config);
                                    $this->upload->initialize($config);
                                    if($this->upload->do_upload('employee_photo')){
                                        if(!empty($data['employeeData']['employee_photo'])){
                                            $imagePath = FCPATH.'uploads/hrm/employee_photo/'.$data['employeeData']['employee_photo'];
                                            if(file_exists($imagePath)){
                                                unlink($imagePath);
                                            }
                                        } 
                                        $uploadData = $this->upload->data();
                                        $employeePhoto = $uploadData['file_name'];
                                    } else {
                                        $employeePhoto = $data['employeeData']['employee_photo'];
                                    }
                                } else {
                                    if(!empty($data['employeeData']['employee_photo'])){
                                        $imagePath = FCPATH.'uploads/hrm/employee_photo/'.$data['employeeData']['employee_photo'];
                                        if(file_exists($imagePath)){
                                            unlink($imagePath);
                                        }
                                    }
                                    $employeePhoto = 'Unknown';
                                }
                        
                                $editData = array(
                                    'employee_photo'=>$employeePhoto,
                                    'employee_status'=>'active'
                                );
                                $editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
                                if($editDataEntry){
                                    $this->session->set_userdata('session_employee_info_employee_photo', "Your employee profile has been update successfully!");
                                    redirect('info-employee/'.urlEncodes($employeeID));
                                }
                            }
                        } else {
                            redirect('permission-denied');
                        }
                    }
                    
                    if($this->input->post('submit_review')){
                        $isPermissionEmployeeReview = checkPermission(HRM_EMPLOYEE_REVIEW_ALIAS, "can_edit");
                        if($isPermissionEmployeeReview){
                            if($this->input->post('submit_review')){
                                $isHrPermission = checkPermission(HRM_EMPLOYEE_HR_REVIEW_ALIAS, "can_edit");
                                $isAdminPermission = checkPermission(HRM_EMPLOYEE_ADMIN_REVIEW_ALIAS, "can_edit");
                                $isTechnicalPermission = checkPermission(HRM_EMPLOYEE_TECHNICAL_REVIEW_ALIAS, "can_edit");
                                
                                if($this->session->userdata['user_role'] == "Super"){
                                    $editData = array(
                                        'hr_review'=>$this->input->post('hr_review'),
                                        'admin_review'=>$this->input->post('admin_review'),
                                        'technical_review'=>$this->input->post('technical_review'),
                                    );
                                } else {
                                    if($isHrPermission){
                                        $editData = array(
                                            'hr_review'=>$this->input->post('hr_review')
                                        );
                                    } 
                                    if($isAdminPermission){
                                        $editData = array(
                                            'admin_review'=>$this->input->post('admin_review') 
                                        );
                                    } 
                                    if($isTechnicalPermission){
                                        $editData = array(
                                            'technical_review'=>$this->input->post('technical_review')
                                        );
                                    } 
                                    if($isHrPermission and $isTechnicalPermission){
                                        $editData = array(
                                            'hr_review'=>$this->input->post('hr_review'),
                                            'technical_review'=>$this->input->post('technical_review')
                                        );
                                    } 
                                    if($isHrPermission and $isAdminPermission){
                                        $editData = array(
                                            'hr_review'=>$this->input->post('hr_review'),
                                            'admin_review'=>$this->input->post('admin_review')
                                        );
                                    } 
                                    if($isTechnicalPermission and $isAdminPermission){
                                        $editData = array(
                                            'technical_review'=>$this->input->post('technical_review'),
                                            'admin_review'=>$this->input->post('admin_review')
                                        );
                                    } 
                                    if($isHrPermission and $isAdminPermission and $isTechnicalPermission){
                                        $editData = array(
                                            'hr_review'=>$this->input->post('hr_review'),
                                            'admin_review'=>$this->input->post('admin_review'),
                                            'technical_review'=>$this->input->post('technical_review'),
                                        );
                                    } 
                                    
                                    if(!$isHrPermission and !$isAdminPermission and !$isTechnicalPermission){
                                        redirect('permission-denied');
                                    }
                                }
              
                                $editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
                                if($editDataEntry){
                                    $this->session->set_userdata('session_employee_info_employee_review', "Your employee has been review successfully!");
                                    redirect('info-employee/'.urlEncodes($employeeID));
                                }
                            }
                        } else {
                            redirect('permission-denied');
                        }
                    }
            
                    if($data['infoEmployee'] != null){
            	        $this->load->view('header');
                		$this->load->view('hrm/employee/employee_info', $data);
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
    
    public function employeeEdit($employeeID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            $isPermission = checkPermission(HRM_EMPLOYEE_ALIAS, "can_edit");
            if($isPermission){
                $employeeID = urlDecodes($employeeID);
                if(ctype_digit($employeeID)){
                   $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                   
                    $data['viewDepartment'] = $this->DataModel->viewData(null, null, DEPARTMENT_TABLE);
                    $departmentID = $data['employeeData']['department_id'];
                    $data['departmentData'] = $this->DataModel->getData('department_id = '.$departmentID, DEPARTMENT_TABLE);
                    
                    if(!empty($data['employeeData'])){
                        $this->load->view('header');
                        $this->load->view('hrm/employee/employee_edit', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('error');
                    }
                    if($this->input->post('submit')){
                        $editData = array(
                            'department_id'=>$this->input->post('department_id'),
                            'employee_first_name'=>$this->input->post('employee_first_name'),
                            'employee_middle_name'=>$this->input->post('employee_middle_name'),
                            'employee_last_name'=>$this->input->post('employee_last_name'),
                            'employee_email'=>$this->input->post('employee_email'),
                            'employee_correspondence_address'=>$this->input->post('employee_correspondence_address'),
                            'employee_permanent_address'=>$this->input->post('employee_permanent_address'),
                            'employee_telephone_no'=>$this->input->post('employee_telephone_no'),
                            'employee_mobile_no'=>$this->input->post('employee_mobile_no'),
                            'employee_birth_date'=>$this->input->post('employee_birth_date'),
                            'employee_blood_group'=>$this->input->post('employee_blood_group'),
                            'employee_marital_status'=>$this->input->post('employee_marital_status'),
                            'employee_emergency_contact_name'=>$this->input->post('employee_emergency_contact_name'),
                            'employee_emergency_contact_relation'=>$this->input->post('employee_emergency_contact_relation'),
                            'employee_emergency_contact_no'=>$this->input->post('employee_emergency_contact_no'),
                            'employee_educational_degree'=>implode("#",$this->input->post('employee_educational_degree')),
                            'employee_educational_university_institute'=>implode("#",$this->input->post('employee_educational_university_institute')),
                            'employee_educational_start_year'=>implode("#",$this->input->post('employee_educational_start_year')),
                            'employee_educational_end_year'=>implode("#",$this->input->post('employee_educational_end_year')),
                            'employee_educational_percentage_grade'=>implode("#",$this->input->post('employee_educational_percentage_grade')),
                            'employee_educational_specialisation'=>implode("#",$this->input->post('employee_educational_specialisation')),
                            'employee_employeement_organisation'=>implode("#",$this->input->post('employee_employeement_organisation')),
                            'employee_employeement_designation'=>implode("#",$this->input->post('employee_employeement_designation')),
                            'employee_employeement_start_date'=>implode("#",$this->input->post('employee_employeement_start_date')),
                            'employee_employeement_end_date'=>implode("#",$this->input->post('employee_employeement_end_date')),
                            'employee_employeement_annual_ctc'=>implode("#",$this->input->post('employee_employeement_annual_ctc')),
                            'employee_family_member_name'=>implode("#",$this->input->post('employee_family_member_name')),
                            'employee_family_member_relation'=>implode("#",$this->input->post('employee_family_member_relation')),
                            'employee_family_member_occupation'=>implode("#",$this->input->post('employee_family_member_occupation')),
                            'employee_family_member_birth_date'=>implode("#",$this->input->post('employee_family_member_birth_date')),
                            'employee_professional_reference_name'=>implode("#",$this->input->post('employee_professional_reference_name')),
                            'employee_professional_reference_organisation'=>implode("#",$this->input->post('employee_professional_reference_organisation')),
                            'employee_professional_reference_designation'=>implode("#",$this->input->post('employee_professional_reference_designation')),
                            'employee_professional_reference_contact_no'=>implode("#",$this->input->post('employee_professional_reference_contact_no')),
                            'employee_place'=>$this->input->post('employee_place'),
                            'employee_signature'=>$this->input->post('employee_signature'),
                        );
                        $editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
                        if($editDataEntry){
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
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
    
    public function employeeTrash($employeeID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $employeeID = urlDecodes($employeeID);
                    if(ctype_digit($employeeID)){
                        $attendanceData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_ATTENDANCE_TABLE);
                        $leaveData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_LEAVE_TABLE);
                        $reportingData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_REPORTING_TABLE);
                        $salaryData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_SALARY_TABLE);
                        $internOfferData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_INTERN_OFFER_TABLE);
                        $internshipCertificateData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_INTERNSHIP_CERTIFICATE_TABLE);
                        $employeeOfferData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_OFFER_TABLE);
                        $appraisalCertificateData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_APPRAISAL_CERTIFICATE_TABLE);
                        $warningMailData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_WARNING_MAIL_TABLE);
                        $appointmentData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_APPOINTMENT_TABLE);
                        $hrPolicyData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_HR_POLICY_TABLE);
                        $declarationData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_DECLARATION_TABLE);
                        $consentData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_CONSENT_TABLE);
                        $nonDisclosureAgreementData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_NON_DISCLOSURE_AGREEMENT_TABLE);
                        $serviceAgreementData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_SERVICE_AGREEMENT_TABLE);
                        $noDueCertificateData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_NO_DUE_CERTIFICATE_TABLE);
                        $relievingData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_RELIEVING_TABLE);
                        $experienceData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EXPERIENCE_TABLE);
                        $terminationData = $this->DataModel->getData('employee_id = '.$employeeID, HRM_TERMINATION_TABLE);
                        $masterUserData = $this->DataModel->getData('employee_id = '.$employeeID, MASTER_USER_TABLE);
                        
                        if(!empty($attendanceData)){
                            $this->session->set_userdata('session_employee_trash_attendance_admin', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($leaveData)){
                            $this->session->set_userdata('session_employee_trash_leave_admin', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($reportingData)){
                            $this->session->set_userdata('session_employee_trash_reporting_admin', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($salaryData)){
                            $this->session->set_userdata('session_employee_trash_salary', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($internOfferData)){
                            $this->session->set_userdata('session_employee_trash_intern_offer', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($internshipCertificateData)){
                            $this->session->set_userdata('session_employee_trash_internship_certificate', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($employeeOfferData)){
                            $this->session->set_userdata('session_employee_trash_employee_offer', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($appraisalCertificateData)){
                            $this->session->set_userdata('session_employee_trash_appraisal_certificate', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($warningMailData)){
                            $this->session->set_userdata('session_employee_trash_warning_mail', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($appointmentData)){
                            $this->session->set_userdata('session_employee_trash_appointment', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($hrPolicyData)){
                            $this->session->set_userdata('session_employee_trash_hr_policy', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($declarationData)){
                            $this->session->set_userdata('session_employee_trash_declaration', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($consentData)){
                            $this->session->set_userdata('session_employee_trash_consent', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($nonDisclosureAgreementData)){
                            $this->session->set_userdata('session_employee_trash_non_disclosure_agreement', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($serviceAgreementData)){
                            $this->session->set_userdata('session_employee_trash_service_agreement', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($noDueCertificateData)){
                            $this->session->set_userdata('session_employee_trash_no_due_certificate', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($relievingData)){
                            $this->session->set_userdata('session_employee_trash_relieving', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($experienceData)){
                            $this->session->set_userdata('session_employee_trash_experience', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($terminationData)){
                            $this->session->set_userdata('session_employee_trash_termination', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else if(!empty($masterUserData)){
                            $this->session->set_userdata('session_employee_trash_user_master', "You can't trash employee!");
                            $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                            if(!empty($sessionEmployeeViewPreviousUrl)){
                                redirect($sessionEmployeeViewPreviousUrl);
                            }
                        } else {
                            $editData = array(
                                'trash_status'=>'true',
                            );
                            $editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
                            if($editDataEntry){
                                $this->session->set_userdata('session_employee_trash_success','Your employee has been trash successfully!');
                                $sessionEmployeeViewPreviousUrl = $this->session->userdata('session_employee_view_previous_url');
                                if(!empty($sessionEmployeeViewPreviousUrl)){
                                    redirect($sessionEmployeeViewPreviousUrl);
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
    
    public function employeeTrashView(){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){

                    $this->session->set_userdata('session_employee_trash_view_previous_url', current_url());
        
                    if(isset($_POST['reset_search'])){
                        $this->session->unset_userdata('session_employee_trash');
                    }
                    if(isset($_POST['submit_search'])){
                        $searchEmployeeTrash = $this->input->post('search_employee_trash');
                        $this->session->set_userdata('session_employee_trash', $searchEmployeeTrash);
                    }
                    $sessionEmployeeTrash = $this->session->userdata('session_employee_trash');
                    
                    if(isset($_POST['reset_filter'])){
                        $this->session->unset_userdata('session_employee_trash_is_employee');
                        $this->session->unset_userdata('session_employee_trash_type');
                        $this->session->unset_userdata('session_employee_trash_status');
                        $this->session->unset_userdata('session_employee_trash_created_start_date');
                        $this->session->unset_userdata('session_employee_trash_created_end_date');
                        redirect('view-trash-employee');
                    }
                    if(isset($_POST['submit_filter'])){
                        $searchEmployeeTrashCreatedStartDate = $this->input->post('search_employee_trash_created_start_date');
                        $searchEmployeeTrashCreatedEndDate = $this->input->post('search_employee_trash_created_end_date');
                        
                        $this->session->set_userdata('session_employee_trash_created_start_date', $searchEmployeeTrashCreatedStartDate);
                        $this->session->set_userdata('session_employee_trash_created_end_date', $searchEmployeeTrashCreatedEndDate);
                    }
                    $sessionEmployeeTrashCreatedStartDate = $this->session->userdata('session_employee_trash_created_start_date');
                    $sessionEmployeeTrashCreatedEndDate = $this->session->userdata('session_employee_trash_created_end_date');
                    
                    $searchEmployeeTrashIsEmployee = $this->input->post('search_employee_trash_is_employee');
                    if($searchEmployeeTrashIsEmployee === 'pending' or $searchEmployeeTrashIsEmployee == 'selected' or $searchEmployeeTrashIsEmployee == 'rejected'){
                        $this->session->set_userdata('session_employee_trash_is_employee', $searchEmployeeTrashIsEmployee);
                    } else if($searchEmployeeTrashIsEmployee === 'all'){
                        $this->session->unset_userdata('session_employee_trash_is_employee');
                    }
                    $sessionEmployeeTrashIsEmployee = $this->session->userdata('session_employee_trash_is_employee');
                    
                    $searchEmployeeTrashType = $this->input->post('search_employee_trash_type');
                    if($searchEmployeeTrashType === 'intern' or $searchEmployeeTrashType == 'employee'){
                        $this->session->set_userdata('session_employee_trash_type', $searchEmployeeTrashType);
                    } else if($searchEmployeeTrashType === 'all'){
                        $this->session->unset_userdata('session_employee_trash_type');
                    }
                    $sessionEmployeeTrashType = $this->session->userdata('session_employee_trash_type');
                    
                    $searchEmployeeTrashStatus = $this->input->post('search_employee_trash_status');
                    if($searchEmployeeTrashStatus === 'draft' or $searchEmployeeTrashStatus == 'active' or $searchEmployeeTrashStatus == 'inactive'){
                        $this->session->set_userdata('session_employee_trash_status', $searchEmployeeTrashStatus);
                    } else if($searchEmployeeTrashStatus === 'all'){
                        $this->session->unset_userdata('session_employee_trash_status');
                    }
                    $sessionEmployeeTrashStatus = $this->session->userdata('session_employee_trash_status');
                    
                    $data = array();
                    //get rows count
                    $conditions['search_employee_trash'] = $sessionEmployeeTrash;
                    $conditions['search_employee_trash_is_employee'] = $sessionEmployeeTrashIsEmployee;
                    $conditions['search_employee_trash_type'] = $sessionEmployeeTrashType;
                    $conditions['search_employee_trash_status'] = $sessionEmployeeTrashStatus;
                    $conditions['search_employee_trash_created_start_date'] = $sessionEmployeeTrashCreatedStartDate;
                    $conditions['search_employee_trash_created_end_date'] = $sessionEmployeeTrashCreatedEndDate;
                    $conditions['returnType'] = 'count';
                    
                    $totalRec = $this->DataModel->viewEmployeeTrashData($conditions, HRM_EMPLOYEE_TABLE);
        
                    //pagination config
                    $config['base_url']    = site_url('view-trash-employee');
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
                    
                    $employee = $this->DataModel->viewEmployeeTrashData($conditions, HRM_EMPLOYEE_TABLE);
                    $data['countEmployee'] = $this->DataModel->countEmployeeTrashData($conditions, HRM_EMPLOYEE_TABLE);

                    $data['viewEmployee'] = array();
                    if(is_array($employee) || is_object($employee)){
                        foreach($employee as $Row){
                            $dataArray = array();
                            $dataArray['employee_id'] = $Row['employee_id'];
                            $dataArray['department_id'] = $Row['department_id'];
                            $dataArray['employee_first_name'] = $Row['employee_first_name'];
                            $dataArray['employee_middle_name'] = $Row['employee_middle_name'];
                            $dataArray['employee_last_name'] = $Row['employee_last_name'];
                            $dataArray['employee_email'] = $Row['employee_email'];
                            $dataArray['employee_photo'] = $Row['employee_photo'];
                            $dataArray['employee_mobile_no'] = $Row['employee_mobile_no'];
                            $dataArray['employee_created_date'] = $Row['employee_created_date'];
                            $dataArray['is_employee'] = $Row['is_employee'];
                            $dataArray['employee_type'] = $Row['employee_type'];
                            $dataArray['employee_status'] = $Row['employee_status'];
                            $dataArray['departmentData'] = $this->DataModel->getData('department_id = '.$dataArray['department_id'], DEPARTMENT_TABLE);
                            array_push($data['viewEmployee'], $dataArray);
                        }
                    }
                    $this->load->view('header');
                    $this->load->view('hrm/employee/employee_trash_view', $data);
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
    
    public function employeeRestore($employeeID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $employeeID = urlDecodes($employeeID);
                    if(ctype_digit($employeeID)){
                        $editData = array(
                            'trash_status'=>'false',
                        );
                        $editDataEntry = $this->DataModel->editData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE, $editData);
                        if($editDataEntry){
                            $this->session->set_userdata('session_employee_restore_success','Your employee has been restore successfully!');
                            $sessionEmployeeTrashViewPreviousUrl = $this->session->userdata('session_employee_trash_view_previous_url');
                            if(!empty($sessionEmployeeTrashViewPreviousUrl)){
                                redirect($sessionEmployeeTrashViewPreviousUrl);
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
    
    public function employeeDelete($employeeID = 0){
        $isLogin = checkAuth();
        if($isLogin == "True"){
            if(!empty($this->session->userdata['user_role'])){ 
                if($this->session->userdata['user_role'] == "Super"){
                    $employeeID = urlDecodes($employeeID);
                    if(ctype_digit($employeeID)){
                        $userID = $this->session->userdata['user_id'];
                        $superUserData = $this->DataModel->getData('user_id = '.$userID, SUPER_USER_TABLE);
                        $data['employeeData'] = $this->DataModel->getData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                        if($this->input->post('submit')){
                            $enteredPassword = md5($this->input->post('password'));
                            if($enteredPassword == $superUserData['user_password']){
                                if(!empty($data['employeeData']['employee_photo'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_photo/'.$data['employeeData']['employee_photo'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                
                                if(!empty($data['employeeData']['employee_pan_front_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_pan_front_image/'.$data['employeeData']['employee_pan_front_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                
                                if(!empty($data['employeeData']['employee_pan_back_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_pan_back_image/'.$data['employeeData']['employee_pan_back_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                
                                if(!empty($data['employeeData']['employee_aadhar_front_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_aadhar_front_image/'.$data['employeeData']['employee_aadhar_front_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                
                                if(!empty($data['employeeData']['employee_aadhar_back_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_aadhar_back_image/'.$data['employeeData']['employee_aadhar_back_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                
                                if(!empty($data['employeeData']['employee_residential_proof_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_residential_proof_image/'.$data['employeeData']['employee_residential_proof_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                
                                if(!empty($data['employeeData']['employee_cheque_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_cheque_image/'.$data['employeeData']['employee_cheque_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                
                                if(!empty($data['employeeData']['employee_experience_certificate_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_experience_certificate_image/'.$data['employeeData']['employee_experience_certificate_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                
                                if(!empty($data['employeeData']['employee_relieving_letter_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_relieving_letter_image/'.$data['employeeData']['employee_relieving_letter_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                
                                if(!empty($data['employeeData']['employee_salary_slip_image'])){
                                    $imagePath = FCPATH.'uploads/hrm/employee_salary_slip_image/'.$data['employeeData']['employee_salary_slip_image'];
                                    if(file_exists($imagePath)){
                                        unlink($imagePath);
                                    }
                                }
                                $resultDataEntry = $this->DataModel->deleteData('employee_id = '.$employeeID, HRM_EMPLOYEE_TABLE);
                                if($resultDataEntry){
                                    $this->session->set_userdata('session_employee_delete_success','Your employee has been delete successfully!');
                                    $sessionEmployeeTrashViewPreviousUrl = $this->session->userdata('session_employee_trash_view_previous_url');
                                    if(!empty($sessionEmployeeTrashViewPreviousUrl)){
                                        redirect($sessionEmployeeTrashViewPreviousUrl);
                                    }
                                }
                            } else {
                                $this->session->set_userdata('session_employee_delete_error','Your password are not matched! Please enter correct password');
                                $sessionEmployeeTrashViewPreviousUrl = $this->session->userdata('session_employee_trash_view_previous_url');
                                if(!empty($sessionEmployeeTrashViewPreviousUrl)){
                                    redirect($sessionEmployeeTrashViewPreviousUrl);
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
