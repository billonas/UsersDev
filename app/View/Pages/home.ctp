 	<?php echo $this->Html->script(array('jquery-1.7.2.min'),array('inline' => false, 'rel' => 'javascript')); ?>
        <?php $this->set('title_for_layout', 'Αρχική σελίδα - ΕΛΚΕΘΕ');?>        
      	<div class="middle_row">
            <div class="index_tile">
                <span class="welcome_msg">Καλωσήρθατε!</span>
                <br />
                                
                <br />
                <span class="about_text">
                        Η σελίδα αυτή αποτελεί παράρτημα του ΕΛ.ΚΕ.Θ.Ε. και έχει ως σκοπό την καταγραφή εμφανίσεων ξενικών ειδών που δεν ανήκουν στα ελληνικά οικοσυστήματα και η παρουσία των οποίων μπορεί να
                    προκαλέσει προβλήματα. Με πολύ απλό τρόπο μπορείς να μπεις στον ιστότοπό μας, να ανεβάσεις την φωτογραφία που έβγαλες 
                    και να μας αναφέρεις οποιαδήποτε άλλα χαρακτηριστικά που θυμάσαι από τη συνάντησή σου με τον οργανισμό που σου προκάλεσε 
                    το ενδιαφέρον. 
                   <p> Μην μένεις απλά θεατής στον υπέροχο κόσμο της θάλασσας, γίνε και εσύ ερευνητής με τον τρόπο σου, συμβάλλοντας στην προσπάθεια 
                    μελέτης και προστασίας της!</p>

                </span>
                <?php echo $this->Html->link('Περισσότερα για τους στόχους μας', array('controller' => 'pages', 'action'=>'about'), array('class' => 'button_like_anchor'));?>

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
                            echo '<a href="/hotSpecies/view"><img class="out_of_sight" data-specie_name="'.$hot['scientific_name'].
                                    '" src="'.$this->webroot.'img/hotspecies/'.$hot['id'].'.jpg" alt="hot_species_img"/></a>';
                        }
                    ?>
                </div>
            </div>
            <div class="index_tile">
                <span class="report_header">Κάντε Μία Αναφορά</span><br />
                <span class="report_text">Συναντήσατε κάποιο παράξενο είδος που δεν μπορούσατε να αναγνωρίσετε; Συμπληρώστε μία αναφορά και οι ερευνητές μας θα αναλάβουν
                να το αναγνωρίσουν.
                </span>
                <?php echo $this->Html->link('Κάντε αναφορά', array('controller' => 'reports', 'action'=>'create'), array('class' => 'button_like_anchor'));?>
            </div>
            <div class="index_tile">
                
                <span class="news_header">Τα Νέα μας</span>
                <br />
                <?php if($lastnew){
                echo '<span class="news_date">Προστέθηκε: '.$lastnew['News']['created'].'</span>
                <br />
                <span class="news_text"><span class="news_title">'.$lastnew['News']['title'].'</span>
                    '.$lastnew['News']['body'].'
                    <br />';
                    echo $this->Html->link('Διαβάστε Περισσότερα', array('controller'=>'News', 'action'=>'view'));
                echo '</span>';
                }
                else 
                    echo '<span class="news_date">Δεν υπάρχουν Νέα</span>';
                    ?>
            </div>
            <div class="index_tile">
                <div class="tile_header">
                    <span>Χάρτης Αναφορών</span><br />
                    Δείτε τις τελευταίες επιβεβαιωμένες αναφορές<br />εμφάνισης κάποιου ξενικού είδους
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
                var base_url = '<?php echo $this->Html->url(array("controller" => "reports","action" => "showspecies")); ?>';
                var open_info_window;
                var open_info_window_ptr = false;
                var open_info_window_index;

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
                        google.maps.event.addListener(markers[i], 'mouseover', function(event){                                
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
                            var contentString = 'Αναφέρθηκε από: ' + marker_buffer[index][2] + '<br/>'+
                                                 'Ημ/νια: ' + marker_buffer[index][3] + '<br/>' +
                                                 'Είδος: ' + marker_buffer[index][4] + '<br/>' +
                                                 'Περιοχή: ' + marker_buffer[index][6];
                            var infowindow = new google.maps.InfoWindow({
                                content: contentString
                            });                                                       
                            infowindow.open(map,markers[index]);
                            marker_buffer[index][8] = infowindow;
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
                function showReport(location){                    
                    var i,index;                    
                    for(i=0 ; i<markers.length ; i++){
                        if(markers[i].getPosition().lat() == location.lat() && markers[i].getPosition().lng() == location.lng()){                            
                            index = i;
                            var url = base_url + '?' + 'select=species&text=' + marker_buffer[index][4];// + '&region=' + marker_buffer[index][7];
                            window.location = url;
                            //window.alert(url);
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
                                                    echo 'Ανώνυμος,';
                                                
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
        
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a>,<a href="http://modernizr.com/">Modernizr</a>.
                Arrows by <a href="http://www.designworkplan.com">DesignWorkPlan</a>.</div>
        </div>
