<?php
/**
 * @author darkmatter 
 */
?>
<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
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
            <h1>Επεξεργασία Χρηστών</h1>
            <div class="flash_box gradient">
                <?php echo $this->Session->flash().'</br>';?>
            </div>
            
            <div id="tableOuterWrapper">
                <div id="filterContainer">
                    <?php echo $this->Form->create('User', array('action' => 'edit_users', 'type'=>'get')); ?>
                        <table>                        
                            <tr>
                                <td>
                                    <input name="text" type="text" class="" id="filterTerm"/>
                                </td>
                                <td>
                                    <input type="submit" value="Αναζήτηση"/>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td>
                                    <input id="searchAnalyst" type="checkbox" value="analyst" name="userType1" checked/>
                                    <label for="searchAnalyst">Αναλυτές</label>
                                </td>
                                <td>
                                    <input id="searchSimple" type="checkbox" value="simple"  name="userType2" checked/>
                                    <label for="searchSimple">Απλοί Χρήστες</label>
                                </td>
                                <td>
                                    <input id="searchHyperanalyst" type="checkbox" value="hyperanalyst"  name="userType3" checked/>
                                    <label for="searchHyperanalyst">Απλοί Χρήστες</label>
                                </td>
                            </tr>
                        </table>
                    <?php echo $this->Form->end(); ?>
                </div>
                <?php if (empty($users)): ?>
                <div class="report noReportFiller">
                    <h2><center>Δεν υπάρχει κανένας εγγεγραμένος χρήστης</center></h2>
                </div>
                <?php else: ?>
                <table id="reportsTable" class="tablesorter reportsTable">
                    <thead>
                        <tr>
                            <th>Ημερομηνία Δημιουργίας Χρήστη</th>
                            <th>Τύπος Χρήστη</th>
                            <th>Όνομα</th>
    <!--                            <th>Κατάσταση</th>-->
                            <th>Επώνυνο</th>
                            <th>Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
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
                            <tr class="report <?php echo $reportStatus ?>" onclick="report_onclick(<?php echo $user['User']['id'] ?>)">
                                <td class="leftmost">
                                    <?php echo $user['User']['created'] ?>
                                </td>
                                <td>
                                    <?php
                                            echo $user['User']['user_type'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                            echo $user['User']['name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $user['User']['surname'];
                                    ?>
                                </td>
                                <td class="rightmost">
                                    <div class="buttonContainer">
                                        <a class="editButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'show', $user['User']['id'])) ?>">
                                            Επεξεργασία
                                        </a>
                                        <br/>
                                        <a class="deleteButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'delete', $user['User']['id'])) ?>">
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

