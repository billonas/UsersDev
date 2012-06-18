<?php
/**
 * @author darkmatter 
 */
?>
<?php echo $this->Html->css(array('main', 'jquery-ui', 'table', 'jquery.tablesorter.pager.css')); ?>
<?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'jquery.tablesorter.min', 'jquery.tablesorter.pager.js', 'googlemaps.js')); ?>
<script>    
    $(document).ready(function()
    { 
        $("#pager button, .buttonContainer a, #filterContainer form input[type='submit'], #filterContainer form button[type='submit'], #createUserLink a").button();
        
        $("#reportsTable").tablesorter({sortList: [[0,1]]})  //sort the first column in descending order
            .tablesorterPager({container: $("#pager")});
        
        positionPagerButtons();
    } 
);
    
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
            case 'hypernalyst':
                target = '/analyst/show/' + id;
                break;
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
                <div id="createUserLink">
                    <a class="" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'create')) ?>">
                        Δημιουργία Αναλυτή
                    </a>
                </div>
                <div id="filterContainer">
                    <?php echo $this->Form->create('User', array('action' => 'edit_users', 'type'=>'get')); ?>
                        <table>                        
                            <tr>
                                <td>
                                    <input name="text" type="text" class="" id="filterTerm"/>
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
                                    <input id="searchAnalyst" type="checkbox" value="analyst" name="userType1" checked/>
                                    <label for="searchAnalyst">Αναλυτές <span class="tag analyst"></span></label>
                                </td>
                                <td>
                                    <input id="searchSimple" type="checkbox" value="simple"  name="userType2" checked/>
                                    <label for="searchSimple">Απλοί Χρήστες <span class="tag basic"></span></label>
                                </td>
                                <td>
                                    <input id="searchHyperanalyst" type="checkbox" value="hyperanalyst"  name="userType3" checked/>
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
                            <th>Ενέργειες</th>
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
                            <tr class="item user <?php echo $userType ?>" onclick="item_onclick(<?php echo $user['User']['id'] ?>, <?php echo $userType?>)">
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
                                            <a class="editButton" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'show', $user['User']['id'])) ?>">
                                                Προβολή
                                            </a>
                                        <?php endif; ?>
                                        <!-- Delete user button-->
                                        <?php if ($userType==='basic'): ?>
                                            <a class="deleteButton" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'delete', $user['User']['id'])) ?>">
                                                <img class="icon" src="../img/whiteX.png"/>
                                                Διαγραφή
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
                                            <a class="upgradeButton" href="<?php echo $this->Html->url(array('controller'=>'analyst', 'action'=>'upgrade', $user['User']['id'])) ?>">
                                                <img class="icon" src="../img/blackUpArrow.png"/>
                                                Αναβάθμιση
                                            </a>
                                        <?php endif; ?>
                                        <!-- Downgrade analyst button-->
                                        <?php if ($userType==='analyst'): ?>
                                            <a class="downgradeButton" href="<?php echo $this->Html->url(array('controller'=>'analysts', 'action'=>'downgrade', $user['User']['id'])) ?>">
                                                <img class="icon" src="../img/blackDownArrow.png"/>
                                                Υποβάθμιση
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
                        <input type="text" class="pagedisplay"/>
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

