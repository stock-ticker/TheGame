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
                 $selectedStock = 'GOLD';
            }
            
            $this->movements($selectedStock);
            $this->transactions($selectedStock);
            $this->stocklist();
            echo $this->selectStock();

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
               // print_r($stocks);
              $this->data['stocks'] = $stocks;
        }
        
        private function movements($stockCode)
        {
            $source = $this->movements->allForStock($stockCode);
            foreach ($source as $record)
		{
                    $movements[] = array('DateTime' => $record['Datetime'],
                        'Action' => $record['Action'],
                        'Amount' => $record['Amount']);
		}
            $this->data['movements'] = $movements;
        }
        
        private function transactions($stockCode)
        {
            $source = $this->transactions->allForStock($stockCode);

            foreach ($source as $record)
		{
                    $transactions[] = array('DateTime' => $record['DateTime'],
                        'Player' => $record['Player'],
                        'Trans' => $record['Trans'],
                        'Quantity' => $record['Quantity']);
		}
            $this->data['transactions'] = $transactions;
        }
}
