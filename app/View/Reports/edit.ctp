<?php echo $this->Html->css(array('jquery-ui'),null, array('inline'=>false)); ?>
<?php echo $this->Html->script(array('jquery.min','jquery-ui.min','tiny_mce/tiny_mce','jwplayer/jwplayer'), array('inline'=>false));?>  
<?php $this->set('title_for_layout', 'Επεξεργασία αναφοράς - ΕΛΚΕΘΕ');?>  

<script>

    $(function() {
            var availableTags = <?php echo json_encode($species); ?>;

            $( "#autoComplete" ).autocomplete({
                    source: availableTags
            });
    });

</script>  

        <script type="text/javascript"
            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC0azkJD2QB5m24LzhdEUenVmgCJPNaiDI&sensor=false">
        </script>
        <script>
            var map;
            $(window).ready(function(){
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
                    setMarker();
            });
        </script>
  

	<div class="middle_row big_row no_padding">
            <style>
                #mapCanvas {
                    width: 100%;
                    height: 30em;
                    position: relative;
                }
            </style>
                    
            <?php   echo '<div class="login_box">  
                               <h1>Επεξεργασία αναφοράς</h1>
                         </div>';
                    echo '<div class="flash_box gradient">';
                    echo '</br/>'.$this->Session->flash().'</br>';
                    echo '</div>';	?>
        	<div class="summary_middle_wrapper">   
                
                <?php 
                    
                    	
                    echo $this->Form->create('Report', array('action' => 'edit',"enctype" => "multipart/form-data"));

                    echo '<table>';
                    echo '<tr><td colspan="2"><div id="mapCanvas"></div></td></tr>';
                    echo '<script>';
                    echo 'function setMarker(){';
                    echo '  var point1 = '.$report['Report']['lat'].';';
                    echo '  var point2 = '.$report['Report']['lng'].';';
                    echo '  var location = new google.maps.LatLng(point1,point2,true);';
                    echo '  var marker = new google.maps.Marker({
                                    animation: google.maps.Animation.DROP,
                                    position: location,
                                    map: map
                                });
                          }';
                    echo '        </script>';
                    echo '<tr><td><label class="std_form">Τοποθεσία παρατήρησης: </label></td>';
                    echo '<td>'.$report['Report']['area'].'</td></tr>';
                    echo '<tr><td><label for="ReportLat" class="std_form">Γεωγραφικός Πλάτος </label></td>';
                    echo '<td>'.$report['Report']['lat'].'</td></tr>';

		
                    echo '<tr><td><label for="ReportLng" class="std_form">Γεωγραφικός Μήκος </label></td>';
                    echo '<td>'.$report['Report']['lng'].'</td></tr>';

                    $datestr = explode('-',$report['Report']['date']);
                    echo '<tr><td><label for="ReportDate" class="std_form">Ημερομηνία Παρατήρησης </label></td>';
                    echo '<td>'.$datestr[2].' ';
                    switch ($datestr[1]) {
                        case '01':
                            echo "Ιανουαρίου ";
                            break;
                        case '02':
                            echo "Φεβρουαρίου ";
                            break;
                        case '03':
                            echo "Μαρτίου ";
                            break;
                        case '04':
                            echo "Απριλίου ";
                            break;
                        case '05':
                            echo "Μαίου ";
                            break;
                        case '06':
                            echo "Ιουνίου ";
                            break;
                        case '07':
                            echo "Ιουλίου ";
                            break;
                        case '08':
                            echo "Αυγούστου ";
                            break;
                        case '09':
                            echo "Σεπτεμβρίου ";
                            break;
                        case '10':
                            echo "Οκτωβρίου ";
                            break;
                        case '11':
                            echo "Νοεμβρίου ";
                            break;
                        case '12':
                            echo "Δεκεμβρίου ";
                            break;

                    }
                    echo $datestr[0].'</td></tr>';
                    echo '<tr><td><label for="ReportDate" class="std_form">Ημερομηνία Exif </label></td>';
                    echo '<td>'.$report['Report']['exif'].'</td></tr>';
                    echo '<tr><td><label for="ReportHabitat" class="std_form">Βιοτοπος-Περιβάλλον Παρατήρησης </label></td>';
                    echo '<td>'.((!strcmp($report['Report']['habitat'],'')) ? '-' : $report['Report']['habitat']).'</td></tr>';

                    echo '<tr><td><label for="ReportDepth" class="std_form">Βάθος</label></td>';
                    echo '<td>'.((!strcmp($report['Report']['depth'],'')) ? '-' : $report['Report']['depth']).'</td></tr>';

                    echo '<tr><td><label for="ReportRe_observation" class="std_form">Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; </label></td>';
                    echo '<td>'.((!strcmp($report['Report']['re_observation'],'')) ? '-' : $report['Report']['re_observation']).'</td></tr>';

                    //$options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');
                    echo '<tr><td><label for="ReportCrowd" class="std_form">Πλήθος Ατόμων Είδους </label></td>';
                    echo '<td>';
                    switch($report['Report']['crowd']){
                        case '-':
                            echo '-';
                            break;
                        case 'few':
                            echo '1-5';
                            break;
                        case 'some':
                            echo '6-10';
                            break;
                        case 'many':
                            echo '10-30';
                            break;    
                    }    
                    echo'</td></tr>';
                    
                    echo '<tr><td><label for="ReportComments" class="std_form">Επιπλέον Σχόλια </label></td>';
                    echo '<td>'.((!strcmp($report['Report']['comments'],'')) ? '-' : $report['Report']['comments']).'</td></tr>';             
                    
                    echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                    $age = explode('-',$report['Report']['date']);
                            echo '<td>'.$age[2].' ';
                            switch ($age[1]) {
                                case '01':
                                    echo "Ιανουαρίου ";
                                    break;
                                case '02':
                                    echo "Φεβρουαρίου ";
                                    break;
                                case '03':
                                    echo "Μαρτίου ";
                                    break;
                                case '04':
                                    echo "Απριλίου ";
                                    break;
                                case '05':
                                    echo "Μαίου ";
                                    break;
                                case '06':
                                    echo "Ιουνίου ";
                                    break;
                                case '07':
                                    echo "Ιουλίου ";
                                    break;
                                case '08':
                                    echo "Αυγούστου ";
                                    break;
                                case '09':
                                    echo "Σεπτεμβρίου ";
                                    break;
                                case '10':
                                    echo "Οκτωβρίου ";
                                    break;
                                case '11':
                                    echo "Νοεμβρίου ";
                                    break;
                                case '12':
                                    echo "Δεκεμβρίου ";
                                    break;
                                default:
                                    echo "-";
                                    break;

                            }
                            echo $age[0].'</td></tr>';
                            echo '<tr><td><label for="ReportEducation" class="std_form">Επίπεδο Εκπαίδευσης </label></td>';
                            echo '<td>';
                            switch($report['Report']['education']){
                                case 'first':
                                    echo 'Πρωτοβάθμια';
                                    break;
                                case 'second':
                                    echo 'Δευτεροβάθμια';
                                    break;
                                case 'third':
                                    echo 'Τριτοβάθμια - Ανώτατη';
                                    break;
                                default:
                                    echo '-';
                                    break;    
                            }    
                            echo'</td></tr>';
                            echo '<tr><td><label for="ReportOccupation" class="std_form">Ιδιότητα </label></td>';
                            echo '<td>';
                            switch($report['Report']['occupation']){
                                case 'fisher':
                                    echo 'Ψαράς';
                                    break;
                                case 'diver':
                                    echo 'Δύτης';
                                    break;
                                case 'tourist':
                                    echo 'Τουρίστας';
                                    break;
                                case 'other':
                                    echo 'Άλλο';
                                    break;
                                default:
                                    echo '-';
                                    break;    
                            }    
                            echo'</td></tr>';
                            
                            echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                            echo '<td>'.((!strcmp($report['Report']['name'],'')) ? '-' : $report['Report']['name']).'</td></tr>';
                            
                            echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                            echo '<td>'.((!strcmp($report['Report']['surname'],'')) ? '-' : $report['Report']['surname']).'</td></tr>';
                            
                            echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                            echo '<td>'.((!strcmp($report['Report']['phone_number'],'')) ? '-' : $report['Report']['phone_number']).'</td></tr>';
                             
                            echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                            echo '<td>'.((!strcmp($report['Report']['email'],'')) ? '-' : $report['Report']['email']).'</td></tr>';
                            					    
                        
                        

                    echo '</table>';
                    //echo $this->Form->input('category_id', array('value'=>null,'label'=>'Κατηγορία Είδους','type'=>'hidden', 'class'=>'std_form'));
                    //echo $this->Form->input('state', array('options' => $options,'value'=>'unknown','label'=>'Κατάσταση Αναφοράς ','type'=>'hidden', 'class'=>'std_form'));                                        
                    echo '<div class="media_wrapper">';
                    if(isset($report['Report']['main_photo'])){
                        echo $this->Html->image($report['Report']['main_photo']);
                        echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας; ", 'default' => $report['Report']['permissionUseMedia'], 'onclick'=>'return false', 'onkeydown'=>'return false', 'class'=>'std_form'));
                    }
                    //check if additional photos are available
                    echo '<div class="additional">';
                    for($i=1;$i<6;$i++){
                        if(isset($report['Report']['additional_photo'.$i]))
                                echo $this->Html->image($report['Report']['additional_photo'.$i]);	  
                                //can have a break here assuming they're uploaded additively
                    }
					echo '</div>';
                    if(isset($report['Report']['video'])){
                        
                        
                        echo '<div id="container">Loading the player ...</div>
                                
                              <script type="text/javascript">
                                jwplayer("container").setup({
                                flashplayer: "/js/jwplayer/player.swf",
                                file: "'.$this->webroot.'video/'.$report['Report']['video'].'",
                                height: 270,
                                width: 480
                                });
                              </script>';
                        
                        $file = explode('/',$report['Report']['video'],3);
                        echo $this->Html->link("Κατέβασμα βίντεο", '/Reports/downloadvid/'. $file[1]);
                    }
                    echo '</div>';
                    
                    $options = array(null => '-');
//                                // Add categories dynamically
                    foreach ($categories as $category)
                    {
                        $options[$category['Category']['id']]= $category['Category']['category_name'];
                    }
                    echo '<table><tr><td><label for="ReportCategory" class="std_form">Κατηγορία Είδους</label></td><td>'.$this->Form->input('category_id', array('options' => $options, 'value'=>null,'label'=>false, 'class'=>'std_form')).'</td></tr>';
                    echo '<tr><td><label for="ReportState" class="std_form">Επιστημονική Ονομασία</label></td><td>'.$this->Form->input('scientific_name', array('value'=>null,'label'=>false,'class'=>'std_form','id'=>'autoComplete')).'</td></tr>';
                    $options = array('unknown' => 'Άγνωστη','confirmed' => 'Έγκυρη', 'unreliable' => 'Αναξιόπιστη');  								
                    echo '<tr><td><label for="ReportState" class="std_form">Κατάσταση αναφοράς</label></td><td>'.$this->Form->input('state', array('options' => $options,'value'=>'unknown','label'=>false,'class'=>'std_form')).'</td></tr>';
                    echo $this->Form->input('id',array("type"=>'hidden'));
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
                    echo '</div>';
            ?>
                        
            </div>

	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	
