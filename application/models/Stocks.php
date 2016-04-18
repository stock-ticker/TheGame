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
     

    //updates local db with latest stock info from BSX server
    function syncStocks() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, BSX_URL . '/data/stocks');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);
        $csv = str_getcsv($output, "\n");
        //$header = str_getcsv($csv[0], ",");

        $this->db->where('Code !=', 'NULL');
        $this->db->delete('stocks');
        // loop through csv to get array
        for ($i = 1; $i < count($csv); $i++) {
            $stock = str_getcsv($csv[$i], ",");
            
            $data = array(
                'Code' => $stock[0],
                'Name' => $stock[1],
                'Category' => $stock[2],
                'Value' => $stock[3]
            );
            $this->db->insert('stocks', $data); 
        }
    }
    
    //returns all stock names as an array 
     function names(){
         $this->db->order_by("Name", "desc");
         $this->db->select('Name');
         $query = $this->db->get('stocks');
         return $query->result_array();
     }
     
     //gets the name of the stock from its code
     function nameFromCode($stock)
     {
        $this->db->select('Name');
        $query = $this->db->get_where('stocks', array('Code' => $stock));
        return $query->row_array()['Name'];
     }
  //gets the value of the stock from its code
     function valueFromCode($stock)
     {
        $this->db->select('Value');
        $query = $this->db->get_where('stocks', array('Code' => $stock));
        return $query->row_array()['Value'];
     }

}