<?php echo $this->Html->css(array('main')); ?>       
 <?php $this->set('title_for_layout', 'Προσθήκη νέου - ΕΛΚΕΘΕ');?>
        
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
<h2>Προσθήκη Νέου</h2>
<?php echo $this->Form->create('Analyst', array('action' => 'create_news')); ?>
          <?php
             
             echo $this->Form->error('title');
             echo $this->Form->input('title',array('label'=>'Τίτλος νέου','div'=>'input[type=text]','id'=>'info'));
             echo $this->Form->error('body');
             echo $this->Form->input('body',array("type" => "textarea",'label'=>'Περιεχόμενο'));
             echo $this->Form->input('date_added',array('type'=>'hidden'));
           ?>
<?php echo $this->Form->end('Προσθήκη Νέου');?>
<?php echo $this->Session->flash(); ?>
                    </div>
			</div>
        </div>