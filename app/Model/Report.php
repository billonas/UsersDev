<?php

/**
 * Report Model
 *
 * @author Kiddo, P.Loverdos
 */
class Report extends AppModel{
    var $name= 'Report';
    public $recursive = 3;
    public $belongsTo = array(
           'User' => array(
              'className' => 'User',
              'foreignKey' => 'observer'
            ),
            'Category' => array(
                'className' => 'Category',
                'foreignKey' => 'category_id'
            ),
	    'Specie' => array(
		 'className' => 'Specie',
		 'foreignKey' => 'species_id'
	    ),
            'Last_edited_by' => array(
                'className' => 'User',
                'foreignKey' => 'last_edited_by'
            )
     );
    
    public $validate = array(
        'date'=>array(  
               'rule1'=>array(
                   'rule'=>array('date'),
                   'alloEmpty'=>false,
                   'message'=>'Παρακαλούμε δώστε έγκυρη ημερομηνία παρακολούθησης'
             )
        ),

        'email'=>array(
            'rule1'=>array(
                   'rule'=>array('email', true),
                   'allowEmpty'=> true,
                   'message'=>'Παρακαλούμε δώστε έγκυρή διεύθυνση ηλεκτρονικού ταχυδρομείου'
             ) 
        ),
        
       'lat'=>array(  
               'rule1'=>array(
                   'rule'=>array('decimal'),
                   'alloEmpty'=>false,
                   'message'=>'Το γεωγραφικό πλάτος δεν έχει κανονική μορφή'
               ),
               'rule3'=>array(
                   'rule' => array('between', 2, 20),
                   'alloEmpty'=>false,
                   'message'=>'Το γεωγραφικό πλάτος δεν μπορεί να έχει παραπάνω από 16 αριθμητικά ψηφία'  
               )
            
         ),
        'lng'=>array(  
               'rule1'=>array(
                   'rule'=>array('decimal'),
                   'message'=>'Το γεωγραφικό μήκος δεν έχει κανονική μορφή'
               ),
               'rule3'=>array(
                   'rule' => array('between', 2, 20),
                   'message'=>'Το γεωγραφικό μήκος δεν μπορεί να έχει παραπάνω από 16 αριθμητικά ψηφία'  
               )
         ),
        'name'=>array(  
               'rule1'=>array(
                  'rule' => array('between', 1, 25),
                   'alloEmpty'=>true,
                  'message'=>'Το όνομα σας δεν μπορεί να περιέχει πάνω από 25 χαρακτήρες'  
               ),
               'rule2'=>array(
                  'rule'=>'alphaNumeric',
                   'alloEmpty'=>true,
                  'message'=>'Το όνομα σας μπορεί να περιέχει μόνο γράμματα'  
               )
        ),
        'surname'=>array(  
               'rule1'=>array(
                  'rule' => array('between', 1, 25),
                  'alloEmpty'=>true,
                  'message'=>'Το επώνυμο σας δεν μπορεί να περιέχει πάνω από 25 χαρακτήρες'  
             ),
               'rule2'=>array(
                  'rule'=>'alphaNumeric',
                  'alloEmpty'=>true,
                  'message'=>'Το επώνυμο σας μπορεί να περιέχει μόνο γράμματα'  
             )
        ),
        'phone_number'=>array(  
               'rule1'=>array(
                   'rule'=>array('numeric'),
                   'alloEmpty'=>true,
                   'message'=>'Το τηλέφωνο σας μπορεί να περιέχει μόνο αριθμούς  χωρίς κενά'
             )
        )
    );
    
     function saveReport($report){
	if(!empty($report['Specie']['scientific_name'])){
           $species = $this->Specie->findByScientific_name($report['Specie']['scientific_name']);
	   if(empty($species)) 
	   {
		$species['Specie']['scientific_name'] = $report['Specie']['scientific_name'];
		$this->Specie->save($species);
		$species = $this->Specie->findByScientific_name($report['Specie']['scientific_name']);
	   }
	   $report['Report']['species_id'] = $species['Specie']['id'];
	}
	$this->save($report);
     }

     function findUserReports($userId){
         $return = false;
         
         $conditions = array(
             'Report.observer'=>$userId,
          );
         //βρες αν υπάρχει ο χρήστης με το συγκεκριμένο username
         $reports = $this->find('all', array('conditions'=>$conditions));
         if(!empty($reports))
         {
            $return=$reports;
         }
         
         return $return;

    }

    function findReportsSpecies() {
         $species = $this->Specie->find('all');
	if(empty($species)) $s = array();
          $j = 0;
	 foreach ($species as $specie){
		$sId = $specie['Specie']['id'];
                $conditions = array(
			'Report.species_id' => $sId
                );
		$reports = $this->find('all', array(
			'conditions'=>	$conditions));
		$i = 0;
		if(empty($reports)) $r = array();
		foreach ($reports as $report){
			$r["$i"] = $report['Report'];
			$i++;
		}
		$perioxes = $this->query("SELECT perioxh FROM reports WHERE species_id = $sId "); 
		$i = 0;
		if(empty($perioxes)) $p = array();
		foreach ($perioxes as $perioxh){
		 $p["$i"] = $perioxh['reports']['perioxh'];
                  $i++;
		}
		$s["$j"] = array($specie['Specie']['scientific_name'],
				$r, $p);
		$j++;
	 }
         return $s;
    }
	
    function findPerioxesSpecies() {
          $perioxes = $this->query("SELECT perioxh FROM reports");
	  $i = 0;
	  if(empty($perioxes)) $pe = array();
	  foreach ($perioxes as $p){
		$per = $p['reports']['perioxh'];
		$pe["$i"][0] = $per;		
		$species = $this->query("SELECT scientific_name FROM species, reports WHERE species_id = species.id AND perioxh = '$per'");
		$j = 0;
		if(empty($species)) $pe["$i"][1] = array();
		foreach($species as $sp){
	          $pe["$i"][1]["$j"] = $sp['species']['scientific_name']; 
		    $j++;
		}
		$reports = $this->query("SELECT * FROM reports WHERE perioxh = '$per'");
		$j = 0;
		foreach($reports as $report){
		   $pe["$i"][2]["$j"] = $report['reports'];
		   $j++;
		}
		$i++;
	  }
	  return $pe;
    }
    
}

?>
