<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-26
 * Time: 4:32 PM
 */
ob_start();
//this file checks that a user is logged in and sends them to the landing page if a user session has not been set
require_once '../redirect.php';

/*
 * The user has clicked 'submit' to save their created strength workout
 * ======================================================================
 */
if (isset($_POST['submit_strength'])){

    //grabbing the name of our strength workout.
    $strength_name = filter_input(INPUT_POST,'strength_name');

    //grabbing the exercises that were entered as part of the workout. If none were entered, store an error message in a variable
    if (!isset($_POST['exercises'])) {
        $exercise_error = "You must enter exercises for the workout!";
    }
    /*multiple form fields with the name exercises, so we capture it in an an array, and we access all the values by grabbing the first
    index in that array.*/
    else {
        $exercises = array($_POST['exercises']);
        $string = $exercises[0];
    }


    /*grabbing our validation class, created a validation object, and then calling a method to test that the user entered in a value.
    If they did not, then we store an error message in a variable.*/
    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testName($strength_name) == false){
    $strength_error = "Provide a name for this workout!";
    }

    //if both valdidations are true, we can start inserting into the database.
    if ($v->testName($strength_name) == true && isset($_POST['exercises'])) {

        //create a database object and call the connection method on that object.
        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDbFromAWS();

        /*creating a strength workout object and setting its user id property equal to that of the id variable that holds our user's id
        in a session. we also set the name property equal to the name given in the form field.*/
        require_once '../Models/StrengthWorkout.php';
        $strength_workout = new StrengthWorkout();
        $strength_workout->setUserId($id);
        $strength_workout->setName($strength_name);

        /* we create a new data acccess object for our strength workout. Before inserting into the database,
        we call a method on this object that checks if the name they gave to the strength workout is unique based on their user id */
        require_once '../Models/StrengthWorkoutDAO.php';
        $sw = new StrengthWorkoutDAO();
        $list = $sw->verifyUniqueName($conn, $strength_workout);

        //initializing an array that will hold all of the names of our strength workouts.
        $namesList = array();

        //for each value in our list, push it into this array.
        foreach ($list as $key=>$value){
            array_push($namesList, $value[0]);
        }

        //if the value that we got from the form is in our array of strength names from the database, display an error message.
        if (in_array($strength_name, $namesList)){
            $strength_error = "You must pick a unique workout name!";
        }

        //otherwise, proceed with insertion into the database.
        else {

            //create a new strengthDAO class and insert into the database.
            //on further inspection, this is redundant since this object was already created above.
            require_once '../Models/StrengthWorkoutDAO.php';
            $sw = new StrengthWorkoutDAO();

            /*call an insertion method on the data access object, passing on our strength object that has the user id
            and name of the workout properties previously set. We also pass in our database connection.*/
            $sw->insertStrengthWorkout($conn, $strength_workout);


            /* Now we must insert into the other table related to our strength workouts, the exercises table.
            This table is linked to the table we inserted into above by a foreign key. Each exercise has a strength_id
            foreign key that identifies which strength workout it belongs to. */

            /*for each exercise stored in our string array, call a method that inserts into strength exercises table
            where the user id and strength workout_name is equal to that of the strength object we are passing in
            This uses a subquery to grab the strength_workout_id that is associated with the name and user id of the object
            we are passing in. Then it uses the result of this subquery to assign the foreign key 'strength_workout_id' in the exercises
            table */
            foreach ($string as $key => $value) {
                $sw->insertStrengthExercises($conn, $value, $strength_workout);
            }

            //creating a cookie with a success message that is displayed when they are re-directed back to the strength hub/dashboard view.
            $success_message = "Workout created!";
            $expire = time() + 1;
            setcookie('success', 'Workout created!', $expire, '/');
            header("Location: strength.php");
        }
    }
}
require_once 'create-strength-view.php';
?>

