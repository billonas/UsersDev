<?php

class Specie extends AppModel{
      var $name = 'Specie';
      public $hasMany = array(
	'Report' => array(
		'className' => 'Report',
		'foreignKey' => 'species_id'
		)
	);
}

?>
