<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlayerStatus extends Application {

    function __construct()
	{
		parent::__construct();
	}

    public function index()
    {   
         
        
        if($this->input->post('playerSelector') != NULL)
            {
                $selectedPlayer = $this->input->post('playerSelector');
            } else
            {
                 $selectedPlayer = 'Donald';
            }
        
        
        $this->data['selectedPlayer'] = $selectedPlayer;
        $this->data['playerCash'] = $this->players->cashForPlayer($selectedPlayer);
        
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
        $source = $this->players->all();
        foreach ($source as $record)
	{
            $players[] = array('Name' => $record['Player']);
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

}

