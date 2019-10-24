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
$page_title="New Agent Creator";
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
    else if($action=='initial_roll') {
        $initial_roll = GameUtils::roll(6, 20);
        $agent = new Agent($db->getConnection());
 ?>
     <div id="agent-creator">
        <p id="initial_roll_values" style="display:none"><?php echo json_encode($initial_roll);?></p>
        <form id="agent-creator-form" action="" method='get'>
            <table class="table table-responsive">
                <tr>
                    <td width="15px">Initial Roll: </td>
                    <td width="20px" id="initial_roll">
                    <?php
                        foreach ($initial_roll as $number) {
                            echo "<span>" . $number . "&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td>Firstname</td>
                    <td><input type='text' name='firstname' class='form-control' required/></td>
                </tr>
                <tr>
                    <td>Strength</td>
                    <td>
                        <select name='strength'>
                <?php
                foreach ($initial_roll as $number) {
                    echo '<option value="'.$number.'">'.$number.'</option>';
                }
                ?>
                        </select>
                    </td>
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
                    <td>
                        <select name='dexterity'>
                <?php
                foreach ($initial_roll as $number) {
                    echo '<option value="'.$number.'">'.$number.'</option>';
                }
                ?>
                        </select>
                    </td>
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
                    <td>
                        <select name='constitution'>
                <?php
                foreach ($initial_roll as $number) {
                    echo '<option value="'.$number.'">'.$number.'</option>';
                }
                ?>
                        </select>
                    </td>
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
                    <td>
                        <select name='intelligence'>
                <?php
                foreach ($initial_roll as $number) {
                    echo '<option value="'.$number.'">'.$number.'</option>';
                }
                ?>
                        </select>
                    </td>
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
                    <td>
                        <select name='wisdom'>
                <?php
                foreach ($initial_roll as $number) {
                    echo '<option value="'.$number.'">'.$number.'</option>';
                }
                ?>
                        </select>
                    </td>
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
                    <td>
                        <select name='charisma'>
                <?php
                foreach ($initial_roll as $number) {
                    echo '<option value="'.$number.'">'.$number.'</option>';
                }
                ?>
                        </select>
                    </td>
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
                <input id='action' type='hidden' name='action' value='assign_skill_points'>
                <input type='hidden' name='initial_roll' value='<?php echo json_encode($initial_roll);?>'>
 
        <tr>
            <td></td><td></td>
            <td>
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span> Set Core Attributes
                </button>
            </td>
        </tr>
            </table>
        
        </form>
    </div>
 <?php
    }
    
    else if($action=='assign_skill_points') {
        ?>
        
        <div id="agent-creator">
        <form id="agent-creator-form" action="newagent.php" method='POST'>
            <table class="table table-responsive">
        <?php
            $attributes = array();
            foreach (  $_GET as $attribute => $value ){
                if ( $attribute != 'firstname' || $attribute != 'action' || $attribute != 'initial_roll')  {
                    if ( $value > 10 ) {
                        array_push($attributes, $attribute);
                        ?>
                        <tr>
                            <td><?php echo $attribute;?></td>
                            <td><p class="<?php echo $attribute;?>-pts-avail" style="display:none"><?php echo $value - 10;?></td>
                            <td><?php echo "Skill Points Avail: ".($value - 10);?></td>
                        </tr>
                        <?php
                            $agent = new Agent($db->getConnection());
                            $skill_names = $agent->$attribute->skill_names;
                            foreach ($skill_names as $skill_name) {
                                ?>
                                <tr>
                                <td><input type=hidden name='<?php echo $attribute; ?>' value='<?php echo $value;?>'</td>
                                <td><?php echo $agent->$attribute->get_skill_display_name($skill_name);?></td>
                                <td><input type=text class='<?php echo $attribute;?>-pts-assigned form-control' required value='0' name='<?echo $skill_name;?>'></td>
                                <?php
                            }
                    }
                    else {
                        echo '<input type=hidden name="'.$attribute.'" value="'.$value.'">';
                    }
                }
            }
            ?>
            <tr>
                <td><p id="attribute-list" style="display:none"><?php echo json_encode($attributes);?></p></td>
                <td><input type=hidden id='action' name="action" value="submit_new_agent"></td>
                <td><input type=hidden hame="initial_roll" value="<?php echo $_GET['initial_roll'];?>"></td>
                <td><button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span> Assign Skill Points
                </button></td>
            </tr>
            </table>
        </form>
        </div>
        
        <?php
        unset($_GET);
    }
    
if($_POST){
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // initialize objects
    $agent = new Agent($db);

    // check if email already exists
    if($agent->playerAgentExists()){
        echo "<div class='alert alert-danger'>";
            echo "You already have an Agent Created";
        echo "</div>";
    }
 
    else{
        // set values to object properties
        $agent->strength->value=$_POST['strength'];
        foreach ($agent->strength->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->strength->{$skill_name}[1] = $_POST[$skill_name];
            }
        }
        $agent->dexterity->value=$_POST['dexterity'];
        foreach ($agent->dexterity->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->dexterity->{$skill_name}[1] = $_POST[$skill_name];
            }
        }
        $agent->constitution->value=$_POST['constitution'];
        foreach ($agent->constitution->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->constitution->{$skill_name}[1] = $_POST[$skill_name];
            }
        }
        $agent->intelligence->value=$_POST['intelligence'];
        foreach ($agent->intelligence->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->intelligence->{$skill_name}[1] = $_POST[$skill_name];
            }
        }
        $agent->wisdom->value=$_POST['wisdom'];
        foreach ($agent->wisdom->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->wisdom->{$skill_name}[1] = $_POST[$skill_name];
            }
        }
        $agent->charisma->value=$_POST['charisma'];
        foreach ($agent->charisma->skill_names as $skill_name) {
            if(isset($_POST[$skill_name])) {
                $agent->charisma->{$skill_name}[1] = $_POST[$skill_name];
            }
        }
        $agent->firstname=$_POST['firstname'];
        $agent->initial_roll=$_POST['initial_roll'];
        $agent->create();
        Utils::redirect('/agentstats.php');
    }
}
echo "</div>";
 
// footer HTML and JavaScript codes
include 'template/layout_foot.php';
?>