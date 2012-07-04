<?php echo $this->Html->script(array('jquery.min'), array('inline'=>false));?>  
<?php $this->set('title_for_layout', 'Σύνοψη αναφοράς - ΕΛΚΕΘΕ');?>  


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
                               <h1>Σύνοψη αναφοράς</h1>
                         </div>';
                    echo '<div class="flash_box gradient">';
                    echo '</br/>'.$this->Session->flash().'</br>';
                    echo '</div>';	?>
        	<div class="summary_middle_wrapper">   
                
                <?php 
                    $report = $this->Session->read('report');
                    
                    echo $this->Form->create('Report', array('action' => 'summary',"enctype" => "multipart/form-data"));

                    echo '<table class="summary_table">';
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
                    echo '<tr><td><label class="std_form">Τοποθεσία παρατήρησης </label></td> </tr>';
                    echo $this->Form->hidden('area',array( 'id'=>'maparea','value'=>$report['Report']['area'], 'div'=>false , "label" => false , "class" => "std_form"));

                    echo '<tr><td><label for="ReportLat" class="std_form">Γεωγραφικός Πλάτος </label></td>';
                    echo '<td>'.$report['Report']['lat'].'</td></tr>';

                    echo $this->Form->input('lat',array('type'=>'hidden', 'id'=>'info','value'=>$report['Report']['lat'],'label' => false,'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow', 'div'=>false));
		
                    echo '<tr><td><label for="ReportLng" class="std_form">Γεωγραφικός Μήκος </label></td>';
                    echo '<td>'.$report['Report']['lng'].'</td></tr>';
                    echo $this->Form->input('lng',array('type'=>'hidden', 'div'=>false,'id'=>'info2','value'=>$report['Report']['lng'],'label' => false,'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow','readonly'=>'readonly'));

		    echo '<tr><td><label for="ReportDate" class="std_form">Ημερομηνία Παρατήρησης </label></td>';
                    echo '<td>'.$report['Report']['date']['day'].' ';
                    switch ($report['Report']['date']['month']) {
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
                            echo "Οκτοβρίου ";
                            break;
                        case '11':
                            echo "Νοεμβρίου ";
                            break;
                        case '12':
                            echo "Δεκεμβρίου ";
                            break;

                    }
                    echo $report['Report']['date']['year'].'</td></tr>';
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
                    echo '<td>'.((!strcmp($report['Report']['habitat'],'')) ? '-' : $report['Report']['habitat']).'</td></tr>';
                    echo $this->Form->input('habitat',array('type'=>'hidden' , 'label'=>false,'value'=>$report['Report']['habitat']));

                    echo '<tr><td><label for="ReportDepth" class="std_form">Βάθος</label></td>';
                    echo '<td>'.((!strcmp($report['Report']['depth'],'')) ? '-' : $report['Report']['depth']).'</td></tr>';
                    echo $this->Form->input('depth',array('type'=>'hidden', 'label'=>false,'value'=>$report['Report']['depth']));

                    echo '<tr><td><label for="ReportRe_observation" class="std_form">Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; </label></td>';
                    echo '<td>'.((!strcmp($report['Report']['re_observation'],'')) ? '-' : $report['Report']['re_observation']).'</td></tr>';
                    echo $this->Form->input('re_observation',array('type'=>'hidden', 'value'=>$report['Report']['re_observation'], 'label' => false));

                    //$options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');
                    echo '<tr><td><label for="ReportCrowd" class="std_form">Πλήθος Ατόμων Είδους </label></td>';
                    echo '<td>'.$report['Report']['crowd'].'</td></tr>';
                    echo $this->Form->input('crowd', array('type'=>'hidden', 'value'=>$report['Report']['crowd'])).'</td></tr>';

                    echo '<tr><td><label for="ReportComments" class="std_form">Επιπλέον Σχόλια </label></td>';
                    echo '<td>'.((!strcmp($report['Report']['comments'],'')) ? '-' : $report['Report']['comments']).'</td></tr>';             
                    echo $this->Form->input('comments', array('type' => 'hidden','value'=>$report['Report']['comments'])).'</td></tr>';
                    echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                    
                    
                    
                    if($this->Session->check('report')){
                        
                        
                            echo '<td>'.$report['Report']['age']['day'].' ';
                            switch ($report['Report']['age']['month']) {
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
                            echo $report['Report']['age']['year'].'</td></tr>';
                            echo '<select name="data[Report][age][month]" id="ReportAgeMonth" style="display:none;">
                                        <option value="'.$report['Report']['age']['month'].'" selected="selected">'.$report['Report']['age']['month'].'</option>
                                  </select>

                                 <select name="data[Report][age][day]" id="ReportAgeDay" style="display:none;">
                                         <option value="'.$report['Report']['age']['day'].'" selected="selected">'.$report['Report']['age']['day'].'</option>
                                 </select>

                                 <select name="data[Report][age][year]" id="ReportAgeYear" style="display:none;">
                                         <option value="'.$report['Report']['age']['year'].'" selected="selected">'.$report['Report']['age']['year'].'</option>
                                 </select>';
                            
                            
                            
                        
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
                            echo $this->Form->input('education', array('type'=>'hidden', 'value'=>$report['Report']['education']));

                                   
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
                            echo $this->Form->input('occupation', array('type'=>'hidden','value'=>$report['Report']['occupation']));
                            /*echo '<select name="data[Report][occupation]" id="ReportOccupation" style="display:none;">
                                    <option value="'.$report['Report']['occupation'].'" selected="selected">'.$report['Report']['occupation'].'</option>
                            </select>';*/

                            
                            if(isset($report['Report']['observer']))
                                    echo $this->Form->input('observer',array('value'=>$report['Report']['observer'],"type"=>'hidden', 'class'=>'std_form'));
                            

                            echo '<tr><td><label for="ReportName" class="std_form">Όνομα</label></td>';
                            echo '<td>'.((!strcmp($report['Report']['name'],'')) ? '-' : $report['Report']['name']).'</td></tr>';
                            echo $this->Form->input('name',array('type'=>'hidden','value'=>$report['Report']['name']));

                            echo '<tr><td><label for="ReportSurname" class="std_form">Επώνυμο</label></td>';
                            echo '<td>'.((!strcmp($report['Report']['surname'],'')) ? '-' : $report['Report']['surname']).'</td></tr>';
                            echo $this->Form->input('surname',array('type'=>'hidden', 'value'=>$report['Report']['surname']));
                            
                            echo '<tr><td><label for="ReportPhone_number" class="std_form">Τηλέφωνο Επικοινωνίας </label></td>';
                            echo '<td>'.((!strcmp($report['Report']['phone_number'],'')) ? '-' : $report['Report']['phone_number']).'</td></tr>';
                            echo $this->Form->input('phone_number',array('type'=>'hidden','value'=>$report['Report']['phone_number']));
                            
                            echo '<tr><td><label for="ReportEmail" class="std_form">E-mail </label></td>';
                            echo '<td>'.((!strcmp($report['Report']['email'],'')) ? '-' : $report['Report']['email']).'</td></tr>';
                            echo $this->Form->input('email',array('type'=>'hidden' ,'value'=>$report['Report']['email']));							    
                        }
                        else{ 
                            echo 'what case is this?';
                            echo '<tr><td><label for="ReportAge" class="std_form">Ημερομηνία Γέννησης </label></td>';
                            
                            echo '<td>'.$report['Report']['age']['day'].' ';
                            switch ($report['Report']['age']['month']) {
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
                                    echo "Οκτοβρίου ";
                                    break;
                                case '11':
                                    echo "Νοεμβρίου ";
                                    break;
                                case '12':
                                    echo "Δεκεμβρίου ";
                                    break;

                            }
                            echo $report['Report']['age']['year'].'</td></tr>';
                            echo '<select name="data[Report][date][month]" class="std_form blue shadow" id="ReportDateMonth" style="display:none;">
                                                        <option value="'.$report['Report']['age']['month'].'" selected="selected">'.$report['Report']['age']['month'].'</option>
                                                </select>					
                                                <select name="data[Report][date][day]" class="std_form blue shadow" id="ReportDateDay" style="display:none;">
                                                        <option value="'.$report['Report']['age']['day'].'" selected="selected">'.$report['Report']['age']['day'].'</option>
                                                </select>
                                                <select name="data[Report][date][year]" class="std_form blue shadow" id="ReportDateYear" style="display:none;">
                                                        <option value="'.$report['Report']['age']['year'].'" selected="selected">'.$report['Report']['age']['year'].'</option>
                                                </select>';
                            
                            
                            //echo '<td>'.$this->Form->input('age',array('label'=>false, 'class'=>'std_form blue shadow', 'div'=>false,'readonly'=>'readonly')).'</td></tr>';
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

                    echo '</table>';
                    echo $this->Form->input('hot_species', array('type'=>'hidden', 'value' => $report['Report']['hot_species']));
                    echo $this->Form->input('state', array('value'=>'unknown','type'=>'hidden'));                
                    //echo $this->Form->input('category_id', array('value'=>null,'type'=>'hidden'));
                                                          
                    echo '<div class="media_wrapper">';
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
                    if($this->Session->check('uploaded5')){
                        $uploaded5 = $this->Session->read('uploaded5');
                        echo $this->Html->image($uploaded5["imagePath"]);
                        echo  $this->Form->input('additional_photo3',array('type'=>'hidden','value'=>$report['Report']['additional_photo3'], 'class'=>'std_form'));
                    }
                    if($this->Session->check('uploaded6')){
                        $uploaded6 = $this->Session->read('uploaded6');
                        echo $this->Html->image($uploaded6["imagePath"]);
                        echo  $this->Form->input('additional_photo4',array('type'=>'hidden','value'=>$report['Report']['additional_photo4'], 'class'=>'std_form'));
                    }
                    if($this->Session->check('uploaded7')){
                        $uploaded7 = $this->Session->read('uploaded7');
                        echo $this->Html->image($uploaded7["imagePath"]);
                        echo  $this->Form->input('additional_photo5',array('type'=>'hidden','value'=>$report['Report']['additional_photo5'], 'class'=>'std_form'));
                    }
                    echo '<br/>';
                    echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας; ", 'default' => $report['Report']['permissionUseMedia'], 'onclick'=>'return false', 'onkeydown'=>'return false', 'class'=>'std_form'));
                    echo '<br/>';
                    echo '</div>';
                    
                    echo '<div style="clear:left;">';
                    echo $this->Html->link('Επιστροφή στην αναφορά', array('controller' => 'reports', 'action'=>'create'), array('class' => 'button_like_anchor')).'</td>';
                    echo $this->Form->end(array(
                                                'label' => 'Οριστική υποβολή',
                                                'div' => false,
                                                'class' => 'std_form'));
                    echo '</div>';
                    
                    echo '</div>';
            ?>
                        
            </div>

	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	
