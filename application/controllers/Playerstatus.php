<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlayerStatus extends Application {

    function __construct()
	{
		parent::__construct();
	}

    public function index()
    {   
        $this->bsxSync(); 
        
        if($this->input->post('playerSelector') != NULL)
            {
                $selectedPlayer = $this->input->post('playerSelector');
            } else
            {
                if($this->session->userdata('logged_in'))
                {
                    $selectedPlayer = $this->session->userdata('username');
                }
                else
                {
                    $selectedPlayer = 'Please Select A Player';
                }
            }
            
       

        
        
        $this->data['selectedPlayer'] = $selectedPlayer;
        $this->data['playerCash'] = $this->users->getCash($selectedPlayer);
        
        if(file_exists (FCPATH . '/assets/avatars/' . $selectedPlayer . '.png'))
        {
            $this->data['imagePath'] = '/assets/avatars/' . $selectedPlayer . '.png';
        }
        elseif(file_exists (FCPATH . '/assets/avatars/' . $selectedPlayer . '.gif'))
        {
            $this->data['imagePath'] = '/assets/avatars/' . $selectedPlayer . '.png';
        }
        elseif(file_exists (FCPATH . '/assets/avatars/' . $selectedPlayer . '.jpg'))
        {
            $this->data['imagePath'] = '/assets/avatars/' . $selectedPlayer . '.png';
        }
        else 
        {
            $this->data['imagePath'] = '/assets/avatars/defaultAvatar.png';
        }
        
        
        $this->playerTransactions($selectedPlayer);
        $this->playerHoldings($selectedPlayer);
        $this->playerlist(); 
        $this->data['pagebody'] = 'players';
        $this->render();      
    }
     /*
     * Passes an array of player names to the view. Used for the player
     * select list
     */  
    public function playerlist()
    {
        $source = $this->users->allPlayers();
        foreach ($source as $record)
	{
            $players[] = array('Name' => $record['name']);
	}
        $this->data['players'] = $players;
    }
    
    /*
     * gets the recent stock transactions for the specified player
     * Param: $playerName - the player to get history for
     */  
    private function playerTransactions($playerName)
    {
        $source = $this->transactions->allForPlayer($playerName);
        if($source == NULL){
            $transactions = array();   
        }

            foreach ($source as $record)
            {
                $transactions[] = array('DateTime' => $record['DateTime'],
                    'Stock' => $record['Stock'],
                    'Trans' => $record['Trans'],
                    'Quantity' => $record['Quantity']);
            }
            $this->data['transactions'] = $transactions;   
    }

    
    private function playerHoldings($playerName)
    {
        $source = $this->holdings->allForPlayer($playerName);
        
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
                'Quantity' => $quantity);
        }
        $this->data['holdings'] = $holdings;
    }
    
    //Syncs withthe bsx server
    public function bsxSync()
    {
        if(time() - $this->session->userdata('lastRegistered') > 100 || $this->session->userdata('lastRegistered') == null)
        {
          $this->registerAgent('G02', 'theTeam', 'tuesday');  
          $this->stocks->syncStocks();
          $this->movements->syncMovements();
        }
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

