<?php

/**
 * Description of ReportsController
 *
 * @author Kiddo
 */

class ReportsController extends AppController{
    var $name = 'Reports';
    public $helpers = array('Html', 'Form', 'Cropimage','GoogleMapV3', 'Js','Session', 'Xls');
    public $components = array('JqImgcrop', 'Image','Video');

   function export() { //http://eureka.ykyuen.info/2009/10/04/cakephp-export-data-to-a-xls-file/       
   	$data = $this->Report->find('all');
   	$this->set('reports', $data);
   }

   /*
    * Create method handle data of a new report in order to save the report properly. 
    */
   function create() {
        /* Check if user is registerd */
        if($this->Session->check('UserUsername')){
            $email = $this->Session->read('UserUsername');
            $userId = ClassRegistry::init('User')->getUserId($email);
            $this->set('userId',$userId);
        }
        if (!empty($this->data)) {
            /* Upload Step */
            if(isset($this->data['Report']['image'])){
                /* Image Upload */
                if(!empty($this->data['Report']['image']['tmp_name'])){
                    //CHECK  IF INPUT FILE IS IMAGE FILE
                    $res = $this->Image->checkImage($this->data['Report']['image']);
                    if($res < 0){
                        $this->Session->setFlash('Παρακαλώ εισάγεται μία φωτογραφία','flash_good');
                        $this->redirect('create');
                    }
                    else if(!$res){
                            $this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική φωτογραφία','flash_bad');
                            $this->redirect('create');
                    }
                    //RENAME IMAGE FILE AND SAVE TO TEMPORARY DIR
                    $this->request->data['Report']['image']['name'] = $this->Image->tmpRename($this->request->data['Report']['image']);
                    $uploaded = $this->JqImgcrop->uploadImage($this->data['Report']['image'], '/img/temporary/', ''); 
                    $this->set('uploaded',$uploaded); 
                    $photo = 1;
                    $this->set('photo',$photo); 
                }
                /* Video Upload */
                else if(!empty($this->data['Report']['video']['name'])){
                    $uploaded = $this->Video->uploadVideo($this->data['Report']['video'], "video/temporary/");
                    if($uploaded['error']){
                        switch($uploaded['error']){
                        case 1:$this->Session->setFlash('Παρακαλώ εισάγετε ένα βίντεο ή αν έχετε εισάγει, εισάγετε ένα μικρότερου μεγέθους','flash_bad');
                                break;
                        case 2: $this->Session->setFlash('Παρακαλώ εισάγετε ένα αρχείο που είναι βίντεο','flash_bad');
                                break;
                        case 3: $this->Session->setFlash('Παρακαλώ εισάγετε ένα πιο μικρό αρχείο','flash_bad');
                                break;
                        case 4: $this->Session->setFlash('Πρόβλημα στη μεταφορά','flash_bad');
                                break;
                        }
                    }
                    $this->set('uploaded',$uploaded); 
                    $video =1;
                    $this->set('video',$video);
                }
                /* Nothing Upload */
                else{
                    $this->Session->setFlash('Παρακαλώ εισάγετε μια φωτογραφία ή ένα βίντεο','flash_good');
                    $this->redirect('create');
                }
            }
            /* Submission step */
            else{
                /* Image */ 
                if(isset($this->photo)){
                    /* Crop needed */
                    if(!empty($this->data['Report']['x1'])){
                        $this->JqImgcrop->cropImage($this->data['Report']['w'], $this->data['Report']['x1'], $this->data['Report']['y1'], $this->data['Report']['x2'], $this->data['Report']['y2'], $this->data['Report']['w'], $this->data['Report']['h'], $this->data['Report']['imagePath'], $this->data['Report']['imagePath']);
                    }
                    $this->Report->create();
                    if ($this->Report->save($this->data['Report'])) {
                        //RENAME IMAGE FILE TO RECORD NAME AND SAVE IT TO DIR
                        $ret = $this->Image->mvSubImg($this->Report, $this->data['Report']['main_photo'], "reports");
                        if(!$ret){
                            $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                            $this->redirect('create');
                        }
                        $this->Session->setFlash('Η αναφορά κατατέθηκε επιτυχώς','flash_good');
                        $this->redirect(array('controller'=>'pages', 'action'=>'display'));
                    } 
                    else {
                        $this->Session->setFlash('Η αναφορά δεν κατατέθηκε επιτυχώς','flash_bad');
                        $this->redirect(array('controller'=>'Reports', 'action'=>'table'));
                    }
                    
                }
                /* Video */
                else if(isset($this->video)){
                    $this->Report->create();
                    if ($this->Report->save($this->data['Report'])){
                        $ret = $this->Video->mvSubVideo($this->Report, $this->data['Report']['video'], "reports");
                        if(!$ret){
                            $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                            $this->redirect('create');
                        }
                        $this->Session->setFlash('Η αναφορά κατατέθηκε επιτυχώς','flash_good');
                        $this->redirect(array('controller'=>'pages', 'action'=>'display'));
                    } 
                    else {
                        $this->Session->setFlash('Η αναφορά δεν κατατέθηκε επιτυχώς','flash_bad');
                        $this->redirect(array('controller'=>'Reports', 'action'=>'table'));
                    }
                }
            }
        }
   }

