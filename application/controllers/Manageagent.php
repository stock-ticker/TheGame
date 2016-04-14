<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageagent extends Application {

    public function index()
    {
        $this->data['pagebody'] = 'management';  
       // $this->bsxSync();
        $this->render();
    }   
    public function bsxSync()
    {
        $this->load->helper('bsxserver');
        registerAgent('G02', 'theTeam', 'tuesday');
        $this->gamestate->getState()['stateDesc'];
        $this->stocks->syncStocks();
        $this->movements->syncMovements();
    }
    
}
