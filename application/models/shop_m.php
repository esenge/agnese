<?php
class Shop_m extends MY_Model
{
 protected $_table_name = 'shops';
 protected $_order_by = 'pubdate desc, id desc';
 //lapu likumi
 protected $_timestamps = TRUE;
 public $rules = array(
  'pubdate' => array(
  	//katrs lauks satur 3 atslēgas;
	//lai lietotu likumus, tos vajag ielādēt, tas notiek lib/admin_controller
   'field' => 'pubdate', 
   'label' => 'Publicēšanas datums', 
   'rules' => 'trim|exact_length[10]|xss_clean'
  ), 
  'title' => array(
   'field' => 'title', 
   'label' => 'Nosaukums', 
   'rules' => 'trim|max_length[100]|xss_clean'
  ), 
  'title_eng' => array(
   'field' => 'title_eng', 
   'label' => 'Nosaukums angliski', 
   'rules' => 'trim|max_length[100]|xss_clean'
  ), 
  'slug' => array(
   'field' => 'slug', 
   'label' => 'Īsvārds', 
   'rules' => 'trim|max_length[100]|url_title|xss_clean'
  ), 
  'body' => array(
   'field' => 'body', 
   'label' => 'Pamatteksts', 
   'rules' => 'trim'
  ),
  'body_eng' => array(
   'field' => 'body_eng', 
   'label' => 'Pamatteksts angliski', 
   'rules' => 'trim'
  ),
  'thumbnail' => array(
   'field' => 'thumbnail', 
   'label' => 'Sīkattēls', 
   'rules' => 'trim|required'
  ),
  'price' => array(
   'field' => 'price', 
   'label' => 'Cena latos', 
   'rules' => 'trim'
  ),
  'price_eng' => array(
   'field' => 'price_eng', 
   'label' => 'Cena euro', 
   'rules' => 'trim'
  )

 );


//padod jaunu preci

 public function get_new ()
 {
  $shop = new stdClass();
  $shop->id = '';
  $shop->title = '';
  $shop->title_eng ='';
  $shop->slug = '';
  $shop->body = '';
  $shop->body_eng ='';
  $shop->pubdate = date('Y-m-d');
  $shop->thumbnail ='';
  $shop->price ='';
  $shop->price_eng ='';
  return $shop;
 }
 
//Ieraksta datumu, kad publicē preci

 public function set_published(){
  $this->db->where('pubdate <=', date('Y-m-d'));
 }
 

//padod 3 pēdejas preces

 public function get_recent($limit = 3){
  

  $limit = (int) $limit;
  $this->set_published();
  $this->db->limit($limit);
  return parent::get();
 }

//padod veikala linku

 public function get_shop_link(){
  $shop = parent::get_by(array('template' => 'shop'), TRUE);
  return isset($shop->slug) ? $shop->slug : '';
 }



}