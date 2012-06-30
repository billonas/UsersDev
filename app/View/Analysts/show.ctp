<div class="middle_row  big_row">
			<div class="middle_wrapper">
				<div class="register_box login_box" align="center">
			 		<br><h1>Προφίλ αναλυτή</h1></br>

					<?php echo $this->Form->create('Analyst', array('action' => 'edit'));?>
               <div class="flash_box"><?php echo $this->Session->flash().'</br>'; ?> </div>
                                        <table>
					<?php 
					echo '<tr><td><label for="AnalystName" class="name std_form">Όνομα:  </label></td><td><p>'.$this->Form->input('Analyst.name', 
									      array('default'=>$analyst['User']['name'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
										  
				    echo '<tr><td><label for="AnalystSurname" class="surname std_form">Επώνυμο:  </label></td><td><p>'.$this->Form->input('Analyst.surname', 
									      array('default'=>$analyst['User']['surname'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystSurname','placeholder' => 'π.χ. Κακομοίρογλου','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
										  
					
					echo '<tr><td><label for="AnalystEmail" class="mail std_form">e-mail:  </label></td><td><p>'.$this->Form->input('Analyst.email', 
									      array('default'=>$analyst['User']['email'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystEmail', 'placeholder' => 'π.χ. mymail@mail.com','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
				    echo '<tr><td><label for="AnalystPhone" class="phone std_form">Τηλέφωνο:  </label></td><td><p>'.$this->Form->input('Analyst.phone_number', 
									      array('default'=>$analyst['User']['phone_number'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystPhone','placeholder' => 'π.χ. 234385497','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
						  
					echo '<tr><td><label for="AnalystAddress" class="address std_form">Διεύθυνση:  </label></td><td><p>'.$this->Form->input('Analyst.address', 
									      array('default'=>$analyst['User']['address'],'label' => false, 'div' => false, 'type' => 'text', 'id'=>	'AnalystAddress','placeholder' => 'π.χ Κολοπετινίτσας 100','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
					echo '<tr><td><label for="AnalystCity" class="city std_form">Πόλη:  </label></td><td><p>'.$this->Form->input('Analyst.city', 
									      array('default'=>$analyst['User']['city'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystCity','placeholder' => 'π.χ. Καβάλα','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';	
					echo '<tr><td><label for="AnalystCountry" class="country std_form">Χώρα:  </label></td><td><p>'.$this->Form->input('Analyst.country', 
									      array('default'=>$analyst['User']['country'], 'label' => false, 'div' => false, 'type' => 'text', 'id'=>'AnalystCountry','placeholder' => 'π.χ. Ελλάδα','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
					echo '<tr><td><label for="AnalystAge" class="age std_form">Ημ/νία γέννησης:  </label></td><td><p>'.$this->Form->input('Analyst.birth_date', 
									      array('type'=>'date', 'empty'=>true, 'minYear'=>1901, 'maxYear'=>date('Y'), 'default'=>$analyst['User']['birth_date'],'label' => false, 'div' => false, 'id'=>'AnalystAge','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';		
					$options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια');  
					echo '<tr><td><label for="AnalystEducation" class="education std_form">Εκπαίδευση:  </label></td><td><p>'.$this->Form->input('Analyst.education', 
									      array('default' => $analyst['User']['education'], 'options' => $options, 'label' => false, 'div' => false, 'id'=> 'AnalystEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';										  									  									  
					$options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο'); 					  
					echo '<tr><td><label for="AnalystMembership" default="-" class="membership std_form">Ιδιότητα:  </label></td><td><p>'.$this->Form->input('Analyst.membership', 
									      array('default'=>$analyst['User']['membership'], 'options'=> $options, 'label' => false, 'div' => false, 'id'=>'AnalystMembership','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr></br>';	
					echo '<tr><td><label for="AnalystCategory1" class="name std_form">Κατηγορία ειδίκευσης:  </label></td><td><p>'.$this->Form->input('Analyst.category1', 
									      array('default'=>$analyst['Category1']['category_name'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
					echo '<tr><td><label for="AnalystCategory2" class="name std_form">Κατηγορία ειδίκευσης:  </label></td><td><p>'.$this->Form->input('Analyst.category2', 
									      array('default'=>$analyst['Category2']['category_name'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
					echo '<tr><td><label for="AnalystInstitute" class="name std_form">Ινστιτούτο:  </label></td><td><p>'.$this->Form->input('Analyst.name', 
									      array('default'=>$analyst['Analyst']['research_institute'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
					?></table><?php					  
                                        $this->Form->end(array(
														'name' => 'data[Analyst][edit]',
														'label' => 'Ανανέωση στοιχείων',
														'div' => false,
                                                        'class' => ' std_form'));									  
								    ?>
			    </div>
			</div>
    <
