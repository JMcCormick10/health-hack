<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-05
 * Time: 5:27 PM
 */

function convertToNull($string){
    if ($string == "0"){
        return null;
    }
    else {
        return $string;
    }
}