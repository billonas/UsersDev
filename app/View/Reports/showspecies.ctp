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
                $(".specie_areas").each(function(){
                    var $this = $(this);
                    if(!$this.parent().parent().hasClass('current_specie_looked')){
                        var h_em = getEm($this,$this.height());
                        $this.attr('data-height',$this.height());
                        $this.parent().attr('data-margin',h_em);
                        $this.css('height','0px');
                    }
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
            
            <div class="left_side">
                
                <div class="specie_div specie_button_wrapper">
                    <a class="specie_button selected_specie_button" href="#">Είδη</a>
                    <a class="specie_button" href="#">Περιοχές</a>
                </div>
                
                <div class="specie_div current_specie_looked">
                    <span class="little_specie_header">Τσιπούρα</span>
                    <div class="img_frame">
                        <img class="squarizer" src='<?php echo $this->webroot.'img/square.png' ?>'/>
                        <img class="specie_img" src='<?php echo $this->webroot.'img/humpback_whale-wallpaper-1920x1200.jpg' ?>'/>
                    </div>
                    <div class="region_button_wrapper">
                        <span class="specie_areas"><span>Περιοχές:</span> Κυκλάδες, Κρήτη, Δωδεκάννησα, Ικάριο Πέλαγος, Ιόνιο Πέλαγος και κάποιο άλλο μέρος και κάποιο άλλο και κάποιο άλλο και κάποιο άλλο και κάποιο άλλο και κάποιο άλλο και κάποιο άλλο και κάποιο άλλο και κάποιο άλλο και κάποιο άλλο και κάποιο άλλο</span>
                        <a href="#" class="more_areas"><img src='<?php echo $this->webroot.'img/double_arrow6.png' ?>'/></a>
                        <a href="#" class="more_info">Περισσότερα...</a>
                    </div>
                </div>
                
                <div class="specie_div" style="display:none"></div>

                <div class="specie_div">
                    <span class="little_specie_header">Τσιπούρα</span>
                    <div class="img_frame">
                        <img class="squarizer" src='<?php echo $this->webroot.'img/square.png' ?>'/>
                        <img class="specie_img" src='<?php echo $this->webroot.'img/humpback_whale-wallpaper-1920x1200.jpg' ?>'/>
                    </div>
                    <div class="region_button_wrapper">
                        <span class="specie_areas"><span>Περιοχές:</span> Κυκλάδες, Κρήτη, Δωδεκάννησα, Ικάριο Πέλαγος, Ιόνιο Πέλαγος</span>
                        <a href="#" class="more_areas"><img src='<?php echo $this->webroot.'img/double_arrow6.png' ?>'/></a>
                        <a href="#" class="more_info">Περισσότερα...</a>
                    </div>
                </div>
                
                <div class="specie_div">
                    <span class="little_specie_header">Τσιπούρα</span>
                    <div class="img_frame">
                        <img class="squarizer" src='<?php echo $this->webroot.'img/square.png' ?>'/>
                        <img class="specie_img" src='<?php echo $this->webroot.'img/humpback_whale-wallpaper-1920x1200.jpg' ?>'/>
                    </div>
                    <div class="region_button_wrapper">
                        <span class="specie_areas"><span>Περιοχές:</span> Κυκλάδες, Κρήτη, Δωδεκάννησα, Ικάριο Πέλαγος, Ιόνιο Πέλαγος</span>
                        <a href="#" class="more_areas"><img src='<?php echo $this->webroot.'img/double_arrow6.png' ?>'/></a>
                        <a href="#" class="more_info">Περισσότερα...</a>
                    </div>
                </div>
                
                <div class="specie_div">
                    <span class="little_specie_header">Τσιπούρα</span>
                    <div class="img_frame">
                        <img class="squarizer" src='<?php echo $this->webroot.'img/square.png' ?>'/>
                        <img class="specie_img" src='<?php echo $this->webroot.'img/humpback_whale-wallpaper-1920x1200.jpg' ?>'/>
                    </div>
                    <div class="region_button_wrapper">
                        <span class="specie_areas"><span>Περιοχές:</span> Κυκλάδες, Κρήτη, Δωδεκάννησα, Ικάριο Πέλαγος, Ιόνιο Πέλαγος</span>
                        <a href="#" class="more_areas"><img src='<?php echo $this->webroot.'img/double_arrow6.png' ?>'/></a>
                        <a href="#" class="more_info">Περισσότερα...</a>
                    </div>
                </div>
                
                <div class="specie_div">
                    <span class="little_specie_header">Τσιπούρα</span>
                    <div class="img_frame">
                        <img class="squarizer" src='<?php echo $this->webroot.'img/square.png' ?>'/>
                        <img class="specie_img" src='<?php echo $this->webroot.'img/humpback_whale-wallpaper-1920x1200.jpg' ?>'/>
                    </div>
                    <div class="region_button_wrapper">
                        <span class="specie_areas"><span>Περιοχές:</span> Κυκλάδες, Κρήτη, Δωδεκάννησα, Ικάριο Πέλαγος, Ιόνιο Πέλαγος</span>
                        <a href="#" class="more_areas"><img src='<?php echo $this->webroot.'img/double_arrow6.png' ?>'/></a>
                        <a href="#" class="more_info">Περισσότερα...</a>
                    </div>
                </div>
                
                <div class="specie_div">
                    <span class="little_specie_header">Τσιπούρα</span>
                    <div class="img_frame">
                        <img class="squarizer" src='<?php echo $this->webroot.'img/square.png' ?>'/>
                        <img class="specie_img" src='<?php echo $this->webroot.'img/humpback_whale-wallpaper-1920x1200.jpg' ?>'/>
                    </div>
                    <div class="region_button_wrapper">
                        <span class="specie_areas"><span>Περιοχές:</span> Κυκλάδες, Κρήτη, Δωδεκάννησα, Ικάριο Πέλαγος, Ιόνιο Πέλαγος</span>
                        <a href="#" class="more_areas"><img src='<?php echo $this->webroot.'img/double_arrow6.png' ?>'/></a>
                        <a href="#" class="more_info">Περισσότερα...</a>
                    </div>
                </div>
                
                <div class="specie_div">
                    <span class="little_specie_header">Τσιπούρα</span>
                    <div class="img_frame">
                        <img class="squarizer" src='<?php echo $this->webroot.'img/square.png' ?>'/>
                        <img class="specie_img" src='<?php echo $this->webroot.'img/humpback_whale-wallpaper-1920x1200.jpg' ?>'/>
                    </div>
                    <div class="region_button_wrapper">
                        <span class="specie_areas"><span>Περιοχές:</span> Κυκλάδες, Κρήτη, Δωδεκάννησα, Ικάριο Πέλαγος, Ιόνιο Πέλαγος</span>
                        <a href="#" class="more_areas"><img src='<?php echo $this->webroot.'img/double_arrow6.png' ?>'/></a>
                        <a href="#" class="more_info">Περισσότερα...</a>
                    </div>
                </div>

            </div>
            
            <div class="left_side hidden_side">
                
                <div class="specie_div specie_button_wrapper">
                    <a class="specie_button" href="#">Είδη</a>
                    <a class="specie_button selected_specie_button" href="#">Περιοχές</a>
                </div>
                
                <div class="specie_div">
                    <span class="little_specie_header">Τσιπούρα</span>
                    <div class="img_frame">
                        <img class="squarizer" src='<?php echo $this->webroot.'img/square.png' ?>'/>
                        <img class="specie_img" src='<?php echo $this->webroot.'img/perioxes/kyklades.PNG' ?>'/>
                    </div>
                    <div class="region_button_wrapper">
                        <a href="#" class="more_info region_center_button">Περισσότερα...</a>
                    </div>
                </div>
                
                <div class="specie_div">
                    <span class="little_specie_header">Τσιπούρα</span>
                    <div class="img_frame">
                        <img class="squarizer" src='<?php echo $this->webroot.'img/square.png' ?>'/>
                        <img class="specie_img" src='<?php echo $this->webroot.'img/perioxes/kriti.PNG' ?>'/>
                    </div>
                    <div class="region_button_wrapper">
                        <a href="#" class="more_info region_center_button">Περισσότερα...</a>
                    </div>
                </div>
                
            </div>


            <div class="right_side">
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
                    <div><span class="info_header"></span>Παρακαλούμε επιλέξτε μία πινέζα για να δείτε την αντίστοιχη αναφορά</div>
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
            </script>
            <div class="marker_db" style="display:none">
            	<?php 
					 foreach($reports as $coords){
						//echo $coords['lat'].', '.$coords['lng'];
					 }
				?>
                38.0397, 24.644;
                38.1397, 24.744;
                38.0397, 24.744;
            </div>

        </div>

        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a>,<a href="http://modernizr.com/">Modernizr</a>.
                Arrows by <a href="http://www.designworkplan.com">DesignWorkPlan</a>.</div>
        </div>

    </div>