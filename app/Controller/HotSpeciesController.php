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
      

    function create() {
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if (!empty($this->data)) {
            if(!empty($this->data['HotSpecie']['image']['tmp_name'])){
                $add1=0;
                $add2=0;
                $add3=0;
                $res = $this->Image->checkImage($this->data['HotSpecie']['image']);
            	if($res < 0){
                    $this->Session->setFlash('Παρακαλώ εισάγετε μία φωτογραφία','flash_bad');
                    $this->redirect(array('action'=>'create'), null, true);
                }
                else if(!$res){
  			$this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική φωτογραφία','flash_bad');
                        $this->redirect(array('action'=>'create'), null, true);
                }
                //briskw thn katalhksh tou arxeiou gia na dwsw thn idia katalhksh sto kainourgio onoma
    	        $this->request->data['HotSpecie']['image']['name'] = $this->Image->tmpRename($this->request->data['HotSpecie']['image']);
                $uploaded = $this->JqImgcrop->uploadImage($this->data['HotSpecie']['image'], 'img/temporary/', ''); 
                $this->request->data['HotSpecie']['main_photo'] = $uploaded['imagePath'];
                $this->request->data['HotSpecie']['priority'] = $this->HotSpecie->find('count')+1;
                //additional_photo1
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
                //briskw thn katalhksh tou arxeiou gia na dwsw thn idia katalhksh sto kainourgio onoma
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
                    //allazw to onoma ths eikonas katallhla
                    //main_photo
                    $ret = $this->Image->mvSubImg($this->HotSpecie, $this->data['HotSpecie']['main_photo'], "hotspecies", "main_photo");
                    if(!$ret){
                            $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας",'flash_bad');
                            $this->redirect(array('action'=>'create'), null, true);
                            }
                    //TODO:Na valo for
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
                        $ret = $this->Image->mvSubImg($this->HotSpecie, $this->data['HotSpecie']['additional_photo'.$i], "hotspecies","additional_photo".$i,$ext);
                        if(!$ret){
                            $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας για την επιπλέον φώτο".$i,'flash_bad');
                            $this->redirect(array('action'=>'create'), null, true);
                        }
                    }
                    $this->Session->setFlash('The HotSpecies has been saved','flash_good');
                    $this->redirect(array('action'=>'show'), null, true);
                }
                else {
                    $this->Session->setFlash('HotSpecies not saved. Try again.','flash_bad');
                    }
            }
            else{
                $this->Session->setFlash('Παρακαλώ εισάγεται μία φωτογραφία','flash_bad');
                $this->redirect(array('action'=>'create'), null, true);
            }
    }
    }
    }
    
    function update($id = null) {
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if ($id == null) {
            $this->Session->setFlash('Invalid HotSpecie Id','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        if (empty($this->data)) {
            $this->data = $this->HotSpecie->read(null, $id);
            $hotspecie = $this->data;
            $this->set('hotspecie',$hotspecie);
        } else {
            if ($this->HotSpecie->save($this->data)) {
                $this->Session->setFlash('The HotSpecie has been saved','flash_good');
                return $this->redirect(array('action'=>'show'), null, true);
            } else {
                $this->Session->setFlash('The HotSpecie could not be saved.
                                            Please, try again.','flash_bad');
            }
        }
        }
    }
    
    function delete($id = null) {
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if ($id == null) {
            $this->Session->setFlash('Invalid id for HotSpecie','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        $this->Image->dlImg($this->HotSpecie, $id, 'HotSpecie');
        if ($this->HotSpecie->deleteHot($id)) {
            $this->Session->setFlash('HotSpecie #'.$id.' deleted','flash_good');
            $this->redirect(array('action'=>'show'), null, true);
        }
        }
    }
    
    function show() {
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        $this->set('hotspecies', $this->HotSpecie->find('all', array('order'=>'HotSpecie.priority')));
        }     
    }
    
    function view() {
        $this->set('hotspecies', $this->HotSpecie->find('all', array('order'=>'HotSpecie.priority')));
    }
    
    function setMainPhoto($id = null , $num = null){
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if (($id == null) || ($num == null) || ($num > 3) || ($num < 1)) { //num{1-3}
            $this->Session->setFlash('Invalid id for HotSpecie or Photo','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        else{
            $hotspecies = $this->HotSpecie->findById($id);
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
            if($additional == ''){//an den yparxei h antistoixi foto(periptosi pou dosame to num xeirokinita h lathos sto view)
                $this->Session->setFlash('This photo does not exist','flash_bad');
                $this->redirect(array('action'=>'update',$id), null, true);
            }
            $this->Image->changePriority($additional, $hotspecies, $ext,$num,$this->HotSpecie);
            $this->Session->setFlash('The photo has been set as main','flash_good');
            $this->redirect(array('action'=>'update',$id));
            //} else {
            //    $this->Session->setFlash('The photo could not be set as main photo. Please, try again.');
            //    $this->redirect(array('action'=>'update',$id), null, true);
           // }
        }
        }
    }
    
    function deleteImg($id = null , $num = null){
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if (($id == null) || ($num == null) || ($num > 3) || ($num < 1)) { //num{1-3}
            $this->Session->setFlash('Invalid id for HotSpecie or Photo','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        else{
            $hotspecies = $this->HotSpecie->findById($id);
            $photo = 'additional_photo'.$num;
            $additional = $hotspecies['HotSpecie'][$photo];
            if($additional == ''){//an den yparxei h antistoixi foto(periptosi pou dosame to num xeirokinita h lathos sto view)
                $this->Session->setFlash('This photo does not exist','flash_bad');
                $this->redirect(array('action'=>'update',$id), null, true);
            }
             $this->HotSpecie->deleteImg($id , $num);       
             $this->Session->setFlash('The photo has been deleted','flash_good');
             $this->redirect(array('action'=>'update',$id));
        }
        }
    }
    
    function addImg(){
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if (!empty($this->data)) {//na ftiakso to else
            if(!empty($this->data['HotSpecie']['image']['tmp_name'])){
                $id = $this->data['HotSpecie']['id'];
                $num = $this->data['HotSpecie']['num'];
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
                $res = $this->Image->checkImage($this->data['HotSpecie']['image']);
            	if($res < 0){
                    $this->Session->setFlash('Παρακαλώ εισάγετε μία φωτογραφία','flash_bad');
                    $this->redirect(array('action'=>'show'), null, true);
                }
                else if(!$res){
  			$this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική φωτογραφία','flash_bad');
                        $this->redirect(array('action'=>'show'), null, true);
                }
                //briskw thn katalhksh tou arxeiou gia na dwsw thn idia katalhksh sto kainourgio onoma
    	        $this->request->data['HotSpecie']['image']['name'] = $this->Image->tmpRename($this->request->data['HotSpecie']['image']);
                $uploaded = $this->JqImgcrop->uploadImage($this->data['HotSpecie']['image'], 'img/temporary/', ''); 
                $imagePath = $uploaded['imagePath'];
                $this->HotSpecie->id = $id;
                if ($this->HotSpecie->saveField("additional_photo".$num,$imagePath )) {
                    //allazw to onoma ths eikonas katallhla
                    //main_photo
                    $ret = $this->Image->mvSubImg($this->HotSpecie, $imagePath, "hotspecies","additional_photo".$num,$ext);
                    if(!$ret){
                            $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας",'flash_bad');
                            $this->redirect(array('action'=>'show'), null, true);
                            }        
                    $this->Session->setFlash('The photo has been saved','flash_good');
                    $this->redirect(array('action'=>'show'), null, true);
                }
                else{
                    $this->Session->setFlash('Savefield error','flash_bad');
                    $this->redirect(array('action'=>'show'), null, true);
                }
            }
            $this->Session->setFlash('Empty image error','flash_bad');
        $this->redirect(array('action'=>'show'), null, true);
        }
        $this->Session->setFlash('Empty data error','flash_bad');
        $this->redirect(array('action'=>'show'), null, true);
        }
    }
    
    function changePriority($id = null,$action = null) {//TODO stin create na theto priority++ kai
    // *  stin delete na meiono ta priority ton epomenon kata1
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if (($id == null) || ($action == null)) {
            $this->Session->setFlash('Invalid HotSpecie Id','flash_bad');
            $this->redirect(array('action'=>'show'), null, true);
        }
        else{
            if($action == 1)
                $this->HotSpecie->upPriority($id);//TODO
            else if($action == 2)
                $this->HotSpecie->downPriority($id);//TODO+elegxo gia return 0
            $this->Session->setFlash('The priority has been changed','flash_good');
            $this->redirect(array('action'=>'show'), null, true);
        }
        }
    }
}
?>
