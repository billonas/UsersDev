<?php

/**
 * Analyst Model
 *
 * @author BLTeam, DBTeam
 */
class Analyst extends AppModel{
    var $name= 'Analyst';
    public $recursive = 3;
    public $belongsTo = array(
        'Category1' => array(
           'className' => 'Category',
       'foreignKey' => 'category1'
         ),
        'Category2' => array(
            'className' => 'Category',
            'foreignKey' => 'category2'
         ),
	'User' => array(
	    'className' => 'User',
	    'foreignKey' => 'id'
        )
    );

      public $validate = array(  
        'research_institute'=>array(  
               'rule1'=>array(
                  'rule'=>'notEmpty',
                  'allowempty'=>false,  
                  'message'=>'Παρακαλούμε πληκτρολογήστε το ινσιτούτο'  
             ),
        ),
          
      );
    
     public function saveAnalyst($analyst, $id)
     { 
         if($id == null)
         {
            //hyperanalyst created user from the begining
            $this->User->save($analyst, false);
            $analyst['id'] = $this->User->id;
            
         }
         else
         {
            //hyperanalyst upgraded simple user to analyst
            $data = array(
                'id' => $id,
                'user_type' => 'analyst',
                'validated' => '0');
            
            $this->User->save($data, false);

            $analyst['id'] = $id;
            
         }

         return $this->save($analyst, false);
    }

}

?>
