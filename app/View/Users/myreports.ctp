<?php $this->set('title_for_layout', 'Οι αναφορές μου - ΕΛΚΕΘΕ');?> 
<?php echo $this->Html->css(array('main', 'jquery-ui', 'tablesorter', 'reportsTable'),null,array('inline'=>false)); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min'),array('inline'=>false)); ?>

<script>
    $(document).ready(function() 
    { 
        $("#reportsTable").tablesorter({sortList: [[0,0]]}); //sort the first column in ascending order
    } 
);
    
    function report_onclick(id)
    {
        window.location.href = '/users/view_report/' + id;
    }
</script>



    <div class="middle_row  big_row">
			<div class="middle_wrapper">
				<div class="register_box login_box" align="center">
			 		<br><h1>Οι αναφορές μου</h1></br>
                    <?php if (empty($reports)): ?>
                			<h2><center>Δεν εχετε υποβάλει αναφορές</center></h2>
            <?php else: ?>

                <?php //Print_r($reports[0]); ?>
                <table id="reportsTable" class="tablesorter reportsTable">
                    <thead>
                        <tr>
                            <th>Ημερομηνία Υποβολής</th>
                            <th>Φωτογραφία Παρατήρησης</th>
                            
<!--                            <th>Κατάσταση</th>-->
                            
                            <th>Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report): ?>
                        <?php
                            // Determine the status of the report
                            $reportStatus = "pending"; // classes are {"pending", "rejected", "verified"}
                            if ( isset($report['state']) )
                            {
                                switch ($report['state'])
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
                            <tr class="report <?php echo $reportStatus ?>" onclick="report_onclick(<?php echo $report['id'] ?>)">
                                <td>
                                    <?php echo $report['created'] ?>
                                </td>
                                <td>
                                    <center>
                                        <?php echo $this->Html->image($report['main_photo'], array('alt' => 'main photo', 'class' => 'tableImage')) ?>
                                    </center>
                                </td>
                                
                                
<!--                                <td>
                                    <?php
                                        echo $report['state'];
                                    ?>
                                </td>-->
                                
                                <td>
                                    <?php echo $this->Html->link('Προβολή', array('action'=>'view_report',$report['id'])); 
                                         
                                    ?>
                                    
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>	
					
			    </div>
			</div>
    </div>