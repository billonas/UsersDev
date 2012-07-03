<?php
/**
 * New Model
 *
 * @author Nick, DBTeam
 */

class News extends AppModel{
    
     public $name = 'New';
     
     public $validate = array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'body' => array(
            'rule' => 'notEmpty'
        )
    );
    
    public function getLast(){
         return $this->find('first', array('order' => array('created DESC')));
    }
}

?>
