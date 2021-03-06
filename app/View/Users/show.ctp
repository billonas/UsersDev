<?php $this->set('title_for_layout', 'Προφίλ Χρήστη - ΕΛΚΕΘΕ');?> 
 
<?php echo $this->Html->css(array('main', 'jquery-ui', 'table')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min')); ?>

<script>

    $(document).ready(function()
    {
        // Add confirmation before delete
        $('a.deleteButton').click(function(e) {
            e.stopPropagation();
            return confirm('Είστε βέβαιος/η ότι θέλετε να διαγράψετε αυτόν τον χρήστη;');
        });
        
        // Add button style
        $('a.deleteButton, a.backButton, a.upgradeButton').button();
    });

</script>


    <div class="middle_row  big_row">
			<div class="middle_wrapper">
				<div class="register_box login_box" align="center">
			 		<br><h1>Προφίλ χρήστη</h1></br>

					<?php echo $this->Form->create('User', array('action' => 'edit'));?>
               <div class="flash_box"><?php echo $this->Session->flash().'</br>'; ?> </div>
                                        <table>
					<?php 
					echo '<tr><td><label for="UserName" class="name std_form">Όνομα:  </label></td><td><p>'.$this->Form->input('User.name', 
									      array('default'=>$user['User']['name'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
										  
				    echo '<tr><td><label for="UserSurname" class="surname std_form">Επώνυμο:  </label></td><td><p>'.$this->Form->input('User.surname', 
									      array('default'=>$user['User']['surname'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserSurame','placeholder' => 'π.χ. Κακομοίρογλου','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
										  
					
					echo '<tr><td><label for="UserEmail" class="mail std_form">e-mail:  </label></td><td><p>'.$this->Form->input('User.email', 
									      array('default'=>$user['User']['email'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserEmail', 'placeholder' => 'π.χ. mymail@mail.com','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
				    echo '<tr><td><label for="UserPhone" class="phone std_form">Τηλέφωνο:  </label></td><td><p>'.$this->Form->input('User.phone_number', 
									      array('default'=>$user['User']['phone_number'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserPhone','placeholder' => 'π.χ. 234385497','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
						  
					echo '<tr><td><label for="UserAddress" class="address std_form">Διεύθυνση:  </label></td><td><p>'.$this->Form->input('User.address', 
									      array('default'=>$user['User']['address'],'label' => false, 'div' => false, 'type' => 'text', 'id'=>	'UserAddress','placeholder' => 'π.χ Κολοπετινίτσας 100','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
					echo '<tr><td><label for="UserCity" class="city std_form">Πόλη:  </label></td><td><p>'.$this->Form->input('User.city', 
									      array('default'=>$user['User']['city'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserCity','placeholder' => 'π.χ. Καβάλα','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';	
					echo '<tr><td><label for="UserCountry" class="country std_form">Χώρα:  </label></td><td><p>'.$this->Form->input('User.country', 
									      array('default'=>$user['User']['country'], 'label' => false, 'div' => false, 'type' => 'text', 'id'=>'UserCountry','placeholder' => 'π.χ. Ελλάδα','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
					echo '<tr><td><label for="UserAge" class="age std_form">Ημ/νία γέννησης:  </label></td><td><p>'.$this->Form->input('User.birth_date', 
									      array('type'=>'date', 'empty'=>true, 'minYear'=>1901, 'maxYear'=>date('Y'), 'default'=>$user['User']['birth_date'],'label' => false, 'div' => false, 'id'=>'UserAge','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';		
					$options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια');  
					echo '<tr><td><label for="UserEducation" class="education std_form">Εκπαίδευση:  </label></td><td><p>'.$this->Form->input('User.education', 
									      array('default' => $user['User']['education'], 'options' => $options, 'label' => false, 'div' => false, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';										  									  									  
					$options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο'); 					  
					echo '<tr><td><label for="UserMembership" default="-" class="membership std_form">Ιδιότητα:  </label></td><td><p>'.$this->Form->input('User.membership', 
									      array('default'=>$user['User']['membership'], 'options'=> $options, 'label' => false, 'div' => false, 'id'=>'UserMembership','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr></br>';	
					?></table><?php					  
                                        $this->Form->end(array(
														'name' => 'data[User][edit]',
														'label' => 'Ανανέωση στοιχείων',
														'div' => false,
                                                        'class' => ' std_form'));									  
								    ?>
               
                                <div style="margin-top:2em; margin-left: auto; margin-right: auto;">
                                    <a class="backButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'edit_users', '?'=>'text=&userType1=analyst&userType2=simple&userType3=hyperanalyst&textType=surname'))?>" >
                                        <img class="icon" src="../../img/blackUpArrow.png" style="transform: rotate(270deg);-ms-transform: rotate(270deg);-webkit-transform: rotate(270deg);-o-transform: rotate(270deg);-moz-transform: rotate(270deg);"/>
                                        Πίσω
                                    </a>
                                    <a class="upgradeButton" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'create', $user['User']['id']))?>" >
                                        <img class="icon" src="../../img/blackUpArrow.png"/>
                                        Αναβάθμιση χρήστη
                                    </a>
                                    <a class="deleteButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'delete', $user['User']['id']))?>" >
                                        <img class="icon" src="../../img/whiteX.png"/>
                                        Διαγραφή χρήστη
                                    </a>
                                </div>
			    </div>
			</div>
    </div>
