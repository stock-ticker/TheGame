<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockHistory extends Application {

    function __construct()
	{
		parent::__construct();
                
	}
        
	public function index()
	{
            
            $source = $this->transactions->allForStock('GOLD');
          // print_r($source);
            
           //$source = $this->stocks->names();
            //print_r($source);
            
            
            foreach ($source as $record)
		{
			$transactions[] = array('DateTime' => $record['DateTime'],
                            'Player' => $record['Player'],
                            'Trans' => $record['Trans'],
                            'Quantity' => $record['Quantity']);
		}
            $this->data['transactions'] = $transactions;

            $this->data['pagebody'] = 'stock_history';
            $this->render();
            //$this->load->view('stock_history');
	}
        
        public function stocklist()
        {
            $source = $this->stocks->names();
            print_r($source);
        }
}
