<?php $this->set('title_for_layout', 'Εγγραφή Χρήστη - ΕΛΚΕΘΕ');?> 
 
    <div class="middle_row  big_row">
			<div class="middle_wrapper">
				<div class="register_box login_box" align="center">
			 		<br><h1>Εγγραφή χρήστη</h1></br>
                    
					<?php echo $this->Form->create('User', array('action' => 'register'));?>
               <div class="flash_box"><?php echo $this->Session->flash().'</br>'; ?> </div>
                                        <table>
					<?php 
					echo '<tr><td><label for="UserName" class="name std_form">Όνομα:  </label></td><td><p>'.$this->Form->input('User.name', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow')).'</p></td></tr>';
										  
				    echo '<tr><td><label for="UserSurname" class="surname std_form">Επώνυμο:  </label></td><td><p>'.$this->Form->input('User.surname', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserSurame','placeholder' => 'π.χ. Κακομοίρογλου','class' => ' std_form blue_shadow')).'</p></td></tr>';
										  
				    echo '<tr><td><label for="UserPhone" class="phone std_form">Τηλέφωνο:  </label></td><td><p>'.$this->Form->input('User.phone_number', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserPhone','placeholder' => 'π.χ. 234385497','class' => ' std_form blue_shadow')).'</p></td></tr>';
					
					echo '<tr><td><label for="UserEmail" class="mail std_form">e-mail:  </label></td><td><p>'.$this->Form->input('User.email', 
									      array('after'=>$this->Form->error('email_unique', 'H συγκεκριμένη διεύθυνση ηλεκτρονικού ταχυδρομείου χρησιμοποιείται ήδη. Παρακαλώ δοκιμάστε άλλη.'),'label' => false, 'div' => false, 'type' => 'text', 'required' => 'required', 'id'=> 'UserEmail', 'placeholder' => 'π.χ. mymail@mail.com','class' => ' std_form blue_shadow')).'</p></td></tr>';
										  
				    echo '<tr><td><label for="UserPassword" class="youpasswd std_form">Κωδικός:  </label></td><td><p>'.$this->Form->input('User.password', 
									      array('label' => false, 'div' => false, 'type' => 'password', 'required' => 'required', 'id'=> 'UserPassword','placeholder' => 'example111','class' => 'std_form blue_shadow')).'</p></td></tr>';	
										  
				    echo '<tr><td><label for="UserPasswordCfm" class="youpasswdcfm std_form">Επαναλάβετε τον Κωδικό:  </label></td><td><p>'.$this->Form->input('User.passwordConfirm', 
									      array('label' => false, 'div' => false, 'type' => 'password', 'required' => 'required', 'id'=> 'UserPasswordCfm','placeholder' => 'example111','class' => ' std_form blue_shadow')).'</p></td></tr>';			  
					echo '<tr><td><label for="UserAddress" class="address std_form">Διεύθυνση:  </label></td><td><p>'.$this->Form->input('User.address', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=>	'UserAddress','placeholder' => 'π.χ Κολοπετινίτσας 100','class' => ' std_form blue_shadow')).'</p></td></tr>';
					echo '<tr><td><label for="UserCity" class="city std_form">Πόλη:  </label></td><td><p>'.$this->Form->input('User.city', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserCity','placeholder' => 'π.χ. Καβάλα','class' => ' std_form blue_shadow')).'</p></td></tr>';	
					echo '<tr><td><label for="UserCountry" class="country std_form">Χώρα:  </label></td><td><p>'.$this->Form->input('User.country', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=>'UserCountry','placeholder' => 'π.χ. Ελλάδα','class' => ' std_form blue_shadow')).'</p></td></tr>';
					echo '<tr><td><label for="UserAge" class="age std_form">Ημ/νία γέννησης:  </label></td><td><p>'.$this->Form->input('User.birth_date', 
									      array('type'=>'date', 'empty'=>true, 'minYear'=>1901, 'maxYear'=>date('Y'), 'label' => false, 'div' => false, 'id'=>'UserAge','class' => ' std_form blue_shadow')).'</p></td></tr>';		
					$options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια');  
					echo '<tr><td><label for="UserEducation" class="education std_form">Εκπαίδευση:  </label></td><td><p>'.$this->Form->input('User.education', 
									      array('options' => $options, 'default' => '  -  ', 'label' => false, 'div' => false, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow')).'</p></td></tr>';										  									  									  
					$options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο'); 					  
					echo '<tr><td><label for="UserMembership" default="-" class="membership std_form">Ιδιότητα:  </label></td><td><p>'.$this->Form->input('User.membership', 
									      array('options'=> $options, 'label' => false, 'div' => false, 'id'=>'UserMembership','class' => ' std_form blue_shadow')).'</p></td></tr></br>';	
					echo '<tr><td></td><td>';					  
					echo $this->Html->Image($this->Html->url(array('controller'=>'users', 'action'=>'captcha'), true),array('style'=>'','vspace'=>2)); 
					echo '</td></tr>';
					echo '<tr><td><label for="UserCaptcha" class="captcha std_form">Γράψτε αυτά που βλέπετε στην εικόνα:  </label></td><td><p>'.$this->Form->input('User.captcha', 
									  array('label' => false, 'autocomplete'=>'off', 'div' => false, 'type' => 'text', 'id'=> 'UserCaptcha', 'error'=>__('Failed validating code',true),'class' => ' std_form blue_shadow')).'</p></td></tr>';		  	
                                        
					?></table><?php					  
                                        echo '</br><p>'.$this->Form->end(array(
														'name' => 'data[User][register]',
														'label' => 'Εγγραφή',
														'div' => false
                                                                                                                ,'class' => ' std_form')).'</p>';									  
								    ?>
			    </div>
			</div>
    </div>