<?php

/**
 * User Model
 *
 * @author Chris Keklikopoulos,Billonas
 */
class User extends AppModel
{
      var $name= 'User';
      public $recursive = 2;
      public $hasOne = array(
          'Analyst' => array(
             'className' => 'Analyst',
             'foreignKey' => 'id',
             'dependent' => true
          )
      ); 
      public $hasMany = array(
          'Report' => array(
             'className' => 'Report',
             'foreignKey' => 'observer',
             'order' => 'Report.created DESC',   //επιστρέφει 
          )
      ); 
      

      var $loggedIn=false;

      var $forgottenPass = false; 


      
      public $validate = array(  
      'email'=>array(  
               'rule1'=>array(
                  'rule'=>array('UniqueEmail'),
                  'message'=>'H συγκεκριμένη διεύθυνση ηλεκτρονικού ταχυδρομείου χρησιμοποιείται ήδη. Παρακαλούμε δοκιμάστε άλλη.'  
             ),
               'rule2'=>array(
                  'rule'=>'notEmpty',
                  'allowempty'=>false,  
                  'message'=>'Παρακαλούμε πληκτρολογήστε τη διεύθυνση ηλεκτρονικού ταχυδρομείου'  
             ),
               'rule3'=>array(
                   'rule'=>array('email', true),
                   'message'=>'Παρακαλούμε δώστε έγκυρή τιμή ηλεκτρονικού ταχυδρομείου'
               ) 
      ),  
      'password'=>array(  
               'rule1'=>array(
                  'rule'=>'notEmpty',
                  'allowempty'=>false,  
                  'message'=>'Παρακαλούμε πληκτρολογήστε τη διεύθυνση ηλεκτρονικού ταχυδρομείου'  
             ),
               'rule2'=>array(
                  'rule'=>array('maxLength', 45),
                  'message'=>'Ο κωδικός σας δεν μπορεί να περιέχει παραπάνω από 45 χαρακτήρες'  

             ),
               'rule3'=>array(
                  'rule'=>array('minlength', 8),
                  'message'=>'Ο κωδικός σας δεν μπορεί να περιέχει λιγότερους από 8 χαρακτήρες'  

             ),
               
      ),  

      'passwordConfirm'=>array(  
               'rule1'=>array(
                  'rule'=>'notEmpty',
                  'allowEmpty'=>false,  
                  'message'=>'Παρακαλούμε επιβεβαιώστε τον κωδικό που επιθυμείτε να χρησιμοποείτε'  
             ),
               'rule2'=>array(
                  'rule'=>array('confirmPassword'),
                  'message'=>'Ο κωδικός επιβεβαίωσης και ο κωδικός σας δεν ταιριάζουν'  
             )
      ),

      'old_password'=>array(  
               'rule1'=>array(
                   'rule'=>array('checkOldPassword'),
                   'message'=>'Ο τωρινός κωδικός που δώσατε δεν είναι σωστός'
                   )
      ),
      'old_email'=>array(  
               'rule1'=>array(
                   'rule'=>array('checkOldEmail'),
                   'message'=>'Η τωρινή διεύθυνση που δώσατε δεν είναι σωστή'
                   )
      ),
          //TODO:με τον τελευταίο κανόνα(και στο name και στο surname) θέλω να σιγουρέψω
          //ότι ο χρήστης θα δώσει μόνο γράμματα. Τώρα μπορεί να δώσει και αριθμούς. Θα 
          //πρέπει να το φτιάξω στην δεύτερη φάση
      'username'=>array(  
               'rule1'=>array(
                  'rule'=>'notEmpty',
                  'allowempty'=>false,  
                  'message'=>'Παρακαλούμε δώστε ένα ψευδώνυμο χρήστη'  
             ),
               'rule2'=>array(
                  'rule'=>array('minLength', 4),
                  'message'=>'Το ψευδώνυμο χρήστη δεν μπορεί να περιέχει λιγότερους από 4 χαρακτήρες'  
             ),
               'rule3'=>array(
                  'rule'=>array('maxLength', 45),
                  'message'=>'Το ψευδώνυμο χρήστη δεν μπορεί να περιέχει πάνω από 45 χαρακτήρες'  
             ),
               'rule4'=>array(
                  'rule'=>'alphaNumeric',
                  'message'=>'Το ψευδώνυμο χρήστη μπορεί να περιέχει μόνο γράμματα και αριθμούς'  
             ),
               'rule4'=>array(
                  'rule'=>array('UniqueUsername'),
                  'message'=>'Το ψευδώνυμο χρήστη χρησιμοποιείται ήδη. Παρακαλούμε δοκιμάστε άλλο.'  
             )

      ),
      'name'=>array(  
               'rule1'=>array(
                  'rule'=>'notEmpty',
                  'allowempty'=>false,  
                  'message'=>'Παρακαλούμε δώστε το όνομα σας'  
             ),
               'rule2'=>array(
                  'rule'=>array('maxLength', 45),
                  'message'=>'Το όνομα σας δεν μπορεί να περιέχει πάνω από 45 χαρακτήρες'  
             ),
               'rule3'=>array(
                  'rule'=>'alphaNumeric',
                  'message'=>'Το όνομα σας μπορεί να περιέχει μόνο γράμματα'  
             )

      ),
      'surname'=>array(  
               'rule1'=>array(
                  'rule'=>'notEmpty',
                  'allowempty'=>false,  
                  'message'=>'Παρακαλούμε δώστε το επώνυμο σας'  
             ),
               'rule2'=>array(
                  'rule'=>array('maxLength', 45),
                  'message'=>'Το επώνυμο σας δεν μπορεί να περιέχει πάνω από 45 χαρακτήρες'  
             ),
               'rule3'=>array(
                  'rule'=>'alphaNumeric',
                  'message'=>'Το επώνυμο σας μπορεί να περιέχει μόνο γράμματα'  
             )

      ),
      'phone_number'=>array(  
               'rule1'=>array(
                   'rule'=>array('onlyNumbers'),
                   'message'=>'Το τηλέφωνο σας μπορεί να περιέχει μόνο αριθμούς χωρίς κενά'
             )
      ),
      //'address'=>array(  
      //         'rule1'=>array(
      //             'rule'=>array('address'),
      //             'message'=>'Το τηλέφωνο σας μπορεί να περιέχει μόνο αριθμούς χωρίς κενά'
      //       )
      //),
      'city'=>array(  
               'rule1'=>array(
                   'rule'=>array('onlyLetters'),
                   'message'=>'Η πόλη μπορεί να περιέχει μόνο γράμματα χωρίς κενά'
             )
      ),
      'country'=>array(  
               'rule1'=>array(
                   'rule'=>array('onlyLetters'),
                   'message'=>'Η χώρα μπορεί να περιέχει μόνο γράμματα χωρίς κενά'
             )
      ),
      
      );


      


/////////////////////Core User Actions(begin)///////////////////////////////////
      
