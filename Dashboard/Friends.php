<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 */




require_once '../redirect.php';
require_once '../Models/Validation.php';
require_once '../Models/Friends.php';

//// new instance of Friends()
$friend = new Friends();

//// Add a Friend
// if a request to add a friend is made
if(isset($_POST['AddFriend']))
{
    //grab form value
    $addFriend = filter_input(INPUT_POST, "FriendsName");

    // new instance of Validation class
    $validate = new Validation();

    // testEmail() ==> true if variable is valid email format; false if not
    $valEmail = $validate->testEmail($addFriend);

    //
    if($valEmail)
    {
        //validate friend exists
        $valid = $db->IsExistingUser($addFriend);

        // if $valid returns true ==> email is valid and belongs to a registered user
        if($valid)
        {
            $friend->addFriendByEmail($addFriend, $id, $userEmail);
            $AddFriendSuccess = "Successfully added friend";
        }
        else
        {
            $AddFriendError = "Couldn't find any people on file by that email";
        }
    }
    else
    {
        $AddFriendError = "Invalid email address";
    }

}

require_once '../Common Views/Header.php';
require_once "../Common Views/sidebar.php";
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <h2 class="h2 col col-md-8 text-center"><?php if(isset($userFirst)){ echo $userFirst; } ?>'s Friends</h2>
        <div class="row rowSpace">
        <!-- Add a friend -->
            <div class="col-x-6">
                <div class="text-center">
                    <h4 class="h3">Add A Friend</h4>
                    <p class="text-primary">Please enter the email of your friend below</p>
                    <form action="Friends.php" method="post" id="changeUserPassword">
                        <div class="form-field">
                            <label class="formLabel">Friends Email</label>
                            <input type="text" class="textInput" title="Email of Friend" placeholder="Email of Friends" name="FriendsName">
                        </div>
                        <div class="form-field">
                            <input type="submit" class="formSubmit" name="AddFriend" value="Add Friend">
                        </div>
                    </form>
                    <p class="badge badge-success"><?php if (isset($AddFriendSuccess)){ echo $AddFriendSuccess;}?></p>
                    <p class="badge badge-error"><?php if (isset($AddFriendError)){ echo $AddFriendError;}?></p>
                </div>
            </div>
        <!-- View Friends -->
            <div class="col-x-6">
                <div class="text-center">
                    <h4 class="h3">Current Friends</h4>
<!--                    <p class="text-primary">Hello World</p>-->
                    <?php
                        // displayFriends() ==> grabs details from all friend_id associated with a user_id
                        $viewFriends = $friend->displayFriends($id);
                        if($viewFriends)
                        {
                        foreach($viewFriends as $d)
                        {
                            $friendDetails = '';
                            $freindInfo = $db->userInfo($d);

                            $friendDetails .=   "<h5>" . $freindInfo->first_name . " " . $freindInfo->last_name . "</h5>";
                            echo $friendDetails;
                        }
                        }// end of conditional check (if $viewFreinds is set)
                    ?>
                </div>
            </div>
        <!-- Buttons to go back to Root/index.php, Dashboard/Index.php, resetPassword.php -->
        </div>
        <div class="row offset-md-1 offset-sm-1 offset-xs-1">
            <a href="../index.php" class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left">Home</span>
            </a>
            <a href="./index.php" class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left">Profile</span>
            </a>
            <a href=resetpassword.php class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left">Reset Password</span>
            </a>
        </div>
    </div> <!-- end of main-content div-->
</div> <!-- end of container div-->
</main>



<?php
require_once '../Common Views/Footer.php';
?>
