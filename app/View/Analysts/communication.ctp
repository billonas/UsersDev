<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'jquery.metadata.js')); ?>

<?php $this->set('title_for_layout', 'Eπικοινωνία αναλυτών - ΕΛΚΕΘΕ');?> 
 
<style>
    .item {
    }
</style>

<script>

  $(document).ready(function()
    { 
        
        
        $("#reportsTable").tablesorter(
            {
                sortList: [[0,1]], //sort the first column in descending order
                headers: {}
            });
    } 
);
</script>
<div class="middle_row  big_row">
    <div class="middle_wrapper">
        <div class="register_box login_box white_box" align="center">
            <br/><h1>Eπικοινωνία αναλυτών</h1><br/>
            <?php if(empty($info)): ?>
                <h2><center>Δεν υπάρχουν στοιχεία αναλυτών</center></h2>;
            <?php else: ?>
                <div id="tableOuterWrapper">
                    <table id="reportsTable" class="tablesorter reportsTable">
                        <thead>
                            <tr>
                                <th>Όνομα</th>
                                <th>Επώνυμο</th>
                                <th>Κατηγορία ειδίκευσης 1</th>
                                <th>Κατηγορία ειδίκευσης 2</th>
                                <th>e-mail</th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($info as $analyst):
                            echo '<tr class="item analyst">';
                                echo '<td>'.$analyst['name'].'</td>';
                                echo '<td>'.$analyst['surname'].'</td>';
                                echo '<td>'.$analyst['category1'].'</td>';
                                echo '<td>'.$analyst['category2'].'</td>';
                                echo '<td>'.$analyst['email'].'</td>';
                            echo '</tr>';
                        endforeach; ?>  
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="comments">
        <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
    </div>
</div>
