<?php
// emaila nosūtīšana, izmantojot gmail
class Email extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index(){
    }
    
    function send()
    {   
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name','Name', 'trim|required');
        $this->form_validation->set_rules('email','Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('subject','Subject', 'trim|required');
        $this->form_validation->set_rules('message','Message', 'trim|required');
        
        if($this->form_validation->run() ==FALSE){
            echo "<script> 
                    setTimeout(function(){
                        alert('Kļūda! Ziņojums netika nosūtīts. Aizpildi visus laukus pareizi vai mēģini vēlāk!');
                    }, 1000); 
                    </script>";
                  redirect('kontakti', 'refresh');
        }
        else{
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');
        

            $this->load->library('email');
            $this->email->set_newline("\r\n");
            $this->email->from($email, $name);
            $this->email->to('agnese.skujina@gmail.com');     
            $this->email->subject($subject);     
            $this->email->message($message);

            if($this->email->send()){
               echo "<script> 
                    setTimeout(function(){
                        alert('Tavs ziņojums administratoram tika nosūtīts. Gaidi atbildi tuvāko 48 stundu laikā.');
                    }, 1000); 
                    </script>";
                  redirect('kontakti', 'refresh');
            }
            else{
                echo "<script> 
                    setTimeout(function(){
                        alert('error.');
                    }, 1000); 
                    </script>";
                  redirect('kontakti', 'refresh');
            }
        }
    }
}


      