<?php
require_once '../Models/Database.php';
require_once '../Models/Calendar.php';

session_start();
ob_start();
$db = new Database();
$db = $db->getDbFromAWS();
$calendar = new Calendar(date('m'), date('Y'), $_SESSION["user"]);
$calendar->setDb($db);
$jcat;
if ($calendar->getDefaultGym() == false) {
    $jcat = json_encode(array('msg' => 'No gym is currently selected'));
}
else {
    $hours = $calendar->getDefaultGymTime();
    $jcat = json_encode($hours);
}



header("Content-Type: application/json");
echo $jcat;