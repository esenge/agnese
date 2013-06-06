<!-- gandrīz copy paste no user controller -->
<?php
class Page extends Admin_Controller
{

	public function __construct ()
	{
		parent::__construct();
		//būs nepieciešams gandrīz katrā metodē
		$this->load->model('page_m');
	}

	public function index ()
	{
		//atlasīt visas lapas, kurām ir vecāki, ir pieeja vecāka slugam
		$this->data['pages'] = $this->page_m->get_with_parent();
		
		//ielādē skatu
		$this->data['subview'] = 'admin/page/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function order ()
	{
		//mainīgais, lai zinātu, ka jāielādē nepieciešamo js failu
		$this->data['sortable'] = TRUE;
		$this->data['subview'] = 'admin/page/order';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function order_ajax ()
	{
		// saglabā kārtību (page_m f-ja)
		if (isset($_POST['sortable'])) {
			//saglabā sakārtotā masīvā
			$this->page_m->save_order($_POST['sortable']);
		}
		
		// atlasa visas lapas
		$this->data['pages'] = $this->page_m->get_nested();
		
		//ielādē skatu
		$this->load->view('admin/page/order_ajax', $this->data);
	}

	public function edit ($id = NULL)
	{
		//atlasa visas lapas vai izveido jaunu
		if ($id) {
			//ja ir, saglabā mainīgajā
			$this->data['page'] = $this->page_m->get($id);
			count($this->data['page']) || $this->data['errors'][] = 'page could not be found';
		}
		else {
			$this->data['page'] = $this->page_m->get_new();
		}
		
		//lapas priekš dropdown izvēlnes
		$this->data['pages_no_parents'] = $this->page_m->get_no_parents();
		
		// // IZVEIDO FORMU
		//likumi balstās uz lapu likumiem
		$rules = $this->page_m->rules;
		$this->form_validation->set_rules($rules);
		
		//FORMAS APSTRĀDE
		if ($this->form_validation->run() == TRUE) {
			//padod datus, kas satur šādus laukus
			$data = $this->page_m->array_from_post(array(
				'title', 
				'title_eng',
				'slug', 
				'body',
				'body_eng', 
				'template', 
				'parent_id'
			));
			$this->page_m->save($data, $id);
			redirect('admin/page');
		}
		
		//Ielādē skatu
		$this->data['subview'] = 'admin/page/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}
	//id kā parametrs
	public function delete ($id)
	{
		$this->page_m->delete($id);
		redirect('admin/page');
	}

	public function _unique_slug ($str)
	{
		//nevalidē ja slug jau eksistē
		//ja vien tā nav tekošā lapa, erors netiek parādīts
		$id = $this->uri->segment(4);
		$this->db->where('slug', $this->input->post('slug'));
		! $id || $this->db->where('id !=', $id);
		$page = $this->page_m->get();
		
		if (count($page)) {
			$this->form_validation->set_message('_unique_slug', '%s jābūt unikālam.');
			return FALSE;
		}
		
		return TRUE;
	}
}