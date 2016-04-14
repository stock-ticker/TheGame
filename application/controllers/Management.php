<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Management extends Application {

    public function index()
    {
        $this->data['pagebody'] = 'management';       
        $this->registerAgent('G02', 'theTeam', 'tuesday');
        $this->gameState();
        //$this->stocks->syncStocks();
        $this->movements->syncMovements();
        
        $this->render();
    }   
    
    //Attemts to register a new agent with the specified user info
     public function registerAgent($teamId, $teamName, $password) {
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
        
        curl_close($curl);
        if($response != null)
        {
            $xml_resp = new SimpleXMLElement($response);
            echo $response;
        } else
        {
            echo "register response is null";
        }
        
         
    }
    //Gets the game state info. Unformatted
    public function gameState() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://bsx.jlparry.com/status');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        $response = curl_exec($curl);
        curl_close($curl);
        if($response != null)
        {
            $xml_resp = new SimpleXMLElement($response);
           echo $xml_resp->desc->__toString();  
        } 
        else
        {
           echo "gamestate response is null";
        }
        
        /*
        echo $xml_resp->state->__toString();
        echo $xml_resp->round->__toString();
        echo $xml_resp->countdown->__toString();

         */
       
         
    }
}
