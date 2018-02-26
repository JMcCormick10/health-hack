<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-26
 * Time: 7:34 PM
 */
class StrengthWorkoutDAO
{
    public function insertStrengthWorkout($db, $reqObj){
        $query = "INSERT INTO STRENGTH_WORKOUTS (user_id, strength_workout_name) VALUES (:user_id, :name)";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->bindValue(':name', $reqObj->getName());
        $statement->execute();
        $statement->closeCursor();

    }
    public function insertStrengthExercises($db, $value, $reqObj){
    $query = "INSERT INTO STRENGTH_EXERCISES (exercise_name, strength_workout_id) VALUES (:name, (SELECT strength_id FROM STRENGTH_WORKOUTS WHERE strength_workout_name = :strength_name AND user_id = :user_id))";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $value);
    $statement->bindValue (':strength_name', $reqObj->getName());
    $statement->bindValue(':user_id', $reqObj->getUserId());
    $statement->execute();
    $statement->closeCursor();
}
public function verifyUniqueName ($db, $reqObj){
        $query = "SELECT strength_workout_name FROM STRENGTH_WORKOUTS WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindValue('user_id', $reqObj->getUserId());
        $statement->execute();
        $strength_workouts = $statement->fetchAll();
        $statement->closeCursor();
        return $strength_workouts;

}
public function getStrengthWorkouts ($db, $reqObj){
    $query = "SELECT * FROM STRENGTH_WORKOUTS WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $reqObj->getUserId());
    $statement->execute();
    $strength_workouts = $statement->fetchAll();
    $statement->closeCursor();
    return $strength_workouts;
}
public function get1StrengthWorkout($db, $reqObj){
    $query = "SELECT * FROM STRENGTH_WORKOUTS JOIN  STRENGTH_EXERCISES ON 
    STRENGTH_WORKOUTS.strength_id = STRENGTH_EXERCISES.strength_workout_id 
    WHERE user_id = :user_id AND strength_id = :strength_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $reqObj->getUserId());
    $statement->bindValue(':strength_id', $reqObj->getId());
    $statement->execute();
    $exercises = $statement->fetchAll();
    $statement->closeCursor();
    return $exercises;
}
public function deleteStrengthExercises($db, $reqObj){
    $query = "DELETE FROM STRENGTH_EXERCISES WHERE strength_workout_id = :strength_workout_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':strength_workout_id', $reqObj->getStrengthWorkoutId());
    $statement->execute();
    $statement->closeCursor();
}
public function deleteStrengthWorkout($db, $reqObj){
    $query = "DELETE FROM STRENGTH_WORKOUTS WHERE strength_id = :strength_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':strength_id', $reqObj->getId());
    $statement->execute();
    $statement->closeCursor();
}

}