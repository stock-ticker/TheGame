<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlayerStatus extends CI_Controller {

    function __construct()
	{
		parent::__construct();
	}

    public function index($player)
	{
                    $source = $this->players->all();
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
            $this->load->view('PlayerStatus');
          
            /*
            $this->data['pagebody'] = 'PlayerStatus';
            $source = $this->database->get($player);
            $this->data['peanuts'] = $source['peanuts'];
            //Need a way to get total player equity here.
            $this->data['gold'] = $source['gold'];
            $this->data['tech'] = $source['technology'];
            $this->data['bonds'] = $source['bonds'];
            $this->data['oil'] = $source['oil'];
            $this->data['industry'] =  $source['industry'];
            $this->data['grain'] = $source['grain'];
            $this->load->view('player_status');
            $this->render();*/
	}
}