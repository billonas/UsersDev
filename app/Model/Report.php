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
                   'rule'=>array('validateEmail'),
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
        ,
        'name'=>array(  
            'rule1'=>array(
                  'rule' => array('maxLength',25),
                  'alloEmpty'=>true,
                  'message'=>'Το ονομά σας δεν μπορεί να περιέχει πάνω από 25 χαρακτήρες'  
             )
            ,
            'rule2'=>array(
                  'rule'=>array('onlyLetters'),
                   'alloEmpty'=>true,
                  'message'=>'Το όνομα σας μπορεί να περιέχει μόνο γράμματα (λατινικά ή ελληνικά)'  
               )
        )
        ,
        'surname'=>array(  
               'rule1'=>array(
                  'rule' => array('maxLength',25),
                  'alloEmpty'=>true,
                  'message'=>'Το επώνυμο σας δεν μπορεί να περιέχει πάνω από 25 χαρακτήρες'  
             )
            ,
               'rule2'=>array(
                  'rule'=>array('onlyLetters'),
                  'alloEmpty'=>true,
                  'message'=>'Το επώνυμο σας μπορεί να περιέχει μόνο γράμματα (λατινικά ή ελληνικά)'  
             )
        )
        ,
        'phone_number'=>array(
            'rule1'=>array(
                  'rule' => array('maxLength',15),
                  'alloEmpty'=>true,
                  'message'=>'Το τηλεφωνό σας μπορεί να είναι μέχρι 15 ψηφία'  
             )
            ,
            'rule2'=>array(
                   'rule'=>array('onlyNumbers'),
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
		if(!$this->Specie->save($species)) return 0;
		$report['Report']['species_id'] = $this->Specie->id;
	   }
	   else $report['Report']['species_id'] = $species['Specie']['id'];
	}
        else if(!strcmp($report['Report']['state'], "confirmed")){
              return -1;
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
         $species = $this->find('all', array('fields' => 'Specie.scientific_name, Report.main_photo, Report.permissionUseMedia', 'conditions' => array('Report.state' => 'confirmed'), 'order' => array('Specie.scientific_name')));
         $size = count($species);
         $i = 0;
         $name = "";
	$index = 0;
         $falg = false;
         while($i < $size){
            if(strcmp($name, $species[$i]['Specie']['scientific_name'])){
		$name = $species[$i]['Specie']['scientific_name'];
                $index = $i;
                $flag = false;
            } 
            if(!$flag && $species[$i]['Report']['permissionUseMedia']  && is_file("img/".$species[$i]['Report']['main_photo'])){
               $species[$index]['Report']['main_photo'] =
		  $species[$i]['Report']['main_photo'];
              $flag = true;
            } 
            if($index < $i)
		unset($species[$i]);
            else if(!$flag) $species[$i]['Report']['main_photo'] = null;
            $i++;
         }
         return $species;
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
         $perioxes = $this->find('all', array('fields' => 'DISTINCT Report.area', 'conditions' => array('Report.state' => 'confirmed'), 'order' => array('Report.area')));
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

    function onlyLetters($check){
        $word = array_shift($check);
         //εάν password και confirm_password είναι ίσα 
         if (preg_match("/^[α-ωΑ-Ω\s]*$/", $word) || preg_match("/^[a-zA-Z\s]*$/", $word) || (strcmp($word , "")==0)) 
         {
            return true;
         }
         else
         {
            return false; 
         }
    }
    
    function onlyNumbers($check)
      {
         $phone = array_shift($check);
         if (preg_match("/^[0-9]+$/", $phone) || (strcmp($phone , "")==0)) 
         {
            return true;
         }
         else
         {
            return false; 
         }
      }
      
      function validateEmail($check)
      {
         $email = array_shift($check);
         if (preg_match("/^([a-z0-9\\+_\\-]+)(\\.[a-z0-9\\+_\\-]+)*@([a-z0-9\\-]+\\.)+[a-z]{2,6}$/ix", $email) || (strcmp($email , "")==0)) 
         {
            return true;
         }
         else
         {
            return false; 
         }
      }
    
}

?>
