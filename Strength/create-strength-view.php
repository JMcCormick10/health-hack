<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-09
 * Time: 9:57 PM
 */
require_once 'create-strength.php';
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <div class="col-md-12 big-spacing">
            <h1 class="red">Create a Strength Workout</h1>
            <p>Here, you can create and store your own custom strength workouts!</p>
        </div>
        <form action="#" method="post">
            <div class="form-field big-spacing col-md-6 offset-md-0">
                <h2 class="spacing">Name of Strength Workout</h2>
                <p class="badge badge-success"><?php if (isset($success_message)){ echo $success_message;} ?></p>

<input placeholder="Provide Name for Strength Workout" <?php if (isset($strength_name)){ echo "value='" . $strength_name ."'";}?> type="text" class="form-control col-md-9 col-sm-9 col-xs-9" name="strength_name"/>
</div><span class="badge badge-danger"><?php if (isset($strength_error)){ echo $strength_error;}?></span>
<div class="form-field big-spacing col-md-6 offset-md-0">
    <h2 class="spacing">Exercises</h2>
    <input placeholder="Add an exercise and hit ADD" type="text" class="form-control" id="ex_name" name="exercise_name"/>
</div>

<button type="button" id="add_ex" class="formSubmit ">Add exercise</button><span class="badge badge-danger exercise_error "></span>
<button type="button" id="delete_ex" class="formSubmit">Reset Exercises</button>

<h4>Your exercises</h4>
<span class="badge badge-danger"><?php if (isset($exercise_error)){ echo $exercise_error;}?></span>
<ul id="ex_list">

</ul>
<div class="big-spacing">
<input class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3" type="submit" name="submit_strength"/>

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