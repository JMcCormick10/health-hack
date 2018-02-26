<?php
/*this file checks that a user is logged in and sends them to the landing page if a user session has not been set
 it also stores the session in a variable called $id*/
require_once '../redirect.php';

//created a new database object and calling our connection method on it to connect to the database.
require_once '../Models/Database.php';
$db   = new Database();
$conn = $db->getDbFromAWS();

/*creating a new cardioworkout object and setting its user id property equal to that of the user
in our re-direct session */
require_once '../Models/cardioworkout.php';
$c = new cardioworkout();
$c->setUserId($id);

/*now we create a new cardio data access object and call a method to grab all of the cardio workouts
associated with our user id. we do this by passing in the cardio workout object from above along with our database connection */
require_once '../Models/cardioworkoutDAO.php';
$get_Cardio      = new cardioworkoutDAO();
$cardio_workouts = $get_Cardio->getCardioWorkouts($conn, $c);


/*creating a new strength workout object and setting its user id property equal to that of the user
in our re-direct session */
require_once '../Models/StrengthWorkout.php';
$sw = new StrengthWorkout();
$sw->setUserId($id);

/*now we create a new strength workout data access object and call a method to grab all of the strength workouts
associated with our user id. we do this by passing in the strength workout object from above along with our database connection */
require_once '../Models/StrengthWorkoutDAO.php';
$get_strength = new StrengthWorkoutDAO();
$strength_workouts = $get_strength->getStrengthWorkouts($conn, $sw);

/*
 * The user has clicked either the button to make the routine they created active or inactive.
 * ==============================================================================================================
 */
if (isset($_POST['routine_yes']) || isset($_POST['routine_no'])) {

        //setting up a flag variable here for validation later. If any of our
        //validation fails, this will be set to false and submission to db will not occur.
    $valid = true;

    /*here we are grabbing all of our form values for each day's cardio workout and strength workout
     if the user does not select any workout for a form field, the value is 0. we must convert this 0 value
    to null for insertion into the database so we run a function that tests whether the value passed is 0 and if it
    is then it converts that value to null. Otherwise, it just returns the original string passed into the function.*/
    require_once '../functions/convert_to_null.php';
        $routine_name = filter_input(INPUT_POST, 'routine_name');
        $monday_cardio = filter_input(INPUT_POST, 'monday_cardio');
        $monday_cardio = convertToNull($monday_cardio);
        $monday_cardio = convertToNull($monday_cardio);
        $monday_strength = filter_input(INPUT_POST, 'monday_strength');
        $monday_strength = convertToNull($monday_strength);
        $tuesday_cardio = filter_input(INPUT_POST, 'tuesday_cardio');
        $tuesday_cardio = convertToNull($tuesday_cardio);
        $tuesday_strength = filter_input(INPUT_POST, 'tuesday_strength');
        $tuesday_strength = convertToNull($tuesday_strength);
        $wednesday_cardio = filter_input(INPUT_POST, 'wednesday_cardio');
        $wednesday_cardio = convertToNull($wednesday_cardio);
        $wednesday_strength = filter_input(INPUT_POST, 'wednesday_strength');
        $wednesday_strength = convertToNull($wednesday_strength);
        $thursday_cardio = filter_input(INPUT_POST, 'thursday_cardio');
        $thursday_cardio = convertToNull($thursday_cardio);
        $thursday_strength = filter_input(INPUT_POST, 'thursday_strength');
        $thursday_strength = convertToNull($thursday_strength);
        $friday_cardio = filter_input(INPUT_POST, 'friday_cardio');
        $friday_cardio = convertToNull($friday_cardio);
        $friday_strength = filter_input(INPUT_POST, 'friday_strength');
        $friday_strength = convertToNull($friday_strength);
        $saturday_cardio = filter_input(INPUT_POST, 'saturday_cardio');
        $saturday_cardio = convertToNull($saturday_cardio);
        $saturday_strength = filter_input(INPUT_POST, 'saturday_strength');
        $saturday_strength = convertToNull($saturday_strength);
        $sunday_cardio = filter_input(INPUT_POST, 'sunday_cardio');
        $sunday_cardio = convertToNull($sunday_cardio);
        $sunday_strength = filter_input(INPUT_POST, 'sunday_strength');
        $sunday_strength = convertToNull($sunday_strength);

    /*we are validating here that the user actually entered a name for this routine.
    if they did not, then we store an error message in a variable for the view to access.*/
    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testName($routine_name) == false){
        $routine_name_error = "You must provide a name for the routine";
        $valid = false;
    }


    /*here we create a new routine object and set its user id property equal to that of the current user and the name property
     equal to that of the name of the routine provided in the routine name form field.
    */
    require_once '../Models/Routine.php';
    $r = new Routine();
    $r->setName($routine_name);
    $r->setUserId($id);

    //now let's create a new workout routine data access object and pass in our routine object in the getRoutines function to make sure we
    //the user has uniquely named their routine.
    require_once '../Models/RoutineDAO.php';
    $unique_Name_Check = new RoutineDAO();
    $list = $unique_Name_Check->verifyUniqueName($conn, $r);

    //here we initialize a new routine array and push each value from our list into the array.
    $routine_Names_List = array();
    foreach ($list as $key => $value) {
        array_push($routine_Names_List, $value[0]);
    }
    /*now we search for the routine the user provided for us in the array we just pushed all our values.
     if it is in the array, we generate an error message, and set our flag variable to false/*/
    if (in_array($routine_name, $routine_Names_List)) {
        $routine_name_error = "You must pick a unique workout name!";
        $valid = false;
    }

    /*now we check to see if the user did not actually select a workout for ANY DAY, and if they didn't store an error message in a variable to pass to the view.
    we also set the flag variable to false if they did not enter a workout for any day. */
    if ($monday_strength == null && $tuesday_strength == null && $wednesday_strength == null && $thursday_strength == null && $friday_strength == null &&
        $saturday_strength == null && $sunday_strength == null && $monday_cardio == null && $tuesday_cardio == null && $wednesday_cardio == null && $thursday_cardio == null && $friday_cardio == null && $saturday_cardio == null && $sunday_cardio == null){
        $workout_error = "You forgot to enter workouts!";
        $valid = false;
    }

    //if the form is valid, we can insert it.
