<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller {

	public function index(){
		$this->load->view('header');
		$this->load->view('error');
		$this->load->view('footer');
	}
	
	public function permissionDenied(){
		$this->load->view('header');
		$this->load->view('permission_denied');
		$this->load->view('footer');
	}
	
	public function ipDenied(){
		$this->load->view('ip_denied');
	}
	
	public function timeDenied(){
		$this->load->view('time_denied');
	}
}
