<?php $this->set('title_for_layout', 'Σελίδα υπεραναλυτή - ΕΛΚΕΘΕ');?> 
 
    <div class="middle_row  big_row">
			<div class="middle_wrapper">
				<div class="register_box login_box" align="center">
			 		<br/><h1>Σελίδα υπεραναλυτή</h1></br>
                                    <div class="link_holder"><strong>
<?php      echo $this->Html->link('Eπεξεργασία χρηστών', '/users/edit_users?textType=surname&text=&userType1=analyst&userType2=simple&userType3=hyperanalyst') ?>
                                        </strong>
                                    </div>
                                    </br>
                                    <div class="link_holder">
                                        <strong>
<?php      echo $this->Html->link('Επεξεργασία Νέων', array('controller' => 'news', 'action'=>'show')); ?>
                                        </strong>
                                    </div>
                                    </br>
                                    <div class="link_holder">
                                        <strong>
<?php      echo $this->Html->link('Επεξεργασία ειδών-στόχων', array('controller' => 'hotSpecies', 'action'=>'show')); ?>
                                        </strong>
                                    </div>
                                </div>
                                    </br>
			</div>
    </div>
        <div class="comments">
            <div><br />Powered by <a href="http://cakephp.org/">Cake.php</a>, <a href="http://jquery.com/">jQuery</a> and <a href="http://modernizr.com/">Modernizr</a>.</div>
        </div>
