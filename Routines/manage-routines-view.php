<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 2:54 PM
 */
require_once 'manage-routines.php';
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="container">
            <form action="#" method="post">
                <div class="col-md-12 big-spacing">
                    <h1 class="red">Manage Routines</h1>
                    <p class="badge badge-success"><?php if (isset($success_message)){ echo $success_message;} ?></p>

                    <p>Here, you can set change the active routine in your calendar and delete routines you don't need.</p>
                    <h2>Set New Routine</h2>
                    <select class="form-control" name ="routine">
                        <?php foreach ($routines as $r):?>
                        <option value="<?php echo $r['routine_id']?>"><?php echo $r['name']?></option>
                    <?php endforeach;?>
                    </select>
        </div>
                <input  type="submit" name="set_active" value="Set as Active Routine" class="formSubmit offset-md-1 col-md-3 col-sm-6 col-xs-1 offset-sm-3    "/>


                <div class="col-md-12 big-spacing">
                    <h2>Delete Routines</h2>
                        <?php foreach ($routines as $i):?>
                            <div class="checkbox">
                            <label><input type="checkbox" name="routine_check[]" value="<?php echo $i['routine_id']?>"><?php echo $i['name']?></label>
                            </div>
                                <?php endforeach;?>

                </div>
                <div class="big-spacing">
                <input  type="submit" name="delete_routines" value="Delete Routines" class="formSubmit offset-md-1 col-md-3 col-sm-6 col-xs-1 offset-sm-3    "/>
                </div>
                <div class="spacing">
                    <span class="badge badge-danger"><?php if (isset($delete_error)){ echo $delete_error;}?></span>

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