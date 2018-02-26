<?php
    require_once('../redirect.php');
    require_once('../Models/Database.php');
    require_once('../Models/Gyms.php');
    require_once('../Models/GymLocation.php');
    $db = new Database();
    $db = $db->getDbFromAWS();
    $gymObj = new Gyms();
    $gymObj->setDb($db);

    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

    $action = 'Index';


    if (isset($_POST['addGym'])) {
        $gymInfo = new GymLocation($_POST);
        if ($gymObj->getGymCountPerUser($_SESSION['userId']) < 5) {
            $addedGym = $gymObj->addGymToFav($gymInfo);
            if ($addedGym === true) {
                $_SESSION['message'] = "New Location was successfully added to your list!";
                $_SESSION['msgStatus'] = 1;
            } else {
                $_SESSION['message'] = "This Gym is already on the list!";
                $_SESSION['msgStatus'] = 0;
            }
        } else {
            $_SESSION['message'] = "No more than 5 Gyms allowed!";
            $_SESSION['msgStatus'] = 0;
        }
        header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit();
    }

    if (isset($_POST['gymToChoose'])) {
        $updatedGym = $gymObj->updateDefaultGym($_POST['gymToChoose']);
        if ($updatedGym === true) {
            $_SESSION['message'] = "Default Gym was successfully changed!";
            $_SESSION['msgStatus'] = 1;
        } else {
            $_SESSION['message'] = $updatedGym;
            $_SESSION['msgStatus'] = 1;
        }
        header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit();
    }

    if (isset($_POST['deleteGym'])) {
        $deletedGym = $gymObj->deleteGymFromList($_POST['gym-num']);
        if ($deletedGym == true) {
            $_SESSION['message'] = "Gym was successfully deleted from your list!";
            $_SESSION['msgStatus'] = 1;
        } else {
            $_SESSION['message'] = $deletedGym;
            $_SESSION['msgStatus'] = 0;
        }
        header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit();
    }


    include('ViewIndex.php');
?>