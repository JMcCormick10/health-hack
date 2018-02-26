<?php
/*Created By Rahul Malik*/
//session_start();
require_once '../redirect.php';
//require_once '../Models/Signup.php';
//require_once '../Models/Profile.php';
//$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
/* $db = new Signup();

$userId = $db->userInfo($user);
 */
//grab  user id, username
/* $id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email; */
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';

//$ModuleID=1;//get it from feature which is integrating this feature this system
if (isset($_POST['search']))
{
    //save the values

    $txtSearch = filter_input(INPUT_POST, 'search');
   

    require_once '../Models/Search.php';
    $SearchObj = new Search();
    $Result=$SearchObj->Search($txtSearch);
	
}
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row" >
  
 
        
		 <div id="SearchTitle">Search Results</div>
          <div id="ResultContainer">
			
            <?php 
				if(count($Result)>0)
				{
					for($i=0;$i<count($Result);$i++) {
		    ?>
					  <div class="ResultTitleDiv">
						<a href="search-details.php?id=<?php echo($Result[$i]['id']);?>&tab=<?php echo($Result[$i]['table']);?>"><?php echo($Result[$i]['title']);?> </a>
					  </div>
             
             <?php  } ?>
			 <div class="Spacer"></div><div id="TotalResultDiv">Total Results Found: <?php echo(count($Result));?></div>
			 <?php
				}
				else
				{
			?>
			    <div id="NoResultDiv">No Result Found.</div>
		    <?php
			    
				}
				
			 ?>
          </div>
        

</div>
<?php
require_once '../Common Views/Footer.php';
?>