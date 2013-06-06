<?php
class User extends Admin_Controller
{

	public function __construct ()
	{
		parent::__construct();
	}
	//lietotāju attēlošani
	public function index ()
	{
		// Atlasīt visus lietotājus, kas atrodas datu bāzē
		$this->data['users'] = $this->user_m->get();
		
		// Ielādē skatus
		$this->data['subview'] = 'admin/user/index';
		//padod datus skatam
		$this->load->view('admin/_layout_main', $this->data);
	}
	//lietotāju pievienošanai un rediģēšanai
	//atlasa lietotāju, ja tā ir rediģēšana
	public function edit ($id = NULL)
	{
		// atlasa lietotāju vai izveido jaunu
		if ($id) {
			//ja ir, saglabā mainīgajā
			$this->data['user'] = $this->user_m->get($id);
			count($this->data['user']) || $this->data['errors'][] = 'Lietotājs netika atrasts.';
		}
		else {
			$this->data['user'] = $this->user_m->get_new();
		}
		
		// IZVEIDO FORMU
		//likumi balstās uz admina likumiem
		$rules = $this->user_m->rules_admin;
		//ja ievieto lietotāju(nav id), tad parolei ir jābūt obligātai
		$id || $rules['password']['rules'] .= '|required';
		$this->form_validation->set_rules($rules);
		
		// APSTRĀDĀ FORMU
		if ($this->form_validation->run() == TRUE) {
			$data = $this->user_m->array_from_post(array('name', 'email', 'password'));
			$data['password'] = $this->user_m->hash($data['password']);
			$this->user_m->save($data, $id);
			redirect('admin/user');
		}
		
		// ielādē skatu
		$this->data['subview'] = 'admin/user/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}
	//id kā parametrs
	public function delete ($id)
	{
		$this->user_m->delete($id);
		redirect('admin/user');
	}

	public function login ()
	{
		// Novirza lietotāju uz admina sākumlapu, ja jau ir autentificējies.
		$dashboard = 'admin/dashboard';
		//izsauc loggedin metodi no user_m,ja šī forma validējas;
		// ja ir loggedin->novirza uz dashboard
		$this->user_m->loggedin() == FALSE || redirect($dashboard);
		
		// IZVEIDO FORMU
		//saglabā likumus no user_m mainīgajā rules
		$rules = $this->user_m->rules;
		//pievieno šos likumus form_validation bibliotēkai,padod $rules mainīgo
		$this->form_validation->set_rules($rules);
		
		// APSTRĀDĀ FORMU
		//ja šie likumi ir derīgi, tad...
		if ($this->form_validation->run() == TRUE) {
			// ..un ir autenitificējies sitēmā
			if ($this->user_m->login() == TRUE) {
				//..novirza uz dashboard
				redirect($dashboard);
			}
			//savādāk parrāda erroru un pārlādē lapu
			else {
				$this->session->set_flashdata('error', 'E-pasta/paroles kombinācija neeksistē.');
				redirect('admin/user/login', 'refresh');
			}
		}
		
		// IELĀDĒ SKATU
		$this->data['subview'] = 'admin/user/login';
		// $this->data atbild par subview ielādi
		$this->load->view('admin/_layout_modal', $this->data);
	}

	public function logout ()
	{
		//izsauc logout metodi no user_m
		$this->user_m->logout();
		//novirza lietotāju
		redirect('admin/user/login');
	}

	public function _unique_email ($str)
	{
		// nevalidē e-pastu, ja tāds jau eksistē
		// izņemot gadījumus, ja ievada cita lietotāja epastu no datu bāzes
		
		$id = $this->uri->segment(4);
		$this->db->where('email', $this->input->post('email'));
		//meklē epastu, bet ne sekojošajam lietotājam
		//ja ir id, neiekļaut esošā lietotāja id, id dabū no id(106rindiņa)
		!$id || $this->db->where('id !=', $id);
		$user = $this->user_m->get();
		//ja atrod lietotāju, ziņo par erroru, return false, likums nenostrādāja
		if (count($user)) {
			$this->form_validation->set_message('_unique_email', '%s jābūt unikālām.');
			return FALSE;
		}
		
		return TRUE;
	}
}