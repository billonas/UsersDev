<?php
/**
 * @author darkmatter 
 */
?>
<?php echo $this->Html->css(array('main', 'jquery-ui', 'tablesorter', 'reportsTable', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'googlemaps.js')); ?>
<?php
    //echo '<script type="text/javascript" src="'.$this->GoogleMapV3->apiUrl().'"></script>';
?>
<script>
    // autocomplete hints for category and species
    var hints =
    {
        'category': <?php echo json_encode($categories)?>,
        'species': <?php echo json_encode($species)?>
    }
    
    $(document).ready(function() 
    { 
        $("#reportsTable").tablesorter({sortList: [[0,0]]})  //sort the first column in ascending order
            .tablesorterPager({container: $("#pager")});
        
        $("#pager button, .deleteButton, .editButton, #filterContainer form input[type='submit']").button();
        
        // Set autocomplete support
        var selection = $("#filterCategory").val();
        $("#filterTerm").autocomplete(
            {
                source: hints[selection]
            }
        );
    } 
);
    
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
            
            <?php
//                echo $this->GoogleMapV3->map(array('map'=>array(
//                'defaultLat' => 39, # only last fallback, use Configure::write('Google.lat', ...); to define own one
//                'defaultLng' => 21, # only last fallback, use Configure::write('Google.lng', ...); to define own one
//                'defaultZoom' => 5,
//                ),'div'=>array('id'=>'my_map', 'height'=>'400', 'width'=>'700')));
////                SET MARKERS FOR ALL REPORTS                
////                $options = array(
////                'lat'=>39,
////                'lng'=>21,
////                );
////                $this->GoogleMapV3->addMarker($options);
//                echo $this->GoogleMapV3->script();
            ?>
            <div class="login_box">  
            <h1>Πίνακας Αναφορών</h1>
            <div class="flash_box gradient">
                <?php echo $this->Session->flash().'</br>';?>
            </div>
            <?php  echo $this->Html->link('Export', array('action'=>'export'), array('id'=>'exportLink'));?>
            <?php if (empty($reports)): ?>
                <h2><center>There are no reports</center></h2>
            <?php else: ?>

                <div id="tableOuterWrapper">
                    <div id="filterContainer">
                        <form>
                            <table>
                                <tr>
                                    <td>
                                        <select id="filterCategory" onchange="filterCategory_changed(this)">
                                            <option value="category" selected="selected">Κατηγορία</option>
                                            <option value="species">Είδος</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="" id="filterTerm"/>
                                    </td>
                                    <td>
                                        <input type="submit" class="" value="Αναζήτηση"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
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
                                        <?php echo $this->Html->link('Edit', array('action'=>'edit',$report['Report']['id']), array('class'=>'editButton')); 
                                                echo ' ';
                                                echo $this->Html->link('Delete', array('action'=>'delete',$report['Report']['id']), array('class'=>'deleteButton')); 
                                        ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div id="pager" class="pager">
                        <form>
    <!--                        <img src="/img/tablesorter-first.png" class="first"/>-->
    <!--                        <img src="/img/tablesorter-prev.png" class="prev"/>-->
                            <button class="first">First</button>
                            <button class="prev">Previous</button>
                            <input type="text" class="pagedisplay"/>
    <!--                        <img src="/img/tablesorter-next.png" class="next"/>-->
    <!--                        <img src="/img/tablesorter-last.png" class="last"/>-->
                            <select class="pagesize">
                                    <option selected="selected" value="2">2</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                            </select>
                            <button class="next">Next</button>
                            <button class="last">Last</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            <br/>   
        </div>
    </div>
</div>
