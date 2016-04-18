<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockHistory extends Application {

    function __construct()
    {
	parent::__construct();
                
    }
    /*
     * The main method of the stock history page. determines the stock for which
     * data is to be displayed, then calls the transaction() movement() methods
     * to display the relevent info.
     */    
    public function index()
	{
            $this->bsxSync();
            if($this->input->post('stockSelector') != NULL)
            {
                $selectedStock = $this->input->post('stockSelector');
            } else
            {
                 $selectedStock = $this->transactions->mostRecent();
            }
            
            $this->data['currentStockName'] = $this->stocks->nameFromCode($selectedStock);
            $this->data['currentStockCode'] = $selectedStock;
            $this->movements($selectedStock);
            $this->transactions($selectedStock);
            $this->stocklist();           
            $this->data['pagebody'] = 'stock_history';
            $this->render();
            
            
	}
    /*
     * passes an array of stock names and codes to the view. Used for the stock
     * select list
     */    
    public function stocklist()
        {
            $source = $this->stocks->all();
            foreach ($source as $record)
		{
                    $stocks[] = array('Name' => $record['Name'],
                        'Code' => $record['Code']);
		}
              $this->data['stocks'] = $stocks;
        }
    /*
     * gets the recent stock movements for the specified stock
     * Param: $stockCode - the stock to get history for
     */    
    private function movements($stockCode)
    {
        $source = $this->movements->allForStock($stockCode);
        if($source == NULL){
            $movements = array();   
        } 
        foreach ($source as $record)
        {
            $movements[] = array('DateTime' => $record['Datetime'],
                'Action' => $record['Action'],
                'Amount' => $record['Amount']);
        }
        $this->data['movements'] = $movements;
        $this->data['move_panel'] = $this->parser->parse('movement_history', $this->data, true);         
    }
     /*
     * gets the recent stock transactions for the specified stock
     * Param: $stockCode - the stock to get history for
     */     
    private function transactions($stockCode)
    {
        $source = $this->transactions->allForStock($stockCode);
        if($source == NULL){
            $transactions = array();   
        }

            foreach ($source as $record)
            {
                $transactions[] = array('DateTime' => $record['DateTime'],
                    'Player' => $record['Player'],
                    'Trans' => $record['Trans'],
                    'Quantity' => $record['Quantity']);
            }
            $this->data['transactions'] = $transactions;
            $this->data['trans_panel'] = $this->parser->parse('transaction_history', $this->data, true); 
        
    }
    //syncs with the bsxserver
    public function bsxSync()
    {
        if(time() - $this->session->userdata('lastRegistered') > 100 || $this->session->userdata('lastRegistered') == null)
        {
          $this->registerAgent('G02', 'theTeam', 'tuesday');  
          $this->stocks->syncStocks();
          $this->movements->syncMovements();
        }
    }
    //Registers a new Agent
    function registerAgent($teamId, $teamName, $password) {
        $params = array(
            'team' => $teamId,
            'name' => $teamName,
            'password' => $password,
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, BSX_URL . '/register');     
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $xml_resp = new SimpleXMLElement($response);
        curl_close($curl);

        $this->session->set_userdata('token', $xml_resp->token->__toString());
        $this->session->set_userdata('lastRegistered', time());
    } 
}
