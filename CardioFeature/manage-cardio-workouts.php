<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 6:13 PM
 */
ob_start();

//this file checks that a user is logged in and sends them to the landing page if a user session has not been set
require_once '../redirect.php';

//created a database object and calling its connection method to connect to our database.
require_once '../Models/Database.php';
$db   = new Database();
$conn = $db->getDbFromAWS();

/*
 * A user has clicked 'delete cardio workout'
 * ==========================================
 */
if (isset($_POST['delete_cardio'])){
    /*we are grabbing all of the classes that we need to do deletion. Because of the we do not have cascading deletion with parent keys
     set in our database schema.*/
    require_once '../Models/completedCardioWorkout.php';
    require_once '../Models/cardioworkout.php';
    require_once '../Models/cardioworkoutDAO.php';
    require_once '../Models/RoutineDAO.php';

    //if the user has not checked off an workout to delete, we store an error message in a variable to be displayed in the view.
    if (empty($_POST['cardio_check'])) {
        $delete_error = "You must select a routine to delete.";

    }
    else {
            /* each cardio workout has a name called cardio_check[] that is an array
            we name them the same so that for each workout checked, we can loop through and delete all of the workouts
            with that value */
            $cardio_delete = $_POST ['cardio_check'];
            foreach ($cardio_delete as $key => $value) {

                //we must delete the children first

                /*first we delete from completed cardio workouts
                /we create a new cardio workout object, and call a method to set the
                id equal to that of the value of the cardio workout*/
                $completed_Cardio_Delete = new completedCardioWorkout();
                $completed_Cardio_Delete->setCardioId($value);

                /*now we create a new data access object, call a method to delete, passing in our connection and cardio object, and
                */
                $c_Cardio_Delete = new cardioworkoutDAO();
                $c_Cardio_Delete->deleteCompletedCardio($conn, $completed_Cardio_Delete);

                //then we delete from the routines table
                $r_Cardio = new RoutineDAO();
                $r_Cardio->deleteCardioRoutine($conn, $value);


                //then we delete the parent keys.
                $cardio_Delete = new cardioworkout();
                $cardio_Delete->setId($value);

                //this is probably unncessecary since we are deleting based on the id of the cardio workout, which is unique.
                $cardio_Delete->setUserId($id);


                $c_Delete = new cardioworkoutDAO();
                $c_Delete->deleteCardio($conn, $cardio_Delete);
                $expire = time() + 1;

                //create a cookie with a success message that expires in one second, and send the user back to the cardio dashboard.
                setcookie('success', 'Cardio workout(s) deleted!', $expire, '/');
                header("Location: Cardio.php");

        }

        }




}
/*=====================================================================================*/

//we create a cardio workout object and set its user id property equal to that of the user logged in
require_once '../Models/cardioworkout.php';
$c = new cardioworkout();
$c->setUserId($id);

/* here we create a new cardio data acces model
and  call in a method to grab all the cardio workouts
pass in our database connection and cardio workout object we just created to only get the workouts associated with this user.
We do this so that we can display each cardio workout with a checkbox beside it for deletion. The value takes on the id of each
cardio workout.
*/
require_once '../Models/cardioworkoutDAO.php';
$get_Cardio      = new cardioworkoutDAO();
$cardio_workouts = $get_Cardio->getCardioWorkouts($conn, $c);

require_once 'manage-cardio-workouts-view.php';
?>