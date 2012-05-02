<?php $this->set('title_for_layout', 'Επεξεργασία Προφίλ - ΕΛΚΕΘΕ');?> 
 
    <div class="middle_row">
			<div class="middle_wrapper">
				<div class="edit" align="center">
			 		<br><h1>Επεξεργασία Προφίλ χρήστη</h1></br>
					<?php echo $this->Form->create('User', array('action' => 'edit'));?>
               <?php echo $this->Session->flash().'</br>'; ?> 
					<?php 
					echo '<p>'.$this->Form->input('User.name', 
									      array('default'=>$user['User']['name'], 'label' => array('class' => 'name', 'text' => 'Όνομα:  '), 'div' => false, 'type' => 'text', 'id'=> 												 												'UserName')).'</p>';
										  
				    echo '</br><p>'.$this->Form->input('User.surname', 
									      array('default'=>$user['User']['surname'],'label' => array('class' => 'surname', 'text' => 'Επώνυμο:  '), 'div' => false, 'type' => 'text', 'id'=> 												 												'UserSurame')).'</p>';
										  
				    echo '</br><p>'.$this->Form->input('User.phone_number', 
									      array('default'=>$user['User']['phone_number'],'label' => array('class' => 'phone', 'text' => 'Τηλέφωνο:  '), 'div' => false, 'type' => 'text', 'id'=> 												 												'UserSurame')).'</p>';
					
					echo '</br><p>'.$this->Form->input('User.email', 
									      array('after'=>$this->Form->error('email_unique', 'H συγκεκριμένη διεύθυνση ηλεκτρονικού ταχυδρομείου χρησιμοποιείται ήδη. Παρακαλώ δοκιμάστε άλλη.'), 'default'=>$user['User']['email'],'label' => array('class' => 'mail', 'text' => 'e-mail:  '), 'div' => false, 'type' => 'text', 'required' => 'required', 'id'=> 												 												'UserEmail', 'placeholder' => 'π.χ. mymail@mail.com')).'</p>';
										  
										  
					echo '</br><p>'.$this->Form->input('User.address', 
									      array('default'=>$user['User']['address'], 'label' => array('class' => 'address', 'text' => 'Διεύθυνση:  '), 'div' => false, 'type' => 'text', 'id'=> 												 												'UserAddress')).'</p>';
					echo '</br><p>'.$this->Form->input('User.city', 
									      array('default'=>$user['User']['city'], 'label' => array('class' => 'city', 'text' => 'Πόλη:  '), 'div' => false, 'type' => 'text', 'id'=> 												 												'UserCity')).'</p>';	
					echo '</br><p>'.$this->Form->input('User.country', 
									      array('default'=>$user['User']['country'], 'label' => array('class' => 'country', 'text' => 'Χώρα:  '), 'div' => false, 'type' => 'text', 'id'=> 												 												'UserCountry')).'</p>';
					echo '</br><p>'.$this->Form->input('User.birth_date', 
									      array('default'=>$user['User']['birth_date'],'label' => array('class' => 'age', 'text' => 'Ημ/νία γέννησης:  '), 'div' => false, 'type' => 'text', 'id'=> 												 												'UserAge')).'</p>';	
					$options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','uptothird' => 'Τριτοβάθμια');  
					echo '</br><p>'.$this->Form->input('User.education', 
									      array('options' => $options, 'default' => $user['User']['education'], 'label' => array('class' => 'education', 'text' => 'Εκπαίδευση:  '), 'div' => false, 'id'=> 												 												'UserEducation')).'</p>';										  									  									  
					$options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο'); 					  
					echo '</br><p>'.$this->Form->input('User.membership', 
									      array('options'=> $options, 'default'=>$user['User']['membership'], 'label' => array('class' => 'membership', 'text' => 'Ιδιότητα:  '), 'div' => false, 'id'=> 												 												'UserMembership')).'</p>';										  	

										  echo '</br><p>'.$this->Form->end(array(
														'name' => 'data[User][edit]',
														'label' => 'Ανανέωση',
														'div' => false )).'</p>';									  
								    ?>
			    </div>
			</div>
    </div>
