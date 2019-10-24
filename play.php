<?php
namespace Game;
// core configuration
define('GAME_LOADED', true);
require('config/game_includes.php');
 
$db = new Config\Database(); 

// set page title
$page_title="Active Contact";
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
if(isset($_POST)) {
    $contact = $_POST['contact'];
    $contact = json_decode($contact);
    if($contact) {
        $attacks = new Objects\Attacks();
        $attack_types = $attacks->types;
        $avail_attacks = $attacks->get_available($contact);
        $issue_res = new Objects\IssueResolutions();
        $avail_issue_res = $issue_res->get_available($contact);
        $customer_stances = new Objects\CustomerStances();
        $avail_stances = $customer_stances->get_available();
    }
    else {
        trigger_error("Cannot load new contact:", E_USER_ERROR);
    }
    ?>
    <div id="initial-contact-data" style="display:none">
    <p id="contact"><?php echo json_encode($contact);?></p>
    <p id="attack-types"><?php echo json_encode($attack_types);?></p>
    <p id="avail-attacks"><?php echo json_encode($avail_attacks);?></p>
    <p id="issue-resolutions"><?php echo json_encode($avail_issue_res);?></p>
    <p id="customer-stances"><?php echo json_encode($avail_stances);?></p>
    </div>
    <div id="play_container">
        <div id="top_bar">
            <div id="agent-stats">
                <div class="flex-between">
                    <h3 class="agent-stats-header">Support Agent</h3>
                    <h4 id="agent-sub-header"></h4>
                </div>
                    <div class="flex-center">
                        <table class="table table-responsive table-bordereless">
                            <tr>
                                <td class="stats-label table-active">Level</td><td id="level" class="value table-primary"></td>
                                <td class="stats-label table-active">AHT</td><td id="aht" class="value table-primary"></td>
                                <td class="stats-label table-active">HMP</td><td id="hmp" class="value table-primary"></td>
                                <td class="stats-label table-active">AHT Cost</td><td id="aht-cost" class="value table-primary"></td>
                            </tr>
                        </table>
                    </div>
                    <div id="agent-prof-div">
                        <table class="table table-responsive table-borderless table-sm">
                            <tr id="agent-prof-labels"></tr>
                            <tr id="agent-prof-values"></tr>
                        </table>
                    </div>
            </div>
            <div id="cx-stats">
                <div class="flex-between">
                    <h3 id="cx-stats-header">Customer</h3>
                    <h4 id="cx-sub-header"></h4>
                </div>
                <div class="flex-center">
                    <table class="table table-responsive table-borderedless">
                        <tr>
                            <td class="stats-label table-active">Cx Proficiency</td><td id="cx_proficiency" class="value table-success"></td>
                            <td class="stats-label table-active">Cx HP</td><td id="chp" class="value table-success"></td>
                            <td class="stats-label table-active">Issue HP</td><td id="ihp" class="value table-success"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div id="content" class="container overflow-auto">
            <p id="contact_opening"></p>
            <table id="messages" class="table table-condense table-borderless"></table>
        </div>
        <div id="action_bar">
            <div id="attacks">
                <form>
                <div id="attacks-div" class="flex-center"></div>
                <div id="attack-desc" class="flex-center"><p style="min-height:1em"></p></div>
                </form>
            </div>
            <div id="issue-resolutions">
                <form>
                <div id="issue-resolutions-div" class="flex-center"></div>
                </form>
            </div>
            <div id="issue-res"></div>
            <div id="special-actions"></div>
            <div id="internal-tools"></div>
        </div>
    </div>
<?php
}
// else if (isset($_SESSION['contact'])) {
//     $contact = $_SESSION['contact'];
// }
// else {
//     trigger_error("contact not found in SESSION or POST", E_USER_ERROR);
// }




// $internal_tools = new InternalTools();
// $avail_internal_tools = $internal_tools->get_available($contact);

// $special_actions = new SpecialActions();
// $avail_special_actions = $special_actions->get_available($contact);

// $customer_stance = new CustomerStance();
// $current_stance = $customer_stance->get_current_stance($contact->stance);

// print_r($category);
// print_r($avail_attacks);
// print_r($avail_issue_res);
// print_r($avail_internal_tools);
// print_r($avail_special_actions);
// print_r($current_stance);



echo "</div>";
 
// footer HTML and JavaScript codes
include 'template/layout_foot.php';
?>