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

$weeksEntries = $gListConn->populateWeeksFoodEntries($db, $passId);

$weekArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

//var_dump($todaysEntries[2]->fat);

foreach ($weeksEntries as $entry) {
    $weekArr['calories'] += $entry->calories;
    $weekArr['fat'] += $entry->fat;
    $weekArr['cholesterol'] += $entry->cholesterol;
    $weekArr['sodium'] += $entry->sodium;
    $weekArr['carbs'] += $entry->carbs;
    $weekArr['protein'] += $entry->protein;
}

//extract($weekArr);
//echo "\$calories = $calories; \$fat = $fat; \$cholesterol = $cholesterol; \$sodium = $sodium; \$carbs = $carbs; \$protein = $protein; ";

$jcat = json_encode($weekArr);

header("Content-Type: application/json");
echo $jcat;



?>