<?php echo $this->Html->css(array('main', 'jquery-ui', 'forms')); ?>       
 <?php $this->set('title_for_layout', 'Επεξεργασία δημοφιλών ειδών - ΕΛΚΕΘΕ');?>       
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
<h2>Επεξεργασία Είδους</h2>
<table>
    
    
    
    <?php echo '<tr>'.$this->Form->create('HotSpecie', array('action' => 'update', "enctype" => "multipart/form-data")); ?>
          <?php
             echo $this->Form->input('id', array('type' => 'hidden'));
             echo '<td>'.$this->Html->image($hotspecie['HotSpecie']['main_photo']."?".time()).'</td>';
             //echo '</br>';
             echo $this->Form->error('scientific_name');
             echo '<td>'.$this->Form->input('scientific_name',array('label'=>'Επιστημονική ονομασία','div'=>'input[type=text]','id'=>'info')).'</td>';
             echo $this->Form->error('description');
             echo '<td>'.$this->Form->input('description',array("type" => "textarea",'label'=>'Περιγραφή είδους')).'</td>';
             echo $this->Form->input('priority', array('type' => 'hidden'));
             echo '</tr>';
             echo '<tr><td colspan="all">'.$this->Form->end('Αποθήκευση').'</td></tr>';
             
          ?>
             <?php 
             if($hotspecie['HotSpecie']['additional_photo1'] != null)
             {  
                    echo '<tr>';
                    echo '<td>'.$this->Html->image($hotspecie['HotSpecie']['additional_photo1']."?".time()).'</td>';
                    echo '<td>'.$this->Html->link('Set as main photo', array('action'=>'setMainPhoto',$hotspecie['HotSpecie']['id'],1)).'</td>';
                    echo '<td>'.$this->Html->link('Delete photo', array('action'=>'deleteImg',$hotspecie['HotSpecie']['id'],1)).'</td></tr>';
             }
             else  {
                    echo '<tr>';
                    echo $this->Form->create('HotSpecie', array('action' => 'addImg', "enctype" => "multipart/form-data"));
                    echo $this->Form->error('image');
                    echo '<td>'.$this->Form->input('image',array("type" => "file",'label'=>'Πρόσθετη Φωτογραφία 1')).'</td>';
                    echo '<td>'.$this->Form->input('id',array('type'=>'hidden','value'=>$hotspecie['HotSpecie']['id'])).'</td>';
                    echo '<td>'.$this->Form->input('num',array('type'=>'hidden','value'=>1)).'</td>';
                    echo '<td>'.$this->Form->end('Προσθήκη Φωτογραφίας').'</td>';
                    echo '</tr>';
             }
             
             if($hotspecie['HotSpecie']['additional_photo2'] != null)
             {  
                    echo '<tr>';
                    echo '<td>'.$this->Html->image($hotspecie['HotSpecie']['additional_photo2']."?".time()).'</td>';
                    echo '<td>'.$this->Html->link('Set as main photo', array('action'=>'setMainPhoto',$hotspecie['HotSpecie']['id'],2)).'</td>';
                    echo '<td>'.$this->Html->link('Delete photo', array('action'=>'deleteImg',$hotspecie['HotSpecie']['id'],2)).'</td></tr>';
             }
             else {
                    echo '<tr>';
                    echo $this->Form->create('HotSpecie', array('action' => 'addImg', "enctype" => "multipart/form-data"));
                    echo $this->Form->error('image');
                    echo '<td>'.$this->Form->input('image',array("type" => "file",'label'=>'Πρόσθετη Φωτογραφία 2')).'</td>';
                    echo '<td>'.$this->Form->input('id',array('type'=>'hidden','value'=>$hotspecie['HotSpecie']['id'])).'</td>';
                    echo '<td>'.$this->Form->input('num',array('type'=>'hidden','value'=>2)).'</td>';
                    echo '<td>'.$this->Form->end('Προσθήκη Φωτογραφίας').'</td>';
                    echo '</tr>';
             }
             
             if($hotspecie['HotSpecie']['additional_photo3'] != null)
             {  
                    echo '<tr>';
                    echo '<td>'.$this->Html->image($hotspecie['HotSpecie']['additional_photo3']."?".time()).'</td>';
                    echo '<td>'.$this->Html->link('Set as main photo', array('action'=>'setMainPhoto',$hotspecie['HotSpecie']['id'],3)).'</td>';
                    echo '<td>'.$this->Html->link('Delete photo', array('action'=>'deleteImg',$hotspecie['HotSpecie']['id'],3)).'</td></tr>';
             }
             else {
                 echo '<tr>';
                    echo $this->Form->create('HotSpecie', array('action' => 'addImg', "enctype" => "multipart/form-data"));
                    echo $this->Form->error('image');
                    echo '<td>'.$this->Form->input('image',array("type" => "file",'label'=>'Πρόσθετη Φωτογραφία 3')).'</td>';
                    echo '<td>'.$this->Form->input('id',array('type'=>'hidden','value'=>$hotspecie['HotSpecie']['id'])).'</td>';
                    echo '<td>'.$this->Form->input('num',array('type'=>'hidden','value'=>3)).'</td>';
                    echo '<td>'.$this->Form->end('Προσθήκη Φωτογραφίας').'</td>';
                    echo '</tr>';
             }
                 
             
             
             
                 
            
             ?>
   

    </table>

<?php echo $this->Session->flash(); ?>
   
                    </div>
			</div>
        </div>
