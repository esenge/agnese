<?php
class Shop extends Admin_Controller
{

	public function __construct ()
	{
		parent::__construct();
		//Ielade modeli
		$this->load->model('shop_m');
	}

	public function index ()
	{
		// Padod veikala datus
		$this->data['shops'] = $this->shop_m->get();
		
		// Ielādē skatu
		$this->data['subview'] = 'admin/shop/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

    private function set_upload_options()
{   
	//Preces attēla opcijas
    $config = array();
    $config['upload_path'] = './images/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '10000';
    $config['max_width']  = '40000';
    $config['max_height']  = '40000';
     
    $config['overwrite']     = FALSE;

    return $config;
}

//augšuplādē attēlu
    function do_upload()
    {
        $this->load->library('upload'); 

        //padod opcijas priekš augšuplādēšanas
		 $this->upload->initialize($this->set_upload_options()); 	

		 foreach($_FILES as $field => $file)
            {
                //parbauda vai viss kartiba ar failu
                if($file['error'] == 0)
                {
                    //notiek augšupielāde
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

         //attēla manipulācija
		$image_data = $this->upload->data();
		//manipulācijas opcijas
		$config =array(
		   'source_image' => $image_data['full_path'],
		   'new_image' =>'./images/thumbs',
		   'maintain_ration' =>true,
		   'width' =>500,
		   'height'=>500
   		);

  $this->load->library('image_lib', $config);
  $this->image_lib->resize();
            
            //ja ir errors, tad agriež to
            if (isset($errors))
     		{
     			return $errors;
    		}
    		//ja nav tad agriež 0
    		else {return '0';}
    }
//funkcija, kas izsauc error paziņojumu
	function do_alert($msg) 
    {
        echo '<script type="text/javascript">alert("' . $msg . '"); </script>';
    }

//Izveido jaunu preci vai rediģē esošo
	public function edit ($id = NULL)
	{
		if ($id) {
			$this->data['shop'] = $this->shop_m->get($id);
			count($this->data['shop']) || $this->data['errors'][] = 'Prece netika atrasta.';
		}
		else {
			$this->data['shop'] = $this->shop_m->get_new();
		}
		
		// Piešķirs formai noteikumus
		$rules = $this->shop_m->rules;
		$this->form_validation->set_rules($rules);
		
		// Apstrādā formu
		if ($this->form_validation->run() == TRUE) {
			$data = $this->shop_m->array_from_post(array(
				'title', 
				'title_eng',
				'slug', 
				'body',
				'body_eng', 
				'pubdate',
				'thumbnail',
				'price',
				'price_eng'
			));

			//piešķīr mainigajam 0 vai erroru no funkcijas
			$err = $this->do_upload();

			//ja ir 0, tad saglabā, ja ir error, tad neko nedara un izmet paziņojumu ar atbilstošu kļūdu
			 if ($err=='0')
     		{
      			$this->shop_m->save($data, $id);
				redirect('admin/shop');
     		}
     		else
     		{
     			$this->do_alert($err);
     		}
		}

		// Ielādē skatu
		$this->data['subview'] = 'admin/shop/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}
	//izdzēš preci
	public function delete ($id)
	{
		$this->shop_m->delete($id);
		redirect('admin/shop');
	}
}