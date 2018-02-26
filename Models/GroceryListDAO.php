<?php

/**
 * Created by PhpStorm.
 * User: kellyannmcnamara
 * Date: 2017-03-12
 * Time: 12:32 PM
 */


class GroceryListDAO
{
    public function populateGroceryLists($db) {
        $query_groceryLists = "SELECT * FROM GROCERY_LISTS";
        $pdo_statement = $db->prepare($query_groceryLists);
        $pdo_statement->execute();
        $groceryLists = $pdo_statement->fetchAll(PDO::FETCH_OBJ);
        return $groceryLists;
    }

    public function populateUserListId($db) {
        $query_userListId = "SELECT * FROM USERS";
        $pdo_statement = $db->prepare($query_userListId);
        $pdo_statement->execute();
        $userListId = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $userListId;
    }

    public function userSelectList($db, $g_list) {
        $query_updateListId = "UPDATE USERS SET list_id = :list_id WHERE user_id = :user_id";
        $pdo_statement = $db->prepare($query_updateListId);
        $pdo_statement->bindValue(":list_id", $g_list->getListId());
        $pdo_statement->bindValue(":user_id", $g_list->getUserId());
        $pdo_statement->execute();
        $pdo_statement->closeCursor();
}

    public function populateVeggieList($db) {
        $query_veggieList = "SELECT * FROM FOOD_ITEMS WHERE category != 'Meat'";
        $pdo_statement = $db->prepare($query_veggieList);
        $pdo_statement->execute();
        $veggieList = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $veggieList;
    }

    public function populateAtkinsList($db) {
        $query_atkinsList = "SELECT * FROM FOOD_ITEMS WHERE ((carbs * 4)/ calories) <= 0.2 OR calories <= 40";
        $pdo_statement = $db->prepare($query_atkinsList);
        $pdo_statement->execute();
        $atkinsList = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $atkinsList;
    }

    public function populateGlutenFreeList($db) {
        $query_glutenFreeList = "SELECT * FROM FOOD_ITEMS WHERE gluten_free = 1";
        $pdo_statement = $db->prepare($query_glutenFreeList);
        $pdo_statement->execute();
        $glutenFreeList = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $glutenFreeList;
    }

    public function userFoodEntry($db, $food){
        //adding content query
        $query_foodDiaryEntry = "INSERT INTO FOOD_TRACKING_LISTS (user_id, food_item_id, meal, servings_count, time_stamp)
                                  VALUES (:user_id, :food_item_id, :meal, :servings_count, :timeInput)";
        $pdo_statement = $db->prepare($query_foodDiaryEntry);
        $pdo_statement->bindValue(":user_id", $food->getUserId());
        $pdo_statement->bindValue(":food_item_id", $food->getFoodItemId());
        $pdo_statement->bindValue(":meal", $food->getMeal());
        $pdo_statement->bindValue(":servings_count", $food->getServingsCount());
        $pdo_statement->bindValue(":timeInput", $food->getTimestamp());
        $pdo_statement->execute();
        $pdo_statement->closeCursor();
    }


