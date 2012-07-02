<?php

/**
 * Description of ReportsController
 *
 * @author Kiddo
 */
CakePlugin::load('PhpExcel');
class ReportsController extends AppController{
    var $name = 'Reports';
    public $helpers = array('Html', 'Form', 'Cropimage','GoogleMapV3', 'Js','Session', 'Xls','Tinymce', 'PhpExcel.PhpExcel');
    public $components = array('JqImgcrop', 'Image','Video','Email');

   function beforeFilter(){
     if(strcmp($this->params['action'],'create')&&strcmp($this->params['action'],'summary')){  
        $this->clearReportSession();
     }

   }
    
   function export() { //http://eureka.ykyuen.info/2009/10/04/cakephp-export-data-to-a-xls-file/ 
        $this->clearReportSession();
   	$data = $this->Report->find('all');
   	$this->set('reports', $data);
   }

   function excelExport(){ //http://bakery.cakephp.org/articles/segy/2012/04/02/phpexcel_helper_for_generating_excel_files
        $this->clearReportSession();
        $data = $this->Report->find('all');
        $this->set('data', $data);
   }
   
   
   function downloadvid($id = null) {
       
        if(!$this->Session->check('UserUsername')){ $this->redirect(array('controller'=>'pages', 'action'=>'display'));}
        if(strcmp($this->Session->read('UserType'),'simple')){  
            $this->viewClass = 'Media';
            $params = array(
                'id'        => 'reports/'.$id,
                'download'  => true,
                'path'      => 'video' . DS
            );
            $this->set($params);
        }
        
    }
   
   
   function createnew(){
       $this->redirect(array('action'=>'create'), null, true);
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
            /* Upload 1st Step */
            if(isset($this->data['Report']['image']) || isset($this->data['Report']['video_file'])){
                /* Photo Upload */
                if(!empty($this->data['Report']['image']['tmp_name'])){
                    /* Check if input file's type is a valid image */
                    $res = $this->Image->checkImage($this->data['Report']['image']);
                    if($res < 0){
                        $this->Session->setFlash('Παρακαλώ εισάγεται μία φωτογραφία','flash_good');
                        $this->redirect('create'); 
                   }
                    else if(!$res){
                            $this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική φωτογραφία','flash_bad');
                            $this->redirect('create');
                    }
		    /* Get photo's shooting date from metadata */ 
		    $this->request->data['Report']['exif'] = $this->Image->readexif($this->data['Report']['image']['tmp_name']);
                    /* Rename image file and save to temp directory */
                    $this->request->data['Report']['image']['name'] = $this->Image->tmpRename($this->request->data['Report']['image']);
                    $uploaded = $this->JqImgcrop->uploadImage($this->data['Report']['image'], '/img/temporary/', '');
		    if(!$uploaded){
                         $this->Session->setFlash('Πρόβλημα στη φόρτωση της φωτογραφίας (Ίσως η φωτογραφία είναι πολύ μεγάλη)','flash_bad');
                        $this->redirect('create');  
                    } 
                    $this->Session->write('uploaded1',$uploaded);
                }
                /* Video Upload */
                if(!empty($this->data['Report']['video_file']['name'])){
                    /* Check if input file's type is a valid video */
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
                        default:
                                $this->Session->setFlash('Άγνωστο σφάλμα','flash_bad');
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
            /* Commit information 2nd step */
            else{
                /* Crop needed */
                if(!empty($this->data['Report']['x1'])){
                   $cropped = $this->JqImgcrop->cropImage($this->data['Report']['w'], $this->data['Report']['x1'], $this->data['Report']['y1'], $this->data['Report']['x2'], $this->data['Report']['y2'], $this->data['Report']['w'], $this->data['Report']['h'], $this->data['Report']['imagePath'], $this->data['Report']['imagePath']);
                   $uploaded1 = $this->Session->read('uploaded1');
                   $uploaded1['imageWidth'] = $this->JqImgcrop->getWidth($cropped);
		   $uploaded1['imageHeight'] = $this->JqImgcrop->getHeight($cropped);
                   $this->Session->write('uploaded1',$uploaded1);
                }
                /* Upload 1st additional photo & save to temp directory */
                if(!empty($this->data['Report']['image2']['name'])){
                    $res = $this->Image->checkImage($this->data['Report']['image2']);
                    if(!$res){
                        $this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική δεύτερη φωτογραφία','flash_bad');
                        $this->redirect('create');
                    }
                    else if($res > 0){
                        /* Rename image file and save to temp directory */
                        $this->request->data['Report']['image2']['name'] = $this->Image->tmpRename($this->request->data['Report']['image2']);
                        $uploaded3 = $this->JqImgcrop->uploadImage($this->data['Report']['image2'], '/img/temporary/', '');
                        $this->request->data['Report']['additional_photo1'] = $uploaded3['imagePath'];
                        $this->Session->write('uploaded3',$uploaded3);
		    }
                }
                
                /* Upload 2nd additional photo & save to temp directory */
                if(!empty($this->data['Report']['image3']['name'])){
                    $res = $this->Image->checkImage($this->data['Report']['image3']);
                    if(!$res){
                        $this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική τρίτη φωτογραφία','flash_bad');
                        $this->redirect('create');
                    }
                    else if($res > 0){
                        /* Rename image file and save to temp directory */
                        $this->request->data['Report']['image3']['name'] = $this->Image->tmpRename($this->request->data['Report']['image3']);
                        $uploaded4 = $this->JqImgcrop->uploadImage($this->data['Report']['image3'], '/img/temporary/', '');
                        $this->request->data['Report']['additional_photo2'] = $uploaded4['imagePath'];
                        $this->Session->write('uploaded4',$uploaded4);
                    }
                }
                /* Save all report information to session for a while */
                $this->Session->write('report',$this->data);
                $this->Session->write('report_completed',1);
                $this->Report->set($this->data);
                /* Validate report's data */
                if(!$this->Report->validates()){
                    $this->Session->setFlash('Τα στοιχεία της αναφοράς έχουν πρόβλημα','flash_bad');
                }
                else{
                    $this->redirect(array('controller'=>'Reports', 'action'=>'summary'));
                }
            }
        }
        /* Initialize report page */
        $hotspecies = ClassRegistry::init('HotSpecie')->find('all');
        $this->set('hotspecies',$hotspecies);
   }
   
   /*
    * Summary method handle data of a report in order to save the report properly. 
    */
   
   function summary() {
       /* Submission step */
       if ($this->Session->check('report_completed')) {
        if(!empty($this->data)){
            $this->Report->create();
            $this->Report->set($this->data);
            // Save report's data
            if ($this->Report->save($this->data)) {
                // Rename image file to record id & save to it to appropriate directory
                if(!empty($this->data['Report']['main_photo'])){$main_photo = $this->data['Report']['main_photo'];
                    $this->request->data['Report']['main_photo'] = "../webroot$main_photo";
                    $ret = $this->Image->mvSubImg($this->Report, $this->data['Report']['main_photo'], "reports", "main_photo");
                    if(!$ret){
                    $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                    $this->redirect('create');
                    }
                }
                // Rename video file to record id & save to it to appropriate directory
                if(!empty($this->data['Report']['video'])){
                    $ret = $this->Video->mvSubVideo($this->Report, $this->data['Report']['video'], "reports");
                    if(!$ret){
                    $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                    $this->redirect('create');
                    }
                }
                // Rename 1st additional photo image file to record id & save to it to appropriate directory
                if(!empty($this->data['Report']['additional_photo1'])){$additional_photo1 = $this->data['Report']['additional_photo1'];
                    $this->request->data['Report']['additional_photo1'] = "../webroot$additional_photo1";
                    $ret = $this->Image->mvSubImg($this->Report, $this->data['Report']['additional_photo1'], "reports", "additional_photo1", "a");
                    if(!$ret){
                    $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                    $this->redirect('create');
                    }
                }
                // Rename 1st additional photo image file to record id & save to it to appropriate directory
		if(!empty($this->data['Report']['additional_photo2'])){$additional_photo2 = $this->data['Report']['additional_photo2'];
                    $this->request->data['Report']['additional_photo2'] = "../webroot$additional_photo2";
                    $ret = $this->Image->mvSubImg($this->Report, $this->data['Report']['additional_photo2'], "reports", "additional_photo2", "b");
                    if(!$ret){
                    $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                    $this->redirect('create');
                    }
                }
                $this->clearReportSession();
                $this->Session->setFlash('Η αναφορά κατατέθηκε επιτυχώς','flash_good');
                $this->redirect(array('controller'=>'Reports', 'action'=>'create'));
            } 
            // Save report's data failed
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
          /* Check loggen in user permission rights */
//        if(($this->Session->check('UserUserName')&&(strcmp($this->Session->read('UserType'),'simple'))){
            if ($id==null) {
                $this->Session->setFlash('Invalid ID');
                $this->redirect('table');
            }
            /* Retrieve report's information step */
            if(empty($this->data)) {
                /* Find analyst's information */
                if($this->Session->check('UserUsername')){
                    $email = $this->Session->read('UserUsername');
                    $userId = ClassRegistry::init('User')->getUserId($email);
                    $this->set('userId',$userId);
                }
                /* Find report information*/
                $this->data = $this->Report->findById($id);
                if(empty($this->data)){
                    $this->Session->setFlash('Invalid ID');
                    $this->redirect('table');
                }
                /* Find categories */
                $categories = ClassRegistry::init('Category')->find('all');
                /* Find species */
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
            /* Commit edited information step */
            else {
                /* Send email to the aproppriate analysts */
                $categoryId = $this->request->data['Report']['category_id'];
                $reportId = $this->request->data['Report']['id'];
                $report = $this->Report->findById($reportId);
                $this->informAnalysts($categoryId,$reportId,$report);
                /* Save report's edited data */
                if(($ret = $this->Report->saveReport($this->data)) > 0) {
                    $this->data = $this->Report->findById($id);
                    /* Find categories categories */
                    $categories = ClassRegistry::init('Category')->find('all');
                    $this->set('categories',$categories);
                    $this->Session->setFlash('Η αναφορά αναλύθηκε επιτυχώς','flash_good');
                    $this->redirect('table');
                } 
                else {
                    if($this->Session->check('UserUsername')){
                        $email = $this->Session->read('UserUsername');
                        $userId = ClassRegistry::init('User')->getUserId($email);
                        $this->set('userId',$userId);
                    }
                    /* Find categories */
                    $categories = ClassRegistry::init('Category')->find('all');
                    /* Find species */
                    $temp_species = ClassRegistry::init('Specie')->find('all');
                    $this->set('report',$report);
                    $this->set('categories',$categories);
                    $i=0;
                    foreach($temp_species as $item){
                            $species[$i]=$item['Specie']['scientific_name'];
                            $i++;
                    }
                    $this->set('species',$species);
                    if(!$ret)
                     $this->Session->setFlash('Η αναφορά δεν αναλύθηκε επιτυχώς','flash_bad');
                    else $this->Session->setFlash('Παρακαλώ εισάγεται Επιστημονική Ονομασία για να επικυρωθεί η αναφορά','flash_bad');
                }    
            }
//        }
//        else{
//            $this->Session->setFlash('Access denied');
//            $this->redirect('table'); 
//        }
    }
    
    function delete($id = null) {
        /* Check loggen in user permission rights */
//        if($this->Session->check('UserUserName')&&($this->Session->read('UserType') == 'hyperanalyst')){
            /* Id not given */
            if ($id==null) {
                $this->redirect(array('controller'=>'Reports', 'action'=>'table'));
            }
            /* Find report */
            $report = $this->Report->findById($id);
            if(empty($report)){
                $this->redirect('table');
            }
            /* Delete all multimedia */
            $this->Image->dlImg($this->Report, $id, 'Report');
            /* Delete report */
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
        /* Check loggen in user permission rights */
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
        /* Check loggen in user permission rights */
//      if(($this->Session->check('UserUserName')&&(strcmp($this->Session->read('UserType'),'simple'))){
            /* Find categories' names */
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
            /* Filtering needed */	
            if ((!empty($this->params['url']['text']))||(!empty($this->params['url']['state1']))||(!empty($this->params['url']['state2']))||(!empty($this->params['url']['state3']))) {
                /* Filtering by species or category needed */
                if(!empty($this->params['url']['text'])){
                    /* States accepted */
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
                    /* Filtering by species */
                    if(!strcmp($this->params['url']['select'],'species')){
                        $conditions = array(
                            'Specie.scientific_name'=> $this->params['url']['text'],
                            'Report.state' => $state
                        );

                    }
                    /* Filtering by category */
                    else if(!strcmp($this->params['url']['select'],'category')){
                        $conditions = array(
                           'Category.category_name'=> $this->params['url']['text'],
                           'Report.state' => $state
                        );
                        
                    }
                    /* Find reports */
                    $reports = $this->Report->find("all", array('conditions'=> $conditions));
                    $this->set('reports',$reports);
                }
                /* Filtering by states */
                else{
                    /* States accepted */
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
                    /* Find reports */
                    $this->set('reports',$this->Report->find('all', array('conditions'=> $conditions)));

                }
            }
            /* Filtering not needed */
            else{
                /* Find reports */
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
      /* Check loggen in user permission rights */
      if(!$this->Session->check('UserUsername')){
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
      /* Find user's id */
      $email = $this->Session->read('UserUsername');
      $userId = ClassRegistry::init('User')->getUserId($email);
      /* Find user's reports */
      if($userId !== false){
        $reports = $this->Report->findUserReports($userId);
        $this->set('reports', $reports);
      }
      else{
          $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
    }
    
    function showspecies(){
        $species = $this->Report->findSpecies();
        $this->set('species',$species);
        $sAreas = $this->Report->findSpeciesAreas();
       // $sReports = $this->Report->findSpeciesReports($species[0]['Specie']['scientific_name']);
        $this->set('sAreas',$sAreas);
        //$this->set('sReports',$sReports);
        $areas = $this->Report->findAreas();
        $this->set('areas', $areas);
        $aSpecies = $this->Report->findAreasSpecies();
        //$aReports = $this->Report->findAreasReports($areas[0]['Report']['area']);
        $this->set('aSpecies', $aSpecies);
        //$this->set('aReports', $aReports);
    }
    
    function informAnalysts($categoryId,$reportId,$report){
        /* Category edited */
        if($report['Report']['category_id'] != $categoryId){
            /* Find all analysts of the category */
            $analysts1 = ClassRegistry::init('Analyst')->find('all', array('conditions' => array('Analyst.category1' => $categoryId)));
            //$analysts2 = ClassRegistry::init('Analyst')->find('all', array('conditions' => array('Analyst.category2' => $categoryId)));
            /* Inform each of them */
            foreach($analysts1 as $analyst)
            {

                $this->set('report_link', 'http://localhost/UsersDev/reports/edit/'.$reportId);//env('SERVER_NAME')

                $this->Email->to = $analyst['User']['email'];
                $this->Email->subject = env('SERVER_NAME') . ' – Νέα αναφορά είδους.';
                $this->Email->from = 'no-reply <no-reply@elke8e.com>"';
                $this->Email->template = 'new_report';
                $this->Email->layout = 'new_report';
                $this->Email->sendAs = 'text';       
                $this->Email->smtpOptions = array(
                                    'port'=>'465',
                                    'timeout'=>'30',
                                    'host' => 'ssl://smtp.gmail.com',
                                    'username'=>'testhcmr@gmail.com',
                                    'password'=>'hcmrelkethe',
                            );
                $this->Email->delivery = 'smtp';
                $this->Email->send();
            }
        }
    }
    
}

