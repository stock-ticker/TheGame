<?php

class Application extends CI_Controller {
    
    protected $data = array();
    protected $id;
    protected $choices = array('Home' => '/',
                               'Gallery' => '/gallery',
                               'About' => '/about');
    
    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['pagetitle'] = 'Sample Image Gallery';
        $this->load->library('parser');
    }
    
    function render() {
        if($this->session->userdata('logged_in') == TRUE)
        {
            $this->data['loginText'] = $this->session->userdata('username');  
        }
        else
        {
            $this->data['loginText'] = 'Login'; 
        }
        $this->data['menubar'] = $this->choices;
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
        $this->data['data'] = &$this->data;
        $this->parser->parse('template', $this->data);
    }
}

