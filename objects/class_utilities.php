<?php
if (!defined('GAME_LOADED')){
    header("location:index.php");
    die();
}

class GameUtil {

    public static function roll($qty, $sides) {
        $result = array();
        foreach (range(1, $qty) as $x) {
            array_push($result, rand(1,$sides));
        }
        return $result;
    }

}