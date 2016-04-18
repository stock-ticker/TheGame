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
    
    function syncMovements() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, BSX_URL . '/data/movement');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);
        $csv = str_getcsv($output, "\n");
        $this->db->where('Code !=', 'NULL');
        $this->db->delete('movements');
        // loop through csv to get array
        $rows = 10;
        if (count($csv) < $rows){$rows = count($csv);}
        for ($i = 1; $i < count($csv); $i++) {
            $move = str_getcsv($csv[$i], ",");
            
            $data = array(
                'seq' => $move[0],
                'Datetime' => gmdate("Y.m.d-H:i:s", $move[1]),
                'Code' => $move[2],
                'Action' => $move[3],
                'Amount' => $move[4]
            );
            $this->db->insert('movements', $data); 
        }
    }
}