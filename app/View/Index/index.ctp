		<?php 	echo $this->Html->script(array('jquery-1.7.2.min','fade'),array('inline' => false, 'rel' => 'javascript')); 	?>
        <?php $this->set('title_for_layout', 'Αρχική σελίδα - ΕΛΚΕΘΕ');?>
        
        <script type="text/javascript">
			$ (document).ready(function($){
			 
					if($('#slideshow').length != 0){
					$('#slideshow').crossSlide({
							sleep: 3,
							fade: 1
					}, [
					{ src:  '<?php echo $this->webroot; ?>img/wall_01.jpg' },
					{ src:  '<?php echo $this->webroot; ?>img/wall_02.jpg' },
					{ src:  '<?php echo $this->webroot; ?>img/wall_03.jpg' }
						]);}
					});
		</script>
  
      	<div class="middle_row">
			<div class="middle_wrapper">
            	<div id="slideshow">
                
                
              	</div>
            </div>
		</div>
		<div class="lower_row">
            <a href="#">
                <h2>Είδη Υψηλής Προτεραιότητας</h2>
                <p>Ενημερωθείτε για τα είδη που έχουν μεγαλύτερη προτεραιότητα αυτή την εποχή για τους αναλυτές μας</p>
            </a>
            <a href="#">
                <h2>Υποβάλλετε Αναφορά</h2>
                <p>Υποβάλλετε μία αναφορά για ένα παράξενο είδος που συναντήσατε</p>
            </a>
            <a href="#">
                <h2>Εγγραφείτε</h2>
                <p>Γίνετε μέλος της κοινότητάς μας και βοηθήστε μας να προστατεύσουμε τις ελληνικές θάλασσες</p>
            </a>
	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	
