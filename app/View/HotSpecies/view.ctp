<?php echo $this->Html->css(array('main', 'jquery-ui', 'tablesorter', 'reportsTable')); ?>        
<?php $this->set('title_for_layout', 'Παρουσίαση δημοφιλών ειδών - ΕΛΚΕΘΕ');?>
        
<style>.tableImage {
    max-width: 200px;
    max-height: 100px;
    min-height: 50px;
    min-width: 50px;
    border: 1px solid silver;
    border-radius: 6px;
}</style>
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
                         <h2>Παρουσίαση δημοφιλών ειδών</h2>
                         </br>
                            <?php if(empty($hotspecies)): ?>
                                Δεν έχουν καταχωρηθεί Είδη Υψηλής Προτεραιότητας
                            <?php else: ?>
                         <table id="reportsTable" class="tablesorter reportsTable">
                         <thead>
                         <tr>
                         <th>Επιστημονική ονομασία</th>
                         <th>Περιγραφή είδους</th>
                         <th>Φωτογραφία</th>
                         <th>Ενέργειες</th>
                         </tr>
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
                            <?php echo $this->Html->link('Επεξεργασία', array('action'=>'update',$hotspecie['HotSpecie']['id'])); 
                                  echo ' ';
                                  echo $this->Html->link('Διαγραφή', array('action'=>'delete',$hotspecie['HotSpecie']['id']));
                                  echo $this->Html->link('Up Priority', array('action'=>'changePriority',$hotspecie['HotSpecie']['id'],1));
                                  echo $this->Html->link('Down Priority', array('action'=>'changePriority',$hotspecie['HotSpecie']['id'],2));?>
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