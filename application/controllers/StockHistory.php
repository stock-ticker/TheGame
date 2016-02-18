<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockHistory extends Application {

    function __construct()
	{
		parent::__construct();
                
	}
        
	public function index()
	{
            if($this->selectStock() != NULL)
            {
                $selectedStock = $this->selectStock();
            } else
            {
                 $selectedStock = $this->transactions->mostRecent();
            }
            
            $this->data['currentStock'] = $this->stocks->nameFromCode($selectedStock);
            
              if($this->movements($selectedStock)){
                $this->data['move_panel'] = $this->parser->parse('movement_history', $this->data, true);
            } else
            {
                $this->data['move_panel'] = '<h3>No movement History</h3>';
            }
            
            if($this->transactions($selectedStock)){
                $this->data['trans_panel'] = $this->parser->parse('transaction_history', $this->data, true);
            } else
            {
                $this->data['trans_panel'] = '<h3>No transaction History</h3>';
            }
             
            $this->stocklist();           

            $this->data['pagebody'] = 'stock_history';
           
           
            $this->render();
	}
        
        public function selectStock()
        {
            $data = $this->input->post('stockSelector');

            return $data;
        }
        
        public function stocklist()
        {
            $source = $this->stocks->all();
            foreach ($source as $record)
		{
                    $stocks[] = array('Name' => $record['Name'],
                        'Code' => $record['Code']);
		}
              $this->data['stocks'] = $stocks;
        }
        
        private function movements($stockCode)
        {
            $source = $this->movements->allForStock($stockCode);
            if($source == NULL){
               return FALSE;
            } 
            foreach ($source as $record)
		{
                    $movements[] = array('DateTime' => $record['Datetime'],
                        'Action' => $record['Action'],
                        'Amount' => $record['Amount']);
		}
            $this->data['movements'] = $movements;
            return TRUE;
        }
        
        private function transactions($stockCode)
        {
            $source = $this->transactions->allForStock($stockCode);
           if($source == NULL){
               return FALSE;
           } else
           {
                foreach ($source as $record)
                {
                    $transactions[] = array('DateTime' => $record['DateTime'],
                        'Player' => $record['Player'],
                        'Trans' => $record['Trans'],
                        'Quantity' => $record['Quantity']);
                }
            
           }
            $this->data['transactions'] = $transactions;
            return TRUE;
        }
}
