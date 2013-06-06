<?php
class Dashboard extends Admin_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index() {
    	//atlasa pēdējos rediģētos un pievienototos rakstu
    	$this->load->model('article_m');
    	$this->db->order_by('modified desc');
    	$this->db->limit(10);
    	$this->data['recent_articles'] = $this->article_m->get();
    	
    	$this->data['subview'] = 'admin/dashboard/index';
        //ielādē skatu _layout_main; ielādē datus layout_main skatā
    	$this->load->view('admin/_layout_main', $this->data);
    }
    
    public function modal() {
        //ielādē skatu _layout_modal
    	$this->load->view('admin/_layout_modal', $this->data);
    }
}