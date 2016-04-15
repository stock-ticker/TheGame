<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageagent extends Application {

    public function index()
    {
        $this->data['pagebody'] = 'management';  
       // $this->bsxSync()
        echo 'TOKEN: ' . $this->session->userdata('token');
        echo 'USERNAME: ' . $this->session->userdata('userName');
        $this->buy('BP', 10);
        $this->render();
    }   
    /*
    public function bsxSync()
    {
       // $this->load->helper('bsxserver');
        registerAgent('G02', 'theTeam', 'tuesday');
        $this->gamestate->getState()['stateDesc'];
        $this->stocks->syncStocks();
        $this->movements->syncMovements();
    }
    */
    
    function buy($stock, $quantity)
    {
        $url = 'http://bsx.jlparry.com/buy';
       
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://bsx.jlparry.com/buy");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
         http_build_query(array('team' => 'g02',
                                'token' => $this->session->userdata('token'),
                                'player' => $this->session->userdata('userName'),
                                'stock' => $stock,
                                'quantity' => $quantity)));
            //"team=g02&token=$token&player=$player&stock=$stock&quantity=$quantity");

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);
echo $server_output;
// further processing ....
if ($server_output == "OK") {  } else {  }
    }

    
}
