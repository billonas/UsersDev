<?php

/**
 * Description of HotSpeciesController
 *
 * @author Nick
 */
class HotSpeciesController extends AppController{
    var $name = 'HotSpecies';
    public $helpers = array('Html', 'Form');
    var $uses = array('HotSpecie'); 
    //to uses edo xreiazetai epeidi xoris tin xrisi tou uses to cakephp psaxnei to antistoixo model
    //to opoio stin sigekrimeni periptosi den vriskei afou to species den exei eniko(i leksi specie den iparxei)
        

    //SXOLIO: From Kiddo, Niko kai gw xrisimopoiw "Report" kai den paizei thema...
    
    
    //From Kiddo: Den xreiazetai en teli i methodos submit, einai lathos antilipsis pou eixame dimiourgisei :P

    function create() {
        if (!empty($this->data)) {
            $this->HotSpecie->create();
            if ($this->HotSpecie->save($this->data)) {
                $this->Session->setFlash('The HotSpecie has been saved');
                //$this->redirect(array('action'=>'show'), null, true);
            } else {
                $this->Session->setFlash('HotSpecie not saved. Try again.');
            }
    }
    }
    
    function update($id = null) {
        if ($id == null) {
            $this->Session->setFlash('Invalid HotSpecie Id');
            $this->redirect(array('action'=>'show'), null, true);
        }
        if (empty($this->data)) {
            $this->data = $this->HotSpecie->find(array('id' => $id));
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
        if ($this->HotSpecie->delete($id)) {
            $this->Session->setFlash('HotSpecie #'.$id.' deleted');
            $this->redirect(array('action'=>'show'), null, true);
        }
    }
    
    function show() {
        $this->set('hotspecies', $this->HotSpecie->find('all'));
    }
}

?>
