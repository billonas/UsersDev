		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default'),null, array('inline'=>false));	?>
        <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','jquery.imgareaselect.pack.js','googlemaps.js'), array('inline'=>false));?>
    
<script type="text/javascript">
		$(function() {

			var $tabs = $('#tabs').tabs();
	
			$(".ui-tabs-panel").each(function(i){
	
			  var totalSize = $(".ui-tabs-panel").size() - 1;
	
			  
	  
			  if (i != 0) {
			      prev = i;
		   		  $(this).append("<a href='#' class='prev-tab mover' rel='" + prev + "'>&#171; Προηγούμενο βήμα</a>");
			  }
			  
			  if (i != totalSize) {
			      next = i + 2;
		   		  $(this).append("<a href='#' class='next-tab mover' rel='" + next + "'>Επόμενο βήμα &#187;</a>");
			  }
   		
			});
	
			$('.next-tab, .prev-tab').click(function() { 
		           $tabs.tabs('select', $(this).attr("rel"));
		           return false;
		       });
       

		});
</script>
    

    
<script type="text/javascript">

var map;
var marker;
var once=true;

function updateMarkerPosition(latLng) {

  document.getElementById('info').innerHTML = latLng.lat();
  document.getElementById('info2').innerHTML = latLng.lng();
  document.forms["ReportCreateForm"].elements["data[Report][lat]"].value = latLng.lat();
  document.forms["ReportCreateForm"].elements["data[Report][lng]"].value = latLng.lng();
}





function handleApiReady() {
  var centerlatLng = new google.maps.LatLng(38.0397, 24.644);
  map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 6,
    center: centerlatLng,
    mapTypeId: google.maps.MapTypeId.SATELLITE,
	mapTypeControl: true,
    mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
        position: google.maps.ControlPosition.BOTTOM_CENTER
    },
    panControl: true,
    panControlOptions: {
        position: google.maps.ControlPosition.TOP_RIGHT
    },
    zoomControl: true,
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.LARGE,
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    scaleControl: true,
    scaleControlOptions: {
        position: google.maps.ControlPosition.TOP_LEFT
    },
    streetViewControl: true,
    streetViewControlOptions: {
        position: google.maps.ControlPosition.LEFT_TOP
   }
   
  });
	
	google.maps.event.addListener(map, 'click', function(event) {
    addMarker(event.latLng);
	updateMarkerPosition(marker.getPosition());
  });

  
  

}

function addMarker(location) {
if (once)
{
  marker = new google.maps.Marker({
	animation: google.maps.Animation.DROP,
    position: location,
    map: map
  });
 
 }
 else{
	marker.setPosition(location);
	marker.setAnimation(google.maps.Animation.DROP);
	}
  once=false;
  google.maps.event.addListener(marker, 'click', toggleBounce);
}



