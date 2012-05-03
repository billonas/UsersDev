<h2>Προσθήκη Είδους</h2>
<?php echo $this->Form->create('HotSpecie', array('action' => 'create', "enctype" => "multipart/form-data")); ?>
       <fieldset>
          <legend>Προσθήκη Είδους</legend>
          <?php echo $this->Session->flash(); ?>
          <?php
             echo $this->Form->error('image');
             echo $this->Form->input('image',array("type" => "file",'label'=>'Φωτογραφία'));
             echo $this->Form->input('main_photo',array('type'=>'hidden'));
             echo $this->Form->error('scientific_name');
             echo $this->Form->input('scientific_name',array('label'=>'Επιστημονική ονομασία'));
             echo $this->Form->error('description');
             echo $this->Form->input('description',array("type" => "textarea",'label'=>'Περιγραφή είδους'));  
           ?>
       </fieldset>
<?php echo $this->Form->end('Προσθήκη Είδους');?>