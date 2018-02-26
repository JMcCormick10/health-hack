<?php
    require_once('../redirect.php');
    require_once('../Models/Database.php');
    require_once('../Models/Calendar.php');
    date_default_timezone_set('America/Toronto');

    $db = new Database();
    $db = $db->getDbFromAWS();

    $calendar = new Calendar(date('m'), date('Y'), $_SESSION["user"]);
    $calendar->setDb($db);

    $action = 'Index';

    if ($action == 'Index') {
        include('ViewIndex.php');
    }
?>