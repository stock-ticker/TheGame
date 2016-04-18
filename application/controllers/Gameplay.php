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
            //$this->bsxSync();
            
            $this->data['player'] = $this->session->userdata('username');
            //$this->data['equity'] =
            $this->data['cash'] = $this->users->getCash($this->session->userdata('username'));
            $this->playerHoldings();
            //$this->data['marketboard'] = $this->fillMarket();
            $this->data['pagebody'] = 'gameplay';
            $this->render();
        }
        //accepts buying forms from view. handles buying and selling
        function submit(){
            $stock = $this->input->post('stock');
            $action = $this->input->post('action');
            if($action == 'buy')
            {
                echo 'buying';
            }
            elseif($action == 'sell')
            {
              echo 'selling';   
            }
            
        }
        
        //gets the held stocks for the currently logged in player
        private function playerHoldings()
        {
            $source = $this->holdings->allForPlayer($this->session->userdata('username'));
        
       foreach ($source as $record)
       {    
           if($record['Quantity'] == NULL)
           {
               $quantity = 0;
           }
           else
           {
               $quantity = $record['Quantity'];
           } 
           
            $holdings[] = array('Stock' => $record['Name'],
                                'Value' => $record['Value'],
                                'Code' => $record['Code'],
                                'Quantity' => $quantity);
        }
        $this->data['holdings'] = $holdings;
    }

        
        public function fillMarket(){
            $source = $this->gameplay->getMarketboard();
            foreach ($source as $record)
            {
                $stocks[] = array('stock' => $record['stock'],
                                  'code' => $record['code'],
                                  'value' => $record['value'],
                                  'radio' => $record['radio']);
            }
            return $stocks;
        }
        
    //buys stock for the currently logged in player. Returns 'Purchased' on success, error message on failure
    function buy($stock, $quantity = 10)
    {
        $stock = $this->input->post('stock');       
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
    
    function sell($stock, $quantity = 10)
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