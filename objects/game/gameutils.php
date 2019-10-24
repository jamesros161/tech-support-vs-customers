<?php

class GameUtils {

    public static function roll($qty, $sides) {
        $result = array();
        foreach (range(1, $qty) as $x) {
            array_push($result, rand(1,$sides));
        }
        return $result;
    }

}