<?php 

class Membership_model extends MY_Model{
	//validācijas f-ja.
	function validate(){
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password',md5($this->input->post('password')));
		$query = $this->db->get('membership');

		if ($query->num_rows ==1 ) {
			return true;
		}
	}
	//izveido jaunu lietotāju no ievadītajiem datiem.
	function create_member(){
		$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password'))
		);
		//ievieto datus datu bāzē.
		$insert = $this->db->insert('membership', $new_member_insert_data);
		return $insert;
	}
}