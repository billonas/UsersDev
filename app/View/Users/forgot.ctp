<?php $this->set('title_for_layout', 'Ξέχασα τον κωδικό μου - ΕΛΚΕΘΕ');?>
    	
		<div class="middle_row">
        	<div class="middle_wrapper">
                <div class="login_box">  
                    				<br><h1>Ξέχασες τον κωδικό σου;</h1></br>
					<div class="required" style="color:blue;font-size:14pt" >Συμπλήρωσε το email σου παρακάτω για να σταλεί email επιβεβαίωσης αλλαγής κωδικού</div></br>
									<?php echo $this->Form->create('User', array('action' => 'forgot'));?>
																		
                                    <div class="flash_box gradient"><?php echo $this->Session->flash().'</br>'; ?></div>
                                    <?php  echo $this->Form->input('User.email', array('label'=>false,'div' => false, 'type' => 'text', 'required' => 'required', 'id'=> 'UserPassword', 'class' => 'std_form blue_shadow'));	

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




