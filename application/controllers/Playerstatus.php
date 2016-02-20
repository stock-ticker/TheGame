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
        $this->holdings($selectedPlayer);
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
           // $this->data['trans_panel'] = $this->parser->parse('transaction_history', $this->data, true);   
    }
    
    private function holdings($playerName)
    {
        $totalTransactions = $this->transactions->transactionSums($playerName);
        $allStocks = $this->stocks->all();
        
            foreach ($allStocks as $stock)
		{   
                    $balance = 0;
                    $balance += $this->transactions->transactionSum($playerName, $stock['Code'], 'buy');
                    $balance -= $this->transactions->transactionSum($playerName, $stock['Code'], 'sell');
                    $holdings[] = array('Name' => $stock['Name'],
                        'Code' => $stock['Code'], 'Balance' => $balance);
		}
        $this->data['holdings'] = $holdings;
    }
}
