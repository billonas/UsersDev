<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default'),null, array('inline'=>false)); ?>
<?php echo $this->Html->script(array('jquery.min','jquery.imgareaselect.pack.js'), array('inline'=>false));?>

<script type="text/javascript"
    src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC0azkJD2QB5m24LzhdEUenVmgCJPNaiDI&sensor=false">
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

$(document).ready(function(){
    $('div[id*="f"]').css('display','none');
    $('#f1').css('display','block');
    $('a[href="#1"]').parent().addClass('selected_tab');
    $('.fragment').bind('click',function(e){
        var $this = $(this);
        if($this.is('a') && !$this.parent().hasClass('selected_tab')){
            var prev_temp = $('.selected_tab').find('a').attr('href');
            var prev_addr = prev_temp.substr(1,prev_temp.length);
            $('#f' + prev_addr).css('display','none');
            $('.selected_tab').toggleClass('selected_tab');
            $this.parent().addClass('selected_tab');
            var temp = $this.attr('href');
            var addr = temp.substr(1,temp.length);
            $('#f' + addr).css('display','block');
            return false;
        }
        else if($this.is('li') && !$this.hasClass('selected_tab')){
            var prev_temp = $('.selected_tab').find('a').attr('href');
            var prev_addr = prev_temp.substr(1,prev_temp.length);
            $('#f' + prev_addr).css('display','none');
            $('.selected_tab').toggleClass('selected_tab');
            $this.addClass('selected_tab');
            var temp = $this.find('a').attr('href');            
            var addr = temp.substr(1,temp.length);
            $('#f' + addr).css('display','block');            
            return false;
        }
    });
    handleApiReady();
});


</script>
    <!--[if lt IE 10 ]>
    <link rel="stylesheet" href="hacks.css" type="text/css" media="screen" />
    <![endif]-->
<style>
    #mapCanvas {
        width: 500px;
        height: 400px;
        position: relative;
    }
