<?php $this->set('title_for_layout', 'Προφίλ Χρήστη - ΕΛΚΕΘΕ');?> 
<?php echo $this->Html->css(array('jquery-ui','bubbletip'),null, array('inline'=>false)); ?>
<?php echo $this->Html->script(array('jquery.min','jQuery.bubbletip-1.0.6'), array('inline'=>false));?>

<script>
$(document).ready(function(){
  
    $(window).bind('load', function() {
	$('#a1_right').bubbletip($('#tip1_right'), { calculateOnShow: true, deltaDirection: 'up' , offsetTop: -45 });
    });  
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
                                        
                                         echo '<tr><td><label for="UserUsername" class="username std_form">Ψευδώνυμο χρήστη:  </label></td><td><p>'.$user['User']['username'].'</p></td></tr>';
					
					echo '<tr><td><label for="UserName" class="name std_form">Όνομα:  </label></td><td><p>'.$this->Form->input('User.name', 
									      array('default'=>$user['User']['name'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow')).'</p></td></tr>';
										  
				    echo '<tr><td><label for="UserSurname" class="surname std_form">Επώνυμο:  </label></td><td><p>'.$this->Form->input('User.surname', 
									      array('default'=>$user['User']['surname'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserSurame','placeholder' => 'π.χ. Κακομοίρογλου','class' => ' std_form blue_shadow')).'</p></td></tr>';
										  
					
					echo '<tr><td><label for="UserEmail" class="mail std_form">E-mail:  </label></td><td><p>';
                                        echo $user['User']['email'].'</p></td><td><a id="a1_right" href="#">'.$this->Html->image('info.png').'</a></td></tr>';
                                        
                                        
                                        echo '<tr><td><label for="UserPhone" class="phone std_form">Τηλέφωνο:  </label></td><td><p>'.$this->Form->input('User.phone_number', 
									      array('default'=>$user['User']['phone_number'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserPhone','placeholder' => 'π.χ. 234385497','class' => ' std_form blue_shadow')).'</p></td></tr>';
						  
					echo '<tr><td><label for="UserAddress" class="address std_form">Διεύθυνση:  </label></td><td><p>'.$this->Form->input('User.address', 
									      array('default'=>$user['User']['address'],'label' => false, 'div' => false, 'type' => 'text', 'id'=>	'UserAddress','placeholder' => 'π.χ Κολοπετινίτσας 100','class' => ' std_form blue_shadow')).'</p></td></tr>';
					echo '<tr><td><label for="UserCity" class="city std_form">Πόλη:  </label></td><td><p>'.$this->Form->input('User.city', 
									      array('default'=>$user['User']['city'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserCity','placeholder' => 'π.χ. Καβάλα','class' => ' std_form blue_shadow')).'</p></td></tr>';	
					echo '<tr><td><label for="UserCountry" class="country std_form">Χώρα:  </label></td><td><p>'.$this->Form->input('User.country', 
									      array('default'=>$user['User']['country'], 'label' => false, 'div' => false, 'type' => 'text', 'id'=>'UserCountry','placeholder' => 'π.χ. Ελλάδα','class' => ' std_form blue_shadow')).'</p></td></tr>';
					echo '<tr><td><label for="UserAge" class="age std_form">Ημ/νία γέννησης:  </label></td><td><p>'.$this->Form->input('User.birth_date', 
									      array('type'=>'date', 'empty'=>true, 'minYear'=>1901, 'maxYear'=>date('Y'), 'default'=>$user['User']['birth_date'],'label' => false, 'div' => false, 'id'=>'UserAge','class' => ' std_form blue_shadow')).'</p></td></tr>';		
					$options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια');  
					echo '<tr><td><label for="UserEducation" class="education std_form">Εκπαίδευση:  </label></td><td><p>'.$this->Form->input('User.education', 
									      array('default' => $user['User']['education'], 'options' => $options, 'label' => false, 'div' => false, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow')).'</p></td></tr>';										  									  									  
					$options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο'); 					  
					echo '<tr><td><label for="UserMembership" default="-" class="membership std_form">Ιδιότητα:  </label></td><td><p>'.$this->Form->input('User.membership', 
									      array('default'=>$user['User']['membership'], 'options'=> $options, 'label' => false, 'div' => false, 'id'=>'UserMembership','class' => ' std_form blue_shadow')).'</p></td></tr></br>';	
					?>
                                        
                                        <?php
                                        
                                        if(!strcmp($this->Session->read('UserType'),'analyst') || !strcmp($this->Session->read('UserType'),'hyperanalyst')){
                                            echo '<tr><td colspan="2">________________</td></tr>';
                                            echo '<tr><td><label for="UserCategory1" class="mail std_form">Κατηγορία ειδίκευσης 1:  </label></td><td><p>';
                                            if(!empty($user['Analyst']['Category1']['category_name']))
                                                echo $user['Analyst']['Category1']['category_name'].'</p></td></tr>';
                                            else
                                                echo '- </p></td></tr>';
                                            
                                            echo '<tr><td><label for="UserCategory2" class="mail std_form">Κατηγορία ειδίκευσης 2:  </label></td><td><p>';
                                            if(!empty($user['Analyst']['Category2']['category_name']))
                                                echo $user['Analyst']['Category2']['category_name'].'</p></td></tr>';
                                            else
                                                echo '- </p></td></tr>';
                                                    
                                            echo '<tr><td><label for="UserInstitute" class="mail std_form">Ινστιτούτο:  </label></td><td><p>';
                                            if(!empty($user['Analyst']['research_institute']))
                                                echo $user['Analyst']['research_institute'].'</p></td></tr>';
                                            else
                                                echo '- </p></td></tr>';
                                            
                                        }
                                        
                                        ?>
                                        
                                        
                                        
                                        
                                        </table><?php					  
                                        echo '</br><p>'.$this->Form->end(array(
														'name' => 'data[User][edit]',
														'label' => 'Ανανέωση στοιχείων',
														'div' => false,
                                                        'class' => ' std_form')).'</p></br></br>';									  
								    ?>
			    </div>
			</div>
    </div>



<div id="tip1_right" style="display:none;">
    <div>Αν θέλετε αλλάξετε το e-mail ή τον κωδικό σας μπορείτε να το κάνετε μέσα απο τις <?php echo $this->Html->link('ρυθμίσεις λογαριασμού', array('controller' => 'Users', 'action'=>'account'),array('target' => '_blank'));?> </div>
</div>

