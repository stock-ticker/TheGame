<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageagent extends Application {

    public function index()
    {
        $this->bsxSync();
        $this->data['pagebody'] = 'management';  
        // $this->bsxSync()
        echo '   STATE:' . $this->gamestate->getState()['stateDesc'] . $this->gamestate->getState()['countdown'];
        echo '    TOKEN: ' . $this->session->userdata('token');
        echo '   USERNAME: ' . $this->session->userdata('userName');
        echo $this->buy('GOLD', 10);
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
        $url = 'http://bsx.jlparry.com/sell';
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
        $certificate = $this->holdings->getCertificate($player, $stock);
        echo 'SELLING CERTIFICATE:'. $certificate;
        //attempt to sell stocks
        $ch = curl_init();   
        curl_setopt($ch, CURLOPT_URL, BSX_URL . '/buy');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,           
            array('team' => 'g02',
              'token' => $agentToken,
              'player' =>  $player,
              'stock' => $stock,
              'quantity' => $quantity,
              'certificate' => $certificate));
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec ($ch);
        curl_close ($ch);
        $xml_resp = new SimpleXMLElement($response);
        if($xml_resp->token->__toString() == null)
        {
            echo $response;
            return 'failed to sell';
        }
        
        //sync stock info with BSX server
        $this->stocks->syncStocks();
        
        //update player info
        $PurchaseValue = $this->stocks->valueFromCode($stock) * $quantity;
        $this->holdings->deleteWithCertificate($certificate);
        $this->users->subtractCash($player, $PurchaseValue * (-1));
        
        return 'Sold';     
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
   
    }
 //Registers a new Agent
    function registerAgent($teamId, $teamName, $password) {
        $params = array(
            'team' => $teamId,
            'name' => $teamName,
            'password' => $password,
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
    }
}
