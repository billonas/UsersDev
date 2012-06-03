<?php echo $this->Html->css(array('main', 'jquery-ui', 'forms')); ?>       
 <?php $this->set('title_for_layout', 'Προσθήκη Νέου/Ανακοίνωσης - ΕΛΚΕΘΕ');?>
        
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
<h2>Προσθήκη Νέου/Ανακοίνωσης</h2>
<?php 
        echo $this->Form->create('New', array('action' => 'create', "enctype" => "multipart/form-data")); 
        echo $this->Form->input('title');
        echo $this->Form->input('body', array('rows' => '3'));
        echo $this->Form->end('Προσθήκη Νέου');  
?>
                    </div>
			</div>
        </div>
