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
//        ,
//
//        'email'=>array(
//            'rule1'=>array(
//                   'rule'=>array('email', true),
//                   'allowEmpty'=> true,
//                   'message'=>'Παρακαλούμε δώστε έγκυρή διεύθυνση ηλεκτρονικού ταχυδρομείου'
//             ) 
//        ), 
       'lat'=>array(  
               'rule1'=>array(
                   'rule'=>array('decimal'),
                   'alloEmpty'=>false,
                   'message'=>'Το γεωγραφικό πλάτος δεν έχει κανονική μορφή'
               ),
               'rule3'=>array(
                   'rule' => array('maxLength',20),
                   'alloEmpty'=>false,
                   'message'=>'Το γεωγραφικό πλάτος δεν μπορεί να έχει παραπάνω από 16 αριθμητικά ψηφία'  
               )
            
         ),
        'lng'=>array(  
               'rule1'=>array(
                   'rule'=>array('decimal'),
                   'alloEmpty'=>false,
                   'message'=>'Το γεωγραφικό μήκος δεν έχει κανονική μορφή'
               ),
               'rule3'=>array(
                   'rule' => array('maxLength',20),
                   'alloEmpty'=>false,
                   'message'=>'Το γεωγραφικό μήκος δεν μπορεί να έχει παραπάνω από 16 αριθμητικά ψηφία'  
               )
         )
//        ,
//        'name'=>array(  
//               'rule1'=>array(
//                  'rule' => array('maxLength',25),
//                   'alloEmpty'=>true,
//                  'message'=>'Το όνομα σας δεν μπορεί να περιέχει πάνω από 25 χαρακτήρες'  
//               )
//            ,
//               'rule2'=>array(
//                  'rule'=>'alphaNumeric',
//                   'alloEmpty'=>true,
//                  'message'=>'Το όνομα σας μπορεί να περιέχει μόνο γράμματα'  
//               )
//        )
//            ,
//        'surname'=>array(  
//               'rule1'=>array(
//                  'rule' => array('maxLength',25),
//                  'alloEmpty'=>true,
//                  'message'=>'Το επώνυμο σας δεν μπορεί να περιέχει πάνω από 25 χαρακτήρες'  
//             )
//            ,
//               'rule2'=>array(
//                  'rule'=>'alphaNumeric',
//                  'alloEmpty'=>true,
//                  'message'=>'Το επώνυμο σας μπορεί να περιέχει μόνο γράμματα'  
//             )
//        )
//            ,
//        'phone_number'=>array(  
//               'rule1'=>array(
//                   'rule'=>array('numeric'),
//                   'alloEmpty'=>true,
//                   'message'=>'Το τηλέφωνο σας μπορεί να περιέχει μόνο αριθμούς  χωρίς κενά'
//             )
//        )
    );
    
     function saveReport($report){
	if(!empty($report['Specie']['scientific_name'])){
           $species = $this->Specie->findByScientific_name($report['Specie']['scientific_name']);
	   if(empty($species)) 
	   {
		$species['Specie']['scientific_name'] = $report['Specie']['scientific_name'];
		if(!$this->Specie->save($species)) return 0;
		$report['Report']['species_id'] = $this->Specie->id;
	   }
	   else $report['Report']['species_id'] = $species['Specie']['id'];
	}
	return $this->save($report);
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

   /* function findSpecies(){
         return $this->Specie->find('all');
    }
*/
   function findSpecies(){
         return $this->find('all', array('fields' => 'DISTINCT Specie.scientific_name', 'conditions' => array('Report.state' => 'confirmed')));
    }

    function findSpeciesReports($species) {
                $conditions = array(
			'Specie.scientific_name' => $species,
			'Report.state' => 'confirmed'
                );
		return $this->find('all', array(
			'conditions'=>	$conditions));
    }
	
    function findSpeciesAreas() {
        $reports = $this->find('all', array('conditions' =>
		array('Report.state' => 'confirmed')));
        $s = array();
	foreach ($reports as $report){
                $species = $report['Specie']['scientific_name'];
 		$area = $report['Report']['area'];
                if(!array_key_exists($species, $s))
                   $s[$species] = array();
                array_push($s[$species], $area);
	 }
         foreach(array_keys($s) as $k){
             $s[$k] = array_unique($s[$k]);
         }
         return $s;
    }

    function findAreas(){
         $perioxes = $this->find('all', array('fields' => 'DISTINCT Report.area', 'conditions' => array('Report.state' => 'confirmed')));
         return $perioxes;
    }

    function findAreasSpecies() {	  
	  $pe = array();
          $reports = $this->find('all', array('conditions' =>
		array('Report.state' => 'confirmed')));
          foreach ($reports as $report){
              $species = $report['Specie']['scientific_name'];
 	      $area = $report['Report']['area'];
              if(!array_key_exists($area, $pe))
                 $pe[$area] = array();
              array_push($pe[$area], $species);
          }
          foreach(array_keys($pe) as $key)
             $pe[$key] = array_unique($pe[$key]);
          return $pe;
    }
    
    function findAreasReports($area) {
        $conditions = array(
			'Report.area' => $area,
			'Report.state' => 'confirmed'
                );
	return $this->find('all', array(
			'conditions'=>	$conditions));
    }

    /*function notifyCategorizedReport($reportId = null,$categoryId = null){
        
        App::uses('CakeEmail', 'Network/Email');
        $report = $this->findById($reportId);
        if($report['Report']['category_id'] != $categoryId)
        {
            $analysts1 = ClassRegistry::init('Analyst')->find('all', array('conditions' => array('Analyst.category1' => $categoryId)));
            $analysts2 = ClassRegistry::init('Analyst')->find('all', array('conditions' => array('Analyst.category2' => $categoryId)));
            foreach($analysts1 as $analyst)
            {
                $email = new CakeEmail();
                $email->config('smtp');
                $email->from(array('no-reply@elke8e.com' => 'Elkethe-Admin'));
                $email->to($analyst['User']['email']);
                $email->subject('New report');
                $email->transport('Smtp');
                $email->send('New report for you: http://localhost/UsersDev/reports/edit/'.$reportId);
            }
            return true;
        }
        else return false;
    }*/
    
}

?>
