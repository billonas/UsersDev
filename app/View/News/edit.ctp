<?php echo $this->Html->css(array('main', 'jquery-ui', 'forms')); ?>       
 <?php $this->set('title_for_layout', 'Επεξεργασία Νέων/Ανακοινώσεων - ΕΛΚΕΘΕ');?>       
      	<div class="middle_row">
			<div class="middle_wrapper">
					<div align="center">
<h2>Επεξεργασία Νέου/Ανακοίνωσης</h2>
<?php   echo $this->Form->create('New', array('action' => 'edit', "enctype" => "multipart/form-data")); 
        echo $this->Form->input('title');
        echo $this->Form->input('body', array('rows' => '3'));
        echo $this->Form->input('id', array('type' => 'hidden'));
        echo $this->Form->end('Αποθήκευση');
?>
                    </div>
			</div>
        </div>