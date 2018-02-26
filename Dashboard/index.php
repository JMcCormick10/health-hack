<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Dashboard/index.php ==> allows users to change their profile information used for Health-hack (weight, profile image); also allows user to input their age
 */



require_once 'processImg.php';



require_once '../redirect.php';



//print_r($img);
if (isset($_POST['profileSubmit']))
{
    $file_error = $_FILES['profileImg']['error'];
    $file_size = $_FILES['profileImg']['size'];
    $file_name = $_FILES['profileImg']['name'];

    //newFileName ==> userFirst & userId
    $newFileName = basename($_FILES['profileImg']['name']);
    //print_r($newFileName);
    // form values
    $age = filter_input(INPUT_POST, "ProfileAge");
    $weight = filter_input(INPUT_POST, "ProfileWeight");


    $filename = pathinfo($file_name);
    $newFile = "userId=" . $id .".". $filename['extension'];
        //print_r($_FILES['profileImg']['tmp_name']);
    // call Image validation function(s)
    $img_error = ImgCode($file_error);
    $img_size = ImgSize($file_size);

    if($img_size === true && $img_error == true)
    {
        //folder to move the uploaded file . "user?" . $userName . "/"
        $target = "../opt-imgs/";
        // rename() file
        move_uploaded_file($_FILES['profileImg']['tmp_name'], $target.$newFile);

       // new instance of Profile
        $signup = new Profile();
        $signup->UserInfo($id,$age,$weight,$newFile);
        //var_dump($newFile);
        $success = "Successfully Updated Profile Information";
    }
    else
    {
        $error = "Unable to create Profile information. Please try again";
    }
}
if (isset($_POST['profileUpdate']))
{
    $file_error = $_FILES['profileImg']['error'];
    $file_size = $_FILES['profileImg']['size'];
    $file_name = $_FILES['profileImg']['name'];

    //newFileName ==> userFirst & userId
    $newFileName = basename($_FILES['profileImg']['name']);
    //print_r($newFileName);
    // form values
    $age = filter_input(INPUT_POST, "ProfileAge");
    $weight = filter_input(INPUT_POST, "ProfileWeight");

    // if user leaves $age, $weight, and $profile blank on update, keep old information
    if (empty($age))
    {
        $age = $results->age;
    }

    if (empty($weight))
    {
        $weight = $results->weight;
    }
    // check for empty on file upload, looking for error 4 (no file uploaded
    if ($_FILES['profileImg']['error'] == 4)
    {
        $newFile = $results->profile_image;
    }
    else
    {
        // upload new file
        $filename = pathinfo($file_name);
        $newFile = "userId=" . $id .".". $filename['extension'];

        $img_size = ImgSize($file_size);

        if($img_size === true)
        {
            //folder to move the uploaded file . "user?" . $userName . "/"
            $target = "../opt-imgs/";
            // move_uploaded_file()
            move_uploaded_file($_FILES['profileImg']['tmp_name'], $target.$newFile);


        }
        else
        {
            $error = "Unable to update Profile information. Please try again";
        }
    }

    // new instance of Profile
    $signup = new Profile();
    $signup->updateUserProfileInformation($age,$weight,$newFile,$id);
    $success = "Successfully Updated Profile Information";
}
require_once '../Common Views/Header.php';
require_once "../Common Views/sidebar.php";
?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <h2 class="h2 col col-md-8 text-center"><?php if(isset($userFirst)){ echo $userFirst; } ?>'s Dashboard</h2>
        <?php

        // if user has profile information on file, load information from PROFILE tbl
        if($results)
        {
            echo "<div class='text-center'>";
            echo "<h4 class='h3 col col-md-9'> Your recorded profile information: </h4>";
            echo "<h4 class='text-primary col col-md-9'> Age: " . $age . "</h4>";
            echo "<h4 class='text-primary col col-md-9'> Weight: " . $weight . "</h4>";
            echo "<img src='../opt-imgs/$img' 'alt='$userFirst profile image' class='rounded-circle' width='139' height='139' />";
            echo "</div>";

        ?>
        <p class="text-primary col col-md-8 text-center">Enter your age, weight, and profile image below</p>
        <p class="text-info col col-md-8 text-center"><?php if (isset($success)){ echo $success; }?></p>
        <p class="text-info col col-md-8 text-center"><?php if (isset($error)){ echo $error; }?></p>
        <form action="index.php" method="post" enctype="multipart/form-data" id="updateProfileInformation" class="rowSpace">
            <div class="form-field col col-md-8">
                <label class="formLabel">Age</label>
                <input type="text" class="textInput" title="Please enter a valid number" placeholder="Age" name="ProfileAge">
                <span class="text-info">Please enter your age</span>
            </div>
            <div class="form-field col col-md-8">
                <label class="formLabel">Weight</label>
                <input type="text" class="textInput" title="Please enter a valid number" placeholder="Weight" name="ProfileWeight">
                <span class="text-info">Please enter your weight</span>
            </div>
            <div class="form-field col col-md-8">
                <input type="file" name="profileImg">
                <span class="text-info">Please select an image to display for your profile</span>
            </div>
            <div class="form-field col-6 col-md-4">
                <input type="submit" class="formSubmit" name="profileUpdate" value="Update Profile">
                <?php
                }
                else
                {?>
                <p class="text-info col col-md-8 text-center"><?php if (isset($success)){ echo $success; }?></p>
                <p class="text-info col col-md-8 text-center"><?php if (isset($error)){ echo $error; }?></p>
                <form action="index.php" method="post" enctype="multipart/form-data" id="updateProfileInformation" class="rowSpace">
                    <div class="form-field col col-md-8">
                        <label class="formLabel">Age</label>
                        <input type="text" class="textInput" title="Please enter a valid number" placeholder="Age" name="ProfileAge">
                        <span class="text-info">Please enter your age</span>
                    </div>
                    <div class="form-field col col-md-8">
                        <label class="formLabel">Weight</label>
                        <input type="text" class="textInput" title="Please enter a valid number" placeholder="Weight" name="ProfileWeight">
                        <span class="text-info">Please enter your weight</span>
                    </div>
                    <div class="form-field col col-md-8">
                        <input type="file" name="profileImg">
                        <span class="text-info">Please select an image to display for your profile</span>
                    </div>
                    <div class="form-field col-6 col-md-4">
                <input type="submit" class="formSubmit" name="profileSubmit" value="Submit">
                <?php
                }?>
            </div>
        </form>

        <div class="row offset-md-1 offset-sm-1 offset-xs-1">
            <a href="../index.php" class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left">Home</span>
            </a>
            <a href="Friends.php" class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left">Friends</span>
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