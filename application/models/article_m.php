<?php
    class Article_m extends MY_Model
    {
      //pārkopē mainīgos no my_model funkcijas
  protected $_table_name = 'articles';
  protected $_order_by = 'pubdate desc, id desc';
  protected $_timestamps = TRUE;
  public $rules = array(
    'pubdate' => array(
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
      'label' => 'Sīkatēls', 
      'rules' => 'trim|required'
    ), 
    'category' => array(
      'field' => 'category', 
      'label' => 'Ketegorija', 
      'rules' => 'trim|max_length[100]|xss_clean'
    ),
  );

  public function get_new ()
  {
    $article = new stdClass();
    $article->id = '';
    $article->title = '';
    $article->title_eng = '';
    $article->slug = '';
    $article->body = '';
    $article->body_eng = '';
    $article->pubdate = date('Y-m-d');
    $article->thumbnail ='';
    $article->category ='';
    return $article;
  }
  public function set_published(){
    $this->db->where('pubdate <=', date('Y-m-d'));
  }
  
  //ņems rakstu limitu, kā paramteru
  public function get_recent($limit = 3){
    
    //dabū limitētu skaitu neseno rakstu
    $limit = (int) $limit;
    $this->set_published();
    $this->db->limit($limit);
    return parent::get();
  }

  public function get_recent10($limit = 10){
    
    //dabū limitētu skaitu neseno rakstu
    $limit = (int) $limit;
    $this->set_published();
    $this->db->limit($limit);
    return parent::get();
  }
        public function inserttodb($aSlug)
        {
            if(!empty($_POST))
            {
                $username = $this->input->post('username');
                $email    = $this->input->post('email');
                $message  = $this->input->post('message');
                           
                //var_dump($aSlug);
                $commentArray = array(
                  'username' =>   $username,
                  'email'    =>   $email,
                  'message'  =>   $message,
                  'slug'    =>    $aSlug
                     
                );
               // var_dump($commentArray);
    $this->db->insert('message',$commentArray);
    return $this->returnMarkup($username,$email,$message);
             }
             
        }
    private function returnMarkup($name,$email,$message)
         {         
             return '<div>
                        <p>'.$name.':'.$message.'</p>
                    </div>';
         }
    }