<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-11
 * Time: 6:10 PM
 */
ob_start();

//this file checks that a user is logged in and sends them to the landing page if a user session has not been set
require_once '../redirect.php';

/*
 * A user has clicked 'Save workout'
 */
if (isset($_POST['save_workout'])) {

    //grab the variables from the form
    $type = filter_input(INPUT_POST, 'type');
    $distance = filter_input(INPUT_POST, 'cardio_distance');
    $hours = filter_input(INPUT_POST, 'hours');
    $minutes = filter_input(INPUT_POST, 'minutes');
    $seconds = filter_input(INPUT_POST, 'seconds');


    //validate the values and store error messages in variables to be displayed in the view if necessary.
    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testName($type) == false) {
        $type_error = "Name this workout.";
    }
    if ($v->testZero($distance) == false) {
        $distance_error = "Enter distance";
    }
    if ($v->testZero($hours) == false && $v->testZero($minutes) == false && $v->testZero($seconds) == false) {
        $time_error = "Enter time";
    }

    // if the form is valid
    if ($v->testName($type) == true && $v->testZero($distance) == true && ($v->testZero($hours) == true || $v->testZero($minutes) == true || $v->testZero($seconds) == true)) {

        //function to concatenate to appropriate time format
        require_once '../functions/time_format_function.php';
        $time = timeFormat($hours, $minutes, $seconds);


        //create a new database object and call the connection method on it.
        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDbFromAWS();


        /*creating a quick cardio workout object and settings its properties to the values of the form and
        our id which holds the user session*/
        require_once '../Models/quickworkout.php';
        $q = new quickworkout();
        $q->setUserId($id);
        $q->setTime($time);
        $q->setDistance($distance);
        $q->setType($type);

        /*now we create a new data access model for our cardio workout, and call a method insert into the database
         passing in our connection and quick cardio object*/
        require_once '../Models/cardioworkoutDAO.php';
        $quick_cardio = new cardioworkoutDAO();
        $quick_cardio->insertQuickCardio($conn, $q);


        //create a cookie with a success message that expires in one second, and send the user back to the cardio dashboard.
        $expire = time() + 1;
        setcookie('success', 'Cardio workout logged!', $expire, '/');
        header("Location: Cardio.php");

    }
}
/*=================================================================================================================*/
require_once 'quick-cardio-workout-view.php';
?>