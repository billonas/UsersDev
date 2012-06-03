<?php echo $this->Html->css(array('main', 'jquery-ui', 'tablesorter', 'reportsTable')); ?>        
<?php $this->set('title_for_layout', 'Παρουσίαση δημοφιλών ειδών - ΕΛΚΕΘΕ');?>
        
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
                         <h2>Παρουσίαση νέων/ανακοινώσεων</h2>
                         </br>
                            <?php if(empty($news)): ?>
                                Δεν έχουν καταχωρηθεί Νέα/Ανακοινώσεις
                            <?php else: ?>
                         <table id="reportsTable" class="tablesorter reportsTable">
                         <thead>
                         <tr>
                         <th>ID</th>
                         <th>Τίτλος</th>
                         <th>Περιγραφή</th>
                         <th>Δημιουργήθηκε</th>
                         <th>Επεξεργάστηκε</th>
                         <th>Ενέργειες</th>
                         </tr>
                         </thead>
                         <tbody>
                            <?php foreach ($news as $new): ?>
                         <tr>
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
                            <?php echo $this->Html->link('Επεξεργασία', array('action'=>'edit',$new['New']['id'])); 
                                  echo ' ';
                                  echo $this->Form->postLink(
                                        'Delete',
                                        array('action' => 'delete', $new['New']['id']),
                                        array('confirm' => 'Are you sure?')); ?>
                         </td>
                         </tr>
                            <?php endforeach; ?>
                         </tbody>
                         </table>
                            <?php endif; ?>
                                </br>       
                        <?php echo $this->Html->link('Προσθέστε Νέο/Ανακοίνωση', array('action'=>'create')); ?>
                        <?php echo $this->Session->flash(); ?>
                    </div>
			</div>
        </div>
