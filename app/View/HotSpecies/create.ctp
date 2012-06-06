<?php echo $this->Html->css(array('main', 'jquery-ui', 'forms')); ?>       
 <?php $this->set('title_for_layout', 'Παρουσίαση δημοφιλών ειδών - ΕΛΚΕΘΕ');?>
        
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
<h2>Προσθήκη Είδους</h2>
<?php echo $this->Form->create('HotSpecie', array('action' => 'create', "enctype" => "multipart/form-data")); ?>
          <?php
             echo $this->Form->error('image');
             echo $this->Form->input('image',array("type" => "file",'label'=>'Φωτογραφία'));
             echo $this->Form->input('main_photo',array('type'=>'hidden'));
             //echo $this->Form->error('image1');
             echo $this->Form->input('image1',array("type" => "file",'label'=>'Φωτογραφία'));
             echo $this->Form->input('additional_photo1',array('type'=>'hidden'));
             echo $this->Form->error('scientific_name');
             echo $this->Form->input('scientific_name',array('label'=>'Επιστημονική ονομασία','div'=>'input[type=text]','id'=>'info'));
             echo $this->Form->error('description');
             echo $this->Form->input('description',array("type" => "textarea",'label'=>'Περιγραφή είδους'));  
           ?>
<?php echo $this->Form->end('Προσθήκη Είδους');?>
<?php echo $this->Session->flash(); ?>
                    </div>
			</div>
        </div>