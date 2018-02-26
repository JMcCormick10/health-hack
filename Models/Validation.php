<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-09
 * Time: 4:32 PM
 */
class Validation
{

    public function testName($string)
    {
        if (preg_match('/\w+/', $string)) {
            return true;
        } else {
            return false;
        }
    }
    public function testEmail($string)
    {
        if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    public function testPhone($string){
        if (preg_match('/^\(?[0-9]{3}(-|\)| )?[0-9]{3}(-| )?[0-9]{4}$/', $string)){
            return true;
        }
        else{
            return false;
        }
    }
    function testPostal($string){
        if (preg_match('/^[a-z]\d[a-z]\s\d[a-z]\d$/i', $string)){
            return true;
        }
        else {
            return false;
        }
    }
    public function testZero($string){
        if ($string == 0){
            return false;
        }
        else {
            return true;
        }
    }
}
?>