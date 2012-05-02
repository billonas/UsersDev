<?php

/**
 * Description of ReportsController
 *
 * @author Kiddo
 */
class ReportsController extends AppController{
    var $name = 'Reports';
    public $helpers = array('Html', 'Form', 'Cropimage', 'Js','Session', 'Xls','GoogleMapV3');
    public $components = array('JqImgcrop');

   function export() { //http://eureka.ykyuen.info/2009/10/04/cakephp-export-data-to-a-xls-file/       
   	$data = $this->Report->find('all');
   	$this->set('reports', $data);
   }

   function checkImage($path){
         $result = 1;
         ini_set("display_errors", 0);  //xreiazetai gia na mhn bgainei warning an den einai foto
   	 if(!exif_imagetype($path)){
            $result = 0;
	 }
         ini_set("display_errors", 1);
         return $result;
   }

    function create() {
        if (!empty($this->data)){
            if(isset($this->data['Report']['image'])){
            	// CHECK IF INPUT FILE IS IMAGE FORMAT
//            	if(!$this->checkImage($this->data['Report']['image']['tmp_name'])){
//  			$this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική φωτογραφία');
//                        $this->redirect('create');
//                }
                // FIND FILE EXTENSION
    	        $tok = strtok (  $this->request->data['Report']['image']['name'], "." );
                while(($tok1 = strtok(".")) !== false){
                        $tok = $tok1;      		
                }
                // FIND A RANDOM NUMBER,WHICH DOESNT EXIST ON TEMPORARY DIR FILES IN ORDER TO NAME THE FILE
                do{ 
                    $rand = rand();
                        $name = "$rand.$tok";		
                }while(file_exists("../webroot/img/temporary/$name"));
                // RENAME THE FILE
                $this->request->data['Report']['image']['name'] = $name;
                $uploaded = $this->JqImgcrop->uploadImage($this->data['Report']['image'], '/img/temporary/', ''); 
                $this->set('uploaded',$uploaded); 
                if(!$this->data['Report']['edit']){
                     $cropped = true;
                     $this->set('cropped',$cropped);
                     $this->set('imagePath',$uploaded['imagePath']);
                }
            }
            else{
                if(isset($this->data['Report']['x1'])){
                    $this->JqImgcrop->cropImage($this->data['Report']['w'], $this->data['Report']['x1'], $this->data['Report']['y1'], $this->data['Report']['x2'], $this->data['Report']['y2'], $this->data['Report']['w'], $this->data['Report']['h'], $this->data['Report']['imagePath'], $this->data['Report']['imagePath']);
                    $imagePath = $this->data['Report']['imagePath'];
                    $cropped = true;
                    $this->set('cropped',$cropped);
                    $this->set('imagePath',$imagePath);
                }
                else{
                    $this->Report->create();
                    if ($this->Report->save($this->data['Report'])) {
                        $name = $this->data['Report']['main_photo'];
                        $newNameId = $this->Report->id;
                                $tok = strtok (  $name, "." );
                        while(($tok1 = strtok(".")) !== false){
                                $tok = $tok1;      		
                        }
			// RENAME THE FILE ACCORDING TO RECORD ID AND MOVE IT TO REPORTS DIR
                        $newName = "../webroot/img/reports/$newNameId.$tok";  
                        rename("../webroot$name", $newName);
                        $this->Report->saveField("main_photo", "reports/$newNameId.$tok");
                        $this->Session->setFlash('The Report has been saved');
                        // UPLOAD ADDITIONAL PHOTOS
//                        if(isset($this->data['Report']['image2'])){
//                            $uploaded2 = $this->JqImgcrop->uploadImage($this->data['Report']['image2'], '/img/temporary/', '');
//                            $this->Report->saveField("additional_photo1",$uploaded2['imagePath']);
//                        }
//                        if(isset($this->data['Report']['image3'])){
//                            $uploaded3 = $this->JqImgcrop->uploadImage($this->data['Report']['image3'], '/img/temporary/', '');
//                            $this->Report->saveField("additional_photo2",$uploaded3['imagePath']);
//                        }
                        $this->redirect('table');
                    } 
                    else {
                        $this->Session->setFlash('Report not saved. Try again.');
                        $this->redirect(array('controller'=>'Reports', 'action'=>'table'));
                    }
                }
            }
       }
    }

    
    function edit($id = null) {
//        if($this->Session->check('User')&&(($this->Session->read('User.user_type') == 'analyst')||($this->Session->read('User.user_type') == 'yperanalyst'))){
            if ($id==null) {
                $this->Session->setFlash('Invalid ID');
                $this->redirect('table');
            }
            if(empty($this->data)) {
                $this->data = $this->Report->findById($id);
                $categories = ClassRegistry::init('Category')->find('all');
                if(empty($this->data)){
                    $this->Session->setFlash('Invalid ID');
                    $this->redirect('table');
                }
                $report = $this->data;
                $this->set('report',$report);
                $this->set('categories',$categories);
            } 
            else {
                if ($this->Report->save($this->data)) {
                    $this->Session->setFlash('The Report has been saved');
                } 
                else {
                    $this->Session->setFlash('The Report could not be saved.Please, try again.');
                }    
            }
//        }
//        else{
//            $this->Session->setFlash('Access denied');
//            $this->redirect('/'); 
//        }
    }
    
    function delete($id = null) {
//        if($this->Session->check('User')&&($this->Session->read('User.user_type') == 'yperanalyst')){
          if (!$id) {
             //$this->Session->setFlash('Invalid id for Task');
             $this->redirect('table');
          }
          $report = $this->Report->findById($id); //pernw ta stoixeia gia na brw pithana media(eikones)
          if ($this->Report->delete($id)) {
             if(file_exists($report['Report']['main_photo']))  //diagrafw thn eikona pou antistoixouse sthn eggrafh, ama uparxei
         	    unlink($report['Report']['main_photo']);
             $this->Session->setFlash('Task #'.$id.' deleted');
             $this->redirect('table');
          }
//        }
//        else{
//            $this->Session->setFlash('Access denied');
//            $this->redirect('/');  
//        }
    }
    
    function view($id = null) {
//        if($this->Session->check('User')) {  
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
//            $this->redirect('/');  
//        }
    }
    
    function table(){
//        if($this->Session->check('User')&&(($this->Session->read('User.user_type') == 'analyst')||($this->Session->read('User.user_type') == 'yperanalyst'))){
            if (!empty($this->data)) {
                // Return reports after filtering

            }
            else{
                $this->set('reports', $this->Report->find('all', array('order' => array('created' => 'desc'))));
            }
//        }
//        else{
//            $this->Session->setFlash('Access denied');
//            $this->redirect('/');
//        }
    }
}

?>
