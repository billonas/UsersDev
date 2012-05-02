<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="en-gb" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>Επεξεργασία Αναφοράς</title>
		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default','forms'));	?>
                
                <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','jquery.imgareaselect.pack.js'));?>

<script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
</script>


		<!--[if lt IE 10 ]>
			<link rel="stylesheet" href="hacks.css" type="text/css" media="screen" />
		 <![endif]-->
	</head>
	<body>
                <?php echo $this->Session->flash();?>    
		<div class="middle_row">
        	<div class="middle_wrapper">
                
                <div id="tabs">
                    <ul>
                        <li><a href="#fragment-1">1. Φωτογραφία<br/> παρατήρησης</a></li>
                        <li><a href="#fragment-2"><span>2. Βασικές Πληροφορίες <br/>Παρατήρησης</span></a></li>
                        <li><a href="#fragment-3"><span>3. Επιπλέον Πληροφορίες <br/>Παρατήρησης</span></a></li>
                        <li><a href="#fragment-4"><span>4. Στοιχεία <br/>Παρατηρητή</span></a></li>  
                        <li><a href="#fragment-5"><span>5. Στοιχεία <br/>Επικοινωνίας</span></a></li>
                        <li><a href="#fragment-6"><span>5. Ανάλυση- <br/>Αξιολόγηση</span></a></li>
                
                    </ul>
                        <div id="fragment-1">
                            <?php 
                                echo '<br/>';
                                echo $this->Form->create('Report', array('action' => 'edit',"enctype" => "multipart/form-data"));     
                                echo $this->Form->hidden('id');
                                echo $this->Html->image($report['Report']['main_photo']); 
                                echo '<br/>';
                                echo $this->Form->input('permissionUseMedia',array("label"=>"Mπορούν να χρησιμοποιηθούν οι φωτογραφίες σας;",'type'=>'checkbox','disabled' =>'true'));
                                echo '<br/>';
                            ?>
                        </div>
                        <div id="fragment-2">
                           
                            <br/>
                           <?php  
                                echo $this->Form->input('date',array('label'=>'Ημερομηνία Παρατήρησης','placeholder'=>'(mm/dd/yy)','disabled'=>'true'));
                                echo '<br/>';
                                echo $this->Form->input('observation_site',array("label" => "Συντεταγμένες Τοποθεσίας",'placeholder' => 'Συντεταγμένες ή Βάλτε μια κουκίδα Google Maps','disabled' =>'true'));
                                echo '<br/>';
                                echo '<br/>';
                                //echo $this->Form->end('Κατάθεση αναφοράς'); 
                           ?>
                        </div>
                        <div id="fragment-3">
                            <?php
                                //echo $this->Html->image($report['Report']['additional_photo1']);
                                //echo $this->Html->image($report['Report']['additional_photo2']);
                                $options = array();
                                $options['1']  = $this->Html->image('hotspecies/1.jpg');
                                $options['2']  = $this->Html->image('hotspecies/2.gif');
                                $options['3']  = $this->Html->image('hotspecies/3.jpg');
                                echo $this->Form->input('hot_id', array('options' => $options,'type'=>'radio','legend'=> false,'before' => 'Είναι κάποιο απ\'τα συγκεκριμένα Hot Species;<br/><br/>'));
                                echo '<br/>';
                                echo $this->Form->input('habitat',array("label"=>"Βιοτοπος-Περιβάλλον Παρατήρησης",'placeholder' => 'Περιγράψτε. Π.Χ. «Βράχια καλυμμένα με βλάστηση»','disabled' =>'true'));
                                echo '<br/>';
                                echo $this->Form->input('depth',array("label"=>"Βάθος",'placeholder' => 'Γράψτε μέτρα(m) ή περιγράψτε','disabled' =>'true'));
                                echo '<br/>';
                                echo $this->Form->input('re_observation',array("label" => "Έχετε ξαναδεί το συγκεκριμένο είδος στην περιοχή;",'placeholder' =>'Αν ναι, περιγράψτε την εμπειρία...','disabled' =>'true'));
                                echo '<br/>';
                                $options = array('-'=>'-','few' => '1-5', 'some' => '6-10','many' => '10-30');  
                                echo $this->Form->input('crowd', array('options' => $options, 'default' => '  -  ','label'=>'Πλήθος Ατόμων Είδους','disabled' =>'true'));
                                echo '<br/>';
                                echo $this->Form->input('comments', array('type' => 'textarea',"label" => "Επιπλέον Σχόλια",'placeholder' =>'Περιγράψτε ότι σας έκανε εντύπωση','disabled' =>'true'));
                                echo '<br/>';
                                echo '<br/>';
                                //echo $this->Form->end('Κατάθεση αναφοράς'); 
                                ?>
                        </div>  
                        <div id="fragment-4">
                            <?php  
                                echo '<br/>';
                                echo $this->Form->input('age',array('type'=>'text','id'=>'age','label'=>'Ημερομηνία Γέννησης','placeholder'=>'(mm/dd/yy)','disabled'=>'true'));
                                echo '<br/>';
                                $options = array('-'=>'-','first' => 'Πρωτοβάθμια', 'second' => 'Δευτεροβάθμια','uptothird' => 'Τριτοβάθμια - Ανώτατη');  
                                echo $this->Form->input('education', array('options' => $options, 'default' => '    -    ','label'=>'Επίπεδο Εκπαίδευσης','disabled' =>'true'));
                                echo '<br/>';
                                $options = array('-'=>'-','fisherman' => 'Ψαράς', 'ditis' => 'Δύτης','tourist' => 'Τουρίστας','other' => 'Άλλο');  
                                echo $this->Form->input('occupation', array('options' => $options, 'default' => '   -   ','label'=>'Ιδιότητα','disabled' =>'true'));
                                echo '<br/>';
                                echo '<br/>';
                                //echo $this->Form->end('Κατάθεση αναφοράς'); 
                           ?>
                        </div>
                        <div id="fragment-5">
                            <?php  
                                echo '<br/>';
                                echo $this->Form->input('name',array("label" => "Όνομα",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','disabled' =>'true'));
                                echo '<br/>';
                                echo $this->Form->input('surname',array("label" => "Επώνυμο",'placeholder' => 'Κεφαλαία Γράμματα Ελληνικά ή Λατινικά','disabled' =>'true'));
                                echo '<br/>';
                                echo $this->Form->input('phone_number',array("label" => "Τηλέφωνο Επικοινωνίας",'placeholder' => 'Σταθερό ή Κινητό','disabled' =>'true'));
                                echo '<br/>';
                                echo $this->Form->input('email',array("label"=>"E-mail",'placeholder'=>"Παρακαλούμε γράψτε το σε κανονική μορφή. Π.Χ. g.kolokotronis@elkethe.gr",'disabled' =>'true'));

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
                                echo '<br/>';
                                echo $this->Form->end('Επεξεργασία αναφοράς'); 
                           ?>
                        </div>
    			</div>
            </div>

	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	</body>
</html>

























