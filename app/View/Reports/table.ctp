<?php
/**
 * @author darkmatter 
 */
?>
<?php echo $this->Html->css(array('main', 'jquery-ui', 'reportsTable', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'googlemaps.js')); ?>
<?php
    //echo '<script type="text/javascript" src="'.$this->GoogleMapV3->apiUrl().'"></script>';
?>
<script>
    // autocomplete hints for category and species
    var hints =
    {
        'category': <?php if (isset($categories))echo json_encode($categories); else echo "[]"?>,
        'species': <?php if (isset($species)) echo json_encode($species); else echo "[]"?>
    }
    
    $(document).ready(function() 
    { 
        $("#pager button, .deleteButton, .editButton, #filterContainer form input[type='submit']").button();
        //$('#pager select').combobox();
        
        // Set autocomplete support
        var selection = $("#filterCategory").val();
        $("#filterTerm").autocomplete(
            {
                source: hints[selection]
            }
        );
        
        $("#reportsTable").tablesorter({sortList: [[0,1]]})  //sort the first column in descending order
            .tablesorterPager({container: $("#pager")});
        
        positionPagerButtons();
    } 
);
    
    function positionPagerButtons()
    {
        // Correct tablesorterPager's tyrranic styling
        $('#pager').attr('style', '');
    }
    
    function report_onclick(id)
    {
        window.location.href = 'edit/' + id;
    }
    
    function filterCategory_changed()
    {
        var selection = $("#filterCategory").val();
        $("#filterTerm").autocomplete("option", "source", hints[selection]);     
    }
</script>
<div class="middle_row">
    <div class="middle_wrapper">
        <div>
            <div class="login_box">  
                <p><?php //echo print_r($reports)?></p>
            <h1>Πίνακας Αναφορών</h1>
            <div class="flash_box gradient">
                <?php echo $this->Session->flash().'</br>';?>
            </div>
            
            <a id ="exportLink" href="<?php echo $this->Html->url(array('controller'=>'reports', 'action'=>'export')) ?>">
                <div class="inner">
                    <span>Εξαγωγή</span>
                    <img class="icon" src="../img/whiteArrow.png"/>
                </div>
            </a>
            
            <div id="tableOuterWrapper">
                <div id="filterContainer">
                    <table>
                        <?php echo $this->Form->create('Report', array('action' => 'table'));     
                        ?>
                        <tr>
                            <td>
                                <select name="data[Report][select]" id="filterCategory" onchange="filterCategory_changed(this)">
                                    <option value="category" selected="selected">Κατηγορία</option>
                                    <option value="species">Είδος</option>
                                </select>
                            </td>
                            <td>
                                <input name="data[Report][text]" type="text" class="" id="filterTerm"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="searchConfirmed" value="confirmed" name="data[Report][type]" checked/>
                                <label for="searchConfirmed">Επιβεβαιωμένες</label>
                                <input type="checkbox" id="searchRejected"  value="rejected"  name="data[Report][type]"  checked/>
                                <label for="searchRejected">Απορριφθείσες</label>
                                <input type="checkbox" id="searchUnknown"   value="unknown"   name="data[Report][type]"   checked/>
                                <label for="searchUnknown">Εκκρεμούσες</label>
                            </td>
                            <td>
                                <?php echo $this->Form->end(array(
                                                    'label' => 'Αναζήτηση',
                                                    'div' => false,
                                                    'class' => 'std_form'));
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php if (empty($reports)): ?>
                <div class="report noReportFiller">
                    <h2><center>There are no reports</center></h2>
                </div>
                <?php else: ?>
                <table id="reportsTable" class="tablesorter reportsTable">
                    <thead>
                        <tr>
                            <th>Ημερομηνία Υποβολής</th>
                            <th>Φωτογραφία Παρατήρησης</th>
                            <th>Κατηγορία</th>
                            <th>Eίδος</th>
    <!--                            <th>Κατάσταση</th>-->
                            <th>Τελευταία Επεξεργασία</th>
                            <th>Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report): ?>
                        <?php
                            // Determine the status of the report
                            $reportStatus = "pending"; // classes are {"pending", "rejected", "verified"}
                            if ( isset($report['Report']['state']) )
                            {
                                switch ($report['Report']['state'])
                                {
                                    case "confirmed":
                                        $reportStatus = "verified";
                                        break;
                                    case "unreliable":
                                        $reportStatus = "rejected";
                                        break;
                                    case "unknown":
                                        break;
                                }
                            }
                        ?>
                            <tr class="report <?php echo $reportStatus ?>" onclick="report_onclick(<?php echo $report['Report']['id'] ?>)">
                                <td class="leftmost">
                                    <?php echo $report['Report']['created'] ?>
                                </td>
                                <td>
                                    <center>
                                        <?php echo $this->Html->image($report['Report']['main_photo'], array('alt' => 'main photo', 'class' => 'tableImage')) ?>
                                    </center>
                                </td>
                                <td>
                                    <?php
                                        if ( isset($report['Category']) )
                                            echo $report['Category']['category_name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if ( isset($report['HotSpecie']) )
                                            echo $report['HotSpecie']['scientific_name'];
                                    ?>
                                </td>
    <!--                                <td>
                                    <?php
                                        echo $report['Report']['state'];
                                    ?>
                                </td>-->
                                <td>
                                    <?php
                                        if ( isset($report['Last_edited_by']) )
                                            echo $report['Report']['modified'];
                                            echo ', ';
                                            echo $report['Last_edited_by']['name'];
                                            echo ' ';
                                            echo $report['Last_edited_by']['surname'];
                                    ?>
                                </td>
                                <td class="rightmost">
                                    <div class="buttonContainer">
                                        <a class="editButton "href="<?php echo $this->Html->url(array('controller'=>'reports', 'action'=>'edit', $report['Report']['id'])) ?>">
                                            Επεξεργασία
                                        </a>
                                        <br/>
                                        <a class="deleteButton "href="<?php echo $this->Html->url(array('controller'=>'reports', 'action'=>'delete', $report['Report']['id'])) ?>">
                                            <img class="icon" src="../img/whiteX.png"/>
                                            Διαγραφή
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pager" class="pager">
                    <form>
<!--                        <img src="/img/tablesorter-first.png" class="first"/>-->
<!--                        <img src="/img/tablesorter-prev.png" class="prev"/>-->
                        <button class="first">Αρχή</button>
                        <button class="prev">Προηγούμενο</button>
                        <input type="text" class="pagedisplay"/>
<!--                        <img src="/img/tablesorter-next.png" class="next"/>-->
<!--                        <img src="/img/tablesorter-last.png" class="last"/>-->
                        <select style="visibility: hidden" class="pagesize" onchange="positionPagerButtons">
                                <option selected="selected" value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                        </select>
                        <button class="next">Επόμενο</button>
                        <button class="last">Τέλος</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            <br/>   
        </div>
    </div>
</div>
