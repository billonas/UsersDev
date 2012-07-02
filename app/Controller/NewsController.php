<?php

/**
 * Description of NewsController
 *
 * @author Nick
 */
class NewsController extends AppController {
    public $name = 'News';
    public $helpers = array('Html', 'Form');
    var $uses = array('New');

    
    public function show() {
        $this->set('news', $this->New->find('all'));
        
    }
    
    public function create() {
        if ($this->request->is('post')) {
            if ($this->New->save($this->request->data)) {
                $this->Session->setFlash('Your new has been saved.');
                $this->redirect(array('action' => 'show'));
            } else {
                $this->Session->setFlash('Unable to add your new.');
            }
        }
    }
    
    public function edit($id = null) {
    $this->New->id = $id;
    if ($this->request->is('get')) {
        $this->request->data = $this->New->read();
    } else {
        if ($this->New->save($this->request->data)) {
            $this->Session->setFlash('Your new has been updated.');
            $this->redirect(array('action' => 'show'));
        } else {
            $this->Session->setFlash('Unable to update your new.');
        }
    }
    }
    
    public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }
    if ($this->New->delete($id)) {
        $this->Session->setFlash('The new with id: ' . $id . ' has been deleted.');
        $this->redirect(array('action' => 'show'));
    }
    }
}
?>
