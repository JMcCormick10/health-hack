<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 8:25 AM
 */
require_once 'create-routine.php';
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="container">


            <form action="#" method="post">
                <div class="col-md-12 big-spacing">
                    <h1 class="red">Set a Routine</h1>
                    <p>Here, you can create a routine by selecting a cardio and strength workout for each day of the week. Your routine will appear in your calendar so that you can easily schedule and complete workouts!</p>
                <span class="badge badge-danger"><?php if (isset($routine_name_error)){ echo $routine_name_error;}?></span>
                    <h2>Routine Name</h2>
                    <input placeholder="Provide Name for Workout Routine" <?php if (isset($routine_name)){ echo "value='" . $routine_name ."'";}?> type="text" class="form-control col-md-9 col-sm-9 col-xs-9" name="routine_name"/>

                    <div class="row">
                        <div class="col-md-3">
                            <h2>Monday</h2>
                            <select name="monday_cardio" class="form-control">
                                <option value="0">--Cardio--</option>
                                <?php
                                foreach ($cardio_workouts as $cardio):
                                    ?>
                                    <option  value="<?php
                                    echo $cardio['cardio_id'];
                                    ?>" <?php if (isset($monday_cardio) && $monday_cardio == $cardio['cardio_id']) echo 'selected';
                                        ?>><?php echo $cardio['name'];
                                    ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <select name="monday_strength" class="form-control">
                                <option value="0">--Strength--</option>
                                <?php
                                foreach ($strength_workouts as $strength):
                                    ?>
                                    <option
                                value="<?php
                                    echo $strength['strength_id'];
                                    ?>"<?php if (isset($monday_strength) && $monday_strength == $strength['strength_id']) echo 'selected';
                                    ?>><?php
                                        echo $strength['strength_workout_name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <h2>Tuesday</h2>
                            <select name="tuesday_cardio" class="form-control">
                                <option value="0">--Cardio--</option>
                                <?php
                                foreach ($cardio_workouts as $cardio):
                                    ?>
                                    <option value="<?php
                                    echo $cardio['cardio_id'];
                                    ?>"<?php if (isset($tuesday_cardio) && $tuesday_cardio == $cardio['cardio_id']) echo 'selected';
                                    ?>><?php
                                        echo $cardio['name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <select name="tuesday_strength" class="form-control">
                                <option value="0">--Strength--</option>
                                <?php
                                foreach ($strength_workouts as $strength):
                                    ?>
                                    <option value="<?php
                                    echo $strength['strength_id'];
                                    ?>"<?php if (isset($tuesday_strength) && $tuesday_strength == $strength['strength_id']) echo 'selected';
                                    ?>><?php
                                        echo $strength['strength_workout_name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <h2>Wednesday</h2>
                            <select name="wednesday_cardio" class="form-control">
                                <option value="0">--Cardio--</option>
                                <?php
                                foreach ($cardio_workouts as $cardio):
                                    ?>
                                    <option  value="<?php
                                    echo $cardio['cardio_id'];
                                    ?>"<?php if (isset($wednesday_cardio) && $wednesday_cardio == $cardio['cardio_id']) echo 'selected';
                                    ?>><?php
                                        echo $cardio['name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <select name="wednesday_strength" class="form-control">
                                <option value="0">--Strength--</option>
                                <?php
                                foreach ($strength_workouts as $strength):
                                    ?>
                                    <option  value="<?php
                                    echo $strength['strength_id'];
                                    ?>"<?php if (isset($wednesday_strength) && $wednesday_strength == $strength['strength_id']) echo 'selected';
                                    ?>><?php
                                        echo $strength['strength_workout_name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <h2>Thursday</h2>
                            <select name="thursday_cardio" class="form-control">
                                <option value="0">--Cardio--</option>
                                <?php
                                foreach ($cardio_workouts as $cardio):
                                    ?>
                                    <option  value="<?php
                                    echo $cardio['cardio_id'];
                                    ?>"<?php if (isset($thursday_cardio) && $thursday_cardio == $cardio['cardio_id']) echo 'selected';
                                    ?>><?php
                                        echo $cardio['name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <select name="thursday_strength" class="form-control">
                                <option value="0">--Strength--</option>
                                <?php
                                foreach ($strength_workouts as $strength):
                                    ?>
                                    <option value="<?php
                                    echo $strength['strength_id'];
                                    ?>"<?php if (isset($thursday_strength) && $thursday_strength == $strength['strength_id']) echo 'selected';
                                    ?>><?php
                                        echo $strength['strength_workout_name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row spacing">
                        <div class="col-md-4">
                            <h2>Friday</h2>
                            <select name="friday_cardio" class="form-control">
                                <option value="0">--Cardio--</option>
                                <?php
                                foreach ($cardio_workouts as $cardio):
                                    ?>
                                    <option  value="<?php
                                    echo $cardio['cardio_id'];
                                    ?>"<?php if (isset($friday_cardio) && $friday_cardio == $cardio['cardio_id']) echo 'selected';
                                    ?>><?php
                                        echo $cardio['name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <select name="friday_strength" class="form-control">
                                <option value="0">--Strength--</option>
                                <?php
                                foreach ($strength_workouts as $strength):
                                    ?>
                                    <option value="<?php
                                    echo $strength['strength_id'];
                                    ?>"<?php if (isset($friday_strength) && $friday_strength == $strength['strength_id']) echo 'selected';
                                    ?>><?php
                                        echo $strength['strength_workout_name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <h2>Saturday</h2>
                            <select name="saturday_cardio" class="form-control">
                                <option value="0">--Cardio--</option>
                                <?php
                                foreach ($cardio_workouts as $cardio):
                                    ?>
                                    <option  value="<?php
                                    echo $cardio['cardio_id'];
                                    ?>"<?php if (isset($saturday_cardio) && $saturday_cardio == $cardio['cardio_id']) echo 'selected';
                                    ?>><?php
                                        echo $cardio['name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <select name="saturday_strength" class="form-control">
                                <option value="0">--Strength--</option>
                                <?php
                                foreach ($strength_workouts as $strength):
                                    ?>
                                    <option  value="<?php
                                    echo $strength['strength_id'];
                                    ?>"<?php if (isset($saturday_strength) && $saturday_strength == $strength['strength_id']) echo 'selected';
                                    ?>><?php
                                        echo $strength['strength_workout_name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <h2>Sunday</h2>
                            <select name="sunday_cardio" class="form-control">
                                <option value="0">--Cardio--</option>
                                <?php
                                foreach ($cardio_workouts as $cardio):
                                    ?>
                                    <option  value="<?php
                                    echo $cardio['cardio_id'];
                                    ?>"<?php if (isset($sunday_cardio) && $sunday_cardio == $cardio['cardio_id']) echo 'selected';
                                    ?>><?php
                                        echo $cardio['name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <select name="sunday_strength" class="form-control">
                                <option value="0">--Strength--</option>
                                <?php
                                foreach ($strength_workouts as $strength):
                                    ?>
                                    <option value="<?php
                                    echo $strength['strength_id'];
                                    ?>"<?php if (isset($sunday_strength) && $sunday_strength == $strength['strength_id']) echo 'selected';
                                    ?>><?php
                                        echo $strength['strength_workout_name'];
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
        </div>
    </div>
        <span class="badge badge-danger"><?php if (isset($workout_error)){ echo $workout_error;}?></span>



    <!-- Modal attempt
                <button data-target="#set_active" data-toggle="modal"   type="button" name="save_routine" class="formSubmit">Save Routine</button>
                <div id="set_active" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times</button>
                                <h4 class="modal-header">Set as active Routine?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Choose yes for this routine to appear in your calendar</p>
                            </div>
                            <div class="modal-footer">
                                <input  type="submit" name="routine_yes" value="Yes" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3    "/>
                                <input  type="submit" name="routine_no" value="No" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3    "/>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="spacing">
                    <h2 class="text-center">Routine Options</h2>
                    <p class="spacing text-center">Click yes to make this routine your active routine in your calendar</p>
                    <input  type="submit" name="routine_yes" value="Yes" class="formSubmit offset-md-1 col-md-3 col-sm-6 col-xs-1 offset-sm-3    "/>
                    <input  type="submit" name="routine_no" value="No" class="formSubmit col-md-3 col-sm-6 col-xs-1 offset-sm-3    "/>
                </div>
            </form>
            <div class="row">
                <a href="routines.php" class="btn btn-info btn-lg offset-md-0">
                    <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
                </a>
            </div>
        </div>
    </div>
    </main>
<?php
require_once '../Common Views/Footer.php';
?>