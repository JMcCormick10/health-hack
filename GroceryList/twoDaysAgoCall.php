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

$twoDaysAgo = $gListConn->populateTwoDaysAgo($db, $passId);

$twoDaysArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

foreach ($twoDaysAgo as $entry) {
    $twoDaysArr['calories'] += $entry->calories;
    $twoDaysArr['fat'] += $entry->fat;
    $twoDaysArr['cholesterol'] += $entry->cholesterol;
    $twoDaysArr['sodium'] += $entry->sodium;
    $twoDaysArr['carbs'] += $entry->carbs;
    $twoDaysArr['protein'] += $entry->protein;
}

$jcat = json_encode($twoDaysArr);

header("Content-Type: application/json");
echo $jcat;



?>
