<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockHistory extends CI_Controller {

    function __construct()
	{
		parent::__construct();
	}
        
	public function index()
	{
		//$this->data['pagebody'] = 'history';
               // $this->render();
            $this->load->view('stock_history');
	}
}
