<?php 

class Login extends CI_Controller{

    function index(){
        $this->load->view('user/login_form');
    }
    function validate_credentials(){
        $this->load->model('membership_model');
        $query= $this->membership_model->validate();

        if ($query) { // ja lietotāja dari pareizi
            $data = array(
                'username' =>$this->input->post('username'),
                'is_logged_in' =>true
            );
        $this->session->set_userdata($data); 
        redirect('site/members_area');
        }

        else{
            $this->index();
        }
    }

    function signup(){

        $data['main_content'] = 'signup_form';
        $this->load->view('user/signup_form');
    }

    function create_member(){
        $this->load->library('form_validation');
        //lauka vārds, kļūdu ziņojumi, likumi

        $this->form_validation->set_rules('first_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
        $this->form_validation->set_rules('email_address', 'E-mail', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
    

        if($this->form_validation->run() == FALSE){
            $this->signup();
        }
        else{
            $this->load->model('membership_model');
            if ($query = $this->membership_model->create_member()) {
                $this->load->view('user/signup_succesful');
            }
            else{
                $this->load->view('user/signup_form');
            }
        }
    }
}