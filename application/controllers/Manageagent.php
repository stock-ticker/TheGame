<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageagent extends Application {

    public function index()
    {
        //$this->bsxSync();
        $this->data['pagebody'] = 'manageAgent';  
        $this->render();
    } 

    public function bsxSync()
    { 
        if(time() - $this->session->userdata('lastRegistered') > 100 || $this->session->userdata('lastRegistered') == null)
        {
          $this->registerAgent('G02', 'theTeam', 'tuesday');  
        }
        
        $this->gamestate->getState()['stateDesc'];
        $this->stocks->syncStocks();
        $this->movements->syncMovements();
        redirect('/Manageagent/index');
    }
 //Registers a new Agent
    function registerAgent() {
        
        $params = array(
            'team' => $stock = $this->input->post('team'),
            'name' => $this->input->post('name'),
            'password' => $this->input->post('password')
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, BSX_URL . '/register');     
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $xml_resp = new SimpleXMLElement($response);
        curl_close($curl);

        $this->session->set_userdata('token', $xml_resp->token->__toString());
        $this->session->set_userdata('lastRegistered', time());
        redirect('/Manageagent/index');
    }
}
