        <?php echo $this->Html->script(array('jquery-1.7.2.min'),array('inline' => false, 'rel' => 'javascript')); ?>
        <?php $this->set('title_for_layout', 'Αναγνωρισμένα Είδη');?>


        <script>
            var normal_pic = "<?php echo $this->webroot.'img/double_arrow6.png' ?>";
            var inverted_pic = "<?php echo $this->webroot.'img/double_arrow6_inv.png' ?>";
            var open = false;
            var offset = 3;
            
            function pow(num,power){
                var i;
                n = 1;
                for(i=0 ; i<power ; i++){
                    n = n * num;
                }
                return n;
            }
            
            function roundNum(num,digit){
                var p = pow(10,digit+1);
                var n = num * p;
                var dig = n % 10;                
                var dig2 = ((dig * 10) % 10)/10;
                dig = dig - dig2;
                dig2 = ((num * p) % 10)/10;
                p = pow(10,digit);
                num = (num * p) - dig2;                
                if(dig >= 5){
                    num++;
                }                
                return num;
            }
            
            function getEm($obj,height){
                var fnt_sz = $obj.parent().css('font-size');
                fnt_sz = parseInt(fnt_sz.substring(0,fnt_sz.length-2));
                var rnd_ems = ((1/fnt_sz)*height);                
                rnd_ems = roundNum(rnd_ems,0);
                return rnd_ems;
            }
            
            $(window).ready(function(){
                $('.specie_button').bind('click',function(){
                    var $this = $(this);
                    if(!$this.hasClass('selected_specie_button')){
                        $('.left_side').each(function(){
                            var $temp = $(this);
                            $temp.toggleClass('hidden_side');
                        });
                    }
                    return false;
                });
                $(".left_side").each(function(){
                    if($(this).hasClass("hidden_side"))
                        $(this).attr('style','display:block;');
                    $(this).find(".specie_areas").each(function(){
                        var $this = $(this);
                        if(!$this.parent().parent().hasClass('current_specie_looked')){
                            var h_em = getEm($this,$this.height());
                            $this.attr('data-height',$this.height());
                            $this.parent().attr('data-margin',h_em);
                            $this.css('height','0px');
                        }
                    });
                    if($(this).hasClass("hidden_side"))
                        $(this).attr('style',' ');
                });
                $(".left_side_button").bind('click',function(){
                    $(this).parent().toggleClass("out_of_screen_side");
                    $(".right_side_button").parent().toggleClass('out_of_screen_side');
                    return false;
                });
                $(".right_side_button").bind('click',function(){
                    $(this).parent().toggleClass("out_of_screen_side");
                    $(".left_side_button").bind('click',function(){
                        $(this).parent().toggleClass('out_of_screen_side');
                    });
                    return false;
                });
                $(".more_areas").bind('click',function(){
                    var $this = $(this);
                    if(open && $this.attr('data-open') == 'true'){
                        $this.attr('data-open','false');
                        $this.find('img').attr('src',normal_pic);
                        $this.parent().find('.specie_areas').animate({'height' : '0px'}, 500);
                        $this.parent().animate({ 'bottom' : '-3em' },500, function() {
                                    $(this).parent().css('z-index','1');
                                });
                        open = false;
                    }
                    else if(open && $this.attr('data-open') != 'true'){
                        $('.more_areas').each(function(){
                            var $temp = $(this);
                            if($temp.attr('data-open') == 'true'){
                                $temp.attr('data-open','false');
                                $temp.find('img').attr('src',normal_pic);
                                $temp = $temp.parent().find('.specie_areas');
                                $temp.animate({ 'height' :  '0px' }, 500);
                                $temp.parent().css('z-index','1').animate( { 'bottom' : '-3em' } , 500 , function() {
                                    $(this).parent().css('z-index','1');
                                });
                                return false;
                            }
                        });
                        $this.find('img').attr('src',inverted_pic);
                        $this.attr('data-open','true');
                        var $temp = $this.parent().find('.specie_areas');
                        var $par = $this.parent();
                        $temp.animate({ 'height' :  $temp.attr('data-height') + 'px' }, 500);
                        $par.css('z-index','2').animate( { 'bottom' : (-1*(parseInt($par.attr('data-margin')) + 3)) + 'em' } , 500 );
                        $par.parent().css('z-index','2');
                        open = true;
                    }
                    else{
                        $this.find('img').attr('src',inverted_pic);
                        $this.attr('data-open','true');
                        var $temp = $this.parent().find('.specie_areas');
                        var $par = $this.parent();
                        $temp.animate({ 'height' :  $temp.attr('data-height') + 'px' }, 500);
                        $par.css('z-index','10').animate( { 'bottom' : (-1*(parseInt($par.attr('data-margin')) + 3)) + 'em' } , 500 );
                        $par.parent().css('z-index','2');
                        open = true;
                    }
                    return false;
                });
                
            });
        </script>
        
      	<div class="middle_row">
            
            <div class="login_box specie_box">  
                   <h1>Κατάλογος Αναγνωρισμένων Ειδών</h1>
             </div>
            
            <?php if(!isset($current_area))
                      echo '<div class="left_side">';
                  else 
                      echo '<div class="left_side hidden_side">';
            ?>
            <a href="#" class="left_side_button"><img src="<?php echo $this->webroot; ?>img/arrows/play_black.png"/></a>
                <div class="specie_search_wrapper">
                <?php echo $this->Form->create('Report', array('action' => 'showspecies', 'type'=>'get')); ?>
                <select name="select" id="filterSpecies">
                                        <option value="species" selected="selected">Είδος</option>
                                        <option value="area">Περιοχή</option>
                </select>
                <input name="text" type="text" class="std_form" id="filterTerm"/>
                <?php echo $this->Form->end(array(
                                                        'label' => 'Αναζήτηση',
                                                        'div' => false,
                                                        'class' => 'std_form'));
                
                                    ?>
                </div>
                <div class="specie_div specie_button_wrapper">
                                <a class="specie_button selected_specie_button" href="#">Είδη</a>
                                <a class="specie_button" href="#">Περιοχές</a>
                </div>
                <?php if(isset($current_species) && !empty($reports)){
                    echo '<div class="specie_div current_specie_looked">
                    <span class="little_specie_header">'.$current_species.'</span>
                    <div class="img_frame">
                        <img class="squarizer" src="'.$this->webroot.'img/square.png'.'"/>
                        <img class="specie_img" src="'.$this->webroot.$current_image.'"/>
                    </div>
                    <div class="region_button_wrapper">
                        <span class="specie_areas"><span>Περιοχές: </span>';
                        $flag = false;
                        foreach($sAreas[$current_species] as $area){ 
                            if($flag) 
                                echo ", "; 
                            else 
                                $flag = true; 
                            echo $area;

                        }
                    echo '</span>    
                    </div>
                </div>';
                }?>        
                <div class="specie_div" style="display:none"></div>
              
                <?php   $iter = 0; 
                        $div_flag = false;
                        foreach ($species as $spc):
                            if((isset($current_species) && !empty($reports) && $spc['Specie']['scientific_name'] != $current_species) || !isset($current_species)){
                                if($iter % 2 == 0){
                                    echo '<div class="specie_line_wrapper">';
                                    $div_flag = true;
                                }
                                echo '<div class="specie_div">
                                    <span class="little_specie_header">';echo $spc['Specie']['scientific_name']; echo '</span>
                                    <div class="img_frame">
                                        <img class="squarizer" src="'; echo $this->webroot.'img/square.png'; echo '" />
                                        <img class="specie_img" src="';echo $this->webroot.'img/'.$spc['Report']['main_photo'];echo '"/>
                                    </div>
                                    <div class="region_button_wrapper">
                                        <span class="specie_areas"><span>Περιοχές: </span>'; $flag = false;foreach($sAreas[$spc['Specie']['scientific_name']] as $area){ if($flag) echo ", "; else $flag = true; echo $area;} echo '</span>
                                        <a href="#" class="more_areas"><img src="';echo $this->webroot.'img/double_arrow6.png';echo '"/></a>
                                        <a href="'; echo $this->Html->url(array(
                                                "controller" => "reports",
                                                "action" => "showspecies",
                                                "?" => array("select" => 'species', 'text'=> $spc['Specie']['scientific_name'])

                                                ));echo '" class="more_info">Αναφορές είδους
                                        </a>
                                    </div>
                                </div>';
                                if($iter % 2 == 1){
                                    echo '</div>';
                                    $div_flag = false;
                                }
                                $iter++;
                            }
                        endforeach; 
                        if($div_flag){
                            echo '</div>';
                        }
             ?>
            </div>
            
            <?php if(isset($current_area))
                      echo '<div class="left_side">';
                  else 
                      echo '<div class="left_side hidden_side">';
            ?>
            <a href="#" class="left_side_button"><img src="<?php echo $this->webroot; ?>img/arrows/play_black.png"/></a>
                <div class="specie_search_wrapper">
                <?php echo $this->Form->create('Report', array('action' => 'showspecies', 'type'=>'get')); ?>
                <select name="select" id="filterSpecies">
                                        <option value="species" >Είδος</option>
                                        <option value="area" selected="selected">Περιοχή</option>
                </select>
                <input name="text" type="text" class="std_form" id="filterTerm"/>
                <?php echo $this->Form->end(array(
                                                        'label' => 'Αναζήτηση',
                                                        'div' => false,
                                                        'class' => 'std_form'));
                
                                    ?>
                </div>
                <div class="specie_div specie_button_wrapper">
                    <a class="specie_button" href="#">Είδη</a>
                    <a class="specie_button selected_specie_button" href="#">Περιοχές</a>
                </div>
                
                <?php if(isset($current_area) && !empty($reports)){
                            echo '<div class="specie_div current_specie_looked">
                                    <span class="little_specie_header">'.$current_area.'</span>  
                                    <div class="region_button_wrapper">
                                    <span class="specie_areas"><span>Είδη: </span>';
                            
                            $flag = false; 
                            foreach($aSpecies[$current_area] as $s){ 
                                if($flag) 
                                    echo ", "; 
                                else 
                                    $flag = true; 
                                echo $s;}

                            echo '</span>
                                    
                                </div>
                            </div>';
                            }  
               ?>   
            
            
                <?php   $iter = 0; 
                        $div_flag = false;
                        foreach($areas as $area):
                            if((isset($current_area) && !empty($reports) && $area['Report']['area'] != $current_area) || !isset($current_area)){
                                if($iter % 2 == 0){
                                    echo '<div class="specie_line_wrapper small_specie_line">';
                                    $div_flag = true;
                                }
                                echo '<div class="specie_div">
                                    <span class="little_specie_header">'; echo $area['Report']['area']; echo '</span>
                                    <div class="region_button_wrapper">
                                        <span class="specie_areas"><span>Είδη: </span>';
                                $flag = false; 
                                foreach($aSpecies[$area['Report']['area']] as $s){ 
                                    if($flag) 
                                        echo ", "; 
                                    else 
                                        $flag = true; 
                                    echo $s;
                                } 
                                        echo '
                                        </span>
                                        <a href="#" class="more_areas"><img src="'; echo $this->webroot.'img/double_arrow6.png'; echo '"/></a>
                                        <a href="'; echo $this->Html->url(array(
                                                "controller" => "reports",
                                                "action" => "showspecies",
                                                "?" => array('select'=> "area", 'text' => $area['Report']['area'])
                                                ));echo '" class="more_info">Αναφορές περιοχής
                                        </a>
                                    </div>
                                </div>';
                                if($iter % 2 == 1){
                                    echo '</div>';
                                    $div_flag = false;
                                }
                                $iter++;
                            }
                        endforeach;
                        if($div_flag){
                            echo '</div>';
                        }
                 ?>
            </div>


            <div class="right_side out_of_screen_side">
                <a href="#" class="right_side_button"><img src="<?php echo $this->webroot; ?>img/arrows/play_black_inv.png"/></a>
                <style>
                    #mapCanvas{
                        width: 100%;
                        height: 30em;
                        float: left;
                        margin-bottom: 1em;
                        margin-top: 0em;
                    }
                </style>
                <div id="mapCanvas"></div>
                <div class="info_wrapper">
                    <div><span class="info_header"></span>
                         <?php if((isset($current_species) && !empty($current_species))|| (isset($current_area) && !empty($current_area)))
                                echo 'Επιλέξτε μία πινέζα για να δείτε την αντίστοιχη αναφορά';
                              else
                                echo 'Κάνετε κλικ στο κάτω βέλος για να δείτε λεπτομέρειες για το είδος ή την περιοχή, ή στην επιλογή "αναφορές" για δείτε ολες τις εγκυρες αναφορές που αφορούν το είδος ή την περιοχή';
                        ?>
                    </div>
                </div>
            </div>
            <script type="text/javascript"
                src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC0azkJD2QB5m24LzhdEUenVmgCJPNaiDI&sensor=false">
            </script>
            <script>
                $(document).ready(function(){                   
                   initialize();
                   getMarkers();
                   addMarkers();
                });

                var map;
                var marker_buffer;
                var markers = new Array();
                var open_info_window;
                var open_info_window_ptr = false;
                var open_info_window_index;

                function initialize() {
                    var myOptions = {
                        center: new google.maps.LatLng(38.0397, 24.644),
                        zoom: 5,
                        mapTypeId: google.maps.MapTypeId.SATELLITE,
                        mapTypeControl: false,
                        navigationControlOptions: {
                            style: google.maps.NavigationControlStyle.ZOOM_PAN
                        },
                        scaleControl: false,
                        keyboardShortcuts: false,
                        streetViewControl: false
                    };
                    map = new google.maps.Map(document.getElementById("mapCanvas"),
                    myOptions);                    
                }

                function addMarkers(){
                    var i=0;
                    var temp;
                    for(i=0 ; i<marker_buffer.length ; i++){
                        temp = marker_buffer[i];
                        markers[i] = new google.maps.Marker({
                            position: new google.maps.LatLng(temp[0], temp[1]),
                            map: map,
                            clickable: true
                        });
                        google.maps.event.addListener(markers[i], 'mouseover', function(event){                                
                                showInfo(this.getPosition());
                            }
                        );
                        google.maps.event.addListener(markers[i], 'click', function(event){                                
                                showReport(this.getPosition());
                            }
                        );
                    }
                }

                function getMarkers(){
                    var text = $(".marker_db").text();
                    marker_buffer = new Array();
                    var word = null;
                    var i=0;
                    var j=0;
                    var k=0;
                    var small_buffer = new Array();
                    while(i < text.length){
                        if(text[i] != ',' && text[i] != ';'){
                            if(word == null){
                                word = text[i];
                            }
                            else{
                                word += text[i];
                            }
                        }
                        else if(text[i] == ',' || text[i] == ';'){
                            small_buffer[j] = word;
                            word = null;
                            if(text[i] == ';'){
                                j = 0;
                                marker_buffer[k] = small_buffer;
                                small_buffer = new Array();
                                k++;
                            }
                            else{
                                j++;
                            }
                        }
                        i++;
                    }
                }    
                
                function showInfo(location){                    
                    var i,index;                    
                    for(i=0 ; i<markers.length ; i++){
                        if(markers[i].getPosition().lat() == location.lat() && markers[i].getPosition().lng() == location.lng()){
                            if(open_info_window_ptr && open_info_window_index == i){
                                break;
                            }
                            index = i;
                            var contentString = 'Αναφέρθηκε από: ' + marker_buffer[index][10] + '<br/>'+
                                                 'Ημ/νια: ' + marker_buffer[index][3] + '<br/>' +
                                                 'Είδος: ' + marker_buffer[index][11] + '<br/>' +
                                                 'Περιοχή: ' + marker_buffer[index][6];
                            //window.alert(contentString);
                            var infowindow = new google.maps.InfoWindow({
                                content: contentString
                            });                                                       
                            infowindow.open(map,markers[index]);
                            if(open_info_window_ptr){
                                open_info_window.close();
                            }
                            open_info_window = infowindow;
                            open_info_window_ptr = true;
                            open_info_window_index = index;
                            google.maps.event.addListener(infowindow,'closeclick',function(){
                                open_info_window_ptr = false;
                            });
                            break;
                        }
                    }                    
                }
                
                var base_url = '<?php echo $this->webroot; ?>img/';
                
                function showReport(location){                    
                    var i,index;                    
                    for(i=0 ; i<markers.length ; i++){
                        if(markers[i].getPosition().lat() == location.lat() && markers[i].getPosition().lng() == location.lng()){                            
                            index = i;
                            //window.alert(marker_buffer[index][3]);
                            var contentString = '<div><img src="'+base_url+marker_buffer[index][2]+'" /></div>'
                                               +'<div><span class="info_header">'+'Υποβλήθηκε από τον: '+'</span> '+marker_buffer[index][10]+'</div>'
                                               +'<div><span class="info_header">'+'Γεωγραφικό Μήκος: '+'</span> '+marker_buffer[index][0]+'</div>'
                                               +'<div><span class="info_header">'+'Γεωγραφικό Πλάτος: '+'</span> '+marker_buffer[index][1]+'</div>'
                                               +'<div><span class="info_header">'+'Όνομα Είδους: '+'</span> '+marker_buffer[index][11]+'</div>'
                                               +'<div><span class="info_header">'+'Κατηγορία Είδους: '+'</span> '+marker_buffer[index][12]+'</div>'
                                               +'<div><span class="info_header">'+'Ημερομηνία Παρατήρησης: '+'</span> '+marker_buffer[index][3]+'</div>'
                                               +'<div><span class="info_header">'+'Βάθος: '+'</span> '+marker_buffer[index][4]+'</div>'
                                               +'<div><span class="info_header">'+'Πλήθος: '+'</span> '+marker_buffer[index][5]+'</div>'
                                               +'<div><span class="info_header">'+'Περιοχή Παρατήρησης: '+'</span> '+marker_buffer[index][6]+'</div>'
                                               +'<div><span class="info_header">'+'Περιβάλλον: '+'</span> '+marker_buffer[index][7]+'</div>'
                                               +'<div><span class="info_header">'+'Σχόλια: '+'</span> '+marker_buffer[index][8]+'</div>'
                                               +'<div><span class="info_header">'+'Έχει ξαναπαρατηρηθεί; '+'</span> '+marker_buffer[index][9]+'</div>';
                            //window.alert(contentString);
                            $('.info_wrapper').empty().append(contentString);
                        }
                    }                    
                }
            </script>
            <div class="marker_db" style="display:none">
            	<?php 
                if(isset($reports)){
                    foreach($reports as $report){
                                             
                            echo $report['Report']['lat'].','.$report['Report']['lng'].',';

                            if($report['Report']['permissionUseMedia']) 
                                echo$report['Report']['main_photo'];
                            else
                                echo"_";

                            echo ','.$report['Report']['date'].',';
                            
                            if(!empty($report['Report']['depth']))
                                echo
                                    $report['Report']['depth'];
                            else 
                                echo '-';
                            
                            echo ',';
                            if(!empty($report['Report']['crowd']))
                                 echo   $report['Report']['crowd'];
                            else
                                 echo '-';
                            echo ',';
                            
                            
                            if(!empty($report['Report']['area']))
                                echo $report['Report']['area'];
                            else
                                echo '-';                           
                            echo ',';
                            
                            if(!empty($report['Report']['habitat']))
                                echo $report['Report']['habitat'];
                            else
                                echo '-';
                            echo ',';
                                    
                            if(!empty($report['Report']['comments']))
                                echo $report['Report']['comments'];
                            else
                                echo '-';
                            echo ',';
                            
                            if(!empty($report['Report']['re_observation']))
                                echo   $report['Report']['re_observation'];
                            else
                                echo '-';
                            echo ',';
                                    
                            
                            if(isset($report['User']['username']))
                                echo $report['User']['username'];
                            else 
                                echo 'Ανώνυμος';
                            
                                echo    ','.$report['Specie']['scientific_name'].','.
                                    $report['Category']['category_name'].';';



                    }
             }?>
            </div>

        </div>

        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a>,<a href="http://modernizr.com/">Modernizr</a>.
                Arrows by <a href="http://www.designworkplan.com">DesignWorkPlan</a>.</div>
        </div>

    </div>
