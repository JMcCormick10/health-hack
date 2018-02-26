<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-08
 * Time: 4:28 PM
 */
require_once 'manage-strength-workouts.php';
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';

?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="container">
            <form action="#" method="post">
                <h1 class="red">Manage Strength Workouts</h1>
                <p class="badge badge-success"><?php if (isset($success_message)){ echo $success_message;} ?></p>
                <p>Here, you can delete strength workouts. All instances of the strength workout will also be deleted in your completed strength workouts.</p>
                <p>If the workout is part of a routine, that routine will also be deleted.</p>

                <h2>Your Strength Workouts</h2>
                <?php foreach ($strength_workouts as $i):?>
                    <div class="checkbox">
                        <label><input type="checkbox" name="strength_check[]" value="<?php echo $i['strength_id']?>"><?php echo $i['strength_workout_name']?></label>
                    </div>
                <?php endforeach;?>

                <div class="big-spacing">
                    <input  type="submit" name="delete_strength" value="Delete Workouts" class="formSubmit offset-md-1 col-md-3 col-sm-6 col-xs-1 offset-sm-3    "/>
                </div>
                <div class="big-spacing">
                <span class="badge badge-danger"><?php if (isset($delete_error)){ echo $delete_error;}?></span>
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