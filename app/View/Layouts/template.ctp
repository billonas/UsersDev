<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="en-gb" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title><?php echo $title_for_layout?></title>
		<?php 	echo $this->Html->css(array('main','bubbletip'), null, array('media' => 'screen')); 	?>
        <?php   echo $scripts_for_layout;?>
		<!--[if lt IE 10 ]>
			<?php 	echo $this->Html->css(array('hacks','bubbletip-IE'), null, array('media' => 'screen')); 	?>
		 <![endif]-->
                <!--[if gte IE 9]>
                  <style type="text/css">
                    .gradient {
                       filter: none;
                    }
                  </style>
                <![endif]-->

         
	</head>
        
        
      <style>  
        #noscript-warning {
            font-family: sans-serif;
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            z-index: 9000;
            text-align: center;
            font-weight: bold;
            font-size: 80%;
            color: rgb(255, 255, 255);
            background-color: rgb(174, 0, 0);
            padding: 3px 0px;
        }
      </style>
      
      
	<body>
            
            <noscript>
                <div id="noscript-warning" style="display:block;">Η σελίδα μας λειτουργεί καλύτερα με ενεργοποιημένη Javascript</div>
            </noscript>
		<div class="wrapper">
        	
			<div class="upper_row">
				<?php echo
					$this->Html->Link( 
						$this->Html->Image("hcmr_logo_small.png"), 
						array('controller' => 'pages', 'action' => 'display'), 
						array('escape' => false));
			    ?>
				<ul class="upper_list" >
					<li class="active">
					      <?php 
						      if($this->Session->check('UserUsername'))
								  echo '<a href="#">'.$this->Session->read('UserFullName').'<span class="pointer"></span></a>';
							  else 
							      echo'<a href="#">Σύνδεση<span class="pointer"></span></a>';	
                          ?>
						<!--oti vriskete apo edo kai kato kai mexri ta epomena sxolia einai o kodikas toy pop up-->
						<!--xreiazontai kai ta dio div alla ta endiamesa mporoun na figoun kai na allaksoun-->
							<div class="upper_pop">
								<div class="login">
                                	<?php 
									    if($this->Session->check('UserUsername')) {
											echo '<h1 class="big_white_header_line">Καλώς ήλθατε</h1>';
											
                                                                                        if(!strcmp($this->Session->read('UserType'),'hyperanalyst'))//superanalyst
												echo $this->Html->link('Σελίδα υπεραναλυτή', array('controller' => 'Analysts', 'action'=> 'panel')).'<br/><br/>';
											if(!strcmp($this->Session->read('UserType'),'analyst') || !strcmp($this->Session->read('UserType'),'hyperanalyst')){ //analyst+hyper
												echo $this->Html->link('Πίνακας αναφορών', '/reports/table?select=category&text=&state1=confirmed&state2=unreliable&state3=unknown').'<br/><br/>';
                                                                                                echo $this->Html->link('Στοιχεία επικοινωνίας αναλυτών', array('controller' => 'Analysts', 'action'=>'communication')).'<br/><br/>';
                                                                                                
                                                                                        }
											echo $this->Html->link('Προσωπικό προφίλ', array('controller' => 'users', 'action'=>'edit'));
                                                                                        echo '</br></br>';
                                                                                        echo $this->Html->link('Ρυθμίσεις λογαριασμού', array('controller' => 'users', 'action'=>'account'));
                                                                                        echo '</br></br>';
                                                                                        echo $this->Html->link('Ιστορικό αναφορών', array('controller' => 'reports', 'action'=>'myreports'));
                                                                                        echo '</br></br>';
                                                                                        echo $this->Html->link('Αποσύνδεση', array('controller' => 'users', 'action'=>'logout'));
                           
									    }else{
                                                                                        echo $this->Form->create('User', array('action' => 'login'));
											echo '<h1 class="big_white_header_line">Σύνδεση χρήστη</h1>';
											echo '<p>'.$this->Form->input('User.login_email', 
												  array('label' => array('class' => 'uname std_form', 'text' => 'To e-mail σας </br>', 'data-icon' => 'u'), 'div' => false, 'type' => 'text',
														'required' => 'required', 'id'=> 'UserUsername', 'placeholder' => 'π.χ. mymail@mail.com','class' => 'std_form')).'</p>';									 
											echo '</br><p>'.$this->Form->input('User.login_password', 
												  array('label' => array('class' => 'youpasswd std_form', 'text' => 'O κωδικός σας  </br>', 'data-icon' => 'p'), 'div' => false, 'type' => 'password', 
														'required' => 'required', 'id'=> 'UserPassword', 'placeholder' => 'π.χ. X8df!90EO','class' => 'std_form')).'</p></br>';	
                                                                                        
               echo '<tr><td><label for="ReportId" class="name std_form"></label></td><td><p>'.$this->Form->input('User.id', array('type' => 'hidden', 'value' => "empty"));
               echo '<tr><td><label for="UrlReferer" class="name std_form"></label></td><td><p>'.$this->Form->input('User.referer', array('type' => 'hidden', 'value' => "empty"));
											echo '<p>'.$this->Form->end(array(
														'name' => 'data[User][login]',
														'label' => 'Σύνδεση',
														'div' => false,
														'class' => 'std_form no_shadow light_line' )).'</p>';	
                                                                                        echo $this->Html->link('Δεν είστε μέλος? Εγγραφείτε τώρα!', array('controller' => 'users', 'action'=>'register'),array('class' => 'to_register'));
                                                                                        echo $this->Html->link('Ξεχάσατε τον κωδικό σας;', array('controller' => 'users', 'action'=>'forgot'),array('class' => 'to_register'));

                                                                                    
                                                                                }
								    ?>
                                    
									
								</div>
							</div>
							<!--telos pop up-->
						
					</li>
					<li><?php echo'<a href="#">Πληροφορίες<span class="pointer"></span></a>';?>                                            
						<!--oti vriskete apo edo kai kato kai mexri ta epomena sxolia einai o kodikas toy pop up-->
						<!--xreiazontai kai ta dio div alla ta endiamesa mporoun na figoun kai na allaksoun-->
							<div class="upper_pop">
								<div class="popup_list">   
                                                                    <ul>
                                                                        <li><?php echo $this->Html->link('Νέα-Ανακοινώσεις', array('controller' => 'News', 'action'=>'view'));?></li>
                                                                        <li><?php echo $this->Html->link('Επικοινωνία', array('controller' => 'pages', 'action'=>'communication'));?></li>
                                                                        <li><?php echo $this->Html->link('Βοήθεια', array('controller' => 'pages', 'action'=>'help'));?></li>
                                                                        <li><?php echo $this->Html->link('Στόχοι μας', array('controller' => 'pages', 'action'=>'about'));?></li>
                                                                    </ul>
								</div>
							</div>
							<!--telos pop up-->
						
					</li>
                                        <li><?php echo $this->Html->link('Είδη-στόχοι', array('controller' => 'HotSpecies', 'action'=>'view'));?></li>
					<li><?php echo $this->Html->link('Αναγνωρισμένα Είδη', array('controller' => 'reports', 'action'=>'showspecies'));?></li>
					<li><?php echo $this->Html->link('Νέα Αναφορά', array('controller' => 'reports', 'action'=>'createnew'));?></li>
                    
					    
						
						
						
						
				</ul>
			</div>		
        
                    

		<?php echo $content_for_layout ?>
        
	</body>
</html>