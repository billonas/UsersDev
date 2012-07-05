<?php echo $this->Html->css(array('jquery.Jcrop'),null, array('inline'=>false)); ?>
<?php echo $this->Html->script(array('jquery.min','jquery.Jcrop.js','jQuery.bubbletip-1.0.6'), array('inline'=>false));?>
        <?php $this->set('title_for_layout', 'Αναφορά παρατήρησης - ΕΛΚΕΘΕ');?>  
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
    var kmlLayer = new google.maps.KmlLayer('https://sites.google.com/site/kolpoielladoskmz/kmz/Kolpoi.kmz',
    {
        suppressInfoWindows: true,
        map: map
    });
	<!---google.maps.event.addListener(map, 'click', function(event) {
    <!----addMarker(event.latLng);
	<!----updateMarkerPosition(marker.getPosition());
	<!--}); ------------->
    google.maps.event.addListener(kmlLayer, 'click', function(kmlEvent)
    {
        var text = kmlEvent.featureData.description;
        showInContentWindow(text);
        addMarker(kmlEvent.latLng);
        updateMarkerPosition(marker.getPosition());
    });
}

function showInContentWindow(text)
{
        document.getElementById('maparea').innerHTML = text;
        document.forms["ReportCreateForm"].elements["data[Report][area]"].value =text;

}

function checkCoords(){
    var $lat = $("#info");
    var $lng = $("#info2");
    var l1 = false;
    var l2 = false;
    var latitude;
    var longitude;
    if($lat.attr('value') != $lat.attr('placeholder') && $lat.attr('value') != ""){
        latitude = $lat.attr('value');
        l1 = true;
    }
    if($lng.attr('value') != $lng.attr('placeholder') && $lng.attr('value') != ""){
        longitude = $lng.attr('value');
        l2 = true;
    }
    if(l1 && l2){
        
        addMarker(new google.maps.LatLng(latitude,longitude,true));
    }
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
    } 
    else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

<?php 
if($this->Session->check('uploaded1')){     //prosthetoume ton kodika gia to JCrop
    echo 
    'function showCoords(c){
	$("#x1").val(c.x);
	$("#y1").val(c.y);
	$("#x2").val(c.x2);
	$("#y2").val(c.y2);
	$("#w").val(c.w);
	$("#h").val(c.h);
    }';
}
?>
    
var small_screen;
var jcrop_api;
var has_crop = false;

function showNextStep(){
    $('a.right_arrow').each(function(index) {
        if($(this).parent().hasClass("report_button_wrapper") && small_screen){
            $(this).css('display','block');
        }
        else if(!$(this).parent().hasClass("report_button_wrapper") && !small_screen){
            $(this).css('display','block');
        }
    }); 
}

function showPreviousStep(){
    $('a.left_arrow').each(function(index) {
        if($(this).parent().hasClass("report_button_wrapper") && small_screen){
            $(this).css('display','block');
        }
        else if(!$(this).parent().hasClass("report_button_wrapper") && !small_screen){
            $(this).css('display','block');
        }
    });
}

function hideNextStep(){
    $('a.right_arrow').each(function(index) {
        if($(this).parent().hasClass("report_button_wrapper") && small_screen){
            $(this).css('display','none');
        }
        else if(!$(this).parent().hasClass("report_button_wrapper") && !small_screen){
            $(this).css('display','none');
        }
    });   
}

function hidePreviousStep(){
    $('a.left_arrow').each(function(index) {
        if($(this).parent().hasClass("report_button_wrapper") && small_screen){
            $(this).css('display','none');
        }
        else if(!$(this).parent().hasClass("report_button_wrapper") && !small_screen){
            $(this).css('display','none');
        }
    });  
}

function pressedTab(tab){
    var prev_temp = $('.selected_tab').find('a').attr('href');
    var prev_addr = prev_temp.substr(1,prev_temp.length);
    $('#f' + prev_addr).css('display','none');
    $('.selected_tab').toggleClass('selected_tab');
    tab.parent().addClass('selected_tab');
    var temp = tab.attr('href');
    var addr = temp.substr(1,temp.length);
    $('#f' + addr).css('display','inline-block');
    if($(".report_button_wrapper").css('display') == 'block'){
        small_screen = true;                
    }
    else{
        small_screen = false;
    }
    if(addr == 2){
        showNextStep();
        showPreviousStep();
    }
    else if(addr == 1){
        hidePreviousStep();                      
        showNextStep();                        
    }
    else if(addr == 3){
        hideNextStep();                     
        showPreviousStep();                       
    }
}

function pressedButton(button){
    var prev_temp = $('.selected_tab').find('a').attr('href');
    var prev_addr = prev_temp.substr(1,prev_temp.length);            
    var next_addr;
    var temp = parseInt(prev_addr);
    if(button.text() == "Προηγούμενο Βήμα"){
        temp--;
    }
    else{
        temp++;
    }
    if($(".report_button_wrapper").css('display') == 'block'){
        small_screen = true;                
    }
    else{
        small_screen = false;
    }
    if(temp == 2){
        showPreviousStep();                                     
        showNextStep();             
    }
    else if(temp == 1){
        hidePreviousStep();                      
        showNextStep();                      
    }
    else if(temp == 3){
        hideNextStep();                      
        showPreviousStep();                    
    }
    $('#f' + prev_addr).css('display','none');
    $('.selected_tab').toggleClass('selected_tab');
    $('a[href="#' + temp + '"]').parent().toggleClass("selected_tab");
    $('#f' + temp).css('display','block');
}

