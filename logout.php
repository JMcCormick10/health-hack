<?php
//start session
session_start();
// destroy session variable
session_destroy();
//return user to landing.php (aka login screen)
header("Location: landing.php");
//exit the page; terminate current script
exit;
?>