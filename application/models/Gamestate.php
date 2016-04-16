<?php
class Gamestate extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function getState() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, BSX_URL . '/status');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        $response = curl_exec($curl); 
        curl_close($curl);
        
        $xml_resp = new SimpleXMLElement($response);
        $responseArray = array(
            'stateDesc' => $xml_resp->desc->__toString(),
            'stateNum' => $xml_resp->state->__toString(),
            'countdown' => $xml_resp->state->__toString()
        );
        return $responseArray;  
    }
}