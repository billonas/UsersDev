<?php echo $this->Html->css(array('main')); ?>        
<?php $this->set('title_for_layout', 'Παρουσίαση Σημαντικών Ειδών - ΕΛΚΕΘΕ');?>
        
      	<div class="middle_row">
            <div class="login_box">  
                <h1>Παρουσίαση Δημοφιλών Ειδών</h1>
            </div>
            <div class="middle_wrapper specie_view">
                <?php if(empty($hotspecies)): ?>
                Δεν έχουν καταχωρηθεί Είδη Υψηλής Προτεραιότητας
                <?php else: ?>
                <?php foreach ($hotspecies as $hotspecie): ?>
                <div class="hot_specie_wrapper">
                    <div>
                        <?php echo $this->Html->image($hotspecie['HotSpecie']['main_photo'], array('alt' => 'main photo', 'class' => 'tableImage')) ?>
                    </div>
                    <div>
                        <span><?php echo $hotspecie['HotSpecie']['scientific_name'] ?></span>
                        <?php echo $hotspecie['HotSpecie']['description'] ?>
                        <div class="cl">
                           <?php 
                            
                                if(!empty($hotspecie['HotSpecie']['additional_photo1']))
                                    echo $this->Html->Image($hotspecie['HotSpecie']['additional_photo1']);
                                if(!empty($hotspecie['HotSpecie']['additional_photo2']))
                                    echo $this->Html->Image($hotspecie['HotSpecie']['additional_photo2']);
                                if(!empty($hotspecie['HotSpecie']['additional_photo3']))
                                    echo $this->Html->Image($hotspecie['HotSpecie']['additional_photo3']);
                           
                           
                           
                           ?> 
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                
            </div>
        </div>
    </div>