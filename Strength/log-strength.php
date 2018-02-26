<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-27
 * Time: 3:29 PM
 */
ob_start();
//this file checks that a user is logged in and sends them to the landing page if a user session has not been set
require_once '../redirect.php';

/*create a new strength workout object and set it's user id property equal to that of the user signed in. */
require_once '../Models/StrengthWorkout.php';
$sw = new StrengthWorkout();
$sw->setUserId($id);

//creating a database object and calling it's connection method.
require_once '../Models/Database.php';
$db = new Database();
$conn = $db->getDbFromAWS();

/*creating a new strength data access object, and calling a method to grab all of the strength workouts associated with
our user. We do this by passing in our strength object previously created, and the database connection we also created.*/
require_once '../Models/StrengthWorkoutDAO.php';
$get_strength = new StrengthWorkoutDAO();
$strength_workouts = $get_strength->getStrengthWorkouts($conn, $sw);



/*
 * A user has selected a workout from the drop-down and clicked 'Load Workout'
 * ======================================================================================
 */

if (isset($_POST['load_strength'])){

    //grab the id of the strength workout selected from the drop-down menu
    $strength_id = filter_input(INPUT_POST,'strength_workout');

    //test it to make sure one was actually selected. If one wasn't then we store an error message in a variable.
    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testZero($strength_id) == false){
        $strength_workout_error = "You must select a strength workout!";
    }

    //if a workout was selected...
    else {

        /*creating a new strength workout object, and setting its user id property equal to the user id we grabbed
        already from the redirect file. We also set the strength_id property equal to that of the value from the form. */
        $selected_Strength_Workout = new StrengthWorkout();
        $selected_Strength_Workout->setUserId($id);
        $selected_Strength_Workout->setId($strength_id);


        /*creating a new data access object, and calling a method to retrieve one workout based on the strength_id property
        of the object created above. We then use this to load details of the workout in the view so that the user
        can enter in their stats for this workout like weight used and repeitions per set. */
        $get_Strength = new StrengthWorkoutDAO();
        $strength_Workout = $get_strength->get1StrengthWorkout($conn, $selected_Strength_Workout);

    }
}
//===================================================================================================================================

/*
 *  The use has clicked 'Save workout' after (hopefully) entering in their stats
 * =========================================================================================
 */

/*checking to see that a workout was actually selected for entry into the database. By default, each exercise that was loaded in the view
 has a hidden exercise_id field so that we can link it back to that table. However, if there is no exercise_id value, something has gone wrong.
If something has gone wrong, we store an error message in a variable*/
if (isset($_POST['save_strength'])) {
    if (!isset($_POST['exercise_id'][0])) {
        $strength_workout_error = "You must select a strength workout!";
    } else {

        /*we redo everything we did for the 'load workout' submission. We do this so that if our user made a mistake, and input to the database
        failed, their strength workout is still selected from the drop-down, and all of the exercises are still in the table.
         . */

        //Re-grabbing values
        //=======================================================
        require_once '../Models/StrengthWorkout.php';
        $sw = new StrengthWorkout();
        $sw->setUserId($id);

        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDbFromAWS();
        $strength_id = filter_input(INPUT_POST, 'strength_workout');

        require_once '../Models/Validation.php';
        $v = new Validation();
        if ($v->testZero($strength_id) == false) {
            $strength_workout_error = "You must select a strength workout!";
        } else {

            $selected_Strength_Workout = new StrengthWorkout();
            $selected_Strength_Workout->setUserId($id);
            $selected_Strength_Workout->setId($strength_id);

            //now let's get all the exercises associated with that strength workout.

            $get_Strength = new StrengthWorkoutDAO();
            $strength_Workout = $get_strength->get1StrengthWorkout($conn, $selected_Strength_Workout);
//==========================================================================================================

            /* now we grab the exercise values. we named sets and weights the same so we could store their values as an array
            and loop through each iteration for insertion into the database. we do this because we have no way of knowing
            what to name our form fields since we don't know how many exercises will be in the strength workout
            our user selected. So no matter how many there are, we just loop through each of them for insertion.
            the exercise id and strength id is also stored with each exercise so that we can insert the foreign keys
            into the completed strength_workout table based on the strength_workouts table and strength_exercises table
            we don't neccessarilly need to link back to the strength_workout table since the exercise table is a pivot
            table for the stength_workout_table and completed_exercise table but we did it anyway.  */
            $completed_exercise_id = array($_POST['exercise_id'])[0];
            $completed_strength_id = array($_POST['strength_id'])[0];
            $exercise_name = array($_POST['exercise_name'])[0];
            $weight = array($_POST['weight'])[0];
            $set_1 = array($_POST['set_1'])[0];
            $set_2 = array($_POST['set_2'])[0];
            $set_3 = array($_POST['set_3'])[0];


            /*we have to check that the user actually entered a weight lifted for each exercise. we also have to check
            they entered a value for the first set. Our users have to complete at least 1 set of each exercise,
            but set 1 and 2 can be null. */
            if (in_array(0, $weight) || in_array(0, $set_1)) {
                if (in_array(0, $set_1)) {
                    $set_1_error = "You must provide a value for at least the first set.";
                }
                if (in_array(0, $weight)) {
                    $weight_error = "You must enter a weight!";
                }

                //validation is good. The user has entered in a weight, and a value for at least the first set of each exercise.
            } else {


                /*since an exercise_id is hidden with each exercise field, we can simply loop through the
                 exercise_id array to insert each exercise into the database.*/
                for ($i = 0; $i < count($completed_exercise_id); $i++) {
                    //if the value is no weight (in the case of weightless exercises like pull ups
                    //we switch the value back to 0 to insert into db. We must do it this way because
                    //the alternative is to allow for 0 values in the select box, which would not validate for users
                    //forgetting to enter a weight. So at the bottom of the weight select box, we provide a value that is
                    //"No weight."
                    if ($weight[$i] == "1") {
                        $weight[$i] = 0;
                    }


                    /*here is the query to do so. Yes, it should be in another file.
                    all we are doing here is changing the values for each iteration so that each exercise is entered.
                    */
                    $query = "INSERT INTO COMPLETED_STRENGTH_EXERCISES 
        (exercise_id, strength_id, exercise_name, weight, set_1, set_2, set_3)
        VALUES (:completed_exercise_id, :completed_strength_id, :exercise_name, :weight,:set_1, :set_2, :set_3 )";
                    $statement = $conn->prepare($query);
                    $statement->bindValue(':completed_exercise_id', $completed_exercise_id[$i]);
                    $statement->bindValue(':completed_strength_id', $completed_strength_id[$i]);
                    $statement->bindValue('exercise_name', $exercise_name[$i]);
                    $statement->bindValue(':weight', $weight[$i]);
                    $statement->bindValue(':set_1', $set_1[$i]);
                    $statement->bindValue(':set_2', $set_2[$i]);
                    $statement->bindValue(':set_3', $set_3[$i]);
                    $statement->execute();
                    $statement->closeCursor();
                    $log_success = "Workout logged!";
                    //$_SESSION['strength_success'] = "Workout saved. Nice work!";
                    $expire = time() + 1;

                    // success cookie is set, redirect back to main strength hub/dashboard view
                    setcookie('success', 'Workout logged!', $expire, '/');
                    header("Location: strength.php");

                }
            }

        }
    }
}
require_once 'log-strength-view.php';
?>
