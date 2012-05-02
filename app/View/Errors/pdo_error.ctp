<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="en-gb" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>Επεξεργασία Αναφοράς</title>
		<?php echo $this->Html->css(array('main','jquery-ui','imgareaselect-default'));	
                ?>
                <?php echo $this->Html->script(array('jquery.min','jquery-ui.min','jquery.imgareaselect.pack.js'));?>

<script>
  $(document).ready(function() {
    $("#tabs").tabs();
    $( ".selector" ).datepicker( "option", "dateFormat", 'yyyy-mm-dd' );
    $("#datepicker").datepicker();
  });
</script>


		<!--[if lt IE 10 ]>
			<link rel="stylesheet" href="hacks.css" type="text/css" media="screen" />
		 <![endif]-->
	</head>
	<body>
    	
		<div class="middle_row">
        	<div class="middle_wrapper">
                
                <?php echo 'ΠΡΟΒΛΗΜΑ ΣΤΗΝ ΒΑΣΗ ΔΕΔΟΜΕΝΩΝ'; ?>    
                    
            </div>

	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
	</body>
</html>
