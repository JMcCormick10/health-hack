<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-09
 * Time: 6:19 PM
 */

function timeFormat($string1, $string2, $string3){
    if ($string1 >=0 && $string1 <=9){
        $string1 = 0 . $string1;
    }
    if ($string2 >=0 && $string2 <=9){
        $string2 = 0 . $string2;
    }
    if ($string3 >=0 && $string2 <=9){
        $string3 = 0 . $string3;
    }
    return $string1 . ":" . $string2 .":" .  $string3;
}
?>