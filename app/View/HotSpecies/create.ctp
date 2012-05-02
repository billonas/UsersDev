<h2>HotSpecies - Create</h2>
<?php echo $this->Form->create('HotSpecie', array('action' => 'create', "enctype" => "multipart/form-data")); ?>
       <fieldset>
          <legend>Add New HotSpecies</legend>
          <?php
             echo $this->Form->error('main_photo');
             echo $this->Form->input('image',array("type" => "file"));
             echo $this->Form->hidden('main_photo');
             echo $this->Form->error('scientific_name');
             echo $this->Form->input('scientific_name');
             echo $this->Form->error('description');
             echo $this->Form->input('description',array("type" => "textarea"));
          ?>
       </fieldset>
<?php echo $this->Form->end('Add Hot Species');?>