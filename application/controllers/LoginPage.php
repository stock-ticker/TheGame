<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginPage extends Application {

    function __construct()
    {
	parent::__construct();
                
    }  
    public function index()
    {
        if($this->input->post('username') != NULL)
        {
           $userData = array(
                'username'  => $this->input->post('username'),
                'logged_in' => TRUE
               );
            $this->session->set_userdata($userData); 
        }
    
        
        if($this->session->userdata('logged_in') == TRUE)
        {
            $this->data['loginStatus'] = 'logged in as ' . $this->session->userdata('username');  
        }
        else
        {
            $this->data['loginStatus'] = 'Please Log In'; 
        }
        $this->data['pagebody'] = 'loginView';
        $this->render();
    }
    public function login()
    {
        $userData = array(
                'username'  => $this->input->post('username'),
                'logged_in' => TRUE
               );
        $this->session->set_userdata($userData);
        $this->data['pagebody'] = 'loginView';
        $this->render();
    }
   
}
