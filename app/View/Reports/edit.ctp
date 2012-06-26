
		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default'),null, array('inline'=>false));	?>
        <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','tiny_mce/tiny_mce','flowplayer/flowplayer-3.2.10.min'), array('inline'=>false));?>

   <script>
 
	$(function() {
		var availableTags = <?php echo json_encode($species); ?>;
		
		$( "#autoComplete" ).autocomplete({
			source: availableTags
		});
	});

	</script> 
  

<div class="middle_row big_row no_padding">
        <div class="login_box">  
            <br><h1>Επεξεργασία αναφοράς</h1></br>
        </div>
        <div class="middle_wrapper">   
                
                <?php 
                    echo '<div class="flash_box gradient">';
                    echo $this->Session->flash().'</br>';
                    echo '</div>';
                    echo $this->Form->create('Report', array('action' => 'edit',"enctype" => "multipart/form-data"));     
                    echo $this->Form->input('id',array("type"=>'hidden', 'class'=>'std_form'));
                    if(isset($report['Report']['main_photo']))
                        echo $this->Html->image($report['Report']['main_photo']);

                    //check if additional photos are available
					echo '<div class="additional">';
                    for($i=1;$i<6;$i++){
                        if(isset($report['Report']['additional_photo'.$i]))
                                echo $this->Html->image($report['Report']['additional_photo'.$i]);	  
                                //can have a break here assuming they're uploaded additively
                    }
					echo '</div>';
                    if(isset($report['Report']['video'])){
                        echo '<a href="'.$this->webroot.'video/'.$report['Report']['video'].'" 
                                style="display:block;width:520px;height:330px" id="player"> </a>  '; //only works for mp4, flv, f4v. more soon
                        echo '<script>
                                    flowplayer("player", "'.$this->webroot.'/js/flowplayer/flowplayer-3.2.11.swf",{
                                                clip:  {
                                                    autoPlay: false,
                                                    autoBuffering: true
                                                }
                                    });
                                </script>';
                    }
                    echo '<br/>';
                    echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας; ",'disabled'=>'true', 'class'=>'std_form'));
                    echo '<br/>';


                    echo '<table>';
                    echo '<tr><td><label class="std_form">Τοποθεσία παρατήρησης: </label></td> </tr>';
                    echo '<br/>';
                    echo '<tr><td><label for="ReportLat" class="std_form">Γεωγραφικός Πλάτος </label></td>';
                    echo '<td>'.$this->Form->input('lat',array('id'=>'info','label' => false,'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow', 'div'=>false,'disabled'=>'true'));
                    echo '</td></tr>';
                    echo '<tr><td><label for="ReportLng" class="std_form">Γεωγραφικός Μήκος </label></td>';
                    echo '<td>'.$this->Form->input('lng',array('div'=>false,'id'=>'info2',"label" => false,'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow','disabled'=>'true'));
                    echo '</td></tr>';
                          
                    echo '<br/>';
                    echo '<br/>';
                    echo '<tr><td><label for="ReportHabitat" class="std_form">Βιοτοπος-Περιβάλλον Παρατήρησης </label></td>';
                    echo '<td>'.$this->Form->input('habitat',array('label'=>false,'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','div'=> false, 'disabled'=>'true', 'class' => 'std_form blue_shadow')).'</td></tr>';
                    echo '<tr><td><label for="ReportDepth" class="std_form">Βάθος</label></td>';
                    echo '<td>'.$this->Form->input('depth',array('label'=>false,'placeholder'=>'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form blue_shadow', 'div'=>false, 'disabled'=>'true')).'</td></tr>';
                    echo '<tr><td><label for="ReportRe_observation" class="std_form">Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; </label></td>';
                    echo '<td>'.$this->Form->input('re_observation',array('label' => false,'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow','disabled'=>'true' , 'div'=>false)).'</td></tr>';
                    $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');
                    echo '<tr><td><label for="ReportCrowd" class="std_form">Πλήθος Ατόμων Είδους </label></td>';
                    echo '<td>'.$this->Form->input('crowd', array('options' => $options, 'default' => ' - ','label' => false, 'class'=>'std_form blue_shadow', 'disabled'=>'true', 'div'=> false)).'</td></tr>';
                    echo '<tr><td><label for="ReportComments" class="std_form">Επιπλέον Σχόλια </label></td>';
                    echo '<td>'.$this->Form->input('comments', array('type' => 'textarea','label' => false,'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow', 'disabled'=>'true', 'div'=>false)).'</td></tr>';
                    echo '';

						
						
                    echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης  </label></td>';
                    echo '<td>'.$this->Form->input('age',array('label'=>false, 'class'=>'std_form blue shadow', 'disabled'=>'true','div'=>false)).'</td></tr>';
                    $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');
                    echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>';
                    echo '<td>'.$this->Form->input('education', array('options' => $options, 'default' => ' - ', 'label'=>false,'class'=>'std_form blue shadow', 'disabled'=>'true','div'=>false)).'</td></tr>';
                    $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');
                    echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>';
                    echo '<td>'.$this->Form->input('occupation', array('options' => $options, 'default' => ' - ', 'label'=>false,'disabled'=>'true', 'class'=>'std_form')).'</td></tr>';
                    echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                    echo '<td>'.$this->Form->input('name',array("label" => false,'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','disabled'=>'true', 'class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                    echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                    echo '<td>'.$this->Form->input('surname',array("label" => false, 'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','disabled'=>'true', 'class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                    echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                    echo '<td>'.$this->Form->input('phone_number',array("label" => false, 'placeholder' => 'Σταθερό ή Κινητό','disabled'=>'true', 'class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                    echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                    echo '<td>'.$this->Form->input('email',array("label"=>false, 'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'disabled'=>'true', 'class' => 'std_form blue_shadow', 'div'=>false)).'</td></tr>';        


                           
                    echo '<br/>';
                    $options = array(null => '-');
//                                // Add categories dynamically
                    foreach ($categories as $category)
                    {
                        $options[$category['Category']['id']]= $category['Category']['category_name'];
                    }
                    echo '<tr><td><label for="ReportCategory" class="std_form">Κατηγορία Είδους</label></td><td>'.$this->Form->input('category_id', array('options' => $options, 'value'=>null,'label'=>false, 'class'=>'std_form')).'</td></tr>';
                    echo '<tr><td><label for="ReportState" class="std_form">Επιστημονική Ονομασία</label></td><td>'.$this->Form->input('scientific_name', array('value'=>null,'label'=>false,'class'=>'std_form','id'=>'autoComplete')).'</td></tr>';
                    $options = array('unknown' => 'Άγνωστη','confirmed' => 'Έγκυρη', 'unreliable' => 'Αναξιόπιστη');  								
                    echo '<tr><td><label for="ReportState" class="std_form">Κατάσταση αναφοράς</label></td><td>'.$this->Form->input('state', array('options' => $options,'value'=>'unknown','label'=>false,'class'=>'std_form')).'</td></tr>';

                    if(isset($userId)){
                        echo $this->Form->input('last_edited_by',array("type"=>'hidden', 'class'=>'std_form','value'=>$userId));
                    }
                    echo '<tr><td><label for="ReportCategory" class="std_form">Σχόλια-Παρατηρήσεις</label></td><td>';
                    echo $this->Tinymce->input('Report.analyst_comments',array("label" => false,'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά', 'class'=>'std_form'),null,'full').'</td></tr>';
                    
					
                    echo '<tr><td>'.$this->Html->link('Επιστροφή στον πίνακα', array('controller' => 'reports', 'action'=>'table'),array('class' => 'button_like_anchor' , "style" => "padding-left: 3.2em;padding-right: 3.2em;")).'</td><td>';
					echo $this->Form->end(array(
                                                'label' => 'Επεξεργασία Αναφοράς',
                                                'div' => false,
                                                'class' => 'std_form')).'</td></tr></table>';
					
                ?>

        </div>

</div>
<div class="comments">
    <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
</div>
	