<?php

//$user_id = 1;
//$list_id = 5;

require_once '../redirect.php';

//grab  user id, username
$id = $userId->user_id;
$list_id = $userId->list_id;

//db
require_once "../Models/Database.php";
$dbConn = new Database();
$db = $dbConn->getDbFromAWS();

require_once "../Models/FoodEntriesLunch.php";
$lunch = new FoodEntriesLunch();
$lunch->setUsersId($id);

//include groceryList DAO
require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();
$gLists = $gListConn->populateGroceryLists($db);
$userList = $gListConn->populateUserListId($db);
$todaysEntries = $gListConn->populateTodaysFoodEntries($db, $lunch);
$weeksEntries = $gListConn->populateWeeksFoodEntries($db, $lunch);
$sixDaysAgo = $gListConn->populateSixDaysAgo($db, $lunch);
$fiveDaysAgo = $gListConn->populateFiveDaysAgo($db, $lunch);
$fourDaysAgo = $gListConn->populateFourDaysAgo($db, $lunch);
$threeDaysAgo = $gListConn->populateThreeDaysAgo($db, $lunch);
$twoDaysAgo = $gListConn->populateSixDaysAgo($db, $lunch);
$todaysBreakfast = $gListConn->populateTodaysBreakfast($db, $lunch);
$todaysLunch = $gListConn->populateTodaysLunch($db, $lunch);
$todaysDinner = $gListConn->populateTodaysDinner($db, $lunch);
$todaysSnacks = $gListConn->populateTodaysSnacks($db, $lunch);

if($list_id == 0){
    header('Location: ../GroceryList/Grocery.php');
} elseif($list_id == 5) {
    $list = $gListConn->populateVeggieList($db);
} elseif ($list_id == 6) {
    $list = $gListConn->populateAtkinsList($db);
} else {
    $list = $gListConn->populateGlutenFreeList($db);
}

//include the header
require_once "../Common Views/Header.php";

//include the sidebar
require_once "../Common Views/sidebar.php";

//empty vars prior to submit
$food_item_id = "";
$meal = "";
$servings_count = "";
$timestamp = "";
$cals_total = "";

$totalCalsB = "";
$totalCalsL = "";
$totalCalsD = "";
$totalCalsS = "";

$todayArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

foreach ($todaysEntries as $today) {
    $todayArr['calories'] += $today->calories;
    $todayArr['fat'] += $today->fat;
    $todayArr['cholesterol'] += $today->cholesterol;
    $todayArr['sodium'] += $today->sodium;
    $todayArr['carbs'] += $today->carbs;
    $todayArr['protein'] += $today->protein;
}

$fatDV = round(($todayArr['fat'] / 65) * 100);
$cholesterolDV = round(($todayArr['cholesterol'] / 300) * 100);
$sodiumDV = round(($todayArr['sodium'] / 2400) * 100);
$carbsDV = round(($todayArr['carbs'] / 300) * 100);


if(isset($_POST['foodEntrySubmit'])) {

    //include the getter and setter for the food entry file
    require_once "../Models/FoodEntry.php";

    //set the vars
    $food_item_id = $_POST["food-item-selected"];
    $meal = $_POST["meal"];
    $servings_count = $_POST["severing"];
    //$time = new DateTime();
    //$timestamp = $time->format('Y-m-d H:i:s');
    $timestamp = date("Y-m-d");
    $user_id = 1;

    //setting the values
    $foodEntryGetSet = new FoodEntry();
    $foodEntryGetSet->setFoodItemId($food_item_id);
    $foodEntryGetSet->setMeal($meal);
    $foodEntryGetSet->setServingsCount($servings_count);
    $foodEntryGetSet->setTimestamp($timestamp);
    $foodEntryGetSet->setUserId($user_id);

    //var_dump($foodEntryGetSet->getUserId());
    $gListConn->userFoodEntry($db, $foodEntryGetSet);

}

?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">
    <div id="loading" class="padding-top-75">
        <div class="col-12">
            <div id="loading-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 236.01 109.76"><defs><style>.logo-loading</style></defs><title>Asset 1</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><polygon class="logo-loading" points="24.7 14.58 24.7 42.53 0 42.53 0 67.23 24.7 67.23 24.7 95.18 49.4 95.18 49.4 14.58 24.7 14.58"/><polygon class="logo-loading2" points="158 0 158 42.53 78 42.53 78 0 53.3 0 53.3 109.76 78 109.76 78 67.23 158 67.23 158 109.76 182.7 109.76 182.7 0 158 0"/><rect class="logo-loading3" x="186.6" y="14.58" width="24.7" height="80.61"/><rect class="logo-loading3" x="211.3" y="42.53" width="24.7" height="24.7"/></g></g>
                </svg>
            </div>
        </div>
        <h4 class="col-5 padding-top-75">We are just compiling your data. Please wait a moment while we collect your results</h4>
    </div>
    <div id="stats">
        <div class="col-md-12 row">
            <div class="col-md-4">
                <h4 class="text-center padding-top-75">Comparative Daily Nutrition Intake</h4>
                <canvas id="nutritionChart"></canvas>
            </div>
            <div class="col-md-4">
                <h4 class="text-center padding-top-75">Comparative Weekly Nutrition Intake</h4>
                <canvas id="weeklyNutritionChart"></canvas>
            </div>
        </div>
        <!------>
        <div class="col-md-10">
            <h4 class="text-center padding-top-75">Weekly Results</h4>
            <canvas id="weekResults"></canvas>
        </div>
        <!------>
        <div class="col-md-10">
            <div class="col-md-12 col-sm-12 col-12 row">
                <h4 class="col-md-12 col-sm-12 col-12 padding-top-75">Today's DV% Intakes</h4>
                <div class="col-md-6 col-sm-6 col-8">
                    <h2 class="text-center">Fat DV% Intake Total</h2>
                    <div class="progress">
                        <div id="fat-progress" class="progress-bar" role="progressbar" aria-valuenow="<?php echo $fatDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $fatDV ?>%;">
                            <span id="fat-num"><?php echo $fatDV ?></span>%
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-8">
                    <h2 class="text-center">Cholesterol DV% Intake Total</h2>
                    <div class="progress">
                        <div id="chol-progress" class="progress-bar" role="progressbar" aria-valuenow="<?php echo $cholesterolDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $cholesterolDV ?>%;">
                            <span id="chol-num"><?php echo $cholesterolDV ?></span>%
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-8">
                    <h2 class="text-center">Sodium DV% Intake Total</h2>
                    <div class="progress">
                        <div id="sodium-progress" class="progress-bar" role="progressbar" aria-valuenow="<?php echo $sodiumDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $sodiumDV ?>%;">
                            <span id="sodium-num"><?php echo $sodiumDV ?></span>%
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-8">
                    <h2 class="text-center">Carbs DV% Intake Total</h2>
                    <div class="progress">
                        <div id="carbs-progress" class="progress-bar" role="progressbar" aria-valuenow="<?php echo $carbsDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $carbsDV ?>%;">
                            <span id="carbs-num"><?php echo $carbsDV ?></span>%
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="col-md-10">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>
        <div class="row">
            <a href="index.php" class="btn btn-info btn-lg offset-md-2">
                <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
            </a>
        </div>
    </div>
</div>
</main>


<?php
require_once '../Common Views/Footer.php';
?>

<script src="../Scripts/nutrition.js"></script>
<script src="../Scripts/progress.js"></script>
