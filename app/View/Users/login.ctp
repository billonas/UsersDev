<?php $this->set('title_for_layout', 'Σύνδεση Χρήστη - ΕΛΚΕΘΕ');?>
    	
		<div class="middle_row">
        	<div class="middle_wrapper">
                <div class="login_box">  
                    				<br><h1>Σύνδεση χρήστη</h1></br>
									<?php echo $this->Form->create('User', array('action' => 'login'));?>
																		
                                    <div class="flash_box gradient"><?php echo $this->Session->flash().'</br>'; ?></div>
                                    <?php echo '<p>'.$this->Form->input('User.login_email', 
									      array('label' => array('class' => 'uname std_form', 'text' => 'To e-mail σας </br>'), 'div' => false, 'type' => 'text', 'required' => 'required', 'id'=> 'UserUsername', 'placeholder' => 'π.χ. mymail@mail.com','class' => 'std_form blue_shadow')).'</p>';
										  
									      echo '</br><p>'.$this->Form->input('User.login_password', array('label' => array('class' => 'youpasswd std_form', 'text' => 'O κωδικός σας </br>'), 'div' => false, 'type' => 'password', 'required' => 'required', 'id'=> 'UserPassword', 'placeholder' => 'π.χ. X8df!90EO', 'class' => 'std_form blue_shadow')).'</p></br>';	

										  echo '<p>'.$this->Form->end(array(
														'name' => 'data[User][login]',
														'label' => 'Σύνδεση',
														'div' => false,
                                                                                                                'class' => 'std_form')).'</p>';									  
								    ?>
                                    <div class="link_holder"><strong>
                                    <?php echo $this->Html->link('Δεν είστε μέλος? Εγγραφείτε τώρα!', array('controller' => 'users', 'action'=>'register'));?>
                                        </strong>
                                    </div>
                                    </br>
                                    <div class="link_holder">
                                        <strong>
                                    <?php echo $this->Html->link('Ξέχασα τον κωδικό μου', array('controller' => 'users', 'action'=>'forgot'));?>
                                        </strong>
                                    </div>
                </div>
        </div>
	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>

