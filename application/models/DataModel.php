<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DataModel extends CI_Model {
    function __construct() {
		parent::__construct();
	}
	
	// ====================================================================== //
    /* Extra Functions */
    // ====================================================================== //
	function countData($where, $table){
		$this->db->select('*');
		if($where){
		    $this->db->where($where);
		}
		$this->db->from($table);
		$result = $this->db->count_all_results();
		return $result;
	}

	// ====================================================================== //
    /* Common Functions */
    // ====================================================================== //
	function insertData($table, $data){
		$result = $this->db->insert($table, $data);
		if($result)
			return $this->db->insert_id();
		else
			return false;
	}
	
	function getData($where, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($where){ $this->db->where($where); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function viewData($order, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order);
		if($order){ $this->db->order_by($order); }
		if($where){ $this->db->where($where); }
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function editData($where, $table, $editData){
		$this->db->where($where);
        $result = $this->db->update($table, $editData);
		if($result)
			return  true;
		else
			return false;
	}
	
	function deleteData($where, $table){
		$this->db->where($where);
		$result = $this->db->delete($table);
		if($result)
			return true;
		else
			return false;
	}
    
    // ====================================================================== //
    /* Master Functions */
    // ====================================================================== //
    // Alias Functions
	function viewAliasData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('alias_id','DESC');
		if(!empty($params['search_alias'])){
            $searchAlias = $params['search_alias'];
            $likeArr = array(
                'alias_name' => $searchAlias
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_alias_status'])){
            $searchAliasStatus = $params['search_alias_status'];
            $this->db->where('alias_status', $searchAliasStatus);
        }
        if(array_key_exists("alias_id",$params)){
            $this->db->where('alias_id',$params['alias_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAliasData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('alias_id','DESC');
		if(!empty($params['search_alias'])){
            $searchAlias = $params['search_alias'];
            $likeArr = array(
                'alias_name' => $searchAlias
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_alias_status'])){
            $searchAliasStatus = $params['search_alias_status'];
            $this->db->where('alias_status', $searchAliasStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
    // Permission Functions
    function viewPermissionData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('permission_id','DESC');
		if(!empty($params['search_permission'])){
            $searchPermission = $params['search_permission'];
            $likeArr = array(
                'permission_name' => $searchPermission, 
                'permission_alias' => $searchPermission
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_permission_status'])){
            $searchPermissionStatus = $params['search_permission_status'];
            $this->db->where('permission_status', $searchPermissionStatus);
        }
        if(array_key_exists("permission_id",$params)){
            $this->db->where('permission_id',$params['permission_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countPermissionData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('permission_id','DESC');
		if(!empty($params['search_permission'])){
            $searchPermission = $params['search_permission'];
            $likeArr = array(
                'permission_name' => $searchPermission, 
                'permission_alias' => $searchPermission
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_permission_status'])){
            $searchPermissionStatus = $params['search_permission_status'];
            $this->db->where('permission_status', $searchPermissionStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewAliasPermissionData($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('permission_id','DESC');
		if(!empty($params['search_alias_permission'])){
            $searchAliasPermission = $params['search_alias_permission'];
            $likeArr = array(
                'permission_name' => $searchAliasPermission, 
                'permission_alias' => $searchAliasPermission
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_alias_permission_status'])){
            $searchAliasPermissionStatus = $params['search_alias_permission_status'];
            $this->db->where('permission_status', $searchAliasPermissionStatus);
        }
        $this->db->where('alias_id', $where);
        if(array_key_exists("permission_id",$params)){
            $this->db->where('permission_id',$params['permission_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAliasPermissionData($params, $where, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('permission_id','DESC');
		if(!empty($params['search_alias_permission'])){
            $searchAliasPermission = $params['search_alias_permission'];
            $likeArr = array(
                'permission_name' => $searchAliasPermission, 
                'permission_alias' => $searchAliasPermission
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_alias_permission_status'])){
            $searchAliasPermissionStatus = $params['search_alias_permission_status'];
            $this->db->where('permission_status', $searchAliasPermissionStatus);
        }
        $this->db->where('alias_id', $where);
		$result = $this->db->count_all_results();
		return $result;
	}
	
    function viewNotDepartmentData($order, $departmentID, $whereArray, $table){ 
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order);
		if($order){ $this->db->order_by($order); }
		if($departmentID){ $this->db->where('department_id', $departmentID); }
		if($whereArray){ $this->db->where_not_in('permission_id', $whereArray); }
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function viewNotUserData($order, $userID, $whereArray, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order);
		if($order){ $this->db->order_by($order); }
		if($userID){ $this->db->where('user_id', $userID); }
		if($whereArray){ $this->db->where_not_in('permission_id', $whereArray); }
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function getDepartmentPermissionData($rightsID, $departmentID, $permissionID, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($rightsID){ $this->db->where('rights_id', $rightsID); }
		if($departmentID){ $this->db->where('department_id', $departmentID); }
		if($permissionID){ $this->db->where('permission_id', $permissionID); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function getUserPermissionData($rightsID, $userID, $permissionID, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($rightsID){ $this->db->where('rights_id', $rightsID); }
		if($userID){ $this->db->where('user_id', $userID); }
		if($permissionID){ $this->db->where('permission_id', $permissionID); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function deleteUserData($departmentID, $permissionID, $table){
		$this->db->where($departmentID);
		$this->db->where($permissionID);
		$result = $this->db->delete($table);
		if($result)
			return true;
		else
			return false;
	}
	
	function editUserData($userID, $departmentID, $permissionID, $table, $editData){
		$this->db->where($userID);
		$this->db->where($departmentID);
		$this->db->where($permissionID);
        $result = $this->db->update($table, $editData);
		if($result)
			return  true;
		else
			return false;
	}
	
    // Department Functions
    function viewDepartmentData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('department_id','DESC');
		if(!empty($params['search_department'])){
            $searchDepartment = $params['search_department'];
            $likeArr = array(
                'department_name' => $searchDepartment
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_department_status'])){
            $searchDepartmentStatus = $params['search_department_status'];
            $this->db->where('department_status', $searchDepartmentStatus);
        }
        $this->db->where('trash_status', 'false');
        if(array_key_exists("department_id",$params)){
            $this->db->where('department_id',$params['department_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countDepartmentData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('department_id','DESC');
		if(!empty($params['search_department'])){
            $searchDepartment = $params['search_department'];
            $likeArr = array(
                'department_name' => $searchDepartment
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_department_status'])){
            $searchDepartmentStatus = $params['search_department_status'];
            $this->db->where('department_status', $searchDepartmentStatus);
        }
        $this->db->where('trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewDepartmentTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('department_id','DESC');
		if(!empty($params['search_department_trash'])){
            $searchDepartmentTrash = $params['search_department_trash'];
            $likeArr = array(
                'department_name' => $searchDepartmentTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_department_trash_status'])){
            $searchDepartmentTrashStatus = $params['search_department_trash_status'];
            $this->db->where('department_status', $searchDepartmentTrashStatus);
        }
        $this->db->where('trash_status', 'true');
        if(array_key_exists("department_id",$params)){
            $this->db->where('department_id',$params['department_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countDepartmentTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('department_id','DESC');
		if(!empty($params['search_department_trash'])){
            $searchDepartmentTrash = $params['search_department_trash'];
            $likeArr = array(
                'department_name' => $searchDepartmentTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_department_trash_status'])){
            $searchDepartmentTrashStatus = $params['search_department_trash_status'];
            $this->db->where('department_status', $searchDepartmentTrashStatus);
        }
        $this->db->where('trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
    // User Functions
    function viewUserData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('user_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, MASTER_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_user'])){
            $searchUser = $params['search_user'];
            $likeArr = array(
                'user_name' => $searchUser, 
                'user_email' => $searchUser, 
                DEPARTMENT_TABLE . '.department_name' => $searchUser
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_user_login'])){
            $searchUserLogin = $params['search_user_login'];
            $this->db->where('is_login', $searchUserLogin);
        }
        if(!empty($params['search_user_status'])){
            $searchUserStatus = $params['search_user_status'];
            $this->db->where('user_status', $searchUserStatus);
        }
        $this->db->where(MASTER_USER_TABLE . '.trash_status', 'false');
        if(array_key_exists("user_id",$params)){
            $this->db->where('user_id',$params['user_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countUserData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('user_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, MASTER_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_user'])){
            $searchUser = $params['search_user'];
            $likeArr = array(
                'user_name' => $searchUser, 
                'user_email' => $searchUser, 
                DEPARTMENT_TABLE . '.department_name' => $searchUser
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_user_login'])){
            $searchUserLogin = $params['search_user_login'];
            $this->db->where('is_login', $searchUserLogin);
        }
        if(!empty($params['search_user_status'])){
            $searchUserStatus = $params['search_user_status'];
            $this->db->where('user_status', $searchUserStatus);
        }
        $this->db->where(MASTER_USER_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewUserTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('user_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, MASTER_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_user_trash'])){
            $searchUserTrash = $params['search_user_trash'];
            $likeArr = array(
                'user_name' => $searchUserTrash, 
                'user_email' => $searchUserTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchUserTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_user_trash_login'])){
            $searchUserTrashLogin = $params['search_user_trash_login'];
            $this->db->where('is_login', $searchUserTrashLogin);
        }
        if(!empty($params['search_user_trash_status'])){
            $searchUserTrashStatus = $params['search_user_trash_status'];
            $this->db->where('user_status', $searchUserTrashStatus);
        }
        $this->db->where(MASTER_USER_TABLE . '.trash_status', 'true');
        if(array_key_exists("user_id",$params)){
            $this->db->where('user_id',$params['user_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countUserTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('user_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, MASTER_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_user_trash'])){
            $searchUserTrash = $params['search_user_trash'];
            $likeArr = array(
                'user_name' => $searchUserTrash, 
                'user_email' => $searchUserTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchUserTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_user_trash_login'])){
            $searchUserTrashLogin = $params['search_user_trash_login'];
            $this->db->where('is_login', $searchUserTrashLogin);
        }
        if(!empty($params['search_user_trash_status'])){
            $searchUserTrashStatus = $params['search_user_trash_status'];
            $this->db->where('user_status', $searchUserTrashStatus);
        }
        $this->db->where(MASTER_USER_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewDepartmentUserData($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('user_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, MASTER_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_department_user'])){
            $searchDepartmentUser = $params['search_department_user'];
            $likeArr = array(
                DEPARTMENT_TABLE . '.department_name' => $searchDepartmentUser, 
                'user_name' => $searchDepartmentUser, 
                'user_email' => $searchDepartmentUser, 
                'user_role' => $searchDepartmentUser
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_department_user_status'])){
            $searchDepartmentUserStatus = $params['search_department_user_status'];
            $this->db->where('user_status', $searchDepartmentUserStatus);
        }
        $this->db->where(DEPARTMENT_TABLE . '.department_id', $where);
        if(array_key_exists("user_id",$params)){
            $this->db->where('user_id',$params['user_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countDepartmentUserData($params, $where, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('user_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, MASTER_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_department_user'])){
            $searchDepartmentUser = $params['search_department_user'];
            $likeArr = array(
                DEPARTMENT_TABLE . '.department_name' => $searchDepartmentUser, 
                'user_name' => $searchDepartmentUser, 
                'user_email' => $searchDepartmentUser, 
                'user_role' => $searchDepartmentUser
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_department_user_status'])){
            $searchDepartmentUserStatus = $params['search_department_user_status'];
            $this->db->where('user_status', $searchDepartmentUserStatus);
        }
        $this->db->where(DEPARTMENT_TABLE . '.department_id', $where);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewLoginHistoryData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('unique_id','DESC');
		if(!empty($params['search_login_history'])){
            $searchLoginHistory = $params['search_login_history'];
            $likeArr = array(
                'user_name' => $searchLoginHistory, 
                'user_email' => $searchLoginHistory, 
                'user_login' => $searchLoginHistory, 
                'user_logout' => $searchLoginHistory
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where('trash_status', 'false');
        if(array_key_exists("unique_id",$params)){
            $this->db->where('unique_id',$params['unique_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countLoginHistoryData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('unique_id','DESC');
		if(!empty($params['search_login_history'])){
            $searchLoginHistory = $params['search_login_history'];
            $likeArr = array(
                'user_name' => $searchLoginHistory, 
                'user_email' => $searchLoginHistory, 
                'user_login' => $searchLoginHistory, 
                'user_logout' => $searchLoginHistory
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where('trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewLoginHistoryTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('unique_id','DESC');
		if(!empty($params['search_login_history_trash'])){
            $searchLoginHistoryTrash = $params['search_login_history_trash'];
            $likeArr = array(
                'user_name' => $searchLoginHistoryTrash, 
                'user_email' => $searchLoginHistoryTrash, 
                'user_login' => $searchLoginHistoryTrash, 
                'user_logout' => $searchLoginHistoryTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where('trash_status', 'true');
        if(array_key_exists("unique_id",$params)){
            $this->db->where('unique_id',$params['unique_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countLoginHistoryTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('unique_id','DESC');
		if(!empty($params['search_login_history_trash'])){
            $searchLoginHistoryTrash = $params['search_login_history_trash'];
            $likeArr = array(
                'user_name' => $searchLoginHistoryTrash, 
                'user_email' => $searchLoginHistoryTrash, 
                'user_login' => $searchLoginHistoryTrash, 
                'user_logout' => $searchLoginHistoryTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where('trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewLoginActivityData($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('unique_id','DESC');
		if(!empty($params['search_login_activity'])){
            $searchLoginActivity = $params['search_login_activity'];
            $likeArr = array(
                'user_name' => $searchLoginActivity, 
                'user_email' => $searchLoginActivity, 
                'user_login' => $searchLoginActivity, 
                'user_logout' => $searchLoginActivity
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where('user_id', $where);
        $this->db->where('user_role !=', 'Super');
        if(array_key_exists("unique_id",$params)){
            $this->db->where('unique_id',$params['unique_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countLoginActivityData($params, $where, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('unique_id','DESC');
		if(!empty($params['search_login_activity'])){
            $searchLoginActivity = $params['search_login_activity'];
            $likeArr = array(
                'user_name' => $searchLoginActivity, 
                'user_email' => $searchLoginActivity, 
                'user_login' => $searchLoginActivity, 
                'user_logout' => $searchLoginActivity
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where('user_id', $where);
        $this->db->where('user_role !=', 'Super');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ip Functions
	function viewIpData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('data_id','DESC');
		if(!empty($params['search_ip'])){
            $searchIp = $params['search_ip'];
            $likeArr = array(
                'data_name' => $searchIp, 
                'data_ip' => $searchIp, 
                'data_email' => $searchIp, 
                'data_time' => $searchIp, 
                'data_start_time' => $searchIp, 
                'data_end_time' => $searchIp
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_ip_status'])){
            $searchIpStatus = $params['search_ip_status'];
            $this->db->where('data_status', $searchIpStatus);
        }
        $this->db->where('trash_status', 'false');
        if(array_key_exists("data_id",$params)){
            $this->db->where('data_id',$params['data_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countIpData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('data_id','DESC');
		if(!empty($params['search_ip'])){
            $searchIp = $params['search_ip'];
            $likeArr = array(
                'data_name' => $searchIp, 
                'data_ip' => $searchIp, 
                'data_email' => $searchIp, 
                'data_time' => $searchIp, 
                'data_start_time' => $searchIp, 
                'data_end_time' => $searchIp
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_ip_status'])){
            $searchIpStatus = $params['search_ip_status'];
            $this->db->where('data_status', $searchIpStatus);
        }
        $this->db->where('trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewIpTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('data_id','DESC');
		if(!empty($params['search_ip_trash'])){
            $searchIpTrash = $params['search_ip_trash'];
            $likeArr = array(
                'data_name' => $searchIpTrash, 
                'data_ip' => $searchIpTrash, 
                'data_email' => $searchIpTrash, 
                'data_time' => $searchIpTrash, 
                'data_start_time' => $searchIpTrash, 
                'data_end_time' => $searchIpTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_ip_trash_status'])){
            $searchIpTrashStatus = $params['search_ip_trash_status'];
            $this->db->where('data_status', $searchIpTrashStatus);
        }
        $this->db->where('trash_status', 'true');
        if(array_key_exists("data_id",$params)){
            $this->db->where('data_id',$params['data_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countIpTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('data_id','DESC');
		if(!empty($params['search_ip_trash'])){
            $searchIpTrash = $params['search_ip_trash'];
            $likeArr = array(
                'data_name' => $searchIpTrash, 
                'data_ip' => $searchIpTrash, 
                'data_email' => $searchIpTrash, 
                'data_time' => $searchIpTrash, 
                'data_start_time' => $searchIpTrash, 
                'data_end_time' => $searchIpTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_ip_trash_status'])){
            $searchIpTrashStatus = $params['search_ip_trash_status'];
            $this->db->where('data_status', $searchIpTrashStatus);
        }
        $this->db->where('trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Extra Functions
    function getPermissionData($userID, $alias, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('user_id', $userID);
		$this->db->where('permission_alias', $alias);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function userPermissionData($aliasName){
        $this->db->select('*');
		$this->db->from(PERMISSION_USER_TABLE);
		$this->db->where('user_id',$this->session->userdata['user_id']); 
		$this->db->where('permission_alias',$aliasName); 
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
    }
    
	// ====================================================================== //
    /* Invoice Functions */
    // ====================================================================== //
	// Publisher Functions
	function viewPublisherData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('publisher_id','DESC');
		if(!empty($params['search_publisher'])){
            $searchPublisher = $params['search_publisher'];
            $likeArr = array(
                'publisher_name' => $searchPublisher, 
                'publisher_address' => $searchPublisher, 
                'publisher_gst_number' => $searchPublisher
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_publisher_status'])){
            $searchPublisherStatus = $params['search_publisher_status'];
            $this->db->where('publisher_status', $searchPublisherStatus);
        }
        if(array_key_exists("publisher_id",$params)){
            $this->db->where('publisher_id',$params['publisher_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countPublisherData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('publisher_id','DESC');
		if(!empty($params['search_publisher'])){
            $searchPublisher = $params['search_publisher'];
            $likeArr = array(
                'publisher_name' => $searchPublisher, 
                'publisher_address' => $searchPublisher, 
                'publisher_gst_number' => $searchPublisher
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_publisher_status'])){
            $searchPublisherStatus = $params['search_publisher_status'];
            $this->db->where('publisher_status', $searchPublisherStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Advertiser Functions
	function viewAdvertiserData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('advertiser_id','DESC');
		if(!empty($params['search_advertiser'])){
            $searchAdvertiser = $params['search_advertiser'];
            $likeArr = array(
                'advertiser_name' => $searchAdvertiser, 
                'advertiser_address' => $searchAdvertiser, 
                'advertiser_project' => $searchAdvertiser
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_advertiser_status'])){
            $searchAdvertiserStatus = $params['search_advertiser_status'];
            $this->db->where('advertiser_status', $searchAdvertiserStatus);
        }
        if(array_key_exists("advertiser_id",$params)){
            $this->db->where('advertiser_id',$params['advertiser_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAdvertiserData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('advertiser_id','DESC');
		if(!empty($params['search_advertiser'])){
            $searchAdvertiser = $params['search_advertiser'];
            $likeArr = array(
                'advertiser_name' => $searchAdvertiser, 
                'advertiser_address' => $searchAdvertiser, 
                'advertiser_project' => $searchAdvertiser
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_advertiser_status'])){
            $searchAdvertiserStatus = $params['search_advertiser_status'];
            $this->db->where('advertiser_status', $searchAdvertiserStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Invoice Functions
	function viewInvoiceData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('invoice_id','DESC');
		$this->db->join(ADVERTISER_TABLE, INVOICE_TABLE . '.advertiser_id = ' . ADVERTISER_TABLE . '.advertiser_id');
		if(!empty($params['search_invoice'])){
            $searchInvoice = $params['search_invoice'];
            $likeArr = array(
                ADVERTISER_TABLE . '.advertiser_name' => $searchInvoice, 
                'invoice_generate_date' => $searchInvoice, 
                'invoice_due_date' => $searchInvoice, 
                'invoice_price' => $searchInvoice
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_invoice_status'])){
            $searchInvoiceStatus = $params['search_invoice_status'];
            $this->db->where('invoice_status', $searchInvoiceStatus);
        }
        $this->db->where(INVOICE_TABLE . '.trash_status', 'false');
        if(array_key_exists("invoice_id",$params)){
            $this->db->where('invoice_id',$params['invoice_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countInvoiceData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('invoice_id','DESC');
		$this->db->join(ADVERTISER_TABLE, INVOICE_TABLE . '.advertiser_id = ' . ADVERTISER_TABLE . '.advertiser_id');
		if(!empty($params['search_invoice'])){
            $searchInvoice = $params['search_invoice'];
            $likeArr = array(
                ADVERTISER_TABLE . '.advertiser_name' => $searchInvoice, 
                'invoice_generate_date' => $searchInvoice, 
                'invoice_due_date' => $searchInvoice, 
                'invoice_price' => $searchInvoice
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_invoice_status'])){
            $searchInvoiceStatus = $params['search_invoice_status'];
            $this->db->where('invoice_status', $searchInvoiceStatus);
        }
        $this->db->where(INVOICE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewInvoiceTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('invoice_id','DESC');
		$this->db->join(ADVERTISER_TABLE, INVOICE_TABLE . '.advertiser_id = ' . ADVERTISER_TABLE . '.advertiser_id');
		if(!empty($params['search_invoice_trash'])){
            $searchInvoiceTrash = $params['search_invoice_trash'];
            $likeArr = array(
                ADVERTISER_TABLE . '.advertiser_name' => $searchInvoiceTrash, 
                'invoice_generate_date' => $searchInvoiceTrash, 
                'invoice_due_date' => $searchInvoiceTrash, 
                'invoice_price' => $searchInvoiceTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_invoice_trash_status'])){
            $searchInvoiceTrashStatus = $params['search_invoice_trash_status'];
            $this->db->where('invoice_status', $searchInvoiceTrashStatus);
        }
        $this->db->where(INVOICE_TABLE . '.trash_status', 'true');
        if(array_key_exists("invoice_id",$params)){
            $this->db->where('invoice_id',$params['invoice_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countInvoiceTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('invoice_id','DESC');
		$this->db->join(ADVERTISER_TABLE, INVOICE_TABLE . '.advertiser_id = ' . ADVERTISER_TABLE . '.advertiser_id');
		if(!empty($params['search_invoice_trash'])){
            $searchInvoiceTrash = $params['search_invoice_trash'];
            $likeArr = array(
                ADVERTISER_TABLE . '.advertiser_name' => $searchInvoiceTrash, 
                'invoice_generate_date' => $searchInvoiceTrash, 
                'invoice_due_date' => $searchInvoiceTrash, 
                'invoice_price' => $searchInvoiceTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_invoice_trash_status'])){
            $searchInvoiceTrashStatus = $params['search_invoice_trash_status'];
            $this->db->where('invoice_status', $searchInvoiceTrashStatus);
        }
        $this->db->where(INVOICE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// ====================================================================== //
    /* SOP Functions */
    // ====================================================================== //
	// Procedure Functions
	function insertImage($data = array()){ 
        if(!empty($data)){ 
            $insert = $this->db->insert_batch(SOP_IMAGE_TABLE, $data); 
            return $insert?$this->db->insert_id():false; 
        } 
        return false; 
    } 
    
    function viewProcedureData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('sop_id','DESC');
		if(!empty($params['search_sop_procedure'])){
            $searchSopProcedure = $params['search_sop_procedure'];
            $likeArr = array(
                'sop_title' => $searchSopProcedure, 
                'sop_department' => $searchSopProcedure, 
                'sop_created_by' => $searchSopProcedure
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_sop_procedure_status'])){
            $searchSopProcedureStatus = $params['search_sop_procedure_status'];
            $this->db->where('sop_status', $searchSopProcedureStatus);
        }
        $this->db->where('trash_status', 'false');
        if(array_key_exists("sop_id",$params)){
            $this->db->where('sop_id',$params['sop_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countProcedureData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('sop_id','DESC');
		if(!empty($params['search_sop_procedure'])){
            $searchSopProcedure = $params['search_sop_procedure'];
            $likeArr = array(
                'sop_title' => $searchSopProcedure, 
                'sop_department' => $searchSopProcedure, 
                'sop_created_by' => $searchSopProcedure
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_sop_procedure_status'])){
            $searchSopProcedureStatus = $params['search_sop_procedure_status'];
            $this->db->where('sop_status', $searchSopProcedureStatus);
        }
        $this->db->where('trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewProcedureTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('sop_id','DESC');
		if(!empty($params['search_sop_procedure_trash'])){
            $searchSopProcedureTrash = $params['search_sop_procedure_trash'];
            $likeArr = array(
                'sop_title' => $searchSopProcedureTrash, 
                'sop_department' => $searchSopProcedureTrash, 
                'sop_created_by' => $searchSopProcedureTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_sop_procedure_trash_status'])){
            $searchSopProcedureStatusTrash = $params['search_sop_procedure_trash_status'];
            $this->db->where('sop_status', $searchSopProcedureStatusTrash);
        }
        $this->db->where('trash_status', 'true');
        if(array_key_exists("sop_id",$params)){
            $this->db->where('sop_id',$params['sop_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countProcedureTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('sop_id','DESC');
		if(!empty($params['search_sop_procedure_trash'])){
            $searchSopProcedureTrash = $params['search_sop_procedure_trash'];
            $likeArr = array(
                'sop_title' => $searchSopProcedureTrash, 
                'sop_department' => $searchSopProcedureTrash, 
                'sop_created_by' => $searchSopProcedureTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_sop_procedure_trash_status'])){
            $searchSopProcedureTrashStatus = $params['search_sop_procedure_trash_status'];
            $this->db->where('sop_status', $searchSopProcedureTrashStatus);
        }
        $this->db->where('trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
    function getRows($sopID = ''){ 
        $this->db->select("*, (SELECT sop_image FROM ".SOP_IMAGE_TABLE." WHERE sop_id = ".SOP_PROCEDURE_TABLE.".sop_id ORDER BY sop_id DESC LIMIT 1)"); 
        $this->db->from(SOP_PROCEDURE_TABLE);
        if($sopID){ 
            $this->db->where('sop_id', $sopID); 
            $query  = $this->db->get(); 
            $result = ($query->num_rows() > 0)?$query->row_array():array(); 
            if(!empty($result)){ 
                $this->db->select('*'); 
                $this->db->from(SOP_IMAGE_TABLE); 
                $this->db->where('sop_id', $result['sop_id']); 
                $this->db->order_by('sop_id', 'DESC'); 
                $query  = $this->db->get(); 
                $result2 = ($query->num_rows() > 0)?$query->result_array():array(); 
                $result['sop_image'] = $result2;  
            }  
        } else { 
            $this->db->order_by('sop_id', 'DESC'); 
            $query  = $this->db->get(); 
            $result = ($query->num_rows() > 0)?$query->result_array():array(); 
        } 
        return !empty($result)?$result:false; 
    } 
    
    function getImgRow($imageID){ 
        $this->db->select('*'); 
        $this->db->from(SOP_IMAGE_TABLE); 
        $this->db->where('image_id', $imageID); 
        $query  = $this->db->get(); 
        return ($query->num_rows() > 0)?$query->row_array():false; 
    } 
    
    function deleteImage($con){ 
        $delete = $this->db->delete(SOP_IMAGE_TABLE, $con); 
        return $delete?true:false; 
    }
    
    // Department Functions
	function viewSopDepartmentData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('unique_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, SOP_DEPARTMENT_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_sop_department'])){
            $searchSopDepartment = $params['search_sop_department'];
            $likeArr = array(
                DEPARTMENT_TABLE . '.department_name' => $searchSopDepartment
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where(SOP_DEPARTMENT_TABLE . '.trash_status', 'false');
        if(array_key_exists("unique_id",$params)){
            $this->db->where('unique_id',$params['unique_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countSopDepartmentData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('unique_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, SOP_DEPARTMENT_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_sop_department'])){
            $searchSopDepartment = $params['search_sop_department'];
            $likeArr = array(
                DEPARTMENT_TABLE . '.department_name' => $searchSopDepartment
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where(SOP_DEPARTMENT_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewSopDepartmentTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('unique_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, SOP_DEPARTMENT_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_sop_department_trash'])){
            $searchSopDepartmentTrash = $params['search_sop_department_trash'];
            $likeArr = array(
                DEPARTMENT_TABLE . '.department_name' => $searchSopDepartmentTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where(SOP_DEPARTMENT_TABLE . '.trash_status', 'true');
        if(array_key_exists("unique_id",$params)){
            $this->db->where('unique_id',$params['unique_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countSopDepartmentTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('unique_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, SOP_DEPARTMENT_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_sop_department_trash'])){
            $searchSopDepartmentTrash = $params['search_sop_department_trash'];
            $likeArr = array(
                DEPARTMENT_TABLE . '.department_name' => $searchSopDepartmentTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where(SOP_DEPARTMENT_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// User Functions
	function viewSopUserData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('unique_id','DESC');
		$this->db->join(MASTER_USER_TABLE, SOP_USER_TABLE . '.user_id = ' . MASTER_USER_TABLE . '.user_id');
		$this->db->join(DEPARTMENT_TABLE, SOP_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_sop_user'])){
            $searchSopUser = $params['search_sop_user'];
            $likeArr = array(
                MASTER_USER_TABLE . '.user_name' => $searchSopUser, 
                DEPARTMENT_TABLE . '.department_name' => $searchSopUser
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where(SOP_USER_TABLE . '.trash_status', 'false');
        if(array_key_exists("unique_id",$params)){
            $this->db->where('unique_id',$params['unique_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countSopUserData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('unique_id','DESC');
		$this->db->join(MASTER_USER_TABLE, SOP_USER_TABLE . '.user_id = ' . MASTER_USER_TABLE . '.user_id');
		$this->db->join(DEPARTMENT_TABLE, SOP_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_sop_user'])){
            $searchSopUser = $params['search_sop_user'];
            $likeArr = array(
                MASTER_USER_TABLE . '.user_name' => $searchSopUser, 
                DEPARTMENT_TABLE . '.department_name' => $searchSopUser
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where(SOP_USER_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewSopUserTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('unique_id','DESC');
		$this->db->join(MASTER_USER_TABLE, SOP_USER_TABLE . '.user_id = ' . MASTER_USER_TABLE . '.user_id');
		$this->db->join(DEPARTMENT_TABLE, SOP_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_sop_user_trash'])){
            $searchSopUserTrash = $params['search_sop_user_trash'];
            $likeArr = array(
                MASTER_USER_TABLE . '.user_name' => $searchSopUserTrash,
                DEPARTMENT_TABLE . '.department_name' => $searchSopUserTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where(SOP_USER_TABLE . '.trash_status', 'true');
        if(array_key_exists("unique_id",$params)){
            $this->db->where('unique_id',$params['unique_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countSopUserTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('unique_id','DESC');
		$this->db->join(MASTER_USER_TABLE, SOP_USER_TABLE . '.user_id = ' . MASTER_USER_TABLE . '.user_id');
		$this->db->join(DEPARTMENT_TABLE, SOP_USER_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_sop_user_trash'])){
            $searchSopUserTrash = $params['search_sop_user_trash'];
            $likeArr = array(
                MASTER_USER_TABLE . '.user_name' => $searchSopUserTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchSopUserTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where(SOP_USER_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// User Procedure Functions
	function viewUserProcedureData($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('sop_id','DESC');
		if(!empty($params['search_sop_user_procedure'])){
            $searchSopUserProcedure = $params['search_sop_user_procedure'];
            $likeArr = array(
                'sop_title' => $searchSopUserProcedure, 
                'sop_department' => $searchSopUserProcedure, 
                'sop_created_by' => $searchSopUserProcedure
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        $this->db->where($where);
        if(array_key_exists("sop_id",$params)){
            $this->db->where('sop_id',$params['sop_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	// ====================================================================== //
    /* HRM Functions */
    // ====================================================================== //
	// Employee Functions
	function viewEmployeeData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('employee_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_employee'])){
            $searchEmployee = $params['search_employee'];
            $likeArr = array(
                'employee_first_name' => $searchEmployee, 
                'employee_middle_name' => $searchEmployee, 
                'employee_last_name' => $searchEmployee, 
                'employee_email' => $searchEmployee, 
                DEPARTMENT_TABLE . '.department_name' => $searchEmployee, 
                'employee_mobile_no' => $searchEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_employee_is_employee'])){  
            $searchEmployeeIsEmployee = $params['search_employee_is_employee'];
            $this->db->where('is_employee', $searchEmployeeIsEmployee);
        }
        if(!empty($params['search_employee_type'])){  
            $searchEmployeeType = $params['search_employee_type'];
            $this->db->where('employee_type', $searchEmployeeType);
        }
        if(!empty($params['search_employee_status'])){  
            $searchEmployeeStatus = $params['search_employee_status'];
            $this->db->where('employee_status', $searchEmployeeStatus);
        }
        if(!empty($params['search_employee_created_start_date']) and !empty($params['search_employee_created_end_date'])){
            $searchEmployeeCreatedStartDate = $params['search_employee_created_start_date'];
            $searchEmployeeCreatedEndDate = $params['search_employee_created_end_date'];
            $this->db->where("STR_TO_DATE(employee_created_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchEmployeeCreatedStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(employee_created_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchEmployeeCreatedEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_employee']) and empty($params['search_employee_is_employee']) and empty($params['search_employee_type']) and empty($params['search_employee_status']) and empty($params['search_employee_created_start_date']) and empty($params['search_employee_created_end_date'])){
            $this->db->where('employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EMPLOYEE_TABLE . '.trash_status', 'false');
        if(array_key_exists("employee_id",$params)){
            $this->db->where('employee_id',$params['employee_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countEmployeeData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('employee_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_employee'])){
            $searchEmployee = $params['search_employee'];
            $likeArr = array(
                'employee_first_name' => $searchEmployee, 
                'employee_middle_name' => $searchEmployee, 
                'employee_last_name' => $searchEmployee, 
                'employee_email' => $searchEmployee, 
                DEPARTMENT_TABLE . '.department_name' => $searchEmployee, 
                'employee_mobile_no' => $searchEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_employee_is_employee'])){  
            $searchEmployeeIsEmployee = $params['search_employee_is_employee'];
            $this->db->where('is_employee', $searchEmployeeIsEmployee);
        }
        if(!empty($params['search_employee_type'])){  
            $searchEmployeeType = $params['search_employee_type'];
            $this->db->where('employee_type', $searchEmployeeType);
        }
        if(!empty($params['search_employee_status'])){  
            $searchEmployeeStatus = $params['search_employee_status'];
            $this->db->where('employee_status', $searchEmployeeStatus);
        }
        if(!empty($params['search_employee_created_start_date']) and !empty($params['search_employee_created_end_date'])){
            $searchEmployeeCreatedStartDate = $params['search_employee_created_start_date'];
            $searchEmployeeCreatedEndDate = $params['search_employee_created_end_date'];
            $this->db->where("STR_TO_DATE(employee_created_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchEmployeeCreatedStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(employee_created_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchEmployeeCreatedEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_employee']) and empty($params['search_employee_is_employee']) and empty($params['search_employee_type']) and empty($params['search_employee_status']) and empty($params['search_employee_created_start_date']) and empty($params['search_employee_created_end_date'])){
            $this->db->where('employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EMPLOYEE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewEmployeeTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('employee_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_employee_trash'])){
            $searchEmployeeTrash = $params['search_employee_trash'];
            $likeArr = array(
                'employee_first_name' => $searchEmployeeTrash, 
                'employee_middle_name' => $searchEmployeeTrash, 
                'employee_last_name' => $searchEmployeeTrash, 
                'employee_email' => $searchEmployeeTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchEmployeeTrash, 
                'employee_mobile_no' => $searchEmployeeTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_employee_trash_is_employee'])){  
            $searchEmployeeTrashIsEmployee = $params['search_employee_trash_is_employee'];
            $this->db->where('is_employee', $searchEmployeeTrashIsEmployee);
        }
        if(!empty($params['search_employee_trash_type'])){  
            $searchEmployeeTrashType = $params['search_employee_trash_type'];
            $this->db->where('employee_type', $searchEmployeeTrashType);
        }
        if(!empty($params['search_employee_trash_status'])){  
            $searchEmployeeTrashStatus = $params['search_employee_trash_status'];
            $this->db->where('employee_status', $searchEmployeeTrashStatus);
        }
        if(!empty($params['search_employee_trash_created_start_date']) and !empty($params['search_employee_trash_created_end_date'])){
            $searchEmployeeTrashCreatedStartDate = $params['search_employee_trash_created_start_date'];
            $searchEmployeeTrashCreatedEndDate = $params['search_employee_trash_created_end_date'];
            $this->db->where("STR_TO_DATE(employee_created_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchEmployeeTrashCreatedStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(employee_created_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchEmployeeTrashCreatedEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_employee_trash']) and empty($params['search_employee_trash_is_employee']) and empty($params['search_employee_trash_type']) and empty($params['search_employee_trash_status']) and empty($params['search_employee_trash_created_start_date']) and empty($params['search_employee_trash_created_end_date'])){
            $this->db->where('employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EMPLOYEE_TABLE . '.trash_status', 'true');
        if(array_key_exists("employee_id",$params)){
            $this->db->where('employee_id',$params['employee_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countEmployeeTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('employee_id','DESC');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_employee_trash'])){
            $searchEmployeeTrash = $params['search_employee_trash'];
            $likeArr = array(
                'employee_first_name' => $searchEmployeeTrash, 
                'employee_middle_name' => $searchEmployeeTrash, 
                'employee_last_name' => $searchEmployeeTrash, 
                'employee_email' => $searchEmployeeTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchEmployeeTrash, 
                'employee_mobile_no' => $searchEmployeeTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_employee_trash_is_employee'])){  
            $searchEmployeeTrashIsEmployee = $params['search_employee_trash_is_employee'];
            $this->db->where('is_employee', $searchEmployeeTrashIsEmployee);
        }
        if(!empty($params['search_employee_trash_type'])){  
            $searchEmployeeTrashType = $params['search_employee_trash_type'];
            $this->db->where('employee_type', $searchEmployeeTrashType);
        }
        if(!empty($params['search_employee_trash_status'])){  
            $searchEmployeeTrashStatus = $params['search_employee_trash_status'];
            $this->db->where('employee_status', $searchEmployeeTrashStatus);
        }
        if(!empty($params['search_employee_trash_created_start_date']) and !empty($params['search_employee_trash_created_end_date'])){
            $searchEmployeeTrashCreatedStartDate = $params['search_employee_trash_created_start_date'];
            $searchEmployeeTrashCreatedEndDate = $params['search_employee_trash_created_end_date'];
            $this->db->where("STR_TO_DATE(employee_created_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchEmployeeTrashCreatedStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(employee_created_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchEmployeeTrashCreatedEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_employee_trash']) and empty($params['search_employee_trash_is_employee']) and empty($params['search_employee_trash_type']) and empty($params['search_employee_trash_status']) and empty($params['search_employee_trash_created_start_date']) and empty($params['search_employee_trash_created_end_date'])){
            $this->db->where('employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EMPLOYEE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function getSerialNoData() {
        $this->db->select_max('employee_serial_no');
        $query = $this->db->get('hrm_employee');
        return $query->row()->employee_serial_no;
    }
	
	// Attendance Admin Functions
	function viewAttendanceAdminData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_attendance_admin'])){
            $searchAttendanceAdmin = $params['search_attendance_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAttendanceAdmin, 
                DEPARTMENT_TABLE . '.department_name' => $searchAttendanceAdmin, 
                'working_date' => $searchAttendanceAdmin, 
                'working_hours' => $searchAttendanceAdmin, 
                'working_overtime_hours' => $searchAttendanceAdmin,
                'working_belowtime_hours' => $searchAttendanceAdmin
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_admin_type'])){  
            $searchAttendanceAdminType = $params['search_attendance_admin_type'];
            $this->db->where(HRM_ATTENDANCE_TABLE . '.working_type', $searchAttendanceAdminType);
        }
        if(!empty($params['search_attendance_admin_status'])){  
            $searchAttendanceAdminStatus = $params['search_attendance_admin_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAttendanceAdminStatus);
        }
        if(!empty($params['search_attendance_admin_working_start_date']) and !empty($params['search_attendance_admin_working_end_date'])){
            $searchAttendanceAdminWorkingStartDate = $params['search_attendance_admin_working_start_date'];
            $searchAttendanceAdminWorkingEndDate = $params['search_attendance_admin_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceAdminWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceAdminWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_admin']) and empty($params['search_attendance_admin_type']) and empty($params['search_attendance_admin_status']) and empty($params['search_attendance_admin_working_start_date']) and empty($params['search_attendance_admin_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
        if(array_key_exists("working_id",$params)){
            $this->db->where('working_id',$params['working_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAttendanceAdminData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_attendance_admin'])){
            $searchAttendanceAdmin = $params['search_attendance_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAttendanceAdmin, 
                DEPARTMENT_TABLE . '.department_name' => $searchAttendanceAdmin, 
                'working_date' => $searchAttendanceAdmin, 
                'working_hours' => $searchAttendanceAdmin, 
                'working_overtime_hours' => $searchAttendanceAdmin,
                'working_belowtime_hours' => $searchAttendanceAdmin
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_admin_type'])){  
            $searchAttendanceAdminType = $params['search_attendance_admin_type'];
            $this->db->where(HRM_ATTENDANCE_TABLE . '.working_type', $searchAttendanceAdminType);
        }
        if(!empty($params['search_attendance_admin_status'])){  
            $searchAttendanceAdminStatus = $params['search_attendance_admin_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAttendanceAdminStatus);
        }
        if(!empty($params['search_attendance_admin_working_start_date']) and !empty($params['search_attendance_admin_working_end_date'])){
            $searchAttendanceAdminWorkingStartDate = $params['search_attendance_admin_working_start_date'];
            $searchAttendanceAdminWorkingEndDate = $params['search_attendance_admin_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceAdminWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceAdminWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_admin']) and empty($params['search_attendance_admin_type']) and empty($params['search_attendance_admin_status']) and empty($params['search_attendance_admin_working_start_date']) and empty($params['search_attendance_admin_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function getAttendanceAdminHoursData($name, $params, $table){
	    $this->db->select('SEC_TO_TIME(SUM(TIME_TO_SEC(`'.$name.'`)))');
		$this->db->from($table);
		$this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_attendance_admin'])){
            $searchAttendanceAdmin = $params['search_attendance_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAttendanceAdmin
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_admin_working_start_date']) and !empty($params['search_attendance_admin_working_end_date'])){
            $searchAttendanceAdminWorkingStartDate = $params['search_attendance_admin_working_start_date'];
            $searchAttendanceAdminWorkingEndDate = $params['search_attendance_admin_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceAdminWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceAdminWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_admin_working_start_date']) and empty($params['search_attendance_admin_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
	function countAttendanceAdminHoursData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_attendance_admin'])){
            $searchAttendanceAdmin = $params['search_attendance_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAttendanceAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAttendanceAdmin
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_admin_working_start_date']) and !empty($params['search_attendance_admin_working_end_date'])){
            $searchAttendanceAdminWorkingStartDate = $params['search_attendance_admin_working_start_date'];
            $searchAttendanceAdminWorkingEndDate = $params['search_attendance_admin_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceAdminWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceAdminWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_admin_working_start_date']) and empty($params['search_attendance_admin_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewAttendanceAdminTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_attendance_admin_trash'])){
            $searchAttendanceAdminTrash = $params['search_attendance_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAttendanceAdminTrash,
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAttendanceAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAttendanceAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAttendanceAdminTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchAttendanceAdminTrash, 
                'working_date' => $searchAttendanceAdminTrash, 
                'working_hours' => $searchAttendanceAdminTrash, 
                'working_overtime_hours' => $searchAttendanceAdminTrash,
                'working_belowtime_hours' => $searchAttendanceAdminTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_admin_trash_type'])){  
            $searchAttendanceAdminTrashType = $params['search_attendance_admin_trash_type'];
            $this->db->where(HRM_ATTENDANCE_TABLE . '.working_type', $searchAttendanceAdminTrashType);
        }
        if(!empty($params['search_attendance_admin_trash_status'])){  
            $searchAttendanceAdminTrashStatus = $params['search_attendance_admin_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAttendanceAdminTrashStatus);
        }
        if(!empty($params['search_attendance_admin_trash_working_start_date']) and !empty($params['search_attendance_admin_trash_working_end_date'])){
            $searchAttendanceAdminTrashWorkingStartDate = $params['search_attendance_admin_trash_working_start_date'];
            $searchAttendanceAdminTrashWorkingEndDate = $params['search_attendance_admin_trash_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceAdminTrashWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceAdminTrashWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_admin_trash']) and empty($params['search_attendance_admin_trash_type']) and empty($params['search_attendance_admin_trash_status']) and empty($params['search_attendance_admin_trash_working_start_date']) and empty($params['search_attendance_admin_trash_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'true');
        if(array_key_exists("working_id",$params)){
            $this->db->where('working_id',$params['working_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAttendanceAdminTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_attendance_admin_trash'])){
            $searchAttendanceAdminTrash = $params['search_attendance_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAttendanceAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAttendanceAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAttendanceAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAttendanceAdminTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchAttendanceAdminTrash, 
                'working_date' => $searchAttendanceAdminTrash, 
                'working_hours' => $searchAttendanceAdminTrash, 
                'working_overtime_hours' => $searchAttendanceAdminTrash,
                'working_belowtime_hours' => $searchAttendanceAdminTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_admin_trash_type'])){  
            $searchAttendanceAdminTrashType = $params['search_attendance_admin_trash_type'];
            $this->db->where(HRM_ATTENDANCE_TABLE . '.working_type', $searchAttendanceAdminTrashType);
        }
        if(!empty($params['search_attendance_admin_trash_status'])){  
            $searchAttendanceAdminTrashStatus = $params['search_attendance_admin_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAttendanceAdminTrashStatus);
        }
        if(!empty($params['search_attendance_admin_trash_working_start_date']) and !empty($params['search_attendance_admin_trash_working_end_date'])){
            $searchAttendanceAdminTrashWorkingStartDate = $params['search_attendance_admin_trash_working_start_date'];
            $searchAttendanceAdminTrashWorkingEndDate = $params['search_attendance_admin_trash_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceAdminTrashWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceAdminTrashWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_admin_trash']) and empty($params['search_attendance_admin_trash_type']) and empty($params['search_attendance_admin_trash_status']) and empty($params['search_attendance_admin_trash_working_start_date']) and empty($params['search_attendance_admin_trash_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function getAttendanceAdminTrashHoursData($name, $params, $table){
	    $this->db->select('SEC_TO_TIME(SUM(TIME_TO_SEC(`'.$name.'`)))');
		$this->db->from($table);
		$this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_attendance_admin_trash'])){
            $searchAttendanceAdminTrash = $params['search_attendance_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAttendanceAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAttendanceAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAttendanceAdminTrash, 
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_admin_trash_working_start_date']) and !empty($params['search_attendance_admin_trash_working_end_date'])){
            $searchAttendanceAdminTrashWorkingStartDate = $params['search_attendance_admin_trash_working_start_date'];
            $searchAttendanceAdminTrashWorkingEndDate = $params['search_attendance_admin_trash_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceAdminTrashWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceAdminTrashWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_admin_trash_working_start_date']) and empty($params['search_attendance_admin_trash_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'true');
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
	function countAttendanceAdminTrashHoursData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_attendance_admin_trash'])){
            $searchAttendanceAdminTrash = $params['search_attendance_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAttendanceAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAttendanceAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAttendanceAdminTrash, 
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_admin_trash_working_start_date']) and !empty($params['search_attendance_admin_trash_working_end_date'])){
            $searchAttendanceAdminTrashWorkingStartDate = $params['search_attendance_admin_trash_working_start_date'];
            $searchAttendanceAdminTrashWorkingEndDate = $params['search_attendance_admin_trash_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceAdminTrashWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceAdminTrashWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_admin_trash_working_start_date']) and empty($params['search_attendance_admin_trash_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Attendance Employee Functions
	function viewAttendanceEmployeeData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_attendance_employee'])){
            $searchAttendanceEmployee = $params['search_attendance_employee'];
            $likeArr = array(
                'working_hours' => $searchAttendanceEmployee, 
                'working_overtime_hours' => $searchAttendanceEmployee,
                'working_belowtime_hours' => $searchAttendanceEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_employee_working_start_date']) and !empty($params['search_attendance_employee_working_end_date'])){
            $searchAttendanceEmployeeWorkingStartDate = $params['search_attendance_employee_working_start_date'];
            $searchAttendanceEmployeeWorkingEndDate = $params['search_attendance_employee_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceEmployeeWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceEmployeeWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_employee_working_start_date']) and empty($params['search_attendance_employee_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_ATTENDANCE_TABLE . '.user_id', $this->session->userdata['user_id']);
        if(array_key_exists("working_id",$params)){
            $this->db->where('working_id',$params['working_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAttendanceEmployeeData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_attendance_employee'])){
            $searchAttendanceEmployee = $params['search_attendance_employee'];
            $likeArr = array(
                'working_hours' => $searchAttendanceEmployee, 
                'working_overtime_hours' => $searchAttendanceEmployee,
                'working_belowtime_hours' => $searchAttendanceEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_attendance_employee_working_start_date']) and !empty($params['search_attendance_employee_working_end_date'])){
            $searchAttendanceEmployeeWorkingStartDate = $params['search_attendance_employee_working_start_date'];
            $searchAttendanceEmployeeWorkingEndDate = $params['search_attendance_employee_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceEmployeeWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceEmployeeWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_employee_working_start_date']) and empty($params['search_attendance_employee_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_ATTENDANCE_TABLE . '.user_id', $this->session->userdata['user_id']);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function getAttendanceEmployeeDashboardHoursData($name, $where, $table){
	    $this->db->select('SEC_TO_TIME(SUM(TIME_TO_SEC(`'.$name.'`)))');
		$this->db->from($table);
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
        $this->db->where($where);
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
    function countAttendanceEmployeeDashboardHoursData($where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
        $this->db->where($where);
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
        $result = $this->db->count_all_results();
		return $result;
    }
    
	function getAttendanceEmployeeHoursData($name, $params, $table){
	    $this->db->select('SEC_TO_TIME(SUM(TIME_TO_SEC(`'.$name.'`)))');
		$this->db->from($table);
		$this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
        if(!empty($params['search_attendance_employee_working_start_date']) and !empty($params['search_attendance_employee_working_end_date'])){
            $searchAttendanceEmployeeWorkingStartDate = $params['search_attendance_employee_working_start_date'];
            $searchAttendanceEmployeeWorkingEndDate = $params['search_attendance_employee_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceEmployeeWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceEmployeeWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_employee_working_start_date']) and empty($params['search_attendance_employee_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_ATTENDANCE_TABLE . '.user_id', $this->session->userdata['user_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    
	function countAttendanceEmployeeHoursData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('working_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_ATTENDANCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
        if(!empty($params['search_attendance_employee_working_start_date']) and !empty($params['search_attendance_employee_working_end_date'])){
            $searchAttendanceEmployeeWorkingStartDate = $params['search_attendance_employee_working_start_date'];
            $searchAttendanceEmployeeWorkingEndDate = $params['search_attendance_employee_working_end_date'];
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchAttendanceEmployeeWorkingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(working_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchAttendanceEmployeeWorkingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_attendance_employee_working_start_date']) and empty($params['search_attendance_employee_working_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_ATTENDANCE_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_ATTENDANCE_TABLE . '.user_id', $this->session->userdata['user_id']);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Leave Admin Functions
	function viewLeaveAdminData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_leave_admin'])){
            $searchLeaveAdmin = $params['search_leave_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchLeaveAdmin, 
                DEPARTMENT_TABLE . '.department_name' => $searchLeaveAdmin, 
                'leave_days' => $searchLeaveAdmin,
                'leave_reason' => $searchLeaveAdmin,
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_admin_type'])){  
            $searchLeaveAdminType = $params['search_leave_admin_type'];
            $this->db->where(HRM_LEAVE_TABLE . '.leave_type', $searchLeaveAdminType);
        }
        if(!empty($params['search_leave_admin_leave'])){  
            $searchLeaveAdminLeave = $params['search_leave_admin_leave'];
            $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $searchLeaveAdminLeave);
        }
        if(!empty($params['search_leave_admin_status'])){  
            $searchLeaveAdminStatus = $params['search_leave_admin_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchLeaveAdminStatus);
        }
        if(!empty($params['search_leave_admin_from_start_date']) and !empty($params['search_leave_admin_from_end_date'])){
            $searchLeaveAdminFromStartDate = $params['search_leave_admin_from_start_date'];
            $searchLeaveAdminFromEndDate = $params['search_leave_admin_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveAdminFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveAdminFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_admin']) and empty($params['search_leave_admin_type']) and empty($params['search_leave_admin_leave']) and empty($params['search_leave_admin_status']) and empty($params['search_leave_admin_from_start_date']) and empty($params['search_leave_admin_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'false');
        if(array_key_exists("leave_id",$params)){
            $this->db->where('leave_id',$params['leave_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
    function countLeaveAdminData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_leave_admin'])){
            $searchLeaveAdmin = $params['search_leave_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchLeaveAdmin, 
                DEPARTMENT_TABLE . '.department_name' => $searchLeaveAdmin, 
                'leave_days' => $searchLeaveAdmin,
                'leave_reason' => $searchLeaveAdmin,
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_admin_type'])){  
            $searchLeaveAdminType = $params['search_leave_admin_type'];
            $this->db->where(HRM_LEAVE_TABLE . '.leave_type', $searchLeaveAdminType);
        }
        if(!empty($params['search_leave_admin_leave'])){  
            $searchLeaveAdminLeave = $params['search_leave_admin_leave'];
            $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $searchLeaveAdminLeave);
        }
        if(!empty($params['search_leave_admin_status'])){  
            $searchLeaveAdminStatus = $params['search_leave_admin_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchLeaveAdminStatus);
        }
        if(!empty($params['search_leave_admin_from_start_date']) and !empty($params['search_leave_admin_from_end_date'])){
            $searchLeaveAdminFromStartDate = $params['search_leave_admin_from_start_date'];
            $searchLeaveAdminFromEndDate = $params['search_leave_admin_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveAdminFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveAdminFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_admin']) and empty($params['search_leave_admin_type']) and empty($params['search_leave_admin_leave']) and empty($params['search_leave_admin_status']) and empty($params['search_leave_admin_from_start_date']) and empty($params['search_leave_admin_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function getLeaveAdminDaysData($params, $where, $table){
        $this->db->select_sum('leave_days');
        $this->db->from($table);
        $this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_leave_admin'])){
            $searchLeaveAdmin = $params['search_leave_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchLeaveAdmin, 
                DEPARTMENT_TABLE . '.department_name' => $searchLeaveAdmin, 
                'leave_days' => $searchLeaveAdmin,
                'leave_reason' => $searchLeaveAdmin,
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_admin_type'])){  
            $searchLeaveAdminType = $params['search_leave_admin_type'];
            $this->db->where(HRM_LEAVE_TABLE . '.leave_type', $searchLeaveAdminType);
        }
        if(!empty($params['search_leave_admin_leave'])){  
            $searchLeaveAdminLeave = $params['search_leave_admin_leave'];
            $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $searchLeaveAdminLeave);
        }
        if(!empty($params['search_leave_admin_status'])){  
            $searchLeaveAdminStatus = $params['search_leave_admin_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchLeaveAdminStatus);
        }
        if(!empty($params['search_leave_admin_from_start_date']) and !empty($params['search_leave_admin_from_end_date'])){
            $searchLeaveAdminFromStartDate = $params['search_leave_admin_from_start_date'];
            $searchLeaveAdminFromEndDate = $params['search_leave_admin_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveAdminFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveAdminFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_admin']) and empty($params['search_leave_admin_type']) and empty($params['search_leave_admin_leave']) and empty($params['search_leave_admin_status']) and empty($params['search_leave_admin_from_start_date']) and empty($params['search_leave_admin_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'false');
        if($where){ $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $where); }
		$query = $this->db->get();
        $result = $query->row_array();
        return $result['leave_days'];
	}
	
	function getLeaveAdminPaidData($params, $table){
        $this->db->select_sum('leave_paid');
        $this->db->from($table);
        $this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_leave_admin'])){
            $searchLeaveAdmin = $params['search_leave_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchLeaveAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchLeaveAdmin, 
                DEPARTMENT_TABLE . '.department_name' => $searchLeaveAdmin, 
                'leave_days' => $searchLeaveAdmin,
                'leave_reason' => $searchLeaveAdmin,
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_admin_type'])){  
            $searchLeaveAdminType = $params['search_leave_admin_type'];
            $this->db->where(HRM_LEAVE_TABLE . '.leave_type', $searchLeaveAdminType);
        }
        if(!empty($params['search_leave_admin_leave'])){  
            $searchLeaveAdminLeave = $params['search_leave_admin_leave'];
            $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $searchLeaveAdminLeave);
        }
        if(!empty($params['search_leave_admin_status'])){  
            $searchLeaveAdminStatus = $params['search_leave_admin_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchLeaveAdminStatus);
        }
        if(!empty($params['search_leave_admin_from_start_date']) and !empty($params['search_leave_admin_from_end_date'])){
            $searchLeaveAdminFromStartDate = $params['search_leave_admin_from_start_date'];
            $searchLeaveAdminFromEndDate = $params['search_leave_admin_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveAdminFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveAdminFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_admin']) and empty($params['search_leave_admin_type']) and empty($params['search_leave_admin_leave']) and empty($params['search_leave_admin_status']) and empty($params['search_leave_admin_from_start_date']) and empty($params['search_leave_admin_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'false');
		$query = $this->db->get();
        $result = $query->row_array();
        return $result['leave_paid'];
	}
	
	function viewLeaveAdminTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_leave_admin_trash'])){
            $searchLeaveAdminTrash = $params['search_leave_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchLeaveAdminTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchLeaveAdminTrash, 
                'leave_days' => $searchLeaveAdminTrash,
                'leave_reason' => $searchLeaveAdminTrash,
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_admin_trash_type'])){  
            $searchLeaveAdminTrashType = $params['search_leave_admin_trash_type'];
            $this->db->where(HRM_LEAVE_TABLE . '.leave_type', $searchLeaveAdminTrashType);
        }
        if(!empty($params['search_leave_admin_trash_leave'])){  
            $searchLeaveAdminTrashLeave = $params['search_leave_admin_trash_leave'];
            $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $searchLeaveAdminTrashLeave);
        }
        if(!empty($params['search_leave_admin_trash_status'])){  
            $searchLeaveAdminTrashStatus = $params['search_leave_admin_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchLeaveAdminTrashStatus);
        }
        if(!empty($params['search_leave_admin_trash_from_start_date']) and !empty($params['search_leave_admin_trash_from_end_date'])){
            $searchLeaveAdminTrashFromStartDate = $params['search_leave_admin_trash_from_start_date'];
            $searchLeaveAdminTrashFromEndDate = $params['search_leave_admin_trash_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveAdminTrashFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveAdminTrashFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_admin_trash']) and empty($params['search_leave_admin_trash_type']) and empty($params['search_leave_admin_trash_leave']) and empty($params['search_leave_admin_trash_status']) and empty($params['search_leave_admin_trash_from_start_date']) and empty($params['search_leave_admin_trash_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'true');
        if(array_key_exists("leave_id",$params)){
            $this->db->where('leave_id',$params['leave_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countLeaveAdminTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_leave_admin_trash'])){
            $searchLeaveAdminTrash = $params['search_leave_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchLeaveAdminTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchLeaveAdminTrash, 
                'leave_days' => $searchLeaveAdminTrash,
                'leave_reason' => $searchLeaveAdminTrash,
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_admin_trash_type'])){  
            $searchLeaveAdminTrashType = $params['search_leave_admin_trash_type'];
            $this->db->where(HRM_LEAVE_TABLE . '.leave_type', $searchLeaveAdminTrashType);
        }
        if(!empty($params['search_leave_admin_trash_leave'])){  
            $searchLeaveAdminTrashLeave = $params['search_leave_admin_trash_leave'];
            $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $searchLeaveAdminTrashLeave);
        }
        if(!empty($params['search_leave_admin_trash_status'])){  
            $searchLeaveAdminTrashStatus = $params['search_leave_admin_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchLeaveAdminTrashStatus);
        }
        if(!empty($params['search_leave_admin_trash_from_start_date']) and !empty($params['search_leave_admin_trash_from_end_date'])){
            $searchLeaveAdminTrashFromStartDate = $params['search_leave_admin_trash_from_start_date'];
            $searchLeaveAdminTrashFromEndDate = $params['search_leave_admin_trash_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveAdminTrashFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveAdminTrashFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_admin_trash']) and empty($params['search_leave_admin_trash_type']) and empty($params['search_leave_admin_trash_leave']) and empty($params['search_leave_admin_trash_status']) and empty($params['search_leave_admin_trash_from_start_date']) and empty($params['search_leave_admin_trash_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function getLeaveAdminTrashDaysData($params, $where, $table){
        $this->db->select_sum('leave_days');
        $this->db->from($table);
        $this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_leave_admin_trash'])){
            $searchLeaveAdminTrash = $params['search_leave_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchLeaveAdminTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchLeaveAdminTrash, 
                'leave_days' => $searchLeaveAdminTrash,
                'leave_reason' => $searchLeaveAdminTrash,
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_admin_trash_type'])){  
            $searchLeaveAdminTrashType = $params['search_leave_admin_trash_type'];
            $this->db->where(HRM_LEAVE_TABLE . '.leave_type', $searchLeaveAdminTrashType);
        }
        if(!empty($params['search_leave_admin_trash_leave'])){  
            $searchLeaveAdminTrashLeave = $params['search_leave_admin_trash_leave'];
            $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $searchLeaveAdminTrashLeave);
        }
        if(!empty($params['search_leave_admin_trash_status'])){  
            $searchLeaveAdminTrashStatus = $params['search_leave_admin_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchLeaveAdminTrashStatus);
        }
        if(!empty($params['search_leave_admin_trash_from_start_date']) and !empty($params['search_leave_admin_trash_from_end_date'])){
            $searchLeaveAdminTrashFromStartDate = $params['search_leave_admin_trash_from_start_date'];
            $searchLeaveAdminTrashFromEndDate = $params['search_leave_admin_trash_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveAdminTrashFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveAdminTrashFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_admin_trash']) and empty($params['search_leave_admin_trash_type']) and empty($params['search_leave_admin_trash_leave']) and empty($params['search_leave_admin_trash_status']) and empty($params['search_leave_admin_trash_from_start_date']) and empty($params['search_leave_admin_trash_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'true');
        if($where){ $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $where); }
		$query = $this->db->get();
        $result = $query->row_array();
        return $result['leave_days'];
	}
	
	function getLeaveAdminTrashPaidData($params, $table){
        $this->db->select_sum('leave_paid');
        $this->db->from($table);
        $this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_leave_admin_trash'])){
            $searchLeaveAdminTrash = $params['search_leave_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchLeaveAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchLeaveAdminTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchLeaveAdminTrash, 
                'leave_days' => $searchLeaveAdminTrash,
                'leave_reason' => $searchLeaveAdminTrash,
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_admin_trash_type'])){  
            $searchLeaveAdminTrashType = $params['search_leave_admin_trash_type'];
            $this->db->where(HRM_LEAVE_TABLE . '.leave_type', $searchLeaveAdminTrashType);
        }
        if(!empty($params['search_leave_admin_trash_leave'])){  
            $searchLeaveAdminTrashLeave = $params['search_leave_admin_trash_leave'];
            $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $searchLeaveAdminTrashLeave);
        }
        if(!empty($params['search_leave_admin_trash_status'])){  
            $searchLeaveAdminTrashStatus = $params['search_leave_admin_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchLeaveAdminTrashStatus);
        }
        if(!empty($params['search_leave_admin_trash_from_start_date']) and !empty($params['search_leave_admin_trash_from_end_date'])){
            $searchLeaveAdminTrashFromStartDate = $params['search_leave_admin_trash_from_start_date'];
            $searchLeaveAdminTrashFromEndDate = $params['search_leave_admin_trash_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveAdminTrashFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveAdminTrashFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_admin_trash']) and empty($params['search_leave_admin_trash_type']) and empty($params['search_leave_admin_trash_leave']) and empty($params['search_leave_admin_trash_status']) and empty($params['search_leave_admin_trash_from_start_date']) and empty($params['search_leave_admin_trash_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'true');
		$query = $this->db->get();
        $result = $query->row_array();
        return $result['leave_paid'];
	}
	
	// Leave Employee Functions
	function viewLeaveEmployeeData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
        if(!empty($params['search_leave_employee'])){
            $searchLeaveEmployee = $params['search_leave_employee'];
            $likeArr = array(
                'leave_date' => $searchLeaveEmployee, 
                'leave_to_date' => $searchLeaveEmployee, 
                'leave_days' => $searchLeaveEmployee, 
                'leave_reason' => $searchLeaveEmployee, 
                'leave_rejection_reason' => $searchLeaveEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_employee_type'])){  
            $searchLeaveEmployeeType = $params['search_leave_employee_type'];
            $this->db->where('leave_type', $searchLeaveEmployeeType);
        }
        if(!empty($params['search_leave_employee_leave'])){  
            $searchLeaveEmployeeLeave = $params['search_leave_employee_leave'];
            $this->db->where('is_leave', $searchLeaveEmployeeLeave);
        }
        if(!empty($params['search_leave_employee_from_start_date']) and !empty($params['search_leave_employee_from_end_date'])){
            $searchLeaveEmployeeFromStartDate = $params['search_leave_employee_from_start_date'];
            $searchLeaveEmployeeFromEndDate = $params['search_leave_employee_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveEmployeeFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveEmployeeFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_employee']) and empty($params['search_leave_employee_type']) and empty($params['search_leave_employee_leave']) and empty($params['search_leave_employee_from_start_date']) and empty($params['search_leave_employee_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_LEAVE_TABLE . '.user_id', $this->session->userdata['user_id']);
        if(array_key_exists("leave_id",$params)){
            $this->db->where('leave_id',$params['leave_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countLeaveEmployeeData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
        if(!empty($params['search_leave_employee'])){
            $searchLeaveEmployee = $params['search_leave_employee'];
            $likeArr = array(
                'leave_date' => $searchLeaveEmployee, 
                'leave_to_date' => $searchLeaveEmployee, 
                'leave_days' => $searchLeaveEmployee, 
                'leave_reason' => $searchLeaveEmployee, 
                'leave_rejection_reason' => $searchLeaveEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_employee_type'])){  
            $searchLeaveEmployeeType = $params['search_leave_employee_type'];
            $this->db->where('leave_type', $searchLeaveEmployeeType);
        }
        if(!empty($params['search_leave_employee_leave'])){  
            $searchLeaveEmployeeLeave = $params['search_leave_employee_leave'];
            $this->db->where('is_leave', $searchLeaveEmployeeLeave);
        }
        if(!empty($params['search_leave_employee_from_start_date']) and !empty($params['search_leave_employee_from_end_date'])){
            $searchLeaveEmployeeFromStartDate = $params['search_leave_employee_from_start_date'];
            $searchLeaveEmployeeFromEndDate = $params['search_leave_employee_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveEmployeeFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveEmployeeFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_employee']) and empty($params['search_leave_employee_type']) and empty($params['search_leave_employee_leave']) and empty($params['search_leave_employee_from_start_date']) and empty($params['search_leave_employee_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_LEAVE_TABLE . '.user_id', $this->session->userdata['user_id']);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function getLeaveEmployeeDaysData($params, $where, $table){
        $this->db->select_sum('leave_days');
        $this->db->from($table);
        $this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
        if(!empty($params['search_leave_employee'])){
            $searchLeaveEmployee = $params['search_leave_employee'];
            $likeArr = array(
                'leave_date' => $searchLeaveEmployee, 
                'leave_to_date' => $searchLeaveEmployee, 
                'leave_days' => $searchLeaveEmployee, 
                'leave_reason' => $searchLeaveEmployee, 
                'leave_rejection_reason' => $searchLeaveEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_employee_type'])){  
            $searchLeaveEmployeeType = $params['search_leave_employee_type'];
            $this->db->where('leave_type', $searchLeaveEmployeeType);
        }
        if(!empty($params['search_leave_employee_leave'])){  
            $searchLeaveEmployeeLeave = $params['search_leave_employee_leave'];
            $this->db->where('is_leave', $searchLeaveEmployeeLeave);
        }
        if(!empty($params['search_leave_employee_from_start_date']) and !empty($params['search_leave_employee_from_end_date'])){
            $searchLeaveEmployeeFromStartDate = $params['search_leave_employee_from_start_date'];
            $searchLeaveEmployeeFromEndDate = $params['search_leave_employee_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveEmployeeFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveEmployeeFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_employee']) and empty($params['search_leave_employee_type']) and empty($params['search_leave_employee_leave']) and empty($params['search_leave_employee_from_start_date']) and empty($params['search_leave_employee_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_LEAVE_TABLE . '.user_id', $this->session->userdata['user_id']);
        if($where){ $this->db->where(HRM_LEAVE_TABLE . '.is_leave', $where); }
		$query = $this->db->get();
        $result = $query->row_array();
        return $result['leave_days'];
	}
	
	function getLeaveEmployeePaidData($params, $table){
        $this->db->select_sum('leave_paid');
        $this->db->from($table);
        $this->db->order_by('leave_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_LEAVE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
        if(!empty($params['search_leave_employee'])){
            $searchLeaveEmployee = $params['search_leave_employee'];
            $likeArr = array(
                'leave_date' => $searchLeaveEmployee, 
                'leave_to_date' => $searchLeaveEmployee, 
                'leave_days' => $searchLeaveEmployee, 
                'leave_reason' => $searchLeaveEmployee, 
                'leave_rejection_reason' => $searchLeaveEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_leave_employee_type'])){  
            $searchLeaveEmployeeType = $params['search_leave_employee_type'];
            $this->db->where('leave_type', $searchLeaveEmployeeType);
        }
        if(!empty($params['search_leave_employee_leave'])){  
            $searchLeaveEmployeeLeave = $params['search_leave_employee_leave'];
            $this->db->where('is_leave', $searchLeaveEmployeeLeave);
        }
        if(!empty($params['search_leave_employee_from_start_date']) and !empty($params['search_leave_employee_from_end_date'])){
            $searchLeaveEmployeeFromStartDate = $params['search_leave_employee_from_start_date'];
            $searchLeaveEmployeeFromEndDate = $params['search_leave_employee_from_end_date'];
            $this->db->where("STR_TO_DATE(leave_from_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchLeaveEmployeeFromStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(leave_to_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchLeaveEmployeeFromEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_leave_employee']) and empty($params['search_leave_employee_type']) and empty($params['search_leave_employee_leave']) and empty($params['search_leave_employee_from_start_date']) and empty($params['search_leave_employee_from_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_LEAVE_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_LEAVE_TABLE . '.user_id', $this->session->userdata['user_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['leave_paid'];
	}
	
	function getLeaveEmployeeDashboardDaysData($where, $table){
		$this->db->select_sum('leave_days');
		$this->db->from($table);
		if($where){ $this->db->where($where); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result['leave_days'];
	}
	
	function getLeaveEmployeeDashboardPaidData($where, $table){
		$this->db->select_sum('leave_paid');
		$this->db->from($table);
		if($where){ $this->db->where($where); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result['leave_paid'];
	}
	
	// Holiday Functions
	function viewHolidayData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('holiday_id','DESC');
		if(!empty($params['search_holiday'])){
            $searchHoliday = $params['search_holiday'];
            $likeArr = array(
                'holiday_name' => $searchHoliday,
                'holiday_date' => $searchHoliday,
                'holiday_day' => $searchHoliday
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_holiday_type'])){  
            $searchHolidayType = $params['search_holiday_type'];
            $this->db->where('holiday_type', $searchHolidayType);
        }
        if(!empty($params['search_holiday_start_date']) and !empty($params['search_holiday_end_date'])){
            $searchHolidayStartDate = $params['search_holiday_start_date'];
            $searchHolidayEndDate = $params['search_holiday_end_date'];
            $this->db->where("STR_TO_DATE(holiday_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchHolidayStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(holiday_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchHolidayEndDate', '%d/%m/%Y')", FALSE);
        }
        $this->db->where('trash_status', 'false');
        if(array_key_exists("holiday_id",$params)){
            $this->db->where('holiday_id',$params['holiday_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countHolidayData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('holiday_id','DESC');
		if(!empty($params['search_holiday'])){
            $searchHoliday = $params['search_holiday'];
            $likeArr = array(
                'holiday_name' => $searchHoliday,
                'holiday_date' => $searchHoliday,
                'holiday_day' => $searchHoliday
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_holiday_type'])){  
            $searchHolidayType = $params['search_holiday_type'];
            $this->db->where('holiday_type', $searchHolidayType);
        }
        if(!empty($params['search_holiday_start_date']) and !empty($params['search_holiday_end_date'])){
            $searchHolidayStartDate = $params['search_holiday_start_date'];
            $searchHolidayEndDate = $params['search_holiday_end_date'];
            $this->db->where("STR_TO_DATE(holiday_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchHolidayStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(holiday_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchHolidayEndDate', '%d/%m/%Y')", FALSE);
        }
        $this->db->where('trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewHolidayTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('holiday_id','DESC');
		if(!empty($params['search_holiday_trash'])){
            $searchHolidayTrash = $params['search_holiday_trash'];
            $likeArr = array(
                'holiday_name' => $searchHolidayTrash,
                'holiday_date' => $searchHolidayTrash,
                'holiday_day' => $searchHolidayTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_holiday_trash_type'])){  
            $searchHolidayTrashType = $params['search_holiday_trash_type'];
            $this->db->where('holiday_type', $searchHolidayTrashType);
        }
        if(!empty($params['search_holiday_trash_start_date']) and !empty($params['search_holiday_trash_end_date'])){
            $searchHolidayTrashStartDate = $params['search_holiday_trash_start_date'];
            $searchHolidayTrashEndDate = $params['search_holiday_trash_end_date'];
            $this->db->where("STR_TO_DATE(holiday_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchHolidayTrashStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(holiday_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchHolidayTrashEndDate', '%d/%m/%Y')", FALSE);
        }
        $this->db->where('trash_status', 'true');
        if(array_key_exists("holiday_id",$params)){
            $this->db->where('holiday_id',$params['holiday_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countHolidayTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('holiday_id','DESC');
		if(!empty($params['search_holiday_trash'])){
            $searchHolidayTrash = $params['search_holiday_trash'];
            $likeArr = array(
                'holiday_name' => $searchHolidayTrash,
                'holiday_date' => $searchHolidayTrash,
                'holiday_day' => $searchHolidayTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_holiday_trash_type'])){  
            $searchHolidayTrashType = $params['search_holiday_trash_type'];
            $this->db->where('holiday_type', $searchHolidayTrashType);
        }
        if(!empty($params['search_holiday_trash_start_date']) and !empty($params['search_holiday_trash_end_date'])){
            $searchHolidayTrashStartDate = $params['search_holiday_trash_start_date'];
            $searchHolidayTrashEndDate = $params['search_holiday_trash_end_date'];
            $this->db->where("STR_TO_DATE(holiday_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchHolidayTrashStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(holiday_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchHolidayTrashEndDate', '%d/%m/%Y')", FALSE);
        }
        $this->db->where('trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewUpcomingHolidayData($table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->where('holiday_type','upcoming'); 
		$this->db->limit('5'); 
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	// Reporting Admin Functions
	function viewReportingAdminData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('reporting_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_REPORTING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_reporting_admin'])){
            $searchReportingAdmin = $params['search_reporting_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchReportingAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchReportingAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchReportingAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchReportingAdmin, 
                DEPARTMENT_TABLE . '.department_name' => $searchReportingAdmin, 
                'reporting_project_name' => $searchReportingAdmin,
                'reporting_task' => $searchReportingAdmin,
                'reporting_progress' => $searchReportingAdmin
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_reporting_admin_type'])){  
            $searchReportingAdminType = $params['search_reporting_admin_type'];
            $this->db->where(HRM_REPORTING_TABLE . '.reporting_type', $searchReportingAdminType);
        }
        if(!empty($params['search_reporting_admin_status'])){  
            $searchReportingAdminStatus = $params['search_reporting_admin_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchReportingAdminStatus);
        }
        if(!empty($params['search_reporting_admin_reporting_start_date']) and !empty($params['search_reporting_admin_reporting_end_date'])){
            $searchReportingAdminReportingStartDate = $params['search_reporting_admin_reporting_start_date'];
            $searchReportingAdminReportingEndDate = $params['search_reporting_admin_reporting_end_date'];
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchReportingAdminReportingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchReportingAdminReportingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_reporting_admin']) and empty($params['search_reporting_admin_type']) and empty($params['search_reporting_admin_reporting_start_date']) and empty($params['search_reporting_admin_reporting_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_REPORTING_TABLE . '.trash_status', 'false');
        if(array_key_exists("reporting_id",$params)){
            $this->db->where('reporting_id',$params['reporting_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
    function countReportingAdminData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('reporting_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_REPORTING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_reporting_admin'])){
            $searchReportingAdmin = $params['search_reporting_admin'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchReportingAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchReportingAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchReportingAdmin, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchReportingAdmin, 
                DEPARTMENT_TABLE . '.department_name' => $searchReportingAdmin, 
                'reporting_project_name' => $searchReportingAdmin,
                'reporting_task' => $searchReportingAdmin,
                'reporting_progress' => $searchReportingAdmin
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_reporting_admin_type'])){  
            $searchReportingAdminType = $params['search_reporting_admin_type'];
            $this->db->where(HRM_REPORTING_TABLE . '.reporting_type', $searchReportingAdminType);
        }
        if(!empty($params['search_reporting_admin_status'])){  
            $searchReportingAdminStatus = $params['search_reporting_admin_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchReportingAdminStatus);
        }
        if(!empty($params['search_reporting_admin_reporting_start_date']) and !empty($params['search_reporting_admin_reporting_end_date'])){
            $searchReportingAdminReportingStartDate = $params['search_reporting_admin_reporting_start_date'];
            $searchReportingAdminReportingEndDate = $params['search_reporting_admin_reporting_end_date'];
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchReportingAdminReportingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchReportingAdminReportingEndDate', '%d/%m/%Y')", FALSE); 
        }
        if(empty($params['search_reporting_admin']) and empty($params['search_reporting_admin_type']) and empty($params['search_reporting_admin_reporting_start_date']) and empty($params['search_reporting_admin_reporting_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_REPORTING_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewReportingAdminTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('reporting_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_REPORTING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_reporting_admin_trash'])){
            $searchReportingAdminTrash = $params['search_reporting_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchReportingAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchReportingAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchReportingAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchReportingAdminTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchReportingAdminTrash, 
                'reporting_project_name' => $searchReportingAdminTrash,
                'reporting_task' => $searchReportingAdminTrash,
                'reporting_progress' => $searchReportingAdminTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_reporting_admin_trash_type'])){  
            $searchReportingAdminTrashType = $params['search_reporting_admin_trash_type'];
            $this->db->where(HRM_REPORTING_TABLE . '.reporting_type', $searchReportingAdminTrashType);
        }
        if(!empty($params['search_reporting_admin_trash_status'])){  
            $searchReportingAdminTrashStatus = $params['search_reporting_admin_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchReportingAdminTrashStatus);
        }
        if(!empty($params['search_reporting_admin_trash_reporting_start_date']) and !empty($params['search_reporting_admin_trash_reporting_end_date'])){
            $searchReportingAdminTrashReportingStartDate = $params['search_reporting_admin_trash_reporting_start_date'];
            $searchReportingAdminTrashReportingEndDate = $params['search_reporting_admin_trash_reporting_end_date'];
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchReportingAdminTrashReportingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchReportingAdminTrashReportingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_reporting_admin_trash']) and empty($params['search_reporting_admin_trash_type']) and empty($params['search_reporting_admin_trash_reporting_start_date']) and empty($params['search_reporting_admin_trash_reporting_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_REPORTING_TABLE . '.trash_status', 'true');
        if(array_key_exists("reporting_id",$params)){
            $this->db->where('reporting_id',$params['reporting_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countReportingAdminTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('reporting_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_REPORTING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_reporting_admin_trash'])){
            $searchReportingAdminTrash = $params['search_reporting_admin_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchReportingAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchReportingAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchReportingAdminTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchReportingAdminTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchReportingAdminTrash, 
                'reporting_project_name' => $searchReportingAdminTrash,
                'reporting_task' => $searchReportingAdminTrash,
                'reporting_progress' => $searchReportingAdminTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_reporting_admin_trash_type'])){  
            $searchReportingAdminTrashType = $params['search_reporting_admin_trash_type'];
            $this->db->where(HRM_REPORTING_TABLE . '.reporting_type', $searchReportingAdminTrashType);
        }
        if(!empty($params['search_reporting_admin_trash_status'])){  
            $searchReportingAdminTrashStatus = $params['search_reporting_admin_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchReportingAdminTrashStatus);
        }
        if(!empty($params['search_reporting_admin_trash_reporting_start_date']) and !empty($params['search_reporting_admin_trash_reporting_end_date'])){
            $searchReportingAdminTrashReportingStartDate = $params['search_reporting_admin_trash_reporting_start_date'];
            $searchReportingAdminTrashReportingEndDate = $params['search_reporting_admin_trash_reporting_end_date'];
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchReportingAdminTrashReportingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchReportingAdminTrashReportingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_reporting_admin_trash']) and empty($params['search_reporting_admin_trash_type']) and empty($params['search_reporting_admin_trash_reporting_start_date']) and empty($params['search_reporting_admin_trash_reporting_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_REPORTING_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Reporting Employee Functions
	function viewReportingEmployeeData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('reporting_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_REPORTING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
        if(!empty($params['search_reporting_employee'])){
            $searchReportingEmployee = $params['search_reporting_employee'];
            $likeArr = array(
                'reporting_project_name' => $searchReportingEmployee, 
                'reporting_task' => $searchReportingEmployee, 
                'reporting_progress' => $searchReportingEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_reporting_employee_type'])){  
            $searchReportingEmployeeType = $params['search_reporting_employee_type'];
            $this->db->where('reporting_type', $searchReportingEmployeeType);
        }
        if(!empty($params['search_reporting_employee_reporting_start_date']) and !empty($params['search_reporting_employee_reporting_end_date'])){
            $searchReportingEmployeeReportingStartDate = $params['search_reporting_employee_reporting_start_date'];
            $searchReportingEmployeeReportingEndDate = $params['search_reporting_employee_reporting_end_date'];
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchReportingEmployeeReportingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchReportingEmployeeReportingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_reporting_employee']) and empty($params['search_reporting_employee_type']) and empty($params['search_reporting_employee_reporting_start_date']) and empty($params['search_reporting_employee_reporting_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_REPORTING_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_REPORTING_TABLE . '.user_id', $this->session->userdata['user_id']);
        if(array_key_exists("reporting_id",$params)){
            $this->db->where('reporting_id',$params['reporting_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countReportingEmployeeData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('reporting_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_REPORTING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
        if(!empty($params['search_reporting_employee'])){
            $searchReportingEmployee = $params['search_reporting_employee'];
            $likeArr = array(
                'reporting_project_name' => $searchReportingEmployee, 
                'reporting_task' => $searchReportingEmployee, 
                'reporting_progress' => $searchReportingEmployee
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_reporting_employee_type'])){  
            $searchReportingEmployeeType = $params['search_reporting_employee_type'];
            $this->db->where('reporting_type', $searchReportingEmployeeType);
        }
        if(!empty($params['search_reporting_employee_reporting_start_date']) and !empty($params['search_reporting_employee_reporting_end_date'])){
            $searchReportingEmployeeReportingStartDate = $params['search_reporting_employee_reporting_start_date'];
            $searchReportingEmployeeReportingEndDate = $params['search_reporting_employee_reporting_end_date'];
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') >=", "STR_TO_DATE('$searchReportingEmployeeReportingStartDate', '%d/%m/%Y')", FALSE);
            $this->db->where("STR_TO_DATE(reporting_date, '%d/%m/%Y') <=", "STR_TO_DATE('$searchReportingEmployeeReportingEndDate', '%d/%m/%Y')", FALSE);
        }
        if(empty($params['search_reporting_employee']) and empty($params['search_reporting_employee_type']) and empty($params['search_reporting_employee_reporting_start_date']) and empty($params['search_reporting_employee_reporting_end_date'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_REPORTING_TABLE . '.trash_status', 'false');
        $this->db->where(HRM_REPORTING_TABLE . '.user_id', $this->session->userdata['user_id']);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Salary Functions
	function viewSalaryData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('salary_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SALARY_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_salary'])){
            $searchSalary = $params['search_salary'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchSalary, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchSalary, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchSalary, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchSalary, 
                DEPARTMENT_TABLE . '.department_name' => $searchSalary, 
                'employee_create_date' => $searchSalary
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_salary_email'])){  
            $searchSalaryEmail = $params['search_salary_email'];
            $this->db->where('is_email', $searchSalaryEmail);
        }
        if(!empty($params['search_salary_type'])){  
            $searchSalaryType = $params['search_salary_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchSalaryType);
        }
        if(!empty($params['search_salary_status'])){  
            $searchSalaryStatus = $params['search_salary_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchSalaryStatus);
        }
        if(empty($params['search_salary']) and empty($params['search_salary_email']) and empty($params['search_salary_type']) and empty($params['search_salary_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SALARY_TABLE . '.trash_status', 'false');
        if(array_key_exists("salary_id",$params)){
            $this->db->where('salary_id',$params['salary_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countSalaryData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('salary_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SALARY_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_salary'])){
            $searchSalary = $params['search_salary'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchSalary, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchSalary, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchSalary, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchSalary, 
                DEPARTMENT_TABLE . '.department_name' => $searchSalary, 
                'employee_create_date' => $searchSalary
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_salary_email'])){  
            $searchSalaryEmail = $params['search_salary_email'];
            $this->db->where('is_email', $searchSalaryEmail);
        }
        if(!empty($params['search_salary_type'])){  
            $searchSalaryType = $params['search_salary_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchSalaryType);
        }
        if(!empty($params['search_salary_status'])){  
            $searchSalaryStatus = $params['search_salary_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchSalaryStatus);
        }
        if(empty($params['search_salary']) and empty($params['search_salary_email']) and empty($params['search_salary_type']) and empty($params['search_salary_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SALARY_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewSalaryTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('salary_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SALARY_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_salary_trash'])){
            $searchSalaryTrash = $params['search_salary_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchSalaryTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchSalaryTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchSalaryTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchSalaryTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchSalaryTrash, 
                'employee_create_date' => $searchSalaryTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_salary_trash_email'])){  
            $searchSalaryTrashEmail = $params['search_salary_trash_email'];
            $this->db->where('is_email', $searchSalaryTrashEmail);
        }
        if(!empty($params['search_salary_trash_type'])){  
            $searchSalaryTrashType = $params['search_salary_trash_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchSalaryTrashType);
        }
        if(!empty($params['search_salary_trash_status'])){  
            $searchSalaryTrashStatus = $params['search_salary_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchSalaryTrashStatus);
        }
        if(empty($params['search_salary_trash']) and empty($params['search_salary_trash_email']) and empty($params['search_salary_trash_type']) and empty($params['search_salary_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SALARY_TABLE . '.trash_status', 'true');
        if(array_key_exists("salary_id",$params)){
            $this->db->where('salary_id',$params['salary_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countSalaryTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('salary_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SALARY_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_salary_trash'])){
            $searchSalaryTrash = $params['search_salary_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchSalaryTrash,
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchSalaryTrash,
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchSalaryTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchSalaryTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchSalaryTrash, 
                'employee_create_date' => $searchSalaryTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_salary_trash_email'])){  
            $searchSalaryTrashEmail = $params['search_salary_trash_email'];
            $this->db->where('is_email', $searchSalaryTrashEmail);
        }
        if(!empty($params['search_salary_trash_type'])){  
            $searchSalaryTrashType = $params['search_salary_trash_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchSalaryTrashType);
        }
        if(!empty($params['search_salary_trash_status'])){  
            $searchSalaryTrashStatus = $params['search_salary_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchSalaryTrashStatus);
        }
        if(empty($params['search_salary_trash']) and empty($params['search_salary_trash_email']) and empty($params['search_salary_trash_type']) and empty($params['search_salary_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SALARY_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// System Functions
	function viewSystemData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('system_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SYSTEM_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_system'])){
            $searchSystem = $params['search_system'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchSystem, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchSystem, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchSystem, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchSystem, 
                DEPARTMENT_TABLE . '.department_name' => $searchSystem, 
                'system_name' => $searchSystem,
                'system_password' => $searchSystem
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_system_status'])){  
            $searchSystemStatus = $params['search_system_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchSystemStatus);
        }
        if(empty($params['search_system']) and empty($params['search_system_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SYSTEM_TABLE . '.trash_status', 'false');
        if(array_key_exists("system_id",$params)){
            $this->db->where('system_id',$params['system_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countSystemData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('system_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SYSTEM_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_system'])){
            $searchSystem = $params['search_system'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchSystem, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchSystem, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchSystem, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchSystem, 
                DEPARTMENT_TABLE . '.department_name' => $searchSystem, 
                'system_name' => $searchSystem,
                'system_password' => $searchSystem
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_system_status'])){  
            $searchSystemStatus = $params['search_system_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchSystemStatus);
        }
        if(empty($params['search_system']) and empty($params['search_system_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SYSTEM_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewSystemTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('system_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SYSTEM_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_system_trash'])){
            $searchSystemTrash = $params['search_system_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchSystemTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchSystemTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchSystemTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchSystemTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchSystemTrash, 
                'system_name' => $searchSystemTrash,
                'system_password' => $searchSystemTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_system_trash_status'])){  
            $searchSystemTrashStatus = $params['search_system_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchSystemTrashStatus);
        }
        if(empty($params['search_system_trash']) and empty($params['search_system_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SYSTEM_TABLE . '.trash_status', 'true');
        if(array_key_exists("system_id",$params)){
            $this->db->where('system_id',$params['system_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countSystemTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('system_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SYSTEM_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_system_trash'])){
            $searchSystemTrash = $params['search_system_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchSystemTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchSystemTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchSystemTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchSystemTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchSystemTrash, 
                'system_name' => $searchSystemTrash,
                'system_password' => $searchSystemTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_system_trash_status'])){  
            $searchSystemTrashStatus = $params['search_system_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchSystemTrashStatus);
        }
        if(empty($params['search_system_trash']) and empty($params['search_system_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SYSTEM_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Device Functions
	function viewDeviceData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('device_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_DEVICE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_device'])){
            $searchDevice = $params['search_device'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchDevice, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchDevice, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchDevice, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchDevice, 
                DEPARTMENT_TABLE . '.department_name' => $searchDevice, 
                'device_name' => $searchDevice,
                'device_accessory' => $searchDevice
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_device_status'])){  
            $searchDeviceStatus = $params['search_device_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchDeviceStatus);
        }
        if(empty($params['search_device']) and empty($params['search_device_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_DEVICE_TABLE . '.trash_status', 'false');
        if(array_key_exists("device_id",$params)){
            $this->db->where('device_id',$params['device_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countDeviceData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('device_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_DEVICE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_device'])){
            $searchDevice = $params['search_device'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchDevice, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchDevice, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchDevice, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchDevice, 
                DEPARTMENT_TABLE . '.department_name' => $searchDevice, 
                'device_name' => $searchDevice,
                'device_accessory' => $searchDevice
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_device_status'])){  
            $searchDeviceStatus = $params['search_device_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchDeviceStatus);
        }
        if(empty($params['search_device']) and empty($params['search_device_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_DEVICE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewDeviceTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('device_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_DEVICE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_device_trash'])){
            $searchDeviceTrash = $params['search_device_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchDeviceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchDeviceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchDeviceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchDeviceTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchDeviceTrash, 
                'device_name' => $searchDeviceTrash,
                'device_accessory' => $searchDeviceTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_device_trash_status'])){  
            $searchDeviceTrashStatus = $params['search_device_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchDeviceTrashStatus);
        }
        if(empty($params['search_device_trash']) and empty($params['search_device_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_DEVICE_TABLE . '.trash_status', 'true');
        if(array_key_exists("device_id",$params)){
            $this->db->where('device_id',$params['device_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countDeviceTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('device_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_DEVICE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_device_trash'])){
            $searchDeviceTrash = $params['search_device_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchDeviceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchDeviceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchDeviceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchDeviceTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchDeviceTrash, 
                'device_name' => $searchDeviceTrash,
                'device_accessory' => $searchDeviceTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_device_trash_status'])){  
            $searchDeviceTrashStatus = $params['search_device_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchDeviceTrashStatus);
        }
        if(empty($params['search_device_trash']) and empty($params['search_device_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_DEVICE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Gmail Functions
	function viewGmailData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('gmail_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_GMAIL_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_gmail'])){
            $searchGmail = $params['search_gmail'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchGmail, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchGmail, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchGmail, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchGmail, 
                DEPARTMENT_TABLE . '.department_name' => $searchGmail, 
                'gmail_mail_id' => $searchGmail,
                'gmail_password' => $searchGmail,
                'figma_password' => $searchGmail
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_gmail_status'])){  
            $searchGmailStatus = $params['search_gmail_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchGmailStatus);
        }
        if(empty($params['search_gmail']) and empty($params['search_gmail_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_GMAIL_TABLE . '.trash_status', 'false');
        if(array_key_exists("gmail_id",$params)){
            $this->db->where('gmail_id',$params['gmail_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countGmailData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('gmail_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_GMAIL_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_gmail'])){
            $searchGmail = $params['search_gmail'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchGmail, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchGmail, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchGmail, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchGmail, 
                DEPARTMENT_TABLE . '.department_name' => $searchGmail, 
                'gmail_mail_id' => $searchGmail,
                'gmail_password' => $searchGmail,
                'figma_password' => $searchGmail
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_gmail_status'])){  
            $searchGmailStatus = $params['search_gmail_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchGmailStatus);
        }
        if(empty($params['search_gmail']) and empty($params['search_gmail_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_GMAIL_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewGmailTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('gmail_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_GMAIL_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_gmail_trash'])){
            $searchGmailTrash = $params['search_gmail_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchGmailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchGmailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchGmailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchGmailTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchGmailTrash, 
                'gmail_mail_id' => $searchGmailTrash,
                'gmail_password' => $searchGmailTrash,
                'figma_password' => $searchGmailTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_gmail_trash_status'])){  
            $searchGmailTrashStatus = $params['search_gmail_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchGmailTrashStatus);
        }
        if(empty($params['search_gmail_trash']) and empty($params['search_gmail_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_GMAIL_TABLE . '.trash_status', 'true');
        if(array_key_exists("gmail_id",$params)){
            $this->db->where('gmail_id',$params['gmail_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countGmailTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('gmail_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_GMAIL_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_gmail_trash'])){
            $searchGmailTrash = $params['search_gmail_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchGmailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchGmailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchGmailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchGmailTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchGmailTrash, 
                'gmail_mail_id' => $searchGmailTrash,
                'gmail_password' => $searchGmailTrash,
                'figma_password' => $searchGmailTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_gmail_trash_status'])){  
            $searchGmailTrashStatus = $params['search_gmail_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchGmailTrashStatus);
        }
        if(empty($params['search_gmail_trash']) and empty($params['search_gmail_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_GMAIL_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Intern Offer Functions
	function viewInternOfferData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('intern_offer_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_INTERN_OFFER_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_intern_offer'])){
            $searchInternOffer = $params['search_intern_offer'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchInternOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchInternOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchInternOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchInternOffer, 
                DEPARTMENT_TABLE . '.department_name' => $searchInternOffer, 
                'employee_create_date' => $searchInternOffer
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_intern_offer_email'])){  
            $searchInternOfferEmail = $params['search_intern_offer_email'];
            $this->db->where('is_email', $searchInternOfferEmail);
        }
        if(!empty($params['search_intern_offer_status'])){  
            $searchInternOfferStatus = $params['search_intern_offer_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchInternOfferStatus);
        }
        if(empty($params['search_intern_offer']) and empty($params['search_intern_offer_email']) and empty($params['search_intern_offer_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_INTERN_OFFER_TABLE . '.trash_status', 'false');
        if(array_key_exists("intern_offer_id",$params)){
            $this->db->where('intern_offer_id',$params['intern_offer_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countInternOfferData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('intern_offer_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_INTERN_OFFER_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_intern_offer'])){
            $searchInternOffer = $params['search_intern_offer'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchInternOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchInternOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchInternOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchInternOffer, 
                DEPARTMENT_TABLE . '.department_name' => $searchInternOffer, 
                'employee_create_date' => $searchInternOffer
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_intern_offer_email'])){  
            $searchInternOfferEmail = $params['search_intern_offer_email'];
            $this->db->where('is_email', $searchInternOfferEmail);
        }
        if(!empty($params['search_intern_offer_status'])){  
            $searchInternOfferStatus = $params['search_intern_offer_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchInternOfferStatus);
        }
        if(empty($params['search_intern_offer']) and empty($params['search_intern_offer_email']) and empty($params['search_intern_offer_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_INTERN_OFFER_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewInternOfferTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('intern_offer_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_INTERN_OFFER_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_intern_offer_trash'])){
            $searchInternOfferTrash = $params['search_intern_offer_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchInternOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchInternOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchInternOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchInternOfferTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchInternOfferTrash, 
                'employee_create_date' => $searchInternOfferTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_intern_offer_trash_status'])){  
            $searchInternOfferTrashStatus = $params['search_intern_offer_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchInternOfferTrashStatus);
        }
        if(empty($params['search_intern_offer_trash']) and empty($params['search_intern_offer_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_INTERN_OFFER_TABLE . '.trash_status', 'true');
        if(array_key_exists("intern_offer_id",$params)){
            $this->db->where('intern_offer_id',$params['intern_offer_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countInternOfferTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('intern_offer_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_INTERN_OFFER_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_intern_offer_trash'])){
            $searchInternOfferTrash = $params['search_intern_offer_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchInternOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchInternOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchInternOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchInternOfferTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchInternOfferTrash, 
                'employee_create_date' => $searchInternOfferTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_intern_offer_trash_status'])){  
            $searchInternOfferTrashStatus = $params['search_intern_offer_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchInternOfferTrashStatus);
        }
        if(empty($params['search_intern_offer_trash']) and empty($params['search_intern_offer_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_INTERN_OFFER_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Internship Certificate Functions
	function viewInternshipCertificateData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('internship_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_INTERNSHIP_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_internship_certificate'])){
            $searchInternshipCertificate = $params['search_internship_certificate'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchInternshipCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchInternshipCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchInternshipCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchInternshipCertificate, 
                DEPARTMENT_TABLE . '.department_name' => $searchInternshipCertificate, 
                'employee_create_date' => $searchInternshipCertificate
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_internship_certificate_status'])){  
            $searchInternshipCertificateStatus = $params['search_internship_certificate_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchInternshipCertificateStatus);
        }
        if(empty($params['search_internship_certificate']) and empty($params['search_internship_certificate_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_INTERNSHIP_CERTIFICATE_TABLE . '.trash_status', 'false');
        if(array_key_exists("internship_certificate_id",$params)){
            $this->db->where('internship_certificate_id',$params['internship_certificate_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countInternshipCertificateData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('internship_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_INTERNSHIP_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_internship_certificate'])){
            $searchInternshipCertificate = $params['search_internship_certificate'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchInternshipCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchInternshipCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchInternshipCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchInternshipCertificate, 
                DEPARTMENT_TABLE . '.department_name' => $searchInternshipCertificate, 
                'employee_create_date' => $searchInternshipCertificate
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_internship_certificate_status'])){  
            $searchInternshipCertificateStatus = $params['search_internship_certificate_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchInternshipCertificateStatus);
        }
        if(empty($params['search_internship_certificate']) and empty($params['search_internship_certificate_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_INTERNSHIP_CERTIFICATE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewInternshipCertificateTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('internship_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_INTERNSHIP_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_internship_certificate_trash'])){
            $searchInternshipCertificateTrash = $params['search_internship_certificate_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchInternshipCertificateTrash,
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchInternshipCertificateTrash,
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchInternshipCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchInternshipCertificateTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchInternshipCertificateTrash, 
                'employee_create_date' => $searchInternshipCertificateTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_internship_certificate_trash_status'])){  
            $searchInternshipCertificateTrashStatus = $params['search_internship_certificate_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchInternshipCertificateTrashStatus);
        }
        if(empty($params['search_internship_certificate_trash']) and empty($params['search_internship_certificate_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_INTERNSHIP_CERTIFICATE_TABLE . '.trash_status', 'true');
        if(array_key_exists("internship_certificate_id",$params)){
            $this->db->where('internship_certificate_id',$params['internship_certificate_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countInternshipCertificateTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('internship_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_INTERNSHIP_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
	    if(!empty($params['search_internship_certificate_trash'])){
            $searchInternshipCertificateTrash = $params['search_internship_certificate_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchInternshipCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchInternshipCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchInternshipCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchInternshipCertificateTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchInternshipCertificateTrash, 
                'employee_create_date' => $searchInternshipCertificateTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_internship_certificate_trash_status'])){  
            $searchInternshipCertificateTrashStatus = $params['search_internship_certificate_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchInternshipCertificateTrashStatus);
        }
        if(empty($params['search_internship_certificate_trash']) and empty($params['search_internship_certificate_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_INTERNSHIP_CERTIFICATE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Employee Offer Functions
	function viewEmployeeOfferData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('employee_offer_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_EMPLOYEE_OFFER_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_employee_offer'])){
            $searchEmployeeOffer = $params['search_employee_offer'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchEmployeeOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchEmployeeOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchEmployeeOffer,
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchEmployeeOffer, 
                DEPARTMENT_TABLE . '.department_name' => $searchEmployeeOffer, 
                'employee_create_date' => $searchEmployeeOffer
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_employee_offer_email'])){  
            $searchEmployeeOfferEmail = $params['search_employee_offer_email'];
            $this->db->where('is_email', $searchEmployeeOfferEmail);
        }
        if(!empty($params['search_employee_offer_status'])){  
            $searchEmployeeOfferStatus = $params['search_employee_offer_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchEmployeeOfferStatus);
        }
        if(empty($params['search_employee_offer']) and empty($params['search_employee_offer_email']) and empty($params['search_employee_offer_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EMPLOYEE_OFFER_TABLE . '.trash_status', 'false');
        if(array_key_exists("employee_offer_id",$params)){
            $this->db->where('employee_offer_id',$params['employee_offer_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countEmployeeOfferData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('employee_offer_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_EMPLOYEE_OFFER_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_employee_offer'])){
            $searchEmployeeOffer = $params['search_employee_offer'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchEmployeeOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchEmployeeOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchEmployeeOffer, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchEmployeeOffer, 
                DEPARTMENT_TABLE . '.department_name' => $searchEmployeeOffer, 
                'employee_create_date' => $searchEmployeeOffer
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_employee_offer_email'])){  
            $searchEmployeeOfferEmail = $params['search_employee_offer_email'];
            $this->db->where('is_email', $searchEmployeeOfferEmail);
        }
        if(!empty($params['search_employee_offer_status'])){  
            $searchEmployeeOfferStatus = $params['search_employee_offer_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchEmployeeOfferStatus);
        }
        if(empty($params['search_employee_offer']) and empty($params['search_employee_offer_email']) and empty($params['search_employee_offer_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EMPLOYEE_OFFER_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewEmployeeOfferTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('employee_offer_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_EMPLOYEE_OFFER_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_employee_offer_trash'])){
            $searchEmployeeOfferTrash = $params['search_employee_offer_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchEmployeeOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchEmployeeOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchEmployeeOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchEmployeeOfferTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchEmployeeOfferTrash, 
                'employee_create_date' => $searchEmployeeOfferTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_employee_offer_trash_status'])){  
            $searchEmployeeOfferTrashStatus = $params['search_employee_offer_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchEmployeeOfferTrashStatus);
        }
        if(empty($params['search_employee_offer_trash']) and empty($params['search_employee_offer_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EMPLOYEE_OFFER_TABLE . '.trash_status', 'true');
        if(array_key_exists("employee_offer_id",$params)){
            $this->db->where('employee_offer_id',$params['employee_offer_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countEmployeeOfferTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('employee_offer_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_EMPLOYEE_OFFER_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_employee_offer_trash'])){
            $searchEmployeeOfferTrash = $params['search_employee_offer_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchEmployeeOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchEmployeeOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchEmployeeOfferTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchEmployeeOfferTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchEmployeeOfferTrash, 
                'employee_create_date' => $searchEmployeeOfferTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_employee_offer_trash_status'])){  
            $searchEmployeeOfferTrashStatus = $params['search_employee_offer_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchEmployeeOfferTrashStatus);
        }
        if(empty($params['search_employee_offer_trash']) and empty($params['search_employee_offer_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EMPLOYEE_OFFER_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Appraisal Certificate Functions
	function viewAppraisalCertificateData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('appraisal_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_APPRAISAL_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_appraisal_certificate'])){
            $searchAppraisalCertificate = $params['search_appraisal_certificate'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAppraisalCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAppraisalCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAppraisalCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAppraisalCertificate, 
                DEPARTMENT_TABLE . '.department_name' => $searchAppraisalCertificate, 
                'employee_create_date' => $searchAppraisalCertificate
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_appraisal_certificate_email'])){  
            $searchAppraisalCertificateEmail = $params['search_appraisal_certificate_email'];
            $this->db->where('is_email', $searchAppraisalCertificateEmail);
        }
        if(!empty($params['search_appraisal_certificate_status'])){  
            $searchAppraisalCertificateStatus = $params['search_appraisal_certificate_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAppraisalCertificateStatus);
        }
        if(empty($params['search_appraisal_certificate']) and empty($params['search_appraisal_certificate_email']) and empty($params['search_appraisal_certificate_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_APPRAISAL_CERTIFICATE_TABLE . '.trash_status', 'false');
        if(array_key_exists("appraisal_certificate_id",$params)){
            $this->db->where('appraisal_certificate_id',$params['appraisal_certificate_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAppraisalCertificateData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('appraisal_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_APPRAISAL_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_appraisal_certificate'])){
            $searchAppraisalCertificate = $params['search_appraisal_certificate'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAppraisalCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAppraisalCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAppraisalCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAppraisalCertificate, 
                DEPARTMENT_TABLE . '.department_name' => $searchAppraisalCertificate, 
                'employee_create_date' => $searchAppraisalCertificate
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_appraisal_certificate_email'])){  
            $searchAppraisalCertificateEmail = $params['search_appraisal_certificate_email'];
            $this->db->where('is_email', $searchAppraisalCertificateEmail);
        }
        if(!empty($params['search_appraisal_certificate_status'])){  
            $searchAppraisalCertificateStatus = $params['search_appraisal_certificate_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAppraisalCertificateStatus);
        }
        if(empty($params['search_appraisal_certificate']) and empty($params['search_appraisal_certificate_email']) and empty($params['search_appraisal_certificate_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_APPRAISAL_CERTIFICATE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewAppraisalCertificateTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('appraisal_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_APPRAISAL_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_appraisal_certificate_trash'])){
            $searchAppraisalCertificateTrash = $params['search_appraisal_certificate_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAppraisalCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAppraisalCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAppraisalCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAppraisalCertificateTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchAppraisalCertificateTrash, 
                'employee_create_date' => $searchAppraisalCertificateTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_appraisal_certificate_trash_status'])){  
            $searchAppraisalCertificateTrashStatus = $params['search_appraisal_certificate_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAppraisalCertificateTrashStatus);
        }
        if(empty($params['search_appraisal_certificate_trash']) and empty($params['search_appraisal_certificate_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_APPRAISAL_CERTIFICATE_TABLE . '.trash_status', 'true');
        if(array_key_exists("appraisal_certificate_id",$params)){
            $this->db->where('appraisal_certificate_id',$params['appraisal_certificate_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAppraisalCertificateTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('appraisal_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_APPRAISAL_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_appraisal_certificate_trash'])){
            $searchAppraisalCertificateTrash = $params['search_appraisal_certificate_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAppraisalCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAppraisalCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAppraisalCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAppraisalCertificateTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchAppraisalCertificateTrash, 
                'employee_create_date' => $searchAppraisalCertificateTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_appraisal_certificate_trash_status'])){  
            $searchAppraisalCertificateTrashStatus = $params['search_appraisal_certificate_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAppraisalCertificateTrashStatus);
        }
        if(empty($params['search_appraisal_certificate_trash']) and empty($params['search_appraisal_certificate_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_APPRAISAL_CERTIFICATE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Warning Mail Functions
	function viewWarningMailData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('warning_mail_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_WARNING_MAIL_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_warning_mail'])){
            $searchWarningMail = $params['search_warning_mail'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchWarningMail,
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchWarningMail, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchWarningMail, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchWarningMail, 
                'employee_warning_reason' => $searchWarningMail, 
                'employee_create_date' => $searchWarningMail
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_warning_mail_email'])){  
            $searchWarningMailEmail = $params['search_warning_mail_email'];
            $this->db->where('is_email', $searchWarningMailEmail);
        }
        if(!empty($params['search_warning_mail_status'])){  
            $searchWarningMailStatus = $params['search_warning_mail_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchWarningMailStatus);
        }
        if(empty($params['search_warning_mail']) and empty($params['search_warning_mail_email']) and empty($params['search_warning_mail_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_WARNING_MAIL_TABLE . '.trash_status', 'false');
        if(array_key_exists("warning_mail_id",$params)){
            $this->db->where('warning_mail_id',$params['warning_mail_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countWarningMailData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('warning_mail_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_WARNING_MAIL_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_warning_mail'])){
            $searchWarningMail = $params['search_warning_mail'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchWarningMail, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchWarningMail, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchWarningMail, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchWarningMail, 
                'employee_warning_reason' => $searchWarningMail, 
                'employee_create_date' => $searchWarningMail
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_warning_mail_email'])){  
            $searchWarningMailEmail = $params['search_warning_mail_email'];
            $this->db->where('is_email', $searchWarningMailEmail);
        }
        if(!empty($params['search_warning_mail_status'])){  
            $searchWarningMailStatus = $params['search_warning_mail_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchWarningMailStatus);
        }
        if(empty($params['search_warning_mail']) and empty($params['search_warning_mail_email']) and empty($params['search_warning_mail_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_WARNING_MAIL_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewWarningMailTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('warning_mail_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_WARNING_MAIL_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_warning_mail_trash'])){
            $searchWarningMailTrash = $params['search_warning_mail_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchWarningMailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchWarningMailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchWarningMailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchWarningMailTrash, 
                'employee_warning_reason' => $searchWarningMailTrash, 
                'employee_create_date' => $searchWarningMailTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_warning_mail_trash_status'])){  
            $searchWarningMailTrashStatus = $params['search_warning_mail_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchWarningMailTrashStatus);
        }
        if(empty($params['search_warning_mail_trash']) and empty($params['search_warning_mail_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_WARNING_MAIL_TABLE . '.trash_status', 'true');
        if(array_key_exists("warning_mail_id",$params)){
            $this->db->where('warning_mail_id',$params['warning_mail_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countWarningMailTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('warning_mail_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_WARNING_MAIL_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_warning_mail_trash'])){
            $searchWarningMailTrash = $params['search_warning_mail_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchWarningMailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchWarningMailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchWarningMailTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchWarningMailTrash, 
                'employee_warning_reason' => $searchWarningMailTrash, 
                'employee_create_date' => $searchWarningMailTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_warning_mail_trash_status'])){  
            $searchWarningMailTrashStatus = $params['search_warning_mail_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchWarningMailTrashStatus);
        }
        if(empty($params['search_warning_mail_trash']) and empty($params['search_warning_mail_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_WARNING_MAIL_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Appointment Functions
	function viewAppointmentData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('appointment_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_APPOINTMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_appointment'])){
            $searchAppointment = $params['search_appointment'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAppointment, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAppointment, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAppointment, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAppointment, 
                DEPARTMENT_TABLE . '.department_name' => $searchAppointment, 
                'employee_create_date' => $searchAppointment
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_appointment_status'])){  
            $searchAppointmentStatus = $params['search_appointment_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAppointmentStatus);
        }
        if(empty($params['search_appointment']) and empty($params['search_appointment_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_APPOINTMENT_TABLE . '.trash_status', 'false');
        if(array_key_exists("appointment_id",$params)){
            $this->db->where('appointment_id',$params['appointment_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAppointmentData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('appointment_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_APPOINTMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_appointment'])){
            $searchAppointment = $params['search_appointment'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAppointment, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAppointment, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAppointment, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAppointment, 
                DEPARTMENT_TABLE . '.department_name' => $searchAppointment, 
                'employee_create_date' => $searchAppointment
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_appointment_status'])){  
            $searchAppointmentStatus = $params['search_appointment_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAppointmentStatus);
        }
        if(empty($params['search_appointment']) and empty($params['search_appointment_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_APPOINTMENT_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewAppointmentTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('appointment_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_APPOINTMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_appointment_trash'])){
            $searchAppointmentTrash = $params['search_appointment_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAppointmentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAppointmentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAppointmentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAppointmentTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchAppointmentTrash, 
                'employee_create_date' => $searchAppointmentTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_appointment_trash_status'])){  
            $searchAppointmentTrashStatus = $params['search_appointment_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAppointmentTrashStatus);
        }
        if(empty($params['search_appointment_trash']) and empty($params['search_appointment_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_APPOINTMENT_TABLE . '.trash_status', 'true');
        if(array_key_exists("appointment_id",$params)){
            $this->db->where('appointment_id',$params['appointment_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAppointmentTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('appointment_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_APPOINTMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_appointment_trash'])){
            $searchAppointmentTrash = $params['search_appointment_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchAppointmentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchAppointmentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchAppointmentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchAppointmentTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchAppointmentTrash, 
                'employee_create_date' => $searchAppointmentTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_appointment_trash_status'])){  
            $searchAppointmentTrashStatus = $params['search_appointment_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchAppointmentTrashStatus);
        }
        if(empty($params['search_appointment_trash']) and empty($params['search_appointment_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_APPOINTMENT_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Hr Policy Functions
	function viewHrPolicyData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('hr_policy_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_HR_POLICY_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_hr_policy'])){
            $searchHrPolicy = $params['search_hr_policy'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchHrPolicy, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchHrPolicy, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchHrPolicy, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchHrPolicy, 
                'employee_wef_date' => $searchHrPolicy
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_hr_policy_type'])){  
            $searchHrPolicyType = $params['search_hr_policy_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchHrPolicyType);
        }
        if(!empty($params['search_hr_policy_status'])){  
            $searchHrPolicyStatus = $params['search_hr_policy_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchHrPolicyStatus);
        }
        if(empty($params['search_hr_policy']) and empty($params['search_hr_policy_type']) and empty($params['search_hr_policy_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_HR_POLICY_TABLE . '.trash_status', 'false');
        if(array_key_exists("hr_policy_id",$params)){
            $this->db->where('hr_policy_id',$params['hr_policy_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countHrPolicyData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('hr_policy_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_HR_POLICY_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_hr_policy'])){
            $searchHrPolicy = $params['search_hr_policy'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchHrPolicy, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchHrPolicy, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchHrPolicy, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchHrPolicy, 
                'employee_wef_date' => $searchHrPolicy
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_hr_policy_type'])){  
            $searchHrPolicyType = $params['search_hr_policy_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchHrPolicyType);
        }
        if(!empty($params['search_hr_policy_status'])){  
            $searchHrPolicyStatus = $params['search_hr_policy_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchHrPolicyStatus);
        }
        if(empty($params['search_hr_policy']) and empty($params['search_hr_policy_type']) and empty($params['search_hr_policy_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_HR_POLICY_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewHrPolicyTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('hr_policy_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_HR_POLICY_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_hr_policy_trash'])){
            $searchHrPolicyTrash = $params['search_hr_policy_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchHrPolicyTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchHrPolicyTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchHrPolicyTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchHrPolicyTrash, 
                'employee_wef_date' => $searchHrPolicyTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_hr_policy_trash_type'])){  
            $searchHrPolicyTrashType = $params['search_hr_policy_trash_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchHrPolicyTrashType);
        }
        if(!empty($params['search_hr_policy_trash_status'])){  
            $searchHrPolicyTrashStatus = $params['search_hr_policy_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchHrPolicyTrashStatus);
        }
        if(empty($params['search_hr_policy_trash']) and empty($params['search_hr_policy_trash_type']) and empty($params['search_hr_policy_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_HR_POLICY_TABLE . '.trash_status', 'true');
        if(array_key_exists("hr_policy_id",$params)){
            $this->db->where('hr_policy_id',$params['hr_policy_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countHrPolicyTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('hr_policy_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_HR_POLICY_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_hr_policy_trash'])){
            $searchHrPolicyTrash = $params['search_hr_policy_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchHrPolicyTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchHrPolicyTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchHrPolicyTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchHrPolicyTrash, 
                'employee_wef_date' => $searchHrPolicyTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_hr_policy_trash_type'])){  
            $searchHrPolicyTrashType = $params['search_hr_policy_trash_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchHrPolicyTrashType);
        }
        if(!empty($params['search_hr_policy_trash_status'])){  
            $searchHrPolicyTrashStatus = $params['search_hr_policy_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchHrPolicyTrashStatus);
        }
        if(empty($params['search_hr_policy_trash']) and empty($params['search_hr_policy_trash_type']) and empty($params['search_hr_policy_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_HR_POLICY_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Declaration Functions
	function viewDeclarationData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('declaration_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_DECLARATION_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_declaration'])){
            $searchDeclaration = $params['search_declaration'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchDeclaration, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchDeclaration, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchDeclaration, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchDeclaration, 
                'employee_create_date' => $searchDeclaration
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_declaration_type'])){  
            $searchDeclarationType = $params['search_declaration_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchDeclarationType);
        }
        if(!empty($params['search_declaration_status'])){  
            $searchDeclarationStatus = $params['search_declaration_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchDeclarationStatus);
        }
        if(empty($params['search_declaration']) and empty($params['search_declaration_type']) and empty($params['search_declaration_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_DECLARATION_TABLE . '.trash_status', 'false');
        if(array_key_exists("declaration_id",$params)){
            $this->db->where('declaration_id',$params['declaration_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countDeclarationData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('declaration_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_DECLARATION_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_declaration'])){
            $searchDeclaration = $params['search_declaration'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchDeclaration, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchDeclaration, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchDeclaration, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchDeclaration, 
                'employee_create_date' => $searchDeclaration
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_declaration_type'])){  
            $searchDeclarationType = $params['search_declaration_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchDeclarationType);
        }
        if(!empty($params['search_declaration_status'])){  
            $searchDeclarationStatus = $params['search_declaration_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchDeclarationStatus);
        }
        if(empty($params['search_declaration']) and empty($params['search_declaration_type']) and empty($params['search_declaration_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_DECLARATION_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewDeclarationTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('declaration_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_DECLARATION_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_declaration_trash'])){
            $searchDeclarationTrash = $params['search_declaration_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchDeclarationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchDeclarationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchDeclarationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchDeclarationTrash, 
                'employee_create_date' => $searchDeclarationTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_declaration_trash_type'])){  
            $searchDeclarationTrashType = $params['search_declaration_trash_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchDeclarationTrashType);
        }
        if(!empty($params['search_declaration_trash_status'])){  
            $searchDeclarationTrashStatus = $params['search_declaration_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchDeclarationTrashStatus);
        }
        if(empty($params['search_declaration_trash']) and empty($params['search_declaration_trash_type']) and empty($params['search_declaration_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_DECLARATION_TABLE . '.trash_status', 'true');
        if(array_key_exists("declaration_id",$params)){
            $this->db->where('declaration_id',$params['declaration_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countDeclarationTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('declaration_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_DECLARATION_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_declaration_trash'])){
            $searchDeclarationTrash = $params['search_declaration_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchDeclarationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchDeclarationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchDeclarationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchDeclarationTrash, 
                'employee_create_date' => $searchDeclarationTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_declaration_trash_type'])){  
            $searchDeclarationTrashType = $params['search_declaration_trash_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchDeclarationTrashType);
        }
        if(!empty($params['search_declaration_trash_status'])){  
            $searchDeclarationTrashStatus = $params['search_declaration_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchDeclarationTrashStatus);
        }
        if(empty($params['search_declaration_trash']) and empty($params['search_declaration_trash_type']) and empty($params['search_declaration_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_DECLARATION_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Consent Functions
	function viewConsentData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('consent_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_CONSENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_consent'])){
            $searchConsent = $params['search_consent'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchConsent, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchConsent, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchConsent, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchConsent, 
                'employee_create_date' => $searchConsent
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_consent_status'])){  
            $searchConsentStatus = $params['search_consent_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchConsentStatus);
        }
        if(empty($params['search_consent']) and empty($params['search_consent_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_CONSENT_TABLE . '.trash_status', 'false');
        if(array_key_exists("consent_id",$params)){
            $this->db->where('consent_id',$params['consent_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countConsentData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('consent_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_CONSENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_consent'])){
            $searchConsent = $params['search_consent'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchConsent, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchConsent, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchConsent, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchConsent, 
                'employee_create_date' => $searchConsent
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_consent_status'])){  
            $searchConsentStatus = $params['search_consent_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchConsentStatus);
        }
        if(empty($params['search_consent']) and empty($params['search_consent_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_CONSENT_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewConsentTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('consent_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_CONSENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_consent_trash'])){
            $searchConsentTrash = $params['search_consent_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchConsentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchConsentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchConsentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchConsentTrash, 
                'employee_create_date' => $searchConsentTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_consent_trash_status'])){  
            $searchConsentTrashStatus = $params['search_consent_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchConsentTrashStatus);
        }
        if(empty($params['search_consent_trash']) and empty($params['search_consent_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_CONSENT_TABLE . '.trash_status', 'true');
        if(array_key_exists("consent_id",$params)){
            $this->db->where('consent_id',$params['consent_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countConsentTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('consent_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_CONSENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_consent_trash'])){
            $searchConsentTrash = $params['search_consent_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchConsentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchConsentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchConsentTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchConsentTrash, 
                'employee_create_date' => $searchConsentTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_consent_trash_status'])){  
            $searchConsentTrashStatus = $params['search_consent_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchConsentTrashStatus);
        }
        if(empty($params['search_consent_trash']) and empty($params['search_consent_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_CONSENT_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Non Disclosure Agreement Functions
	function viewNonDisclosureAgreementData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('employee_nda_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_NON_DISCLOSURE_AGREEMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_non_disclosure_agreement'])){
            $searchNonDisclosureAgreement = $params['search_non_disclosure_agreement'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchNonDisclosureAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchNonDisclosureAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchNonDisclosureAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchNonDisclosureAgreement, 
                DEPARTMENT_TABLE . '.department_name' => $searchNonDisclosureAgreement, 
                'employee_create_date' => $searchNonDisclosureAgreement
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_non_disclosure_agreement_type'])){  
            $searchNonDisclosureAgreementType = $params['search_non_disclosure_agreement_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchNonDisclosureAgreementType);
        }
        if(!empty($params['search_non_disclosure_agreement_status'])){  
            $searchNonDisclosureAgreementStatus = $params['search_non_disclosure_agreement_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchNonDisclosureAgreementStatus);
        }
        if(empty($params['search_non_disclosure_agreement']) and empty($params['search_non_disclosure_agreement_type']) and empty($params['search_non_disclosure_agreement_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_NON_DISCLOSURE_AGREEMENT_TABLE . '.trash_status', 'false');
        if(array_key_exists("employee_nda_id",$params)){
            $this->db->where('employee_nda_id',$params['employee_nda_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countNonDisclosureAgreementData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('employee_nda_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_NON_DISCLOSURE_AGREEMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_non_disclosure_agreement'])){
            $searchNonDisclosureAgreement = $params['search_non_disclosure_agreement'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchNonDisclosureAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchNonDisclosureAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchNonDisclosureAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchNonDisclosureAgreement, 
                DEPARTMENT_TABLE . '.department_name' => $searchNonDisclosureAgreement, 
                'employee_create_date' => $searchNonDisclosureAgreement
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_non_disclosure_agreement_type'])){  
            $searchNonDisclosureAgreementType = $params['search_non_disclosure_agreement_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchNonDisclosureAgreementType);
        }
        if(!empty($params['search_non_disclosure_agreement_status'])){  
            $searchNonDisclosureAgreementStatus = $params['search_non_disclosure_agreement_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchNonDisclosureAgreementStatus);
        }
        if(empty($params['search_non_disclosure_agreement']) and empty($params['search_non_disclosure_agreement_type']) and empty($params['search_non_disclosure_agreement_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_NON_DISCLOSURE_AGREEMENT_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewNonDisclosureAgreementTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('employee_nda_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_NON_DISCLOSURE_AGREEMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_non_disclosure_agreement_trash'])){
            $searchNonDisclosureAgreementTrash = $params['search_non_disclosure_agreement_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchNonDisclosureAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchNonDisclosureAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchNonDisclosureAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchNonDisclosureAgreementTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchNonDisclosureAgreementTrash, 
                'employee_create_date' => $searchNonDisclosureAgreementTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_non_disclosure_agreement_trash_type'])){  
            $searchNonDisclosureAgreementTrashType = $params['search_non_disclosure_agreement_trash_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchNonDisclosureAgreementTrashType);
        }
        if(!empty($params['search_non_disclosure_agreement_trash_status'])){  
            $searchNonDisclosureAgreementTrashStatus = $params['search_non_disclosure_agreement_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchNonDisclosureAgreementTrashStatus);
        }
        if(empty($params['search_non_disclosure_agreement_trash']) and empty($params['search_non_disclosure_agreement_trash_type']) and empty($params['search_non_disclosure_agreement_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_NON_DISCLOSURE_AGREEMENT_TABLE . '.trash_status', 'true');
        if(array_key_exists("employee_nda_id",$params)){
            $this->db->where('employee_nda_id',$params['employee_nda_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countNonDisclosureAgreementTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('employee_nda_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_NON_DISCLOSURE_AGREEMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_non_disclosure_agreement_trash'])){
            $searchNonDisclosureAgreementTrash = $params['search_non_disclosure_agreement_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchNonDisclosureAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchNonDisclosureAgreementTrash,
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchNonDisclosureAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchNonDisclosureAgreementTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchNonDisclosureAgreementTrash, 
                'employee_create_date' => $searchNonDisclosureAgreementTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_non_disclosure_agreement_trash_type'])){  
            $searchNonDisclosureAgreementTrashType = $params['search_non_disclosure_agreement_trash_type'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_type', $searchNonDisclosureAgreementTrashType);
        }
        if(!empty($params['search_non_disclosure_agreement_trash_status'])){  
            $searchNonDisclosureAgreementTrashStatus = $params['search_non_disclosure_agreement_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchNonDisclosureAgreementTrashStatus);
        }
        if(empty($params['search_non_disclosure_agreement_trash']) and empty($params['search_non_disclosure_agreement_trash_type']) and empty($params['search_non_disclosure_agreement_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_NON_DISCLOSURE_AGREEMENT_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Service Agreement Functions
	function viewServiceAgreementData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('service_agreement_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SERVICE_AGREEMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_service_agreement'])){
            $searchServiceAgreement = $params['search_service_agreement'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchServiceAgreement,
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchServiceAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchServiceAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchServiceAgreement, 
                DEPARTMENT_TABLE . '.department_name' => $searchServiceAgreement, 
                'employee_create_date' => $searchServiceAgreement
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_service_agreement_status'])){  
            $searchServiceAgreementStatus = $params['search_service_agreement_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchServiceAgreementStatus);
        }
        if(empty($params['search_service_agreement']) and empty($params['search_service_agreement_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SERVICE_AGREEMENT_TABLE . '.trash_status', 'false');
        if(array_key_exists("service_agreement_id",$params)){
            $this->db->where('service_agreement_id',$params['service_agreement_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countServiceAgreementData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('service_agreement_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SERVICE_AGREEMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_service_agreement'])){
            $searchServiceAgreement = $params['search_service_agreement'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchServiceAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchServiceAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchServiceAgreement, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchServiceAgreement, 
                DEPARTMENT_TABLE . '.department_name' => $searchServiceAgreement, 
                'employee_create_date' => $searchServiceAgreement
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_service_agreement_status'])){  
            $searchServiceAgreementStatus = $params['search_service_agreement_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchServiceAgreementStatus);
        }
        if(empty($params['search_service_agreement']) and empty($params['search_service_agreement_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SERVICE_AGREEMENT_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewServiceAgreementTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('service_agreement_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SERVICE_AGREEMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_service_agreement_trash'])){
            $searchServiceAgreementTrash = $params['search_service_agreement_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchServiceAgreementTrash,
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchServiceAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchServiceAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchServiceAgreementTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchServiceAgreementTrash,
                'employee_create_date' => $searchServiceAgreementTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_service_agreement_trash_status'])){  
            $searchServiceAgreementTrashStatus = $params['search_service_agreement_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchServiceAgreementTrashStatus);
        }
        if(empty($params['search_service_agreement_trash']) and empty($params['search_service_agreement_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SERVICE_AGREEMENT_TABLE . '.trash_status', 'true');
        if(array_key_exists("service_agreement_id",$params)){
            $this->db->where('service_agreement_id',$params['service_agreement_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countServiceAgreementTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('service_agreement_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_SERVICE_AGREEMENT_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_service_agreement_trash'])){
            $searchServiceAgreementTrash = $params['search_service_agreement_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchServiceAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchServiceAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchServiceAgreementTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchServiceAgreementTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchServiceAgreementTrash,
                'employee_create_date' => $searchServiceAgreementTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_service_agreement_trash_status'])){  
            $searchServiceAgreementTrashStatus = $params['search_service_agreement_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchServiceAgreementTrashStatus);
        }
        if(empty($params['search_service_agreement_trash']) and empty($params['search_service_agreement_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_SERVICE_AGREEMENT_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// No Due Certificate Functions
	function viewNoDueCertificateData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('no_due_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_NO_DUE_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_no_due_certificate'])){
            $searchNoDueCertificate = $params['search_no_due_certificate'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchNoDueCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchNoDueCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchNoDueCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchNoDueCertificate, 
                DEPARTMENT_TABLE . '.department_name' => $searchNoDueCertificate
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_no_due_certificate_status'])){  
            $searchNoDueCertificateStatus = $params['search_no_due_certificate_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchNoDueCertificateStatus);
        }
        if(empty($params['search_no_due_certificate']) and empty($params['search_no_due_certificate_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_NO_DUE_CERTIFICATE_TABLE . '.trash_status', 'false');
        if(array_key_exists("no_due_certificate_id",$params)){
            $this->db->where('no_due_certificate_id',$params['no_due_certificate_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countNoDueCertificateData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('no_due_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_NO_DUE_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_no_due_certificate'])){
            $searchNoDueCertificate = $params['search_no_due_certificate'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchNoDueCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchNoDueCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchNoDueCertificate, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchNoDueCertificate, 
                DEPARTMENT_TABLE . '.department_name' => $searchNoDueCertificate
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_no_due_certificate_status'])){  
            $searchNoDueCertificateStatus = $params['search_no_due_certificate_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchNoDueCertificateStatus);
        }
        if(empty($params['search_no_due_certificate']) and empty($params['search_no_due_certificate_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_NO_DUE_CERTIFICATE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewNoDueCertificateTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('no_due_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_NO_DUE_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_no_due_certificate_trash'])){
            $searchNoDueCertificateTrash = $params['search_no_due_certificate_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchNoDueCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchNoDueCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchNoDueCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchNoDueCertificateTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchNoDueCertificateTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_no_due_certificate_trash_status'])){  
            $searchNoDueCertificateTrashStatus = $params['search_no_due_certificate_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchNoDueCertificateTrashStatus);
        }
        if(empty($params['search_no_due_certificate_trash']) and empty($params['search_no_due_certificate_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_NO_DUE_CERTIFICATE_TABLE . '.trash_status', 'true');
        if(array_key_exists("no_due_certificate_id",$params)){
            $this->db->where('no_due_certificate_id',$params['no_due_certificate_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countNoDueCertificateTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('no_due_certificate_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_NO_DUE_CERTIFICATE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_no_due_certificate_trash'])){
            $searchNoDueCertificateTrash = $params['search_no_due_certificate_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchNoDueCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchNoDueCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchNoDueCertificateTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchNoDueCertificateTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchNoDueCertificateTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_no_due_certificate_trash_status'])){  
            $searchNoDueCertificateTrashStatus = $params['search_no_due_certificate_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchNoDueCertificateTrashStatus);
        }
        if(empty($params['search_no_due_certificate_trash']) and empty($params['search_no_due_certificate_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_NO_DUE_CERTIFICATE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Relieving Functions
	function viewRelievingData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('relieving_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_RELIEVING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_relieving'])){
            $searchRelieving = $params['search_relieving'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchRelieving, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchRelieving, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchRelieving, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchRelieving, 
                DEPARTMENT_TABLE . '.department_name' => $searchRelieving, 
                'employee_create_date' => $searchRelieving
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_relieving_status'])){  
            $searchRelievingStatus = $params['search_relieving_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchRelievingStatus);
        }
        if(empty($params['search_relieving']) and empty($params['search_relieving_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_RELIEVING_TABLE . '.trash_status', 'false');
        if(array_key_exists("relieving_id",$params)){
            $this->db->where('relieving_id',$params['relieving_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countRelievingData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('relieving_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_RELIEVING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_relieving'])){
            $searchRelieving = $params['search_relieving'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchRelieving,
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchRelieving, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchRelieving, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchRelieving, 
                DEPARTMENT_TABLE . '.department_name' => $searchRelieving, 
                'employee_create_date' => $searchRelieving
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_relieving_status'])){  
            $searchRelievingStatus = $params['search_relieving_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchRelievingStatus);
        }
        if(empty($params['search_relieving']) and empty($params['search_relieving_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_RELIEVING_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewRelievingTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('relieving_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_RELIEVING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_relieving_trash'])){
            $searchRelievingTrash = $params['search_relieving_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchRelievingTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchRelievingTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchRelievingTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchRelievingTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchRelievingTrash, 
                'employee_create_date' => $searchRelievingTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_relieving_trash_status'])){  
            $searchRelievingTrashStatus = $params['search_relieving_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchRelievingTrashStatus);
        }
        if(empty($params['search_relieving_trash']) and empty($params['search_relieving_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_RELIEVING_TABLE . '.trash_status', 'true');
        if(array_key_exists("relieving_id",$params)){
            $this->db->where('relieving_id',$params['relieving_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countRelievingTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('relieving_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_RELIEVING_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_relieving_trash'])){
            $searchRelievingTrash = $params['search_relieving_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchRelievingTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchRelievingTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchRelievingTrash,
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchRelievingTrash,
                DEPARTMENT_TABLE . '.department_name' => $searchRelievingTrash, 
                'employee_create_date' => $searchRelievingTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_relieving_trash_status'])){  
            $searchRelievingTrashStatus = $params['search_relieving_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchRelievingTrashStatus);
        }
        if(empty($params['search_relieving_trash']) and empty($params['search_relieving_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_RELIEVING_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Experience Functions
	function viewExperienceData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('experience_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_EXPERIENCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_experience'])){
            $searchExperience = $params['search_experience'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchExperience, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchExperience, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchExperience, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchExperience, 
                DEPARTMENT_TABLE . '.department_name' => $searchExperience, 
                'employee_create_date' => $searchExperience
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_experience_status'])){  
            $searchExperienceStatus = $params['search_experience_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchExperienceStatus);
        }
        if(empty($params['search_experience']) and empty($params['search_experience_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EXPERIENCE_TABLE . '.trash_status', 'false');
        if(array_key_exists("experience_id",$params)){
            $this->db->where('experience_id',$params['experience_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countExperienceData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('experience_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_EXPERIENCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_experience'])){
            $searchExperience = $params['search_experience'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchExperience,
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchExperience, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchExperience, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchExperience, 
                DEPARTMENT_TABLE . '.department_name' => $searchExperience, 
                'employee_create_date' => $searchExperience
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_experience_status'])){  
            $searchExperienceStatus = $params['search_experience_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchExperienceStatus);
        }
        if(empty($params['search_experience']) and empty($params['search_experience_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EXPERIENCE_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewExperienceTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('experience_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_EXPERIENCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_experience_trash'])){
            $searchExperienceTrash = $params['search_experience_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchExperienceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchExperienceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchExperienceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchExperienceTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchExperienceTrash, 
                'employee_create_date' => $searchExperienceTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_experience_trash_status'])){  
            $searchExperienceTrashStatus = $params['search_experience_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchExperienceTrashStatus);
        }
        if(empty($params['search_experience_trash']) and empty($params['search_experience_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EXPERIENCE_TABLE . '.trash_status', 'true');
        if(array_key_exists("experience_id",$params)){
            $this->db->where('experience_id',$params['experience_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countExperienceTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('experience_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_EXPERIENCE_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		$this->db->join(DEPARTMENT_TABLE, HRM_EMPLOYEE_TABLE . '.department_id = ' . DEPARTMENT_TABLE . '.department_id');
		if(!empty($params['search_experience_trash'])){
            $searchExperienceTrash = $params['search_experience_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchExperienceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchExperienceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchExperienceTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchExperienceTrash, 
                DEPARTMENT_TABLE . '.department_name' => $searchExperienceTrash, 
                'employee_create_date' => $searchExperienceTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_experience_trash_status'])){  
            $searchExperienceTrashStatus = $params['search_experience_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchExperienceTrashStatus);
        }
        if(empty($params['search_experience_trash']) and empty($params['search_experience_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_EXPERIENCE_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Termination Functions
	function viewTerminationData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('termination_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_TERMINATION_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_termination'])){
            $searchTermination = $params['search_termination'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchTermination, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchTermination, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchTermination, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchTermination, 
                'employee_create_date' => $searchTermination
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_termination_email'])){  
            $searchTerminationEmail = $params['search_termination_email'];
            $this->db->where('is_email', $searchTerminationEmail);
        }
        if(!empty($params['search_termination_status'])){  
            $searchTerminationStatus = $params['search_termination_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchTerminationStatus);
        }
        if(empty($params['search_termination']) and empty($params['search_termination_email']) and empty($params['search_termination_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_TERMINATION_TABLE . '.trash_status', 'false');
        if(array_key_exists("termination_id",$params)){
            $this->db->where('termination_id',$params['termination_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countTerminationData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('termination_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_TERMINATION_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_termination'])){
            $searchTermination = $params['search_termination'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchTermination, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchTermination,
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchTermination, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchTermination, 
                'employee_create_date' => $searchTermination
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_termination_email'])){  
            $searchTerminationEmail = $params['search_termination_email'];
            $this->db->where('is_email', $searchTerminationEmail);
        }
        if(!empty($params['search_termination_status'])){  
            $searchTerminationStatus = $params['search_termination_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchTerminationStatus);
        }
        if(empty($params['search_termination']) and empty($params['search_termination_email']) and empty($params['search_termination_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_TERMINATION_TABLE . '.trash_status', 'false');
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewTerminationTrashData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('termination_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_TERMINATION_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_termination_trash'])){
            $searchTerminationTrash = $params['search_termination_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchTerminationTrash,
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchTerminationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchTerminationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchTerminationTrash,
                'employee_create_date' => $searchTerminationTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_termination_trash_status'])){  
            $searchTerminationTrashStatus = $params['search_termination_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchTerminationTrashStatus);
        }
        if(empty($params['search_termination_trash']) and empty($params['search_termination_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_TERMINATION_TABLE . '.trash_status', 'true');
        if(array_key_exists("termination_id",$params)){
            $this->db->where('termination_id',$params['termination_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countTerminationTrashData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('experience_id','DESC');
		$this->db->join(HRM_EMPLOYEE_TABLE, HRM_TERMINATION_TABLE . '.employee_id = ' . HRM_EMPLOYEE_TABLE . '.employee_id');
		if(!empty($params['search_termination_trash'])){
            $searchTerminationTrash = $params['search_termination_trash'];
            $likeArr = array(
                HRM_EMPLOYEE_TABLE . '.employee_first_name' => $searchTerminationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_middle_name' => $searchTerminationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_last_name' => $searchTerminationTrash, 
                HRM_EMPLOYEE_TABLE . '.employee_email' => $searchTerminationTrash, 
                'employee_create_date' => $searchTerminationTrash
            );
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_termination_trash_status'])){  
            $searchTerminationTrashStatus = $params['search_termination_trash_status'];
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status', $searchTerminationTrashStatus);
        }
        if(empty($params['search_termination_trash']) and empty($params['search_termination_trash_status'])){
            $this->db->where(HRM_EMPLOYEE_TABLE . '.employee_status !=', 'inactive');
        }
        $this->db->where(HRM_TERMINATION_TABLE . '.trash_status', 'true');
		$result = $this->db->count_all_results();
		return $result;
	}
}