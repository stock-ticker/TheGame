<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Players extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    //return all images, descending order by post date
    function all()
    { 
           $this->db->order_by("Player", "desc");
           $query = $this->db->get('players');
           return $query->result_array();
    }
}