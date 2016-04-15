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
        $this->data['pagetitle'] = 'Stock Ticker';
        $this->load->library('parser');
    }
    
    function render() {
        $mychoices = array('menudata' => $this->makemenu());
        
        $this->data['menubar'] = $this->parser->parse('_menubar', $mychoices, true);
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
        $this->data['data'] = &$this->data;
        $this->parser->parse('template', $this->data);
    }
    
    function makemenu() {
            $choices = array();

            $userRole = $this->session->userdata('userRole'); 
            $userName = $this->session->userdata('userName');

            if($userRole != null) {
                $choices[] = array('name' => "Alpha", 'link' => '/alpha');
                $choices[] = array('name' => "Beta", 'link' => '/beta');
                $choices[] = array('name' => $userName, 'link' => '/manageaccn');
                $choices[] = array('name' => "Logout", 'link' => '/loginpage/logout');
            } else {
                $choices[] = array('name' => "Alpha", 'link' => '/alpha');
                $choices[] = array('name' => "Login", 'link' => '/loginpage');
                $choices[] = array('name' => "Sign up", 'link' => '/register');
            }
            return $choices;
    }
    
    function restrict($roleNeeded = null) {
        $userRole = $this->session->userdata('userRole');
        
        if ($roleNeeded != null) {
            if (is_array($roleNeeded)) {
                if (!in_array($userRole, $roleNeeded)) {
                    redirect("/");
                    return;
                }
            } else if ($userRole != $roleNeeded) {
                redirect("/");
                return;
            }
        }
    }
}

