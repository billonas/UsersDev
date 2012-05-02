
		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default'),null, array('inline'=>false));	?>
        <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','jquery.imgareaselect.pack.js'), array('inline'=>false));?>
                
	    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
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
                                  echo '<li class="long-text"><a href="#fragment-1">1. Φωτογραφία<br/>Παρατήρησης</a></li>
                                        <li class="long-text"><a href="#fragment-2" onClick="appendBootstrap()"><span>2. Βασικές<br/>Πληροφορίες</span></a></li>
                                        <li class="long-text"><a href="#fragment-3"><span>3. Επιπλέον<br/>Πληροφορίες</span></a></li>
                                        <li class="long-text"><a href="#fragment-4"><span>4. Στοιχεία<br/>Παρατηρητή</span></a></li>  
                                        <li class="long-text"><a href="#fragment-5"><span>5. Στοιχεία<br/>Επικοινωνίας</span></a></li> ';
    
                                }else{
                                    echo '<li class="long-tab selected-tab"><a href="#fragment-1">1. Φωτογραφία παρατήρησης</a></li>';
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
                                        echo $this->Form->input('image',array("type" => "file",'label'=>'Φωτογραφία'));  
                                        echo $this->Form->input('edit',array("label"=>"Θέλετε να επεξεργαστείτε την φωτογραφία;",'type'=>'checkbox'));
                                        echo $this->Form->end(array(
                                                                            'label' => 'Ανέβασμα Φωτογραφίας',
                                                                            'div' => false,
                                                                            'class' => 'std_form')); 
                                    }
                                    else{
                                        echo '<div id="fragment-1">';
                                        echo $this->Session->flash(); 
                                        echo $this->Form->create('Report', array('action' => 'create',"enctype" => "multipart/form-data"));     
                                        echo $this->Cropimage->createJavaScript($uploaded['imageWidth'],$uploaded['imageHeight'],151,151);  
                                        echo $this->Cropimage->createForm($uploaded["imagePath"], 151, 151); 
                                        echo '<br/>';
                                        echo $this->Form->end(array(
                                                                            'label' => 'Επεξεργασία Φωτογραφίας',
                                                                            'div' => false,
                                                                            'class' => 'std_form')); 
                                    } 
                                }
                                else{
                                    echo '<div id="fragment-1" class="small_pic">';
                                    echo $this->Session->flash(); 
                                    echo $this->Form->create('Report', array('action' => 'create',"enctype" => "multipart/form-data"));     
                                    echo $this->Html->image($imagePath); 
                                    echo $this->Form->input('main_photo',array('type'=>'hidden','value'=>$imagePath));
                                    echo '<br/>';
                                    echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας; "));
                                }
                            ?>
                        </div>
                    <?php 
                       if(isset($cropped)){
                           echo '<div id="fragment-2">';
                                echo '<div id="mapCanvas"></div>';
                                //echo '<div class="frag-2">';
                                echo $this->Form->input('date',array('label'=>'Ημερομηνία Παρατήρησης','div'=>false));
                                echo '<br/>';
                                echo $this->Form->input('lat',array('div'=>false,'id'=>'info',"label" => "Γεωγραφικός Πλάτος",'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow'));
                                echo '<br/>';
                                echo $this->Form->input('lng',array('div'=>false,'id'=>'info2',"label" => "Γεωγραφικό Μήκος",'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow'));
                                //echo '</div>';                           
                            echo '</div>';
                       }
                    ?>
                    <?php
                        if(isset($cropped)){ 
                            echo '<div id="fragment-3">';
                                echo $this->Form->input('image2',array("type" => "file",'label'=>'Επιπλέον Φωτογραφία 1'));
                                echo $this->Form->input('image3',array("type" => "file",'label'=>'Επιπλέον Φωτογραφία 2'));
                                //echo $this->Form->input('additional_photo1',array('type'=>'hidden'));
                                //echo $this->Form->input('additional_photo2',array('type'=>'hidden'));
                                echo '<br/>';
                                $options = array();
                                $options['1']  = $this->Html->image('hotspecies/1.jpg');
                                $options['2']  = $this->Html->image('hotspecies/2.jpg');
                                $options['3']  = $this->Html->image('hotspecies/3.jpg');
                                echo $this->Form->input('hot_id', array('options' => $options,'type'=>'radio','legend'=> false,'before' => 'Είναι κάποιο απ\'τα συγκεκριμένα Hot Species;<br/><br/>'));
                                echo '<br/>';
                                echo $this->Form->input('habitat',array("label"=>"Βιοτοπος-Περιβάλλον Παρατήρησης ",'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','class'=>'std_form blue_shadow'));
                                echo '<br/>';
                                echo $this->Form->input('depth',array("label"=>"Βάθος ",'placeholder' => 'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form'));
                                echo '<br/>';
                                echo $this->Form->input('re_observation',array("label" => "Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; ",'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow'));
                                echo '<br/>';
                                $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');  
                                echo $this->Form->input('crowd', array('options' => $options, 'default' => '  -  ','label'=>'Πλήθος Ατόμων Είδους '));
                                echo '<br/>';
                                echo $this->Form->input('comments', array('type' => 'textarea',"label" => "Επιπλέον Σχόλια ",'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow'));                              
                        echo '</div>';
                    }
                    ?>
                    <?php  
                        if(isset($cropped)){ 
                            echo '<div id="fragment-4">';
                                if($this->Session->check('UserUsername')){
                                    echo $this->Form->input('age',array('label'=>'Ημερομηνία Γέννησης ','default'=>$this->Session->read('UserBirthDate'),'disabled'=>'true'));
                                    echo '<br/>';
                                    $options = array('noValue'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');  
                                    echo $this->Form->input('education', array('options' => $options,'default'=>$this->Session->read('UserEducation'),'label'=>'Επίπεδο Εκπαίδευσης ','disabled'=>'true'));
                                    echo '<br/>';
                                    $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');  
                                    echo $this->Form->input('occupation', array('options' => $options,'default'=>$this->Session->read('UserMembership'),'label'=>'Ιδιότητα ','disabled'=>'true'));
                                    echo '<br/>';
                                    echo '<br/>';
                                }
                                else{
                                    echo $this->Form->input('age',array('label'=>'Ημερομηνία Γέννησης '));
                                    echo '<br/>';
                                    $options = array('-'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');  
                                    echo $this->Form->input('education', array('options' => $options, 'default' => '    -    ','label'=>'Επίπεδο Εκπαίδευσης '));
                                    echo '<br/>';
                                    $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');  
                                    echo $this->Form->input('occupation', array('options' => $options, 'default' => '   -   ','label'=>'Ιδιότητα '));
                                }
                            echo '</div>';
                        }
                        ?>
                    <?php 
                        if(isset($cropped)){ 
                            echo'<div id="fragment-5">';
                                if($this->Session->check('UserUsername')){
                                    echo $this->Form->input('name',array("label" => "Όνομα ",'value'=>$this->Session->read('UserName'),'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','disabled'=>'true'));
                                    echo '<br/>';
                                    echo $this->Form->input('surname',array("label" => "Επώνυμο ",'value'=>$this->Session->read('UserSurname'),'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','disabled'=>'true'));
                                    echo '<br/>';
                                    echo $this->Form->input('phone_number',array("label" => "Τηλέφωνο Επικοινωνίας ",'value'=>$this->Session->read('UserPhoneNumber'),'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','disabled'=>'true'));
                                    echo '<br/>';
                                    echo $this->Form->input('email',array("label"=>"E-mail ",'value'=>$this->Session->read('UserUsername'),'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow','disabled'=>'true'));
                                    echo '<br/>';
                                    echo $this->Form->input('observer',array('value'=>$userId,"type"=>'hidden'));
                                }
                                else{
                                    echo $this->Form->input('name',array("label" => "Όνομα ",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow'));
                                    echo '<br/>';
                                    echo $this->Form->input('surname',array("label" => "Επώνυμο ",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow'));
                                    echo '<br/>';
                                    echo $this->Form->input('phone_number',array("label" => "Τηλέφωνο Επικοινωνίας ",'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow'));
                                    echo '<br/>';
                                    echo $this->Form->input('email',array("label"=>"E-mail ",'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow'));
                                    echo '<br/>';
                                }
                                $options = array('unknown' => 'Άγνωστη','confirmed' => 'Έγκυρη', 'unreliable' => 'Αναξιόπιστη');  
                                echo $this->Form->input('state', array('options' => $options,'value'=>'unknown','label'=>'Κατάσταση Αναφοράς ','type'=>'hidden'));
                                echo '<br/>';
                                echo $this->Form->end(array(
                                                            'label' => 'Κατάθεση Αναφοράς',
                                                            'div' => false,
                                                            'class' => 'std_form'));
                            echo '</div>';
                        }
                    ?>
                    </div>
                </div>
	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	