    public function populateWeeksFoodEntries($db, $obj){
        $query_weeksFoodEntries = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                        (calories * sum(servings_count)) AS calories, 
                                        (fat * sum(servings_count)) AS fat, 
                                        (cholesterol * sum(servings_count)) AS cholesterol, 
                                        (sodium  * sum(servings_count)) AS sodium, 
                                        (carbs * sum(servings_count)) AS carbs, 
                                        (protein * sum(servings_count)) AS protein, 
                                        meal, FOOD_TRACKING_LISTS.user_id
                                      FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                                      WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                      AND FOOD_TRACKING_LISTS.user_id = :user_id
	                                  AND time_stamp BETWEEN (CURDATE() - INTERVAL 7 DAY) AND CURDATE()
	                                  GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_weeksFoodEntries);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $weeksFoodEntries = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $weeksFoodEntries;
    }

    public function populateSixDaysAgo($db, $obj){
        $query_sixDaysAgo = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                        (calories * sum(servings_count)) AS calories, 
                                        (fat * sum(servings_count)) AS fat, 
                                        (cholesterol * sum(servings_count)) AS cholesterol, 
                                        (sodium  * sum(servings_count)) AS sodium, 
                                        (carbs * sum(servings_count)) AS carbs, 
                                        (protein * sum(servings_count)) AS protein, 
                                        meal, FOOD_TRACKING_LISTS.user_id
                                      FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                                      WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                      AND FOOD_TRACKING_LISTS.user_id = :user_id
	                                  AND time_stamp = CURDATE() - INTERVAL 6.333 DAY
	                                  GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_sixDaysAgo);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $sixDaysAgo = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $sixDaysAgo;
    }

    public function populateFiveDaysAgo($db, $obj){
        $query_fiveDaysAgo = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                        (calories * sum(servings_count)) AS calories, 
                                        (fat * sum(servings_count)) AS fat, 
                                        (cholesterol * sum(servings_count)) AS cholesterol, 
                                        (sodium  * sum(servings_count)) AS sodium, 
                                        (carbs * sum(servings_count)) AS carbs, 
                                        (protein * sum(servings_count)) AS protein, 
                                        meal, FOOD_TRACKING_LISTS.user_id
                                      FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                                      WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                      AND FOOD_TRACKING_LISTS.user_id = :user_id
	                                  AND time_stamp = CURDATE() - INTERVAL 5.333 DAY
	                                  GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_fiveDaysAgo);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $fiveDaysAgo = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $fiveDaysAgo;
    }

    public function populateFourDaysAgo($db, $obj){
        $query_fourDaysAgo = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                        (calories * sum(servings_count)) AS calories, 
                                        (fat * sum(servings_count)) AS fat, 
                                        (cholesterol * sum(servings_count)) AS cholesterol, 
                                        (sodium  * sum(servings_count)) AS sodium, 
                                        (carbs * sum(servings_count)) AS carbs, 
                                        (protein * sum(servings_count)) AS protein, 
                                        meal, FOOD_TRACKING_LISTS.user_id
                                      FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                                      WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                      AND FOOD_TRACKING_LISTS.user_id = :user_id
	                                  AND time_stamp = CURDATE() - INTERVAL 4.333 DAY
	                                  GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_fourDaysAgo);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $fourDaysAgo = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $fourDaysAgo;
    }

    public function populateThreeDaysAgo($db, $obj){
        $query_threeDaysAgo = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                        (calories * sum(servings_count)) AS calories, 
                                        (fat * sum(servings_count)) AS fat, 
                                        (cholesterol * sum(servings_count)) AS cholesterol, 
                                        (sodium  * sum(servings_count)) AS sodium, 
                                        (carbs * sum(servings_count)) AS carbs, 
                                        (protein * sum(servings_count)) AS protein, 
                                        meal, FOOD_TRACKING_LISTS.user_id
                                      FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                                      WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                      AND FOOD_TRACKING_LISTS.user_id = :user_id
	                                  AND time_stamp = CURDATE() - INTERVAL 3.333 DAY
	                                  GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_threeDaysAgo);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $threeDaysAgo = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $threeDaysAgo;
    }

    public function populateTwoDaysAgo($db, $obj){
        $query_twoDaysAgo = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                        (calories * sum(servings_count)) AS calories, 
                                        (fat * sum(servings_count)) AS fat, 
                                        (cholesterol * sum(servings_count)) AS cholesterol, 
                                        (sodium  * sum(servings_count)) AS sodium, 
                                        (carbs * sum(servings_count)) AS carbs, 
                                        (protein * sum(servings_count)) AS protein, 
                                        meal, FOOD_TRACKING_LISTS.user_id
                                      FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                                      WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                      AND FOOD_TRACKING_LISTS.user_id = :user_id
	                                  AND time_stamp = CURDATE() - INTERVAL 2.333 DAY
	                                  GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_twoDaysAgo);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $twoDaysAgo = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $twoDaysAgo;
    }

    public function populateTodaysFoodEntries($db, $obj){
        $query_todaysFoodEntries = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                        (calories * sum(servings_count)) AS calories, 
                                        (fat * sum(servings_count)) AS fat, 
                                        (cholesterol * sum(servings_count)) AS cholesterol, 
                                        (sodium  * sum(servings_count)) AS sodium, 
                                        (carbs * sum(servings_count)) AS carbs, 
                                        (protein * sum(servings_count)) AS protein, 
                                        meal, FOOD_TRACKING_LISTS.user_id
                                      FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                                      WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                      AND FOOD_TRACKING_LISTS.user_id = :user_id
	                                  AND time_stamp = CURDATE() - INTERVAL 1.333 DAY
	                                  GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_todaysFoodEntries);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $todaysFoodEntries = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $todaysFoodEntries;

    }

    public function populateTodaysBreakfast($db, $obj) {
        $query_todaysBreakfast = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                    (calories * sum(servings_count)) AS calories, 
                                    (fat * sum(servings_count)) AS fat, 
                                    (cholesterol * sum(servings_count)) AS cholesterol, 
                                    (sodium  * sum(servings_count)) AS sodium, 
                                    (carbs * sum(servings_count)) AS carbs, 
                                    (protein * sum(servings_count)) AS protein, 
                                    meal, FOOD_TRACKING_LISTS.user_id
                                  FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                                  WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                    AND FOOD_TRACKING_LISTS.user_id = :user_id
	                                AND time_stamp = CURDATE()
	                                AND meal = 'breakfast'
	                              GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_todaysBreakfast);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $todaysBreakfast = $pdo_statement->fetchAll(PDO::FETCH_OBJ);
        return $todaysBreakfast;
    }

    public function populateTodaysLunch($db, $obj) {
        $query_todaysLunch = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                (calories * sum(servings_count)) AS calories, 
                                (fat * sum(servings_count)) AS fat, 
                                (cholesterol * sum(servings_count)) AS cholesterol, 
                                (sodium  * sum(servings_count)) AS sodium, 
                                (carbs * sum(servings_count)) AS carbs, 
                                (protein * sum(servings_count)) AS protein, 
                                meal, FOOD_TRACKING_LISTS.user_id
                              FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                              WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                AND FOOD_TRACKING_LISTS.user_id = :id
                                AND time_stamp = CURDATE()
                                AND meal = 'lunch'
                              GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_todaysLunch);
        $pdo_statement->bindValue(":id", $obj->getUsersId());
        $pdo_statement->execute();
        $todaysLunch = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $todaysLunch;
    }

    public function populateTodaysDinner($db, $obj) {
        $query_todaysDinner = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                (calories * sum(servings_count)) AS calories, 
                                (fat * sum(servings_count)) AS fat, 
                                (cholesterol * sum(servings_count)) AS cholesterol, 
                                (sodium  * sum(servings_count)) AS sodium, 
                                (carbs * sum(servings_count)) AS carbs, 
                                (protein * sum(servings_count)) AS protein, 
                                meal, FOOD_TRACKING_LISTS.user_id
                              FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                              WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                AND FOOD_TRACKING_LISTS.user_id = :user_id
                                AND time_stamp = CURDATE()
                                AND meal = 'dinner'
                              GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_todaysDinner);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $todaysDinner = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $todaysDinner;
    }

    public function populateTodaysSnacks($db, $obj) {
        $query_todaysSnacks = "SELECT food_item_name, sum(servings_count) AS servings_count, 
                                (calories * sum(servings_count)) AS calories, 
                                (fat * sum(servings_count)) AS fat, 
                                (cholesterol * sum(servings_count)) AS cholesterol, 
                                (sodium  * sum(servings_count)) AS sodium, 
                                (carbs * sum(servings_count)) AS carbs, 
                                (protein * sum(servings_count)) AS protein, 
                                meal, FOOD_TRACKING_LISTS.user_id
                              FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                              WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                AND FOOD_TRACKING_LISTS.user_id = :user_id
                                AND time_stamp = CURDATE()
                                AND meal = 'snack'
                              GROUP BY food_item_name";
        $pdo_statement = $db->prepare($query_todaysSnacks);
        $pdo_statement->bindValue(":user_id", $obj->getUsersId());
        $pdo_statement->execute();
        $todaysSnacks = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $todaysSnacks;
    }
}
