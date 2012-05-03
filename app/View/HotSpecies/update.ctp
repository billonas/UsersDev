<h2>Επεξεργασία Είδους</h2>
<?php echo $this->Form->create('HotSpecie', array('action' => 'update', "enctype" => "multipart/form-data")); ?>
       <fieldset>
          <legend>Επεξεργασία Είδους</legend>
          <?php echo $this->Session->flash(); ?>
          <?php
             echo $this->Form->input('id', array('type' => 'hidden'));
             echo $this->Html->image($hotspecie['HotSpecie']['main_photo']);
             echo $this->Form->error('scientific_name');
             echo $this->Form->input('scientific_name',array('label'=>'Επιστημονική ονομασία'));
             echo $this->Form->error('description');
             echo $this->Form->input('description',array("type" => "textarea",'label'=>'Περιγραφή είδους'));
          ?>
       </fieldset>
<?php echo $this->Form->end('Αποθήκευση');?>