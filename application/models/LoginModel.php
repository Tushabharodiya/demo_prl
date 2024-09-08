<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	// ====================================================================== //
    /* Common Functions */
    // ====================================================================== //
    function getData($where, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($where){ $this->db->where($where); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	function insertData($table, $data){
		$result = $this->db->insert($table, $data);
		if($result)
			return $this->db->insert_id();
		else
			return false;
	}
	function editData($where, $table, $editData){
		$this->db->where($where);
        $result = $this->db->update($table, $editData);
		if($result)
			return  true;
		else
			return false;
	}
	
	// ====================================================================== //
    /* Login Functions */
    // ====================================================================== //
	function checkLogin($table, $data){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('user_email', $data['user_email']);
		$this->db->where('user_password', $data['user_password']);
		$query = $this->db->get();
		return $query->row_array();
	}
	function checkIP($ipAddress, $table){
		$this->db->select('*');
		$this->db->where('data_ip', $ipAddress);
		$this->db->from($table);
		$query = $this->db->get();
		return $query->row_array();
	}
    
    
}	 

	
	

