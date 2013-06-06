<?php 

class Site extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->is_logged_in();
	}

	function members_area(){

		$this->load->view('user/members_area');

	}

	function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!isset($is_logged_in) || $is_logged_in != true){
			echo 'Tev nav pieejas šai lapai. <a href="../login">Ieiet</a>';
			die();
		}
	}
}