if ($valid) {



//we take our previously created routine property and set all of its cardio day properites equal to the values of our form field
        $r->setMondayCardio($monday_cardio);
        $r->setTuesdayCardio($tuesday_cardio);
        $r->setWednesdayCardio($wednesday_cardio);
        $r->setThursdayCardio($thursday_cardio);
        $r->setFridayCardio($friday_cardio);
        $r->setSaturdayCardio($saturday_cardio);
        $r->setSundayCardio($sunday_cardio);

//we take our previously created routine property and set all of its strength day properites equal to the values of our form field
        $r->setMondayStrength($monday_strength);
        $r->setTuesdayStrength($tuesday_strength);
        $r->setWednesdayStrength($wednesday_strength);
        $r->setThursdayStrength($thursday_strength);
        $r->setFridayStrength($friday_strength);
        $r->setSaturdayStrength($saturday_strength);
        $r->setSundayStrength($sunday_strength);



        /*
         * the user has clicked the make routine active button
         * ========================================================
         */
        if (isset($_POST['routine_yes'])) {

            //setting the active property of our routine object to "yes"
            $activeValue = "Yes";
            $r->setActive($activeValue);

            /*we create a new data access object and call a method to first set any routine currently set to active that belongs to
            this user to inactive.*/
            $rou_yes = new RoutineDAO();
            $rou_yes->setInactive($conn, $r);

            /*call a method to insert a new routine. We pass in our connection an routine object
            as parameters. The routine object we are passing in has a property that makes this routine the active routine.*/
            $rou_yes->insertRoutine($conn, $r);
            $expire = time() + 1;

            //setting a cookie to display a success message and passing them back to to the main routine hub/dashboar view
            setcookie('success', 'Routine set!', $expire, '/');
            header("Location: routines.php");

        }
    //=============================================================

    /*
     * the user has clicked to create the routine but to make it inactive
     * ====================================================================
     */
        if (isset($_POST['routine_no'])) {

            //setting the active property of our routine object to "yes"
            $activeValue = "No";
            $r->setActive($activeValue);

            /*call a method to insert a new routine. We pass in our connection an routine object
            as parameters. The routine object we are passing in has a property that makes this routine a non-active routine.*/
            $rou_no = new RoutineDAO();
            $rou_no->insertRoutine($conn, $r);

            //setting a cookie to display a success message and passing them back to to the main routine hub/dashboar view
            $expire = time() + 1;
            setcookie('success', 'Routine created!', $expire, '/');
            header("Location: routines.php");

        }
        //==================================================================
    }

}

require_once 'create-routine-view.php';