<?php

/**
 * Description of UsersController
 *
 * @author Billonas
 */
class IndexController extends AppController{
  
  
  
	public $helpers = array('Html', 'Session','Js'); //To 'js' prepei na ginei 'Js' gia na douleuei
    function index()
    {
      $this->layout = 'template';  
    }
	public function report() {

	}
    
}

?>
