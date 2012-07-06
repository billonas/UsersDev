<?php $this->set('title_for_layout', 'Προφίλ Αναλυτή - ΕΛΚΕΘΕ');?> 

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
        $('a.deleteButton, a.backButton, a.upgradeButton, button[type="submit"], input[type="submit"]').button();
    });
</script>

<div class="middle_row  big_row">
    <div class="middle_wrapper">
        <div class="register_box login_box" align="center">
            <br/><h1>Προφίλ αναλυτή</h1><br/>
            <div class="flash_box"><?php echo $this->Session->flash().'</br>'; ?> </div>
            <?php echo $this->Form->create('Analyst', array('action' => 'update'));?>
            <table>
                <?php
                
                $disableAnalystFields = 'true';
                if ( $analyst['User']['user_type']==='hyperanalyst' )
                    $disableAnalystFields = 'true';
                else if ( $analyst['User']['user_type']==='analyst' )
                    $disableAnalystFields = 'false';

               echo '<tr><td><label for="AnalystId" class="name std_form"></label></td><td><p>'.$this->Form->input('Analyst.id', array('type' => 'hidden', 'value' => $post_id));

                echo '<tr><td><label for="AnalystName" class="name std_form">Όνομα:  </label></td><td><p>'.$this->Form->input('Analyst.name', 
                                                        array('default'=>$analyst['User']['name'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';

                echo '<tr><td><label for="AnalystSurname" class="surname std_form">Επώνυμο:  </label></td><td><p>'.$this->Form->input('Analyst.surname', 
                                                        array('default'=>$analyst['User']['surname'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystSurname','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';


                echo '<tr><td><label for="AnalystEmail" class="mail std_form">e-mail:  </label></td><td><p>'.$this->Form->input('Analyst.email', 
                                                        array('default'=>$analyst['User']['email'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystEmail','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
                echo '<tr><td><label for="AnalystPhone" class="phone std_form">Τηλέφωνο:  </label></td><td><p>'.$this->Form->input('Analyst.phone_number', 
                                                        array('default'=>$analyst['User']['phone_number'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystPhone','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';

                echo '<tr><td><label for="AnalystAddress" class="address std_form">Διεύθυνση:  </label></td><td><p>'.$this->Form->input('Analyst.address', 
                                                        array('default'=>$analyst['User']['address'],'label' => false, 'div' => false, 'type' => 'text', 'id'=>	'AnalystAddress','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
                echo '<tr><td><label for="AnalystCity" class="city std_form">Πόλη:  </label></td><td><p>'.$this->Form->input('Analyst.city', 
                                                        array('default'=>$analyst['User']['city'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystCity', 'class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';	
                echo '<tr><td><label for="AnalystCountry" class="country std_form">Χώρα:  </label></td><td><p>'.$this->Form->input('Analyst.country', 
                                                        array('default'=>$analyst['User']['country'], 'label' => false, 'div' => false, 'type' => 'text', 'id'=>'AnalystCountry','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';
                echo '<tr><td><label for="AnalystAge" class="age std_form">Ημ/νία γέννησης:  </label></td><td><p>'.$this->Form->input('Analyst.birth_date', 
                                                        array('type'=>'date', 'empty'=>true, 'minYear'=>1901, 'maxYear'=>date('Y'), 'default'=>$analyst['User']['birth_date'],'label' => false, 'div' => false, 'id'=>'AnalystAge','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';		
                $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια');  
                echo '<tr><td><label for="AnalystEducation" class="education std_form">Εκπαίδευση:  </label></td><td><p>'.$this->Form->input('Analyst.education', 
                                                        array('default' => $analyst['User']['education'], 'options' => $options, 'label' => false, 'div' => false, 'id'=> 'AnalystEducation','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr>';										  									  									  
                $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο'); 					  
                echo '<tr><td><label for="AnalystMembership" default="-" class="membership std_form">Ιδιότητα:  </label></td><td><p>'.$this->Form->input('Analyst.membership', 
                                                        array('default'=>$analyst['User']['membership'], 'options'=> $options, 'label' => false, 'div' => false, 'id'=>'AnalystMembership','class' => ' std_form blue_shadow', 'disabled'=>'true')).'</p></td></tr></br>';	
                if(strcmp($analyst['User']['user_type'], "hyperanalyst"))
                {
                  echo "<tr>";
                  echo "<td></td>";
                  echo '<td><span class="message" style="color:blue;font-size:14pt">Επεξεργαστείτε τα στοιχεία αναλυτή</span></td>';
                  echo '</tr>';
                }

					$options = array('Καμία Κατηγορία'=>'-','1' => 'Δεκάποδα/ Καβούρια/ Γαρίδες', '2' => 'Μαλάκια: Γαστερόποδα/Δίθυρα','3' => 'Ψάρια', '4' =>'Χταπόδια/ Καλαμάρια', '5' => 'Εχινόδερμα', '6' => 'Ασκίδια', '7' =>'Επιλιθικοί οργανισμοί: Βρυόζωα', '8' => 'Μέδουσες', '9' => 'Άλλοι πλαγκτονικοί οργανισμοί', '10' => 'Φύκη');  
					echo '<tr><td><label for="AnalystCategory" class="education std_form">Κατηγορία Ειδίκευσης 1:  </label></td><td><p>'.$this->Form->input('Analyst.category1', 
									      array('default'=>$analyst['Category1']['id'], 'options' => $options, 'label' => false, 'div' => false, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow','disabled'=>$disableAnalystFields)).'</p></td></tr>';										  									  									  
					$options = array('Καμία Κατηγορία'=>'-','1' => 'Δεκάποδα/ Καβούρια/ Γαρίδες', '2' => 'Μαλάκια: Γαστερόποδα/Δίθυρα','3' => 'Ψάρια', '4' =>'Χταπόδια/ Καλαμάρια', '5' => 'Εχινόδερμα', '6' => 'Ασκίδια', '7' =>'Επιλιθικοί οργανισμοί: Βρυόζωα', '8' => 'Μέδουσες', '9' => 'Άλλοι πλαγκτονικοί οργανισμοί', '10' => 'Φύκη');  
					echo '<tr><td><label for="UserEducation" class="education std_form">Κατηγορία Ειδίκευσης 2:  </label></td><td><p>'.$this->Form->input('Analyst.category2', 
									      array('default'=>$analyst['Category2']['id'], 'options' => $options, 'label' => false, 'div' => false, 'id'=> 'UserEducation','placeholder' => 'π.χ. Δημοτικό','class' => ' std_form blue_shadow', 'disabled'=>$disableAnalystFields)).'</p></td></tr>';										  									  									  
                echo '<tr><td><label for="AnalystInstitute" class="name std_form">Ινστιτούτο:  </label></td><td><p>'.$this->Form->input('Analyst.research_institute', 
                                                        array('default'=>$analyst['Analyst']['research_institute'],'label' => false, 'div' => false, 'type' => 'text', 'id'=> 'AnalystName','class' => ' std_form blue_shadow', 'disabled'=>$disableAnalystFields)).'</p></td></tr>';
                
                ?>
                <?php
                    echo '<tr><td></td>';
                    if ( $analyst['User']['user_type']==='analyst' )
                    {
                        echo '<td>'.$this->Form->end(array('name' => 'data[Analyst][edit]',
                                                'label' => 'Ενημέρωση',
                                                'div' => false,
                                                'class' => 'formSubmit')).'</td></tr></table>';	
                    }
                    else
                    {
                        echo '<td>'.$this->Form->end().'</td></tr></table>';	
                    }
                ?>
            
               
            <div style="margin-top:2em; margin-left: auto; margin-right: auto;">
                <a class="backButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'edit_users', '?'=>'text=&userType1=analyst&userType2=simple&userType3=hyperanalyst&textType=surname'))?>" >
                    <img class="icon" src="../../img/blackUpArrow.png" style="transform: rotate(270deg);-ms-transform: rotate(270deg);-webkit-transform: rotate(270deg);-o-transform: rotate(270deg);-moz-transform: rotate(270deg);"/>
                    Πίσω
                </a>
                <?php if ( $analyst['User']['user_type'] === 'analyst' ): ?>
                    <a class="upgradeButton" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'upgrade', $analyst['User']['id']))?>" >
                        <img class="icon" src="../../img/blackUpArrow.png"/>
                        Αναβάθμιση αναλυτή
                    </a>
                    <a class="deleteButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'delete', $analyst['User']['id']))?>" >
                        <img class="icon" src="../../img/whiteX.png"/>
                        Διαγραφή αναλυτή
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