function pressedListItem(li){
    pressedTab(li.find('a'));
}

function resizeJCrop(){
    var height = <?php if($this->Session->check('uploaded1')){$uploaded1 = $this->Session->read('uploaded1'); echo $uploaded1['imageHeight'].';';} else echo "0;";?>
    var width =  <?php if($this->Session->check('uploaded1'))echo $uploaded1['imageWidth'].';'; else echo "0;";?>
    var is_displayed = true;
    var $jcrop_target = $("#jcrop_target");
    if($jcrop_target.parent().parent().parent().css('display') == 'none'){
        is_displayed = false;
        $jcrop_target.parent().parent().parent().css('display','block');
    }
    var maxw = $("#img_crop_area").width();
    $jcrop_target.Jcrop({                        
                onSelect: showCoords,
                addClass: "jcrop-dark",
                boxWidth: maxw,
                boxHeight: maxw*0.7,
                trueSize: [width,height]
            },function(){
                jcrop_api = this;
                has_crop = true;
        });
    if(!is_displayed){
        $jcrop_target.parent().parent().parent().css('display','none');
    }
}

$(document).ready(function(){
    $('div[id*="f"]').css('display','none');
    $('#f1').css('display','block');
    $('a[href="#1"]').parent().addClass('selected_tab');
    if($(".report_button_wrapper").css('display') == 'block'){
        small_screen = true;
    }
    else{
        small_screen = false;
    }
    $('.fragment').bind('click',function(e){
        var $this = $(this);
        if($this.is('a') && $this.parent().is('li')){            
            pressedTab($this);
            return false;
        }
        else if($this.is('a') && $this.parent().is('div')){
            pressedButton($this);
            return false;
        }
    });
    $('.fragment').each(function(){
        var $this = $(this);
        if($this.is('a') && $this.parent().is('li')){
            var parent = $this.parent();
            parent.bind('click',function(){
                pressedListItem(parent);
            });
        }
    });
    handleApiReady();
    $('#info').bind('blur',checkCoords);
    $('#info2').bind('blur',checkCoords);
    var maxw = $("#img_crop_area").width();
    var height = <?php if($this->Session->check('uploaded1'))echo $uploaded1['imageHeight'].';'; else echo "0;";?>
    var width =  <?php if($this->Session->check('uploaded1'))echo $uploaded1['imageWidth'].';'; else echo "0;";?>
    $("#jcrop_target").Jcrop({                        
                        onSelect: showCoords,
                        addClass: "jcrop-dark",
                        boxWidth: maxw,
                        boxHeight: maxw*0.7,
                        trueSize: [width,height]
                    },function(){
                        jcrop_api = this;
                        has_crop = true;
                });
    $(window).resize(function () { 
        if(has_crop){
            jcrop_api.destroy();
        }
        if($(".report_button_wrapper").css("display") == "block"){
            if(!small_screen){
                hideNextStep();
                hidePreviousStep();
                small_screen = true;                
            }                           
        }
        else{
            if(small_screen){
                hideNextStep();
                hidePreviousStep();
                small_screen = false;
            }
        }
        var num = $('li.selected_tab').find('a').attr('href');
        num = num.substring(1,num.length);
        if(num == '1'){
            showNextStep();
            hidePreviousStep();           
        }
        else if(num == '2'){
            showNextStep();
            showPreviousStep();
        }
        else if(num == '3'){
            hideNextStep();
            showPreviousStep();
        }
        if(has_crop){
            setTimeout("resizeJCrop()",100);
        }
    });
});

$(window).bind('load', function() {

	$('#a1_right').bubbletip($('#tip1_right'), { calculateOnShow: true, deltaDirection: 'right' , offsetTop: -5 });
        $('#a2_right').bubbletip($('#tip2_right'), { calculateOnShow: true, deltaDirection: 'right' , offsetTop: -20 });
						
});

var imgcounter=3;
function addInput() {
	if (imgcounter <=6) {
	$("#" + "photo" + imgcounter).show("slow");
	imgcounter++;}
	if (imgcounter >6 )
	$("#addbutton").prop('value', 'MAX REACHED');
	
	}

	
function getTop(e) {
        var offset = e.offsetTop;
        if (e.offsetParent != null) offset += getTop(e.offsetParent);
        return offset;
}
function getLeft(e) {
        var offset = e.offsetLeft;
        if (e.offsetParent != null) offset += getLeft(e.offsetParent);
        return offset;
}
function hideDivImageDisplay() {
        $('#divImageDisplay').html();
}

function showDivImageDisplay(img) {
    var leftPos = getLeft(img) + 80;
    var topPos = getTop(img) + 20;
    $('#divImageDisplay').offset({ top: topPos, left: leftPos })
    $('#divImageDisplay').html("<img src='" + img.src + "'/>");
   
        }

	




</script>


<style>
    
    .tableImage {
        max-width: 80px;
        max-height: 50px;
        min-height: 5px;
        min-width: 30px;
        border: 1px solid silver;
        border-radius: 6px;
    }

    #mapCanvas {
        width: 100%;
        height: 30em;
        position: relative;
    }
