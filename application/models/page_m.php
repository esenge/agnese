<?php
class Page_m extends MY_Model
{
	protected $_table_name = 'pages';
	//lai vecāku atslēgas būtu iestatītas pirms bērnu atslēgām
	protected $_order_by = 'parent_id, order';
	//lapu likumi
	public $rules = array(
		'parent_id' => array(
			'field' => 'parent_id', 
			'label' => 'Vecāks', 
			'rules' => 'trim|intval'
		), 
		'template' => array(
			'field' => 'template', 
			'label' => 'Veidne', 
			'rules' => 'trim|required|xss_clean'
		), 
		'title' => array(
			//lauks tite ar vārdu Title
			'field' => 'title', 
			'label' => 'Nosaukums', 
			'rules' => 'trim|required|max_length[100]|xss_clean'
		), 
		'title_eng' => array(
			'field' => 'title_eng', 
			'label' => 'Nosaukums angliski', 
			'rules' => 'trim|required|max_length[100]|xss_clean'
		), 
		'slug' => array(
			'field' => 'slug', 
			'label' => 'Īsvārds', 
			'rules' => 'trim|required|max_length[100]|url_title|callback__unique_slug|xss_clean'
		), 
		'body' => array(
			'field' => 'body', 
			'label' => 'Pammatteksts', 
			'rules' => 'trim'
		), 
		'body_eng' => array(
			'field' => 'body_eng', 
			'label' => 'Pammatteksts angliski', 
			'rules' => 'trim'
		)
	);

	public function get_new ()
	{//lai pievienoto lapu,defaultās vērtības
		$page = new stdClass();
		$page->title = '';
		$page->title_eng ='';
		$page->slug = '';
		$page->body = '';
		$page->body_eng ='';
		$page->parent_id = 0;//lapa bez vecāka
		$page->template = 'page';
		return $page;
	}
	//ja kādreiz mainās links uz arhīvu, lai tai no sākumlapas varētu piekļūt
	public function get_archive_link(){
		//atlasa lapas, kur veidne ir news_archive, tad padod kā otro parametru
		$page = parent::get_by(array('template' => 'news_archive'), TRUE);
		//atgriež lapas slugu, ja lapa eksistē, vari arī tukšu, ja neeksistē
		return isset($page->slug) ? $page->slug : '';
	}
	
	public function delete ($id)
	{
		//dzēst lapu, izsauc page metodi , padodot id
		parent::delete($id);
		
		//pārliek vecāka id bērniem(atjaunošana)
		$this->db->set(array(
			'parent_id' => 0
			//vecāks id būs nulle, kur vecāks ir vienāds ar tekošo id, pēc tam atjauno page tabulu
		))->where('parent_id', $id)->update($this->_table_name);
	}
	//lapu izkārtojumam, ņem masīvu kā parametru
	public function save_order ($pages)
	{
		//vai lapu masīvs satur jebkādus ierakstus
		if (count($pages)) {
			//iet cauri masīvam
			foreach ($pages as $order => $page) {
				//atjaunina tikai tad ja nav tukša rinda
				if ($page['item_id'] != '') {
					//int lai atgriež skaitli, savādāk errors
					$data = array('parent_id' => (int) $page['parent_id'], 'order' => $order);
					//lietojot datu masīvu kur primārā atslēga vienāda ar itema id, atjaunina
					$this->db->set($data)->where($this->_primary_key, $page['item_id'])->update($this->_table_name);
				}
			}
		}
	}
	//f-ja lai dabūtu navigāciju(ligzdojumu)
	public function get_nested ()
	{
		$this->db->order_by($this->_order_by);
		//mainaīgais pages, kas atgriež query resultātu masīvu
		$pages = $this->db->get('pages')->result_array();
		
		$array = array();
		foreach ($pages as $page) {
			if (! $page['parent_id']) {
				//ja lapai nav parent_id, tad to ieliek masīvā, page_id būs atslēga
				$array[$page['id']] = $page;
			}
			else {
				// ja tā lapa ir bērns, tad atslēgu ievieto children masīvā
				$array[$page['parent_id']]['children'][] = $page;
			}
		}
		//atgriež sakārtotu masīvu
		return $array;
	}
	//tie paši parametri kas get metodei
	public function get_with_parent ($id = NULL, $single = FALSE)
	{
		$this->db->select('pages.*, p.slug as parent_slug, p.title as parent_title');
		//atgriež visas lapas un usvecāka lapas dat
		$this->db->join('pages as p', 'pages.parent_id=p.id', 'left');
		//atgriezīs no parent metodes
		return parent::get($id, $single);
	}

	public function get_no_parents ()
	{
		//atlasa visas lapas, kurām nav vecāku

		$this->db->select('id, title');
		$this->db->where('parent_id', 0);
		//dabū lapas, saglabā tās.
		$pages = parent::get();
		
		// atgriež atslēgu, kas satur vērtību pāri
		$array = array(
			0 => 'Nav vecāks' //defaultā vērtība
		);
		//ja ir lapas, iet tām cauri;
		//katrai lapai masīvā piešķir masīvu: id kā atslēgu un nosaukumu kā vērtību
		if (count($pages)) {
			foreach ($pages as $page) {
				$array[$page->id] = $page->title;
			}
		}
		return $array;
	}
}