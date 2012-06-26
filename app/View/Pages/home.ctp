 	<?php echo $this->Html->script(array('jquery-1.7.2.min'),array('inline' => false, 'rel' => 'javascript')); ?>
        <?php $this->set('title_for_layout', 'Αρχική σελίδα - ΕΛΚΕΘΕ');?>        
      	<div class="middle_row">
            <div class="index_tile">
                <span class="welcome_msg">Καλωσήρθατε στην ιστοσελίδα του Ελληνικού Κέντρου Θαλάσσιων Ερευνών</span>
                <br />
                                
                <br />
                <span class="about_text">
                    Η ιστοσελίδα που βρίσκεστε αυτή τη στιγμή είναι η επίσημη ιστοσελίδα του ΕΛΚΕΘΕ. Σκοπός μας είναι η μελέτη
                    των ελληνικών θαλασσών και η καταγραφή των ειδών της. Μέσα από αυτή τη σελίδα μας ενδιαφέρει κυρίως να καταγράψουμε
                    εμφανίσεις ξενικών ειδών που κανονικά δεν ανήκουν στα ελληνικά οικοσυστήματα και που η παρουσία τους μπορεί να
                    προκαλέσει προβλήματα.
                </span>
            </div>
            <div class="index_tile" style="background:#101010 url('<?php echo $this->webroot; ?>img/arrows/loading.gif') no-repeat center center;">
            	
                <a href="#" class="button display_on_hover" id="left_arrow"><img src ='<?php echo $this->webroot; ?>img/arrows/left_arrow_fat_white.png'/></a>
                <a href="#" class="button display_on_hover" id="right_arrow"><img src ='<?php echo $this->webroot; ?>img/arrows/right_arrow_fat_white.png'/></a>
                <a href="#" class="button display_on_hover" id="play"><img src ='<?php echo $this->webroot; ?>img/arrows/play_white.png'/></a>
                <a href="#" class="button display_on_hover" id="pause"><img src ='<?php echo $this->webroot; ?>img/arrows/pause_fat_white.png'/></a>
                <div class="tile_header">                    
                    <span>Είδη-στόχοι</span><br />
                    Πατήστε πάνω σε μία φωτογραφία για να μάθετε<br /> περισσότερες πληροφορίες για το είδος
                </div>
                <div class="specie_header"></div>
                <div id="fish_slideshow" class="fish_slideshow">
                    <?php 
				 foreach($hotspecies as $hot){
					echo '<a href="#"><img class="out_of_sight" data-specie_name="'.$hot['scientific_name'].'" src="'.$this->webroot.'img/hotspecies/'.$hot['id'].'.jpg" alt="images/1.jpg"/>				 							</a>';
                    
				}
				
				
				?>
                </div>
            </div>
            <div class="index_tile">
                <span class="report_header">Κάντε Μία Αναφορά</span><br />
                <span class="report_text">Συναντήσατε κάποιο παράξενο είδος που δεν μπορούσατε να αναγνωρίσετε. Κάντε μία αναφορά και οι ερευνητές μας θα αναλάβουν
                να το αναγνωρίσουν.
                </span>
                <?php echo $this->Html->link('Κάντε αναφορά', array('controller' => 'reports', 'action'=>'create'), array('class' => 'button_like_anchor'));?>
            </div>
            <div class="index_tile">
                <span class="news_header">Τα Νέα μας</span>
                <br />
                <span class="news_date">Προστέθηκε: 23-05-12</span>
                <br />
                <span class="news_text"><a href="#">Ένα καινούργιο είδος τσιπούρας ανακαλύφθηκε ανοιχτά της Σαντορίνης με τρία μάτια
                        και δύο στόματα. Εικάζεται ότι είναι αποτέλεσμα της μόλυνσης που προκαλεί το ναυάγιο του Sea Diamond που κάθεται
                        στο βυθό της Σαντορίνης εδώ και 20000 χρόνια. Οι ειδικοί μας που έσπευσαν στο σημείο μας επιβεβαίωσαν
                        ότι έχει άθλια γεύση αλλά μετά από 10 ούζο τα πάντα τρώγονται ευχάριστα...........</a>
                    <br /><a href="#">Διαβάστε Περισσότερα</a></span>
            </div>
            <div class="index_tile">
                <div class="tile_header">
                    <span>Χάρτης Αναφορών</span><br />
                    Εδώ μπορείτε να δείτε τις τελευταίες επιβεβαιωμένες αναφορές<br />εμφάνισης κάποιου ξενικού είδους
                </div>
                <style>
                    #mapCanvas{
                        height:100%;
                        width:100%;
                        border:0;
                        margin:0;
                        outline:0;
                        padding:0;
                    }
                </style>
                <div id="mapCanvas"></div>
            </div>
            <script type="text/javascript"
                src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC0azkJD2QB5m24LzhdEUenVmgCJPNaiDI&sensor=false">
            </script>
            <script type="text/javascript">
                var interval            = 4000;
                var playtime;                                                
                var nmb_thumbs          = $('#fish_slideshow img').length;
                var current             = nmb_thumbs;
                var prev                = nmb_thumbs - 1;

                $('#pause').bind('click',function(e){
                    $this = $(this);
                    $this.css({'display':'none'});
                    $('#play').css({'display':'block'});
                    pause();
                    return false;
                });      

                $('#play').bind('click',function(e){
                    $this = $(this);
                    $this.css({'display':'none'});
                    $('#pause').css({'display':'block'});
                    play();
                    return false;
                });

                $('#left_arrow').bind('click',function(e){
                    $('#pause').css({'display':'none'});
                    $('#play').css({'display':'block'});
                    pause();
                    previous(false);
                    return false;
                });

                $('#right_arrow').bind('click',function(e){
                    $('#pause').css({'display':'none'});
                    $('#play').css({'display':'block'});
                    pause();
                    next(false);
                    return false;
                });

                function resetTimer(){
                    if(playtime)
                        clearInterval(playtime);
                    playtime = setInterval(next,interval);
                }

                function play(){
                    resetTimer();
                }

                function pause(){
                    clearInterval(playtime);
                }

                function next(start){
                    prev = current;
                    current++;
                    if(current == nmb_thumbs + 1)
                        current = 1;                                    
                    showImage('l',start);
                }

                function previous(start){
                    prev = current;
                    current--;
                    if(current == 0)
                        current = nmb_thumbs;
                    showImage('r',start);
                }

                function showImage(dir,start){
                    var $next_thumb = $('#fish_slideshow').find('a:nth-child(' + current + ')').find('img');
                    var $cur_thumb = $('#fish_slideshow').find('a:nth-child(' + prev + ')').find('img');
                    if($next_thumb.length && $cur_thumb.length){
                        if(dir == 'r'){
                            if(!start){
                                $cur_thumb
                                    .animate({
                                        opacity:.0 ,
                                        left: '100%'
                                        }, 600, function(){
                                            $(this).attr('style','').toggleClass('out_of_sight');
                                            $next_thumb
                                                .toggleClass('out_of_sight')
                                                .css({
                                                    'opacity' : '0' ,
                                                    'left' : '-100%'
                                                    })
                                                .animate({
                                                        'left' : '0',
                                                        'opacity' : 1
                                                    }, 800
                                                );
                                        }
                                    );
                            }
                            else{
                                $next_thumb
                                            .toggleClass('out_of_sight')
                                            .css({
                                                'opacity' : '0' ,
                                                'left' : '-100%'
                                                })
                                            .animate({
                                                    'left' : '0',
                                                    'opacity' : 1
                                                }, 800
                                            );
                            }
                            var specie = $next_thumb.attr('data-specie_name');
                            $('.specie_header').text(specie);                                
                        }
                        else if(dir == 'l'){
                            if(!start){
                                $cur_thumb
                                    .animate({
                                        opacity:.0 ,
                                        left: '-100%'
                                        }, 600, function(){
                                            $(this).attr('style','').toggleClass('out_of_sight');
                                            $next_thumb
                                                .toggleClass('out_of_sight')
                                                .css({
                                                    'opacity' : '0' ,
                                                    'left' : '100%'
                                                    })
                                                .animate({
                                                        'left' : '0',
                                                        'opacity' : 1
                                                    }, 800
                                                );
                                        }
                                    );
                            }
                            else{
                                $next_thumb
                                            .toggleClass('out_of_sight')
                                            .css({
                                                'opacity' : '0' ,
                                                'left' : '100%'
                                                })
                                            .animate({
                                                    'left' : '0',
                                                    'opacity' : 1
                                                }, 800
                                            );
                            }
                            var specie = $next_thumb.attr('data-specie_name');
                            $('.specie_header').text(specie);
                        }
                    }
                    else{
                        window.alert('error with the slideshow');
                    }
                }

                $(document).ready(function(){
                   next(true);
                   play(); 
                   initialize();
                   getMarkers();
                   addMarkers();
                });

                var map;
                var marker_buffer;
                var markers = new Array();
                var base_url = '<?php echo $this->Html->link('Κάντε αναφορά', array('controller' => 'reports', 'action'=>'create'), array('class' => 'button_like_anchor'));?>';

                function initialize() {
                    var myOptions = {
                        center: new google.maps.LatLng(38.0397, 24.644),
                        zoom: 6,
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
                        google.maps.event.addListenerOnce(markers[i], 'mouseover', function(event){                                
                                showInfo(this.getPosition());
                            }
                        );
                        google.maps.event.addListenerOnce(markers[i], 'click', function(event){                                
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
                    var lat = true;
                    var lngt = false;
                    var name = false;
                    var date = false;
                    var specie = false;
                    var specie_id = false;
                    var region = false;
                    var region_id = false;
                    var small_buffer = new Array();
                    while(i < text.length){
                        if(lat){                            /*pairnoume to geografiko mikos mexri na vroume komma*/
                            if(text[i] == ','){
                                lat = false;
                                lngt = true;
                                small_buffer[0] = word;
                                word = null;
                            }
                            else if(text[i] != ' '){
                                if(word != null)
                                    word += text[i];
                                else
                                    word = text[i];
                            }
                        }
                        else if (lngt){                     /*pairnoume to geografiko platos mexri na vroume komma*/
                            if(text[i] == ','){                                
                                lngt = false;
                                name = true;
                                small_buffer[1] = word;
                                word = null;
                            }
                            else if(text[i] != ' '){
                                if(word != null)
                                    word += text[i];
                                else
                                    word = text[i];
                            }
                        }
                        else if (name){                     /*pairnoume to onoma tou xristi pou ekane tin anafora mexri na vroume komma*/
                            if(text[i] == ','){                                                             
                                name = false;
                                date = true;
                                small_buffer[2] = word;
                                word = null;
                            }
                            else if(text[i] != ' '){
                                if(word != null)
                                    word += text[i];
                                else
                                    word = text[i];
                            }
                        }
                        else if (date){                     /*pairnoume tin imerominia mexri na vroume komma*/
                            if(text[i] == ','){                                
                                date = false;
                                specie = true;
                                small_buffer[3] = word;
                                word = null;
                            }
                            else if(text[i] != ' '){
                                if(word != null)
                                    word += text[i];
                                else
                                    word = text[i];
                            }
                        }
                        else if (specie){                   /*pairnoume to eidos mexri na vroume komma*/
                            if(text[i] == ','){                                
                                specie = false;
                                specie_id = true;
                                small_buffer[4] = word;                                
                                word = null;
                            }
                            else if(text[i] != ' '){
                                if(word != null)
                                    word += text[i];
                                else
                                    word = text[i];
                            }
                        }
                        else if (specie_id){                     /*pairnoume tin taftotita tou eidous mexri na vroume komma*/
                            if(text[i] == ','){                                
                                specie_id = false;
                                region = true;
                                small_buffer[5] = word;
                                word = null;
                            }
                            else if(text[i] != ' '){
                                if(word != null)
                                    word += text[i];
                                else
                                    word = text[i];
                            }
                        }
                        else if (region){                     /*pairnoume tin perioxi mexri na vroume komma*/
                            if(text[i] == ','){                                
                                region = false;
                                region_id = true;
                                small_buffer[6] = word;
                                word = null;
                            }
                            else if(text[i] != ' '){
                                if(word != null)
                                    word += text[i];
                                else
                                    word = text[i];
                            }
                        }
                        else if (region_id){                   /*pairnoume tin taftotita tis perioxis mexri na vroume erotimatiko*/
                            if(text[i] == ';'){                                
                                region_id = false;
                                lat = true;
                                small_buffer[7] = word;
                                marker_buffer[j] = small_buffer;
                                small_buffer = new Array();
                                j++;
                                word = null;
                            }
                            else if(text[i] != ' '){
                                if(word != null)
                                    word += text[i];
                                else
                                    word = text[i];
                            }
                        }
                        i++;
                    }
                }
                
                function showInfo(location){                    
                    var i,index;                    
                    for(i=0 ; i<markers.length ; i++){
                        if(markers[i].getPosition().lat() == location.lat() && markers[i].getPosition().lng() == location.lng()){                            
                            index = i;
                            var contentString = 'Αναφέρθηκε από: ' + marker_buffer[index][2] + '<br/>'+
                                                 'Ημ/νια: ' + marker_buffer[index][3] + '<br/>' +
                                                 'Είδος: ' + marker_buffer[index][4] + '<br/>' +
                                                 'Περιοχή: ' + marker_buffer[index][6];
                            var infowindow = new google.maps.InfoWindow({
                                content: contentString
                            });                                                       
                            infowindow.open(map,markers[index]);
                            marker_buffer[index][8] = infowindow;
                            google.maps.event.addListenerOnce(markers[index], 'mouseout' , function(event){                                        
                                        hideInfo(this.getPosition());
                                    }
                                );                            
                            break;
                        }
                    }                    
                }
                function showReport(location){                    
                    var i,index;                    
                    for(i=0 ; i<markers.length ; i++){
                        if(markers[i].getPosition().lat() == location.lat() && markers[i].getPosition().lng() == location.lng()){                            
                            index = i;
                            var url = base_url + '/' + 'specie=' + marker_buffer[index][5] + '&region=' + marker_buffer[index][7];
                            window.location = url;
                        }
                    }                    
                }
                function hideInfo(location){
                    var i,index;                    
                    for(i=0 ; i<markers.length ; i++){
                        if(markers[i].getPosition().lat() == location.lat() && markers[i].getPosition().lng() == location.lng()){                            
                            index = i;
                            marker_buffer[index][8].close();
                            google.maps.event.addListenerOnce(markers[index], 'mouseover', function(event){                                
                                    showInfo(this.getPosition());
                                }
                            );
                            break;
                        }
                    }   
                }                
            </script>
            <div class="marker_db" style="display:none">            	
                
            
            	<?php if(isset($reports)){
                    
					 foreach($reports as $confirmed){
						echo $confirmed['Report']['lat'].','.$confirmed['Report']['lng'].',';
                                                if(isset($confirmed['User']['username'])){
                                                    echo $confirmed['User']['username'].',';
                                                }else
                                                    echo 'anonymous,';
                                                
                                                $date=array();
                                                $date= explode("-",$confirmed['Report']['date'],4);
                                                echo $date[2].' ';
                                                switch ($date[1]) {
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
                                                echo $date[0].','; 
                                                
                                                if(isset($confirmed['Specie']['scientific_name'])){ 
                                                    echo $confirmed['Specie']['scientific_name'];
                                                }
                                                echo ',';
                                                if(isset($confirmed['Report']['species_id'])){ 
                                                    echo $confirmed['Report']['species_id'];
                                                }
                                                echo ',';
                                                if(isset($confirmed['Report']['area'])){ //needs to be changed into name from species_id 
                                                    echo $confirmed['Report']['area'];
                                                }
                                                
                                                echo ',0;';
                                          }
                }
				?>
                
            </div>
        </div>
        
        
        
        
        
        
        
        <!--
        <div class="lower_row">
            <?php/* echo $this->Html->link('<h2>Είδη Υψηλής Προτεραιότητας</h2>  <p>Ενημερωθείτε για τα είδη που έχουν μεγαλύτερη προτεραιότητα αυτή την εποχή για τους αναλυτές μας</p>', 
                                                                                        array('controller' => 'hotSpecies', 'action'=>'show'),array('escape' => false));*/?>

            <?php/* echo $this->Html->link('<h2>Υποβάλλετε Αναφορά</h2>  <p>Υποβάλλετε μία αναφορά για ένα παράξενο είδος που συναντήσατε</p>', 
                                                                                        array('controller' => 'reports', 'action'=>'create'),array('escape' => false));*/?>

            <?php/* echo $this->Html->link('<h2>Εγγραφείτε</h2>
                <p>Γίνετε μέλος της κοινότητάς μας και βοηθήστε μας να προστατεύσουμε τις ελληνικές θάλασσες</p>', 
                                                                                        array('controller' => 'users', 'action'=>'register'),array('escape' => false));*/?>

        </div>-->
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a>,<a href="http://modernizr.com/">Modernizr</a>.
                Arrows by <a href="http://www.designworkplan.com">DesignWorkPlan</a>.</div>
        </div>
