<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Transactions extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    //return all images, descending order by post date
    function all()
    {      
           $this->db->order_by("DateTime", "desc");
           $query = $this->db->get('transactions');
           return $query->result_array();
    }
    
    function allForStock($stock)
    {      $this->db->order_by("DateTime", "desc");
           $query = $this->db->get_where('transactions', array('Stock' => $stock));
           return $query->result_array();
    }
    function mostRecent()
    {
        $this->db->select('Stock');
        $this->db->order_by("DateTime", "desc");
        $query = $this->db->get('transactions');
       // return = array('DateTime' => $record['DateTime'],
        return $query->row_array()['Stock'];
    }
}