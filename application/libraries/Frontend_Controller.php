<?php
class Frontend_Controller extends MY_Controller
{
	function __construct ()
	{
		parent::__construct();

		//ielādē modeļus, 
		$this->load->model('page_m');
		$this->load->model('article_m');
		$this->load->model('shop_m');
		
		// atlasa navigāciju
		//nodefinē mainīgo, lieto modeli, lai dabūtu navigāciju ar get_nested metodi
		$this->data['menu'] = $this->page_m->get_nested();
		//lai dabūtu linku ar get_archive_link metodi
		$this->data['news_archive_link'] = $this->page_m->get_archive_link();
		$this->data['meta_title'] = config_item('site_name');
		$this->data['shop_link'] = $this->shop_m->get_shop_link();
	}
}