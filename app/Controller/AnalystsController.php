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
    
    
    function panel () {
        if((!$this->Session->check('UserUsername')) || 
                   (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
        {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
        }
    }
    
    function create($id = null)
    {
      if((!$this->Session->check('UserUsername')) || 
                   (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
      {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }


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

              $hash_password = $this->Analyst->User->hash_password($this->data['Analyst']['email'], $rand_password);

              $data = array(
               'name'=>            $this->data['Analyst']['name'],
               'surname'=>         $this->data['Analyst']['surname'],
               'password'=>        $hash_password,
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
               'category1'=>       $this->data['Analyst']['category1'],
               'category2'=>       $this->data['Analyst']['category2'],
               'research_institute'=>$this->data['Analyst']['research_institute'],
               'user_type'=>'analyst',
               );
           }

           if($this->Analyst->saveAnalyst($data, $post_id))
           {
              $user_id = $this->Analyst->User->getUserId($this->data['Analyst']['email']);

              
              if($rand_password ==null)
              {
                $occasion =  "upgradeSimple";
              }
              else
              {
                $occasion = "createNew";
              }

              if(!$this->__sendActivationEmail($user_id, $rand_password, $occasion)) 
              {
                $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε", 'flash_bad'); 
                //undo the changes being done up to here
                $newUser = false;

                if($post_id == null)
                {
                  //new user created
                  $newUser = true;
                }
                else
                {
                  //user already exists
                  $newUser = false;
                }
                $this->Analyst->unSaveAnalyst($newUser, $user_id);
              }
              else
              {
                 $this->Session->setFlash("O αναλυτής δημιουργήθηκε επιτυχώς και θα ενημερωθεί με email.", 'flash_good'); 
                 $this->redirect(array('controller'=>'users', 'action'=>'edit_users',
                                  "?" => array(
                                         "textType" => "surname",
                                         "userType1" => "analyst",
                                         "userType2" => "simple",
                                         "userType3" => "hyperanalyst"
                                         ),
                                   ));  
                 
              }
           }
           else
           {
              $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε", 'flash_bad');
           }
        
        }
            
      }
      //upgrade user to analyst
      $user = null;
      if($id != null || $post_id!=null) 
      {
         
         $user = $this->Analyst->User->findById($id);

         //this will cause the fields refering to user's info to be disabled
      }
      
      $this->set('user', $user); 
      $this->set('post_id', $id); 
    }
    
    function update($id = null)
    {
    //this function will give the hyperanalyst the right to update the analyst 
    //info.
      if((!$this->Session->check('UserUsername')) || 
                   (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
      {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }


      $post_id = null;

      if(!empty($this->data['Analyst']))
      {
        $post_id = $this->data['Analyst']['id'];

        $validated_user = true; //vailidation of user info has already being done.

        //validation of analyst data is needed anyway
        $this->Analyst->set(array(
            'category1'=>       $this->data['Analyst']['category1'],
            'category2'=>       $this->data['Analyst']['category2'],
            'research_institute'=>$this->data['Analyst']['research_institute'],
        ));

        if($this->Analyst->validates() && $validated_user == true) 
        {
           $data = array(
            'id'=>$post_id,
            'category1'=>       $this->data['Analyst']['category1'],
            'category2'=>       $this->data['Analyst']['category2'],
            'research_institute'=>$this->data['Analyst']['research_institute'],
            );

           if($this->Analyst->save($data, false))
           {
              
              $occasion = "updateAnalyst";

              $rand_password = null;

              if(!$this->__sendActivationEmail($post_id, $rand_password, $occasion)) 
              {
                $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε", 'flash_bad'); 
              }
              else
              {
                 $this->Session->setFlash("Τα στοιχεία αναλυτή ενημερώθηκαν και θα του σταλεί σχετικό email.", 'flash_good'); 
                 $this->redirect(array('controller'=>'users', 'action'=>'edit_users',
                                  "?" => array(
                                         "textType" => "surname",
                                         "userType1" => "analyst",
                                         "userType2" => "simple",
                                         "userType3" => "hyperanalyst"
                                         ),
                                   ));  
              }
           }
           else
           {
              $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε", 'flash_bad');
           }
        }
            
      }

      if($id != null)  
      {
        $analyst = $this->Analyst->findById($id);
      }
      else if ($post_id !=null)
      {
        $analyst = $this->Analyst->findById($post_id);
      }
      
      $this->set('analyst', $analyst); 
      $this->set('post_id', $id); 
      
    }
  
    function downgrade($id = null)
    {
      if((!$this->Session->check('UserUsername')) || 
                   (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
      {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
      if($id==null)
      {
          $this->Session->setFlash('Δεν βρέθηκε ο χρήστης που ζητήσατε', 'flash_bad');
          $this->redirect();
      }
      else
      {
         if($this->Analyst->downgradeAnalyst($id))
         {
              $rand_password = null;

              $occasion =  "downgradeAnalyst";

              if(!$this->__sendActivationEmail($id, $rand_password, $occasion)) 
              {
                $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε", 'flash_bad'); 
                $this->Analyst->unDowngradeAnalyst();
              }
              else
              {
                 $this->Session->setFlash("O αναλυτής υποβαθμίστηκε σε απλό χρήστη και θα ενημερωθεί με email.", 'flash_good'); 
                 $this->redirect(array('controller'=>'users', 'action'=>'edit_users',
                                  "?" => array(
                                         "textType" => "surname",
                                         "userType1" => "analyst",
                                         "userType2" => "simple",
                                         "userType3" => "hyperanalyst"
                                         ),
                                   ));  
              }
          }
          else
          {
             $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε", 'flash_bad');
          }
      }
    }

    function upgrade($id = null)
    {
    //this function will upgrade an analnyst to hyperanalyst
      if((!$this->Session->check('UserUsername')) || 
                   (strcmp($this->Session->read('UserType'), 'hyperanalyst')))
      {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
      if($id==null)
      {
          $this->Session->setFlash('Δεν βρέθηκε ο χρήστης που ζητήσατε', 'flash_bad');
          $this->redirect();
      }
      else
      {
         if($this->Analyst->upgradeAnalyst($id))
         {
              $rand_password = null;

              $occasion =  "upgradeAnalyst";

              if(!$this->__sendActivationEmail($id, $rand_password, $occasion)) 
              {
                $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε", 'flash_bad'); 
                $this->Analyst->unUpgradeAnalyst();
              }
              else
              {
                 $this->Session->setFlash("O αναλυτής αναβαθμίστηκε σε υπέρ-αναλυτή και θα ενημερωθεί με email.", 'flash_good'); 
                 $this->redirect(array('controller'=>'users', 'action'=>'edit_users',
                                  "?" => array(
                                         "textType" => "surname",
                                         "userType1" => "analyst",
                                         "userType2" => "simple",
                                         "userType3" => "hyperanalyst"
                                         ),
                                   ));  
                 
              }
           }
           else
           {
              $this->Session->setFlash("Κάτι πήγε λάθος. Παρακαλώ ξαναπροσπαθήστε", 'flash_bad');
           }
      }

    }

    function communication()
    {
      if((!$this->Session->check('UserUsername')) || 
                   (strcmp($this->Session->read('UserType'), 'hyperanalyst')) ||(strcmp($this->Session->read('UserType'), 'hyperanalyst')))
      {
         $this->redirect(array('controller'=>'pages', 'action'=>'display'));  
      }
      $info = $this->Analyst->getProperties();
      $this->set('info',$info);
    }
///////////////////////////Helpful methods(begin)///////////////////////////////

    function __sendActivationEmail($user_id, $rand_password, $occasion)
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

       $activateUrl = $this->__curPageURL('/UsersDev/users/activate/' . $user['User']['id'] .'/');

       $activationHash = $this->Analyst->User->getActivationHash();
       

       $activateUrl = $activateUrl . $activationHash;

       $this->set('activate_url', $activateUrl);

               
       $this->set('email', $user['User']['email']);


       $this->Email->to = $user['User']['email'];
       $this->Email->from = 'no-reply <no-reply@elke8e.com>"';
      
       //occasion has 3 values:
       //createNew:       send email to a newly created analyst
       //upgradeSimple:   send email to an upraded simple user (from simple to analyst)
       //upgradeAnalyst:  send email to an upgraded analyst (from analyst to hyperanalyst)
       //downgradeAnalyst:send email to an downgraded analyst (from analyst to simple)  
       switch ($occasion) {
        case "createNew":
                          $this->Email->subject = env('SERVER_NAME') . ' – Καλώς ήρθες καινούργιε αναλυτή.';
                          $this->Email->template = 'create_analyst';
                          $this->Email->layout = 'create_analyst';
                          $this->set('rand_password', $rand_password);
                          break;

        case "upgradeSimple":
                          $this->Email->subject = env('SERVER_NAME') . ' – O λογαριασμός σου μόλις αναβαθμίστηκε σε αναλυτή.';
                          $this->Email->template = 'upgrade_simple';
                          $this->Email->layout = 'upgrade_simple';
                          break;

                          
        case "upgradeAnalyst":
                          $this->Email->subject = env('SERVER_NAME') . ' – O λογαριασμός σου μόλις αναβαθμίστηκε σε υπέρ-αναλυτή.';
                          $this->Email->template = 'upgrade_analyst';
                          $this->Email->layout = 'upgrade_analyst';
                          break;

        case "downgradeAnalyst":
                          $this->Email->subject = env('SERVER_NAME') . ' – O λογαριασμός σου μόλις υποβαθμίστηκε σε απλο εγγεγραμένο χρήστη.';
                          $this->Email->template = 'downgrade_analyst';
                          $this->Email->layout = 'downgrade_analyst';
                          break;

        case "updateAnalyst":
                          $this->Email->subject = env('SERVER_NAME') . ' – Tα στοιχεία σου ως αναλυτή μόλις ανανεώθηκαν.';
                          $this->Email->template = 'update_analyst';
                          $this->Email->layout = 'update_analyst';
                          break;
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
