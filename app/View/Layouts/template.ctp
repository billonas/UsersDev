<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="en-gb" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title><?php echo $title_for_layout?></title>
		<?php 	echo $this->Html->css(array('main'), null, array('media' => 'screen', 'rel' => 'stylesheet')); 	?>
        <?php   echo $scripts_for_layout;?>
		<!--[if lt IE 10 ]>
			<?php 	echo $this->Html->css(array('hacks'), null, array('media' => 'screen')); 	?>
		 <![endif]-->
                <!--[if gte IE 9]>
                  <style type="text/css">
                    .gradient {
                       filter: none;
                    }
                  </style>
                <![endif]-->

         
	</head>
	<body>
		<div class="wrapper">
        	
			<div class="upper_row">
				<?php echo
					$this->Html->Link( 
						$this->Html->Image("hcmr-logo.png"), 
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
											echo '<h1>Καλώς ήλθατε</h1>';
											
											if(!strcmp($this->Session->read('UserType'),'simple')) {//simple
												echo $this->Html->link('Προσωπικό προφίλ', array('controller' => 'users', 'action'=>'edit'));
												echo '</br></br>';
												echo $this->Html->link('Ιστορικό αναφορών', array('controller' => 'users', 'action'=>'myreports'));
												echo '</br></br>';
												echo $this->Html->link('Αποσύνδεση', array('controller' => 'users', 'action'=>'logout'));
											}
											else if(!strcmp($this->Session->read('UserType'),'analyst')) {//analyst
												echo $this->Html->link('Πίνακας αναφορών', array('controller' => 'reports', 'action'=>'table'));
												echo '</br></br>';
												echo $this->Html->link('Αποσύνδεση', array('controller' => 'users', 'action'=>'logout'));
											}
											else if(!strcmp($this->Session->read('UserType'),'yperanalyst')) {//superanalyst
												echo $this->Html->link('Πίνακας υπεραναλυτή', array('controller' => 'users', 'action'=>false));
												echo '</br></br>';
												echo $this->Html->link('Πίνακας αναφορών', array('controller' => 'reports', 'action'=>'table'));
												echo '</br></br>';
												echo $this->Html->link('Αποσύνδεση', array('controller' => 'users', 'action'=>'logout'));
											}
                           
									    }
										else{
											
											echo $this->Form->create('User', array('action' => 'login'));
											echo '<h1>Σύνδεση χρήστη</h1>';
											echo '<p>'.$this->Form->input('User.login_email', 
												  array('label' => array('class' => 'uname std_form', 'text' => 'To e-mail σας </br>', 'data-icon' => 'u'), 'div' => false, 'type' => 'text',
														'required' => 'required', 'id'=> 'UserUsername', 'placeholder' => 'π.χ. mymail@mail.com','class' => 'std_form')).'</p>';
												  
											echo '</br><p>'.$this->Form->input('User.login_password', 
												  array('label' => array('class' => 'youpasswd std_form', 'text' => 'O κωδικός σας  </br>', 'data-icon' => 'p'), 'div' => false, 'type' => 'password', 
														'required' => 'required', 'id'=> 'UserPassword', 'placeholder' => 'π.χ. X8df!90EO','class' => 'std_form')).'</p></br>';	
		
											echo '<p>'.$this->Form->end(array(
														'name' => 'data[User][login]',
														'label' => 'Σύνδεση',
														'div' => false,
														'class' => 'std_form no_shadow' )).'</p>';	
										    echo $this->Html->link('Δεν είστε μέλος? Εγγραφείτε τώρα!', array('controller' => 'users', 'action'=>'register'),array('class' => 'to_register'));
										}
								    ?>
                                    
									
								</div>
							</div>
							<!--telos pop up-->
							
					
					
					    
						
						
					</li>
					<li><?php echo $this->Html->link('Επικοινωνία', array('controller' => 'pages', 'action'=>'communication'));?></li>
                                        <li><?php echo $this->Html->link('Βοήθεια', array('controller' => 'pages', 'action'=>'help'));?></li>
					<li><?php echo $this->Html->link('Οι σκοποί μας', array('controller' => 'pages', 'action'=>'about'));?></li>
					<li><?php echo $this->Html->link('Αρχική', array('controller' => 'pages', 'action'=>'display'));?></li>
                    
					    
						
						
						
						
				</ul>
			</div>
		</div>
        
		<?php echo $content_for_layout ?>
        
	</body>
</html>