<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
function bsxSync()
    {
        registerAgent('G02', 'theTeam', 'tuesday');
        echo $this->gamestate->getState()['stateDesc'];
        $this->stocks->syncStocks();
        $this->movements->syncMovements();
    }
    //Attemts to register a new agent with the specified user info
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
        
        curl_close($curl);
        $agentAuth = $response;
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

function syncMovements() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://bsx.jlparry.com/data/movement');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);
        $csv = str_getcsv($output, "\n");
        $this->db->where('Code !=', 'NULL');
        $this->db->delete('movements');
        // loop through csv to get array

        for ($i = 1; $i < count($csv); $i++) {
            $move = str_getcsv($csv[$i], ",");
            
            $data = array(
                'seq' => $move[0],
                'Datetime' => gmdate("Y.m.d-H:i:s", $move[1]),
                'Code' => $move[2],
                'Action' => $move[3],
                'Amount' => $move[4]
            );
            $this->db->insert('movements', $data); 
        }
    }
    
    function syncStocks() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://bsx.jlparry.com/data/stocks');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);
        $csv = str_getcsv($output, "\n");
        //$header = str_getcsv($csv[0], ",");

        $this->db->where('Code !=', 'NULL');
        $this->db->delete('stocks');
        // loop through csv to get array
        for ($i = 1; $i < count($csv); $i++) {
            $stock = str_getcsv($csv[$i], ",");
            
            $data = array(
                'Code' => $stock[0],
                'Name' => $stock[1],
                'Category' => $stock[2],
                'Value' => $stock[3]
            );
            $this->db->insert('stocks', $data); 
        }
    }