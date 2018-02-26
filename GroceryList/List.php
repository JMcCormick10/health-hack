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

//include groceryList DAO
require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();



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


?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">
    <div class="col-md-6 ">
        <h1 class="light-grey padding-top-75">Nutrition</h1>
        <p>Welcome to your nutrition list by Health Hack. Here you will be able to see and add to your selected list. </p>
        <p>Below you will see a list of food items that are currently in your list. If you would like to see the full nutrition facts for a food item please click on the name and it will expand to show more information. If you would like to change your grocery list please use the button below.</p>
        <!--<div class="col-md-12 row">
            <div class="col-md-7">
                <button class="buttonLink" href="Grocery.php">Select a New Grocery List</button>
            </div>
            <div class="col-md-5">
                <button class="buttonLink" href="../GroceryList/FoodDiaryEntry.php">Food Tracker</button>
            </div>
        </div>-->
    </div>

    <div class="panel-group col-md-10 col-sm-12 col-12 row" id="list-accordion">
        <?php
            foreach($list as $listOutput) {
        ?>
            <div class="panel panel-default col-md-4 col-sm-6 col-12">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#list-accordion" href="#list-item-<?php echo $listOutput->food_item_id ?>">
                            <?php echo $listOutput->food_item_name ?>
                        </a>
                    </h4>
                </div>
                <div id="list-item-<?php echo $listOutput->food_item_id ?>" class="panel-collapse collapse in">
                    <div class="panel-body row">
                        <div class="col-md-12 col-sm-12 col-12 nutrition-category">Category: <?php echo $listOutput->category ?></div>
                        <div class="col-md-12 col-sm-12 col-12 nutrition-serving-size">Serving Size <?php echo $listOutput->grams ?> g</div>
                        <div class="col-md-12 col-sm-12 col-12 row">
                            <div class="col-md-7 col-sm-7 col-7 nutrition-amount">Amount Per Serving</div>
                            <div class="col-md-5 col-sm-5 col-5 nutrition-dv">% Daily Value</div>
                        </div>
                        <div class="col-md-12"><strong>Calories</strong> <?php echo $listOutput->calories ?></div>
                        <div class="col-md-9 col-sm-9 col-9">
                            <div><strong>Total Fat</strong> <?php echo $listOutput->fat ?>g</div>
                            <div><strong>Cholesterol</strong> <?php echo $listOutput->cholesterol ?>mg</div>
                            <div><strong>Sodium</strong> <?php echo $listOutput->sodium ?>mg</div>
                            <div><strong>Total Carbs</strong> <?php echo $listOutput->carbs ?>g</div>
                            <div><strong>Protein</strong> <?php echo $listOutput->protein ?>g</div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-3">
                            <div><?php echo round(($listOutput->fat / 65) * 100) ?>%</div>
                            <div><?php echo round(($listOutput->cholesterol / 300) * 100) ?>%</div>
                            <div><?php echo round(($listOutput->sodium / 2400) * 100) ?>%</div>
                            <div><?php echo round(($listOutput->carbs / 300) * 100) ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        <div class="row col-12">
            <a href="index.php" class="btn btn-info btn-lg offset-md-5">
                <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
            </a>
        </div>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
