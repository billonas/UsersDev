<?php

/**
 * Analyst Model
 *
 * @author BLTeam, DBTeam
 */
class Analyst extends AppModel{
    var $name= 'Analyst';
    public $belongsTo = array(
        'Category1' => array(
           'className' => 'Category',
       'foreignKey' => 'category1'
         ),
        'Category2' => array(
            'className' => 'Category',
            'foreignKey' => 'category2'
         )
    );
    public $hasOne = array(
	'User' => array(
	    'className' => 'User',
	    'foreignKey' => 'id',
	    'dependent' => true
        )
    );
    //put your code here
}

?>
