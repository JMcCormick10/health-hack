<?php
    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
?>
<div class='col-sm-9'>
    <div id='gymlist'>
        <h2>My Gyms</h2>
        <span id='success-msg' class='alert alert-success'></span>
        <?php if (isset($_SESSION['message'])) : ?>
            <?php if ($_SESSION['msgStatus'] === 0 ) { ?>
                <span class='alert alert-danger'><?php echo $_SESSION['message']; ?></span>
            <?php } else { ?>
                <span class='alert alert-success'><?php echo $_SESSION['message']; ?></span>
            <?php } ?>
        <?php unset($_SESSION['message']); unset($_SESSION['msgStatus']); ?>
        <?php endif; ?>
        <?php echo $gymObj->displayGymList(); ?>
    </div>
</div>
<?php
    require_once('../Common Views/Footer.php');
?>

<script type='text/javascript'>
    $("#success-msg").hide();
    $('#gymToChoose').click(function() {
        $.ajax({
            type: 'POST',
            url: '/health-hack/Gym/index.php',
            data: {'gymToChoose': $("input[name='gymtodef']:checked").val()},
            success: function() {
                $('.alert').hide();
                $("#success-msg").html("Default Gym was successfully changed").show();
            }
        });
    });
</script>