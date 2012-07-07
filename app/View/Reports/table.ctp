<?php
/**
 * @author darkmatter 
 */
?>
<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'jquery.metadata.js')); ?>

<?php $this->set('title_for_layout', 'Πίνακας αναφορών - ΕΛΚΕΘΕ');?>  

<script>        
    // autocomplete hints for category and species
    var hints =
    {
        'category': <?php if (isset($categories))echo json_encode($categories); else echo "[]"?>,
        'species': <?php if (isset($species)) echo json_encode($species); else echo "[]"?>
    }
    
    $(document).ready(function()
    { 
        // Add confirmation before delete
        $('.item a.deleteButton').click(function(e) {
            e.stopPropagation();
            return confirm('Είστε βέβαιος/η ότι θέλετε να διαγράψετε αυτήν την αναφορά;');
        });
    
        $("#pager button, .deleteButton, .editButton, #filterContainer form input[type='submit'], #filterContainer form button[type='submit']").button();
        
        // Set autocomplete support
        var selection = $("#filterCategory").val();
        $("#filterTerm").autocomplete(
            {
                source: hints[selection]
            }
        );
        
        // Add a tablesorter parser for the modified field
        $.tablesorter.addParser({ 
            id: 'lastModified', 
            is: function(s) { 
                // return false so this parser is not auto detected 
                return false; 
            }, 
            format: function(s) {
                var rxDate = /\d+-\d+-\d/g;
                var rxTime = /\d+:\d+:\d/g;
                
                var date = rxDate.exec(s);
                var time = rxTime.exec(s);
                
                return date + " " + time;
            }, 
            //type: 'numeric'
            type: 'text'
        }); 
        
        $("#reportsTable").tablesorter(
            {
                sortList: [[0,1]], //sort the first column in descending order
                headers: {}
            }).tablesorterPager({container: $("#pager")});
        
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
        window.location.href = "<?php echo $this->Html->url(array('controller'=>'reports', 'action'=>'edit'))?>" + "/" + id;
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
            <h1>Πίνακας Αναφορών</h1>
            <div class="flash_box gradient">
                <?php echo $this->Session->flash().'</br>';?>
            </div>
            
            <div id="exportLinkContainer">
                <a class="exportLink" href="<?php echo $this->Html->url(array('controller'=>'reports', 'action'=>'excelExport', '?' => $this->params['url'])) ?>">
                    <div class="inner">
                        <span>Εξαγωγή εμφανιζόμενων</span>
                        <img class="icon" src="../img/whiteArrow.png"/>
                    </div>
                </a>
                <br/>
                <a class="exportLink" href="<?php echo $this->Html->url(array('controller'=>'reports', 'action'=>'excelExport')) ?>">
                    <div class="inner">
                        <span>Εξαγωγή όλων</span>
                        <img class="icon" src="../img/whiteArrow.png"/>
                    </div>
                </a>
            </div>
            
            <div id="tableOuterWrapper">
                <div id="filterContainer">
                    <?php echo $this->Form->create('Report', array('action' => 'table', 'type'=>'get')); ?>
                        <table>                        
                            <tr>
                                <td>
                                    <select name="select" id="filterCategory" class="std_form" onchange="filterCategory_changed(this)">
                                        <?php if(!isset($select) || $select==='') $select='category'; //Default is category ?>
                                        <option value="category" <?php if ($select==='category') echo 'selected="selected"'; ?> >Κατηγορία</option>
                                        <option value="species" <?php if ($select==='species') echo 'selected="selected"'; ?> >Είδος</option>
                                    </select>
                                </td>
                                <td>
                                    <input name="text" type="text" class="std_form" id="filterTerm" value="<?php if(isset($text))echo $text;?>"/>
                                </td>
                                <td>
                                    <button type="submit" value="Αναζήτηση">
                                        <img src="../img/whiteSpyglass.png"/>
                                        Αναζήτηση
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="searchConfirmed" value="confirmed" name="state1" <?php if(isset($checkboxes['state1'])) if($checkboxes['state1']) echo 'checked'; ?>/>
                                                <label for="searchConfirmed">Επιβεβαιωμένες</label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="searchRejected"  value="unreliable"  name="state2" <?php if(isset($checkboxes['state2'])) if($checkboxes['state2']) echo 'checked'; ?>/>
                                                <label for="searchRejected">Απορριφθείσες</label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <input type="checkbox" id="searchUnknown"   value="unknown"   name="state3" <?php if(isset($checkboxes['state3'])) if($checkboxes['state3']) echo 'checked'; ?>/>
                                                <label for="searchUnknown">Εκκρεμούσες</label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
    <!--                            <td>
                                    <?php echo $this->Form->end(array(
                                                        'label' => 'Αναζήτηση',
                                                        'div' => false,
                                                        'class' => 'std_form'));
                                    ?>
                                </td>-->
                            </tr>
                        </table>
                    <?php echo $this->Form->end(); ?>
                </div>
                <?php if (empty($reports)): ?>
                <div class="report noItemsFiller">
                    <h2><center>Δεν υπάρχουν αναφορές</center></h2>
                </div>
                <?php else: ?>
                <table id="reportsTable" class="tablesorter reportsTable">
                    <thead>
                        <tr>
                            <th>Ημερομηνία Υποβολής</th>
                            <th class="{sorter: false}">Φωτογραφία Παρατήρησης</th>
                            <th>Κατηγορία</th>
                            <th>Eίδος</th>
                            <th class="{sorter: 'lastModified'}">Τελευταία Επεξεργασία</th>
                            <th class="{sorter: false}">Ενέργειες</th>
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
                            <tr class="item clickable report <?php echo $reportStatus ?>" onclick="report_onclick(<?php echo $report['Report']['id'] ?>)">
                                <td class="leftmost">
                                    <?php echo $report['Report']['created'] ?>
                                </td>
                                <td>
                                    <center>
                                        
                                        <?php
                                        if($report['Report']['main_photo']!=null){
                                        echo $this->Html->image($report['Report']['main_photo'], array('alt' => 'main photo', 'class' => 'tableImage'));
                                        }
                                        else{
                                        echo $this->Html->image('Video_icon.png', array('alt' => 'main photo', 'class' => 'tableImage'));    
                                        }
                                        ?>
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
                                        if ( isset($report['Specie']) )
                                            echo $report['Specie']['scientific_name'];
                                    ?>
                                </td>
    <!--                                <td>
                                    <?php
                                        echo $report['Report']['state'];
                                    ?>
                                </td>-->
                                <td>
                                    <?php
                                        if ( !isset($report['Last_edited_by']) )
                                        {
                                            echo '-';
                                        }
                                        else
                                        {
                                            if ($report['Report']['modified'] === $report['Report']['created'])
                                            {
                                                echo '-';
                                            }
                                            else
                                            {
                                                echo $report['Report']['modified'];
                                                echo ', ';
                                                echo $report['Last_edited_by']['name'];
                                                echo ' ';
                                                echo $report['Last_edited_by']['surname'];
                                            }
                                        }
                                    ?>
                                </td>
                                <td class="rightmost">
                                    <div class="buttonContainer">
                                        <a class="editButton" href="<?php echo $this->Html->url(array('controller'=>'reports', 'action'=>'edit', $report['Report']['id'])) ?>">
                                            Επεξεργασία
                                        </a>
                                        <br/>
                                        
                                        <?php if($this->Session->read('UserType') === 'hyperanalyst')
                                            echo'
                                        <a class="deleteButton" href="'.$this->Html->url(array('controller'=>'reports', 'action'=>'delete', $report['Report']['id'])).
                                            '<img class="icon" src="../img/whiteX.png"/>
                                            Διαγραφή
                                          
                                        </a>';
                                            ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pager" class="pager">
                    <form>
                        <button class="first">Αρχή</button>
                        <button class="prev">Προηγούμενο</button>
                        <input type="text" class="pagedisplay" readonly="readonly"/>
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
