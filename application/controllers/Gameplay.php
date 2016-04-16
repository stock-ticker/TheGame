<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Controller for the Gameplay elements of StockTicker.
 *  Facilitates buying/selling of stock.
 *
 * @author Sean
 */
class Gameplay extends Application{
    
      function __construct()
        {
          parent::__construct();
        }
        
        public function index()
        {
            $this->bsxSync();
            $this->data['pagebody'] = 'gameplay';
            //$this->data['player'] =
            //$this->data['equity'] =
            //$this->data['cash] =
            //$this->data['holdings] =
            //$this->data['marketboard'
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
