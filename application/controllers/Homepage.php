
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends Application {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->data['pagebody'] = 'homepage'; 
                $this->data['players_panel'] = $this->players();
                $this->data['stocks_panel'] = $this->stocks();
                $this->render();
	}
        
        function stocks() {
            $source = $this->stocks->all();
            foreach ($source as $record)
            {
                $stocks[] = array('Name' => $record['Name'],
                                  'Code' => $record['Code'],
                                  'Category' => $record['Category'],
                                  'Value' => $record['Value']);
            }
            return $stocks;
        }
        
        function players() {
            $source = $this->players->all();
            foreach ($source as $record) 
            {
                $players[] = array('Player' => $record['Player'],
                                   'Cash' => $record['Cash']);
            }
            return $players;
        }
        

}
