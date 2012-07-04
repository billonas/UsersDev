<?php $this->set('title_for_layout', 'Ρυθμίσεις Λογαριασμού χρήστη- ΕΛΚΕΘΕ');?> 
 
    <div class="middle_row  big_row">
			<div class="middle_wrapper">
				<div class="register_box login_box white_box" align="center">
			 		<br><h1>Ρυθμίσεις Λογαριασμού</h1></br>
                                    <div class="link_holder"><strong>
<?php      echo $this->Html->link('Αλλαγή διεύθυνσης ηλεκτρονικού ταχυδρομείου', array('controller' => 'users', 'action'=>'change_email')); ?>
                                        </strong>
                                    </div>
                                    </br>
                                    <div class="link_holder">
                                        <strong>
<?php      echo $this->Html->link('Αλλαγή Κωδικού', array('controller' => 'users', 'action'=>'change_password')); ?>
                                        </strong>
                                    </div>
                                    </br>
                                    <div class="link_holder">
                                        <strong>
<?php      echo $this->Html->link('Διαγραφή λογαριασμού', array('controller' => 'users', 'action'=>'delete_account', $user_id)); ?>
                                        </strong>
                                    </div>
                                </div>
                                    </br>
			</div>
    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
