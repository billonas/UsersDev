<?php

/**
 * HotSpecie Model
 *
 * @author Nick, DBTeam
 */
class HotSpecie extends AppModel{
    var $name= 'HotSpecie';
    var $validate = array(
       //'image' => array(
           //'image' => array('rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
           //    'message' => 'Please supply a valid image.'    )
        //'rule' => 'notEmpty',
        //'message' => 'Παρακαλώ μεταφορτώστε μια τουλάχιστον εικόνα'
        //),
        'scientific_name' => array(
            'notEmpty'=>array(
                'rule' => 'notEmpty',
                'message' => 'Παρακαλώ δώστε τον τίτλο του είδους',
                'last'=> true
            )//,
            //'allowedCharacters'=>array(
               //'rule' => 'alphaNumeric',
               //'message' => 'Παρακαλώ χρησιμοποιείστε μόνο χαρακτήρες' 
            //)
            ),
        'description' => array(
        'notEmpty'=>array(
                'rule' => 'notEmpty',
                'message' => 'Παρακαλώ δώστε την περιγραφή του είδους',
                'last'=> true
            )//,
            //'allowedCharacters'=>array(
               //'rule' => 'alphaNumeric',
               //'rule' => array('custom', '/^[a-z0-9 ]*$/i') ,
               //'message' => 'Παρακαλώ χρησιμοποιείστε μόνο χαρακτήρες' 
            //)
        )
    );
    
     function deleteImg($id , $num){
         $dir = 'img/';
         $hot = $this->findById($id);
         $this->id = $id;
         if($hot['HotSpecie']['additional_photo'.$num]){  //diagrafw thn eikona pou antistoixouse sthn eggrafh, ama uparxei
         	unlink($dir.$hot['HotSpecie']['additional_photo'.$num]);
                if($this->saveField('additional_photo'.$num, null))
                return true;
         }
         return false;
    }
    
    function upPriority($id){
        
         $hot1 = $this->findById($id);
         //if(!$hot2 = $this->findByPriority($hot1['HotSpecie']['priority']-1))
             //return false;
         $neighbors = $this->find('neighbors', array('field' => 'priority', 'value' => $hot1['HotSpecie']['priority']));
         if(!$hot2 = $neighbors['prev'])
             return false;
         $pr1 = $hot1['HotSpecie']['priority'];
         $pr2 = $hot2['HotSpecie']['priority'];
         $id2 = $hot2['HotSpecie']['id'];
         $this->id = $id;
         if($this->saveField('priority', $pr2)){
             $this->id = $id2;
             if($this->saveField('priority', $pr1))
                     return true;
         }
         //$pr1 = $hot1['HotSpecie']['priority'];
         //$hot1['HotSpecie']['priority'] = $hot2['HotSpecie']['priority'];
         //$hot2['HotSpecie']['priority'] = $pr1;
         //if( $this->save($hot1['HotSpecie']) && $this->save($hot2['HotSpecie']))
         //    return true;
         return false;
      }
      
      function downPriority($id){
        
         $hot1 = $this->findById($id);
         $neighbors = $this->find('neighbors', array('field' => 'priority', 'value' => $hot1['HotSpecie']['priority']));
         if(!$hot2 = $neighbors['next'])
             return false;
         $pr1 = $hot1['HotSpecie']['priority'];
         $pr2 = $hot2['HotSpecie']['priority'];
         $id2 = $hot2['HotSpecie']['id'];
         $this->id = $id;
         if($this->saveField('priority', $pr2)){
             $this->id = $id2;
             if($this->saveField('priority', $pr1))
                     return true;
         }
         return false;
      }
      function deleteHot($id){
          
          $hot = $this->findById($id);
          $neighbors = $this->find('neighbors', array('field' => 'priority', 'value' => $hot['HotSpecie']['priority']));
          if($this->delete($id)){             
              while($next = $neighbors['next']){
                $priority = $next['HotSpecie']['priority'];
                $priority--;
                $this->id = $next['HotSpecie']['id'];
                if($this->saveField('priority', $priority)){
                    $neighbors = $this->find('neighbors', array('field' => 'priority', 'value' => $next['HotSpecie']['priority']));
                }
                else{
                    return false;
                }
              }
              return true;
          }
          return false;
      }
}

?>
