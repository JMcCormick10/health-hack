<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 */

ob_start();
//start session
session_start();



$homepage = "/health-hack/index.php";
$homepage2 = "/health-hack/";
//pattern for access_token
$access = "/[?]access[_]token[=]\d{2}[*]\d{4}/";
// contains current host & request uri
$currentpage = $_SERVER['REQUEST_URI'];
$currentpage2 = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if($homepage == $currentpage || $homepage2 == $currentpage || preg_match($access, $currentpage2)) {
    require_once 'Models/Signup.php';
    require_once 'Models/Profile.php';
    //require_once 'processImg.php';
 } else {
    require_once '../Models/Signup.php';
    require_once '../Models/Profile.php';
 }




if(!isset($_SESSION['user'])){
    header("Location:/health-hack/landing.php");
}

$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
$db = new Signup();

$userId = $db->userInfo($user);

//grab  user id, username
$id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email;

$profile = new Profile();

$results = $profile->getUserProfileIinfo($id);
$age = $results->age;
$weight = $results->weight;

$img = $profile->getUserProfileImg($id)->profile_image;

include('error.php');