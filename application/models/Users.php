<?php

class Users extends MY_Model {
    public function __construct() {
    parent::__construct('users', 'id');
    }
    
    //returns the amount of cash the player currently has
    public function getCash($playerName)
    {
       $this->db->select('Cash');
       $query = $this->db->get_where('users', array('Name' => $playerName));
       return $query->row_array()['Cash']; 
    }
    
    //subtracts the specified mount from the players cash
    public function subtractCash($playerName, $amount)
    {
        $data = array(
               'Cash' => $this->getCash($playerName) - $amount
            );     
        
        $this->db->where('name', $playerName);
        $this->db->update('users', $data); 

    }

}