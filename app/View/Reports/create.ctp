<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="en-gb" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>Αναφορά Παρατήρησης</title>
		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default'));	
                ?>
                <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','jquery.imgareaselect.pack.js'));?>
                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

var map;
var marker;
var once=true;
var x;
var y;


function updateMarkerPosition(latLng) {

  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
  x=latLng.lat();
  y=latLng.lng();
  document.forms["ReportCreateForm"].elements["data[Report][observation_site]"].value = [x,y].join(', ');
}


function initialize() {
  var latLng = new google.maps.LatLng(38.0397, 24.644);
  map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 6,
    center: latLng,
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
google.maps.event.addDomListener(window, 'load', initialize);


</script>
<script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
</script>
		<!--[if lt IE 10 ]>
			<link rel="stylesheet" href="hacks.css" type="text/css" media="screen" />
		 <![endif]-->
	</head>
	<body>
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
		<div class="middle_row big_row">
                    <div class="middle_wrapper">   
                        <div class="tabs">
                            <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
                            <label for="tab-1" class="tab-label-1">ΒΗΜΑ 1ο</label>
                            
                            <?php 
                                if(isset($cropped)){
                                    echo '<input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />';
                                    echo '<label for="tab-2" class="tab-label-2">ΒΗΜΑ 2ο</label>';

                                    echo '<input id="tab-3" type="radio" name="radio-set" class="tab-selector-3" />';
                                    echo '<label for="tab-3" class="tab-label-3">ΒΗΜΑ 3ο</label>';

                                    echo '<input id="tab-4" type="radio" name="radio-set" class="tab-selector-4" />';
                                    echo '<label for="tab-4" class="tab-label-4">ΒΗΜΑ 4ο</label>';
                            
                                    echo '<input id="tab-5" type="radio" name="radio-set" class="tab-selector-5" />';
                                    echo '<label for="tab-5" class="tab-label-5">ΒΗΜΑ 5ο</label>';
                                }
                            ?>

                            <div class="content">
                                <div class="content-1">
                                    <?php 
                                        if(!isset($cropped)){
                                            if(!isset($uploaded)){
                                                echo $this->Form->create('Report', array('action' => 'create', "enctype" => "multipart/form-data"));
                                                echo $this->Form->input('image',array("type" => "file",'label'=>'Φωτογραφία'));  
                                                echo $this->Form->input('edit',array("label"=>"Θέλετε να επεξεργαστείτε την φωτογραφία;",'type'=>'checkbox'));
                                                echo $this->Form->end(array(
                                                                            'label' => 'Ανέβασμα Φωτογραφίας',
                                                                            'div' => false,
                                                                            'class' => 'std_form')); 
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
                                <div class="content-2">
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
                                <div class="content-3">
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
                                            echo '<br/>';
                                        }?>
                                </div>
                                <div class="content-4">
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
                                            echo '<br/>';
                                        }?>
                                </div>
                                <div class="content-5">
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
	</body>
</html>
