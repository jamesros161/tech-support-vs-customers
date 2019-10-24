<?php

namespace Game\Libs;

class Utils{
    
    public static function redirect($url) {
        $string = '<script type="text/javascript">';
        $string .= 'window.location = "' . $url . '"';
        $string .= '</script>';
        echo $string;
    }
}