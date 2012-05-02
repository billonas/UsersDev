
		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default'),null, array('inline'=>false));	?>
        <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','jquery.imgareaselect.pack.js'), array('inline'=>false));?>

<script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
		<!--[if lt IE 10 ]>
			<link rel="stylesheet" href="hacks.css" type="text/css" media="screen" />
		 <![endif]-->
	
                <style>
                    #mapCanvas {
                        width: 500px;
                        height: 400px;
                        float: left;
                        clear: both;
                    }
                </style>
		<div class="middle_row big_row no_padding">
        	<div class="middle_wrapper">   
                <div id="tabs">
                    <ul>                
                        <?php
                                  echo '<li class="long-text"><a href="#fragment-1">1. Φωτογραφία<br/>Παρατήρησης</a></li>
                                        <li class="long-text"><a href="#fragment-2" onClick="appendBootstrap()"><span>2. Βασικές<br/>Πληροφορίες</span></a></li>
                                        <li class="long-text"><a href="#fragment-3"><span>3. Επιπλέον<br/>Πληροφορίες</span></a></li>
                                        <li class="long-text"><a href="#fragment-4"><span>4. Στοιχεία<br/>Παρατηρητή</span></a></li>  
                                        <li class="long-text"><a href="#fragment-5"><span>5. Στοιχεία<br/>Επικοινωνίας</span></a></li> 
                                        <li class="long-text"><a href="#fragment-6"><span>5. Στοιχεία<br/>Ανάλυσης</span></a></li>
                                        ';

                        ?>
                
                    </ul>
                        <div id="fragment-1">
                            <?php 
                                echo '<div class="flash_box gradient">';
                                echo $this->Session->flash().'</br>';
                                echo '</div>';
                                echo $this->Form->create('Report', array('action' => 'edit',"enctype" => "multipart/form-data"));     
                                echo $this->Html->image($report['Report']['main_photo']);
                                echo '<br/>';
                                echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας; ",'disabled'=>'true'));
                                echo '<br/>';
                                
                            ?>
                        </div>
                        <div id="fragment-2"> 
                            
                           <?php  
                                echo $this->Form->input('date',array('label'=>'Ημερομηνία Παρατήρησης','div'=>false));
                                echo '<br/>';
                                echo $this->Form->input('lat',array('div'=>false,'id'=>'info',"label" => "Γεωγραφικός Πλάτος",'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow','disabled'=>'true'));
                                echo '<br/>';
                                echo $this->Form->input('lng',array('div'=>false,'id'=>'info2',"label" => "Γεωγραφικό Μήκος",'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow','disabled'=>'true'));
                           ?>
                        </div>
                        <div id="fragment-3">
                            <?php
                                echo '<br/>';
                                $options = array();
                                $options['1']  = $this->Html->image('hotspecies/1.jpg');
                                $options['2']  = $this->Html->image('hotspecies/2.jpg');
                                $options['3']  = $this->Html->image('hotspecies/3.jpg');
                                echo $this->Form->input('hot_id', array('options' => $options,'type'=>'radio','legend'=> false,'before' => 'Είναι κάποιο απ\'τα συγκεκριμένα Hot Species;<br/><br/>','disabled'=>'true'));
                                echo '<br/>';
                                echo $this->Form->input('habitat',array("label"=>"Βιοτοπος-Περιβάλλον Παρατήρησης ",'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','class'=>'std_form blue_shadow','disabled'=>'true'));
                                echo '<br/>';
                                echo $this->Form->input('depth',array("label"=>"Βάθος ",'placeholder' => 'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form','disabled'=>'true'));
                                echo '<br/>';
                                echo $this->Form->input('re_observation',array("label" => "Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; ",'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow','disabled'=>'true'));
                                echo '<br/>';
                                $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');  
                                echo $this->Form->input('crowd', array('options' => $options, 'default' => '  -  ','label'=>'Πλήθος Ατόμων Είδους ','disabled'=>'true'));
                                echo '<br/>';
                                echo $this->Form->input('comments', array('type' => 'textarea',"label" => "Επιπλέον Σχόλια ",'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow','disabled'=>'true'));
                            ?>
                        </div>  
                        <div id="fragment-4">
                            <?php  
                                    echo $this->Form->input('age',array('label'=>'Ημερομηνία Γέννησης '));
                                    echo '<br/>';
                                    $options = array('-'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');  
                                    echo $this->Form->input('education', array('options' => $options, 'default' => '    -    ','label'=>'Επίπεδο Εκπαίδευσης ','disabled'=>'true'));
                                    echo '<br/>';
                                    $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');  
                                    echo $this->Form->input('occupation', array('options' => $options, 'default' => '   -   ','label'=>'Ιδιότητα ','disabled'=>'true'));
                            ?>
                        </div>
                        <div id="fragment-5">
                            <?php 
                                    echo $this->Form->input('name',array("label" => "Όνομα ",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','disabled'=>'true'));
                                    echo '<br/>';
                                    echo $this->Form->input('surname',array("label" => "Επώνυμο ",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','disabled'=>'true'));
                                    echo '<br/>';
                                    echo $this->Form->input('phone_number',array("label" => "Τηλέφωνο Επικοινωνίας ",'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','disabled'=>'true'));
                                    echo '<br/>';
                                    echo $this->Form->input('email',array("label"=>"E-mail ",'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow','disabled'=>'true'));
                            ?>
                        </div>
                        <div id="fragment-6">
                            <?php  
                                echo '<br/>';
                                $options = array();
//                                // Add categories dynamically
//                                foreach ($categories as $category)
//                                {
//                                    $options[$category['Category']['id']]= $category['Category']['category_name'];
//                                }
                                // Add categories manually
                                $options = array(
                                    '4' => 'Ασκίδια',
                                    '3' => 'Εχινόδερμα',
                                    '1' => 'Μαλάκια',
                                    '5' => 'Φύκια',
                                    '2' => 'Ψάρια',
                                );
                                echo $this->Form->input('category_id', array('options' => $options,'label'=>'Κατηγορία Είδους'));
                                echo '<br/>';
                                
                                echo $this->Form->input('scientific_name',array("label" => "Επιστημονική Ονομασία",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά'));
                                echo '<br/>';
                                echo $this->Form->input('analyst_comments',array("label" => "Σχόλια-Παρατηρήσεις",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά'));
                                echo '<br/>';
                                $options = array('unknown' => 'Άγνωστη','confirmed' => 'Έγκυρη', 'unreliable' => 'Αναξιόπιστη');  
                                echo $this->Form->input('state', array('options' => $options,'label'=>'Κατάσταση Αναφοράς'));
                                echo '<br/>';
                                echo $this->Form->end(array(
                                                            'label' => 'Επεξεργασία Αναφοράς',
                                                            'div' => false,
                                                            'class' => 'std_form'));
                           ?>
                        </div>
    			</div>
            </div>

	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	