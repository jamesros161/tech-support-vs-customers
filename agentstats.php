<?php
// core configuration
define('GAME_LOADED', true);
include_once "config/core.php";
include_once "objects/game/agents.php";
include_once "libs/php/utils.php";
include_once "config/database.php";
 
// set page title
$page_title="Agent Stats";
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
 
    // content once logged in
        $db = new Database();
        $player_agent = new Agent($db);
        $isPlayerAgent = $player_agent->playerAgentExists();
        if ( $isPlayerAgent ) {
            ?>
            <div id="agent-stats-summary-div">
            <table id="agent_stats_summary" class="table table-dark">
                <tr>
                    <td class="center-align">Agent Name:</td><td class="left-align"><?php echo $player_agent->firstname;?></td>
                    <td class="center-align">Agent Level:</td><td><?php echo $player_agent->level;?></td>
                    <td class="center-align">XP to Level Up:</td><td><?php echo $player_agent->xptolvlup;?></td>
                </tr>
                <tr>
                    <td class="center-align">Average Handling Time:</td><td class="left-align"><?php echo $player_agent->aht;?></td>
                    <td class="center-align">AHT Cost Per Turn:</td><td class="left-align"><?php echo $player_agent->ahtcost;?></td>
                    <td class="center-align">Hackerman Points:</td><td class="left-align"><?php echo $player_agent->hmp;?></td>
                </tr>
            </table>
            </div><!--End agent-stats-summary-div -->
            
            <div id="agent-stats-div-left" class="flex-space-around">
                <div class="stat-col">
                <table class="table table-sm">
                    <tr>
                        <td>Strength</td>
                        <td><?php echo $player_agent->strength->value;?></td>
                        <td></td>
                    </tr>
                    <?php
                        foreach ($player_agent->strength->skill_names as $skill_name){
                        echo "<tr><td></td><td>".$player_agent->strength->{$skill_name}[0]."</td><td>".$player_agent->strength->{$skill_name}[1]."</td></tr>";
                        }
                    ?>
                    <tr>
                        <td>Dexterity</td>
                        <td><?php echo $player_agent->dexterity->value;?></td>
                        <td></td>
                    </tr>
                    <?php
                        foreach ($player_agent->dexterity->skill_names as $skill_name){
                        echo "<tr><td></td><td>".$player_agent->dexterity->{$skill_name}[0]."</td><td>".$player_agent->dexterity->{$skill_name}[1]."</td></tr>";
                        }
                    ?>
                    <tr>
                        <td>Constitution</td>
                        <td><?php echo $player_agent->constitution->value;?></td>
                        <td></td>
                    </tr>
                    <?php
                        foreach ($player_agent->constitution->skill_names as $skill_name){
                        echo "<tr><td></td><td>".$player_agent->constitution->{$skill_name}[0]."</td><td>".$player_agent->constitution->{$skill_name}[1]."</td></tr>";
                        }
                    ?>
                </table>
                </div><!--End agent-stats-div-left -->
                
                <div id="agent-stats-div-right" class="stat-col">
                <table class="table table-sm">
                    <tr>
                        <td>Intelligence</td>
                        <td><?php echo $player_agent->intelligence->value;?></td>
                        <td></td>
                    </tr>
                    <?php
                        foreach ($player_agent->intelligence->skill_names as $skill_name){
                        echo "<tr><td></td><td>".$player_agent->intelligence->{$skill_name}[0]."</td><td>".$player_agent->intelligence->{$skill_name}[1]."</td></tr>";
                        }
                    ?>
                    <tr>
                        <td>Wisdom</td>
                        <td><?php echo $player_agent->wisdom->value;?></td>
                        <td></td>
                    </tr>
                    <?php
                        foreach ($player_agent->wisdom->skill_names as $skill_name){
                        echo "<tr><td></td><td>".$player_agent->wisdom->{$skill_name}[0]."</td><td>".$player_agent->wisdom->{$skill_name}[1]."</td></tr>";
                        }
                    ?>
                    <tr>
                        <td>Charisma</td>
                        <td><?php echo $player_agent->charisma->value;?></td>
                        <td></td>
                    </tr>
                    <?php
                        foreach ($player_agent->charisma->skill_names as $skill_name){
                        echo "<tr><td></td><td>".$player_agent->charisma->{$skill_name}[0]."</td><td>".$player_agent->charisma->{$skill_name}[1]."</td></tr>";
                        }
                    ?>
                </table>
                </div><!--End agent-stats-div-right -->
            </div>
            <?php
        }
        else {
            // If user hasn't created an agent, redirect to new agent roll
            Utils::redirect("/newagent.php?action=initial_roll");
        }
 
echo "</div>";
 
// footer HTML and JavaScript codes
include 'template/layout_foot.php';
?>

