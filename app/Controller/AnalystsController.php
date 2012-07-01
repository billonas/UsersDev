<?php

/**
 * Description of AdminController
 * CAUTION: Κρατάω επιφύλαξη, μήπως χρειαστεί να μετανομαστεί σε AnalystsController λόγω CakePHP
 * @author Rodger
 */
class AnalystsController extends AppController{
    var $name = 'Analysts';
    var $components = array('Email', 'Password');//, 'Captcha');
    public $helpers = array('Html', 'Form');
    //put your code here
    
       
    function beforeFilter() 
   {

      if($this->Session->check('report')){
            $this->Session->delete('report');
        }
        if($this->Session->check('report_completed')){
            $this->Session->delete('report_completed');
        }
        if($this->Session->check('uploaded1')){
            $this->Session->delete('uploaded1');
        }
        if($this->Session->check('uploaded2')){
            $this->Session->delete('uploaded2');
        }
        if($this->Session->check('uploaded3')){
            $this->Session->delete('uploaded3');
          }
          if($this->Session->check('uploaded4')){
            $this->Session->delete('uploaded4');
          }
   }
    
    function create($id = null)
    {
      if((!$this->Session->check('UserUsername')) || 
                   (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
      {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }


      $userType = 'analyst';
      $post_id = null;

      if(!empty($this->data['Analyst']))
      {
        $post_id = $this->data['Analyst']['id'];

        $validated_user = true;

        if($post_id == null)
        {
           //validation of user data is needed only if a new user is being inserted
           $this->Analyst->User->set(array(
               'name'=>            $this->data['Analyst']['name'],
               'surname'=>         $this->data['Analyst']['surname'],
               'phone_number'=>    $this->data['Analyst']['phone_number'],
               'email'=>           $this->data['Analyst']['email'],
               'education'=>       $this->data['Analyst']['education'],
               'membership'=>      $this->data['Analyst']['membership'],
               'birth_date'=>      $this->data['Analyst']['birth_date'],
               'address'=>         $this->data['Analyst']['address'],
               'country'=>         $this->data['Analyst']['country'],
               'city'=>            $this->data['Analyst']['city'],
               
           ));

           if(!$this->Analyst->User->validates())
           {
               $this->Analyst->validationErrors = $this->Analyst->User->validationErrors; 
               $validated_user = false;
           }
        }
        //validation of analyst data is needed anyway
        $this->Analyst->set(array(
            'category1'=>       $this->data['Analyst']['category1'],
            'category2'=>       $this->data['Analyst']['category2'],
            'research_institute'=>$this->data['Analyst']['research_institute'],
        ));

        if($this->Analyst->validates() && $validated_user == true) 
        {
           //TODO:
           //1:hash password χρησιμοποιώντας customize συνάρτηση
           //2:sanitize την είσοδο που δίνει ο χρήστης
           $this->Analyst->create(); 

//           $new_user = true; //by default a new user is being inserted from the begining

           if($post_id == null)
           {
              //new user is being inserted from the begining
              //with the new password generated 
              
              $rand_password = $this->Password->generatePassword();
              
              $data = array(
               'name'=>            $this->data['Analyst']['name'],
               'surname'=>         $this->data['Analyst']['surname'],
               'password'=>        $rand_password,
               'phone_number'=>    $this->data['Analyst']['phone_number'],
               'email'=>           $this->data['Analyst']['email'],
               'education'=>       $this->data['Analyst']['education'],
               'membership'=>      $this->data['Analyst']['membership'],
               'birth_date'=>      $this->data['Analyst']['birth_date'],
               'address'=>         $this->data['Analyst']['address'],
               'country'=>         $this->data['Analyst']['country'],
               'city'=>            $this->data['Analyst']['city'],
               'category1'=>       $this->data['Analyst']['category1'],
               'category2'=>       $this->data['Analyst']['category2'],
               'research_institute'=>$this->data['Analyst']['research_institute'],
               'user_type'=>'analyst',

               );
           }
           else
           {
              //user upgrading from simple to analyst
              //without the new password generated 
              $rand_password = null;
//              $new_user = false;

              $data = array(
               'name'=>            $this->data['Analyst']['name'],
               'surname'=>         $this->data['Analyst']['surname'],
               'phone_number'=>    $this->data['Analyst']['phone_number'],
               'email'=>           $this->data['Analyst']['email'],
               'education'=>       $this->data['Analyst']['education'],
               'membership'=>      $this->data['Analyst']['membership'],
               'birth_date'=>      $this->data['Analyst']['birth_date'],
               'address'=>         $this->data['Analyst']['address'],
               'country'=>         $this->data['Analyst']['country'],
               'city'=>            $this->data['Analyst']['city'],
               'category1'=>       $this->data['Analyst']['category1'],
               'category2'=>       $this->data['Analyst']['category2'],
               'research_institute'=>$this->data['Analyst']['research_institute'],
               'user_type'=>'analyst',

               );
           }

           if($this->Analyst->saveAnalyst($data, $post_id))
           {
              $user_id = $this->Analyst->User->getUserId($this->data['Analyst']['email']);

              if(!$this->__sendActivationEmail($user_id, $rand_password)) 
              {
                $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε"); 
                $this->Analyst->delete($user_id);  //delete analyst from database if message not sent
                if($post_id == null)
                {
                  $this->Analyst->User->delete($user_id);
                }
                else
                {
                  $this->Analyst->User->save(array('user_type' => 'simple'), false);
                }
              }
              else
              {
                 $this->Session->setFlash("O αναλυτής δημιουργήθηκε επιτυχώς και θα ενημερωθεί με email."); 
                 $this->redirect(array('controller'=>'users', 'action'=>'edit_users',
                                  "?" => array(
                                         "userType1" => "analyst",
                                         "userType2" => "simple",
                                         "userType3" => "hyperanalyst"
                                         ),
                                   ));  
                 
              }
           }
           else
           {
              $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε");
           }
        
        }
            
      }
      //upgrade user to analyst
      $user = null;
      if($id != null || $post_id!=null) 
      {
         
         $user = $this->Analyst->User->findById($id);

         //this will cause the fields refering to user's info to be disabled
         $userType = 'basic';
      }
      
      $this->set('user', $user); 
      $this->set('post_id', $id); 
      $this->set('userType', $userType);
    }
    
    function update()
    {
    //this function will give the hyperanalyst the right to update the analyst 
    //info.
      
    }
  
    function show($id = null)
    {
      if((!$this->Session->check('UserUsername')) || 
                   (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
      {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
      if($id==null){
          $this->Session->setFlash('Δεν βρέθηκε ο χρήστης που ζητήσατε');
          $this->redirect();
      }
      else
      {
         $analyst =$this->Analyst->findById($id); 
         if($analyst == null)
         {
          $this->Session->setFlash('Δεν βρέθηκε ο χρήστης που ζητήσατε');
          $this->redirect();
         }
         else
         {
          $this->set('analyst', $analyst);
         }
      }
    }

    function downgrade()
    {

    }

    function upgrade()
    {

    }

///////////////////////////Helpful methods(begin)///////////////////////////////

    function __sendActivationEmail($user_id, $rand_password)
    {
       $conditions = array(
           'User.id'=>$user_id,
        );
       //βρες αν υπάρχει ο χρήστης με το συγκεκριμένο username
         $user = $this->Analyst->User->find('first', array('conditions'=>$conditions));

       if ($user === false) 
       {
         debug(__METHOD__." failed to retrieve User data for user.id: {$user_id}");
         return false;
       }
       $activateUrl = $this->__curPageURL('/users/activate/' . $user['User']['id'] .'/');

       $activationHash = $this->Analyst->User->getActivationHash();
       

       $activateUrl = $activateUrl . $activationHash;

       $this->set('activate_url', $activateUrl);

               
       $this->set('email', $this->data['Analyst']['email']);


       $this->Email->to = $user['User']['email'];
       $this->Email->from = 'no-reply <no-reply@elke8e.com>"';
       
       if($rand_password != null)
       {
         //hyperanalyst created a new analyst from the beggining
         $this->Email->subject = env('SERVER_NAME') . ' – Καλώς ήρθες καινούργιε αναλυτή.';

         $this->Email->template = 'analyst_confirm';
		   $this->Email->layout = 'analyst_confirm';
          
         $this->set('rand_password', $rand_password);
       }
       else
       {
         //hyperanalyst upgraded a user to analyst 
         $this->Email->subject = env('SERVER_NAME') . ' – O λογαριασμός σου μόλις αναβαθμίστηκε.';

         $this->Email->template = 'user_analyst_confirm';
		   $this->Email->layout = 'user_analyst_confirm';
         
       }
       $this->Email->sendAs = 'text';       
	    $this->Email->smtpOptions = array(
			'port'=>'465',
			'timeout'=>'30',
			'host' => 'ssl://smtp.gmail.com',
			'username'=>'testhcmr@gmail.com',
			'password'=>'hcmrelkethe',
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
