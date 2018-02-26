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

$sixDaysAgo = $gListConn->populateSixDaysAgo($db, $passId);

$sixDaysArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

foreach ($sixDaysAgo as $entry) {
    $sixDaysArr['calories'] += $entry->calories;
    $sixDaysArr['fat'] += $entry->fat;
    $sixDaysArr['cholesterol'] += $entry->cholesterol;
    $sixDaysArr['sodium'] += $entry->sodium;
    $sixDaysArr['carbs'] += $entry->carbs;
    $sixDaysArr['protein'] += $entry->protein;
}

$jcat = json_encode($sixDaysArr);

header("Content-Type: application/json");
echo $jcat;



?>