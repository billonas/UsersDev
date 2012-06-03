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
}

?>