      function validate_user($data)
      {
         $return = false;
         
         $conditions = array(
             'User.email'=>$data['User']['login_email'],
          );
         //βρες αν υπάρχει ο χρήστης με το συγκεκριμένο username
         $user = $this->find('first', array('conditions'=>$conditions));

         //εάν υπάρχει
         if(!empty($user))
         {
            //έλενξε τον κωδικό
            if(strcmp($user['User']['password'] , $this->hash_password($user['User']['email'], $data['User']['login_password']))==0)
            {
               $return=$user;
            }
         }
         return $return;
      }

      function checkOldPassword($check)
      {
            $email = $this->getEmail();
            $old_password = array_shift($check);

            $data = array('User'=> array('login_email'=>$email,
                                         'login_password'=>$old_password));
            $result = $this->validate_user($data); 
            
            if($result!= false)
              return true;
            else
              return false;
      }

      function checkOldEmail($check)
      {
            $email = $this->getEmail();
            $old_email = array_shift($check);

            
            if(strcmp($email, $old_email) == 0)
              return true;
            else
              return false;
      }

      function findUserByEmail($email)
      {
         $return = false;
         
         $conditions = array(
             'User.email'=>$email,
          );
         //βρες αν υπάρχει ο χρήστης με το συγκεκριμένο username
         $user = $this->find('first', array('conditions'=>$conditions));

         //εάν υπάρχει
         if(!empty($user))
         {
            $return=$user;
         }
         return $return;
      }


      function getUserId($email)
      {
         $return = false;
         
         $conditions = array(
             'User.email'=>$email,
          );
         //βρες αν υπάρχει ο χρήστης με το συγκεκριμένο username
         $user = $this->find('first', array('conditions'=>$conditions));

         //εάν υπάρχει
         if(!empty($user))
         {
            $return=$user['User']['id'];
         }
         return $return;
      }


      function getActivationHash()
      {
        if (!isset($this->id)) 
        {
                return false;
        }
        return substr(Security::hash(Configure::read('Security.salt') . 
                      $this->field('email') . $this->field('created')), 0, 8);
      }

      function resetPasswordHash()
      {
        if (!isset($this->id)) 
        {
                return false;
        }
        return substr(Security::hash(Configure::read('Security.salt') . 
                      $this->field('email') . $this->field('username')), 0, 8);
      }

      function activateAccount()
      {
         $this->set('validated', 1); 

         if($this->save())
            return true;
         else
            return false;
      }

      function isActivated()
      {
         return $this->field('validated');
      }

      function hash_password($email, $passwd)
      {
        
        $salt = md5($email); 

        $secret = 'secret';

        $i=0;

        while($i<4)
        { 
         $encrypted = hash("sha256", $passwd.$salt); 
         $passwd=$encrypted;
         $i=$i+1;
        }
        return $encrypted;
      }

      function getByPar($par, $value, $userType){
          $conditions = array("$par LIKE" => "%$value%",
                              'user_type'=>$userType
              );
	  return $this->find('all', array('conditions' => $conditions));
      }

      

/////////////////////Core User Actions(end)/////////////////////////////////////


////////////////////////////setters and getters(begin)//////////////////////////

	   function setEmail($value)	
      {
	   	$this->email = $value; //θέτω την τιμή του loggedIn
	   }
      
