<?php


require_once './Models/Signup.php';
require_once './Models/Profile.php';


// check if $_GET paramaters exist on incoming URI
if (isset($_GET['access_token'])) {
    $test = $_GET['access_token'];
    // var to hold URI from GET request (from email)
    $emailRefer = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    // set var to hold the value of the access_token from specific request
    $access_token = substr($emailRefer, strpos($emailRefer, "access_token=") +13);
    //echo $access_token;

    // new instance of Profile()
    $db = new Profile();

    // call GetUserIdByToken()
    $profile = $db->GetUserIdByToken($access_token);

    // initialize new SESSION variable
    $_SESSION['user'] = $profile->user_id;
    // set $user to $_SESSION['user']
    $user = $_SESSION['user'];
}else{
    $test = '';
}

require_once 'redirect.php';

// est. variable that contains session variable for email
$user = $_SESSION['user'];



//new instance of Signup()
$db = new Signup();


// call userInfo() method
$userId = $db->userInfo($user);
//grab username, email

// *** $id & $userFirst variables are needed for sidebar.php and need to be on every page
$userFirst = $userId->first_name;
$id = $userId->user_id;

$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email;
$list_id = $userId->list_id;



require_once 'Common Views/Header.php';
require_once 'Common Views/sidebar.php';

//progress section

require_once "Models/Database.php";
$dbConn = new Database();
$db = $dbConn->getDbFromAWS();

require_once "Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();

require_once "Models/FoodEntriesLunch.php";
$lunch = new FoodEntriesLunch();
$lunch->setUsersId($id);
$todaysEntries = $gListConn->populateTodaysFoodEntries($db, $lunch);

$todayArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

foreach ($todaysEntries as $today) {
    $todayArr['calories'] += $today->calories;
    $todayArr['fat'] += $today->fat;
    $todayArr['cholesterol'] += $today->cholesterol;
    $todayArr['sodium'] += $today->sodium;
    $todayArr['carbs'] += $today->carbs;
    $todayArr['protein'] += $today->protein;
}

$fatDV = round(($todayArr['fat'] / 65) * 100);
$cholesterolDV = round(($todayArr['cholesterol'] / 300) * 100);
$sodiumDV = round(($todayArr['sodium'] / 2400) * 100);
$carbsDV = round(($todayArr['carbs'] / 300) * 100);

?>
        <!-- Logout Modal -->

        <!-- 02-2-2. Main Content -->
        <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
            <!-- 02-2-2-1. Intro Banner -->
            <div id="intro-banner" class="col-md-12 col-sm-12 col-12">
                <h1>Welcome Back <?php echo $userName; ?>
                </h1>
            </div>
            <!-- 02-2-2-2. Feature Call Out -->
            <div id="feature-callouts" class="col-md-9 col-sm-9 col-12 row">
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="Routines/routines.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="./opt-imgs/routine-icon.png" alt="" />
                        </div>
                        <p class="text-center">Routines</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="GroceryList/FoodDiaryEntry.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/foodlog-icon.png" alt="" />
                        </div>
                        <p class="text-center">Food Diary</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="FitnessProgress/index.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/fitnessprogress-icon.png" alt="" />
                        </div>
                        <p class="text-center">Fitness Progress</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="CardioFeature/Cardio.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/cardio-icon.png" alt="" />
                        </div>
                        <p class="text-center">Cardio Workouts</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="GroceryList/statistics.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/foodgoals-icon.png" alt="" />
                        </div>
                        <p class="text-center">Nutrition Statistics</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="Strength/strength.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/strength-icon.png" alt="" />
                        </div>
                        <p class="text-center">Strength Workouts</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="Tracking/TrackMe.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/distance-icon.png" alt="" />
                        </div>
                        <p class="text-center">Track Distance</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="Gym" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/gymlocation-icon.png" alt="" />
                        </div>
                        <p class="text-center">Gyms</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="Dashboard/Friends.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/friends-icon.png" alt="" />
                        </div>
                        <p class="text-center">Friends</p>
                    </a>
                </div>
            </div>
            <!-- 02-2-2-3. Progress -->
            <div id="progress-recap" class="col-md-3 col-sm-3 col-12">
                <h2 class="light-grey">Progress</h2>
                <div class="col-md-10 col-sm-10 col-12">
                    <p class="text-center">Fat DV% Intake Total</p>
                    <div class="progress">
                        <div id="fat-progress" class="progress-bar" role="progressbar" aria-valuenow="<?php echo $fatDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $fatDV ?>%;">
                            <span id="fat-num"><?php echo $fatDV ?></span>%
                        </div>
                    </div>
                    <p class="text-center">Cholesterol DV% Intake Total</p>
                    <div class="progress">
                        <div id="chol-progress" class="progress-bar" role="progressbar" aria-valuenow="<?php echo $cholesterolDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $cholesterolDV ?>%;">
                            <span id="chol-num"><?php echo $cholesterolDV ?></span>%
                        </div>
                    </div>
                    <p class="text-center">Sodium DV% Intake Total</p>
                    <div class="progress">
                        <div id="sodium-progress" class="progress-bar" role="progressbar" aria-valuenow="<?php echo $sodiumDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $sodiumDV ?>%;">
                            <span id="sodium-num"><?php echo $sodiumDV ?></span>%
                        </div>
                    </div>
                    <p class="text-center">Carbs DV% Intake Total</p>
                    <div class="progress">
                        <div id="carbs-progress" class="progress-bar" role="progressbar" aria-valuenow="<?php echo $carbsDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $carbsDV ?>%;">
                            <span id="carbs-num"><?php echo $carbsDV ?></span>%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- 02-2-3. Footer -->
   <?php
    require_once 'Common Views/Footer.php';
    ?>

<script src="Scripts/progress.js"></script>