</style>
    <div class="middle_row big_row no_padding">
        <div class="login_box">  
                <h1>Αναφορά παρατήρησης</h1>
            </div>
            <?php echo '<div class="flash_box gradient">';
                        echo '</br/>'.$this->Session->flash().'</br>';
                        echo '</div>'; ?>
        <div class="middle_wrapper">
            
            <div id="tabs">
                <ul>
                    <?php 
                    if($this->Session->check('uploaded1') || $this->Session->check('uploaded2') || $this->Session->check('report_completed')){
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
                if(!$this->Session->check('uploaded1') && !$this->Session->check('uploaded2') && !$this->Session->check('report_completed')){
                        echo '<div id="f1" class="init_tab">';
                        echo '<div class="init_form">';
                        echo $this->Form->create('Report', array('action' => 'create','div'=>false, "enctype" => "multipart/form-data"));
                        echo '<div>';
			echo $this->Html->image('photo_camera.svg', array('alt' => 'Photo'));			
			echo '</br>';
                        echo '<label for="ReportImage" class="std_form">Δώστε μία Φωτογραφία: </label>';
                        echo $this->Form->input('image',array("type" => "file",'label'=>false,'div'=>false,'class'=>'std_form'));
                        echo '</div>';
                        echo '<div>ή/και</div>';                        
                        echo '<div>';
                        echo $this->Html->image('video_camera.svg', array('alt' => 'Video'));
                        echo '</br>';
                        echo '<div>';
                        echo '<label for="ReportImage" class="std_form">Δώστε ένα Βίντεο: </label>';
                        echo $this->Form->input('video_file',array("type" => "file",'label'=>false,'div'=>false,'class'=>'std_form'));
                        echo '</div>';
                        echo '</div>';
                        echo '<div>';
                        echo $this->Form->end(array(
                        'label' => 'Ανέβασμα Φωτογραφίας ή/και Video',
                        'div' => false,
                        'class' => 'std_form big_button centered_button'));
                        echo '<div class="report_button_wrapper">';
                        echo $this->Form->end(array(
                        'label' => 'Ανέβασμα Φωτογραφίας ή/και Video',
                        'div' => false,
                        'class' => 'std_form big_button centered_button'));
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                }
                else{
                    if(!$this->Session->check('report')){
                        echo '<div id="f1">';
                        echo '<div class="flash_box gradient">';
                        echo '</br/>'.$this->Session->flash().'</br>';
                        echo '</div>';
                        echo $this->Form->create('Report', array('action' => 'create',"enctype" => "multipart/form-data"));                        
                        echo '<span class="red_msg"> Όλα τα πεδία αυτού του βήματος είναι υποχρεωτικά!</span>';
                        echo '<table>';                        
                        echo '<tr><td colspan="2">';
                        echo '<div id="mapCanvas"></div>';
                        echo '</td></tr>';
                        
                        echo '<tr><td><label class="std_form">Τοποθεσία παρατήρησης: </label></td> <td><a id="a2_right" href="#" style="clear:left;">'.$this->Html->image('info.png').'</a></td></tr>';
                        echo '<tr><td><label for="ReportLat" class="std_form">Γεωγραφικό Πλάτος </label></td>';
                        echo '<td>'.$this->Form->input('lat',array('id'=>'info','label' => false,'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow', 'div'=>false));						
                        echo '</td></tr>';
                        echo '<tr><td>';
                        echo '<label for="ReportLng" class="std_form">Γεωγραφικό Μήκος </label>';
                        echo '</td>';
                        echo '<td>';
                        echo $this->Form->input('lng',array('div'=>false,'id'=>'info2',"label" => false,'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow'));
                        echo '</td>';
                        echo '</tr>';
                        
			echo $this->Form->input('area',array('id'=>'maparea','div'=>false , "label" => false , "class" => "std_form"));
                        echo '<tr><td>';
                        echo '<label for="ReportDate" class="std_form">Ημερομηνία Παρατήρησης </label></td>';  
                        
                        $monthOptions = array('01' => 'Ιανουαρίου','02' => 'Φεβρουαρίου','03' => 'Μαρτίου','04' => 'Απριλίου','05' => 'Μαΐου','06' => 'Ιουνίου',
                            '07' => 'Ιουλίου','08' => 'Αυγούστου','09' => 'Σεπτεμβρίου','10' => 'Οκτωβρίου','11' => 'Νοεμβρίου', '12' => 'Δεκεμβρίου');
                        
                        echo '<td>'.$this->Form->day('date', array('label'=> false, 'empty' => 'Ημέρα'));
                        echo $this->Form->month('date', array('label'=> false, 'monthNames' => $monthOptions, 'empty' => 'Μήνας'));
                        echo $this->Form->year('date', date('Y') - 25, date('Y'), array('label'=> false, 'empty' => "Χρονιά"));
                        echo '</td></tr>';
                        echo '</table>';
                        if($this->Session->check('uploaded1')){
                            $uploaded1 = $this->Session->read('uploaded1');
                            //echo $this->Cropimage->createJavaScript($uploaded1['imageWidth'],$uploaded1['imageHeight'],151,151);
                            echo $this->Cropimage->createForm($uploaded1['imagePath'], 151, 151);
                            echo $this->Form->input('main_photo',array('type'=>'hidden','value'=>$uploaded1["imagePath"], 'class'=>'std_form'));
			    echo $this->Form->hidden('exif',array('type'=>'hidden', 'class'=>'std_form'));
                        }
                        if($this->Session->check('uploaded2')){
                            $uploaded2 = $this->Session->read('uploaded2');
                            if(!$this->Session->check('uploaded1')) //if he hasn't uploaded image
                                echo $this->Form->input('permissionUseMedia',array("label"=>"Μπορούν να χρησιμοποιηθούν οι φωτογραφίες/βίντεό σας για την παρουσίαση των αναφορών σας;", 'class'=>'std_form'));
                            echo $this->Form->input('video',array('type'=>'hidden','value'=>$uploaded2["path"], 'class'=>'std_form'));
                        }        
                        echo '</div>';

                        echo '<div id="f2">';
                        echo '</br><big style="font-family:Arial,sans-serif;"> Τα πεδία αυτού του βήματος είναι προαιρετικά!</big></br></br><table>';
                        echo '<tr><td><label for="ReportImage2" class="std_form">Επιπλέον Φωτογραφία 1 </label></td>';
                        echo '<td>'.$this->Form->input('image2',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
                        
                        echo '<tr id="photo3" style="display:none;"><td><label for="ReportImage3" class="std_form">Επιπλέον Φωτογραφία 2 </label></td>';
                        echo '<td>'.$this->Form->input('image3',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
                        
                        echo '<tr id="photo4" style="display:none;"><td><label for="ReportImage4" class="std_form">Επιπλέον Φωτογραφία 3 </label></td>';
                        echo '<td>'.$this->Form->input('image4',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
                        
                        echo '<tr id="photo5" style="display:none;"><td><label for="ReportImage5" class="std_form">Επιπλέον Φωτογραφία 4 </label></td>';
                        echo '<td>'.$this->Form->input('image5',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
                        
                        echo '<tr id="photo6" style="display:none;"><td><label for="ReportImage6" class="std_form">Επιπλέον Φωτογραφία 5 </label></td>';
                        echo '<td>'.$this->Form->input('image6',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><input type="button" id="addbutton" onclick="addInput()" name="add" value="Προσθέστε μια ακόμα φωτογραφία" /></td></tr>';
                        echo '<tr><td><label for="ReportHot_species" class="std_form">Είναι κάποιο απο τα παρακάτω είδη-στόχους; </label></td></tr>';
                        echo '</table>';    
                        echo '<br/>';
                         
                        $iter = 0;
                        foreach($hotspecies as $hot){
                            if($iter == 0){
                                echo '<div class="hot_radio" style="clear:left;"><input type="radio" id="'.$hot['HotSpecie']['id'].'"name="data[Report][hot_species]" value="'.$hot['HotSpecie']['scientific_name'].'" class="std_form" />
                                    <label for="'.$hot['HotSpecie']['id'].'"><img src="'.$this->webroot.'img/'.$hot['HotSpecie']['main_photo'].'" alt="" /></label></div>';
                                $iter = 1;
                            }
                            else{
                                echo '<div class="hot_radio"><input type="radio" id="'.$hot['HotSpecie']['id'].'" name="data[Report][hot_species]" value="'.$hot['HotSpecie']['scientific_name'].'" class="std_form" />
                                    <label for="'.$hot['HotSpecie']['id'].'"><img src="'.$this->webroot.'img/'.$hot['HotSpecie']['main_photo'].'" alt="" /></label></div>';
                            }
                        }
                        echo '<div class="hot_radio"><input type="radio" name="data[Report][hot_species]" value="Κανένα" class="std_form" checked />
                                   Κανένα απο τα παραπάνω </div>';
                        
                        echo '<br/><table>';
			echo' <div id="divImageDisplay" style="position:absolute;"> </div>';
			echo '<a id="a1_right" href="#" style="clear:left;">'.$this->Html->image('info.png').'</a>';
                        echo '<tr><td><label for="ReportHabitat" class="std_form">Βιοτοπος-Περιβάλλον Παρατήρησης </label></td>';
                        echo '<td>'.$this->Form->input('habitat',array('label'=>false,'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','div'=> false, 'class' => 'std_form blue_shadow')).'</td></tr>';
                        echo '<tr><td><label for="ReportDepth" class="std_form">Βάθος</label></td>';
                        echo '<td>'.$this->Form->input('depth',array('label'=>false,'placeholder'=>'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportRe_observation" class="std_form">Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; </label></td>';
                        echo '<td>'.$this->Form->input('re_observation',array('label' => false,'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                        $options = array('-'=>'-','1' => '1', '2-5' => '2-5', '6-10' => '6-10','11-30' => '11-30', '>30'=>'>30');
                        echo '<tr><td><label for="ReportCrowd" class="std_form">Πλήθος Ατόμων Είδους </label></td>';
                        echo '<td>'.$this->Form->input('crowd', array('options' => $options, 'default' => ' - ','label' => false, 'class'=>'std_form blue_shadow', 'div'=> false)).'</td></tr>';
                        echo '<tr><td><label for="ReportComments" class="std_form">Επιπλέον Σχόλια </label></td>';
                        echo '<td>'.$this->Form->input('comments', array('type' => 'textarea','label' => false,'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                        echo '</table>';
                        echo '</div>';

                        echo '<div id="f3">';
                        echo '</br><big style="font-family:Arial,sans-serif;"> Τα πεδία αυτού του βήματος είναι προαιρετικά!</big></br></br>';
                        echo '<table>';
                    }
                    else{
                        
                        $report = $this->Session->read('report');
                       
			echo '<div id="f1">';
                        echo '<div class="flash_box gradient">';
                        echo '</br/>'.$this->Session->flash().'</br>';
                        echo '</div>';
                        echo $this->Form->create('Report', array('action' => 'create',"enctype" => "multipart/form-data"));
								
			echo '<span class="red_msg"> Όλα τα πεδία αυτού του βήματος είναι υποχρεωτικά!</span>';
                        echo '<table>';                        
                        echo '<tr><td colspan="2">';
                        echo '<div id="mapCanvas"></div>';
                        echo '</td></tr>';
                        
                        echo $this->Form->input('area',array('id'=>'maparea','div'=>false ,'value'=>$report['Report']['area'],  "label" => false , "class" => "std_form"));
                        echo '<tr><td><label class="std_form">Τοποθεσία παρατήρησης: </label></td> <td><a id="a2_right" href="#" style="clear:left;">'.$this->Html->image('info.png').'</a></td></tr>';

                        echo '<tr><td><label for="ReportLat" class="std_form">Γεωγραφικό Πλάτος </label></td>';
                        echo '<td>'.$this->Form->input('lat',array('id'=>'info','value'=>$report['Report']['lat'],'label' => false,'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow', 'div'=>false));						
                        echo '</td></tr>';
                        echo '<tr><td>';
                        echo '<label for="ReportLng" class="std_form">Γεωγραφικό Μήκος </label>';
                        echo '</td>';
                        echo '<td>';
                        echo $this->Form->input('lng',array('div'=>false,'id'=>'info2','value'=>$report['Report']['lng'],"label" => false,'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow'));
                        echo '</td>';
                        echo '</tr>';
                        
                        echo '<tr><td>';
                        echo '<label for="ReportDate" class="std_form">Ημερομηνία Παρατήρησης </label></td>';
                        
                        $monthOptions = array('01' => 'Ιανουαρίου','02' => 'Φεβρουαρίου','03' => 'Μαρτίου','04' => 'Απριλίου','05' => 'Μαΐου','06' => 'Ιουνίου',
                            '07' => 'Ιουλίου','08' => 'Αυγούστου','09' => 'Σεπτεμβρίου','10' => 'Οκτωβρίου','11' => 'Νοεμβρίου', '12' => 'Δεκεμβρίου');
                        
                        
                        echo '<td>'.$this->Form->day('date', array('label'=> false, 'empty' => 'Ημέρα', 'value'=>$report['Report']['date']['day']));
                        echo $this->Form->month('date', array('label'=> false, 'monthNames' => $monthOptions, 'empty' => "Μήνας",'value'=>$report['Report']['date']['month']));
                        echo $this->Form->year('date', date('Y') - 25, date('Y'), array('label'=> false, 'empty' => "Χρονιά", 'value'=>$report['Report']['date']['year']));
                        echo '</td></tr>';
                        echo '</table>';
			
                        
                        
                      	if($this->Session->check('uploaded1')){
                            $uploaded1 = $this->Session->read('uploaded1');
                            //echo $this->Cropimage->createJavaScript($uploaded1['imageWidth'],$uploaded1['imageHeight'],151,151);
                            echo $this->Cropimage->createForm($uploaded1['imagePath'], 151, 151);
                            echo $this->Form->input('main_photo',array('type'=>'hidden','value'=>$uploaded1["imagePath"], 'class'=>'std_form'));
                            echo $this->Form->hidden('exif',array('type'=>'hidden', 'class'=>'std_form'));
                        }
                        if($this->Session->check('uploaded2')){
                            $uploaded2 = $this->Session->read('uploaded2');
                            //echo 'VIDEO';
                            echo $this->Form->input('permissionUseMedia',array("label"=>"Μπορούν να χρησιμοποιηθούν οι φωτογραφίες/βίντεό σας για την παρουσίαση των αναφορών σας;", 'value'=>$report['Report']['permissionUseMedia'], 'class'=>'std_form'));
                            echo $this->Form->input('video',array('type'=>'hidden','value'=>$uploaded2["path"], 'class'=>'std_form'));
                        }
                        echo '</div>'; 
			

                        echo '<div id="f2">';
                        
                        echo '</br><big style="font-family:Arial,sans-serif;"> Τα πεδία αυτού του βήματος είναι προαιρετικά!</big></br></br><table>';
                        if($this->Session->check('uploaded3')){
                            $uploaded3 = $this->Session->read('uploaded3');      
                            echo '<tr><td><label for="ReportImage2" class="std_form">Επιπλέον Φωτογραφία 1 </label></td><td>'.$this->Html->image($uploaded3['imagePath'],array('class'=>'tableImage')).'</td></tr>';
                            echo $this->Form->input('additional_photo1',array("type" => "hidden",'value'=> $report['Report']['additional_photo1']));
                        }
                        else{
                            echo '<tr><td><label for="ReportImage2" class="std_form">Επιπλέον Φωτογραφία 1 </label></td>';
                            echo '<td>'.$this->Form->input('image2',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';                  
                        } 
                        
                        if($this->Session->check('uploaded4')){
                            $uploaded4 = $this->Session->read('uploaded4');      
                            echo '<tr><td><label for="ReportImage3" class="std_form">Επιπλέον Φωτογραφία 2 </label></td><td>'.$this->Html->image($uploaded4['imagePath'],array('class'=>'tableImage')).'</td></tr>';
                            echo $this->Form->input('additional_photo2',array("type" => "hidden",'value'=> $report['Report']['additional_photo2']));
                        }
                        else{
                            echo '<tr id="photo3" style="display:none;"><td><label for="ReportImage3" class="std_form">Επιπλέον Φωτογραφία 2 </label></td>';
                            echo '<td>'.$this->Form->input('image3',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
                        }
                        
                        if($this->Session->check('uploaded5')){
                            $uploaded5 = $this->Session->read('uploaded5');      
                            echo '<tr><td><label for="ReportImage4" class="std_form">Επιπλέον Φωτογραφία 3 </label></td><td>'.$this->Html->image($uploaded5['imagePath'],array('class'=>'tableImage')).'</td></tr>';
                            echo $this->Form->input('additional_photo3',array("type" => "hidden",'value'=> $report['Report']['additional_photo3']));
                        }
                        else{
                            echo '<tr id="photo4" style="display:none;"><td><label for="ReportImage4" class="std_form">Επιπλέον Φωτογραφία 3 </label></td>';
                            echo '<td>'.$this->Form->input('image4',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
                        }
                        
                        if($this->Session->check('uploaded6')){
                            $uploaded6 = $this->Session->read('uploaded6');      
                            echo '<tr><td><label for="ReportImage5" class="std_form">Επιπλέον Φωτογραφία 4 </label></td><td>'.$this->Html->image($uploaded6['imagePath'],array('class'=>'tableImage')).'</td></tr>';
                            echo $this->Form->input('additional_photo4',array("type" => "hidden",'value'=> $report['Report']['additional_photo4']));
                        } 
                        else{
                            echo '<tr id="photo5" style="display:none;"><td><label for="ReportImage5" class="std_form">Επιπλέον Φωτογραφία 4 </label></td>';
                            echo '<td>'.$this->Form->input('image5',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
                        }
                        
                        if($this->Session->check('uploaded7')){
                            $uploaded7 = $this->Session->read('uploaded7');      
                            echo '<tr><td><label for="ReportImage6" class="std_form">Επιπλέον Φωτογραφία 5 </label></td><td>'.$this->Html->image($uploaded7['imagePath'],array('class'=>'tableImage')).'</td></tr>';
                            echo $this->Form->input('additional_photo5',array("type" => "hidden",'value'=> $report['Report']['additional_photo5']));
                        } 
                        else{
                            echo '<tr id="photo6" style="display:none;"><td><label for="ReportImage6" class="std_form">Επιπλέον Φωτογραφία 5 </label></td>';
                            echo '<td>'.$this->Form->input('image6',array("type" => "file",'label'=>false, 'class'=>'std_form', 'div'=>false)).'</td></tr>';
                        }
                        
                        
                        echo '<tr><td><input type="button" id="addbutton" onclick="addInput()" name="add" value="Προσθέστε μια ακόμα φωτογραφία" /></td></tr>';

                        echo '<tr><td><label for="ReportHot_species" class="std_form">Είναι κάποιο απο τα παρακάτω είδη-στόχους; </label></td></tr>';
                        echo '</table>';    
                        echo '<br/>';
                                          
                        
                        
                        $iter = 0;
                        foreach($hotspecies as $hot){
                            if($iter == 0){
                                echo '<div class="hot_radio" style="clear:left;"><input type="radio" id="'.$hot['HotSpecie']['id'].'" name="data[Report][hot_species]" value="'.$hot['HotSpecie']['scientific_name'].'" class="std_form" ';
                                if($report['Report']['hot_species']===$hot['HotSpecie']['scientific_name']) echo ' checked ';
                                echo '/>';
                                $iter = 1;
                            }
                            else{
                                echo '<div class="hot_radio"><input type="radio" id="'.$hot['HotSpecie']['id'].'" name="data[Report][hot_species]" value="'.$hot['HotSpecie']['scientific_name'].'" class="std_form" ';
                                if($report['Report']['hot_species']===$hot['HotSpecie']['scientific_name']) echo ' checked ';
                                echo '/>';    
                            }
                            echo '<label for="'.$hot['HotSpecie']['id'].'"><img src="'.$this->webroot.'img/'.$hot['HotSpecie']['main_photo'].'" alt="" /></label></div>';
                        }
                         echo '<div class="hot_radio"><input type="radio" name="data[Report][hot_species]" value="Κανένα" class="std_form"';
                         if ($report['Report']['hot_species']==="Κανένα") echo 'checked ';
                        echo       '/>  Κανένα απο τα παραπάνω </div>';
                        
                         
                        echo '<table>';
                        
                        			
			echo '<a id="a1_right" href="#" style="clear:left;">'.$this->Html->image('info.png').'</a>';
                        echo '<tr><td><label for="ReportHabitat" class="std_form">Βιοτοπος-Περιβάλλον Παρατήρησης </label></td>';
                        echo '<td>'.$this->Form->input('habitat',array('label'=>false,'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','value'=>$report['Report']['habitat'],'div'=> false, 'class' => 'std_form blue_shadow')).'</td></tr>';
                        echo '<tr><td><label for="ReportDepth" class="std_form">Βάθος</label></td>';
                        echo '<td>'.$this->Form->input('depth',array('label'=>false,'value'=>$report['Report']['depth'],'placeholder'=>'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportRe_observation" class="std_form">Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; </label></td>';
                        echo '<td>'.$this->Form->input('re_observation',array('label' => false,'value'=>$report['Report']['re_observation'],'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                        $options = array('-'=>'-','1' => '1', '2-5' => '2-5', '6-10' => '6-10','11-30' => '11-30', '>30'=>'>30');
                        echo '<tr><td><label for="ReportCrowd" class="std_form">Πλήθος Ατόμων Είδους </label></td>';
                        echo '<td>'.$this->Form->input('crowd', array('options' => $options, 'default' => ' - ','label' => false,'value'=>$report['Report']['crowd'], 'class'=>'std_form blue_shadow', 'div'=> false)).'</td></tr>';
                        echo '<tr><td><label for="ReportComments" class="std_form">Επιπλέον Σχόλια </label></td>';
                        echo '<td>'.$this->Form->input('comments', array('type' => 'textarea','label' => false,'value'=>$report['Report']['comments'],'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow', 'div'=>false)).'</td></tr>';
                        echo '</table>';
                                                //echo "<a href='#1' class='prev-tab mover'>&#171; Προηγούμενο βήμα</a>";
                                                //echo "<a href='#3' class='next-tab mover'>Επόμενο βήμα &#187;</a>";
                        echo '</div>';

                        echo '<div id="f3">';
                        echo '</br><big style="font-family:Arial,sans-serif;"> Τα πεδία αυτού του βήματος είναι προαιρετικά!</big></br></br>';
                        echo '<table>';
                    }
                    if($this->Session->check('UserUsername')){
                        //echo "You are logged in!"; 
                        echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                        
                        $monthOptions = array('01' => 'Ιανουαρίου','02' => 'Φεβρουαρίου','03' => 'Μαρτίου','04' => 'Απριλίου','05' => 'Μαΐου','06' => 'Ιουνίου',
                                             '07' => 'Ιουλίου','08' => 'Αυγούστου','09' => 'Σεπτεμβρίου','10' => 'Οκτωβρίου','11' => 'Νοεμβρίου', '12' => 'Δεκεμβρίου');
                       
                        $agedata = explode("-",$this->Session->read('UserBirthDate'));
                        echo '<td>';
                        echo $this->Form->day('displayage', array('label'=> false, 'disabled'=>true, 'empty' => 'Ημέρα', 'value' => $agedata[2]));
                        echo $this->Form->month('displayage', array('label'=> false, 'disabled'=>true, 'monthNames' => $monthOptions, 'empty' => 'Μήνας', 'value' => $agedata[1]));
                        echo $this->Form->year('displayage', date('Y') - 110, date('Y'), array('label'=> false, 'disabled'=>true, 'empty' => "Χρονιά", 'value' => $agedata[0]));
                        echo '</td></tr>';
                        echo '<select name="data[Report][age][month]" id="ReportAgeMonth" style="display:none;">
                                        <option value="'.$agedata[1].'" selected="selected">'.$agedata[1].'</option>
                                  </select>

                                 <select name="data[Report][age][day]" id="ReportAgeDay" style="display:none;">
                                         <option value="'.$agedata[2].'" selected="selected">'.$agedata[2].'</option>
                                 </select>

                                 <select name="data[Report][age][year]" id="ReportAgeYear" style="display:none;">
                                         <option value="'.$agedata[0].'" selected="selected">'.$agedata[0].'</option>
                                 </select>';
                        switch($this->Session->read('UserEducation')){
                                case 'first':
                                    $education= 'Πρωτοβάθμια';
                                    break;
                                case 'second':
                                    $education= 'Δευτεροβάθμια';
                                    break;
                                case 'third':
                                    $education= 'Τριτοβάθμια - Ανώτατη';
                                    break;
                                default:
                                    $education= '-';
                                    break;    
                            }    
                        echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>';
                        //echo '<td>'.$this->Form->input('education', array('options' => $options,'default'=>$this->Session->read('UserEducation'),'label'=>false,'class'=>'std_form blue shadow', 'div'=>false)).'</td></tr>';
                        echo '<td>'.$this->Form->input('education', array('value'=>$education, 'label'=>false,'class'=>'std_form blue shadow', 'div'=>false, 'readonly'=>'readonly')).'</td></tr>';
                        echo '<select name="data[Report][education]" id="ReportEducation" style="display:none;">
                                    <option value="'.$this->Session->read('UserEducation').'" selected="selected">'.$this->Session->read('UserEducation').'</option>
                             </select>';       
                        
                        
                        switch($this->Session->read('UserMembership')){
                                case 'fisher':
                                    $occupation = 'Ψαράς';
                                    break;
                                case 'diver':
                                    $occupation = 'Δύτης';
                                    break;
                                case 'tourist':
                                    $occupation = 'Τουρίστας';
                                    break;
                                case 'other':
                                    $occupation = 'Άλλο';
                                    break;
                                default:
                                    $occupation = '-';
                                    break;    
                            }    
                        echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>';
                        //echo '<td>'.$this->Form->input('occupation', array('options' => $options,'default'=>$this->Session->read('UserMembership'),'label'=>false, 'class'=>'std_form')).'</td></tr>';
                        echo '<td>'.$this->Form->input('occupation', array('value'=>$occupation, 'label'=>false,'class'=>'std_form','readonly'=>'readonly')).'</td></tr>';
 	                echo '<select name="data[Report][occupation]" id="ReportOccupation" style="display:none;">
                                 <option value="'.$this->Session->read('UserMembership').'" selected="selected">'.$this->Session->read('UserMembership').'</option>
                              </select>';
                        
                        echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                        echo '<td>'.$this->Form->input('name',array("label" => false,'value'=>$this->Session->read('UserName'),'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow', 'readonly'=>'readonly', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                        echo '<td>'.$this->Form->input('surname',array("label" => false, 'value'=>$this->Session->read('UserSurname'),'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow', 'readonly'=>'readonly', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                        echo '<td>'.$this->Form->input('phone_number',array("label" => false,'value'=>$this->Session->read('UserPhoneNumber'),'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow', 'readonly'=>'readonly', 'div'=>false)).'</td></tr>';
                        echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                        echo '<td>'.$this->Form->input('email',array("label"=>false,'value'=>$this->Session->read('UserUsername'),'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow', 'readonly'=>'readonly', 'div'=>false)).'</td></tr>';
                        echo $this->Form->input('observer',array('value'=>$userId,"type"=>'hidden', 'class'=>'std_form'));
                        
                    }
                    else{
                        if($this->Session->check('report')){
                            echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                            
                            $monthOptions = array('01' => 'Ιανουαρίου','02' => 'Φεβρουαρίου','03' => 'Μαρτίου','04' => 'Απριλίου','05' => 'Μαΐου','06' => 'Ιουνίου',
                            '07' => 'Ιουλίου','08' => 'Αυγούστου','09' => 'Σεπτεμβρίου','10' => 'Οκτωβρίου','11' => 'Νοεμβρίου', '12' => 'Δεκεμβρίου');
                            echo '<td>'.$this->Form->day('age', array('label'=> false, 'empty' => 'Ημέρα', 'value'=>$report['Report']['age']['day']));
                            echo $this->Form->month('age', array('label'=> false, 'monthNames' => $monthOptions, 'empty' => "Μήνας",'value'=>$report['Report']['age']['month']));
                            echo $this->Form->year('age', date('Y') - 25, date('Y'), array('label'=> false, 'empty' => "Χρονιά", 'value'=>$report['Report']['age']['year'])).'</td></tr>';
                            
                            //echo '<td>'.$this->Form->input('age',array('label'=>false,'default'=>$report['Report']['age'], 'class'=>'std_form blue shadow', 'div'=>false,'empty' => true,'minYear' => date('Y')-100, 'maxYear' => date('Y'))).'</td></tr>';
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
                            $monthOptions = array('01' => 'Ιανουαρίου','02' => 'Φεβρουαρίου','03' => 'Μαρτίου','04' => 'Απριλίου','05' => 'Μαΐου','06' => 'Ιουνίου',
                            '07' => 'Ιουλίου','08' => 'Αυγούστου','09' => 'Σεπτεμβρίου','10' => 'Οκτωβρίου','11' => 'Νοεμβρίου', '12' => 'Δεκεμβρίου');
                            echo '<td>'.$this->Form->day('age', array('label'=> false, 'empty' => 'Ημέρα', ));
                            echo $this->Form->month('age', array('label'=> false, 'monthNames' => $monthOptions, 'empty' => "Μήνας"));
                            echo $this->Form->year('age', date('Y') - 25, date('Y'), array('label'=> false, 'empty' => "Χρονιά")).'</td></tr>';


                                //echo '<td>'.$this->Form->input('age',array('label'=>false, 'class'=>'std_form blue shadow', 'div'=>false,'empty' => true,'minYear' => date('Y')-100, 'maxYear' => date('Y'))).'</td></tr>';
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
                    
                    
                    echo '<br/>';
                    echo '</table></div>';
                    echo '<a href="#" style="display:none;" class="fragment button_like_anchor left_arrow white_arrow"><img src="'.$this->webroot.'img/arrows/white_arrow_left_small3.png"/>Προηγούμενο Βήμα</a>';
                    echo $this->Form->end(array(
                    'label' => 'Κατάθεση Αναφοράς',
                    'div' => false,
                    'class' => 'std_form'));
                    echo '<a href="#" class="fragment button_like_anchor right_arrow white_arrow">Επόμενο Βήμα<img src="'.$this->webroot.'img/arrows/white_arrow_right_small3.png"/></a>';
                    echo '<br />';
                    echo $this->Html->link('Νέα αναφορά', array('controller' => 'reports', 'action'=>'createnew'), array('class' => 'button_like_anchor' , "style" => "padding-left: 3em;padding-right: 3em;margin-top:1em;"));
                    echo '<div class="report_button_wrapper">';
                    echo '<a href="#" style="display:none;" class="fragment button_like_anchor left_arrow white_arrow"><img src="'.$this->webroot.'img/arrows/white_arrow_left_small3.png"/>Προηγούμενο Βήμα</a>';
                    echo $this->Form->end(array(
                    'label' => 'Κατάθεση Αναφοράς',
                    'div' => false,
                    'class' => 'std_form'));
                    echo '<a href="#" class="fragment button_like_anchor right_arrow white_arrow">Επόμενο Βήμα<img src="'.$this->webroot.'img/arrows/white_arrow_right_small3.png"/></a>';
                    echo $this->Html->link('Νέα αναφορά', array('controller' => 'reports', 'action'=>'createnew'), array('class' => 'button_like_anchor' , "style" => "padding-left: 5.4em;padding-right: 5.4em;"));
                    echo "</div>";
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

<div id="tip1_right" style="display:none;">
                            Μπορείτε να μάθετε περισσότερα για τα παραπάνω είδη στην σελίδα <?php echo $this->Html->link('Είδών-στόχων', array('controller' => 'hotSpecies', 'action'=>'view'),array('target' => '_blank'));?>
</div>

<div id="tip2_right" style="display:none;">
                            Μπορείτε να κλικάρετε πάνω στον χάρτη στην περιοχή που θέλετε για να τοποθετήσετε το στίγμα σας
</div>