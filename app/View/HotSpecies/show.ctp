        <?php $this->set('title_for_layout', 'Παρουσίαση δημοφιλών ειδών - ΕΛΚΕΘΕ');?>
        
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
                         <h2>Παρουσίαση δημοφιλών ειδών</h2>
                        <?php echo $this->Session->flash(); ?>
                         </br>
                            <?php if(empty($hotspecies)): ?>
                                Δεν έχουν καταχωρηθεί Είδη Υψηλής Προτεραιότητας
                            <?php else: ?>
                         <table>
                         <tr>
                         <th>Επιστημονική ονομασία</th>
                         <th>Περιγραφή είδους</th>
                         <th>Φωτογραφία</th>
                         </tr>
                            <?php foreach ($hotspecies as $hotspecie): ?>
                         <tr>
                         <td>
                            <?php echo $hotspecie['HotSpecie']['scientific_name'] ?>
                         </td>
                         <td>
                            <?php echo $hotspecie['HotSpecie']['description'] ?>
                         </td>
                         <td>
                            <?php echo $this->Html->image($hotspecie['HotSpecie']['main_photo'], array('alt' => 'main photo', 'class' => 'tableImage')) ?>
                         </td>
                         <td>
                            <?php echo $this->Html->link('Επεξεργασία', array('action'=>'update',$hotspecie['HotSpecie']['id'])); ?>
                         </td>
                         <td>
                            <?php echo $this->Html->link('Διαγραφή', array('action'=>'delete',$hotspecie['HotSpecie']['id'])); ?>
                         </td>
                         </tr>
                            <?php endforeach; ?>
                         </table>
                            <?php endif; ?>
                                </br>       
                        <?php echo $this->Html->link('Προσθέστε Είδος', array('action'=>'create')); ?>
                    </div>
			</div>
        </div>
