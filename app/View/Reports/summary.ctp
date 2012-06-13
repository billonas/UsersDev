
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
                                echo '<div class="flash_box gradient">';
                                echo '</br/>'.$this->Session->flash().'</br>';
                                echo '</div>';
                                echo $this->Form->create('Report', array('action' => 'summary',"enctype" => "multipart/form-data"));     
                                if($this->Session->check('uploaded1')){
                                    $uploaded1 = $this->Session->read('uploaded1');
                                    echo $this->Html->image($uploaded1["imagePath"]);
                                    echo $this->Form->input('main_photo',array('type'=>'hidden','value'=>$uploaded1["imagePath"], 'class'=>'std_form'));
                                }
                                if($this->Session->check('uploaded2')){
                                    $uploaded2 = $this->Session->read('uploaded2');
                                    echo 'VIDEO';
                                    echo $this->Form->input('video',array('type'=>'hidden','value'=>$uploaded2["path"], 'class'=>'std_form'));
                                }
                                echo $this->Form->input('summary',array("type"=>'hidden', 'class'=>'std_form'));
                                echo '<br/>';
                                echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας; ",'disabled'=>'true', 'class'=>'std_form'));
                                echo '<br/>';
                                
                          
                                echo '<table>';
                    echo '<tr><td><label class="std_form">Τοποθεσία παρατήρησης: </label></td> </tr>';
                    echo '<br/>';
                    echo '<tr><td><label for="ReportLat" class="std_form">Γεωγραφικός Πλάτος </label></td>';
                    echo '<td>'.$this->Form->input('lat',array('id'=>'info','value'=>$report['Report']['lat'],'label' => false,'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow', 'div'=>false,'disabled'=>'true'));
                    echo '</td></tr>';
                    echo '<tr><td><label for="ReportLng" class="std_form">Γεωγραφικός Μήκος </label></td>';
                    echo '<td>'.$this->Form->input('lng',array('div'=>false,'id'=>'info2','value'=>$report['Report']['lng'],"label" => false,'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow','disabled'=>'true'));
                    echo '</td></tr>';
                          
                                echo '<br/>';
                                echo '<br/>';
                        echo '<tr><td><label for="ReportHabitat" class="std_form">Βιοτοπος-Περιβάλλον Παρατήρησης </label></td>';
                        echo '<td>'.$this->Form->input('habitat',array('label'=>false,'value'=>$report['Report']['habitat'],'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','div'=> false, 'disabled'=>'true', 'class' => 'std_form blue_shadow')).'</td></tr>';
                        echo '<tr><td><label for="ReportDepth" class="std_form">Βάθος</label></td>';
                        echo '<td>'.$this->Form->input('depth',array('label'=>false,'value'=>$report['Report']['depth'],'placeholder'=>'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form blue_shadow', 'div'=>false, 'disabled'=>'true')).'</td></tr>';
                        echo '<tr><td><label for="ReportRe_observation" class="std_form">Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; </label></td>';
                        echo '<td>'.$this->Form->input('re_observation',array('label' => false,'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow','disabled'=>'true' , 'div'=>false)).'</td></tr>';
                        $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');
                        echo '<tr><td><label for="ReportCrowd" class="std_form">Πλήθος Ατόμων Είδους </label></td>';
                        echo '<td>'.$this->Form->input('crowd', array('options' => $options, 'value'=>$report['Report']['crowd'],'default' => ' - ','label' => false, 'class'=>'std_form blue_shadow', 'disabled'=>'true', 'div'=> false)).'</td></tr>';
                        echo '<tr><td><label for="ReportComments" class="std_form">Επιπλέον Σχόλια </label></td>';
                        echo '<td>'.$this->Form->input('comments', array('type' => 'textarea','value'=>$report['Report']['crowd'],'label' => false,'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow', 'disabled'=>'true', 'div'=>false)).'</td></tr>';
                        echo '';
			  if($this->Session->check('UserUsername')){
                        echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                        echo '<td>'.$this->Form->input('age',array('label'=>false,'default'=>$this->Session->read('UserBirthDate'),'disabled'=>'true', 'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
                        $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');
                        echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>';
                        echo '<td>'.$this->Form->input('education', array('options' => $options,'default'=>$this->Session->read('UserEducation'),'label'=>false,'disabled'=>'true', 'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
                        $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');
                        echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>';
                        echo '<td>'.$this->Form->input('occupation', array('options' => $options,'default'=>$this->Session->read('UserMembership'),'label'=>false,'disabled'=>'true', 'class'=>'std_form')).'</td></tr>';
                        echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                        echo '<td>'.$this->Form->input('name',array("label" => false,'value'=>$this->Session->read('UserName'),'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','disabled'=>'true', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                        echo '<td>'.$this->Form->input('surname',array("label" => false, 'value'=>$this->Session->read('UserSurname'),'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','disabled'=>'true', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                        echo '<td>'.$this->Form->input('phone_number',array("label" => false,'value'=>$this->Session->read('UserPhoneNumber'),'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','disabled'=>'true', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                        echo '<td>'.$this->Form->input('email',array("label"=>false,'value'=>$this->Session->read('UserUsername'),'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow','disabled'=>'true', 'div'=>false)).'</td></tr>';
                        echo $this->Form->input('observer',array('value'=>$userId,"type"=>'hidden', 'class'=>'std_form'));
                        echo "<a href='#2' class='prev-tab mover'>&#171; Προηγούμενο βήμα</a>";
                        //echo '</div>';
                    }
                    else{
                        if($this->Session->check('report')){
                            echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                            echo '<td>'.$this->Form->input('age',array('label'=>false,'value'=>$report['Report']['age'], 'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
                            $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');
                            echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>';
                            echo '<td>'.$this->Form->input('education', array('options' => $options,'value'=>$report['Report']['education'], 'default' => ' - ', 'label'=>false,'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
                            $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');
                            echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>';
                            echo '<td>'.$this->Form->input('occupation', array('options' => $options,'value'=>$report['Report']['occupation'], 'default' => ' - ', 'label'=>false,'class'=>'std_form')).'</td></tr>';
                            echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                            echo '<td>'.$this->Form->input('name',array("label" => false,'value'=>$report['Report']['name'],'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                            echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                            echo '<td>'.$this->Form->input('surname',array("label" => false, 'value'=>$report['Report']['surname'],'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                            echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                            echo '<td>'.$this->Form->input('phone_number',array("label" => false,'value'=>$report['Report']['phone_number'], 'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                            echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                            echo '<td>'.$this->Form->input('email',array("label"=>false,'value'=>$report['Report']['email'], 'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow', 'div'=>false)).'</td></tr>';							    
                        }
                        else{
                            echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                            echo '<td>'.$this->Form->input('age',array('label'=>false, 'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
                            $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');
                            echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>';
                            echo '<td>'.$this->Form->input('education', array('options' => $options, 'default' => ' - ', 'label'=>false,'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
                            $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');
                            echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>';
                            echo '<td>'.$this->Form->input('occupation', array('options' => $options, 'default' => ' - ', 'label'=>false,'class'=>'std_form')).'</td></tr>';
                            echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                            echo '<td>'.$this->Form->input('name',array("label" => false,'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                            echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                            echo '<td>'.$this->Form->input('surname',array("label" => false,'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                            echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                            echo '<td>'.$this->Form->input('phone_number',array("label" => false, 'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                            echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                            echo '<td>'.$this->Form->input('email',array("label"=>false, 'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow', 'div'=>false)).'</td></tr>';							    
                        }
                        
                    }
                    echo '</table></div>';
                    echo $this->Form->end(array(
                                                'label' => 'Οριστική υποβολή',
                                                'div' => false,
                                                'class' => 'std_form'));
                           ?>
                        
            </div>

	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	