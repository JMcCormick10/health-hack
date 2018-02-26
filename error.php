<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 */

ini_set('display_errors',0);



function errHandle($errno,$errmsg,$filename,$linenum,$vars){

    $errortype = array(
        E_ERROR => "Error",
        E_WARNING => "warning",
        'E_PARSE' => "parse error",
        "E_NOTICE" => "Notice",
        E_USER_ERROR => " user Error",
        E_USER_WARNING => "user warning",
        E_USER_NOTICE => "user Notice"
    );

    $dt = date('Y-m-d H:i:s');
    $err = "Error reporting\n";
    $err .= "\t Date Time: " . $dt . "\n";
    $err .= "\t Error Number: " . $errno . "\n";
    $err .= "\t Error Type: " . "[$errno]" . "\n";
    $err .= "\t Error Message: " . $errmsg . "\n";
    $err .= "\t file name: " . $filename . "\n";
    $err .= "\t Error line number: " . $linenum . "\n";
    $err .= "End reporting\n";


    error_log($err,3, dirname(__FILE__). '/ErrorLog/error.log');

    header("Location: http://localhost:81/health-hack/404page.php");
}


set_error_handler("errHandle");


?>