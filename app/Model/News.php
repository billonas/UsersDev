<?php
/**
 * New Model
 *
 * @author Nick, DBTeam
 */

class News extends AppModel{
    
     public $name = 'New';
     
     /*public $validate = array(
        'title' => array(
            'notEmpty'=>array(
                'rule' => 'notEmpty',
                'message' => 'Παρακαλώ δώστε τον τίτλο του νέου',
                'last'=> true
            )
            ),
        'body' => array(
        'notEmpty'=>array(
                'rule' => 'notEmpty',
                'message' => 'Παρακαλώ δώστε την περιγραφή του νέου',
                'last'=> true
            )
            )
         );*/
     
     public $validate = array(
        //'title' => array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'body' => array(
            'rule' => 'notEmpty'
        )
           // 'rule' => 'notEmpty'
//         'title' => array(
//            'notEmpty'=>array(
//                'rule' => 'notEmpty',
//                'message' => 'Παρακαλώ δώστε τον τίτλο του είδους',
//                'last'=> true
//            )
//        ),
//        'body' => array(
//            'rule' => 'notEmpty'
//        )
    );
    
   function get_cat_desc($description, $max_length = 50) {
      $the_description = strip_tags($description);
      if(strlen($the_description) > $max_length && preg_match('#^\s*(.{'. $max_length .',}?)[,.\s]+.*$#s', $the_description, $matches)) {
        return $matches[1] .'...';
      } else {
        return $the_description;
      }
    }

    public function getLast(){
         $news = $this->find('first', array('order' => array('created DESC')));
         if(!$news)  return 0;
         $news['News']['body'] = $this->get_cat_desc($news['News']['body'], 300);
	return $news;
    }
}

?>
