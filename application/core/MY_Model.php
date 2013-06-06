<?php
//kā kāds modelis tiek ielādēts, tad arī šis modelis tiek ielādēts reizē ar to
//kā "parent class" visiem pārējiem
class MY_Model extends CI_Model {
	
	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	public $rules = array();
	protected $_timestamps = FALSE; //pēc noklusējuma
	
	function __construct() {
		parent::__construct();
	}
	
	public function array_from_post($fields){
		$data = array();
		foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		}
		return $data;
	}
	
//$id ņem kā parameetru
	public function get($id = NULL, $single = FALSE){
		
		if ($id != NULL) {
			//ja ir id, tad atgriež konkrēto row=>1
			//kā ari to filtrē,kuru saglabā mainīgajā

			$filter = $this->_primary_filter;
			$id = $filter($id);
			//izpilde where nosacījumu
			$this->db->where($this->_primary_key, $id);
			//atgriež vienu rindu
			$method = 'row';
		}
		//ja padod single parametru, atgriež single row
		elseif($single == TRUE) {
			$method = 'row';
		}

//>1 savādāk atgriež visus rezultātus (ja nepadod single, tad iegūst masīvu ar rezultātiem )
		else {
			$method = 'result';
		}
		if (!count($this->db->ar_orderby)) {
			$this->db->order_by($this->_order_by);
		}
		//pieslēdzas datubāzei, pielietojot konkrēto metodi.
		return $this->db->get($this->_table_name)->$method();
	}

	//meklē, izmantojot where 
	public function get_by($where, $single = FALSE){
		$this->db->where($where);
		//atgriež get statementu
		return $this->get(NULL, $single);
	}
	
	//insert un save metode izveidota vienā, jo tās pēc būtības ir ļoti līdzīgas
	//ņem masīvu, kurš sauksies $data
	//vienmēr būs dati, ko saglabāt,
	//ja padod id, tad dati tiks atjaunoti, ja nē, tad būs ievietoti
	public function save($data, $id = NULL){
		
		// Iestatīt taimstampus(laikspiedogus)
		//ja vajag tos uzstādīt
		if ($this->_timestamps == TRUE) {
			$now = date('Y-m-d H:i:s');
			//ja nav id, izveido datumu
			$id || $data['created'] = $now;
			//datums, kad rediģē
			$data['modified'] = $now;
		}
		// DATU IEVIETOŠANA

		//ja nav padots id
		if ($id === NULL) {
			//ja primārā atslēga nav isset, tad piešķier, ja ir, tad null
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			$this->db->set($data);
			//iebūvētā metode
			$this->db->insert($this->_table_name);
			//id tiks uzstādīts
			$id = $this->db->insert_id();
		}
		// DATU ATJAUNINĀŠANA

		//ja padod id
		else {
			//vajag primary key piešķirt
			$filter = $this->_primary_filter;
			$id = $filter($id);
			//noteikt datus
			$this->db->set($data);
			$this->db->where($this->_primary_key, $id);
			$this->db->update($this->_table_name);
		}
		//atgriež id, kur ievietoti jaunie/pievienotie dati
		//ja bija atjaunināšana, tad jau ir
		//ja ievietošana, tad to uzstāda
		return $id;
	}
	//paņem vienu parametru
	public function delete($id){
		$filter = $this->_primary_filter;
		//filtrē jeb atlasa id, kurš tika padots
		$id = $filter($id);
		
		//ja tāds id nav, tad neko nedzēš
		if (!$id) {
			return FALSE;
		}
		//ja ir, tad ievieotp, kur primary key ir vienāda ar id
		$this->db->where($this->_primary_key, $id);
		$this->db->limit(1);
		//izssauc , padod tabulas nosaukumu
		$this->db->delete($this->_table_name);
	}
}