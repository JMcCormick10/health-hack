<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 2:47 PM
 */
/*this file checks that a user is logged in and sends them to the landing page if a user session has not been set
 it also stores the session in a variable called $id*/
require_once '../redirect.php';

//created a new database object and calling our connection method on it to connect to the database.
require_once '../Models/Database.php';
$db = new Database();
$conn = $db->getDbFromAWS();

/*
 * if the user clicks the button that makes the routine they selected active.
 * =================================================================================================================
 */
if (isset($_POST['set_active'])){

    //grabbing the id of the routine that they want to set active from the drop-down menu
    $routine_id = filter_input(INPUT_POST, 'routine');

    //created a new routine object from our routine class and calling the methods on it to set the ID of the user and the id of the routine
    require_once '../Models/Routine.php';
    $routine_Change = new Routine();
    $routine_Change->setRoutineId($routine_id);
    $routine_Change->setUserId($id);

    /*now we are creating the data access object for the routine. We call the method to change the active routine by passing in
    the database connection and our routine object we created above.*/
    require_once '../Models/RoutineDAO.php';
    $r_Change = new RoutineDAO();
    $r_Change->setInactive($conn, $routine_Change);

    //now we call the method to set the routine the user selected from the drop-down to the active routine in the database.
    $r_Change->setActive($conn, $routine_Change);
    $expire = time() +1;

    //now we create a cookie that is active for one second and pass the user back to the main routine hub/dashboard view
    setcookie('success', 'Routine set!', $expire, '/');
    header("Location: routines.php");
}
/*
 * =================================================================================================================
 */

/*
 * the user has clicked 'delete routine(s)'
 */
if (isset($_POST['delete_routines'])) {

    //grabbing the routines class and routines data access class to create a new routine object and data access object later on.
    require_once '../Models/Routine.php';
    require_once '../Models/RoutineDAO.php';

    //testing to see whether any of the checkboxes were selected at all. if not, an error message is stored in a variable.
    if (empty($_POST['routine_check'])) {
        $delete_error = "You must select a routine to delete.";

    }

    //we are grabbing all of the id's of the routines that were checked.
    else {
        $routine_delete = $_POST ['routine_check'];

        //for each routine that was selected, we access the value of that routine and do a process to delete it from the database.
        foreach ($routine_delete as $key => $value) {

            /*first we create a new routine object, and set the routine Id equal to the current value iteration, and the user id defined
             in our redirect file*/
            $routine_Delete = new Routine();
            $routine_Delete->setRoutineId($value);
            $routine_Delete->setUserId($id);

            /*now we create a routine data access object, and call a method to delete the specified routine, passing our
             routine object created above as a parameter, along with our database connection. */
            $r_Delete = new RoutineDAO();
            $r_Delete->deleteRoutine($conn, $routine_Delete);

            //setting a cookie to display a success message and passing them back to to the main routine hub/dashboar view
            $expire = time() + 1;
            setcookie('success', 'Routine(s) deleted', $expire, '/');
            header("Location: routines.php");
        }
    }

}


//here we grab our routines class and data access class.
require_once '../Models/RoutineDAO.php';
require_once '../Models/Routine.php';

//creating a new routine object and settings its user_id property equal to that of the id from our session above in the redirect file.
$our_User = new Routine();
$our_User->setUserId($id);

/*created a data access object, calling a method to grab all of the routines associated with the current user to be displayed
in the drop-down menu and checkboxes.*/
$r = new RoutineDAO();
$routines = $r->getRoutines($conn, $our_User);




require_once 'manage-routines-view.php';