<?php echo $this->Html->css(array('main', 'jquery-ui', 'forms')); ?>       
 <?php $this->set('title_for_layout', 'Επεξεργασία δημοφιλών ειδών - ΕΛΚΕΘΕ');?>       
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
<h2>Επεξεργασία Είδους</h2>
<?php echo $this->Form->create('HotSpecie', array('action' => 'update', "enctype" => "multipart/form-data")); ?>
          <?php
             echo $this->Form->input('id', array('type' => 'hidden'));
             echo $this->Html->image($hotspecie['HotSpecie']['main_photo']."?".time());
             echo '</br>';
             echo $this->Html->image($hotspecie['HotSpecie']['additional_photo1']."?".time());
             echo $this->Html->link('Set as main photo', array('action'=>'setMainPhoto',$hotspecie['HotSpecie']['id'],1));
             echo $this->Form->error('scientific_name');
             echo $this->Form->input('scientific_name',array('label'=>'Επιστημονική ονομασία','div'=>'input[type=text]','id'=>'info'));
             echo $this->Form->error('description');
             echo $this->Form->input('description',array("type" => "textarea",'label'=>'Περιγραφή είδους'));
          ?>
<?php echo $this->Form->end('Αποθήκευση');?>
<?php echo $this->Session->flash(); ?>
                    </div>
			</div>
        </div>
