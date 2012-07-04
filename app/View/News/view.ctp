<?php echo $this->Html->css(array('main')); ?>        
<?php $this->set('title_for_layout', 'Τα Νέα Μας - ΕΛΚΕΘΕ');?>
        
      	<div class="middle_row">
            <div class="middle_wrapper">
                <div class="login_box white_box no_small_padding">
                    <h1>Παρουσίαση νέων/ανακοινώσεων</h1>
                <?php if(empty($news)): ?>
                    Δεν έχουν καταχωρηθεί Νέα/Ανακοινώσεις
                <?php else: ?>
                    <?php foreach ($news as $new): ?>
                        <div class="news_wrapper">
                            <span class="news_date">Προστέθηκε: <?php echo $new['New']['created'] ?></span>
                            <span class="news_title"><?php echo $new['New']['title'] ?></span>
                            <span class="news_text"><?php echo $new['New']['body'] ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
