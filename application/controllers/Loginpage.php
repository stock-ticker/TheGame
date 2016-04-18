<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginpage extends Application {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
    
    function index() {
        $this->data['pagebody'] = 'loginView';
        $this->render();
    }
    
    function submit() {
        $key = $this->input->post('userid');
        $user = $this->users->get($key);
        if (password_verify($this->input->post('password'),$user->password)) {
            $this->session->set_userdata('userID',$key);
            $this->session->set_userdata('username',$user->name);
            $this->session->set_userdata('userRole',$user->role);
            redirect('/');
        } else{
            redirect('/Loginpage');
        }
        
    }
    
    function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }
}
