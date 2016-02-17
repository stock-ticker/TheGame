<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Stocks extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    //return all images, descending order by post date
    function all()
    {   
           $this->db->order_by("Name", "desc");
           $query = $this->db->get('stocks');
           return $query->result_array();
           
         return $query->result_array();
    }
}