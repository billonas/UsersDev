<?php $this->set('title_for_layout', 'Διαγραφή λογαριασμού Χρήστη - ΕΛΚΕΘΕ');?>
    	
		<div class="middle_row">
        	<div class="middle_wrapper">
                <div class="login_box white_box">  
                    				<br><h1>Διαγραφή Λογαριασμού</h1></br>
																		
                    <?php echo $this->Form->create('User', array('action' => 'delete_account')); ?>
                                    <div class="flash_box gradient"><?php echo $this->Session->flash().'</br>'; ?></div>
                        <table>                        
                            <tr>
                                    <label for="searchAnalyst">Είστε σίγουρος ότι θέλετε να διαγράψετε το λογαριασμό σας;<span class="tag analyst"></span></label>
                            </tr>
                            <tr>
                                <td>
    <?php //echo $this->Form->checkbox('confirmDelete', array('label'=>'Ndfjdkfjd')); 
                                  echo $this->Form->input('User.confirmDelete',array( 'label' => 'Ναι είμαι σίγουρος', 'type' => 'checkbox'));
                                  echo $this->Form->input('User.post_id', array('type' => 'hidden', 'value' => $post_id));
?>
                                </td>
                            </tr>
                        </table>
                    <?php 
										  echo '<p>'.$this->Form->end(array(
														'label' => 'Διαγραφή',
														'div' => false,
                                                                                                                'class' => 'std_form')).'</p>';									  
                    ?>
                                    <div class="link_holder">
                                        <strong>
                                    <?php echo $this->Html->link('Επιστροφή στις ρυθμίσεις λογαριασμού', array('controller' => 'users', 'action'=>'account'));?>
                                        </strong>
                                    </div>
                </div>
        </div>
	    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
