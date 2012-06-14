<?php

/**
 * Description of UsersController
 *
 * @author Billonas
 */
class UsersController extends AppController
{
    var $name = 'Users';
    var $components = array('Security','Email', 'Recaptcha.Recaptcha');//, 'Captcha');
    public $helpers = array('Html', 'Form', 'Session', 'Recaptcha.Recaptcha');
	

/////////////////////////Parent Methods(begin)/////////////////////////////////////////
   function beforeFilter() 
   {
   //H μέθοδος beforeFilter() εκτελείται πριν από κάθε κλήση ενός action του 
   //συγκεκριμένου controller.
      parent::beforeFilter();
      $this->Email->delivery = 'debug'; /* used to debug email message */
      $this->Security->validatePost = false;
      
   }

/////////////////////////Parent Methods(end)////////////////////////////////////

/////////////////////////Core UsersController Methods(begin)////////////////////

   function register() 
   {
	   
     	 Configure::load('Recaptcha.key');
	   
        //ελέγχει εάν ο χρήστης είναι ήδη συνδεδεμένος. Εάν έιναι ήδη συνδεδεμένος
        //τότε τον κάνει redirect στην αρχική σελίδα
        if($this->Session->check('UserUsername')) 
        {  
           $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
        if(!empty($this->data['User']))
        {
           $this->User->setLoggedIn(false);
           $this->User->setEditEmail("no");
           //θέσε στο μοντέλο User τα δεδομένα της φόρμας για να τα κάνει validate
           $this->User->set(array(
                  'name'=> $this->data['User']['name'],
                  'surname'=> $this->data['User']['surname'],
                  'phone_number'=>$this->data['User']['phone_number'],
                  'email'=>$this->data['User']['email'],
                  'password'=>$this->data['User']['password'],
                  'passwordConfirm'=>$this->data['User']['passwordConfirm'],
                  'education'=>$this->data['User']['education'],
                  'membership'=>$this->data['User']['membership'],
                  'birth_date'=>$this->data['User']['birth_date'],
                  'address'=>$this->data['User']['address'],
                  'country'=>$this->data['User']['country'],
                  'city'=>$this->data['User']['city'],
                  
            ));

           if($this->User->validates())
           {
              //TODO:
              //1:hash password χρησιμοποιώντας customize συνάρτηση
              //2:sanitize την είσοδο που δίνει ο χρήστης
              $this->User->create(); 

              $data = array(
                  'name'=> $this->data['User']['name'],
                  'surname'=> $this->data['User']['surname'],
                  'phone_number'=>$this->data['User']['phone_number'],
                  'email'=>$this->data['User']['email'],
                  'password'=>$this->data['User']['password'],
                  'education'=>$this->data['User']['education'],
                  'membership'=>$this->data['User']['membership'],
                  'birth_date'=>$this->data['User']['birth_date'],
                  'address'=>$this->data['User']['address'],
                  'country'=>$this->data['User']['country'],
                  'city'=>$this->data['User']['city'],

                  );
              if($this->User->save($data, false))
              {
                 $id = $this->User->getUserId($this->data['User']['email']);
                 if(!$this->__sendActivationEmail($id)) 
                 {
                   $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε"); 
                   $this->User->delete($id);  //delete user from database if message not sent
                 }
                 $this->redirect(array('controller'=>'users', 'action'=>'notify_user', 
                                       $this->data['User']['email']));  
              }
              else
              {
                 debug($this->User->validationErrors);
                 $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε");
              }
              
           }
        }
        
   }
    
    function edit() 
    {
         //ελέγχει εάν ο χρήστης είναι συνδεδεμένος. Εάν δεν έιναι ήδη συνδεδεμένος
         //τότε τον κάνει redirect στην αρχική σελίδα για να μην μπορεί να δει 
         //την σελίδα επεξεργασίας προφίλ συνδεδεμένου χρήστη.
         if(!$this->Session->check('UserUsername')) 
         {  
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
         }
         if(!empty($this->data['User']))
         {
            //ελέγχεται εάν ο χρήστης άλλαξε το email του.
            if(strcmp($this->Session->read('UserUsername'), $this->data['User']['email'])==0)
            {
               $editEmail='no';     //το email δεν άλλαξε
            }
            else
            {
               $editEmail='yes';   //το email άλλαξε
            }

            //πεδίο μέσω του οποίου ελέγχει το μοντέλο 
            //εάν είναι συνδεδμένος ο χρήστης 
            //κατά την ανανέωση του προφίλ αν ο χρήστης
            //αλλάξει το email του θα πρέπει να ελεχθεί
            //αν ο το email χρησιμοποιείται ήδη.
            
            $this->User->setLoggedIn(true);
            $this->User->setEditEmail($editEmail);
            
            
            //θέσε στο μοντέλο User τα δεδομένα της φόρμας για να τα κάνει validate
            $this->User->set(array(
                   'name'=> $this->data['User']['name'],
                   'surname'=> $this->data['User']['surname'],
                   'phone_number'=>$this->data['User']['phone_number'],
                   'email'=>$this->data['User']['email'],
                   'education'=>$this->data['User']['education'],
                   'membership'=>$this->data['User']['membership'],
                   'birth_date'=>$this->data['User']['birth_date'],
                   'address'=>$this->data['User']['address'],
                   'country'=>$this->data['User']['country'],
                   'city'=>$this->data['User']['city'],
                   ));

            if($this->User->validates())
            {
               //TODO:
               //1:hash password χρησιμοποιώντας customize συνάρτηση
               //2:sanitize την είσοδο που δίνει ο χρήστης
               $email = $this->Session->read('UserUsername');
               $id = $this->User->getUserId($email);
                       
               $data=array(
                   'id'=>$id,
                   'name'=> $this->data['User']['name'],
                   'surname'=> $this->data['User']['surname'],
                   'phone_number'=>$this->data['User']['phone_number'],
                   'email'=>$this->data['User']['email'],
                   'education'=>$this->data['User']['education'],
                   'membership'=>$this->data['User']['membership'],
                   'birth_date'=>$this->data['User']['birth_date'],
                   'address'=>$this->data['User']['address'],
                   'country'=>$this->data['User']['country'],
                   'city'=>$this->data['User']['city'],
                   );
               if($this->User->save($data, false))
               {
                  $this->Session->setFlash('Tο προφίλ σας ενημερώθηκε επιτυχώς!','flash_good');  
                  //αλλάζω τις τιμές που υπάρχουν στο session 

                  $name = $this->data['User']['name'];
                  //το πλήρες όνομα του χρήστη υπό την μορφή:V.Kazhs
                  //(αν name=Vasilhs και Surname=Kazhs)
                  $arr = str_split($name);

                  $surname = $this->data['User']['surname'];

                  $fullname = $arr[0] .".". $surname;
                  
                  $this->Session->write('UserUsername',$this->data['User']['email']);  
                  $this->Session->write('UserEducation',$this->data['User']['education']);  
                  $this->Session->write('UserMembership',$this->data['User']['membership']);  
                  $this->Session->write('UserBirthDate',$this->data['User']['birth_date']);  
                  $this->Session->write('UserPhoneNumber',$this->data['User']['phone_number']);  
                  $this->Session->write('UserFullName',$fullname);  
                  $this->Session->write('UserName',$name);  
                  $this->Session->write('UserSurname',$surname);  
               }
               else
               {
                  debug($this->User->validationErrors);
                  $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε");
               }
            }
            else
            {
//               debug($this->User->validationErrors);
               $this->Session->setFlash("");
            }
         }
         $email=$this->Session->read('UserUsername');
         $user = $this->User->findUserByEmail($email);
         if($user!==FALSE)
         {
            //Θέτω τα στοιχεία στη μεταβλητή user για να έχει σε αυτή πρόσβαση
            //το αντίστοιχο view(edit.ctp) σε κάθε πεδίο του.
           $this->set('user', $user); 

         }
    }
    
    
    function delete($id = null) 
    {
        
    }
    

    function login() 
    {  //ελέγχει εάν ο χρήστης είναι ήδη συνδεδεμένος. Εάν έιναι ήδη συνδεδεμένος
       //τότε τον κάνει redirect στην αρχική σελίδα
      if($this->Session->check('UserUsername'))
      {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
      if(!empty($this->data))
      {
        $result = $this->User->validate_user($this->data);
        if($result !== FALSE)
        {
            
          $validated = $result['User']['validated'];
          if(!$validated)
          {
            $this->Session->setFlash('Ο λογαριασμός σας δεν έχει ενεργοποιηθεί ακόμα.
                                    Ακολουθήστε το σύνδεσμο που στάλθηκε με email και ενεργοποιήστε τον.');  
	  	      $this->redirect(array('controller'=>'users','action'=>'login'));			  
          }
          $name = $result['User']['name'];
          //το πλήρες όνομα του χρήστη υπό την μορφή:V.Kazhs
          //(αν name=Vasilhs και Surname=Kazhs)
          $surname = $result['User']['surname'];



         preg_match_all('/[\p{L}\p{M}]/u', $name, $result1, PREG_PATTERN_ORDER);

         $fullname = $result1[0][0] . "." .  $surname; 

          $this->Session->write('UserUsername',$result['User']['email']);  
          $this->Session->write('UserType', $result['User']['user_type']);
          $this->Session->write('UserFullName',$fullname);  
          $this->Session->write('UserName',$name);  
          $this->Session->write('UserSurname',$surname);  
          $this->Session->write('UserEducation',$result['User']['education']);  
          $this->Session->write('UserMembership',$result['User']['membership']);  
          $this->Session->write('UserBirthDate',$result['User']['birth_date']);  
          $this->Session->write('UserPhoneNumber',$result['User']['phone_number']);  

          $url = $this->referer();

          $this->flash('Πατήστε εδώ αν ο browser δεν σας ανακατευθύνει αυτόματα', $url, 4, 'login_success');
        }
        else 
        {  
          $this->Session->setFlash('Το mail ή ο κωδικός χρήστη που εισάγατε ήταν λάθος!','flash_bad');  
	  	    $this->redirect(array('controller'=>'users','action'=>'login'));			  
        }
      }
    }


    function logout() 
    {  
      if($this->Session->check('UserUsername')) 
      {   
        $this->Session->delete('UserUsername');  
        $this->Session->delete('UserType');  
        $this->Session->delete('UserFullName');  
        $this->Session->delete('UserName');  
        $this->Session->delete('UserSurname');  
        $this->Session->delete('UserEducation');  
        $this->Session->delete('UserMembership');  
        $this->Session->delete('UserBirthDate');  
        $this->Session->delete('UserPhoneNumber');  
        $url = array('controller'=>'pages', 'action'=>'display');
        $this->flash('Πατήστε εδώ αν ο browser δεν σας ανακατευθύνει αυτόματα στην αρχική σελίδα', 
                  $url, 4, 'logout_success');
      }  
      else
      {
        $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
    }
    
    function activate($id=null, $in_hash=null) 
    {
      $this->User->id = $id;

      if(($this->User->exists()) && ($in_hash == $this->User->getActivationHash()))
      {  
         if(!$this->User->isActivated())
         {
            //ενεργοποίηση λογαριασμού χρήστη
            $this->User->activateAccount();

            $this->Session->setFlash('O λογαριασμός σας ενεργοποιήθηκε επιτυχώς, 
                                          συνδεθείτε συμπληρώνοντας την φόρμα.');
            $this->redirect('login');

         }
         else
         {
            
            $this->Session->setFlash('O λογαριασμός σας έχει ήδη ενεργοποιηθεί επιτυχώς,
                                     συνδεθείτε συμπληρώνοντας την φόρμα.'); 

            $this->redirect('login');
         }
      }
      else
      {
         $this->Session->setFlash('Δεν υπάρχει λογαριασμός με τα συγκεκριμένα στοιχεία.');
          
      }
    }

    function notify_user($email = null)
    {
      $url = array('controller'=>'pages', 'action'=>'display');
      $this->flash('Αν δεν ανακατευθυνθείτε αυτόματα στην αρχική σελίδα πατήστε εδώ', $url, 4, 'register_success');
    }


    function edit_users()
    {
      if((!$this->Session->check('UserUsername')) || 
                   (strcmp($this->Session->read('UserType'), 'yperanalyst')))
      {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
      else
      {
         $users = $this->User->find('all'); 
         $this->set('users', $users);
         

      }
      
    }

/////////////////////////Core UsersController Methods(end)//////////////////////




///////////////////////////Helpful methods(begin)///////////////////////////////

    function __sendActivationEmail($user_id)
    {
       $conditions = array(
           'User.id'=>$user_id,
        );
       //βρες αν υπάρχει ο χρήστης με το συγκεκριμένο username
         $user = $this->User->find('first', array('conditions'=>$conditions));

       if ($user === false) 
       {
         debug(__METHOD__." failed to retrieve User data for user.id: {$user_id}");
         return false;
       }
       $activateUrl = $this->__curPageURL('/users/activate/' . $user['User']['id'] .'/');

       $activationHash = $this->User->getActivationHash();
       

       $activateUrl = $activateUrl . $activationHash;

       $this->set('activate_url', $activateUrl);

               
       $this->set('email', $this->data['User']['email']);

       $this->Email->to = $user['User']['email'];
       $this->Email->subject = env('SERVER_NAME') . ' – Παρακαλούμε επιβεβαιώστε την 
                                                  διεύθυνση ηλεκτρονικού σας ταχυδρομείου.';
       $this->Email->from = 'no-reply <no-reply@elke8e.com>"';
       $this->Email->template = 'user_confirm';
		 $this->Email->layout = 'user_confirm';
       $this->Email->sendAs = 'text';       
	    $this->Email->smtpOptions = array(
			'port'=>'465',
			'timeout'=>'30',
			'host' => 'ssl://smtp.gmail.com',
			'username'=>'vas1l1skaz1s@gmail.com',
			'password'=>'g00gl3@cc0unt',
		 );
		 $this->Email->delivery = 'smtp';
		 if ($this->Email->send()) 
       {
		 	return true;
		 } 
       else 
       {
		 	return false;
		 }
    }


    function __curPageURL($targetPage) 
    {
      $pageURL = 'http';
      //Εδω υπάρχει κάποιο bug. Δεν αναγνωρίζει την enviromental μεταβλητή $_SERVER['HTTPS']
     // if ($_SERVER["HTTPS"] == "on") 
     //
     // {
     //    $pageURL .= "s";
     // }

      $pageURL .= "://";
      if ($_SERVER["SERVER_PORT"] != "80") 
      {
       $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"] . $targetPage;
      } 
      else 
      {
       $pageURL .= $_SERVER["SERVER_NAME"].$targetPage;
      }

      return $pageURL;
    }
///////////////////////////Helpful methods(end)/////////////////////////////////
    
}



?>
