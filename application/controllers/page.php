<?php

class Page extends Frontend_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('page_m'); 
        $this->load->library('session');
        $langses = $this->session->userdata('lang');
       
    }
    public function index() {
        // Ielādēt lapas templeitu (sagatavi)
        //dabūt lapu pēc tās slug, meklē kur slug sakrīt ar pirmo segmentu
        $this->data['page'] = $this->page_m->get_by(array('slug' => (string) $this->uri->segment(1)), TRUE);
        //ja lapa neeksistē paziņo par 404 erroru, padodo tekošo url adresi
        count($this->data['page']) || show_404(current_url());
        
        add_meta_title($this->data['page']->title);
        
        //atlasa visus datus
        //mainīgajā saglabā tekošās lapas veidni
        $method = '_' . $this->data['page']->template;
        //ja metode eksistē.. klasi padod caur pirmo parametru, un metodes nosaukumu kā otro
        if (method_exists($this, $method)) {
            //izsauc metodi
            $this->$method();
        }
        //ja nē, izsauc log_messag, kur parādās errori, rindiņas nosaukumu, faila nosaukumu
        else {
            log_message('error', 'Could not load template ' . $method .' in file ' . __FILE__ . ' at line ' . __LINE__);
            //lietotājam parāda tikai to, ka nevar ielādēt veidni
            show_error('Could not load template ' . $method);
        }
        
        //ielādē skatu, subview būs vienāds ar veidni
        $this->data['subview'] = $this->data['page']->template;
        $this->load->view('_main_layout', $this->data);
    }
    private function _shop(){
            $this->data['recent_news'] = $this->shop_m->get_recent();
            
            //saskaita visas preces veikalā
            $this->shop_m->set_published();
            $count = $this->db->count_all_results('shops');
            
            //uzstādā pārlapošanu
             $pershop = 6;
             if ($count > $pershop) {
                 $this->load->library('pagination');
                 $config['base_url'] = site_url($this->uri->segment(1));
                 $config['total_rows'] = $count;
                 $config['per_page'] = $pershop;
                 $config['uri_segment'] = 2;
                 $this->pagination->initialize($config);
                 $this->data['pagination'] = $this->pagination->create_links();
                 $offset = $this->uri->segment(2);
             }
             else {
                 $this->data['pagination'] = '';
                 $offset = 0;
             }
            
            //atlasa visas preces
            $this->shop_m->set_published();
            $this->db->limit($pershop, $offset);
            $this->data['shops'] = $this->shop_m->get();
        }
    
    private function _page(){

        $this->data['articles'] = $this->article_m->get();//define article te
         $this->data['articles'] = $this->article_m->get();
        $this->data['articles10'] = $this->article_m->get_recent10();
    }

    
    private function _homepage(){ 
    	
    	$this->article_m->set_published();
        //izveido mainīgo, kuram piešķir get metodi no article_m
    	$this->data['articles'] = $this->article_m->get_recent();
        $this->data['articles10'] = $this->article_m->get_recent10();
    }
    
    private function _news_archive(){
    	
    	$this->data['recent_news'] = $this->article_m->get_recent();
		//saskatia visus rakstus, kas atbilst kritētirijiem
		$this->article_m->set_published();
        //saskaite visus ierakstus no datu bāzes tabulas articles
		$count = $this->db->count_all_results('articles');
		
		//iestata pārlapošanu
		$perpage = 5;//tik rādās vienā lapā
        //ja raksti ir vairāk par norādīto
		if ($count > $perpage) {
            //iekļauj pagination bibliotēku
			$this->load->library('pagination');
			$config['base_url'] = site_url($this->uri->segment(1) . '/');
			$config['total_rows'] = $count;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config);
            //saglabā linkus mainīgajā
			$this->data['pagination'] = $this->pagination->create_links();
			//limitēs rakstus
            $offset = $this->uri->segment(2);
		}
        //ja nevajag tad tukša rinda un pārlapošana nav vajadzīga
		else {
			$this->data['pagination'] = '';
			$offset = 0;
		}
		
		//atlasa rakstus, kuri būs attēloti
		$this->article_m->set_published();
		$this->db->limit($perpage, $offset);
		$this->data['articles'] = $this->article_m->get();
        $this->data['articles10'] = $this->article_m->get_recent10();


    }

    private function _contacts(){
      
    }


}