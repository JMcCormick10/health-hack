<?php
    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
    echo $dty;
?>
    <div id='calendar-feature' class='col-md-9 col-sm-12'>
        <h3>Today is <?php echo date('d'); ?> <?php echo date('F'); ?> <?php echo date('l'); ?> <?php echo date('Y'); ?></h3>
        <p>Check out what is on Agenda</p>
        <p>Working hours for your gym</p>
        <div id='gym-hours' class='row'></div>
        <?php echo $calendar->drawMobile(); ?>
        <a href="/health-hack" class="btn btn-info btn-lg offset-md-0">
            <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
        </a>
    </div>
<?php
    require_once('../Common Views/Footer.php');
?>
<script type="text/javascript">
    var gymHours = [];
    var arr;

    $.ajax({
        url: "getDefaultGymHours.php",
        dataType: "json",
        success: function(data) {
            if (data.msg) {
                var elem = $('<p></p>').html("No Gym is currently selected!");
                $('#gym-hours').append(elem);
            }
            else if (data.result.opening_hours) {
                data.result.opening_hours.weekday_text.forEach(function(item) {
                    gymHours.push(item);
                });

                gymHours.forEach(function(item, index) {
                    var elemwrap;
                    var elem = $('<span></span>').html(item);
                    if (index % 2 === 0) {
                        elemwrap = $('<div class="col-sm-12 col-md-3"></div>').append(elem);
                        $('#gym-hours').append(elemwrap);
                    } else {
                        $('#gym-hours > div:last-child').append(elem);
                    }
                });
            } else {
                var elem = $('<p></p>').html("Working hours for selected gym aren't available online");
                $('#gym-hours').append(elem);
            }
        },
        error: function() {
            var elem = $('<p></p>').html("No Gym is currently selected!");
            $('#gym-hours').append(elem);
        }
    });
</script>