<?php

class Transactions extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
    
     /*
     * returns all the rows from transactions table
     */
    function all()
    {      
           $this->db->order_by("DateTime", "desc");
           $query = $this->db->get('transactions');
           return $query->result_array();
    }
    /*
     * returns all the transactions for the specified stock
     */
    function allForStock($stock)
    {      $this->db->order_by("DateTime", "desc");
           $query = $this->db->get_where('transactions', array('Stock' => $stock));
           return $query->result_array();
    }
    
    /*
     * returns all the transactions for the specified player
     */
    function allForPlayer($playerName)
    {      $this->db->order_by("DateTime", "desc");
           $query = $this->db->get_where('transactions', array('Player' => $playerName));
           return $query->result_array();
    }
    
    /*
     * returns the Code of the stock with the most recent transaction
     */
    function mostRecent()
    {
        $this->db->select('Stock');
        $this->db->order_by("DateTime", "desc");
        $query = $this->db->get('transactions');
        return $query->row_array()['Stock'];
    }
    function transactionSums($playerName)
    {
        $this->db->select('Stock, Trans');
        $this->db->select_sum('Quantity');
        $this->db->where('Player', $playerName);
        $this->db->group_by(array('Stock', 'Trans')); 
        $query = $this->db->get('transactions');
        return $query->result_array();
    }
    function transactionSum($player, $stock, $transaction)
    {
        $this->db->select_sum('Quantity');
        $this->db->where('Player', $player);
        $this->db->where('Trans', $transaction);
        $this->db->where('Stock', $stock);
        $query = $this->db->get('transactions');
        return $query->row_array()['Quantity'];
    }

}