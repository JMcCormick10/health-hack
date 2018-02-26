<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-09
 * Time: 9:10 AM
 */

$homepage = "/health-hack/index.php";
$homepage2 = "/health-hack/";
//pattern for access_token
$access = "/[?]access[_]token[=]\d{2}[*]\d{4}/";
// contains current host & request uri
$currentpage = $_SERVER['REQUEST_URI'];
$currentpage2 = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

?>

<!-- Authors: Kelly Ann McNamara
Client: Health Hack
Project: Php Group Project 2017
Verison: 1.0

_________________________________

INDEX
01 .Top Bar
01-1. Menu
01-2. Logo
01-3. Search Bar
02. Site Canvas
02-1. Mobile Menu
02-1-1. Profile Photo
02-1-2. User Details
02-1-3. Links
02-2. Main Content
02-2-1. Navigation
02-2-1-1. Profile Photo
02-2-1-2. User Details
02-2-1-3. Links
02-2-2. Main Content
02-2-2-1. Intro Banner
02-2-2-2. Feature Call Out
02-2-2-3. Progress
02-2-3. Footer



-->
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--<meta http-equiv="refresh" content="5">-->
    <title>Health Hack</title>
    <link rel="shortcut icon" sizes="16x16 24x24 32x32 48x48 64x64" href="../opt-imgs/favicon.png">
    <!-- Importing Files -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <?php if($homepage == $currentpage || $homepage2 == $currentpage || preg_match($access, $currentpage2)) { ?>
        <link rel="stylesheet" href="main.css?v=1" />
    <?php } else { ?>
        <link rel="stylesheet" href="../main.css?v=1" />
        <?php } ?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
<div id="wrapper">
    <!-- 01. Top Bar -->
    <div id="top-bar" class="row">
        <!-- 01-1. Menu -->
        <div id="menu" class="col-md-3 col-sm-3 col-4" >
            <button href="#" id="menu-btn" title="Main Menu button" class="toggle-nav">MENU</button>
        </div>
        <!-- 01-2. Logo -->
        <div id="top-logo" class="col-md-6 col-sm-6 col-4">
            <div id="logo">
                <?php
                if($homepage == $currentpage || $homepage2 == $currentpage || preg_match($access, $currentpage2)) {
                    ?><a href="index.php"><img src="opt-imgs/logo.svg" alt="Health Hack Logo" width="43" /></a><?php
                } else {
                    ?><a href="../index.php"><img src="../opt-imgs/logo.svg" alt="Health Hack Logo" width="43" /></a><?php
                }
                ?>
                <!--<img src="../opt-imgs/logo.svg" alt="Health Hack Logo" width="43" />-->
            </div>
        </div>
        <!-- 01-3. Search Bar -->
        <div id="search" class="search col-md-3 col-sm-3 col-4">
            <form id="search-bar" name="frmSearchBar" action="/health-hack/Search/submit_search.php" method="post">
                <input class="search-input" placeholder="" type="search" value="" name="search" id="search-input">
                <button class="search-submit" type="submit" value="">
                    <div id="search-icon">
                        <div id="search-line-1"></div>
                        <div id="search-line-2"></div>
                    </div>
                </button>
            </form>
        </div>
    </div>
    <!-- 02. Site Canvas-->
    <div id="site-canvas">
        <!-- 02-1. Mobile Menu -->
        <div id="mobile-menu" class="col-md-3">
            <!-- 02-1-1. Profile Photo -->
            <div class="profile">
                <?php
                if($homepage == $currentpage || $homepage2 == $currentpage || preg_match($access, $currentpage2)) {
                    ?><img src="opt-imgs/<?php echo $img; ?>" alt="<?php echo $userFirst?> profile image" class="rounded-circle" width="139" height="139" /><?php
                } else {
                    ?><img src="../opt-imgs/<?php echo $img; ?>" alt="<?php echo $userFirst?> profile image" class="rounded-circle" width="139" height="139" /><?php
                }
                ?>

                <!-- 02-1-2. User Details -->
                <h2><?php if(isset($userName)){ echo $userName; } ?></h2>
<!--                <h3>--><?php //if(isset($userEmail)){ echo $userEmail; } ?><!--</h3>-->
            </div>
            <!-- 02-1-3. Links -->
            <div class="nav-links">
                <ul>
                    <li class="link-hover"><a href="/health-hack/Dashboard" title="Dashboard Link">Dashboard</a></li>
                    <li class="link-hover"><a href="/health-hack/Calendar" title="Calendar Link">Calendar</a></li>
                    <li class="link-hover"><a href="/health-hack/FitnessProgress" title="Fitness Link">Fitness Progress</a></li>
                    <li class="link-hover"><a href="/health-hack/GymLocator" title="Gym Locator Link">Gym Locator</a></li>
                    <li class="link-hover"><a href="/health-hack/GroceryList" title="Nutrition Link">Nutrition</a></li>
                    <li class="link-hover"><a href="/health-hack/logout.php" title="Log Out Link" >Log Out</a></li>
                </ul>
            </div>
            </nav>
        </div>