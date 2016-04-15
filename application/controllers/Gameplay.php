<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Controller for the Gameplay elements of StockTicker.
 *  Facilitates buying/selling of stock.
 *
 * @author Sean
 */
class Gameplay extends Application{
    
      function __construct()
        {
          parent::__construct();
        }
        
        public function index()
        {
            $this->data['pagebody'] = 'gameplay';
            //$this->data['player'] =
            //$this->data['equity'] =
            //$this->data['cash] =
            //$this->data['holdings] =
            //$this->data['marketboard'
            $this->render();
        }
        
        
}
