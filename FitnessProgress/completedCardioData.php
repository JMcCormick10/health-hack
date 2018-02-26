<?php
    require('../Models/Database.php');
    require('../Models/FitnessProgress.php');
    $db = new Database();
    $db = $db->getDbFromAWS();
    $fitnessProg = new FitnessProgress();
    $fitnessProg->setDb($db);

    session_start();

    $month = $_GET['month'];
    $year = $_GET['year'];


    $workouts = json_encode($fitnessProg->getCompletedCardWorkouts($month, $year, $_SESSION["user"]));

    header("Content-Type: application/json");
    echo $workouts;
?>