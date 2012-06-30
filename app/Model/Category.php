<?php

  class Category extends AppModel{
       public $name ='Category';
       public $hasMany =array(
	'Analyst1' => array(
	    'className' => 'Analyst',
	    'foreignKey' => 'category1'
        ),
        'Analyst2' => array(
	    'className' => 'Analyst',
	    'foreignKey' => 'category2'
        ),
        'Report' => array(
             'className' => 'Report',
             'foreignKey' => 'category_id',
             'order' => 'Report.created DESC'
        )
      );
  }

?>
