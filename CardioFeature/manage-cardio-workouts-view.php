<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 6:39 PM
 */
require_once 'manage-cardio-workouts.php';
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="container">
<form action="#" method="post">
    <h1 class="red">Manage Cardio Workouts</h1>
    <p class="badge badge-success"><?php if (isset($success_message)){ echo $success_message;} ?></p>
    <p>Here, you can delete cardio workouts. All instances of the cardio workout will also be deleted in your completed cardio workouts.</p>
    <p>If the workout is part of a routine, that routine will also be deleted.</p>

    <h2>Your Cardio Workouts</h2>
    <?php foreach ($cardio_workouts as $i):?>
                        <div class="checkbox">
                            <label><input type="checkbox" name="cardio_check[]" value="<?php echo $i['cardio_id']?>"><?php echo $i['name']?></label>
                        </div>
                    <?php endforeach;?>

            <div class="spacing">
                <input  type="submit" name="delete_cardio" value="Delete Cardio Workouts" class="formSubmit offset-md-1 col-md-3 col-sm-6 col-xs-1 offset-sm-3    "/>
            </div>
    <div class="spacing">
    <span class="badge badge-danger"><?php if (isset($delete_error)){ echo $delete_error;}?></span>
    </div>
</form>
            <div class="row">
                <a href="Cardio.php" class="btn btn-info btn-lg offset-md-0">
                    <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
                </a>
            </div>

        </div>
    </div>
    </div>
    </main>


<?php
require_once '../Common Views/Footer.php';
?>