function toggleBounce() {

  if (marker.getAnimation() != null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

// Onload handler to fire off the app.



function appendBootstrap() {
var script = document.createElement("script");
script.type = "text/javascript";
script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=handleApiReady";


document.body.appendChild(script);
once=true;
document.getElementById('info').innerHTML = "";

} 


</script>
<script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
		<!--[if lt IE 10 ]>
			<link rel="stylesheet" href="hacks.css" type="text/css" media="screen" />
		 <![endif]-->
	
                <style>
                    #mapCanvas {
                        width: 500px;
                        height: 400px;
                        float: left;
                        clear: both;
                    }
                </style>
		<div class="middle_row big_row no_padding">
        	<div class="middle_wrapper">   
                <div id="tabs">
                    <ul>                
                        <?php  if(isset($cropped)){ 
                                  echo '<li class="long-text"><a href="#fragment-1" onClick="appendBootstrap()"><span>1. Βασικές<br/>Πληροφορίες</span></a></li>      
                                        <li class="long-text"><a href="#fragment-2"><span>2. Επιπλέον<br/>Πληροφορίες</span></a></li>
                                        <li class="long-text"><a href="#fragment-3"><span>3. Στοιχεία<br/>Παρατηρητή</span></a></li>';
    
                                }else{
                                    echo '<li class="long-tab selected-tab"><a href="#fragment-1">1. Βασικές Πληροφορίες</a></li>';
                                }
                        ?>
                
                    </ul>
                            <?php 
                                if(!isset($cropped)){
                                    if(!isset($uploaded)){
                                        echo '<div id="fragment-1" class="">';
                                        echo '<div class="flash_box gradient">';
                                        echo $this->Session->flash().'</br>';
                                        echo '</div>';
                                        echo $this->Form->create('Report', array('action' => 'create', "enctype" => "multipart/form-data"));
                                        echo $this->Form->input('image',array("type" => "file",'label'=>'Φωτογραφία/Video: ', 'class'=>'std_form'));  
                                        echo $this->Form->input('edit',array("label"=>"Θέλετε να επεξεργαστείτε την φωτογραφία;",'type'=>'checkbox', 'class'=>'std_form'));
                                        echo $this->Form->end(array(
                                                                            'label' => 'Ανέβασμα Φωτογραφίας ή Video',
                                                                            'div' => false,
                                                                            'class' => 'std_form')); 
                                    }
                                    else{
                                        echo '<div id="fragment-1">';
                                        echo $this->Session->flash(); 
                                        echo $this->Form->create('Report', array('action' => 'create',"enctype" => "multipart/form-data"));     
                                        echo $this->Cropimage->createJavaScript($uploaded['imageWidth'],$uploaded['imageHeight'],151,151);  
                                        echo $this->Cropimage->createForm($uploaded["imagePath"], 151, 151); 
                                        echo '<br/>-Eνδείκνυται στη φωτογραφία να φαίνεται το περιβάλλον που εντοπίστηκε το είδος<br/><br/>';
                                        echo $this->Form->end(array(
                                                                            'label' => 'Επεξεργασία Φωτογραφίας',
                                                                            'div' => false,
                                                                            'class' => 'std_form')); 
                                    } 
                                }
                                else{
                                    echo '<div id="fragment-1" class="">';
                                    echo $this->Session->flash(); 
                                    echo $this->Form->create('Report', array('action' => 'create',"enctype" => "multipart/form-data"));     
                                    echo $this->Html->image($imagePath); 
                                    echo $this->Form->input('main_photo',array('type'=>'hidden','value'=>$imagePath, 'class'=>'std_form'));
                                    echo '<br/>';
                                    echo $this->Form->input('permissionUseMedia',array("label"=>"Μπορούν να χρησιμοποιηθούν οι φωτογραφίες/βίντεό σας για την παρουσίαση των αναφορών σας;", 'class'=>'std_form'));
									echo '</br><label for="ReportDate" class="std_form">Ημερομηνία Παρατήρησης </label>';
									echo $this->Form->input('date',array('label'=>false,'div'=>false, 'class'=>'std_form blue shadow'));
									echo '</br></br><div id="mapCanvas"></div>';
									echo '<table>';				
                                    
									echo '<tr><td><label class="std_form">Τοποθεσία παρατήρησης: </label></td> </tr>';
									echo '<br/>';
									
									echo '<tr><td><label for="ReportLat" class="std_form">Γεωγραφικός Πλάτος </label></td>';
									echo '<td>'.$this->Form->input('lat',array('id'=>'info','label' => false,'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow', 'div'=>false));
									echo '</td></tr>';
									echo '<tr><td><label for="ReportLng" class="std_form">Γεωγραφικός Μήκος </label></td>';
									echo '<td>'.$this->Form->input('lng',array('div'=>false,'id'=>'info2',"label" => false,'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow'));
                                    echo '</td></tr></table>';
                                }
                            ?>
                        </div>
                    
                    <?php
                        if(isset($cropped)){ 
                            echo '<div id="fragment-2">';
                                echo $this->Form->input('image2',array("type" => "file",'label'=>'Επιπλέον Φωτογραφία 1', 'class'=>'std_form'));
                                echo $this->Form->input('image3',array("type" => "file",'label'=>'Επιπλέον Φωτογραφία 2', 'class'=>'std_form'));
                                //echo $this->Form->input('additional_photo1',array('type'=>'hidden'));
                                //echo $this->Form->input('additional_photo2',array('type'=>'hidden'));
                                echo '<br/>';
                                $options = array();
                                $options['1']  = $this->Html->image('hotspecies/1.jpg');
                                $options['2']  = $this->Html->image('hotspecies/2.jpg');
                                $options['3']  = $this->Html->image('hotspecies/3.jpg');
                                echo $this->Form->input('hot_id', array('options' => $options,'type'=>'radio','legend'=> false,'before' => 'Είναι κάποιο απ\'τα συγκεκριμένα Hot Species;<br/><br/>', 'class'=>'std_form'));
                                echo '<br/><table>';
								echo '<tr><td><label for="ReportHabitat" class="std_form">Βιοτοπος-Περιβάλλον Παρατήρησης </label></td>';
                                echo '<td>'.$this->Form->input('habitat',array('label'=>false,'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','div'=> false, 'class' => 'std_form blue_shadow')).'</td></tr>';
                                
								echo '<tr><td><label for="ReportDepth" class="std_form">Βάθος</label></td>';
                                echo '<td>'.$this->Form->input('depth',array('label'=>false,'placeholder'=>'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                                
								echo '<tr><td><label for="ReportRe_observation" class="std_form">Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή;  </label></td>';
                                echo '<td>'.$this->Form->input('re_observation',array('label' => false,'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                                $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30'); 
								echo '<tr><td><label for="ReportCrowd" class="std_form">Πλήθος Ατόμων Είδους </label></td>'; 
                                echo '<td>'.$this->Form->input('crowd', array('options' => $options, 'default' => '  -  ','label' => false, 'class'=>'std_form blue_shadow', 'div'=> false)).'</td></tr>';
                                
								
								echo '<tr><td><label for="ReportComments" class="std_form">Επιπλέον Σχόλια </label></td>'; 
                                echo '<td>'.$this->Form->input('comments', array('type' => 'textarea','label' => false,'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';     
								echo '</table>';                         
                        echo '</div>';
						
                    }
                    ?>
                    <?php  
                        if(isset($cropped)){ 
                            echo '<div id="fragment-3">';
							echo '<table>';
                                if($this->Session->check('UserUsername')){
									echo '<tr><td><label for="ReportAge" class="std_form">Επιπλέον Σχόλια </label></td>'; 
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
                                }
                                else{
								    echo '<tr><td><label for="ReportAge" class="std_form">Επιπλέον Σχόλια </label></td>'; 
                                    echo '<td>'.$this->Form->input('age',array('label'=>false, 'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
                                    $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');  
									echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>'; 
                                    echo '<td>'.$this->Form->input('education', array('options' => $options, 'default' => '    -    ', 'label'=>false,'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
                                    $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');  
									echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>'; 
                                    echo '<td>'.$this->Form->input('occupation', array('options' => $options, 'default' => '    -    ', 'label'=>false,'class'=>'std_form')).'</td></tr>';
                                    echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>'; 
									echo '<td>'.$this->Form->input('name',array("label" => false,'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                                    
									echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>'; 
                                    echo '<td>'.$this->Form->input('surname',array("label" => false, 'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
									
                                    echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>'; 
                                    echo '<td>'.$this->Form->input('phone_number',array("label" => false, 'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','div'=>false)).'</td></tr>';
                                    
									echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>'; 
                                    echo '<td>'.$this->Form->input('email',array("label"=>false, 'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow', 'div'=>false)).'</td></tr>';	    
                                }
								
                                $options = array('unknown' => 'Άγνωστη','confirmed' => 'Έγκυρη', 'unreliable' => 'Αναξιόπιστη');  
                                echo $this->Form->input('category_id', array('value'=>null,'label'=>'Κατηγορία Είδους','type'=>'hidden', 'class'=>'std_form'));
                                echo $this->Form->input('state', array('options' => $options,'value'=>'unknown','label'=>'Κατάσταση Αναφοράς ','type'=>'hidden', 'class'=>'std_form'));
                                echo '<br/>';
                                
                            echo '</table></div>';
							echo $this->Form->end(array(
                                                            'label' => 'Κατάθεση Αναφοράς',
                                                            'div' => false,
                                                            'class' => 'std_form'));
                        }
						
                        ?>
                   
                    </div>
                </div>
	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	