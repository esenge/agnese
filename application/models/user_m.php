<?php
class User_M extends MY_Model
{
	
	protected $_table_name = 'users';
	protected $_order_by = 'name';
	//validācijas "likumi" priekš login formas
	public $rules = array(
		'email' => array(
			//katrs lauks satur 3 atslēgas;
			//lai lietotu likumus, tos vajag ielādēt, tas notiek lib/admin_controller
			'field' => 'email', 
			'label' => 'E-pasts', 
			'rules' => 'trim|required|valid_email|xss_clean'
		), 
		'password' => array(
			'field' => 'password', 
			'label' => 'Parole', 
			'rules' => 'trim|required'
		)
	);
	//admin f-jām
	public $rules_admin = array(
		'name' => array(
			'field' => 'name', 
			'label' => 'Vārds', 
			'rules' => 'trim|required|xss_clean'
		), 
		'email' => array(
			'field' => 'email', 
			'label' => 'E=pasts', 
			//callback, lai rediģējot lietotāju, varētu saglabāt to pašu epastu
			'rules' => 'trim|required|valid_email|callback__unique_email|xss_clean'
		), 
		'password' => array(
			'field' => 'password', 
			'label' => 'Parole', 
			'rules' => 'trim|matches[password_confirm]'
		),
		'password_confirm' => array(
			'field' => 'password_confirm', 
			'label' => 'Paroles apstiprināšana', 
			'rules' => 'trim|matches[password]'
		),
	);

	function __construct ()
	{
		parent::__construct();
	}
	//atlasa email un password, pārbauda vai ir
	public function login ()
	{	
		//atrod lietotāju, saglabā to mainīgajā user
		$user = $this->get_by(array(
			'email' => $this->input->post('email'),
			//izsauc f-ju hash, lai nohashotu paroli, true lai dabūtu viena lietotāju, ne masīva objektus
			'password' => $this->hash($this->input->post('password')),
		), TRUE);
		
		//ja lietotājs nav tukšs, tad...
		if (count($user)) {
			//.. var autentificēties ->
			//izveido mainīgu, kas sastāv no masīva, kas satur šo informāciju:
			$data = array(
				'name' => $user->name,
				'email' => $user->email,
				'id' => $user->id,
				//lietotājs ir autentificējies
				'loggedin' => TRUE,
			);
			//masīvs tiek glabāts sesijā, kas pastāv, kamēr pārlūkprogramma ir atvērta
			$this->session->set_userdata($data);
		}
	}
	//"nobeidz login" sesiju
	public function logout ()
	{
		//notīra loggedin sesijas mainīgo
		$this->session->sess_destroy();
	}
	//atgriež true ja lietotājs ir autentificējies, savādāk atgriež false
	//zinot, cik ilga ir sesija, var uzrakstīt loggedin metodi(no login)
	public function loggedin ()
	{
		//atgriež sesijas mainīgo loggedin'
		return (bool) $this->session->userdata('loggedin');
	}
	
	public function get_new(){
		$user = new stdClass();
		$user->name = '';
		$user->email = '';
		$user->password = '';
		return $user;
	}
	//hasho paroli.ņem strinu kā parametru un hasho, "salted"ar ecnryption key.garumā 512 ar sha algoritmu.
	public function hash ($string)
	{
		return hash('sha512', $string . config_item('encryption_key'));
	}
}