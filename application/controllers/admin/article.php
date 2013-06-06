<?php
class Article extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('article_m');
	}
	public function index ()
	{
		// atlasa vaisus rakstus ar get metodi
	
		$this->data['articles'] = $this->article_m->get();
		
		// ielādē skatu
		$this->data['subview'] = 'admin/article/index';
		$this->load->view('admin/_layout_main', $this->data);
	}


   private function set_upload_options()
{   
// attēla opcijas
    $config = array();
    $config['upload_path'] = './images/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size']      = '0';
    $config['max_size'] = '10000';
    $config['max_width']  = '20000';
    $config['max_height']  = '20000';
     
    $config['overwrite']     = FALSE;
    return $config;
}
	public function do_upload()
    {
        $this->load->library('upload'); 
		 $this->upload->initialize($this->set_upload_options()); 	
		 foreach($_FILES as $field => $file)
            {
                // ja nav problēmas ar failu
                if($file['error'] == 0)
                {
                    //notiek augšupielādē
                    if ($this->upload->do_upload($field))
                    {
                        $data = $this->upload->data();
                    }
                    else
                    {	
                        $errors = $this->upload->display_errors('','');
                    }
                }
            }
            if (isset($errors))
     		{
     			return $errors;
    		}
    		else {return '0';}
    }

	public function do_alert($msg) 
    {
        echo '<script type="text/javascript">alert("' . $msg . '"); </script>';
    }

	public function edit ($id = NULL)
	{
		
		//dabū rakstu, vai izveido jaunu rakstu
		if ($id) {
			$this->data['article'] = $this->article_m->get($id);
			count($this->data['article']) || $this->data['errors'][] = 'Raksts netika atrasts.';
		}
		else {
			$this->data['article'] = $this->article_m->get_new();
		
		}
		//izveido formu
		$rules = $this->article_m->rules;
		$this->form_validation->set_rules($rules);
		
		// apstrādā formu
		if ($this->form_validation->run() == TRUE) {
			$data = $this->article_m->array_from_post(array(
				'title',
				'title_eng', 
				'slug', 
				'body', 
				'body_eng',
				'pubdate',
				'thumbnail',
				'category'
			));
			$err = $this->do_upload();
			 if ($err=='0')
     		{
      			$this->article_m->save($data, $id);
				redirect('admin/article');
     		}
     		else
     		{
     			$this->do_alert($err);
     		}
		}
		
		//ielādē skatu
		$this->data['subview'] = 'admin/article/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function delete ($id)
	{
		$this->article_m->delete($id);
		redirect('admin/article');
	}
}