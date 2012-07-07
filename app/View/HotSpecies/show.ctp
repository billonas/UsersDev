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
            sortList: [[0,0]], //sort the first column in descending order
            headers: {}
        });
    });
    
    function item_onclick(id)
    {
        var target = "<?php echo $this->Html->url(array('controller'=>'hotSpecies', 'action'=>'update')) ?>" + '/' + id;  
        window.location.href = target;
    }
</script>

    <div class="middle_row">
        <div class="middle_wrapper">
            <div align="center">
                <?php 
                echo '<div class="login_box">  
                               <h1>Παρουσίαση ειδών-στόχων</h1>
                         </div>';
                echo '<div class="flash_box gradient">';
                    echo '</br/>'.$this->Session->flash().'</br>';
                    echo '</br>';
                    echo '</div>';?>
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
                                <th>Σειρά εμφάνισης</th>
                                <th>Επιστημονική ονομασία</th>
                                <th>Περιγραφή είδους</th>
                                <th class="{sorter: false}"">Φωτογραφία</th>
                                <th class="{sorter: false}">Ενέργειες</th>
                            </thead>
                            <tbody>
                                <?php foreach ($hotspecies as $hotspecie): ?>
                                    <tr height="100px" class="item clickable species" onclick="item_onclick(<?php echo $hotspecie['HotSpecie']['id']?>)">
                                        <td>
                                            <?php echo $hotspecie['HotSpecie']['priority'] ?>
                                        </td>
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
                                                                <img class="icon" src="../img/blackUpArrow.png"/>
                                                                Αναβάθμιση
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="itemButton downButton" href="<?php echo $this->Html->url(array('action'=>'changePriority',$hotspecie['HotSpecie']['id'],2)) ?>">
                                                                <img class="icon" src="../img/blackDownArrow.png"/>
                                                                Υποβάθμιση
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
            </div>
        </div>
    </div>