<?php

/**
 * Description of HotSpeciesController
 *
 * @author Nick
 */
class HotSpeciesController extends AppController{
    var $name = 'HotSpecies';
    public $helpers = array('Html', 'Form');
    public $components = array('JqImgcrop', 'Image');
    var $uses = array('HotSpecie'); 
    //to uses edo xreiazetai epeidi xoris tin xrisi tou uses to cakephp psaxnei to antistoixo model
    //to opoio stin sigekrimeni periptosi den vriskei afou to species den exei eniko(i leksi specie den iparxei)
        

    function create() {
        if (!empty($this->data)) {
            if(isset($this->data['HotSpecie']['image'])){
                $res = $this->Image->checkImage($this->data['HotSpecie']['image']);
            	if($res < 0){
                    $this->Session->setFlash('Παρακαλώ εισάγετε μία φωτογραφία');
                    $this->redirect(array('action'=>'create'), null, true);
                }
                else if(!$res){
  			$this->Session->setFlash('Παρακαλώ εισάγετε μία κανονική φωτογραφία');
                        $this->redirect(array('action'=>'create'), null, true);
                }
                //briskw thn katalhksh tou arxeiou gia na dwsw thn idia katalhksh sto kainourgio onoma
    	        $this->Image->tmpRename($this->request->data['HotSpecie']['image']);
                $uploaded = $this->JqImgcrop->uploadImage($this->data['HotSpecie']['image'], '/img/temporary/', ''); 
                $this->request->data['HotSpecie']['main_photo'] = $uploaded['imagePath'];
                //$this->request->data['HotSpecie']['main_photo'] = $this->HotSpecie->getSize()+1;
                $this->HotSpecie->create();
                if ($this->HotSpecie->save($this->data['HotSpecie'])) {
                    //allazw to onoma ths eikonas katallhla
                    $ret = $this->Image->mvSubImg($this->HotSpecie, $this->data['HotSpecie']['main_photo'], "hotspecies");
                    if(!$ret){
                            $this->Session->setFlash("Πρόβλημα στη διαχείρηση της εικόνας");
                            $this->redirect(array('action'=>'create'), null, true);
                            }
                    $this->Session->setFlash('The HotSpecie has been saved');
                    $this->redirect(array('action'=>'show'), null, true);
                }
                else {
                    $this->Session->setFlash('HotSpecie not saved. Try again.');
                    }
            }
            else{
                $this->Session->setFlash('Παρακαλώ εισάγεται μία φωτογραφία');
                $this->redirect(array('action'=>'create'), null, true);
            }
    }
    }
    
    function update($id = null) {
        if ($id == null) {
            $this->Session->setFlash('Invalid HotSpecie Id');
            $this->redirect(array('action'=>'show'), null, true);
        }
        if (empty($this->data)) {
            $this->data = $this->HotSpecie->read(null, $id);
            $hotspecie = $this->data;
            $this->set('hotspecie',$hotspecie);
        } else {
            if ($this->HotSpecie->save($this->data)) {
                $this->Session->setFlash('The HotSpecie has been saved');
                $this->redirect(array('action'=>'show'), null, true);
            } else {
                $this->Session->setFlash('The HotSpecie could not be saved.
                                            Please, try again.');
            }
        }
    }
    
    function delete($id = null) {
        if ($id == null) {
            $this->Session->setFlash('Invalid id for HotSpecie');
            $this->redirect(array('action'=>'show'), null, true);
        }
        //$this->Image->dlImg($this->HotSpecie, $id);
        $report = $this->HotSpecie->findById($id);
        if($report['HotSpecie']['main_photo'])  //diagrafw thn eikona pou antistoixouse sthn eggrafh, ama uparxei
         	unlink($report['HotSpecie']['main_photo']);
        if ($this->HotSpecie->delete($id)) {
            $this->Session->setFlash('HotSpecie #'.$id.' deleted');
            $this->redirect(array('action'=>'show'), null, true);
        }
    }
    
    function show() {
        $this->set('hotspecies', $this->HotSpecie->find('all'));
    }
    
    function setMainPhoto($id = null , $num = null){
        if (($id == null) || ($num == null) || ($num > 3) || ($num < 1)) { //num{1-3}
            $this->Session->setFlash('Invalid id for HotSpecie or Photo');
            $this->redirect(array('action'=>'show'), null, true);
        }
        else{
            $hotspecies = $this->HotSpecie->findById($id);
            //$main = $hotspecies['HotSpecie']['main_photo'];
            $photo = 'additional_photo'.$num;
            $additional = $hotspecies['HotSpecie'][$photo];
            if($additional == ''){//an den yparxei h antistoixi foto(periptosi pou dosame to num xeirokinita h lathos sto view)
                $this->Session->setFlash('This photo does not exist');
                $this->redirect(array('action'=>'update',$id), null, true);
            }
            $this->Image->changePriority($additional, $hotspecies, 'a',$num,$this->HotSpecie);
            //clearCache();
            //sleep(10);
            //$hotspecies['HotSpecie'][$photo] = $main;
            //$hotspecies['HotSpecie']['main_photo'] = $additional;
            //if ($this->HotSpecie->save($hotspecies)) {
                //$this->Image->changePriority($additional, $hotspecies, 'a');
                $this->Session->setFlash('The photo has been set as main');
                $this->redirect(array('action'=>'update',$id));
            //} else {
            //    $this->Session->setFlash('The photo could not be set as main photo. Please, try again.');
            //    $this->redirect(array('action'=>'update',$id), null, true);
           // }
        }
    }
    
    /*function changePriority($id = null,$action = null) {
        if (($id == null) || ($action == null)) {
            $this->Session->setFlash('Invalid HotSpecie Id');
            $this->redirect(array('action'=>'show'), null, true);
        }
        else{
            if($action == 1)
                $this->HotSpecie->upPriority($id);//TODO
            else if($action == 2)
                $this->HotSpecie->downPriority($id);//TODO+elegxo gia return 0
            $this->Session->setFlash('The priority has been changed');
            $this->redirect(array('action'=>'show'), null, true);
        }
    }*/
}
?>