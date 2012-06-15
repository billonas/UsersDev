<?php

/**
 * Description of AdminController
 * CAUTION: Κρατάω επιφύλαξη, μήπως χρειαστεί να μετανομαστεί σε AnalystsController λόγω CakePHP
 * @author Rodger
 */
class AnalystsController extends AppController{
    var $name = 'Analyst';
    public $helpers = array('Html', 'Form');
    //put your code here
    
    function create()
    {

    }
       
    function beforeFilter() 
   {

      if($this->Session->check('report')){
            $this->Session->delete('report');
        }
        if($this->Session->check('report_completed')){
            $this->Session->delete('report_completed');
        }
        if($this->Session->check('uploaded1')){
            $this->Session->delete('uploaded1');
        }
        if($this->Session->check('uploaded2')){
            $this->Session->delete('uploaded2');
        }
        if($this->Session->check('uploaded3')){
            $this->Session->delete('uploaded3');
          }
          if($this->Session->check('uploaded4')){
            $this->Session->delete('uploaded4');
          }
   }
    
    function update()
    {
      
    }
  
    function show()
    {
      
    }
}

?>
