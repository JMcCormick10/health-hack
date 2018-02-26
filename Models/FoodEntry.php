<?php

class FoodEntry {

    //properties
    private $food_item_id, $meal, $servings_count, $timestamp, $track_id, $user_id;

    //get food_item_id
    public function getFoodItemId()
    {
        return $this->food_item_id;
    }

    //set food_item_id
    public function setFoodItemId($food_item_id)
    {
        $this->food_item_id = $food_item_id;
    }

    //get meal
    public function getMeal()
    {
        return $this->meal;
    }

    //set meal
    public function setMeal($meal)
    {
        $this->meal = $meal;
    }

    //get $servings_count
    public function getServingsCount()
    {
        return $this->servings_count;
    }

    //set $servings_count
    public function setServingsCount($servings_count)
    {
        $this->servings_count = $servings_count;
    }

    //get timestamp
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    //set timestamp
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    //get track_id
    public function getTrackId()
    {
        return $this->track_id;
    }

    //set track_id
    public function setTrackId($track_id)
    {
        $this->track_id = $track_id;
    }

    //get user_id
    public function getUserId()
    {
        return $this->user_id;
    }

    //set user_id
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

}

?>

