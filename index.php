<?php
/*
*   title : index.php
*   usage : Main landing page. Verifies that CX is logged in, and has created
*            an agent. If user has not created an agent, redirects to newagent.php
*            If user has created an agent, it redirects to agentstats.php
*   todos : N/A
*/
    namespace Game;
    define('GAME_LOADED', true);
    require("config/game_includes.php");
    // core configuration
    include_once "objects/game/agents.php";
    //include_once "config/database.php";
     
    // set page title
    $page_title="Index";
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
 
    // PAGE CONTENT
        $db = new Config\Database();
        $player_agent = new Objects\Agent($db->getConnection());
        $isPlayerAgent = $player_agent->playerAgentExists();
        if ( $isPlayerAgent ) {
            Libs\Utils::redirect("agentstats.php");
        }
        else {
            Libs\Utils::redirect("newagent.php?action=initial_roll");
        }
    // END PAGE CONTENT
    
    echo "</div>";
 
    // footer HTML and JavaScript codes
    include 'template/layout_foot.php';
?>

