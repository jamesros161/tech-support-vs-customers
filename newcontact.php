<?php
// core configuration
define('GAME_LOADED', true);
require('config/game_includes.php');
 
// set page title
$page_title="New Contact";
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
        $db = new Game\Config\Database();
        $player_agent = new Game\Objects\Agent($db);
        $isPlayerAgent = $player_agent->playerAgentExists();
        if ( $isPlayerAgent ) {
            $contact = new Game\Objects\Contact($player_agent);
            ?>
            <table class="table table-responsive">
            <tr><td class="align-right bold">Issue:</td><td><?php echo $contact->issue_string;?></td><td></td></tr>
            <tr><td class="align-right bold">Category:</td><td><?php echo $contact->category;?></td><td></td></tr>
            <tr><td>Agent Status</td><td></td><td>Name: <?php echo $contact->agent_name;?></td></tr>
            <tr><td class="align-right">AHT: </td><td><?php echo $contact->aht;?></td><td></td></tr>
            <tr><td class="align-right">HMP: </td><td><?php echo $contact->hmp;?></td><td></td></tr>
            <tr><td>Customer / Issue Status</td><td></td><td>Name: <?php echo $contact->customer_name;?></td></tr>
            <tr><td class="align-right">Customer HP: </td><td><?php echo $contact->chp;?></td><td></td></tr>
            <tr><td class="align-right">Issue HP: </td><td><?php echo $contact->ihp;?></td><td></td></tr>
            <tr><td class="align-right">Customer Stance: </td><td><?php echo $contact->customer->stance;?></td><td></td></tr>
            </table>
            <form action="/play.php" method="POST">
                <input type=hidden name="action" value="answer_contact">
                <input type=hidden name="contact" value="<?php echo htmlspecialchars(strip_tags(json_encode($contact)));?>">
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Answer Contact</button>
            </form>
            <?php
        }
        else {
            Utils::redirect("/newagent.php?action=initial_roll");
        }
 
echo "</div>";
 
// footer HTML and JavaScript codes
include 'template/layout_foot.php';
?>

