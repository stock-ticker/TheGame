<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Application {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
    
    function index() {
        $this->data['pagebody'] = 'registerView';
        $this->render();
        //use data transfer buffer technique
    }
    
    function submit() {
        $name = $this->input->post('name');
        $id = $this->input->post('userid');
        $pword = $this->input->post('password');
        $user = $this->users->create();
        $user->id = $id;
        $user->name = $name;
        $user->password = password_hash($pword, PASSWORD_DEFAULT);
        $user->role = "user";
        $this->users->add((array) $user);
        $this->session->set_userdata('userID', $user->id);
        $this->session->set_userdata('userName', $user->name);
        $this->session->set_userdata('userRole', $user->role);
        
        $config['upload_path'] = './assets/avatars/';
        $config['file_name'] = $id;
        $config['allowed_types'] = 'gif|jpg|png';
        
        $this->load->library('upload', $config);
        
        if(!$this->upload->do_upload('avatar')) {
            echo($this->upload->display_errors());
        }
        
        //redirect('/');
    }
}
