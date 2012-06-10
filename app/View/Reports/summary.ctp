		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default'),null, array('inline'=>false));	?>
        <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','jquery.imgareaselect.pack.js'), array('inline'=>false));?>


  
  
		<!--[if lt IE 10 ]>
			<link rel="stylesheet" href="hacks.css" type="text/css" media="screen" />
		 <![endif]-->
		<div class="middle_row big_row no_padding">
        	<div class="middle_wrapper">   
                
                    <?php
                                echo '<div class="flash_box gradient">';
                                echo $this->Session->flash().'</br>';
                                echo '</div>';
                                echo $this->Form->create('Report', array('action' => 'summary',"enctype" => "multipart/form-data"));     
                                echo $this->Form->input('id',array("type"=>'hidden', 'class'=>'std_form'));
                                echo $this->Html->image($report['Report']['main_photo']);
																
                                echo '<br/>';
                                echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας; ",'disabled'=>'true', 'class'=>'std_form'));
                                echo '<br/>';
                 
                                echo $this->Form->input('date',array('label'=>'Ημερομηνία Παρατήρησης','div'=>false, 'class'=>'std_form'));
                                echo '<br/>';
                                echo $this->Form->input('lat',array('div'=>false,'id'=>'info',"label" => "Γεωγραφικός Πλάτος",'placeholder' => 'Συντεταγμένή lat ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow','disabled'=>'true', 'class'=>'std_form'));
                                echo '<br/>';
                                echo $this->Form->input('lng',array('div'=>false,'id'=>'info2',"label" => "Γεωγραφικό Μήκος",'placeholder' => 'Συντεταγμένη lng ή Βάλτε μια κουκίδα Google Maps','class'=>'std_form blue_shadow','disabled'=>'true', 'class'=>'std_form'));
                         
                                echo '<br/>';
                                $options = array();
                                $options['1']  = $this->Html->image('hotspecies/1.jpg');
                                $options['2']  = $this->Html->image('hotspecies/2.jpg');
                                $options['3']  = $this->Html->image('hotspecies/3.jpg');
                                echo $this->Form->input('hot_id', array('options' => $options,'type'=>'radio','legend'=> false,'before' => 'Είναι κάποιο απ\'τα συγκεκριμένα Hot Species;<br/><br/>','disabled'=>'true', 'class'=>'std_form'));
                                echo '<br/>';
                                echo $this->Form->input('habitat',array("label"=>"Βιοτοπος-Περιβάλλον Παρατήρησης ",'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','class'=>'std_form blue_shadow','disabled'=>'true', 'class'=>'std_form'));
                                echo '<br/>';
                                echo $this->Form->input('depth',array("label"=>"Βάθος ",'placeholder' => 'Γράψτε μέτρα(m) ή περιγράψτε','class'=>'std_form','disabled'=>'true', 'class'=>'std_form'));
                                echo '<br/>';
                                echo $this->Form->input('re_observation',array("label" => "Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή; ",'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','class'=>'std_form blue_shadow','disabled'=>'true', 'class'=>'std_form'));
                                echo '<br/>';
                                $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');  
                                echo $this->Form->input('crowd', array('options' => $options, 'default' => '  -  ','label'=>'Πλήθος Ατόμων Είδους ','disabled'=>'true', 'class'=>'std_form'));
                                echo '<br/>';
                                echo $this->Form->input('comments', array('type' => 'textarea',"label" => "Επιπλέον Σχόλια ",'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','class'=>'std_form blue_shadow','disabled'=>'true', 'class'=>'std_form'));
                            
                                    echo $this->Form->input('age',array('label'=>'Ημερομηνία Γέννησης ', 'class'=>'std_form'));
                                    echo '<br/>';
                                    $options = array('-'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','third' => 'Τριτοβάθμια - Ανώτατη');  
                                    echo $this->Form->input('education', array('options' => $options, 'default' => '    -    ','label'=>'Επίπεδο Εκπαίδευσης ','disabled'=>'true', 'class'=>'std_form'));
                                    echo '<br/>';
                                    $options = array('noValue'=>'-','fisher' => 'Ψαράς', 'diver' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');  
                                    echo $this->Form->input('occupation', array('options' => $options, 'default' => '   -   ','label'=>'Ιδιότητα ','disabled'=>'true', 'class'=>'std_form'));
                           
                                    echo $this->Form->input('name',array("label" => "Όνομα ",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','disabled'=>'true', 'class'=>'std_form'));
                                    echo '<br/>';
                                    echo $this->Form->input('surname',array("label" => "Επώνυμο ",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','class'=>'std_form blue_shadow','disabled'=>'true', 'class'=>'std_form'));
                                    echo '<br/>';
                                    echo $this->Form->input('phone_number',array("label" => "Τηλέφωνο Επικοινωνίας ",'placeholder' => 'Σταθερό ή Κινητό','class'=>'std_form blue_shadow','disabled'=>'true', 'class'=>'std_form'));
                                    echo '<br/>';
                                    echo $this->Form->input('email',array("label"=>"E-mail ",'placeholder'=>"Π.Χ. g.kolokotronis@elkethe.gr",'class' => 'std_form blue_shadow','disabled'=>'true', 'class'=>'std_form'));
                          
                                
                                echo '<br/>';
                                echo $this->Form->end(array(
                                                            'label' => 'Οριστική υποβολή',
                                                            'div' => false,
                                                            'class' => 'std_form'));
                           ?>
                       
    		
            </div>

	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	