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
            $userName = $this->session->userdata('username');

            $choices[] = array('name' => "Home", 'link' => '/homepage');
            $choices[] = array('name' => "Stock History", 'link' => '/Stockhistory');
            $choices[] = array('name' => "Players", 'link' => '/Playerstatus');
            if($userRole != null) {

                $choices[] = array('name' => "Play Game", 'link' => '/Gameplay');

                
                if($userRole == "admin") {
                    $choices[] = array('name' => "Manage Agent", 'link' => '/Manageagent');
                }
                $choices[] = array('name' => 'Logged in as: ' . $userName, 'link' => '/manageaccn');
                $choices[] = array('name' => "Logout", 'link' => '/loginpage/logout');
            }
            else{
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

