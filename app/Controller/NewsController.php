<?php

/**
 * Description of NewsController
 *
 * @author Nick
 */
class NewsController extends AppController {
    public $name = 'News';
    public $helpers = array('Html', 'Form','Session');
    var $uses = array('New', 'News');

    
  /*
   *  show method is used to present all news to hyperanalysts
   */
    public function show() {
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        /*find news*/
        $this->set('news', $this->New->find('all'));
        }
    }
    
  /*
   *  view method is used to present all news to users
   */
    public function view() {
        $this->set('news', $this->New->find('all'));
        
    }
    
  /*
   *  create method is used to create a new and save it's data by hyperanalyst
   */
    public function create() {
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
            /*request with data*/
            if ($this->request->is('post')) {
                /*save new*/
            if ($this->New->save($this->request->data)) {
                $this->Session->setFlash('Το νέο κατατέθηκε επιτυχως','flash_good');
                $this->redirect(array('action' => 'show'));
            }
            else {
                $this->Session->setFlash('Το νέο δεν κατατέθηκε επιτυχώς.Προσπαθήστε ξανά.');
            }
            }
        }
    }
    
  /*
   *  edit method is used to edit news data by hyperanalyst
   */
    public function edit($id = null) {
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        $this->New->id = $id;
        if ($this->request->is('get')) {
            /*find new*/
            $this->request->data = $this->New->read();
        } else {
            /*save new*/
            if ($this->New->save($this->request->data)) {
                $this->Session->setFlash('Τα νέα στοιχεία κατατέθηκαν επιτυχώς','flash_good');
                $this->redirect(array('action' => 'show'));
            } else {
                $this->Session->setFlash('Τα νέα στοιχεία δεν κατατέθηκαν επιτυχώς.Προσπαθήστε ξανά.','flash_bad');
            }
        }
        }
    }
    
  /*
   *  delete method is used to delete a news data by hyperanalyst
   */
    public function delete($id) {
        /*check if user is logged in and is a hyperanalyst*/
        if((!$this->Session->check('UserUsername')) || 
                    (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        else
        {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        /*delete new*/
        if ($this->New->delete($id)) {
            $this->Session->setFlash('Το νέο με κωδικό: ' . $id . ' διαγράφηκε επιτυχώς.','flash_good');
            $this->redirect(array('action' => 'show'));
        }
        }
    }
}
?>
