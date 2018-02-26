<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-09
 * Time: 9:26 PM
 */

require_once 'create-cardio.php';
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
<div class="container">
    <div class="col-md-12 big-spacing">
        <h1 class="red">Create a Cardio Workout</h1>
        <p>Here, you can create and store your own custom cardio workouts!</p>
        <!-- this is where success goes -->
    </div>

    <form action="#" method="post">
            <div class="form-field big-spacing col-md-6 offset-md-0">
                <h2 class="spacing">Name the Cardio Workout</h2>
                <input placeholder="Name of Cardio Workout" <?php if (isset($cardio_name)){ echo "value='" . $cardio_name ."'";}?> type="text" class="form-control col-md-9 col-sm-9 col-xs-9" name="cardio_name"/><span class="badge badge-danger"><?php if (isset($name_error)){ echo $name_error;}?></span>
</div>
<div class="form-field big-spacing col-md-6 offset-md-0">
    <h2 class="spacing">What type of Cardio is this workout?</h2>
    <input placeholder="Run, walk, bike etc" <?php if (isset($cardio_type)){ echo "value='" . $cardio_type ."'";}?> type="text" class="form-control col-md-9 col-sm-9 col-xs-9" name="cardio_type"/><span class="badge badge-danger"><?php if (isset($type_error)){ echo $type_error;}?></span>
</div>

<div class="form-field big-spacing col-md-9 offset-md-0">
    <h2 class="spacing">Enter a Goal for the Distance of your workout</h2>
    <select class=" col-md-3 col-sm-3 col-xs-1" name="cardio_distance">
        <option value="0">Goal Distance</option>
        <?php foreach (range(0, 100, 0.5) as $i) :?>
            <option <?php if(isset($cardio_distance) && $cardio_distance == $i){echo 'selected';}?> value="<?php echo  $i?>"><?php echo $i?></option>
        <?php endforeach;?>
    </select><span><span class="badge badge-danger"><?php if (isset($distance_error)){ echo $distance_error;}?></span>
</div>
<div class="form-field big-spacing offset-md-0">
    <h2 class="spacing">Enter your goal for the time to complete this workout:</h2>
    <select class="col-md-2 col-sm-3 col-xs-1 offset-md-0" name="hours">
        <option value="0">Hours</option>
        <?php foreach (range(0, 10, 1) as $i) :?>
            <option <?php if(isset($cardio_hours) && $cardio_hours == $i){echo 'selected';}?> value="<?php echo $i?>"><?php echo $i?></option>
        <?php endforeach ; ?>
    </select>
    <select class=" col-md-2 col-sm-3 col-xs-1 offset-md-1" name="minutes">
        <option value="0">Minutes</option>
        <?php foreach (range(0, 59, 1) as $i) :?>
            <option <?php if(isset($cardio_minutes) && $cardio_minutes == $i){echo 'selected';}?> value="<?php echo $i; ?>"><?php echo $i?></option>
        <?php endforeach ;?>
    </select>
    <select class=" col-md-2 col-sm-3 col-xs-1 offset-md-1" name="seconds">
        <option value="0">Seconds</option>
        <?php foreach (range(0, 59, 1) as $i) :?>
            <option <?php if(isset($cardio_seconds) && $cardio_seconds == $i){echo 'selected';}?> value="<?php echo $i; ?>"><?php echo $i?></option>
        <?php endforeach ;?>
    </select><span class="badge badge-danger"><?php if (isset($time_error)){echo $time_error;}?></span>
</div>
<div class="form-field big spacing">
    <input class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3" type="submit" name="submit_cardio"/>
</div>
</form>
    <div class="row">
        <a href="Cardio.php" class="btn btn-info btn-lg offset-md-0">
            <span class="glyphicon glyphicon-circle-arrow-left">Back</span>
        </a>
    </div>
</div>
</div>
</main>
<?php
require_once '../Common Views/Footer.php';
?>
