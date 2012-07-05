<?php

/**
 * Description of HotSpeciesController
 *
 * @author Nick
 */
class HotSpeciesController extends AppController{
    var $name = 'HotSpecies';
    public $helpers = array('Html', 'Form','Session');
    public $components = array('JqImgcrop', 'Image');
    var $uses = array('HotSpecie'); 
    //to uses edo xreiazetai epeidi xoris tin xrisi tou uses to cakephp psaxnei to antistoixo model
    //to opoio stin sigekrimeni periptosi den vriskei afou to species den exei eniko(i leksi specie den iparxei)
      
  /*
   *  create method is used to create properly a new hot species and save it's data
   */    
    function create() {
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if (!empty($this->data)) {
            /*upload main photo*/
            if(!empty($this->data['HotSpecie']['image']['tmp_name'])){
                $add1=0;
                $add2=0;
                $add3=0;
                /* Check if input file's type is a valid image */
                $res = $this->Image->checkImage($this->data['HotSpecie']['image']);
            	if($res < 0){
                    $this->Session->setFlash('Παρακαλώ εισάγετε μία φωτογραφία','flash_bad');
                    $this->redirect(array('action'=>'create'), null, true);
                }
                else if(!$res){
  			$this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική φωτογραφία','flash_bad');
                        $this->redirect(array('action'=>'create'), null, true);
                }
                /* Rename image file and save to temp directory */
    	        $this->request->data['HotSpecie']['image']['name'] = $this->Image->tmpRename($this->request->data['HotSpecie']['image']);
                $uploaded = $this->JqImgcrop->uploadImage($this->data['HotSpecie']['image'], 'img/temporary/', ''); 
                $this->request->data['HotSpecie']['main_photo'] = $uploaded['imagePath'];
                $this->request->data['HotSpecie']['priority'] = $this->HotSpecie->find('count')+1;
                /* Upload additional photos,rename them and save them to temp directory*/
                for($i=1;$i<4;$i++){
                if(!empty($this->data['HotSpecie']['image'.$i]['tmp_name'])){
                $res = $this->Image->checkImage($this->data['HotSpecie']['image'.$i]);
            	if($res < 0){
                    $this->Session->setFlash('Παρακαλώ εισάγετε μία φωτογραφία για την επιπλέον φώτο'.$i,'flash_bad');
                    $this->redirect(array('action'=>'create'), null, true);
                }
                else if(!$res){
  			$this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική φωτογραφία για την επιπλέον φώτο'.$i,'flash_bad');
                        $this->redirect(array('action'=>'create'), null, true);
                }
    	        $this->request->data['HotSpecie']['image'.$i]['name'] = $this->Image->tmpRename($this->request->data['HotSpecie']['image'.$i]);
                $uploaded = $this->JqImgcrop->uploadImage($this->data['HotSpecie']['image'.$i], 'img/temporary/', ''); 
                $this->request->data['HotSpecie']['additional_photo'.$i] = $uploaded['imagePath'];
                if($i==1)$add1 = 1;
                if($i==2)$add2 = 1;
                if($i==3)$add3 = 1;
                }
                else break;
                }
                $this->HotSpecie->create();
                if ($this->HotSpecie->save($this->data['HotSpecie'])) {
                    /*Move main photo to hotspecies images directory */
                    $ret = $this->Image->mvSubImg($this->HotSpecie, $this->data['HotSpecie']['main_photo'], "hotspecies", "main_photo");
                    if(!$ret){
                            $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας",'flash_bad');
                            $this->redirect(array('action'=>'create'), null, true);
                            }
                    $k=0;        
                    if($add1 == 1)$k=2;
                    if($add2 == 1)$k=3;
                    if($add3 == 1)$k=4;
                    for($i=1;$i<$k;$i++)
                    {
                        switch ($i)
                        {
                        case 1:
                        $ext = 'a';
                        break;    
                        case 2:
                        $ext = 'b';
                        break;
                        case 3:
                        $ext = 'c';
                        break;
                        }
                        /*Move additional photos to hotspecies images directory */
                        $ret = $this->Image->mvSubImg($this->HotSpecie, $this->data['HotSpecie']['additional_photo'.$i], "hotspecies","additional_photo".$i,$ext);
                        if(!$ret){
                            $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας για την επιπλέον φώτο".$i,'flash_bad');
                            $this->redirect(array('action'=>'create'), null, true);
                        }
                    }
                    $this->Session->setFlash('Το είδος κατατέθηκε επιτυχώς','flash_good');
                    $this->redirect(array('action'=>'show'), null, true);
                }
                else {
                    $this->Session->setFlash('Το είδος δεν κατατέθηκε επιτυχώς.Προσπαθήστε ξανά.','flash_bad');
                    }
            }
            else{
                $this->Session->setFlash('Παρακαλώ εισάγεται μία φωτογραφία','flash_bad');
                $this->redirect(array('action'=>'create'), null, true);
            }
    }
    }
    }
    
  /*
   *  update method is used to update hot species data by hyperanalyst
   */    
    function update($id = null) {
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if ($id == null) {
            $this->Session->setFlash('Λάθος κωδικός είδους','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        if (empty($this->data)) {
            /* Find hotspecies */
            $this->data = $this->HotSpecie->read(null, $id);
            $hotspecie = $this->data;
            $this->set('hotspecie',$hotspecie);
        } else {
            /* Save hotspecies */
            if ($this->HotSpecie->save($this->data)) {
                $this->Session->setFlash('Τα νέα στοιχεία κατατέθηκαν επιτυχώς','flash_good');
                return $this->redirect(array('action'=>'show'), null, true);
            } else {
                $this->Session->setFlash('Τα νέα στοιχεία δεν κατατέθηκαν επιτυχώς.Προσπαθήστε ξανά.','flash_bad');
                $this->data = $this->HotSpecie->read(null, $id);
                $hotspecie = $this->data;
                $this->set('hotspecie',$hotspecie);
            }
        }
        }
    }
    
  /*
   *  delete method is used to delete hot species data by hyperanalyst
   */    
    function delete($id = null) {
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if ($id == null) {
            $this->Session->setFlash('Λάθος κωδικός είδους','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        /* Delete hotspecies images*/
        $this->Image->dlImg($this->HotSpecie, $id, 'HotSpecie');
        /* Delete hotspecies */
        if ($this->HotSpecie->deleteHot($id)) {
            $this->Session->setFlash('Το είδος με κωδικό #'.$id.' διαγράφηκε επιτυχώς','flash_good');
            $this->redirect(array('action'=>'show'), null, true);
        }
        }
    }
    
  /*
   *  show method is used to present all hot species to hyperanalysts
   */
    function show() {
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        /* Find all hotspecies ordered by priority */
        $this->set('hotspecies', $this->HotSpecie->find('all', array('order'=>'HotSpecie.priority')));
        }     
    }
    
  /*
   *  view method is used to present all hot species to users
   */
    function view() {
        /* Find all hotspecies ordered by priority */
        $this->set('hotspecies', $this->HotSpecie->find('all', array('order'=>'HotSpecie.priority')));
    }
    
    
  /*
   *  setMainPhoto method is used to set a hot species' additional photo as main
   */
    function setMainPhoto($id = null , $num = null){
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        /* num should be between 1 and 3*/
        if (($id == null) || ($num == null) || ($num > 3) || ($num < 1)) { 
            $this->Session->setFlash('Λάθος κωδικός είδους ή φωτογραφίας','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        else{
            /* Find hotspecies*/
            $hotspecies = $this->HotSpecie->findById($id);
            /* Switch photo's extension*/
            switch ($num)
            {
            case 1:
              $ext = 'a';
              break;    
            case 2:
              $ext = 'b';
              break;
            case 3:
              $ext = 'c';
              break;
            }   
            $photo = 'additional_photo'.$num;
            $additional = $hotspecies['HotSpecie'][$photo];
            if($additional == ''){//photo does not exist
                $this->Session->setFlash('Η φωτογραφία δεν υπάρχει','flash_bad');
                $this->redirect(array('action'=>'update',$id), null, true);
            }
            /* Swap main and additional photo */
            $this->Image->changePriority($additional, $hotspecies, $ext,$num,$this->HotSpecie);
            $this->Session->setFlash('Η ενέργεια εκτελέστηκε επιτυχώς','flash_good');
            $this->redirect(array('action'=>'update',$id));
        }
        }
    }
    
  /*
   *  deleteImg method is used to delete a hot species' additional photo
   */
    function deleteImg($id = null , $num = null){
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        /* num should be between 1 and 3*/
        if (($id == null) || ($num == null) || ($num > 3) || ($num < 1)) {
            $this->Session->setFlash('Λάθος κωδικός είδους ή φωτογραφίας','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        else{
            /* Find hotspecies*/
            $hotspecies = $this->HotSpecie->findById($id);
            $photo = 'additional_photo'.$num;
            $additional = $hotspecies['HotSpecie'][$photo];
            if($additional == ''){//photo does not exist
                $this->Session->setFlash('Η φωτογραφία δεν υπάρχει','flash_bad');
                $this->redirect(array('action'=>'update',$id), null, true);
            }
            /*Delete image*/
             $this->HotSpecie->deleteImg($id , $num);       
             $this->Session->setFlash('Η φωτογραφία διαγράφηκε επιτυχώς','flash_good');
             $this->redirect(array('action'=>'update',$id));
        }
        }
    }
    
  /*
   *  addImg method is used to add an additional photo to a hot species
   */
    function addImg(){
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if (!empty($this->data)) {
            /*upload main photo*/
            if(!empty($this->data['HotSpecie']['image']['tmp_name'])){
                $id = $this->data['HotSpecie']['id'];
                $num = $this->data['HotSpecie']['num'];
                /* Switch photo's extension*/
                switch ($num)
                {
                    case 1:
                    $ext = 'a';
                    break;    
                    case 2:
                    $ext = 'b';
                    break;
                    case 3:
                    $ext = 'c';
                    break;
                }
                /* Check if input file's type is a valid image */
                $res = $this->Image->checkImage($this->data['HotSpecie']['image']);
            	if($res < 0){
                    $this->Session->setFlash('Παρακαλώ εισάγετε μία φωτογραφία','flash_bad');
                    $this->redirect(array('action'=>'update',$id));
                }
                else if(!$res){
  			$this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική φωτογραφία','flash_bad');
                        $this->redirect(array('action'=>'update',$id));
                }
                /* Rename image file and save to temp directory */
    	        $this->request->data['HotSpecie']['image']['name'] = $this->Image->tmpRename($this->request->data['HotSpecie']['image']);
                $uploaded = $this->JqImgcrop->uploadImage($this->data['HotSpecie']['image'], 'img/temporary/', ''); 
                $imagePath = $uploaded['imagePath'];
                $this->HotSpecie->id = $id;
                /* Save proper image field */
                if ($this->HotSpecie->saveField("additional_photo".$num,$imagePath )) {
                    /*Move additional photos to hotspecies images directory */
                    $ret = $this->Image->mvSubImg($this->HotSpecie, $imagePath, "hotspecies","additional_photo".$num,$ext);
                    if(!$ret){
                            $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας",'flash_bad');
                            $this->redirect(array('action'=>'update',$id));
                            }        
                    $this->Session->setFlash('Η φωτογραφία αποθηκεύτηκε επιτυχώς','flash_good');
                    $this->redirect(array('action'=>'update',$id));
                }
                else{
                    $this->Session->setFlash('Η φωτογραφία δεν αποθηκεύτηκε επιτυχώς.Πρόβλημα στη διαχείρηση της μνήμης','flash_bad');
                    $this->redirect(array('action'=>'update',$id));
                }
            }
            $id = $this->data['HotSpecie']['id'];
            $this->Session->setFlash('Παρακαλώ επιλέξτε μία φωτογραφία','flash_bad');
        $this->redirect(array('action'=>'update',$id));
        }
        $this->Session->setFlash('Δεν υπάρχουν δεδομένα','flash_bad');
        $this->redirect(array('action'=>'show'), null, true);
        }
    }
    
  /*
   *  changePriority method is used to change a hot species' view priority
   */
    function changePriority($id = null,$action = null) {
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if (($id == null) || ($action == null)) {
            $this->Session->setFlash('Λάθος κωδικός είδους','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        else{
            if($action == 1){
                /* Swap hot species priority with higher's hot species priority  */
                if(!$this->HotSpecie->upPriority($id))
                {
                    $this->Session->setFlash('Μη επιτρεπτή ενέργεια','flash_bad');
                    $this->redirect(array('action'=>'show'), null, true);
                }
            }
            else if($action == 2){
                /* Swap hot species priority with lowers's hot species priority  */
                if(!$this->HotSpecie->downPriority($id))
                {
                    $this->Session->setFlash('Μη επιτρεπτή ενέργεια','flash_bad');
                    $this->redirect(array('action'=>'show'), null, true);
                }
            }
            $this->Session->setFlash('Η προτεραιότητα εμφάνισης άλλαξε επιτυχώς','flash_good');
            $this->redirect(array('action'=>'show'), null, true);
        }
        }
    }
}
?>
