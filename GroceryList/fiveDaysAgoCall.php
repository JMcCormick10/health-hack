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
$fiveDaysAgo = $gListConn->populateFiveDaysAgo($db, $passId);

//placeholder array
$fiveDaysArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

foreach ($fiveDaysAgo as $entry) {
    $fiveDaysArr['calories'] += $entry->calories;
    $fiveDaysArr['fat'] += $entry->fat;
    $fiveDaysArr['cholesterol'] += $entry->cholesterol;
    $fiveDaysArr['sodium'] += $entry->sodium;
    $fiveDaysArr['carbs'] += $entry->carbs;
    $fiveDaysArr['protein'] += $entry->protein;
}

$jcat = json_encode($fiveDaysArr);

header("Content-Type: application/json");
echo $jcat;


?>
