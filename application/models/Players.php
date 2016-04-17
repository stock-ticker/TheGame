<?php



class Players extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
    /*
    //return all players, descending order by player name
    function all()
    { 
           $this->db->order_by("Player", "desc");
           $query = $this->db->get('players');
           return $query->result_array();
    }
    

    function cashForPlayer($playerName)
     {
        $this->db->select('Cash');
        $query = $this->db->get_where('players', array('Player' => $playerName));
        return $query->row_array()['Cash'];
     }
     
     //add player

     */
}