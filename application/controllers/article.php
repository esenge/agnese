<!-- gandrīz tas pats, kas page_m -->
<?php 
class Article extends Frontend_Controller
  {
    public function __construct(){
        parent::__construct();
        
        $this->data['recent_news'] = $this->article_m->get_recent();
    }
   public function index($id, $slug)
    {
      //ielādē sesijas bibliotēku
      $this->load->library('session');
      //ieliek flashdata mainīgo $id un definē viņu, kā article_id mainīgo
      $this->session->set_flashdata('article_id',$id);

    $this->data['articles10'] = $this->article_m->get_recent10();

    $this->data['result'] = $this->db->get('message')->result();

      //atlasa rakstu
    $this->article_m->set_published();
        //pēc datuma, un pēc tā id
    $this->data['article'] = $this->article_m->get($id);
       
    
      //atgriez 404 eroru, ja neatrod rakstus
      count($this->data['article']) || show_404(uri_string());
     // var_dump($id);
      //pāradresēt ja slug nepareizs
      $requested_slug = $this->uri->segment(3);
      $set_slug = $this->data['article']->slug;
        //ja pieprasītais slug nav vienāds ar uzstādīto slug
      if ($requested_slug != $set_slug) {
            //pāradresē uz .. 301 jo 3.segments un uz to pāradresē. piem /-aha-raksts, pāradresē /raksts
        redirect('article/' . $this->data['article']->id . '/' . $this->data['article']->slug, 'location', '301');
      }
      
      //ielādē skatu, 
      add_meta_title($this->data['article']->title);
      $this->data['subview'] = 'article';
      $this->load->view('_main_layout', $this->data);
     }

//mērķis dabūt $id saturu no index un insert funkciju

    public function insert()
     {
      //izņem mainīgo
      $id = $this->session->flashdata('article_id');
      //saglabā flashdata, lai izvadītos komentāri vairākas reizes.
      $this->session->keep_flashdata('article_id');

      $this->data['article'] = $this->article_m->get($id);
      $aSlug = $this->data['article']->slug; 
       $this->load->model('article_m');
       echo $this->article_m->inserttodb($aSlug); 
      }
    }


