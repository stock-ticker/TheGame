<?php

class Holdings extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }
    
     /*
     * returns all the rows from transactions table
     */
    function all()
    {      
           $this->db->order_by("DateTime", "desc");
           $query = $this->db->get('holdings');
           return $query->result_array();
    }
    
    /*
     * returns all the transactions for the specified player
     */
    function allForPlayer($playerName)        
    {      
        $query = $this->db->select('*')
                    ->select_sum('Quantity')
                    ->from('stocks')
                    ->join('holdings', 'stocks.Code = holdings.Stock', ' left outer')
                    ->where('Player', $playerName)
                    ->or_where('Player', NULL)
                    ->order_by("Quantity", "desc")
                    ->group_by("Code")
                    ->get();
        
        return $query->result_array();
        
    }
    
    /*
     * returns the Code of the stock with the most recent transaction
     */
    
    function mostRecent()
    {
        $this->db->select('Stock');
        $this->db->order_by("DateTime", "desc");
        $query = $this->db->get('transactions');
        return $query->row_array()['Stock'];
    }
    function transactionSums($playerName)
    {
        $this->db->select('Stock, Trans');
        $this->db->select_sum('Quantity');
        $this->db->where('Player', $playerName);
        $this->db->group_by(array('Stock', 'Trans')); 
        $query = $this->db->get('transactions');
        return $query->result_array();
    }
    function transactionSum($player, $stock, $transaction)
    {
        $this->db->select_sum('Quantity');
        $this->db->where('Player', $player);
        $this->db->where('Trans', $transaction);
        $this->db->where('Stock', $stock);
        $query = $this->db->get('transactions');
        return $query->row_array()['Quantity'];
    }
    function addStock($player, $stock, $quantity, $certificate)
    {
       $data = array(
            'Player' => $player,
            'Stock' => $stock,
            'Quantity' => $quantity,
            'Certificate' => $certificate
        );
        $this->db->insert('holdings', $data);  
    }
    
    //get the certificate for stocks held by the player
    function getCertificate($player, $stock)
    {
        $this->db->select('Certificate');
        $this->db->where('Player', $player); 
        $this->db->where('Stock', $stock); 
        $query = $this->db->get('holdings');
        return $query->row_array()['Certificate'];
    }
    
    //delete held stocks with certificate
    function deleteWithCertificate($certificate)
    {
        $this->db->where('Certificate', $certificate);
        $this->db->delete('holdings'); 
    }

}