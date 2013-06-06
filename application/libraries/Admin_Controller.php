<!-- izpildās visās admin lapās -->
<?php
class Admin_Controller extends MY_Controller
{

	function __construct ()
	{
		parent::__construct();
		//vietnes nosaukums
		$this->data['meta_title'] = 'Rokdarbu pasaule';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');

		//atbild par likumu ielādēšanu
		$this->load->model('user_m');
		
		// Ielogošanās pārbaude, veiks autentifikācijas testu visos kontrolieros, kas ir balstīti uz admin_controller
		//izņēmuma gadījumi, kad netiek veikta pārbaude
		$exception_uris = array(
			'admin/user/login', 
			'admin/user/logout'
		);
		//ja nav no kādām izņēmuma lapām, tad...
		if (in_array(uri_string(), $exception_uris) == FALSE) {
			//...ja loggedin return false, tad...
			if ($this->user_m->loggedin() == FALSE) {
				//..novirza lietotāju uz login formu
				redirect('admin/user/login');
			}
		}
	
	}
}