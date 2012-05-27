<?php

/**
 * Description of UsersController
 *
 * @author Billonas
 */
class UsersController extends AppController{
    var $name = 'Users';
    var $components = array('Email', 'Recaptcha.Recaptcha');//, 'Captcha');
    public $helpers = array('Html', 'Form', 'Session', 'Recaptcha.Recaptcha');
	

	
    //put your code here

   //H μέθοδος beforeFilter() εκτελείται πριν από κάθε κλήση ενός action του 
   //συγκεκριμένου controller.
   function beforeFilter() 
   {
      parent::beforeFilter();
      $this->Email->delivery = 'debug'; /* used to debug email message */
   }

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
            //$this->User->setCaptcha($this->Captcha->getVerCode());
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
               //   if($this->__sendActivationEmail($this->User->getLastInsertID())) //παίζει να υπάρχει κάποιο bug εδώ..
               //   {
               //      $this->Session->setFlash("Message Sent");
               //      $this->redirect(array('controller'=>'users', 'action'=>'notifyuser'));
               //   }
               //   else
               //   {
               //     $this->Session->setFlash("Message not sent"); 
               //     $this->redirect(array('controller'=>'users', 'action'=>'notifyuser'));
               //   }
               //    // pr($this->Session->read('Message.email')); /*Uncomment this code to view the content of email FOR DEBUG */
               //   
                  //TODO:Ακόμα δεν έχω βρει τον τρόπο να στέλνω το email επιβεβαίωσης.
                  //Αυτό που θα κάνω τώρα είναι ότι απλά θα ενημερώνω τοω χρήστη ότι 
                  //επιτυχώς δημιουργήθηκε ο λογαριασμός του και και θα του δίνω τον σύνδεσμο
                  //για να συνδεθεί. Αυτό θα γίνει με την χρήση flash όπως γίνεται και όταν ο
                  //χρήστης κάνει login
                  $url = '/users/login';
                  $this->flash('Πατήστε εδώ για να οδηγηθείτε στη σελίδα σύνδεσης', $url, 4, 'register_success');
               }
               else
               {
                  debug($this->User->validationErrors);
                  $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε");
               }
               
            }
         }
         
    }

    function notifyuser()
    {
      
                                 
    }

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
        $this->set('activate_url', 'http://' . env('SERVER_NAME') . 
                '/users/activate/' . $user['User']['id'] . '/' . $this->User->getActivationHash());
                
        $this->set('username', $this->data['User']['email']);
        echo "to email e;ina " . $user['User']['email'];
        $this->Email->to = $user['User']['email'];
        $this->Email->subject = env('SERVER_NAME') . ' – Please confirm your email address';
        $this->Email->from = 'vas1l1skaz1s@gmail.com';
        $this->Email->template = 'user_confirm';
        $this->Email->sendAs = 'text';   // you probably want to use both :)    

        return $this->Email->send();
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
    {    //ελέγχει εάν ο χρήστης είναι ήδη συνδεδεμένος. Εάν έιναι ήδη συνδεδεμένος
         //τότε τον κάνει redirect στην αρχική σελίδα
        // if( $this->Session->check('UserUsername') ) 
        // {  
        //    $this->redirect(array('controller'=>'Index', 'action'=>'index'));  

        // }
         if($this->Session->check('UserUsername'))
         {
            $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
         }
         if(!empty($this->data))
         {


               $result = $this->User->validate_user($this->data);
               
               if($result !== FALSE)
               {
                     // update login time  
                     //$this->User->id = $result['User']['id'];  
                     //$this->User->saveField('last_login',date("Y-m-d H:i:s"));  
                     
                      

                  $name = $result['User']['name'];
                  //το πλήρες όνομα του χρήστη υπό την μορφή:V.Kazhs
                  //(αν name=Vasilhs και Surname=Kazhs)
                  $arr = str_split($name);

                  $surname = $result['User']['surname'];

                  $fullname = $arr[0] .".". $surname;

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
    
    function validate($code = null) 
    {
        //put your code here
    }

    function captcha() 
    {
         $this->autoRender = false;
         $this->layout='ajax';
         if(!isset($this->Captcha)) { //if Component was not loaded throug $components array()
          App::import('Component','Captcha'); //load it
          $this->Captcha = new CaptchaComponent(); //make instance
          $this->Captcha->startup($this); //and do some manually calling
         }
         //$width = isset($_GET['width']) ? $_GET['width'] : '120';
         //$height = isset($_GET['height']) ? $_GET['height'] : '40';
         //$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
         //$this->Captcha->create($width, $height, $characters); //options, default are 120, 40, 6.
         $this->Captcha->create();
    }
    
}

?>
