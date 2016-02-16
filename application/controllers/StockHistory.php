<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockHistory extends CI_Controller {

    function __construct()
	{
		parent::__construct();
                
	}
        
	public function index()
	{
            $source = array_map('str_getcsv', file('stocks.csv'));
            print_r($source);
            /*
            foreach ($source as $record)
		{
			$stocks[] = array('Code' => $record['Code'], 'Name' => $record['Name'], 'Category' => $record['Category'], 'Value' => $record['Value']);
		}
		$this->data['stocks'] = $stocks;
*/
            //$this->data['pagebody'] = 'stock_history';
            //$this->render();
            $this->load->view('stock_history');
	}
}
