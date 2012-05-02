
		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default','forms'),null, array('inline'=>false));	?>
        <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','jquery.imgareaselect.pack','maps'), array('inline'=>false));?>
                
	    
<?php echo $this->Html->scriptStart(array('inline' => false));?>

var map;
var marker;
var once=true;

function updateMarkerPosition(latLng) {

  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
  document.forms["ReportCreateForm"].elements["data[Report][observation_site]"].value = latLng.toUrlValue();
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




  $(document).ready(function() {
    $("#tabs").tabs();
  });
 <?php echo $this->Html->scriptEnd();?> 
		
                <style>
                    #mapCanvas {
                        width: 500px;
                        height: 400px;
                        float: left;
                        clear: both;
                    }
                    #infoPanel {
                        float: left;
                        margin-left: 10px;
                    }
                    #infoPanel div {
                        margin-bottom: 5px;
                    }
                </style>
                <?php echo $this->Session->flash();?>  
		<div class="middle_row">
        	<div class="middle_wrapper">   
                <div id="tabs">
                    <ul>
                        <li><a href="#fragment-1">1. Φωτογραφία<br/> παρατήρησης</a></li>
                        <?php  if(isset($cropped)){ 
                  echo '<li><a href="#fragment-2" onClick="appendBootstrap()"><span>2. Βασικές Πληροφορίες <br/>Παρατήρησης</span></a></li>
                        <li><a href="#fragment-3"><span>3. Επιπλέον Πληροφορίες <br/>Παρατήρησης</span></a></li>
                        <li><a href="#fragment-4"><span>4. Στοιχεία <br/>Παρατηρητή</span></a></li>  
                        <li><a href="#fragment-5"><span>5. Στοιχεία <br/>Επικοινωνίας</span></a></li> ';
    
                        } ?>
                
                    </ul>
                        <div id="fragment-1">
                            <?php 
                                
                                echo '<br/>';
                                if(!isset($cropped)){
                                    if(!isset($uploaded)){
                                        echo $this->Form->create('Report', array('action' => 'create', "enctype" => "multipart/form-data"));
                                        echo $this->Form->input('image',array("type" => "file",'label'=>'Φωτογραφία'));  
                                        echo $this->Form->input('edit',array("label"=>"Θέλετε να επεξεργαστείτε την φωτογραφία;",'type'=>'checkbox'));
                                        echo $this->Form->end('Ανέβασμα Φωτογραφίας'); 
                                    }
                                    else{
                                        echo $this->Form->create('Report', array('action' => 'create',"enctype" => "multipart/form-data"));     
                                        echo $this->Cropimage->createJavaScript($uploaded['imageWidth'],$uploaded['imageHeight'],151,151);  
                                        echo $this->Cropimage->createForm($uploaded["imagePath"], 151, 151); 
                                        echo $this->Form->submit('Επεξεργασία Φωτογραφίας', array("id"=>"save_thumb"));
                                        echo $this->Form->end();
                                    } 
                                }
                                else{
                                    echo $this->Form->create('Report', array('action' => 'create',"enctype" => "multipart/form-data"));     
                                    echo $this->Html->image($imagePath); 
                                    echo $this->Form->input('main_photo',array('type'=>'hidden','value'=>$imagePath));
                                    echo '<br/>';
                                    echo '<br/>';
                                    echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας;"));
                                    echo '<br/>';
                                }
                            ?>
                        </div>
                        <div id="fragment-2">
                            <br/>
                           <?php  
                           if(isset($cropped)){ 
                                echo $this->Form->input('date',array('label'=>'Ημερομηνία Παρατήρησης'));
                                echo '<br/>';
                                echo '<div id="mapCanvas"></div>';
                                echo '<br/>';
                                echo $this->Form->input('observation_site',array('div'=>'input[type=text]','id'=>'info',"label" => "Συντεταγμένες Τοποθεσίας",'placeholder' => 'Συντεταγμένες ή Βάλτε μια κουκίδα Google Maps'));
                           }
                           ?>
                        </div>
                        <div id="fragment-3">
                            <?php
                            if(isset($cropped)){ 
                                echo $this->Form->input('image2',array("type" => "file",'label'=>'Επιπλέον Φωτογραφία 1'));
                                echo $this->Form->input('image3',array("type" => "file",'label'=>'Επιπλέον Φωτογραφία 2'));
                                echo $this->Form->input('additional_photo1',array('type'=>'hidden'));
                                echo $this->Form->input('additional_photo2',array('type'=>'hidden'));
                                echo '<br/>';
                                $options = array();
                                $options['1']  = $this->Html->image('hotspecies/1.jpg');
                                $options['2']  = $this->Html->image('hotspecies/2.gif');
                                $options['3']  = $this->Html->image('hotspecies/3.jpg');
                                echo $this->Form->input('hot_id', array('options' => $options,'type'=>'radio','legend'=> false,'before' => 'Είναι κάποιο απ\'τα συγκεκριμένα Hot Species;<br/><br/>'));
                                echo '<br/>';
                                echo $this->Form->input('habitat',array("label"=>"Βιοτοπος-Περιβάλλον Παρατήρησης",'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»'));
                                echo '<br/>';
                                echo $this->Form->input('depth',array("label"=>"Βάθος",'placeholder' => 'Γράψτε μέτρα(m) ή περιγράψτε'));
                                echo '<br/>';
                                echo $this->Form->input('re_observation',array("label" => "Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή;",'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...'));
                                echo '<br/>';
                                $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');  
                                echo $this->Form->input('crowd', array('options' => $options, 'default' => '  -  ','label'=>'Πλήθος Ατόμων Είδους'));
                                echo '<br/>';
                                echo $this->Form->input('comments', array('type' => 'textarea',"label" => "Επιπλέον Σχόλια",'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση'));
                                echo '<br/>';
                                echo $this->Form->end('Κατάθεση Αναφοράς');
                            }?>
                        </div>  
                        <div id="fragment-4">
                            <?php  
                            if(isset($cropped)){ 
                                echo '<br/>';
                                echo $this->Form->input('age',array('label'=>'Ημερομηνία Γέννησης'));
                                echo '<br/>';
                                $options = array('-'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','uptothird' => 'Τριτοβάθμια - Ανώτατη');  
                                echo $this->Form->input('education', array('options' => $options, 'default' => '    -    ','label'=>'Επίπεδο Εκπαίδευσης'));
                                echo '<br/>';
                                $options = array('-'=>'-','fisherman' => 'Ψαράς', 'ditis' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');  
                                echo $this->Form->input('occupation', array('options' => $options, 'default' => '   -   ','label'=>'Ιδιότητα'));
                                echo '<br/>';
                                echo $this->Form->end('Κατάθεση Αναφοράς');
                            }?>
                        </div>
                        <div id="fragment-5">
                            <?php 
                            if(isset($cropped)){ 
                                echo '<br/>';
                                echo $this->Form->input('name',array("label" => "Όνομα",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά'));
                                echo '<br/>';
                                echo $this->Form->input('surname',array("label" => "Επώνυμο",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά'));
                                echo '<br/>';
                                echo $this->Form->input('phone_number',array("label" => "Τηλέφωνο Επικοινωνίας",'placeholder' => 'Σταθερό ή Κινητό'));
                                echo '<br/>';
                                echo $this->Form->input('email',array("label"=>"E-mail",'placeholder'=>"Παρακαλούμε γράψτε το σε κανονική μορφή. Π.Χ. g.kolokotronis@elkethe.gr"));
                                echo '<br/>';
                                $options = array('unknown' => 'Άγνωστη','confirmed' => 'Έγκυρη', 'unreliable' => 'Αναξιόπιστη');  
                                echo $this->Form->input('state', array('options' => $options,'value'=>'unknown','label'=>'Κατάσταση Αναφοράς','type'=>'hidden'));
                                echo '<br/>';
                                echo $this->Form->end('Κατάθεση Αναφοράς');
                            }?>
                        </div>
                        
                        
    			</div>
                
            </div>
		
	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	