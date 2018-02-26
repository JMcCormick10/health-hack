<?php
require_once '../redirect.php';

require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="container">
            <div class="row spacing">
                <!-- if a user has been redirected from another page with a  success message, display it here-->
                <span class="badge badge-success"><?php if (isset($_COOKIE['success'])){ echo $_COOKIE['success'];}?></span>
            </div>
        </div>
        <div id="feature-callouts" class="col-md-9 col-sm-9 col-12 row">
        <div class="feature col-md-6 col-sm-6 col-6">
                <a href="create-cardio.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/cardio-icon.png" alt="" />
                    </div>
                    <p class="text-center">Create Cardio Workout</p>
                </a>
            </div>
            <div class="feature col-md-6 col-sm-6 col-6">
                <a href="log-cardio.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/img2.png" alt="" />
                    </div>
                    <p class="text-center">Log a Cardio Workout</p>
                </a>
            </div>
            <div class="feature col-md-6 col-sm-6 col-6">
                <a href="quick-cardio-workout.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/img7.png" alt="" />
                    </div>
                    <p class="text-center">Quick Cardio Workout</p>
                </a>
            </div>
            <div class="feature col-md-6 col-sm-6 col-6">
                <a href="manage-cardio-workouts.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/manage.png" alt="" />
                    </div>
                    <p class="text-center">Manage Cardio Workouts</p>
                </a>
            </div>
            <div class="row offset-md-1 offset-sm-1 offset-xs-1">
                <a href="../index.php" class="btn btn-info btn-lg offset-md-0">
                    <span class="glyphicon glyphicon-circle-arrow-left">Back</span>
                </a>
            </div>
        </div>
    </div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
