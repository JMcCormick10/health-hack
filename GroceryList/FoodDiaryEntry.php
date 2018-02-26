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
$lunch = new FoodEntriesLunch();
$lunch->setUsersId($id);

//include groceryList DAO
require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();
$gLists = $gListConn->populateGroceryLists($db);
$userList = $gListConn->populateUserListId($db);
//$todaysEntries = $gListConn->populateTodaysFoodEntries($db);
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

$totalCalsB = ""; $totalServingsB = ""; $totalProteinB = ""; $totalCarbssB = "";
$totalCalsL = ""; $totalServingsL = ""; $totalProteinL = ""; $totalCarbssL = "";
$totalCalsD = ""; $totalServingsD = ""; $totalProteinD = ""; $totalCarbssD = "";
$totalCalsS = ""; $totalServingsS = ""; $totalProteinS = ""; $totalCarbssS = "";


if(isset($_POST['foodEntrySubmit'])) {

    //include the getter and setter for the food entry file
    require_once "../Models/FoodEntry.php";
    $foodEntryGetSet = new FoodEntry();

    //set the vars
    $food_item_id = $_POST["food-item-selected"];
    $meal = $_POST["meal"];
    $servings_count = $_POST["severing"];

    //$time = new DateTime();
    //$timestamp = $time->format('Y-m-d H:i:s');
    $timestamp = date("Y-m-d");
    //$user_id = 1;

    //setting the values
    $foodEntryGetSet->setFoodItemId($food_item_id);
    $foodEntryGetSet->setMeal($meal);
    $foodEntryGetSet->setServingsCount($servings_count);
    $foodEntryGetSet->setTimestamp($timestamp);
    $foodEntryGetSet->setUserId($id);

    //var_dump($foodEntryGetSet->getUserId());
    $gListConn->userFoodEntry($db, $foodEntryGetSet);

}