	   function getEmail()	
      {
	   	return $this->email; //παίρνω την τιμή του loggedIn
	   }
	   function setForgotten($value)	
      {
	   	$this->forgottenPass = $value; //θέτω την τιμή του editEmail
	   }

	   function getForgotten()	
      {
	   	return $this->forgottenPass; //παίρνω την τιμή του EditEmail
	   }



////////////////////////////setters and getters(end)////////////////////////////
      

//////////////////////////Customized Validation Actions(begin)//////////////////

      function UniqueEmail($check)
      {
         //μέσω αυτής της συνάρτησης ελέγχεται εάν χρησιμοποιείται ήδη το email
         //που έδωσε ο χρήστης και τον ενημερώνει αντίστοιχα μέσω του error που 
         //υπάρχει για το συγκεκριμένο πεδίο στο αντίστοιχο view(register.ctp)

        //έλεγχος για το αν ήδη υπάρχει το email που επιλέγει ο χρήστης γίνεται
        //σε 2 περιπτώσεις:
        //α)Κατά την εγγραφή του χρήστη
        //β)Κατά την επεξεργασία προφίλ του χρήστη σε περίπτωση που επεξεργαστεί
        //  το email του.
        $email = array_shift($check);
        //in the occasion of forgotten password don't check if the email is unique
        if(!$this->getForgotten())
        {
          $conditions = array(
              'User.email'=>$email
           );
          if(!$this->id)
          {
            if($this->find('count', array('conditions'=>$conditions))>0) 
            {
                return false; 
            }
          }
          return true;

        }        
        else
          return true;
      }

      function UniqueUsername($check)
      {
         //μέσω αυτής της συνάρτησης ελέγχεται εάν χρησιμοποιείται ήδη το email
         //που έδωσε ο χρήστης και τον ενημερώνει αντίστοιχα μέσω του error που 
         //υπάρχει για το συγκεκριμένο πεδίο στο αντίστοιχο view(register.ctp)

        //έλεγχος για το αν ήδη υπάρχει το email που επιλέγει ο χρήστης γίνεται
        //σε 2 περιπτώσεις:
        //α)Κατά την εγγραφή του χρήστη
        //β)Κατά την επεξεργασία προφίλ του χρήστη σε περίπτωση που επεξεργαστεί
        //  το email του.
        $username = array_shift($check);
        //in the occasion of forgotten password don't check if the email is unique
        if(!$this->getForgotten())
        {
          $conditions = array(
              'User.username'=>$username
           );
          if(!$this->id)
          {
            if($this->find('count', array('conditions'=>$conditions))>0) 
            {
                return false; 
            }
          }
          return true;

        }        
        else
          return true;
      }

      function confirmPassword($check)
      {
         $confirm_password = array_shift($check);
         //εάν password και confirm_password είναι ίσα 
         if (strcmp($confirm_password, ($this->data['User']['password']))==0) 
         {
            return true;
         }
         else
         {
            return false; 
         }
      }

      function onlyNumbers($check)
      {
         $phone = array_shift($check);
         //εάν password και confirm_password είναι ίσα 
         if (preg_match("/^[0-9]+$/", $phone) || (strcmp($phone , "")==0)) 
         {
            return true;
         }
         else
         {
            return false; 
         }
      }

    function onlyLetters($check){
        $word = array_shift($check);
         //εάν password και confirm_password είναι ίσα 
         if (preg_match("/^[\p{L}]+$/u", $word) || (strcmp($word , "")==0)) 
         {
            return true;
         }
         else
         {
            return false; 
         }
    }

    function address($check){
        $word = array_shift($check);
         //εάν password και confirm_password είναι ίσα 
         if (preg_match("/^[\p{L}\s\d[3]]+$/u", $word) || (strcmp($word , "")==0)) 
         {
            return true;
         }
         else
         {
            return false; 
         }
    }

//////////////////////////Customized Validation Actions(end)////////////////////

      function getNameSur(){
          $arr = $this->find('all', array("fields" => "name, surname"));
          $ns = array();
          foreach($arr as $a){
              if($a['User']['name'] == null)
		array_push($ns, $a['User']['surname']);
	      else if($a['User']['surname'] == null)
		array_push($ns, $a['User']['surname']);
	      else
		array_push($ns, $a['User']['name']." ".$a['User']['surname']);
	  }
          return $ns;
      }
       
      function namesurname($str){
          if(!strcmp($str, "")){
              return null;
	  }
          $arr = explode(" ", $str);
          if (!$arr)  return null;
	  $size = count($arr);
          if($size == 1){
		$arr = $this->find('all', array('conditions' => array("OR" => array('User.name LIKE' => "%$str%", 'User.surname LIKE' => "%$str%"))));
          }
	  else{
		$arr = $this->find('all', array('conditions' => array("OR" => array(array('User.name LIKE' => "%".$arr[0]."%", 'User.surname LIKE' => "%".$arr[1]."%"), array('User.name LIKE' => "%".$arr[1]."%", 'User.surname LIKE' => "%".$arr[0]."%")))));
	  }
          return $arr;
      }

      
}

?>
