<?php $this->set('title_for_layout', 'Παρουσίαση δημοφιλών ειδών - ΕΛΚΕΘΕ');?>

<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'jquery.metadata.js')); ?>
        
<style>
</style>
<script>
$(document).ready(function() {
    $('.buttonContainer a').button();
});
</script>

    <div class="middle_row">
        <div class="middle_wrapper">
            <div align="center">
                <h2>Παρουσίαση δημοφιλών ειδών</h2>
                </br>
                <?php if(empty($hotspecies)): ?>
                    Δεν έχουν καταχωρηθεί Είδη Υψηλής Προτεραιότητας
                <?php else: ?>
                    <table id="speciesTable" class="tablesorter speciesTable">
                        <thead>
                            <th>Επιστημονική ονομασία</th>
                            <th>Περιγραφή είδους</th>
                            <th>Φωτογραφία</th>
                            <th>Ενέργειες</th>
                        </thead>
                        <tbody>
                            <?php foreach ($hotspecies as $hotspecie): ?>
                                <tr height="100px">
                                    <td>
                                        <?php echo $hotspecie['HotSpecie']['scientific_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $hotspecie['HotSpecie']['description'] ?>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $this->Html->image($hotspecie['HotSpecie']['main_photo'], array('alt' => 'main photo', 'class' => 'tableImage')) ?>
                                        </center>
                                    </td>
                                    <td>
                                        <!--<?php echo $this->Html->link('Επεξεργασία', array('action'=>'update',$hotspecie['HotSpecie']['id'])); 
                                            echo ' ';
                                            echo $this->Html->link('Διαγραφή', array('action'=>'delete',$hotspecie['HotSpecie']['id']));
                                            echo $this->Html->link('Up Priority', array('action'=>'changePriority',$hotspecie['HotSpecie']['id'],1));
                                            echo $this->Html->link('Down Priority', array('action'=>'changePriority',$hotspecie['HotSpecie']['id'],2));
                                        ?>-->
                                        <div class="buttonContainer">                                            
                                            <a class="editButton" href="<?php echo $this->Html->url(array('action'=>'update',$hotspecie['HotSpecie']['id'])) ?>">
                                                Επεξεργασία
                                            </a>
                                            <a class="deleteButton" href="<?php echo $this->Html->url(array('action'=>'delete',$hotspecie['HotSpecie']['id'])) ?>">
                                                <img class="icon" src="../img/whiteX.png"/>
                                                Διαγραφή
                                            </a>
                                            <br/>
                                            <a class="upButton" href="<?php echo $this->Html->url(array('action'=>'changePriority',$hotspecie['HotSpecie']['id'],1)) ?>">
                                                Up Priority
                                            </a>
                                            <a class="downButton" href="<?php echo $this->Html->url(array('action'=>'changePriority',$hotspecie['HotSpecie']['id'],2)) ?>">
                                                Down Priority
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                    </br>       
                <?php echo $this->Html->link('Προσθέστε Είδος', array('action'=>'create')); ?>
                <?php echo $this->Session->flash(); ?>
            </div>
        </div>
    </div>