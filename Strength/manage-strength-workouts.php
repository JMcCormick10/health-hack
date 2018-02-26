<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-08
 * Time: 4:28 PM
 */
ob_start();

//this file checks that a user is logged in and sends them to the landing page if a user session has not been set
require_once '../redirect.php';

//creating a database object and calling our connection method on it.
require_once '../Models/Database.php';
$db   = new Database();
$conn = $db->getDbFromAWS();


/*
 * if the user clicks 'delete strength workout
 * ========================================================
 */
if (isset($_POST['delete_strength'])){

    //grab our exercise and strength classes, along with our data access object for strength exercises, and our
    //data access object for routines.
    require_once '../Models/Exercises.php';
    require_once '../Models/StrengthWorkout.php';
    require_once '../Models/StrengthWorkoutDAO.php';
    require_once '../Models/RoutineDAO.php';

    //if the user does not check any of the strength workouts to delete, store an error message in a variable.
    if (empty($_POST['strength_check'])) {
        $delete_error = "You must select a strength workout to delete.";

    }
    //otherwise, grab all of the strength workouts that were checked to be delete, and loop through them to delete them.
    else {

        $strength_delete = $_POST ['strength_check'];
        foreach ($strength_delete as $key => $value) {


            /* because our database is not set to cascading, we must manually delete the child relationships
            before the parent relationships. We start with all of the completed exercises associated with our strength workout.  */

            //we delete all the completed exercises that have a foreign key (strength_id) equal to the values we grabbed
            //from our form stored in $strength_delete array.

           $query = "DELETE FROM COMPLETED_STRENGTH_EXERCISES WHERE strength_id = :strength_id";
           $statement = $conn->prepare($query);
           $statement->bindValue(':strength_id', $value);
           $statement->execute();
           $statement->closeCursor();


            //create a new exercise object, set its strength_id property equal to the value from $strength_delete
            $exercises = new Exercises();
            $exercises->setStrengthWorkoutId($value);

            //create a data access object, and pass in our exercise object from above which holds the value
            //of the strength_workout id foreign key on the exercises_table. Delete all exercises that have this
            //value as a foreign key.
            $e = new StrengthWorkoutDAO();
            $e->deleteStrengthExercises($conn, $exercises);


            //then we delete all routines that have this strength_workout apart of them.
            //we create a new routine data access object, pass in the strength_id value to be delete
            $r_Strength = new RoutineDAO();
            $r_Strength->deleteStrengthRoutine($conn, $value);


            //finally we can delete the parent key
            //create a new strength_workout object, and set its id and user id values.
            //the id is equal to the $value we are currently iterating over, and the user_id is set to the
            //value from our redirect file
            $strength_Delete = new StrengthWorkout();
            $strength_Delete->setId($value);
            $strength_Delete->setUserId($id);

            //creating another data access object, and passing in our strength_workout object as a paramter to
            //delete the strength_workout associated with the id property of our strength_workout object.
            $s_Delete = new StrengthWorkoutDAO();
            $s_Delete->deleteStrengthWorkout($conn, $strength_Delete);
            $expire = time() + 1;

            //setting a success message in a cookie, and redirecting to the strength_workout hub/dashboard view.
            setcookie('success', 'Workout(s) deleted!', $expire, '/');
            header("Location: strength.php");
            header("Location: strength.php");
        }

    }




}
//=======================================================================================================================

//we have to grab all of the strength_workouts associated with this user for them to choose which ones to delete.
//we create a strength_workout object and set its user id equal to that of the value we get from the 'redirect' file
require_once '../Models/StrengthWorkout.php';
$s = new StrengthWorkout();
$s->setUserId($id);

//now we create a data access object and call a method to grab all the strength workouts associated with our user by
//passing in the strength workout object we just created with its user_id property set.
require_once '../Models/StrengthWorkoutDAO.php';
$get_Strength      = new StrengthWorkoutDAO();
$strength_workouts = $get_Strength->getStrengthWorkouts($conn, $s);

require_once 'manage-strength-workouts-view.php';
?>