    function edit($id = null) {
//        if(($this->Session->check('UserUserName')&&(strcmp($this->Session->read('UserType'),'simple'))){
            if ($id==null) {
                $this->Session->setFlash('Invalid ID');
                $this->redirect('table');
            }
            if(empty($this->data)) {
                $this->data = $this->Report->findById($id);
                if(empty($this->data)){
                    $this->Session->setFlash('Invalid ID');
                    $this->redirect('table');
                }
                $categories = ClassRegistry::init('Category')->find('all');
                $species = ClassRegistry::init('Specie')->find('all');
                $report = $this->data;
                $this->set('report',$report);
                $this->set('categories',$categories);
                $this->set('species',$species);
				
				$i=0;
				foreach($species as $item){
					$response[$i]=$item['Specie']['scientific_name'];
					$i++;
				}
				$this->set('response',$response);
            } 
            else {
                if ($this->Report->save($this->data)) {
                    $this->data = $this->Report->findById($id);
                    if(empty($this->data)){
                        $this->Session->setFlash('Invalid ID');
                        $this->redirect('table');
                    }
                    //SAVE SPECIES
                    //ClassRegistry::init('Specie')->save($this->data['Report']['scientific_name']);
                    $categories = ClassRegistry::init('Category')->find('all');
                    $report = $this->data;
                    $this->set('report',$report);
                    $this->set('categories',$categories);
                    $this->Session->setFlash('Η αναφορά αναλύθηκε επιτυχώς','flash_good');
                    $this->redirect('table');
                } 
                else {
                    $this->Session->setFlash('Η αναφορά δεν αναλύθηκε επιτυχώς','flash_bad');
                }    
            }
//        }
//        else{
//            $this->Session->setFlash('Access denied');
//            $this->redirect('table'); 
//        }
    }
    
    function delete($id = null) {
//        if($this->Session->check('UserUserName')&&($this->Session->read('UserType') == 'hyperanalyst')){
            if (!$id) {
                //$this->Session->setFlash('Invalid id for Task');
                $this->redirect(array('controller'=>'Reports', 'action'=>'table'));
            }
            // $report = $this->Report->findById($id); //pernw ta stoixeia gia na brw pithana media(eikones)
            //$this->Image->dlImg($this->Report, $id);
            if ($this->Report->delete($id)) {
            //  if($report['Report']['main_photo'])  //diagrafw thn eikona pou antistoixouse sthn eggrafh, ama uparxei
                    //    unlink($report['Report']['main_photo']);
                $this->Session->setFlash('Η αναφορά '.$id.' διαγράφηκε επιτυχώς','flash_good');
                $this->redirect(array('action'=>'table'), null, true);
            }
//        }
//        else{
//            $this->Session->setFlash('Access denied');
//            $this->redirect('table');  
//        }
    }
    
    function view($id = null) {
//        if($this->Session->check('UserUserName')) {  
            if($id==null){
                $this->Session->setFlash('Invalid ID');
                $this->redirect();
            }
            else{
                $this->set('report',$this->Report->findById($id));
            }
//        }
//        else{
//            $this->Session->setFlash('Access denied');
//            $this->redirect(array('controller'=>'pages', 'action'=>'display'));
//        }
    }
    
    function table(){
//      if(($this->Session->check('UserUserName')&&(strcmp($this->Session->read('UserType'),'simple'))){
            if (!empty($this->data)) {
                  // Return reports after filtering

            }
            else{
                //$this->set('reports',$this->Report->find('all'));
                $this->set('reports',$this->Report->find('all', array('order'=>'created DESC')));
                

            }
//       }
//       else{
//            $this->Session->setFlash('Access denied');
//            $this->redirect(array('controller'=>'pages', 'action'=>'display'));
//       }
    }
    
    function myreports(){
      if(!$this->Session->check('UserUsername')){
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
      $email = $this->Session->read('UserUsername');
      $userId = ClassRegistry::init('User')->getUserId($email);
      
      if($userId !== false){
        $reports = $this->Report->findUserReports($userId);
        $this->set('reports', $reports);
      }
    }
    
    function showspecies(){
        $species = ClassRegistry::init('Specie')->find('all');
        $this->set('species',$species);
    }
    
    
}

?>
