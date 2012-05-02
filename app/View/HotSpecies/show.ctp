        <?php $this->set('title_for_layout', 'Παρουσίαση δημοφιλών ειδών - ΕΛΚΕΘΕ');?>
        
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
                         <h2>HotSpecies</h2>
                         </br>
                            <?php if(empty($hotspecies)): ?>
                                There are no hotspecies in this list
                            <?php else: ?>
                         <table>
                         <tr>
                         <th>Scientific Name</th>
                         <th>Description</th>
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
                            <?php echo $this->Html->link('Update', array('action'=>'update',$hotspecie['HotSpecie']['id'])); ?>
                         </td>
                         <td>
                            <?php echo $this->Html->link('Delete', array('action'=>'delete',$hotspecie['HotSpecie']['id'])); ?>
                         </td>
                         </tr>
                            <?php endforeach; ?>
                         </table>
                            <?php endif; ?>
                                </br>       
                        <?php echo $this->Html->link('Add HotSpecies', array('action'=>'create')); ?>
                        <?php echo $this->Session->flash(); ?>
                    </div>
			</div>
        </div>
