<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageagent extends Application {

    public function index()
    {
        $this->data['pagebody'] = 'management';  
        $this->bsxSync();
        $this->render();
    }   
    public function bsxSync()
    {
        $this->registerAgent('G02', 'theTeam', 'tuesday');
        echo $this->gamestate->getState()['stateDesc'];
        $this->stocks->syncStocks();
        $this->movements->syncMovements();
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
