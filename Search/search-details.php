<?php
/*Created By Rahul Malik*/
//session_start();
require_once '../redirect.php';
//require_once '../Models/Signup.php';
//require_once '../Models/Profile.php';
//$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
//$db = new Signup();

//$userId = $db->userInfo($user);

//grab  user id, username
/* $id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email; */
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
//$ModuleID=1;//get it from feature which is integrating this feature this system
if (isset($_GET['id']))
{
    //save the values

    $SearchID = filter_input(INPUT_GET, 'id');
    $SearchTAB = filter_input(INPUT_GET, 'tab');

    require_once '../Models/Search.php';
    $SearchObj = new Search();
    $Result=$SearchObj->SearchDetail($SearchID,$SearchTAB);
	
}
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row" >
  
 
        
		 <div id="SearchTitle">Search Details</div>
		 <div id="ResultDetailContainer">
			  <div id="SearchDetailTitle"><?php echo($Result['title']);?></div>
			  <div id="ResultDetailDiv">
				<?php echo($Result['details']);?>
			  </div>
          </div>
        

</div>
<?php

require_once '../Common Views/Footer.php';
?>