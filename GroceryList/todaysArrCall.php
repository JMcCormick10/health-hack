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

$todaysEntries = $gListConn->populateTodaysFoodEntries($db, $passId);

$todayArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

//var_dump($todaysEntries[2]->fat);

foreach ($todaysEntries as $today) {
    $todayArr['calories'] += $today->calories;
    $todayArr['fat'] += $today->fat;
    $todayArr['cholesterol'] += $today->cholesterol;
    $todayArr['sodium'] += $today->sodium;
    $todayArr['carbs'] += $today->carbs;
    $todayArr['protein'] += $today->protein;
}

$jcat = json_encode($todayArr);

header("Content-Type: application/json");
echo $jcat;
//print_r($todayArr);


?>