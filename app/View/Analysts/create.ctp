<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'jquery.metadata.js')); ?>

<script>
$(document).ready(function()
{ 
    $('a.backButton, input[type="submit"]').button();
});
</script>

<div class="middle_row  big_row"><?php $this->set('title_for_layout', 'Δημιουργία αναλυτή - ΕΛΚΕΘΕ');?> 

			<div class="middle_wrapper">
				<div class="register_box login_box white_box" align="center">
			 		<br><h1>Δημιουργία αναλυτή</h1></br>

					<?php echo $this->Form->create('Analyst', array('action' => 'create'));?>
               <div class="flash_box"><?php echo $this->Session->flash().'</br>'; ?> </div>
                                        <table>
					<?php 
               echo '<tr><td><label for="AnalystId" class="name std_form"></label></td><td><p>'.$this->Form->input('Analyst.id', array('type' => 'hidden', 'value' => $post_id));
                                        
                                        if(isset($user['User']['user_type']) & !strcmp($user['User']['user_type'],'simple')){
                                                echo '<tr><td><label for="AnalystName" class="name std_form">Ψευδώνυμο χρήστη:  </label></td><td><p>'.$this->Form->input('Analyst.username', 
                                                                                    array('default'=>$user['User']['username'],'readonly'=>'readonly', 'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                echo '<tr><td><label for="AnalystName" class="name std_form">Όνομα:  </label></td><td><p>'.$this->Form->input('Analyst.name', 
                                                                                    array('default'=>$user['User']['name'],'readonly'=>'readonly', 'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                echo '<tr><td><label for="AnalystSurname" class="surname std_form">Επώνυμο:  </label></td><td><p>'.$this->Form->input('Analyst.surname', 
                                                                                    array('default'=>$user['User']['surname'],'label' => false, 'readonly'=>'readonly',  'div' => false, 'type' => 'text', 'id'=> 'AnalystSurame','placeholder' => 'π.χ. Κακομοίρογλου','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                echo '<tr><td><label for="UserEmail" class="mail std_form">e-mail:  </label></td><td><p>'.$this->Form->input('Analyst.email', 
                                                                                    array('default'=>$user['User']['email'],'label' => false, 'div' => false, 'type' => 'text','readonly'=>'readonly',  'id'=> 'AnalystEmail', 'placeholder' => 'π.χ. mymail@mail.com','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                echo '<tr><td><label for="AnalystPhone" class="phone std_form">Τηλέφωνο:  </label></td><td><p>'.$this->Form->input('Analyst.phone_number', 
                                                                                    array('default'=>$user['User']['phone_number'],'readonly'=>'readonly', 'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystPhone','placeholder' => 'π.χ. 234385497','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                echo '<tr><td><label for="AnalystAddress" class="address std_form">Διεύθυνση:  </label></td><td><p>'.$this->Form->input('Analyst.address', 
                                                                                    array('default'=>$user['User']['address'],'label' => false, 'div' => false, 'type' => 'text', 'readonly'=>'readonly', 'id'=>	'AnalystAddress','placeholder' => 'π.χ Κολοπετινίτσας 100','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                echo '<tr><td><label for="AnalystCity" class="city std_form">Πόλη:  </label></td><td><p>'.$this->Form->input('Analyst.city', 
                                                                                    array('default'=>$user['User']['city'],'label' => false, 'div' => false, 'type' => 'text', 'readonly'=>'readonly', 'id'=> 'AnalystCity','placeholder' => 'π.χ. Καβάλα','class' => ' std_form blue_shadow')).'</p></td></tr>';	
                                                echo '<tr><td><label for="UserCountry" class="country std_form">Χώρα:  </label></td><td><p>'.$this->Form->input('Analyst.country', 
                                                                                    array('default'=>$user['User']['country'], 'label' => false, 'div' => false, 'type' => 'text','readonly'=>'readonly',  'id'=>'AnalystCountry','placeholder' => 'π.χ. Ελλάδα','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                echo '<tr><td><label for="AnalystAge" class="age std_form">Ημ/νία γέννησης:  </label></td><td><p>'.$this->Form->input('Analyst.birth_date', 
                                                                                    array('type'=>'date', 'empty'=>true, 'minYear'=>1901, 'maxYear'=>date('Y'), 'default'=>$user['User']['birth_date'],'disabled' => true, 'label' => false, 'div' => false, 'id'=>'AnalystAge','class' => ' std_form blue_shadow')).'</p></td></tr>';		
                                                $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια');  
                                                echo '<tr><td><label for="UserEducation" class="education std_form">Εκπαίδευση:  </label></td><td><p>'.$this->Form->input('Analyst.education', 
                                                                                    array('default' => $user['User']['education'], 'options' => $options, 'label' => false, 'div' => false, 'disabled' => true, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow')).'</p></td></tr>';										  									  									  
                                                $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο'); 					  
                                                echo '<tr><td><label for="UserMembership" default="-" class="membership std_form">Ιδιότητα:  </label></td><td><p>'.$this->Form->input('Analyst.membership', 
                                                                                    array('default'=>$user['User']['membership'], 'options'=> $options, 'label' => false, 'div' => false,'disabled' => true,  'id'=>'AnalystMembership','class' => ' std_form blue_shadow')).'</p></td></tr></br>';	
                                                
                                        }else{
                                                echo '<tr><td><label for="AnalystName" class="name std_form">Ψευδώνυμο χρήστη:  </label></td><td><p>'.$this->Form->input('Analyst.username', 
                                                                                    array('default'=>$user['User']['username'], 'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                          
                                                echo '<tr><td><label for="AnalystName" class="name std_form">Όνομα:  </label></td><td><p>'.$this->Form->input('Analyst.name', 
									      array('default'=>$user['User']['name'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','placeholder' => 'π.χ. Κακομοίρης','class' => ' std_form blue_shadow')).'</p></td></tr>';
										  
                                                echo '<tr><td><label for="AnalystSurname" class="surname std_form">Επώνυμο:  </label></td><td><p>'.$this->Form->input('Analyst.surname', 
                                                                                        array('default'=>$user['User']['surname'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystSurame','placeholder' => 'π.χ. Κακομοίρογλου','class' => ' std_form blue_shadow')).'</p></td></tr>';


                                                    echo '<tr><td><label for="UserEmail" class="mail std_form">e-mail:  </label></td><td><p>'.$this->Form->input('Analyst.email', 
                                                                                        array('default'=>$user['User']['email'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystEmail', 'placeholder' => 'π.χ. mymail@mail.com','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                echo '<tr><td><label for="AnalystPhone" class="phone std_form">Τηλέφωνο:  </label></td><td><p>'.$this->Form->input('Analyst.phone_number', 
                                                                                        array('default'=>$user['User']['phone_number'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystPhone','placeholder' => 'π.χ. 234385497','class' => ' std_form blue_shadow')).'</p></td></tr>';

                                                    echo '<tr><td><label for="AnalystAddress" class="address std_form">Διεύθυνση:  </label></td><td><p>'.$this->Form->input('Analyst.address', 
                                                                                        array('default'=>$user['User']['address'],'label' => false, 'div' => false, 'type' => 'text', 'id'=>	'AnalystAddress','placeholder' => 'π.χ Κολοπετινίτσας 100','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                    echo '<tr><td><label for="AnalystCity" class="city std_form">Πόλη:  </label></td><td><p>'.$this->Form->input('Analyst.city', 
                                                                                        array('default'=>$user['User']['city'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystCity','placeholder' => 'π.χ. Καβάλα','class' => ' std_form blue_shadow')).'</p></td></tr>';	
                                                    echo '<tr><td><label for="UserCountry" class="country std_form">Χώρα:  </label></td><td><p>'.$this->Form->input('Analyst.country', 
                                                                                        array('default'=>$user['User']['country'], 'label' => false, 'div' => false, 'type' => 'text', 'id'=>'AnalystCountry','placeholder' => 'π.χ. Ελλάδα','class' => ' std_form blue_shadow')).'</p></td></tr>';
                                                    echo '<tr><td><label for="AnalystAge" class="age std_form">Ημ/νία γέννησης:  </label></td><td><p>'.$this->Form->input('Analyst.birth_date', 
                                                                                        array('type'=>'date', 'empty'=>true, 'minYear'=>1901, 'maxYear'=>date('Y'), 'default'=>$user['User']['birth_date'],'label' => false, 'div' => false, 'id'=>'AnalystAge','class' => ' std_form blue_shadow')).'</p></td></tr>';		
                                                    $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια');  
                                                    echo '<tr><td><label for="UserEducation" class="education std_form">Εκπαίδευση:  </label></td><td><p>'.$this->Form->input('Analyst.education', 
                                                                                        array('default' => $user['User']['education'], 'options' => $options, 'label' => false, 'div' => false, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow')).'</p></td></tr>';										  									  									  
                                                    $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο'); 					  
                                                    echo '<tr><td><label for="UserMembership" default="-" class="membership std_form">Ιδιότητα:  </label></td><td><p>'.$this->Form->input('Analyst.membership', 
                                                                                        array('default'=>$user['User']['membership'], 'options'=> $options, 'label' => false, 'div' => false, 'id'=>'AnalystMembership','class' => ' std_form blue_shadow')).'</p></td></tr></br>';	
                                                    }
                if(isset($user['User']['user_type']) & strcmp($user['User']['user_type'],'simple') == 0)
                {
                  echo "<tr>";
                  echo "<td></td>";
                  echo '<td><span class="message" style="color:blue;font-size:14pt" >Συμπληρώστε τα στοιχεία αναλυτή</span></td>';
                  echo '</tr>';
                }

                                                    
					$options = array('Καμία Κατηγορία'=>'-','1' => 'Δεκάποδα/ Καβούρια/ Γαρίδες', '2' => 'Μαλάκια: Γαστερόποδα/Δίθυρα','3' => 'Ψάρια', '4' =>'Χταπόδια/ Καλαμάρια', '5' => 'Εχινόδερμα', '6' => 'Ασκίδια', '7' =>'Επιλιθικοί οργανισμοί: Βρυόζωα', '8' => 'Μέδουσες', '9' => 'Άλλοι πλαγκτονικοί οργανισμοί', '10' => 'Φύκη');  
					echo '<tr><td><label for="AnalystCategory" class="education std_form">Κατηγορία Ειδίκευσης:  </label></td><td><p>'.$this->Form->input('Analyst.category1', 
									      array('options' => $options, 'label' => false, 'div' => false, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow')).'</p></td></tr>';										  									  									  
					$options = array('Καμία Κατηγορία'=>'-','1' => 'Δεκάποδα/ Καβούρια/ Γαρίδες', '2' => 'Μαλάκια: Γαστερόποδα/Δίθυρα','3' => 'Ψάρια', '4' =>'Χταπόδια/ Καλαμάρια', '5' => 'Εχινόδερμα', '6' => 'Ασκίδια', '7' =>'Επιλιθικοί οργανισμοί: Βρυόζωα', '8' => 'Μέδουσες', '9' => 'Άλλοι πλαγκτονικοί οργανισμοί', '10' => 'Φύκη');  
					echo '<tr><td><label for="UserEducation" class="education std_form">Δευτερεύουσα Κατηγορία Ειδίκευσης:  </label></td><td><p>'.$this->Form->input('Analyst.category2', 
									      array('options' => $options, 'label' => false, 'div' => false, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow')).'</p></td></tr>';										  									  									  
					echo '<tr><td><label for="AnalystResearchInstitute" class="name std_form">Ινστιτούτο:  </label></td><td><p>'.$this->Form->input('Analyst.research_institute', 
									      array('label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','placeholder' => 'π.χ. ΕΚΠΑ','class' => ' std_form blue_shadow')).'</p></td></tr>';

									  
                                        echo '<tr><td>'
                                        ?>

                                            <a class="backButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'edit_users', '?'=>'text=&userType1=analyst&userType2=simple&userType3=hyperanalyst&textType=surname'))?>" >
                                                <img class="icon" src="../../img/blackUpArrow.png" style="transform: rotate(270deg);-ms-transform: rotate(270deg);-webkit-transform: rotate(270deg);-o-transform: rotate(270deg);-moz-transform: rotate(270deg);"/>
                                                Πίσω
                                            </a>
                                        <?php
                                        echo '</td>'; 

                                        echo '<td>'. $this->Form->end(array(
														'name' => 'data[User][edit]',
														'label' => 'Δημιουργία',
														'div' => false,
                                                        'class' => '')).'</td></tr></table>';									  
								    
                                        
                                        ?>
			    </div>
			</div>
</div>