</style>
    <div class="middle_row big_row no_padding">
        <div class="middle_wrapper">
            <div id="tabs">
                <ul>
                    <?php if(isset($uploaded1) || isset($uploaded2) || isset($validation_error)){
                        echo '<li class="long_tab fragment"><a href="#1" class="fragment"><span>1. Βασικές Πληροφορίες</span></a></li>
                        <li class="long_tab fragment"><a href="#2" class="fragment"><span>2. Επιπλέον Πληροφορίες</span></a></li>
                        <li class="long_tab fragment"><a href="#3" class="fragment"><span>3. Στοιχεία Παρατηρητή</span></a></li>';
                    }else{
                        echo '<li class="long_tab selected_tab" class="fragment"><a href="#1" class="fragment">1. Βασικές Πληροφορίες</a></li>';
                    }
                    ?>
                </ul>
                <div>
                <?php
                if(!isset($uploaded1) && !isset($uploaded2) && !isset($validation_error)){
                        echo '<div id="f1">';
                        echo '<div class="flash_box gradient">';
                        echo $this->Session->flash().'</br>';
                        echo '</div>';
                        echo $this->Form->create('Report', array('action' => 'create','div'=>false, "enctype" => "multipart/form-data"));
						echo $this->Html->image('photo.png', array('alt' => 'Photo'));
						echo $this->Html->image('video.png', array('alt' => 'Video'));
						echo '</br>';
                        echo '<label for="ReportImage" class="std_form">Δώστε μία Φωτογραφία: </label>';
                        echo $this->Form->input('image',array("type" => "file",'label'=>false,'div'=>false,'class'=>'std_form'));
                        echo '<label for="ReportImage" class="std_form">Δώστε ένα Βίντεο: </label>';
                        echo $this->Form->input('video_file',array("type" => "file",'label'=>false,'div'=>false,'class'=>'std_form'));
                        echo '<br />';
                        echo '<br />';
                        echo $this->Form->end(array(
                        'label' => 'Ανέβασμα Φωτογραφίας ή Video',
                        'div' => false,
                        'class' => 'std_form big_button'));
                }
                else{
                    echo '<div id="f1">';
                    echo $this->Session->flash();
		    echo $this->Form->create('Report', array('action' => 'create',"enctype" => "multipart/form-data"));
                    if(isset($photo)){
                        echo $this->Cropimage->createJavaScript($uploaded1['imageWidth'],$uploaded1['imageHeight'],151,151);
                        echo $this->Cropimage->createForm($uploaded1['imagePath'], 151, 151);
                        echo $this->Form->input('main_photo',array('type'=>'hidden','value'=>$uploaded1["imagePath"], 'class'=>'std_form'));
                    }
                    if(isset($video)){
                        echo 'VIDEO';
			echo $this->Form->input('video',array('type'=>'hidden','value'=>$uploaded2["path"], 'class'=>'std_form'));
                    }
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
                    //echo "<a href='#2' class='button_like_anchor'>Επόμενο βήμα &#187;</a>";
                    echo '<big><span style="color:red;font-family:Arial,sans-serif;"> Όλα τα πεδία αυτού του βήματος είναι υποχρεωτικά!</span></big></br></br></br>';
                    echo '</div>';
                
                    echo '<div id="f2">';
                    echo '</br><big style="font-family:Arial,sans-serif;"> Τα πεδία αυτού του βήματος είναι προαιρετικά!</big></br></br><table>';
								echo '<tr><td><label for="ReportImage2" class="std_form">Επιπλέον Φωτογραφία 1 </label></td>';
                                echo '<td>'.$this->Form->input('image2',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
								echo '<tr><td><label for="ReportImage3" class="std_form">Επιπλέον Φωτογραφία 2 </label></td>';
                                echo '<td>'.$this->Form->input('image3',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
								echo '<tr><td><label for="ReportHot_id" class="std_form">Είναι κάποιο απο τα παρακάτω είδη-στόχους; </label></td></tr>';
						echo '</table>';    
                        echo '<br/>';
                        $options = array();
                        $options['1'] = $this->Html->image('hotspecies/1.jpg');
                        $options['2'] = $this->Html->image('hotspecies/2.jpg');
                        $options['3'] = $this->Html->image('hotspecies/3.jpg');
                        echo $this->Form->input('hot_id', array('options' => $options,'type'=>'radio','legend'=> false,'class'=>'std_form'));
                        echo '<br/><table>';
                        echo '<tr><td><label for="ReportHabitat" class="std_form">Βιοτοπος-Περιβάλλον Παρατήρησης </label></td>';
                        echo '<td>'.$this->Form->input('habitat',array('label'=>false,'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','div'=> false, 'class' => 'std_form blue_shadow')).'</td></tr>';
                        echo '<tr><td><label for="ReportDepth" class="std_form">Βάθος</label></td>';
                        echo '<td>'.$this->Form->input('depth',array('label'=>false,'placeholder'=>'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportRe_observation" class="std_form">Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; </label></td>';
                        echo '<td>'.$this->Form->input('re_observation',array('label' => false,'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                        $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');
                        echo '<tr><td><label for="ReportCrowd" class="std_form">Πλήθος Ατόμων Είδους </label></td>';
                        echo '<td>'.$this->Form->input('crowd', array('options' => $options, 'default' => ' - ','label' => false, 'class'=>'std_form blue_shadow', 'div'=> false)).'</td></tr>';
                        echo '<tr><td><label for="ReportComments" class="std_form">Επιπλέον Σχόλια </label></td>';
                        echo '<td>'.$this->Form->input('comments', array('type' => 'textarea','label' => false,'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                        echo '</table>';
						//echo "<a href='#1' class='prev-tab mover'>&#171; Προηγούμενο βήμα</a>";
						//echo "<a href='#3' class='next-tab mover'>Επόμενο βήμα &#187;</a>";
                        echo '</div>';
               
                        echo '<div id="f3">';
						echo '</br><big style="font-family:Arial,sans-serif;"> Τα πεδία αυτού του βήματος είναι προαιρετικά!</big></br></br>';
                        echo '<table>';
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
                    echo '<a href="#" class="fragment button_like_anchor left_arrow white_arrow"><img src="';
                    echo $this->webroot;
                    echo '/img/arrows/white_arrow_left_small3.png"/>Προηγούμενο Βήμα</a>';
                    echo $this->Form->end(array(
                    'label' => 'Κατάθεση Αναφοράς',
                    'div' => false,
                    'class' => 'std_form'));
                    echo '<a href="#" class="fragment button_like_anchor right_arrow white_arrow">Επόμενο Βήμα<img src="';
                    echo $this->webroot;
                    echo '/img/arrows/white_arrow_right_small3.png"/></a>';
		   }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="comments">
        <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
    </div>
</div>
