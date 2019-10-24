<?php
// core configuration
define('GAME_LOADED', true);
include_once "config/core.php";
include_once "objects/game/agents.php";
include_once "objects/game/gameutils.php";
include_once "config/database.php";
include_once "libs/php/utils.php";
 
$db = new Database(); 

// set page title
$page_title="Level Up Agent";
error_log("page_title " . $page_title, 4);
// include login checker
$require_login=true;
include_once "login_checker.php";
 
// include page header HTML
include_once 'template/layout_head.php';
 
echo "<div class='col-md-12'>";
 
    // to prevent undefined index notice
    $action = isset($_GET['action']) ? $_GET['action'] : "";
 
    // if login was successful
    if($action=='login_success'){
        echo "<div class='alert alert-info'>";
            echo "<strong>Hi " . $_SESSION['firstname'] . ", welcome back!</strong>";
        echo "</div>";
    }
 
    // if user is already logged in, shown when user tries to access the login page
    else if($action=='already_logged_in'){
        echo "<div class='alert alert-info'>";
            echo "<strong>You are already logged in.</strong>";
        echo "</div>";
    }
    else if($action=='level_up') {
        $agent = new Agent($db->getConnection());
        $agent->playerAgentExists();
        $initial_roll = json_decode($agent->initial_roll);
        $level = $agent->level;
        $sum_initial_roll = array_sum($initial_roll);
        $total_additional_points = ( $level - 1 ) * 10;
        $total_points_assigned = array_sum(array(
            $agent->strength->value,
            $agent->dexterity->value,
            $agent->constitution->value,
            $agent->intelligence->value,
            $agent->wisdom->value,
            $agent->charisma->value
            ));
        $avail_points = $total_additional_points - ( $total_points_assigned - $sum_initial_roll);
 ?>
     <div id="agent-level-up">
        <p id="initial_roll_values" style="display:none"><?php echo json_encode($initial_roll);?></p>
        <form id="agent-level-up-form" action="" method='get'>
            <table class="table table-responsive">
                <tr>
                    <td></td>
                    <td>Points Available to Spend</td>
                    <td id="points-avail"><?php echo $avail_points;?></td>
                </tr>
                <tr>
                    <td>Strength</td>
                    <td id="strength-original-value" >Current Value: <?php echo $agent->strength->value;?>
                    <input type="hidden" name="strength-original-value" value="<?php echo $agent->strength->value;?>"></td>
                    <td><input type="text" name="strength" id="strength-input" value="0" class="attribute-input"></input></td>
                    <td><p id="strength-total" class="attribute-total"><?php echo $agent->strength->value;?></p></td>
                    <td><span>Skills: </span>
                        <?php
                        $skill_names=$agent->strength->skill_names;
                        foreach ($skill_names as $skill_name) {
                            if ($skill_names[0] != $skill_name) {
                                echo "<span>, ".$agent->strength->get_skill_display_name($skill_name)."<span>";
                            }
                            else {
                                echo "<span>".$agent->strength->get_skill_display_name($skill_name)."<span>";
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Dexterity</td>
                    <td id="dexterity-original-value" >Current Value: <?php echo $agent->dexterity->value;?>
                    <input type="hidden" name="dexterity-original-value" value="<?php echo $agent->dexterity->value;?>"></td>
                    <td><input type="text" name="dexterity" id="dexterity-input" value="0" class="attribute-input"></input></td>
                    <td><p id="dexterity-total" class="attribute-total" ><?php echo $agent->dexterity->value;?></p></td>
                    <td><span>Skills: </span>
                        <?php
                        $skill_names=$agent->dexterity->skill_names;
                        foreach ($skill_names as $skill_name) {
                            if ($skill_names[0] != $skill_name) {
                                echo "<span>, ".$agent->dexterity->get_skill_display_name($skill_name)."<span>";
                            }
                            else {
                                echo "<span>".$agent->dexterity->get_skill_display_name($skill_name)."<span>";
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Constitution</td>
                    <td id="constitution-original-value" >Current Value: <?php echo $agent->constitution->value;?>
                    <input type="hidden" name="constitution-original-value" value="<?php echo $agent->constitution->value;?>"></td>
                    <td><input type="text" name="constitution" id="constitution-input" value="0" class="attribute-input"></input></td>
                    <td><p id="constitution-total" class="attribute-total" ><?php echo $agent->constitution->value;?></p></td>
                    <td><span>Skills: </span>
                        <?php
                        $skill_names=$agent->constitution->skill_names;
                        foreach ($skill_names as $skill_name) {
                            if ($skill_names[0] != $skill_name) {
                                echo "<span>, ".$agent->constitution->get_skill_display_name($skill_name)."<span>";
                            }
                            else {
                                echo "<span>".$agent->constitution->get_skill_display_name($skill_name)."<span>";
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Intelligence</td>
                    <td id="intelligence-original-value" >Current Value: <?php echo $agent->intelligence->value;?>
                    <input type="hidden" name="intelligence-original-value" value="<?php echo $agent->intelligence->value;?>"></td>
                    <td><input type="text" name="intelligence" id="intelligence-input" value="0" class="attribute-input"></input></td>
                    <td><p id="intelligence-total" class="attribute-total"><?php echo $agent->intelligence->value;?></p></td>
                    <td><span>Skills: </span>
                        <?php
                        $skill_names=$agent->intelligence->skill_names;
                        foreach ($skill_names as $skill_name) {
                            if ($skill_names[0] != $skill_name) {
                                echo "<span>, ".$agent->intelligence->get_skill_display_name($skill_name)."<span>";
                            }
                            else {
                                echo "<span>".$agent->intelligence->get_skill_display_name($skill_name)."<span>";
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Wisdom</td>
                    <td id="wisdom-original-value" >Current Value: <?php echo $agent->wisdom->value;?>
                    <input type="hidden" name="wisdom-original-value" value="<?php echo $agent->wisdom->value;?>"></td>
                    <td><input type="text" name="wisdom" id="wisdom-input" value="0" class="attribute-input"></input></td>
                    <td><p id="wisdom-total" class="attribute-total" ><?php echo $agent->wisdom->value;?></p></td>
                    <td><span>Skills: </span>
                        <?php
                        $skill_names=$agent->wisdom->skill_names;
                        foreach ($skill_names as $skill_name) {
                            if ($skill_names[0] != $skill_name) {
                                echo "<span>, ".$agent->wisdom->get_skill_display_name($skill_name)."<span>";
                            }
                            else {
                                echo "<span>".$agent->wisdom->get_skill_display_name($skill_name)."<span>";
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Charisma</td>
                    <td id="charisma-original-value" >Current Value: <?php echo $agent->charisma->value;?>
                    <input type="hidden" name="charisma-original-value" value="<?php echo $agent->charisma->value;?>"></td>
                    <td><input type="text" name="charisma" id="charisma-input" value="0" class="attribute-input"></input></td>
                    <td><p id="charisma-total" class="attribute-total" ><?php echo $agent->charisma->value;?></p></td>
                    <td><span>Skills: </span>
                        <?php
                        $skill_names=$agent->charisma->skill_names;
                        foreach ($skill_names as $skill_name) {
                            if ($skill_names[0] != $skill_name) {
                                echo "<span>, ".$agent->charisma->get_skill_display_name($skill_name)."<span>";
                            }
                            else {
                                echo "<span>".$agent->charisma->get_skill_display_name($skill_name)."<span>";
                            }
                        }
                        ?>
                    </td>
                </tr>
                <input id='action' type='hidden' name='action' value='update_skill_points'>
                <input type='hidden' name='initial_roll' value='<?php echo json_encode($initial_roll);?>'>
 
        <tr>
            <td></td><td></td><td></td>
            <td>
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span> Set Core Attributes
                </button>
            </td>
            <td id="validation-error"></td>
        </tr>
            </table>
        
        </form>
    </div>
 <?php
    }
    
    else if($action=='update_skill_points') {
        $agent = new Agent($db->getConnection());
        $agent->playerAgentExists();
        ?>
        
        <div id="agent-level-up">
        <form id="agent-level-up-form" action="levelup.php" method='POST'>
            <table class="table table-responsive">
            <tr>
                <th>Core Attribute</th>
                <th>Skill</th>
                <th>Points Assigned</th>
                <th>Points Available</th>
            </th>
        <?php
            $attributes = array();
            foreach (  $_GET as $attribute => $value ){
                if ( strpos($attribute, '-value') !== false )  {
                    $attr_name = explode( '-', $attribute )[0];
                    $orig_value = $value;
                    $new_attr_value = $value + $_GET[$attr_name];
                    if ($orig_value > 10) {
                        $skill_points_assigned = $orig_value - 10;
                    }
                    else {
                        $skill_points_assigned = 0;
                    }
                    $total_skill_points = $new_attr_value - 10;
                    $skill_points_avail = $total_skill_points - $skill_points_assigned;
                    // echo 'attr_name: ' . $attr_name. '</br>orig_value: '.$value. '</br>new_value: '.$new_attr_value.'<br>';
                    // echo 'total_pts_assigned: '. $skill_points_assigned . '</br>total_skill_points_earned: ' . $total_skill_points . '<br>avail_points: 
                    if ( $skill_points_avail > 0 ) {
                        array_push($attributes, $attr_name);
                        ?>
                        <tr>
                            <td><?php echo ucfirst($attr_name);?></td>
                            <td></td>
                            <td><?php echo $skill_points_assigned;?></td>
                            <td id="<?php echo $attr_name;?>-pts-avail"><?php echo $skill_points_avail;?></td>
                        </tr>
                        <?php
                            $skill_names = $agent->$attr_name->skill_names;
                            foreach ($skill_names as $skill_name) {
                                ?>
                                <tr>
                                <td><input type=hidden name='<?php echo $attr_name; ?>' value='<?php echo $new_attr_value;?>'</td>
                                <td><?php echo $agent->$attr_name->get_skill_display_name($skill_name);?></td>
                                <td id="<?php echo $skill_name;?>-pts-assigned"><?php echo $agent->$attr_name->$skill_name[1];?></td>
                                <td><input type=text class='<?php echo $attr_name;?>-pts-assigned form-control' required value='0' name='<?echo $skill_name;?>'></td>
                                <td><input type=hidden id='<?php echo $skill_name;?>-total' class='form-control' required value='0' name='<?echo $skill_name;?>-total'></td>
                                <?php
                            }
                        echo "<tr><td></td><td></td><td></td><td></td></tr>";
                    }
                    else {
                        echo '<input type=hidden name="'.$attr_name.'" value="'.$value.'">';
                    }
                }
                
            }
            ?>
            <tr>
                <td><p id="attribute-list" style="display:none"><?php echo json_encode($attributes);?></p></td>
                <td><input type=hidden id='action' name="action" value="apply_levelup"></td>
                <td><button type="submit" class="btn btn-primary">Assign Skill Points</button>
                    <input type=hidden hame="initial_roll" value="<?php echo $_GET['initial_roll'];?>">
                </td>
                <td><p id="validation-error"></p></td>
            </tr>
            </table>
        </form>
        </div>
        
        <?php
        unset($_GET);
    }
    else if($_POST){
        if($_POST['action'] !== 'apply_levelup') {
            Utils::redirect('/agentstats.php');
        }
        // get database connection
        $database = new Database();
        $db = $database->getConnection();
     
        // initialize objects
        $agent = new Agent($db);
        $agent->playerAgentExists();
    
        // set values to object properties
        $agent->strength->value=$_POST['strength'];
        foreach ($agent->strength->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->strength->{$skill_name}[1] = $_POST[$skill_name.'-total'];
            }
        }
        $agent->dexterity->value=$_POST['dexterity'];
        foreach ($agent->dexterity->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->dexterity->{$skill_name}[1] = $_POST[$skill_name.'-total'];
            }
        }
        $agent->constitution->value=$_POST['constitution'];
        foreach ($agent->constitution->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->constitution->{$skill_name}[1] = $_POST[$skill_name.'-total'];
            }
        }
        $agent->intelligence->value=$_POST['intelligence'];
        foreach ($agent->intelligence->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->intelligence->{$skill_name}[1] = $_POST[$skill_name.'-total'];
            }
        }
        $agent->wisdom->value=$_POST['wisdom'];
        foreach ($agent->wisdom->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->wisdom->{$skill_name}[1] = $_POST[$skill_name.'-total'];
            }
        }
        $agent->charisma->value=$_POST['charisma'];
        foreach ($agent->charisma->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->charisma->{$skill_name}[1] = $_POST[$skill_name.'-total'];
            }
        }
        $agent->level_up();
    
    }

echo "</div>";
 
// footer HTML and JavaScript codes
include 'template/layout_foot.php';
?>