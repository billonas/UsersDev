<?php $this->set('title_for_layout', 'Οι αναφορές μου - ΕΛΚΕΘΕ');?> 
<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css'),null,array('inline'=>false)); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'googlemaps.js'),array('inline'=>false)); ?>

<script>
    $(document).ready(function() 
    {
        // Create button style
        $('#pager button, .item a.showButton').button();
        
        $("#reportsTable").tablesorter(
            {
                sortList: [[0,1]], //sort the first column in descending order
                headers:
                {
                    1: { sorter: false }, //photo
                    2: { sorter: false } //buttons
                }
            }).tablesorterPager({container: $("#pager")});
        
        positionPagerButtons();
    });
    
    function positionPagerButtons()
    {
        // Correct tablesorterPager's tyrranic styling
        $('#pager').attr('style', '');
    }
    
    function report_onclick(id)
    {
        window.location.href = '/users/view_report/' + id;
    }
</script>
    <div class="middle_row  big_row">
        <div class="middle_wrapper">
            <div class="register_box login_box" align="center">
                <br/><h1>Οι αναφορές μου</h1><br/>
                <div id="tableOuterWrapper">
                    <?php if (empty($reports)): ?>
                    <div class="report noItemsFiller">
                        <h2><center>Δεν έχετε κάνει καμία αναφορά!</center></h2>
                    </div>
                    <?php else: ?>
                    <table id="reportsTable" class="tablesorter reportsTable">
                        <thead>
                            <tr>
                                <th>Ημερομηνία Υποβολής</th>
                                <th class="{sorter: false}">Φωτογραφία Παρατήρησης</th>
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
                                <tr class="item report <?php echo $reportStatus ?>" onclick="report_onclick(<?php echo $report['Report']['id'] ?>)">
                                    <td>
                                        <?php echo $report['Report']['created'] ?>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $this->Html->image($report['Report']['main_photo'], array('alt' => 'main photo', 'class' => 'tableImage')) ?>
                                        </center>
                                    </td>                                
                                    <td>
                                        <div class="buttonContainer">
                                            <a class="showButton" href="<?php echo $this->Html->url(array('controller'=>'reports','action'=>'view_report',$report['Report']['id'])) ?>">
                                                Προβολή
                                            </a>
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
            </div>
        </div>
    </div>