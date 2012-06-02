<?php

  class Category extends AppModel{
       public $name ='Category';
       public $hasOne =array(
	'Analyst1' => array(
	    'className' => 'Analyst',
	    'foreignKey' => 'category1'
        ),
        'Analyst2' => array(
	    'className' => 'Analyst',
	    'foreignKey' => 'category2'
        )
       );
       public $hasMany = array(
          'Report' => array(
             'className' => 'Report',
             'foreignKey' => 'category_id',
             'order' => 'Report.created DESC'
          )
      );
  }

?>
