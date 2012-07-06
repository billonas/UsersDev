<?php
/**
 * @author darkmatter 
 */
?>
<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'googlemaps.js', 'jquery.metadata')); ?>
<?php $this->set('title_for_layout', 'Επεξεργασία Χρηστών - ΕΛΚΕΘΕ');?>  


<script>    
    
    
    
    $(document).ready(function()
    {  
        $('.item a.deleteButton').click(function(e) {
            e.stopPropagation();
            return confirm('Είστε βέβαιος/η ότι θέλετε να διαγράψετε αυτόν τον χρήστη;');
        });
        
        $('.item a.upgradeAnalyst').click(function(e) {
            e.stopPropagation();
            return confirm('Είστε βέβαιος/η ότι θέλετε να αναβαθμίσετε αυτόν τον αναλυτή σε υπεραναλυτή;');
        });
        
        $('.item a.downgradeAnalyst').click(function(e) {
            e.stopPropagation();
            return confirm('Είστε βέβαιος/η ότι θέλετε να υποβαθμίσετε αυτόν τον αναλυτή;');
        });
        
        // Create button styles
        $("#pager button, .buttonContainer a, #filterContainer form input[type='submit'], #filterContainer form button[type='submit'], #createUserLink a").button();    
        
        $("#reportsTable").tablesorter(
            {
                sortList: [[0,1]], //sort the first column in descending order
                headers: {}
            }).tablesorterPager({container: $("#pager")});
        
        positionPagerButtons();
    });
    
    function positionPagerButtons()
    {
        // Correct tablesorterPager's tyrranic styling
        $('#pager').attr('style', '');
    }
    
    function item_onclick(id, type)
    {
        var target = '';
        switch (type)
        {
            case 'basic':
                target = 'show/' + id;
                break;
            case 'analyst':
            case 'hyperanalyst':
                target = '/analysts/update/' + id;
                break;
            default:
                throw "Invalid user type: " + type;
        }
        
        window.location.href = target;
    }