?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">
    <div class="col-md-6 col-sm-8 col-10">
        <h1 class="light-grey padding-top-75">Food Tracker</h1>
        <p>Please fill out the below form to keep track of what you have been eating. This is where many of your results will populate from.</p>
    </div>
    <div class="feature col-md-10 col-sm-10 col-12">
        <form method="post" action="FoodDiaryEntry.php" id="food-diary-entry" class="col-md-7 col-sm-8 col-10">
            <div class="form-field">
                <label for="food-item-selected" class="col-md-12">Food Item Name:</label>
                <select name="food-item-selected" class="col-md-12" required>
                    <?php foreach ($list as $listOutput) { ?>
                        <option value="<?php echo $listOutput->food_item_id ?>"><?php echo $listOutput->food_item_name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-field">
                <label for="meal" class="col-md-12">Meal:</label>
                <select name="meal" class="col-md-12" required>
                    <option value="breakfast" id="breakfast">Breakfast</option>
                    <option value="lunch" id="lunch">Lunch</option>
                    <option value="dinner" id="dinner">Dinner</option>
                    <option value="snack" id="snack">Snack</option>
                </select>
            </div>
            <div class="form-field">
                <label for="severing" class="col-md-12">Severing Size:</label>
                <input type="text" name="severing" id="severing" class="col-md-12" required/>
            </div>
            <div class="form-field">
                <input id="foodEntrySubmit" name="foodEntrySubmit" type="submit" class="formSubmit" />
            </div>
        </form>
        <h4 class="text-center padding-top-75">Breakfast</h4>
        <div class="col-md-12 row">
            <div class="col-md-4 col-sm-4 col-4">
                <p><strong>Food Item</strong></p>
                <?php foreach ($todaysBreakfast as $today){ ?>
                    <div class=""><p><?php echo $today->food_item_name ?></p></div>
                <?php } ?>
                <p class="red">Total:</p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Servings</strong></p>
                <?php foreach ($todaysBreakfast as $today){ ?>
                    <div class=""><p><?php echo $today->servings_count ?></p></div>
                    <?php $totalServingsB += $today->servings_count; ?>
                <?php } ?>
                <p class="red"><?php echo $totalServingsB ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Calories</strong></p>
                <?php foreach ($todaysBreakfast as $today){ ?>
                    <div class=""><p><?php echo $today->calories ?></p></div>
                    <?php $totalCalsB += $today->calories; ?>
                <?php } ?>
                <p class="red"><?php echo $totalCalsB ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Protein</strong></p>
                <?php foreach ($todaysBreakfast as $today){ ?>
                    <div class=""><p><?php echo $today->protein ?></p></div>
                    <?php $totalProteinB += $today->protein; ?>
                <?php } ?>
                <p class="red"><?php echo $totalProteinB ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Carbs</strong></p>
                <?php foreach ($todaysBreakfast as $today){ ?>
                    <div class=""><p><?php echo $today->carbs ?></p></div>
                    <?php $totalCarbssB += $today->carbs; ?>
                <?php } ?>
                <p class="red"><?php echo $totalCarbssB ?></p>
            </div>
        </div>
        <h4 class="text-center padding-top-75">Lunch</h4>
        <div class="col-md-12 row">
            <div class="col-md-4 col-sm-4 col-4">
                <p><strong>Food Item</strong></p>
                <?php foreach ($todaysLunch as $today){ ?>
                    <div class=""><p><?php echo $today->food_item_name ?></p></div>
                <?php } ?>
                <p class="red">Total:</p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Servings</strong></p>
                <?php foreach ($todaysLunch as $today){ ?>
                    <div class=""><p><?php echo $today->servings_count ?></p></div>
                    <?php $totalServingsL += $today->servings_count; ?>
                <?php } ?>
                <p class="red"><?php echo $totalServingsL ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Calories</strong></p>
                <?php foreach ($todaysLunch as $today){ ?>
                    <div class=""><p><?php echo $today->calories ?></p></div>
                    <?php $totalCalsL += $today->calories; ?>
                <?php } ?>
                <p class="red"><?php echo $totalCalsL ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Protein</strong></p>
                <?php foreach ($todaysLunch as $today){ ?>
                    <div class=""><p><?php echo $today->protein ?></p></div>
                    <?php $totalProteinL += $today->protein; ?>
                <?php } ?>
                <p class="red"><?php echo $totalProteinL ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Carbs</strong></p>
                <?php foreach ($todaysLunch as $today){ ?>
                    <div class=""><p><?php echo $today->carbs ?></p></div>
                    <?php $totalCarbssL += $today->carbs; ?>
                <?php } ?>
                <p class="red"><?php echo $totalCarbssL ?></p>
            </div>
        </div>
        <h4 class="text-center padding-top-75">Dinner</h4>
        <div class="col-md-12 row">
            <div class="col-md-4 col-sm-4 col-4">
                <p><strong>Food Item</strong></p>
                <?php foreach ($todaysDinner as $today){ ?>
                    <div class=""><p><?php echo $today->food_item_name ?></p></div>
                <?php } ?>
                <p class="red">Total:</p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Servings</strong></p>
                <?php foreach ($todaysDinner as $today){ ?>
                    <div class=""><p><?php echo $today->servings_count ?></p></div>
                    <?php $totalServingsD += $today->servings_count; ?>
                <?php } ?>
                <p class="red"><?php echo $totalServingsD ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Calories</strong></p>
                <?php foreach ($todaysDinner as $today){ ?>
                    <div class=""><p><?php echo $today->calories ?></p></div>
                    <?php $totalCalsD += $today->calories; ?>
                <?php } ?>
                <p class="red"><?php echo $totalCalsD ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Protein</strong></p>
                <?php foreach ($todaysDinner as $today){ ?>
                    <div class=""><p><?php echo $today->protein ?></p></div>
                    <?php $totalProteinD += $today->protein; ?>
                <?php } ?>
                <p class="red"><?php echo $totalProteinD ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Carbs</strong></p>
                <?php foreach ($todaysDinner as $today){ ?>
                    <div class=""><p><?php echo $today->carbs ?></p></div>
                    <?php $totalCarbssD += $today->carbs; ?>
                <?php } ?>
                <p class="red"><?php echo $totalCarbssD ?></p>
            </div>
        </div>
        <h4 class="text-center padding-top-75">Snacks</h4>
        <div class="col-md-12 row">
            <div class="col-md-4 col-sm-4 col-4">
                <p><strong>Food Item</strong></p>
                <?php foreach ($todaysSnacks as $today){ ?>
                    <div class=""><p><?php echo $today->food_item_name ?></p></div>
                <?php } ?>
                <p class="red">Total:</p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Servings</strong></p>
                <?php foreach ($todaysSnacks as $today){ ?>
                    <div class=""><p><?php echo $today->servings_count ?></p></div>
                    <?php $totalServingsS += $today->servings_count; ?>
                <?php } ?>
                <p class="red"><?php echo $totalServingsS ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Calories</strong></p>
                <?php foreach ($todaysSnacks as $today){ ?>
                    <div class=""><p><?php echo $today->calories ?></p></div>
                    <?php $totalCalsS += $today->calories; ?>
                <?php } ?>
                <p class="red"><?php echo $totalCalsS ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Protein</strong></p>
                <?php foreach ($todaysSnacks as $today){ ?>
                    <div class=""><p><?php echo $today->protein ?></p></div>
                    <?php $totalProteinS += $today->protein; ?>
                <?php } ?>
                <p class="red"><?php echo $totalProteinS ?></p>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                <p><strong>Carbs</strong></p>
                <?php foreach ($todaysSnacks as $today){ ?>
                    <div class=""><p><?php echo $today->carbs ?></p></div>
                    <?php $totalCarbssS += $today->carbs; ?>
                <?php } ?>
                <p class="red"><?php echo $totalCarbssS ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <canvas id="skills" height="100px" width="100px"></canvas>
    </div>
    <div class="col-md-12 row">
        <a href="index.php" class="back-btn offset-md-1">
            <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
        </a>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>

<!--<script src="../Scripts/nutrition.js"></script>-->
