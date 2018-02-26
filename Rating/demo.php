<?php
/*Created By Rahul Malik*/
require_once '../redirect.php';
//require_once '../Models/Signup.php';
//require_once '../Models/Profile.php';
//$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
/* $db = new Signup();

$userId = $db->userInfo($user); */

//grab  user id, username
/* $id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email; */
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';


$ModuleID=1;
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
  <div>
  <script src="/health-hack/Rating/Scripts/script.js"></script>
    <?php require_once("../Rating/rating.php");?>
  </div>
</div>
<?php
require_once '../Common Views/Footer.php';
?>
