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
   
   function createnew(){
       if($this->Session->check('report')){
            $this->Session->delete('report');
        }
        if($this->Session->check('report_completed')){
            $this->Session->delete('report_completed');
        }
        if($this->Session->check('uploaded1')){
            $this->Session->delete('uploaded1');
        }
        if($this->Session->check('uploaded2')){
            $this->Session->delete('uploaded2');
        }
        if($this->Session->check('uploaded3')){
            $this->Session->delete('uploaded3');
        }
        if($this->Session->check('uploaded4')){
            $this->Session->delete('uploaded4');
        }
        $this->redirect(array('controller'=>'Reports', 'action'=>'create'));
   }
   
   /*
    * Create method handle data of a new report in order to build the report properly. 
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
                    $this->Session->write('uploaded1',$uploaded);
                }
                /* Video Upload */
                if(!empty($this->data['Report']['video_file']['name'])){
                    $uploaded = $this->Video->uploadVideo($this->data['Report']['video_file'], "video/temporary/");
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
                        $this->redirect('create');
                    }
                    $this->Session->write('uploaded2',$uploaded);
                }
                /* Nothing Upload */
                if(empty($this->data['Report']['image']['name']) && empty($this->data['Report']['video_file']['name'])) {
                    $this->Session->setFlash('Παρακαλώ εισάγετε μια φωτογραφία ή ένα βίντεο','flash_good');
                }
            }
            else{
                /* Crop needed */
                if(!empty($this->data['Report']['x1'])){
                    $this->JqImgcrop->cropImage($this->data['Report']['w'], $this->data['Report']['x1'], $this->data['Report']['y1'], $this->data['Report']['x2'], $this->data['Report']['y2'], $this->data['Report']['w'], $this->data['Report']['h'], $this->data['Report']['imagePath'], $this->data['Report']['imagePath']);
                }
                //UPLOAD ADDITIONAL IMAGE FILE AND SAVE TO TEMPORARY DIR
                if(!empty($this->data['Report']['image2']['name'])){
                    $res = $this->Image->checkImage($this->data['Report']['image2']);
                    if(!$res){
                            $this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική δεύτερη φωτογραφία','flash_bad');
                            $this->redirect('create');
                    }
                    else if($res > 0){
                    //RENAME ADDITIONAL IMAGE FILE AND SAVE TO TEMPORARY DIR
                     $this->request->data['Report']['image2']['name'] = $this->Image->tmpRename($this->request->data['Report']['image2']);
                     $uploaded3 = $this->JqImgcrop->uploadImage($this->data['Report']['image2'], '/img/temporary/', '');
                     $this->request->data['Report']['additional_photo1'] = $uploaded3['imagePath'];
                     $this->Session->write('uploaded3',$uploaded3);
		    }
                }
                
                //UPLOAD ADDITIONAL IMAGE FILE AND SAVE TO TEMPORARY DIR
                if(!empty($this->data['Report']['image3']['name'])){
                    $res = $this->Image->checkImage($this->data['Report']['image3']);
                    if(!$res){
                            $this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική τρίτη φωτογραφία','flash_bad');
                            $this->redirect('create');
                    }
                    else if($res > 0){
                    //RENAME ADDITIONAL IMAGE FILE AND SAVE TO TEMPORARY DIR
                     $this->request->data['Report']['image3']['name'] = $this->Image->tmpRename($this->request->data['Report']['image3']);
                     $uploaded4 = $this->JqImgcrop->uploadImage($this->data['Report']['image3'], '/img/temporary/', '');
                     $this->request->data['Report']['additional_photo2'] = $uploaded4['imagePath'];
                     $this->Session->write('uploaded4',$uploaded4);
                    }
                }
                $this->Session->write('report',$this->data);
                $this->Session->write('report_completed',1);
                $this->Report->set($this->data);
                if(!$this->Report->validates()){
                    $this->Session->setFlash('Τα στοιχεία της αναφοράς έχουν πρόβλημα','flash_bad');
                }
                else{
                    $this->redirect(array('controller'=>'Reports', 'action'=>'summary'));
                }
            }
        }
   }
   
   /*
    * Summary method handle data of a report in order to save the report properly. 
    */
   
   function summary() {
       /* Submission step */
       if ($this->Session->check('report_completed')) {
        if(!empty($this->data)){
            /* Image */
            $this->Report->create();
            $this->Report->set($this->data);
            if ($this->Report->save($this->data)) {
                //RENAME IMAGE FILE TO RECORD NAME AND SAVE IT TO DIR
                if(!empty($this->data['Report']['main_photo'])){$main_photo = $this->data['Report']['main_photo'];
                    $this->request->data['Report']['main_photo'] = "../webroot$main_photo";
                    $ret = $this->Image->mvSubImg($this->Report, $this->data['Report']['main_photo'], "reports", "main_photo");
                    if(!$ret){
                    $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                    $this->redirect('create');
                    }
                }
                ////RENAME VIDEO FILE TO RECORD NAME AND SAVE IT TO DIR
                if(!empty($this->data['Report']['video'])){
                    $ret = $this->Video->mvSubVideo($this->Report, $this->data['Report']['video'], "reports");
                    if(!$ret){
                    $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                    $this->redirect('create');
                    }
                }
                if(!empty($this->data['Report']['additional_photo1'])){$additional_photo1 = $this->data['Report']['additional_photo1'];
                    $this->request->data['Report']['additional_photo1'] = "../webroot$additional_photo1";
                    $ret = $this->Image->mvSubImg($this->Report, $this->data['Report']['additional_photo1'], "reports", "additional_photo1", "a");
                    if(!$ret){
                    $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                    $this->redirect('create');
                    }
                }
		if(!empty($this->data['Report']['additional_photo2'])){$additional_photo2 = $this->data['Report']['additional_photo2'];
                    $this->request->data['Report']['additional_photo2'] = "../webroot$additional_photo2";
                    $ret = $this->Image->mvSubImg($this->Report, $this->data['Report']['additional_photo2'], "reports", "additional_photo2", "b");
                    if(!$ret){
                    $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                    $this->redirect('create');
                    }
                }
                if($this->Session->check('report')){
                    $this->Session->delete('report');
                }
                if($this->Session->check('report_completed')){
                    $this->Session->delete('report_completed');
                }
                if($this->Session->check('uploaded1')){
                    $this->Session->delete('uploaded1');
                }
                if($this->Session->check('uploaded2')){
                    $this->Session->delete('uploaded2');
                }
                if($this->Session->check('uploaded3')){
                    $this->Session->delete('uploaded3');
                }
                if($this->Session->check('uploaded4')){
                    $this->Session->delete('uploaded4');
                }
                $this->Session->setFlash('Η αναφορά κατατέθηκε επιτυχώς','flash_good');
                $this->redirect(array('controller'=>'Reports', 'action'=>'create'));
            } 
            else {
                $this->Session->setFlash('Η αναφορά δεν κατατέθηκε επιτυχώς','flash_bad');
                $this->set("validation", 1);
                $this->redirect(array('controller'=>'Reports', 'action'=>'summary'));
            }
        }
       }
       else{
        $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
       }
   }

    function edit($id = null) {
          if($this->Session->check('report')){
            $this->Session->delete('report');
          }
          if($this->Session->check('report_completed')){
            $this->Session->delete('report_completed');
          }
          if($this->Session->check('uploaded1')){
            $this->Session->delete('uploaded1');
          }
          if($this->Session->check('uploaded2')){
            $this->Session->delete('uploaded2');
          }
          if($this->Session->check('uploaded3')){
            $this->Session->delete('uploaded3');
          }
          if($this->Session->check('uploaded4')){
            $this->Session->delete('uploaded4');
          }
//        if(($this->Session->check('UserUserName')&&(strcmp($this->Session->read('UserType'),'simple'))){
            if ($id==null) {
                $this->Session->setFlash('Invalid ID');
                $this->redirect('table');
            }
            if(empty($this->data)) {
                if($this->Session->check('UserUsername')){
                    $email = $this->Session->read('UserUsername');
                    $userId = ClassRegistry::init('User')->getUserId($email);
                    $this->set('userId',$userId);
                }
                $this->data = $this->Report->findById($id);
                if(empty($this->data)){
                    $this->Session->setFlash('Invalid ID');
                    $this->redirect('table');
                }
                $categories = ClassRegistry::init('Category')->find('all');
                $temp_species = ClassRegistry::init('Specie')->find('all');
                $report = $this->data;
                $this->set('report',$report);
                $this->set('categories',$categories);
				$i=0;
				foreach($temp_species as $item){
					$species[$i]=$item['Specie']['scientific_name'];
					$i++;
				}
				$this->set('species',$species);
            } 
            else {
                //Kodikas pou kalei thn synartisi pou stelnei mail stous analytes tis catigorias
                /*$catId = $this->request->data['Report']['category_id'];
                $repId = $this->request->data['Report']['id'];
                $this->Report->notifyCategorizedReport($repId, $catId);*/
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
            $report = $this->Report->findById($id); //pernw ta stoixeia gia na brw pithana media(eikones)
            $this->Image->dlImg($this->Report, $id, 'Report');
            if ($this->Report->delete($id)) {
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
        if($this->Session->check('report')){
            $this->Session->delete('report');
          }
          if($this->Session->check('report_completed')){
            $this->Session->delete('report_completed');
          }
          if($this->Session->check('uploaded1')){
            $this->Session->delete('uploaded1');
          }
          if($this->Session->check('uploaded2')){
            $this->Session->delete('uploaded2');
          }
          if($this->Session->check('uploaded3')){
            $this->Session->delete('uploaded3');
          }
          if($this->Session->check('uploaded4')){
            $this->Session->delete('uploaded4');
          }
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
        if($this->Session->check('report')){
            $this->Session->delete('report');
        }
        if($this->Session->check('report_completed')){
            $this->Session->delete('report_completed');
        }
        if($this->Session->check('uploaded1')){
            $this->Session->delete('uploaded1');
        }
        if($this->Session->check('uploaded2')){
            $this->Session->delete('uploaded2');
        }
        if($this->Session->check('uploaded3')){
            $this->Session->delete('uploaded3');
          }
          if($this->Session->check('uploaded4')){
            $this->Session->delete('uploaded4');
          }
//      if(($this->Session->check('UserUserName')&&(strcmp($this->Session->read('UserType'),'simple'))){
			//probably awkward way to get only the names of categories - only for temp testing
			$table = ClassRegistry::init('Category')->find('all');
                        $temp_species = ClassRegistry::init('Specie')->find('all');

            $this->set('table',$table);
                        $i=0;
                        foreach($table as $item){
                                $categories[$i]=$item['Category']['category_name'];
                                $i++;
                        }
			$this->set('categories',$categories);
                        $i=0;
                        foreach($temp_species as $item){
                                $species[$i]=$item['Specie']['scientific_name'];
                                $i++;
                        }
                        $this->set('species',$species);
			
            if ((!empty($this->params['url']['text']))||(!empty($this->params['url']['state1']))||(!empty($this->params['url']['state2']))||(!empty($this->params['url']['state3']))) {
                // INPUT GIVEN 
                if(!empty($this->params['url']['text'])){
                    $state = array();
                    if(!empty($this->params['url']['state1'])){
                        array_push($state, $this->params['url']['state1']);
                        $state1 = $this->params['url']['state1'];
                    }
                    if(!empty($this->params['url']['state2'])){
                        array_push($state, $this->params['url']['state2']);
                    }
                    if(!empty($this->params['url']['state3'])){
                        array_push($state,$this->params['url']['state3']);
                    }
                    $conditions = array(
                            'Report.state' => $state
                    );
                    if(!strcmp($this->params['url']['select'],'species')){
                        $conditions = array(
                            'Specie.scientific_name'=> $this->params['url']['text'],
                            'Report.state' => $state
                        );

                    }
                    else if(!strcmp($this->params['url']['select'],'category')){
                        $conditions = array(
                           'Category.category_name'=> $this->params['url']['text'],
                           'Report.state' => $state
                        );
                        
                    }
                    $reports = $this->Report->find("all", array('conditions'=> $conditions));
                    $this->set('reports',$reports);
                }
                else{
                    $state = array();
                    if(!empty($this->params['url']['state1'])){
                        array_push($state, $this->params['url']['state1']);
                    }
                    if(!empty($this->params['url']['state2'])){
                        array_push($state, $this->params['url']['state2']);
                    }
                    if(!empty($this->params['url']['state3'])){
                        array_push($state, $this->params['url']['state3']);
                    }
                    $conditions = array(
                            'Report.state' => $state
                    );
                    $this->set('reports',$this->Report->find('all', array('conditions'=> $conditions)));

                }
            }
            else{
                 $reports = $this->Report->find("all");
                 $this->set('reports',$reports);
            }
//       }
//       else{
//            $this->Session->setFlash('Access denied');
//            $this->redirect(array('controller'=>'pages', 'action'=>'display'));
//       }
    }
    
    function myreports(){
      if($this->Session->check('report')){
            $this->Session->delete('report');
          }
          if($this->Session->check('report_completed')){
            $this->Session->delete('report_completed');
          }
          if($this->Session->check('uploaded1')){
            $this->Session->delete('uploaded1');
          }
          if($this->Session->check('uploaded2')){
            $this->Session->delete('uploaded2');
          }  
          if($this->Session->check('uploaded3')){
            $this->Session->delete('uploaded3');
          }
          if($this->Session->check('uploaded4')){
            $this->Session->delete('uploaded4');
          }
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
        if($this->Session->check('report')){
            $this->Session->delete('report');
          }
          if($this->Session->check('report_completed')){
            $this->Session->delete('report_completed');
          }
          if($this->Session->check('uploaded1')){
            $this->Session->delete('uploaded1');
          }
          if($this->Session->check('uploaded2')){
            $this->Session->delete('uploaded2');
          }
          if($this->Session->check('uploaded3')){
            $this->Session->delete('uploaded3');
          }
          if($this->Session->check('uploaded4')){
            $this->Session->delete('uploaded4');
          }
        $species = ClassRegistry::init('Specie')->find('all');
        $this->set('species',$species);
        $perioxes = $this->Report->findPerioxesSpecies();
        $species2 = $this->Report->findReportsSpecies();
        $this->set('perioxes',$perioxes);
        $this->set('species2',$species2);
    }
    
    
}

