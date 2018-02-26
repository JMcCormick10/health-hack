<?php
/*Created By Rahul Malik*/
//session_start();
require_once '../redirect.php';
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
//$user = $_SESSION['user'];  //get it from session
$ModuleID=1;//get it from feature which is integrating this feature this system
$Message='';
if (isset($_POST['RatNum']))
{
    //save the values

    $Description = filter_input(INPUT_POST, 'Description');
    $ModuleID = $_POST['ModuleID'];
    $RatNum = $_POST['RatNum'];
    $UserID = $user;

    require_once '../Models/Rating.php';
    $RatingObj = new Rating();
    $RatingObj->AddRating($UserID,$RatNum,$ModuleID,$Description);
    $Message = "Your rating has been saved to the system!";
    
	
}
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
	<div>
		<div id="MessageDiv">
  
			<?php echo($Message);?>
		</div>
		
	</div>
	<div class="col-md-12 row">
        <a href="/health-hack" class="btn btn-info btn-lg offset-md-0">
            <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
        </a>
    </div>
  
</div>
<?php

require_once '../Common Views/Footer.php';
?>
