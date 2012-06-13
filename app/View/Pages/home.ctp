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
                <div class="specie_header">Δελφίνι Δελφίνους</div>
                <div id="fish_slideshow" class="fish_slideshow">
                    <a href="#">
                        <img src='<?php echo $this->webroot; ?>img/Dolphins-HQ-Photos-Wallpapers.jpg' alt="images/1.jpg"/>
                    </a>
                    <a href="#">
                        <img class="out_of_sight" data-specie_name="Δελφίνι Δελφίνους" src='<?php echo $this->webroot; ?>img/1_Dolphin_Wallpaper_04.jpg' alt="images/2.jpg"/>
                    </a>
                    <a href="#">
                        <img class="out_of_sight" data-specie_name="Δελφίνι Δελφίνους" src='<?php echo $this->webroot; ?>img/2-Dolphins-Loving-Wallpapers.jpg' alt="images/3.jpg"/>
                    </a>
                    <a href="#">
                        <img class="out_of_sight" data-specie_name="Δελφίνι Δελφίνους" src='<?php echo $this->webroot; ?>img/3D-Dolphin-Wallpapers.jpg' alt="images/4.jpg"/>
                    </a>
                    <a href="#">
                        <img class="out_of_sight" data-specie_name="Φάλαινα Φάλαινους" src='<?php echo $this->webroot; ?>img/humpback_whale-wallpaper-1920x1200.jpg' alt="images/5.jpg"/>
                    </a>
                    <a href="#">
                        <img class="out_of_sight" data-specie_name="Φάλαινα Φάλαινους" src='<?php echo $this->webroot; ?>img/whale-shark-belize.jpg' alt="images/6.jpg"/>
                    </a>
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
                var current             = 1;                                
                var nmb_thumbs          = $('#fish_slideshow img').length;
                var prev                = nmb_thumbs;

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
                    previous();
                    return false;
                });

                $('#right_arrow').bind('click',function(e){
                    $('#pause').css({'display':'none'});
                    $('#play').css({'display':'block'});
                    pause();
                    next();
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

                function next(){
                    prev = current;
                    current++;
                    if(current == nmb_thumbs)
                        current = 1;                                    
                    showImage('l');
                }

                function previous(){
                    var temp = current;
                    current = prev;
                    prev = temp;
                    showImage('r');
                }

                function showImage(dir){
                    var $next_thumb = $('#fish_slideshow').find('a:nth-child(' + current + ')').find('img');
                    var $cur_thumb = $('#fish_slideshow').find('a:nth-child(' + prev + ')').find('img');
                    if($next_thumb.length && $cur_thumb.length){
                        if(dir == 'r'){
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
                                var specie = $cur_thumb.attr('data-specie_name');
                                //specie = "Είδος: " + specie;
                                $('.specie_header').text(specie);
                                prev = current - 1;
                                if(prev == 0)
                                    prev = nmb_thumbs;
                        }
                        else if(dir == 'l'){
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
                                var specie = $cur_thumb.attr('data-specie_name');
                                $('.specie_header').text(specie);
                        }
                    }
                    else{
                        window.alert('error with the slideshow');
                    }
                }

                $(document).ready(function(){
                   play(); 
                   initialize();
                   getMarkers();
                   addMarkers();
                });

                var map;
                var marker_buffer;
                var markers = new Array();

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
                        google.maps.event.addListenerOnce(markers[i], 'mouseover', bounceAndInfo);
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
                    var small_buffer = new Array();
                    while(i < text.length){
                        if(lat){
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
                        else if (lngt){
                            if(text[i] == ';'){
                                lat = true;
                                lngt = false;
                                small_buffer[1] = word;
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
                
                function bounceAndInfo(){                    
                    var i,index;
                    for(i=0 ; i<markers.length ; i++){
                        if(markers[i].getPosition() == this.getPosition()){                            
                            index = i;
                            //markers[index].setAnimation(google.maps.Animation.BOUNCE);
                            //var pinColor = 'FFFF00';
                            /*var pinIcon = new google.maps.MarkerImage(
                                "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
                                new google.maps.Size(21, 34),
                                new google.maps.Point(0,0),
                                new google.maps.Point(10, 34),
                                new google.maps.Size(42, 68));
                            //window.alert('got icon');
                            marker[index].setIcon(pinIcon);
                            //clearInstanceListeners(markers[index]);
                            //google.maps.event.addListenerOnce(markers[index], 'mouseout', stopBounceAndInfo);
                            */
                            break;
                        }
                    }                    
                }
                function stopBounceAndInfo(){
                    var i,index;
                    for(i=0 ; i<markers.length ; i++){
                        if(markers[i].getPosition() == this.getPosition()){                            
                            index = i;
                            //markers[index].setAnimation(null);
                            //clearInstanceListeners(markers[index]);                            
                            break;
                        }
                    }   
                }                
            </script>
            <div class="marker_db" style="display:none">
                38.0397, 24.644;
                38.1397, 24.744;
                38.0397, 24.744;
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
	