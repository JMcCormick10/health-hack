<?php
ob_start();

//this file checks that a user is logged in and sends them to the landing page if a user session has not been set
require_once '../redirect.php';

//create a new $cardioworkout object and set it's user id equal to that of the user logged in.
//this is done so that we only load the cardio workouts in the drop-down associated with the logged in user.
//the id variable is created in our redirect.php file.
require_once '../Models/cardioworkout.php';
$c = new cardioworkout();
$c->setUserId($id);


//created a database object and then calling our connection the database in the method.
require_once '../Models/Database.php';
$db   = new Database();
$conn = $db->getDbFromAWS();

//create a new cardioWorkoutDAO object and pass in our cardio object and database connection.
//we do this to populate our dropdown list of cardio workouts to choose from
require_once '../Models/cardioworkoutDAO.php';
$get_Cardio      = new cardioworkoutDAO();
$cardio_workouts = $get_Cardio->getCardioWorkouts($conn, $c);


/*
 * A user has clicked the 'Load' button on a selected cardio workout.
 * ======================================================================
 */
if (isset($_POST['load_cardio'])) {

    //grab our id of the cardio workout that was selected from the drop-down menu
    $cardio_id = filter_input(INPUT_POST, 'cardio_workout');

    //minor validation. The first option in our dropdown has a value of 0, as it holds a placeholder message.
    if ($cardio_id == "0") {
        $cardio_workout_error = "You must select a cardio workout to log.";
    }
    //a user has selected a cardio workout.
    //we are now creating a new cardio workout object, and setting it's user id property equal to the session of the user logged in.
    else {
        $selected_Cardio_Workout = new cardioworkout();
        $selected_Cardio_Workout->setUserId($id);
        $selected_Cardio_Workout->setId($cardio_id);

        /*running a query to get all of the columns associated with this particular cardio workout.
         we are created a new data access object, calling a method to grab just one cardio workout
        and passing in our database connection and cardio workout object. */
        $get_1_Cardio = new cardioworkoutDAO();
        $cardio_Workout = $get_1_Cardio->get1CardioWorkout($conn, $selected_Cardio_Workout);
    }
}
/*
 * A user has clicked the 'Save Workout' button
 * ====================================================
 */
if (isset($_POST['save_workout'])) {

    /*re-capture the selected cardio workout from the drop-down so that it is still displayed and available
     to user for our foreign key when we insert into the completed cardio workouts below
    //we also do this in case the user submits the workout without first loading workout details, which is acceptable.*/
    $cardio_id = filter_input(INPUT_POST, 'cardio_workout');

    //a user has selected a cardio workout.
    //we are now creating a new cardio workout object, and setting it's user id property equal to the session of the user logged in.
    $selected_Cardio_Workout = new cardioworkout();
    $selected_Cardio_Workout->setUserId($id);
    $selected_Cardio_Workout->setId($cardio_id);

    /*running a query to get all of the information for the cardio workout that was selected.
     we are doing this for this button click as well so that if a mistake is made in the form submission, the correct cardio workout
    will be selected in the drop-down, along with it's associated goals and times. */
    $get_1_Cardio = new cardioworkoutDAO();
    $cardio_Workout = $get_1_Cardio->get1CardioWorkout($conn, $selected_Cardio_Workout);

    //we are grabbing our form field values the user submitted.
    $distance = filter_input(INPUT_POST, 'cardio_distance');
    $hours = filter_input(INPUT_POST, 'hours');
    $minutes = filter_input(INPUT_POST, 'minutes');
    $seconds = filter_input(INPUT_POST, 'seconds');

    //now we are validating.
    require_once '../Models/Validation.php';
    $v = new Validation();

    if ($cardio_id == 0) {
        $cardio_workout_error = "Select a workout!";
    }
    if ($v->testZero($distance) == false) {
        $distance_error = "Enter distance!";
    }

    //if a user does not provide a value for hours, minutes or seconds, the form is invalid.
    if ($v->testZero($hours) == false && $v->testZero($minutes) == false && $v->testZero($seconds) == false) {
        $time_error = "Enter time!";
    }
    //testing if everything validates to true, and if so, do the steps required to insert into the database.
    if ($cardio_id != 0 && $v->testZero($distance) == true && ($v->testZero($hours) == true || $v->testZero($minutes) == true || $v->testZero($seconds) == true)) {

        //here we are using a custom function to convert our three time variables one valid datetime variable to insert into the database.
        require_once '../functions/time_format_function.php';
        $cardio_time = timeFormat($hours, $minutes, $seconds);

        //created a new completed cardio workout object.
        require_once '../Models/completedCardioWorkout.php';
        $completed_Cardio = new completedCardioWorkout();

        //set the properties of this completed cardio workout equal to the form values.
        $completed_Cardio->setCardioId($cardio_id);
        $completed_Cardio->setDistance($distance);
        $completed_Cardio->setTime($cardio_time);

        //create a new DAO object, and call the method to insert, passing in our connection and completed cardio object
        $complete = new cardioworkoutDAO();
        $complete->insertCompletedCardio($conn, $completed_Cardio);


        //create a cookie with a success message that expires in one second, and send the user back to the cardio dashboard.
        $expire = time() + 1;
        setcookie('success', 'Cardio workout logged!', $expire, '/');
        header("Location: Cardio.php");

    }
}
require_once 'log-cardio-view.php';
?>
