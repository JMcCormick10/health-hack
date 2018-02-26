<?php

require_once '../redirect.php';

//grab  user id, username
$id = $userId->user_id;
$list_id = $userId->list_id;

//db
require_once "../Models/Database.php";
$dbConn = new Database();
$db = $dbConn->getDbFromAWS();

require_once "../Models/FoodEntriesLunch.php";
$passId = new FoodEntriesLunch();
$passId->setUsersId($id);

//include groceryList DAO
require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();

$threeDaysAgo = $gListConn->populateThreeDaysAgo($db, $passId);

$threeDaysArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

foreach ($threeDaysAgo as $entry) {
    $threeDaysArr['calories'] += $entry->calories;
    $threeDaysArr['fat'] += $entry->fat;
    $threeDaysArr['cholesterol'] += $entry->cholesterol;
    $threeDaysArr['sodium'] += $entry->sodium;
    $threeDaysArr['carbs'] += $entry->carbs;
    $threeDaysArr['protein'] += $entry->protein;
}

$jcat = json_encode($threeDaysArr);

header("Content-Type: application/json");
echo $jcat;



?>
