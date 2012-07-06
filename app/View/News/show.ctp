<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'jquery.metadata.js')); ?>

<script>
    $(document).ready(function() {
        $('.buttonContainer a, .tableTopButtonContainer a').button();

        $("#newsTable").tablesorter(
        {
            sortList: [[0,0]], //sort the first column in descending order
            headers: {}
        });
    });
    
    function item_onclick(id)
    {
        var target = '/hotSpecies/update/' + id;        
        window.location.href = target;
    }
</script>

<?php $this->set('title_for_layout', 'Παρουσίαση νέων/ανακοινώσεων - ΕΛΚΕΘΕ');?>
        
    <div class="middle_row">
        <div class="middle_wrapper">
            <div align="center">
                <h1>Παρουσίαση νέων/ανακοινώσεων</h1>
                <br/>
                <div id="tableOuterWrapper">
                    <div style="margin-bottom: 4px" id="createNewsDiv" class="tableTopButtonContainer">
                        <?php echo $this->Html->link('Προσθέστε Νέο/Ανακοίνωση', array('action'=>'create'), array('class'=>'blueButton')); ?>
                    </div>
                    <?php if(empty($news)): ?>
                        <div class="report noItemsFiller">
                            <h2><center>Δεν έχουν καταχωρηθεί Νέα/Ανακοινώσεις</center></h2>
                        </div>
                    <?php else: ?>
                    <table id="newsTable" class="tablesorter newsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Τίτλος</th>
                                <th>Περιγραφή</th>
                                <th>Δημιουργήθηκε</th>
                                <th>Επεξεργάστηκε</th>
                                <th class="{sorter: false}">Ενέργειες</th>
                            </tr>
                        </thead>
                         <tbody>
                            <?php foreach ($news as $new): ?>
                                <tr class="item species">
                                    <td>
                                        <?php echo $new['New']['id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $new['New']['title'] ?>
                                    </td>
                                    <td>
                                        <?php echo $new['New']['body'] ?>
                                    </td>
                                    <td>
                                        <?php echo $new['New']['created'] ?>
                                    </td>
                                    <td>
                                        <?php echo $new['New']['modified'] ?>
                                    </td>
                                    <td>
                                        <div class="buttonContainer">
                                            <?php echo $this->Html->link('Επεξεργασία', array('action'=>'edit',$new['New']['id'])); 
                                                echo ' ';
                                                echo $this->Form->postLink(
                                                        'Delete',
                                                        array('action' => 'delete', $new['New']['id']),
                                                        array('confirm' => 'Are you sure?', 'class'=>"deleteButton")); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                         </tbody>
                    </table>
                    <?php endif; ?>
                </div>
                </br>       
                <!--<?php echo $this->Html->link('Προσθέστε Νέο/Ανακοίνωση', array('action'=>'create')); ?>-->
                <?php echo $this->Session->flash(); ?>
            </div>
        </div>
    </div>
