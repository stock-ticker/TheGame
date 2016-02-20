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
    
    //return all stocks, descending order by post name
    function all()
    {   
           $this->db->order_by("Name", "desc");
           $query = $this->db->get('stocks');
           return $query->result_array();
    }

     function names(){
         $this->db->order_by("Name", "desc");
         $this->db->select('Name');
         $query = $this->db->get('stocks');
         return $query->result_array();
     }
     
     function nameFromCode($stock)
     {
        $this->db->select('Name');
        $query = $this->db->get_where('stocks', array('Code' => $stock));
        return $query->row_array()['Name'];
     }
     function holdings($playerName)
     {
        $this->db->select('*');
        $this->db->from('blogs');
        $this->db->join('comments', 'comments.id = blogs.id');
        $query = $this->db->get();
        return $query->result_array();
     }

}