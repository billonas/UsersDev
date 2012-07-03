<?php $this->set('title_for_layout', 'Αλλαγή κωδικού - ΕΛΚΕΘΕ');?>
    	
		<div class="middle_row">
        	<div class="middle_wrapper">
                <div class="login_box">  
                    				<br><h1>Αλλαγή κωδικού</h1></br>
									<?php echo $this->Form->create('User', array('action' => 'reset_password'));?>
																		
                                    <div class="flash_box gradient"><?php echo $this->Session->flash().'</br>'; ?></div>
                                    <?php echo '<p>'.$this->Form->input('User.password', 
									      array('label' => array('class' => 'uname std_form', 'text' => 'Νέος κωδικός: </br>', 'style'=>'color:green'), 'div' => false, 'type' => 'password', 'required' => 'required', 'id'=> 'UserUsername', 'class' => 'std_form blue_shadow')).'</p>';
										  
									      echo '</br><p>'.$this->Form->input('User.passwordConfirm', array('label' => array('class' => 'youpasswd std_form', 'text' => 'Επιβεβαίωση νέου κωδικόυ:</br>', 'style'=>'color:green'), 'div' => false, 'type' => 'password', 'required' => 'required', 'id'=> 'UserPassword', 'class' => 'std_form blue_shadow')).'</p></br>';	
                                  echo $this->Form->input('User.post_id', array('type' => 'hidden', 'value' => $post_id));
                                  echo $this->Form->input('User.in_hash', array('type' => 'hidden', 'value' => $in_hash));

										  echo '<p>'.$this->Form->end(array(
														'label' => 'Αλλαγή',
														'div' => false,
                                                                                                                'class' => 'std_form')).'</p>';									  
								    ?>
                                    <div class="link_holder">
                                        <strong>
                                    <?php echo $this->Html->link('Επιστροφή στην αρχική σελίδα', array('controller' => 'pages', 'action'=>'display'));?>
                                        </strong>
                                    </div>

                </div>
        </div>
	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
