<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-09
 * Time: 9:30 PM
 */
require_once 'log-cardio.php';
require_once '../Models/Signup.php';
require_once '../Models/Profile.php';
$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
$db = new Signup();

$userId = $db->userInfo($user);

//grab  user id, username
$id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email;

require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <form action="#" method="post">
            <div class="col-md-12 big-spacing">
                <h1 class="red">Begin a Cardio workout</h1>
                <p>Here, you can select a cardio workout you created, and log it to your profile!</p>
                <!-- success here -->
            </div>

            <h3 class=" offset-md-1 spacing">Load your workout here</h3>
            <div class="form-field big-spacing col-md9 offset-md-0">
                <h2 class="spacing">Select a cardio workout</h2>
                <select  name="cardio_workout" class="form-control col-md-9 col-sm-9 col-xs-9">
                    <option value="0">--Select--</option>
                    <?php
                    foreach ($cardio_workouts as $cardio):
                        ?>
                        <option <?php
                        if (isset($cardio_Workout) && $cardio_Workout['name'] == $cardio['name']) {
                            echo 'selected';
                        }
                        ?> ) value="<?php
                        echo $cardio['cardio_id'];
                        ?>"><?php
                            echo $cardio['name'];
                            ?></option>
                        <?php
                    endforeach;
                    ?>
                </select><span class="badge badge-danger"><?php if (isset($cardio_workout_error)){ echo $cardio_workout_error;}?></span>
            </div>

            <div class="form-field big-spacing">
                <input  type="submit" name="load_cardio" value="Load Details" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3 "/>
            </div>
            <h3 class="offset-md-1 spacing">Log your workout here </h3>



            <h4 class="text-left offset-md-4"><?php
                if (isset($cardio_Workout)) {
                    echo $cardio_Workout['name'];
                }
                ?></h4>

            <div class="row big-spacing">
                <h4 class=" text-left col-md-4 offset-md-0">Your goal Time: <?php
                    if (isset($cardio_Workout)) {
                        echo   $cardio_Workout['goal_time'];
                    }
                    ?></h4>
                <h4 class="text-left col-md-6 offset-md-0"">Your goal Distance in KM:<?php
                if (isset($cardio_Workout)) {
                    echo  $cardio_Workout['goal_distance'];
                }
                ?></h4>
            </div>


            <form action="#" method="post">
                <div class="form-field big-spacing col-md-9 offset-md-0">
                    <h2 class="spacing">Enter the distance travelled.</h2>
                    <select class=" col-md-3 col-sm-3 col-xs-3" name="cardio_distance">
                        <option value="0">Total Distance</option>
                        <?php
                        foreach (range(0, 100, 0.5) as $i):
                            ?>
                            <option <?php
                            if (isset($distance) && $distance == $i) {
                                echo 'selected';
                            }
                            ?> value="<?php
                            echo $i;
                            ?>"><?php
                                echo $i;
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select><span class="badge badge-danger"><?php if (isset($distance_error)){ echo $distance_error;}?></span>
                </div>
                <div class="form-field big-spacing offset-md-0">
                    <h2 class="spacing">Enter the time it took to complete the workout:</h2>
                    <select class=" col-md-2 col-sm-3 col-xs-1 offset-md-0" name="hours">
                        <option value="0">Hours</option>
                        <?php
                        foreach (range(0, 10, 1) as $i):
                            ?>
                            <option <?php
                            if (isset($hours) && $hours == $i) {
                                echo 'selected';
                            }
                            ?> value="<?php
                            echo $i;
                            ?>"><?php
                                echo $i;
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                    <select class=" col-md-2 col-sm-3 col-xs-1 offset-md-1" name="minutes">
                        <option value="0">Minutes</option>
                        <?php
                        foreach (range(0, 59, 1) as $i):
                            ?>
                            <option <?php
                            if (isset($minutes) && $minutes == $i) {
                                echo 'selected';
                            }
                            ?> value="<?php
                            echo $i;
                            ?>"><?php
                                echo $i;
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                    <select class=" col-md-2 col-sm-3 col-xs-1 offset-md-1" name="seconds">
                        <option value="0">Seconds</option>
                        <?php
                        foreach (range(0, 59, 1) as $i):
                            ?>
                            <option <?php
                            if (isset($seconds) && $seconds == $i) {
                                echo 'selected';
                            }
                            ?> value="<?php
                            echo $i;
                            ?>"><?php
                                echo $i;
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select><span class="badge badge-danger"><?php if(isset($time_error)){echo $time_error;}?></span>
                </div>


                <div class="form-field big-spacing">
                    <input type="hidden" name="cardio_workouts_id""/>
                    <input type="submit" value="Save Workout" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3" name="save_workout"/>
                </div>
                <div class="row">
                    <a href="Cardio.php" class="btn btn-info btn-lg offset-md-0">
                        <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
                    </a>
                </div>
                <div class="form-group">
                    <input type="hidden" value="<?php if (isset($cardio_id)) {echo $cardio_id;}?>"
                </div>
            </form>

    </div>
</div>
</main>
<?php
include '../Common Views/Footer.php';
?>
