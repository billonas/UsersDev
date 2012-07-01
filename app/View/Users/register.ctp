<?php $this->set('title_for_layout', 'Εγγραφή Χρήστη - ΕΛΚΕΘΕ');?> 
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
			 		<br><h1>Εγγραφή χρήστη</h1></br>
                    
					<div class="required" style="color:red">(υποχρεωτικά πεδία *)</div>
					<?php echo $this->Form->create('User', array('action' => 'register'));?>
               <div class="flash_box"><?php echo $this->Session->flash().'</br>'; ?> </div>
               <table>
                                       <td> <table>
					<?php 
                                        echo '<tr><td><label for="UserUsername" class="username std_form">Ψευδώνυμο χρήστη<span class="required" style="color:red"> *</span>:  </label></td><td><p>'.$this->Form->input('User.username', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserUsername','placeholder' => 'Τουλάχιστον 4 Χαρακτήρες','class' => ' std_form blue_shadow')).'</p></td></tr>';
					echo '<tr><td><label for="UserName" class="name std_form">Όνομα<span class="required" style="color:red"> *</span>:  </label></td><td><p>'.$this->Form->input('User.name', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow')).'</p></td></tr>';
										  
                                        echo '<tr><td><label for="UserSurname" class="surname std_form">Επώνυμο<span class="required" style="color:red"> *</span>:  </label></td><td><p>'.$this->Form->input('User.surname', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserSurame','placeholder' => 'π.χ. Κακομοίρογλου','class' => ' std_form blue_shadow')).'</p></td></tr>';
										  
					
					echo '<tr><td><label for="UserEmail" class="mail std_form">e-mail<span class="required" style="color:red"> *</span>:  </label></td><td><p>'.$this->Form->input('User.email', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'required' => 'required', 'id'=> 'UserEmail', 'placeholder' => 'π.χ. mymail@mail.com','class' => ' std_form blue_shadow')).'</p></td></tr>';

                                        echo '<tr><td><label for="UserPassword" class="youpasswd std_form">Κωδικός<span class="required" style="color:red"> *</span>:  </label></td><td><p>'.$this->Form->input('User.password', 
                                                                                array('label' => false, 'div' => false, 'type' => 'password', 'required' => 'required', 'id'=> 'UserPassword','placeholder' => 'Τουλάχιστον 8 Χαρακτήρες','class' => 'std_form blue_shadow')).'</p></td></tr>';	

                                        echo '<tr><td><label for="UserPasswordCfm" class="youpasswdcfm std_form">Επαναλάβετε τον Κωδικό<span class="required" style="color:red"> *</span>:  </label></td><td><p>'.$this->Form->input('User.passwordConfirm', 
                                                                                array('label' => false, 'div' => false, 'type' => 'password', 'required' => 'required', 'id'=> 'UserPasswordCfm','placeholder' => 'Τουλάχιστον 8 Χαρακτήρες','class' => ' std_form blue_shadow')).'</p></td></tr>';			  
                                        echo '</table></td><td><table>';
                                        echo '<tr><td><label for="UserPhone" class="phone std_form">Τηλέφωνο:  </label></td><td><p>'.$this->Form->input('User.phone_number', 
                                                                                array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserPhone','placeholder' => 'π.χ. 234385497','class' => ' std_form blue_shadow')).'</p></td></tr>';
					echo '<tr><td><label for="UserAddress" class="address std_form">Διεύθυνση:  </label></td><td><p>'.$this->Form->input('User.address', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=>	'UserAddress','placeholder' => 'π.χ Κολοπετινίτσας 100','class' => ' std_form blue_shadow')).'</p></td></tr>';
					echo '<tr><td><label for="UserCity" class="city std_form">Πόλη:  </label></td><td><p>'.$this->Form->input('User.city', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'UserCity','placeholder' => 'π.χ. Καβάλα','class' => ' std_form blue_shadow')).'</p></td></tr>';	
					echo '<tr><td><label for="UserCountry" class="country std_form">Χώρα:  </label></td><td><p>'.$this->Form->input('User.country', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=>'UserCountry','placeholder' => 'π.χ. Ελλάδα','class' => ' std_form blue_shadow')).'</p></td></tr>';
					
                                        $monthOptions = array('01' => 'Ιανουαρίου','02' => 'Φεβρουαρίου','03' => 'Μαρτίου','04' => 'Απριλίου','05' => 'Μαΐου','06' => 'Ιουνίου',
                                             '07' => 'Ιουλίου','08' => 'Αυγούστου','09' => 'Σεπτεμβρίου','10' => 'Οκτωβρίου','11' => 'Νοεμβρίου', '12' => 'Δεκεμβρίου');
                        
                                        echo '<tr><td><label for="UserAge" class="age std_form">Ημ/νία γέννησης:  </label></td><td><p>';
                                        echo $this->Form->day('User.birth_date', array('label'=> false, 'empty' => 'Ημέρα'));
                                        echo $this->Form->month('User.birth_date', array('label'=> false, 'monthNames' => $monthOptions, 'empty' => 'Μήνας'));
                                        echo $this->Form->year('User.birth_date', date('Y') - 110, date('Y'), array('label'=> false, 'empty' => "Χρονιά"));
                                     
                                        $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια');  
					echo '<tr><td><label for="UserEducation" class="education std_form">Εκπαίδευση:  </label></td><td><p>'.$this->Form->input('User.education', 
									      array('options' => $options, 'default' => '  -  ', 'label' => false, 'div' => false, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow')).'</p></td></tr>';										  									  									  
					$options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο'); 					  
					echo '<tr><td><label for="UserMembership" default="-" class="membership std_form">Ιδιότητα:  </label></td><td><p>'.$this->Form->input('User.membership', 
									      array('options'=> $options, 'label' => false, 'div' => false, 'id'=>'UserMembership','class' => ' std_form blue_shadow')).'</p></td></tr></br>';	
					
				                                       
					?></td></table>	
               </table>
                                </div>
                            <div align="center">
                                        <table><tr><td>
					<?php echo $this->Recaptcha->show(array(
						'theme' => 'white',
						'custom_translations' => array('instructions_visual' => 'Γράψτε τις λέξεις')	
					));
                                        
   					echo $this->Recaptcha->error();	 ?>
                                        </td><td><?php echo '<a id="a1_right" href="#">'.$this->Html->image('info.png').'</a>';?></td></tr></table>
                                      
				<?php echo '</div><div class="register_box login_box" align="center">';	
					echo '</br><p>'.$this->Form->end(array(
									'name' => 'data[User][register]',
									'label' => 'Εγγραφή',
									'div' => false,
									'class' => ' std_form')).'</p>';									  
					 ?>
			    </div>
			</div>
    </div>


<div id="tip1_right" style="display:none;">
    <div>Συμπληρώνοντας τις λέξεις της εικόνας μας βοηθάτε να προστατέψουμε 
    τη σελίδα από κακόβουλο λογισμικό</div>
</div>