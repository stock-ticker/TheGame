<?php

class Movements extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * returns all the rows from movements table
     */
    function all()
    {
        $this->db->order_by("DateTime", "desc");
        $query = $this->db->get('movements');
        return $query->result_array();
    }
    
    /*
     * returns all the rows from movements table for the specified stock
     */
    function allForStock($stock)
    {   
        $this->db->order_by("DateTime", "desc");  
        $query = $this->db->get_where('movements', array('code' => $stock));
        return $query->result_array();
    }
}