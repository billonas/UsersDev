<?php

/**
 * Analyst Model
 *
 * @author BLTeam, DBTeam
 */
class Analyst extends AppModel{
    var $name= 'Analyst';
    public $recursive = 3;
    public $belongsTo = array(
        'Category1' => array(
           'className' => 'Category',
       'foreignKey' => 'category1'
         ),
        'Category2' => array(
            'className' => 'Category',
            'foreignKey' => 'category2'
         ),
	'User' => array(
	    'className' => 'User',
	    'foreignKey' => 'id'
        )
    );
    
     public function saveAnalyst($analyst){ 
        $this->User->save($analyst, false);
        $analyst['Analyst']['id'] = $this->User->id;
        return $this->save($analyst);
    }
}

?>
