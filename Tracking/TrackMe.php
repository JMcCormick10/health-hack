<?php
/*Created By Rahul Malik*/
//session_start();
require_once '../redirect.php';
//require_once '../Models/Signup.php';
//require_once '../Models/Profile.php';
//$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
/*$db = new Signup();

$userId = $db->userInfo($user);

//grab  user id, username
$id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email;*/

require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
<script src="/health-hack/Tracking/Scripts/script.js"></script>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
  <div>
    <form name="FrmTrack"  id="FrmTrack">
	 <input type="hidden" name="StartTime" id="StartTime" value="">
	 <input type="hidden" name="EndTime" id="EndTime" value="">
	 <input type="hidden" name="FromLatitude" id="FromLatitude" value="">
	 <input type="hidden" name="FromLongitude" id="FromLongitude" value="">
	 <input type="hidden" name="ToLatitude" id="ToLatitude" value="">
	 <input type="hidden" name="ToLongitude" id="ToLongitude" value="">
		<div id="StartDiv">
			        <a href="#" id="StartButton" class="btn btn-info btn-lg offset-md-0">
						<span class="glyphicon glyphicon-circle-arrow-left"></span>Start Tracking
					</a>

		
		</div>
		<div id="EndDiv">
		   <a href="#" id="EndButton" class="btn btn-info btn-lg offset-md-0">
						<span class="glyphicon glyphicon-circle-arrow-left"></span>End Tracking
					</a>
			
		</div>
		<div id="CalculateDiv">
		   <a href="#" id="CalculateButton" class="btn btn-info btn-lg offset-md-0">
						<span class="glyphicon glyphicon-circle-arrow-left"></span>Calculate Distance
					</a>
			
		</div>
		
	</form>
  </div>
  
</div>
<?php
require_once '../Common Views/Footer.php';
?>


