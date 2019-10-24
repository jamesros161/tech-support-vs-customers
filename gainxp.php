<?php
/*
*   title : gainxp.php
*   usage : handles ajax requests from game application to apply XP gained.
*   todos : N/A
*/

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

    // to prevent undefined index notice
    $action = isset($_GET['action']) ? $_GET['action'] : "";

    // if POST is set
    if (isset($_POST)) {
        $db = new Database();
        $agent = new Agent($db->getConnection());
        $agent->playerAgentExists();
        $existing_xptolvlup = $agent->xptolvlup;
        $new_xptolvlup = $existing_xptolvlup - $_POST['xp'];
        if ( $new_xptolvlup > 0 ) { //if the xp gain does not result in new level
            $applied_xp = $agent->apply_xp_gain($new_xptolvlup); 
            if ( $applied_xp === true ) {
                echo "XP Gain Applied";
            }
            else {
                echo "XP Gain Failed";
            }
        }
        else { //if the xp gain results in level up, apply level up
            $applied_xp = $agent->apply_lvl_up();
        }
    }

?>