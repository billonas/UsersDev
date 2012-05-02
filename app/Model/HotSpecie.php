<?php

/**
 * HotSpecie Model
 *
 * @author BLTeam, DBTeam
 */
class HotSpecie extends AppModel{
    var $name= 'HotSpecie';
    var $validate = array(
       'main_photo' => array(
           //'image' => array('rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
           //    'message' => 'Please supply a valid image.'    )
        'rule' => 'notEmpty',
        'message' => 'Παρακαλώ μεταφορτώστε μια τουλάχιστον εικόνα'
        ),
        'scientific_name' => array(
            'notEmpty'=>array(
                'rule' => 'notEmpty',
                'message' => 'Παρακαλώ δώστε τον τίτλο του είδους',
                'last'=> true
            ),
            'allowedCharacters'=>array(
               'rule' => 'alphaNumeric',
               'message' => 'Παρακαλώ χρησιμοποιείστε μόνο χαρακτήρες' 
            )
            ),
        'description' => array(
        'notEmpty'=>array(
                'rule' => 'notEmpty',
                'message' => 'Παρακαλώ δώστε την περιγραφή του είδους',
                'last'=> true
            ),
            'allowedCharacters'=>array(
               'rule' => 'alphaNumeric',
               'message' => 'Παρακαλώ χρησιμοποιείστε μόνο χαρακτήρες' 
            )
        )
    );
}

?>
