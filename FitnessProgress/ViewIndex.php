<?php
    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
?>

<div id="fitness-progress" class='col-md-9 col-sm-12 col-12'>
    <h2>Find out your Fitness Progress</h2>
    <?php if ($action == "Index") { ?>
        <div id="progress-place" class="row">
            <div id="strength" class="col-sm-12">
                <form method="post">
                    <input type="submit" name="sbmStrength" class="btn btn-default" value="Strength" />
                </form>
            </div>
            <div id="cardio" class="col-sm-12">
                <form method="post">
                    <input type="submit" name="sbmCardio" class="btn btn-default" value="Cardio" />
                </form>
            </div>
        </div>
        <a href="/health-hack" class="btn btn-info btn-lg offset-md-0">
            <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
        </a>
    <?php } ?>

    <?php if ($action == "Strength" || $action == "Cardio") { ?>
    <a href="/health-hack/FitnessProgress" class="btn btn-info btn-lg offset-md-0">
        <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
    </a>
    <h3><?php echo $action; ?></h3>
        <div id="strengthControls">
            <div class="form-group">
                <select name="month" class="form-control">
                </select>
            </div>
            <div class="form-group">
                <select name="year" class="form-control">
                </select>
            </div>
            <div class="form-group">
                <?php if ($action == "Strength") { ?>
                    <input id="strengthProgress" type="submit" class="btn btn-info" value="Show Progress" />
                <?php } else { ?>
                    <input id="cardioProgress" type="submit" class="btn btn-info" value="Show Progress" />
                <?php } ?>
            </div>
        </div>
        <div id="chartPlace">
            <canvas id="myChart"></canvas>
        </div>
    <?php } ?>
</div>

<?php require_once('../Common Views/Footer.php'); ?>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<?php if ($action == "Strength" || $action == "Cardio") { ?>
<script src="../Scripts/strength.js"></script>
<?php } ?>

