<?php $this->set('title_for_layout', 'Αλλαγή ηλεκτρονικής διεύθυνσης - ΕΛΚΕΘΕ');?>
    	
		<div class="middle_row">
        	<div class="middle_wrapper">
                <div class="login_box white_box">  
                    				<br><h1>Αλλαγή ηλεκτρονικής διεύθυνσης</h1></br>
					<div class="required" style="color:blue">(κατά την αλλαγή ηλεκτρονικού ταχυδρομείου θα χρειαστεί να αποσυνδεθείτε αυτόματα και να επικυρώσετε την νέα διεύθυνση)</div>
									<?php echo $this->Form->create('User', array('action' => 'change_email'));?>
																		
                                    <div class="flash_box gradient"><?php echo $this->Session->flash().'</br>'; ?></div>
                                    <?php echo '<p>'.$this->Form->input('User.old_email', 
									      array('label' => array('class' => 'uname std_form', 'text' => 'Tωρινό email: </br>', 'style'=>'color:red'), 'div' => false, 'type' => 'text', 'required' => 'required', 'id'=> 'UserUsername', 'class' => 'std_form blue_shadow')).'</p>';
										  
									      echo '</br><p>'.$this->Form->input('User.email', array('label' => array('class' => 'youpasswd std_form', 'text' => 'Νέο email:</br>', 'style'=>'color:green'), 'div' => false, 'type' => 'text', 'required' => 'required', 'id'=> 'UserPassword', 'class' => 'std_form blue_shadow')).'</p></br>';	

										  echo '<p>'.$this->Form->end(array(
														'label' => 'Αλλαγή',
														'div' => false,
                                                                                                                'class' => 'std_form')).'</p>';									  
								    ?>
                                    <div class="link_holder">
                                        <strong>
                                    <?php echo $this->Html->link('Επιστροφή στις ρυθμίσεις λογαριασμού', array('controller' => 'users', 'action'=>'account'));?>
                                        </strong>
                                    </div>

                </div>
        </div>
	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>



