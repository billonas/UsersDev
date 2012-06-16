
		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default'),null, array('inline'=>false));	?>
        <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','jquery.imgareaselect.pack.js'), array('inline'=>false));?>

<script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
  
  
   <script>
 
	$(function() {
		var availableTags = <?php echo json_encode($response); ?>;
		
		$( "#autoComplete" ).autocomplete({
			source: availableTags
		});
	});
	

/*$(function() {
    $('#autoComplete').autocomplete({
        //source: "/groceries/items/autoComplete", ///This works but response isn't formatted correctly'
        //dataType: "json"
        minLength: 2,
        source: function( request, response ) {
            $.ajax({
                url: "http://localhost/UsersDev/Reports/autoComplete",
                dataType: "jsonp",
                data: {
                    featureClass: "P",
                    style: "full",
                    maxRows: 12,
                    term: request.term
                },
                success: function( data ) {
                    response( $.map( data, function( el ) {
                        return { label: el.label, value: el.value }
                    }));
                }
            });
        }
    });
	});*/
	</script>
  
  
		<!--[if lt IE 10 ]>
			<link rel="stylesheet" href="hacks.css" type="text/css" media="screen" />
		 <![endif]-->
		<div class="middle_row big_row no_padding">
        	<div class="middle_wrapper">   
                
                            <?php 
                                $report = $this->Session->read('report');
								echo '<div class="login_box">  
                    				<br><h1>Σύνοψη αναφοράς</h1></br>
									</div>';
                                echo '<div class="flash_box gradient">';
                                echo '</br/>'.$this->Session->flash().'</br>';
                                echo '</div>';		
                                echo $this->Form->create('Report', array('action' => 'summary',"enctype" => "multipart/form-data"));     
                                if($this->Session->check('uploaded1')){
                                    $uploaded1 = $this->Session->read('uploaded1');
                                    echo $this->Html->image($uploaded1["imagePath"]);
                                    echo $this->Form->input('main_photo',array('type'=>'hidden','value'=>$uploaded1["imagePath"], 'class'=>'std_form'));
				    echo $this->Form->input('exif',array('type'=>'hidden','default'=>$report['Report']['exif'], 'class'=>'std_form'));
                                }
                                if($this->Session->check('uploaded2')){
                                    $uploaded2 = $this->Session->read('uploaded2');
                                    echo 'VIDEO';
                                    echo $this->Form->input('video',array('type'=>'hidden','value'=>$uploaded2["path"], 'class'=>'std_form'));
                                }
                                if($this->Session->check('uploaded3')){
                                    $uploaded3 = $this->Session->read('uploaded3');
                                    echo $this->Html->image($uploaded3["imagePath"]);
                                    echo $this->Form->input('additional_photo1',array('type'=>'hidden','value'=>$report['Report']['additional_photo1'], 'class'=>'std_form'));
                                }
                                if($this->Session->check('uploaded4')){
                                    $uploaded4 = $this->Session->read('uploaded4');
                                    echo $this->Html->image($uploaded4["imagePath"]);
                                    echo  $this->Form->input('additional_photo2',array('type'=>'hidden','value'=>$report['Report']['additional_photo2'], 'class'=>'std_form'));
                                }
                                echo '<br/>';
                                echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας; ",'onclick'=>'return false', 'onkeydown'=>'return false', 'class'=>'std_form'));
                                echo '<br/>';
                                
                          
                                echo '<table>';
                    echo '<tr><td><label class="std_form">Τοποθεσία παρατήρησης: </label></td> </tr>';
                    
                    echo '<tr><td><label for="ReportLat" class="std_form">Γεωγραφικός Πλάτος </label></td>';
                    echo '<td>'.$this->Form->input('lat',array('id'=>'info','value'=>$report['Report']['lat'],'label' => false,'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow', 'div'=>false));
					
                    echo '</td></tr>';
                    echo '<tr><td><label for="ReportLng" class="std_form">Γεωγραφικός Μήκος </label></td>';
                    echo '<td>'.$this->Form->input('lng',array('div'=>false,'id'=>'info2','value'=>$report['Report']['lng'],'label' => false,'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow','readonly'=>'readonly'));
                    echo '</td></tr>';
					 echo '<tr><td><label for="ReportDate" class="std_form">Ημερομηνία Παρατήρησης </label></td>';
                    echo '<td>'.$this->Form->input('date',array('label'=>false,'default'=>$report['Report']['date'],'div'=>false, 'class'=>'std_form blue shadow','disabled'=>true, 'empty' => true,'minYear' => date('Y')-50, 'maxYear' => date('Y'))).'</td></tr>';
					
					echo '<select name="data[Report][date][month]" class="std_form blue shadow" id="ReportDateMonth" style="display:none;">
						<option value="'.$report['Report']['date']['month'].'" selected="selected">'.$report['Report']['date']['month'].'</option>
					</select>					
					<select name="data[Report][date][day]" class="std_form blue shadow" id="ReportDateDay" style="display:none;">
						<option value="'.$report['Report']['date']['day'].'" selected="selected">'.$report['Report']['date']['day'].'</option>
					</select>
					<select name="data[Report][date][year]" class="std_form blue shadow" id="ReportDateYear" style="display:none;">
						<option value="'.$report['Report']['date']['year'].'" selected="selected">'.$report['Report']['date']['year'].'</option>
					</select>';
					
					
					
                        echo '<tr><td><label for="ReportHabitat" class="std_form">Βιοτοπος-Περιβάλλον Παρατήρησης </label></td>';
                        echo '<td>'.$this->Form->input('habitat',array('label'=>false,'value'=>$report['Report']['habitat'],'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','div'=> false, 'readonly'=>'readonly', 'class' => 'std_form blue_shadow')).'</td></tr>';
                        echo '<tr><td><label for="ReportDepth" class="std_form">Βάθος</label></td>';
                        echo '<td>'.$this->Form->input('depth',array('label'=>false,'value'=>$report['Report']['depth'],'placeholder'=>'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form blue_shadow', 'div'=>false, 'readonly'=>'readonly')).'</td></tr>';
                        echo '<tr><td><label for="ReportRe_observation" class="std_form">Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; </label></td>';
                        echo '<td>'.$this->Form->input('re_observation',array('label' => false,'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow','readonly'=>'readonly' , 'div'=>false)).'</td></tr>';
                        $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');
                        echo '<tr><td><label for="ReportCrowd" class="std_form">Πλήθος Ατόμων Είδους </label></td>';
                        echo '<td>'.$this->Form->input('crowd', array('options' => $options, 'value'=>$report['Report']['crowd'],'default' => ' - ','label' => false, 'class'=>'std_form blue_shadow', 'readonly'=>'readonly', 'div'=> false)).'</td></tr>';
                        echo '<tr><td><label for="ReportComments" class="std_form">Επιπλέον Σχόλια </label></td>';
                        echo '<td>'.$this->Form->input('comments', array('type' => 'textarea','value'=>$report['Report']['crowd'],'label' => false,'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow', 'readonly'=>'readonly', 'div'=>false)).'</td></tr>';
                        echo '';
			  if($this->Session->check('UserUsername')){
                        echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                        echo '<td>'.$this->Form->input('age',array('label'=>false,'default'=>$this->Session->read('UserBirthDate'), 'disabled'=>true, 'class'=>'std_form blue shadow', 'div'=>false, 'empty' => true,'minYear' => date('Y')-50, 'maxYear' => date('Y'))).'</td></tr>';
						echo '<select name="data[Report][age][month]" id="ReportAgeMonth" style="display:none;">
							<option value="'.$report['Report']['age']['month'].'" selected="selected">06</option>
						</select>
						
						<select name="data[Report][age][day]" id="ReportAgeDay" style="display:none;">
							<option value="'.$report['Report']['age']['day'].'" selected="selected">13</option>
						</select>
						
						<select name="data[Report][age][year]" id="ReportAgeYear" style="display:none;">
							<option value="'.$report['Report']['age']['year'].'" selected="selected">2012</option>
						</select>';

                        $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');
                        echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>';
                        echo '<td>'.$this->Form->input('education', array('options' => $options,'default'=>$this->Session->read('UserEducation'),'label'=>false,'disabled'=> true, 'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
						
						
                        $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');
                        echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>';
                        echo '<td>'.$this->Form->input('occupation', array('options' => $options,'default'=>$this->Session->read('UserMembership'),'label'=>false,'readonly'=>'readonly', 'class'=>'std_form')).'</td></tr>';
                        echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                        echo '<td>'.$this->Form->input('name',array("label" => false,'value'=>$this->Session->read('UserName'),'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','readonly'=>'readonly', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                        echo '<td>'.$this->Form->input('surname',array("label" => false, 'value'=>$this->Session->read('UserSurname'),'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','readonly'=>'readonly', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                        echo '<td>'.$this->Form->input('phone_number',array("label" => false,'value'=>$this->Session->read('UserPhoneNumber'),'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','readonly'=>'readonly', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                        echo '<td>'.$this->Form->input('email',array("label"=>false,'value'=>$this->Session->read('UserUsername'),'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow','readonly'=>'readonly', 'div'=>false)).'</td></tr>';
                        echo $this->Form->input('observer',array('value'=>$userId,"type"=>'hidden', 'class'=>'std_form'));
                        echo "<a href='#2' class='prev-tab mover'>&#171; Προηγούμενο βήμα</a>";
                        //echo '</div>';
                    }
                    else{
                        if($this->Session->check('report')){
                            echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                            echo '<td>'.$this->Form->input('age',array('label'=>false,'default'=>$report['Report']['age'], 'class'=>'std_form blue shadow', 'div'=>false, 'disabled'=>true, 'empty' => true,'minYear' => date('Y')-50, 'maxYear' => date('Y'))).'</td></tr>';
							
							echo '<select name="data[Report][age][month]" id="ReportAgeMonth" style="display:none;">
							<option value="'.$report['Report']['age']['month'].'" selected="selected">'.$report['Report']['age']['month'].'</option>
						</select>
						
						<select name="data[Report][age][day]" id="ReportAgeDay" style="display:none;">
							<option value="'.$report['Report']['age']['day'].'" selected="selected">'.$report['Report']['age']['day'].'</option>
						</select>
						
						<select name="data[Report][age][year]" id="ReportAgeYear" style="display:none;">
							<option value="'.$report['Report']['age']['year'].'" selected="selected">'.$report['Report']['age']['year'].'</option>
						</select>';
							
							
							
							
                            $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');
                            echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>';
                            echo '<td>'.$this->Form->input('education', array('options' => $options,'default'=>$report['Report']['education'], 'default' => ' - ', 'label'=>false,'class'=>'std_form blue shadow', 'div'=>false, 'disabled'=>true)).'</td></tr>';
							
							echo '<select name="data[Report][education]" id="ReportEducation" style="display:none;">
							<option value="'.$report['Report']['education'].'" selected="selected">'.$report['Report']['education'].'</option>
							</select>';
							
							
                            $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');
                            echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>';
                            echo '<td>'.$this->Form->input('occupation', array('options' => $options,'value'=>$report['Report']['occupation'], 'default' => ' - ', 'label'=>false,'class'=>'std_form', 'disabled'=>true)).'</td></tr>';
							echo '<select name="data[Report][occupation]" id="ReportOccupation" style="display:none;">
								<option value="'.$report['Report']['occupation'].'" selected="selected">'.$report['Report']['occupation'].'</option>
							</select>';
							
                            echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                            echo '<td>'.$this->Form->input('name',array("label" => false,'value'=>$report['Report']['name'],'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false, 'readonly'=>'readonly')).'</td></tr>';
                            echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                            echo '<td>'.$this->Form->input('surname',array("label" => false, 'value'=>$report['Report']['surname'],'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false,'readonly'=>'readonly')).'</td></tr>';
                            echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                            echo '<td>'.$this->Form->input('phone_number',array("label" => false,'value'=>$report['Report']['phone_number'], 'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','div'=>false,'readonly'=>'readonly')).'</td></tr>';
                            echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                            echo '<td>'.$this->Form->input('email',array("label"=>false,'value'=>$report['Report']['email'], 'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow', 'div'=>false, 'readonly'=>'readonly')).'</td></tr>';							    
                        }
                        else{ 
                            echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                            echo '<td>'.$this->Form->input('age',array('label'=>false, 'class'=>'std_form blue shadow', 'div'=>false,'readonly'=>'readonly')).'</td></tr>';
                            $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');
                            echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>';
                            echo '<td>'.$this->Form->input('education', array('options' => $options, 'default' => ' - ', 'label'=>false,'class'=>'std_form blue shadow', 'div'=>false, 'readonly'=>'readonly')).'</td></tr>';
                            $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');
                            echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>';
                            echo '<td>'.$this->Form->input('occupation', array('options' => $options, 'default' => ' - ', 'label'=>false, 'readonly'=>'readonly', 'class'=>'std_form')).'</td></tr>';
                            echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                            echo '<td>'.$this->Form->input('name',array("label" => false,'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false,'readonly'=>'readonly')).'</td></tr>';
                            echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                            echo '<td>'.$this->Form->input('surname',array("label" => false,'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false,'readonly'=>'readonly')).'</td></tr>';
                            echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                            echo '<td>'.$this->Form->input('phone_number',array("label" => false, 'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','div'=>false,'readonly'=>'readonly')).'</td></tr>';
                            echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                            echo '<td>'.$this->Form->input('email',array("label"=>false, 'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow', 'readonly'=>'readonly', 'div'=>false)).'</td></tr>';							    
                        }
                        
                    }
                    echo $this->Form->input('category_id', array('value'=>null,'label'=>'Κατηγορία Είδους','type'=>'hidden', 'class'=>'std_form'));
                    echo $this->Form->input('state', array('options' => $options,'value'=>'unknown','label'=>'Κατάσταση Αναφοράς ','type'=>'hidden', 'class'=>'std_form'));
					
					echo '<tr><td>'.$this->Html->link('Επιστροφή στην φόρμα', array('controller' => 'reports', 'action'=>'create'), array('class' => 'button_like_anchor')).'</td>';
                    echo '<td>'.$this->Form->end(array(
                                                'label' => 'Οριστική υποβολή',
                                                'div' => false,
                                                'class' => 'std_form
												')).'</td></tr></table>'.'</div>';
                           ?>
                        
            </div>

	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	
