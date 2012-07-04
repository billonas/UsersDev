<?php

class Specie extends AppModel{
      var $name = 'Specie';
      public $hasMany = array(
	'Report' => array(
		'className' => 'Report',
		'foreignKey' => 'species_id'
		)
	);
      
//      public $validate = array(
//        'scientific_name'=>array(  
//            'rule1'=>array(
//                  'rule' => array('maxLength',35),
//                  'alloEmpty'=>true,
//                  'message'=>'Το ονομά σας δεν μπορεί να περιέχει πάνω από 35 χαρακτήρες'  
//             )
//            ,
//            'rule2'=>array(
//                  'rule'=>array('onlyLetters'),
//                   'alloEmpty'=>true,
//                  'message'=>'Το όνομα σας μπορεί να περιέχει μόνο γράμματα (λατινικά ή ελληνικά)'  
//               )
//        )
//    );
//      
//    function onlyLetters($check){
//        $word = array_shift($check);
//         //εάν password και confirm_password είναι ίσα 
//         if (preg_match("/^[α-ωΑ-Ω\s]*$/", $word) || preg_match("/^[a-zA-Z\s]*$/", $word) || (strcmp($word , "")==0)) 
//         {
//            return true;
//         }
//         else
//         {
//            return false; 
//         }
//    }  
}

?>
