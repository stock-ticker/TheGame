<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageagent extends Application {

    public function index()
    {
        $this->data['pagebody'] = 'management';  
        // $this->bsxSync()
        echo '   STATE:' . $this->gamestate->getState()['stateDesc'] . $this->gamestate->getState()['countdown'];
        echo '    TOKEN: ' . $this->session->userdata('token');
        echo '   USERNAME: ' . $this->session->userdata('userName');
        echo $this->buy('BOND', 10);
        ///echo '   CERTIFICATE: ' . $this->session->userdata('certificate');
        $this->render();
    } 

    //buys stock for the currently logged in player. Returns 'Purchased' on success, error message on failure
    function buy($stock, $quantity)
    {
        $url = 'http://bsx.jlparry.com/buy';
        $player = $this->session->userdata('userName');
        if($player == null)
        {
            return 'no logged in player';
        }
        
        $agentToken = $this->session->userdata('token');
        if($agentToken == null)
        {
            return 'no agent token';
        }
        //sync stock information with BSX server
        $this->stocks->syncStocks();
        
        //check if player has enough cash
        $PurchaseValue = $this->stocks->valueFromCode($stock) * $quantity;
        echo 'VALUE:' . $PurchaseValue;
        if($this->users->getCash($player) < $PurchaseValue) 
        {
            return 'insufficient cash'; 
        }
        
        //attempt to buy stocks
        $ch = curl_init();   
        curl_setopt($ch, CURLOPT_URL,"http://bsx.jlparry.com/buy");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,           
            array('team' => 'g02',
              'token' => $agentToken,
              'player' =>  $player,
              'stock' => $stock,
              'quantity' => $quantity));
            //"team=g02&token=$token&player=$player&stock=$stock&quantity=$quantity");
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec ($ch);
        curl_close ($ch);
        $xml_resp = new SimpleXMLElement($response);
        echo ' CERTIFICATE: '. $xml_resp->token->__toString();
        if($xml_resp->token->__toString() == null)
        {
            return 'failed to buy';
        }
        
        //update player info
        $this->holdings->addStock($player, $stock, $quantity, $xml_resp->token->__toString());
        $this->users->subtractCash($player, $PurchaseValue);
        
        return 'Purchased';     
    }
    
    function sell($stock, $quantity)
    {
        $url = BSX_URL . '/buy';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://bsx.jlparry.com/buy");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,           
            array('team' => 'g02',
              'token' => $this->session->userdata('token'),
              'player' => $this->session->userdata('userName'),
              'stock' => $stock,
              'quantity' => $quantity));
            //"team=g02&token=$token&player=$player&stock=$stock&quantity=$quantity");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec ($ch);
        
        $xml_resp = new SimpleXMLElement($response);
       // $this->session->set_userdata('certificate', $xml_resp->certificate->__toString());
        $this->session->set_userdata('certificate', 'asdf');
        curl_close ($ch);
        
       // echo 'CERTIFICATE:' . $xml_resp->certificate->__toString();
        
        
        
    }
}
