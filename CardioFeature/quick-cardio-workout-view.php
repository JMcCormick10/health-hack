<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-09
 * Time: 9:39 PM
 */
require_once 'quick-cardio-workout.php';
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>

<div id="main-content" class="col-md-9 col-sm-9 col-xs-9 row">
    <div class="container">
        <form action="#" method="post">

            <div class="col-md-12 big-spacing">
                <h1 class="red">Quick Cardio Workout:</h1>
<!-- success-->
                <p>Here, you can quickly record a cardio workout without having to load a previously created cardio workout!</p>
            </div>
            <div class="form-field big-spacing col-md-6 offset-md-0 ">
                <h2 class="spacing">Name the Cardio Workout:</h2>
                <input value="<?php if (isset($type)) echo $type;?>" placeholder="Name of Cardio Workout" type="text" class="textInput" name="type"/><span class=" badge badge-danger"><?php if (isset($type_error)){echo $type_error;}?></span>
            </div>

            <div class="form-field big-spacing  col-md-9 offset-md-0 ">
                <h2 class="spacing">Enter the distance travelled:</h2>

                <select class="  col-md-3 col-sm-3 col-xs-3" name="cardio_distance">
                    <option  value="0">Total Distance</option>
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
                </select><span class=" badge badge-danger"><?php if (isset($distance_error)){ echo $distance_error;}?></span>
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
                <select class=" select-box col-md-2 col-sm-3 col-xs-1 offset-md-1" name="seconds">
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
                </select><span class=" badge badge-danger"><?php if(isset($time_error)){echo $time_error;}?></span>
            </div>

            <div class="form-field big-spacing">
                <input type="submit" value="Save Workout" class=" formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3" name="save_workout"/>
            </div>
        </form>
        <div class="row">
            <a href="Cardio.php" class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
            </a>
        </div>
    </div>
</div>
</main>
<?php
require_once '../Common Views/Footer.php';
?>
