<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-09
 * Time: 10:01 PM
 */
require_once 'log-strength.php';
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <form action="#" method="post">
        <div class="col-md-12 big-spacing">
            <h1 class="red">Log a Strength Workout</h1>
            <p>Here, you can select a strength workout you created, and log it to your profile!</p>
            <p class="badge badge-success"><?php if(isset($success_message)){echo $success_message;}?></p>
</div>

<h3 class=" offset-md-1 spacing">Load your workout here</h3>
<div class="form-field big-spacing col-md9 offset-md-0">
    <h2 class="spacing">Select a strength workout</h2>
    <select  name="strength_workout" class="form-control col-md-9 col-sm-9 col-xs-9">
        <option value="0">--Select--</option>
        <?php
        foreach ($strength_workouts as $strength):
            ?>
            <option <?php
            if (isset($strength_Workout)) {
                foreach ($strength_Workout as $key){
                    if ($key['strength_id'] == $strength['strength_id']){
                        echo 'selected ';
                    }

                }
            }
            ?>  value="<?php
            echo $strength['strength_id'];
            ?>"><?php
                echo $strength['strength_workout_name'];
                ?></option>
            <?php
        endforeach;
        ?>
    </select><span class="badge badge-danger"><?php if (isset($strength_workout_error)){ echo $strength_workout_error;}?></span>
</div>

<div class="form-field big-spacing">
    <input  type="submit" name="load_strength" value="Load Details" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3 "/>
</div>
<h3 class="offset-md-1 spacing">Log your workout here </h3>
<div class="table-responsive big-spacing">
    <table class="table">
        <thead>
        <tr>
            <th>Exercise</th>
            <th>Weight</th>
            <th>Set 1</th>
            <th>Set 2</th>
            <th>Set 3</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($strength_Workout)){
            require_once 'exercise-form.php';
        }?>


        </tbody>
    </table>
</div>
<div class="form-field big-spacing">
    <span class="badge badge-danger"><?php if (isset($weight_error)){echo $weight_error;}?></span>
    <span class="badge badge-danger"><?php if (isset($set_1_error)){ echo $set_1_error;}?></span>
    <input  type="submit" name="save_strength" value="Save Workout" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3    "/>
</div>
</form>
        <div class="row">
            <a href="strength.php" class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
            </a>
        </div>
</div>
</div>
</main>
<?php
require_once '../Common Views/Footer.php';
?>

