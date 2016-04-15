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
        $this->load->helper('bsxserver');
        $this->bsxSync();
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

            if($userRole == "admin") {
                $choices[] = array('name' => "Alpha", 'link' => '/alpha');
                $choices[] = array('name' => "Beta", 'link' => '/beta');
                $choices[] = array('name' => "Gamma", 'link' => '/gamma');
                $choices[] = array('name' => "Logout", 'link' => '/auth/logout');
            }
            if($userRole == "user") {
                $choices[] = array('name' => "Alpha", 'link' => '/alpha');
                $choices[] = array('name' => "Beta", 'link' => '/beta');
                $choices[] = array('name' => $userName, 'link' => '/loginpage/logout');
            }
            if($userRole == null) {
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
    
    public function bsxSync()
    {
        $this->load->helper('bsxserver');
        $this->registerAgent('G02', 'theTeam', 'tuesday');
        $this->gamestate->getState()['stateDesc'];
        $this->stocks->syncStocks();
        $this->movements->syncMovements();
    }
//public $agentAuth = 'sdfg';
    function registerAgent($teamId, $teamName, $password) {
        $params = array(
            'team' => $teamId,
            'name' => $teamName,
            'password' => $password,
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://bsx.jlparry.com/register');     
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        //$xml_resp = new SimpleXMLElement($response);
        curl_close($curl);
        //echo $xml_resp;
        $this->session->set_userdata('token', (string)$response);
       
        /*
        if($response != null)
        {
            $xml_resp = new SimpleXMLElement($response);
            echo $response;
        } else
        {
            echo "register response is null";
        }
        */
    }
}

