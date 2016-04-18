<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Model for the management of player input to the BSX server
 *
 * @author Sean
 */
class Gameplay extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
        public function getCash($playerName)
    {
       $this->db->select('Cash');
       $query = $this->db->get_where('users', array('Name' => $playerName));
       return $query->row_array()['Cash']; 
    }
    
    //Methods needed
    public function getHoldings($playerName){
        $query = $this->db->select('stocks.code', 'stocks.value', 'holdings.quantity', 'holdings.quantity * stocks.value AS Equity')
                ->from('stocks')
                ->join('holdings', 'stocks.Code = holdings.stock', 'left outer')
                ->where('Player', $playerName)
                ->order_by("Value", "desc")
                ->get();
                return $query->result_array();
                }
    //1: Method to list available stocks to be traded from the server
    
    public function getMarketboard(){
        $query = $this->db->select('name','code','value','code AS radio')
                ->from('stocks')
                ->order_by("Value", "desc")
                ->get();
                return $query->result_array();
                
    }
    //2: Method to purchase stock
    
    //3: Method to sell stock
    
    
    //5: Method to parse player assets
    
    
}
