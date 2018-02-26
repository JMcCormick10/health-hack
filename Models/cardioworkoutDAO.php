<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-10
 * Time: 5:17 PM
 */
class cardioworkoutDAO
{
    public function insertCardio($db, $reqObj){
        $query = "INSERT INTO CARDIO_WORKOUTS (user_id, name, goal_distance, goal_time) VALUES (:user_id, :cardio_name, :goal_distance, :goal_time )";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->bindValue(':cardio_name', $reqObj->getName());
        $statement->bindValue(':goal_distance', $reqObj->getGoalDistance());
        $statement->bindValue(':goal_time', $reqObj->getGoalTime());
        $statement->execute();
        $statement->closeCursor();


    }
    public function getCardioWorkouts($db, $reqObj){
        $query = "SELECT * FROM CARDIO_WORKOUTS WHERE user_id= :user_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->execute();
        $cardio_workouts = $statement->fetchAll();
        $statement->closeCursor();
        return $cardio_workouts;
    }
    public function get1CardioWorkout($db, $reqObj){
        $query = "SELECT * FROM CARDIO_WORKOUTS WHERE user_id = :user_id AND cardio_id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->bindValue(':id', $reqObj->getId());
        $statement->execute();
        $cardio_workout = $statement->fetch();
        $statement->closeCursor();
        return $cardio_workout;

    }
    public function insertCompletedCardio($db, $reqObj){
        $query = "INSERT INTO COMPLETED_CARDIO_WORKOUTS (cardio_id, distance, cardio_time) VALUES (:cardio_id, :distance, :cardio_time)";
        $statement = $db->prepare($query);
        $statement->bindValue(':cardio_id', $reqObj->getCardioId());
        $statement->bindValue(':distance', $reqObj->getDistance());
        $statement->bindValue(':cardio_time', $reqObj->getTime());
        $statement->execute();
        $statement->closeCursor();
    }
    public function insertQuickCardio($db, $reqObj){
        $query = "INSERT INTO QUICK_CARDIO_WORKOUTS (cardio_type, distance, quick_cardio_time, user_id) VALUES (:cardio_type, :distance, :quick_cardio_time, :user_id)";
        $statement = $db->prepare($query);
        $statement->bindValue(':cardio_type', $reqObj->getType());
        $statement->bindValue(':distance', $reqObj->getDistance());
        $statement->bindValue(':quick_cardio_time', $reqObj->getTime());
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->execute();
        $statement->closeCursor();
    }
    public function deleteCardio ($db, $reqObj){
        $query = "DELETE FROM CARDIO_WORKOUTS WHERE user_id = :user_id AND cardio_id = :cardio_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->bindValue(':cardio_id', $reqObj->getId());
        $statement->execute();
        $statement->closeCursor();
    }
    public function deleteCompletedCardio ($db, $reqObj){
        $query ="DELETE FROM COMPLETED_CARDIO_WORKOUTS WHERE cardio_id = :cardio_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':cardio_id', $reqObj->getCardioId());
        $statement->execute();
        $statement->closeCursor();
    }
    public function verify_Unique_Cardio ($db, $reqObj){
        $query = "SELECT name FROM CARDIO_WORKOUTS WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->execute();
        $cardio_names = $statement->fetchAll();
        $statement->closeCursor();
        return $cardio_names;
    }

}