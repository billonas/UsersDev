<?php

/**
 * Report Model
 *
 * @author Kiddo
 */
class Report extends AppModel{
    var $name= 'Report';
    public $recursive = 3;
    public $belongsTo = array(
          'HotSpecie' => array(
             'className' => 'HotSpecie',
             'foreignKey' => 'hot_id'
           ),
           'User' => array(
              'className' => 'User',
              'foreignKey' => 'observer'
            ),
            'Category' => array(
                'className' => 'Category',
                'foreignKey' => 'category_id'
            ),
            'Last_edited_by' => array(
                'className' => 'User',
                'foreignKey' => 'last_edited_by'
            )
     );
    
    public $validate = array(
//        'habitat' => array(
//                'rule' => 'alphaNumeric',
//                'rule' => array('minLength', 4),
//                'allowEmpty' => true,
//                'message'  => 'Παρακαλώ περιγράψτε τον βιότοπο της παρατήρησης'
//        ),
        'email' => array(
            'email' => array(
                'rule'     => 'email',
                'allowEmpty' => true,
                'message'  => 'Το Email δεν έχει κανονική μορφή'
            )
        ),
//        'depth' => array(
//            'AlphaNumeric' => array(
//                'rule'  => 'alphaNumeric',
//                'allowEmpty' => true,
//                'message'  => 'Παρακαλώ συμπληρώστε το βάθος σε μέτρα'
//            )/*,
//            'between' => array(
//                'rule'    => array('between', 0, 4),
//                'message' => 'Παρακαλώ δώστε ένα έγκυρο βάθος (< 9999)'
//            )*/
//        ),
        'date' => array(
            'rule'       => 'date',
            'message'    => 'Παρακαλώ συμπληρώστε μια κανονική ημερομηνία(Π.Χ. 12/03/2012)',
            'allowEmpty' => false
        )
    );
    
     function findUserReports($userId)
     {
         $return = false;
         
         $conditions = array(
             'Report.observer'=>$userId,
          );
         //βρες αν υπάρχει ο χρήστης με το συγκεκριμένο username
         $reports = $this->find('all', array('conditions'=>$conditions));
         if(!empty($reports))
         {
            $return=$reports;
         }
         
         return $return;

    }
}

?>
