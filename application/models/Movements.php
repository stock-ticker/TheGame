<?php

class Movements extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    function all()
    {
         //  $this->db->order_by("Name", "desc");
        $query = $this->db->get('movements');
        return $query->result_array();
    }
    
    function allForStock($stock)
    {      
        $query = $this->db->get_where('movements', array('code' => $stock));
        return $query->result_array();
    }
}