</script>
<div class="middle_row">
    <div class="middle_wrapper">
        <div>
            <div class="login_box">  
                <p><?php //echo print_r($reports)?></p>
            <h1>Επεξεργασία Χρηστών</h1>
            <div class="flash_box gradient">
                <?php echo $this->Session->flash().'</br>';?>
            </div>
            
            <div id="tableOuterWrapper">
                <div id="createUserLink" class="tableTopButtonContainer">
                    <a class="" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'create')) ?>">
                        Δημιουργία Αναλυτή
                    </a>
                </div>
                <div id="filterContainer">
                    <?php echo $this->Form->create('User', array('action' => 'edit_users', 'type'=>'get')); ?>
                        <table>                        
                            <tr>
                                <td>
                                    <select class="std_form" name="textType" id="filterType">
                                        <?php if(!isset($textType) || $textType==='') $textType='surname'; //Default is surname ?>
                                        <option value="username" <?php if ($textType==='username') echo 'selected="selected"'; ?> >Όνομα χρήστη</option>
                                        <option value="name" <?php if ($textType==='name') echo 'selected="selected"'; ?> >Όνομα</option>
                                        <option value="surname" <?php if ($textType==='surname') echo 'selected="selected"'; ?> >Επώνυμο</option>
                                        <option value="email" <?php if ($textType==='email') echo 'selected="selected"'; ?> >Ηλεκτρονική Διεύθυνση</option>
                                    </select>
                                </td>
                                <td>
                                    <input name="text" type="text" class="std_form" id="filterTerm" value="<?php if(isset($text))echo $text;?>"/>
                                </td>
                                <td>
                                    <button type="submit" value="Αναζήτηση">
                                        <img src="../img/whiteSpyglass.png"/>
                                        Αναζήτηση
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td>
                                    <input id="searchAnalyst" type="checkbox" value="analyst" name="userType1" <?php if(isset($checkboxes['userType1'])) if($checkboxes['userType1']) echo 'checked'; ?>/>
                                    <label for="searchAnalyst">Αναλυτές <span class="tag analyst"></span></label>
                                </td>
                                <td>
                                    <input id="searchSimple" type="checkbox" value="simple"  name="userType2" <?php if(isset($checkboxes['userType2'])) if($checkboxes['userType2']) echo 'checked'; ?>/>
                                    <label for="searchSimple">Απλοί Χρήστες <span class="tag basic"></span></label>
                                </td>
                                <td>
                                    <input id="searchHyperanalyst" type="checkbox" value="hyperanalyst"  name="userType3" <?php if(isset($checkboxes['userType3'])) if($checkboxes['userType3']) echo 'checked'; ?>/>
                                    <label for="searchHyperanalyst">Υπερχρήστες <span class="tag hyperanalyst"></span></label>
                                </td>
                            </tr>
                        </table>
                    <?php echo $this->Form->end(); ?>
                </div>
                <?php if (empty($users)): ?>
                <div class="user noItemsFiller">
                    <h2><center>Δεν υπάρχει κανένας εγγεγραμένος χρήστης</center></h2>
                </div>
                <?php else: ?>
                <table id="reportsTable" class="tablesorter reportsTable">
                    <thead>
                        <tr>
                            <th>Ημερομηνία Δημιουργίας Χρήστη</th>
                            <th>Τύπος Χρήστη</th>
                            <th>Όνομα</th>
                            <th>Επώνυνο</th>
                            <th>Ψευδώνυμο</th>
                            <th class="{sorter: false}">Ενέργειες</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <?php
                            // Determine user class
                            $userType = "basic"; // classes are {"basic", "analyst", "hyperanalyst"}
                            if ( isset($user['User']['user_type']) )
                            {
                                switch ($user['User']['user_type'])
                                {
                                    case "simple":
                                        $userType = "basic";
                                        break;
                                    case "analyst":
                                        $userType = "analyst";
                                        break;
                                    case "hyperanalyst":
                                        $userType = "hyperanalyst";
                                        break;
                                }
                            }
                        ?>
                            <tr class="item clickable user <?php echo $userType ?>" onclick="item_onclick(<?php echo $user['User']['id'] ?>, '<?php echo $userType?>')">
                                <td class="leftmost">
                                    <?php echo $user['User']['created'] ?>
                                </td>
                                <td>
                                    <?php
                                        switch ($user['User']['user_type'])
                                        {
                                            case 'simple':
                                                echo 'Απλός';
                                                break;
                                            case 'analyst':
                                                echo 'Αναλυτής';
                                                break;
                                            case 'hyperanalyst':
                                                echo 'Υπεραναλυτής';
                                                break;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $user['User']['name'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $user['User']['surname'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $user['User']['username'];
                                    ?>
                                </td>
                                <td class="rightmost">
                                    <div class="buttonContainer">
                                        <!-- Show basic user button-->
                                        <?php if ($userType==='basic'): ?>
                                            <a class="editButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'show', $user['User']['id'])) ?>">
                                                Προβολή
                                            </a>
                                        <?php endif; ?>
                                        <!-- Show analyst button-->
                                        <?php if ($userType==='analyst' || $userType==='hyperanalyst'): ?>
                                            <a class="editButton" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'update', $user['User']['id'])) ?>">
                                                <?php if ($userType==='analyst') : ?>
                                                    Επεξεργασία
                                                <?php elseif ($userType==='hyperanalyst'): ?>
                                                    Προβολή
                                                <?php endif; ?>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <!-- Upgrade basic user button-->
                                        <?php if ($userType==='basic'): ?>
                                            <a class="upgradeButton" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'create', $user['User']['id'])) ?>">
                                                <img class="icon" src="../img/blackUpArrow.png"/>
                                                Αναβάθμιση
                                            </a>
                                        <?php endif; ?>
                                        <!-- Upgrade analyst button-->
                                        <?php if ($userType==='analyst'): ?>
                                            <a class="upgradeButton upgradeAnalyst" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'upgrade', $user['User']['id'])) ?>">
                                                <img class="icon" src="../img/blackUpArrow.png"/>
                                                Αναβάθμιση
                                            </a>
                                        <?php endif; ?>
                                        <!-- Downgrade analyst button-->
                                        <?php if ($userType==='analyst'): ?>
                                            <a class="downgradeButton downgradeAnalyst" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'downgrade', $user['User']['id'])) ?>">
                                                <img class="icon" src="../img/blackDownArrow.png"/>
                                                Υποβάθμιση
                                            </a>
                                        <?php endif; ?>
                                        <!-- Delete user button-->
                                        <?php if ($userType==='basic' || $userType ==='analyst'): ?>
                                            <a class="deleteButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'delete', $user['User']['id']))?>" >
                                                <img class="icon" src="../img/whiteX.png"/>
                                                Διαγραφή
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pager" class="pager">
                    <form>
                        <button class="first">Αρχή</button>
                        <button class="prev">Προηγούμενο</button>
                        <input type="text" class="pagedisplay" readonly="readonly"/>
                        <select style="visibility: hidden" class="pagesize" onchange="positionPagerButtons">
                                <option selected="selected" value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                        </select>
                        <button class="next">Επόμενο</button>
                        <button class="last">Τέλος</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            <br/>   
        </div>
    </div>
</div>

