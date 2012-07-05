<?php $this->set('title_for_layout', 'Παρουσίαση δημοφιλών ειδών - ΕΛΚΕΘΕ');?>

<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'jquery.metadata.js')); ?>
        
<style>
    .itemButton {
        width: 100%;
    }
    
    .buttonContainer table {
        border-collapse: collapse;
    }
</style>
<script>
    $(document).ready(function() {
        $('.buttonContainer a, #createSpeciesDiv a').button();

        $("#speciesTable").tablesorter(
        {
            sortList: [[0,1]], //sort the first column in descending order
            headers: {}
        });
    });
</script>

    <div class="middle_row">
        <div class="middle_wrapper">
            <div align="center">
                <h2>Παρουσίαση δημοφιλών ειδών</h2>
                <br/>
                <div id="tableOuterWrapper">
                    <div id="createSpeciesDiv" class="tableTopButtonContainer">
                        <?php echo $this->Html->link('Προσθέστε Είδος', array('action'=>'create'), array('class'=>'blueButton')); ?>
                    </div>
                    <?php if(empty($hotspecies)): ?>
                        <div class="report noItemsFiller">
                            <h2><center>Δεν έχουν καταχωρηθεί Είδη Υψηλής Προτεραιότητας</center></h2>
                        </div>
                    <?php else: ?>
                        <table id="speciesTable" class="tablesorter speciesTable">
                            <thead>
                                <th>Επιστημονική ονομασία</th>
                                <th>Περιγραφή είδους</th>
                                <th class="{sorter: false}"">Φωτογραφία</th>
                                <th class="{sorter: false}">Ενέργειες</th>
                            </thead>
                            <tbody>
                                <?php foreach ($hotspecies as $hotspecie): ?>
                                    <tr height="100px" class="item species">
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
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <a class="itemButton editButton" href="<?php echo $this->Html->url(array('action'=>'update',$hotspecie['HotSpecie']['id'])) ?>">
                                                                Επεξεργασία
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="itemButton deleteButton" href="<?php echo $this->Html->url(array('action'=>'delete',$hotspecie['HotSpecie']['id'])) ?>">
                                                                <img class="icon" src="../img/whiteX.png"/>
                                                                Διαγραφή
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a class="itemButton upButton" href="<?php echo $this->Html->url(array('action'=>'changePriority',$hotspecie['HotSpecie']['id'],1)) ?>">
                                                                Up Priority
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="itemButton downButton" href="<?php echo $this->Html->url(array('action'=>'changePriority',$hotspecie['HotSpecie']['id'],2)) ?>">
                                                                Down Priority
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                <br/>       
                <?php echo $this->Session->flash(); ?>
            </div>
        </div>
    </div>