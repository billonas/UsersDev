<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'jquery.metadata.js')); ?>

<?php $this->set('title_for_layout', 'Eπικοινωνία αναλυτών - ΕΛΚΕΘΕ');?> 
 


<script>

  $(document).ready(function()
    { 
        
        
        $("#reportsTable").tablesorter(
            {
                sortList: [[0,1]], //sort the first column in descending order
                headers:
                {
//                    1: { sorter: false }, //photo
//                    5: { sorter: false }, //buttons
//                    4: { sorter: 'lastModified' } // last modified
                }
            });
        
        positionPagerButtons();
    } 
);
</script>
    <div class="middle_row  big_row">
			<div class="middle_wrapper">
				<div class="register_box login_box" align="center">
			 		<br/><h1>Eπικοινωνία αναλυτών</h1><br/>
                                      <?php 
                                      
                                        if(empty($info))
                                            echo '<h2><center>Δεν υπάρχουν στοιχεία αναλυτών</center></h2>';
                                        else {
                                            echo '<table id="reportsTable" class="tablesorter reportsTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Όνομα</th>
                                                            <th>Επώνυμο</th>
                                                            <th>Κατηγορία ειδίκευσης 1</th>
                                                            <th>Κατηγορία ειδίκευσης 2</th>
                                                            <th>e-mail</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                            
                                            foreach($info as $analyst){
                                                echo '<tr>';
                                                echo '<td>'.$analyst['name'].'</td>';
                                                echo '<td>'.$analyst['surname'].'</td>';
                                                echo '<td>'.$analyst['category1'].'</td>';
                                                echo '<td>'.$analyst['category2'].'</td>';
                                                echo '<td>'.$analyst['email'].'</td>';
                                                echo '</tr>';
                                            }
                                            echo '</tbody></table>';
                                        }
                                      ?>
			</div>
    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
