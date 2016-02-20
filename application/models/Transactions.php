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
     * returns all the rows from transactions table for the specified stock
     */
    function allForStock($stock)
    {      $this->db->order_by("DateTime", "desc");
           $query = $this->db->get_where('transactions', array('Stock' => $stock));
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
}