<?php
ob_start();

//this file checks that a user is logged in and sends them to the landing page if a user session has not been set
require_once '../redirect.php';

/*
 * A user has submitted the form for created a cardio workout.
 ==================================================================*/
if (isset($_POST['submit_cardio'])) {

    //set up a flag variable that gets turned to false if any of our validation fails
    $cardio_Valid = true;

    //grabbing the values from our form.
    $cardio_name     = filter_input(INPUT_POST, 'cardio_name');
    $cardio_type     = filter_input(INPUT_POST, 'cardio_type');
    $cardio_distance = filter_input(INPUT_POST, 'cardio_distance');
    $cardio_hours    = filter_input(INPUT_POST, 'hours');
    $cardio_minutes  = filter_input(INPUT_POST, 'minutes');
    $cardio_seconds  = filter_input(INPUT_POST, 'seconds');



    //created a new database object, and calling a method to connect to the database.
    require_once '../Models/Database.php';
    $db   = new Database();
    $conn = $db->getDbFromAWS();

    //created a new cardio workout object from our cardio class.
    require_once '../Models/Validation.php';
    require_once '../Models/cardioworkout.php';
    $c = new cardioworkout();

    //setting the user_id property of our cardio object equal to the id of the user.
    //this id variable is set as part of the 'redirect file we are requiring
    $c->setUserId($id);

    //this object holds all of the methods for our database queries.
    require_once '../Models/cardioworkoutDAO.php';
    $insert_C = new cardioworkoutDAO();


    //creating that holds all of the cardio workouts names associated with our user.
    // We pass in the database connection along with our cardio workout object that holds our user_id property.
    $list              = $insert_C->verify_Unique_Cardio($conn, $c);

    //initializing an array that will hold all of the names of our cardio workouts.
    $cardio_Names_List = array();
    //for each value in our list, push it into this array.
    foreach ($list as $key => $value) {
        array_push($cardio_Names_List, $value[0]);
    }
    //if the value that we got from the form is in our array of cardio names from the database, display an error message.
    //also set the formValid variable to false.
    if (in_array($cardio_name, $cardio_Names_List)) {
        $name_error   = "You must pick a unique name!";
        $cardio_Valid = false;
    }

    //now we are validating our form using a custom validation class.
    //if any of the methods return false, we are storing an error message that will be passed to the view, and setting the form to invalid.
    $v = new Validation();

    if ($v->testName($cardio_name) == false) {
        $name_error   = "Name workout!";
        $cardio_Valid = false;

    }
    if ($v->testName($cardio_type == false)) {
        $type_error   = "Specify type!";
        $cardio_Valid = false;

    }
    if ($v->testZero($cardio_distance) == false) {
        $distance_error = "Enter goal distance!";
        $cardio_Valid   = false;

    }
    //if a user does not provide a value for hours, minutes or seconds, the form is invalid.
    if ($v->testZero($cardio_hours) == false && $v->testZero($cardio_minutes) == false && $v->testZero($cardio_seconds) == false) {
        $time_error   = "Enter goal time!!";
        $cardio_Valid = false;

    }

    //if the variable is still true, the form is valid. We can now insert into the database.
    if ($cardio_Valid) {

        //here we are using a custom function to convert our three time variables one valid datetime variable to insert into the database.
        require_once '../functions/time_format_function.php';
        $cardio_time = timeFormat($cardio_hours, $cardio_minutes, $cardio_seconds);


        //now we create a new cardioworkout object and set its properties equal to our form values that we previously grabbed.
        require_once '../Models/cardioworkout.php';
        $c = new cardioworkout();
        $c->setName($cardio_name);
        $c->setUserId($id);
        $c->setGoalDistance($cardio_distance);
        $c->setGoalTime($cardio_time);
        $c->setUserId($id);


        //now we use our Cardio DAO object to insert into the database, passing in the database connection and the cardio object that holds
        //the neccessary properties.
        $insert_C->insertCardio($conn, $c);

        //create a cookie with a success message that expires in one second, and send the user back to the cardio dashboard.
        $expire = time() + 1;
        setcookie('success', 'Cardio workout created!', $expire, '/');
        header("Location: Cardio.php");




    }


}



require_once 'create-cardio-view.php';
?>