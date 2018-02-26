$(document).ready(function() {
    var monthNames = ["January", "February", "March", "April", "May", "June", 
    "July", "August", "September", "October", "November", "December"];
    var d = new Date();
    var year = d.getFullYear();
    var years = [year - 1, year, year + 1];

    var monthControl = $("#strengthControls > div:nth-child(1) select");
    var yearControl = $("#strengthControls > div:nth-child(2) select");

    function formatMonth(month) {
        if (month < 10) return "0"+month;
        else return month;
    }

    $.each(monthNames, function(index) {
        monthControl.append($("<option />").val(formatMonth(index+1)).text(monthNames[index]));
    });

    $.each(years, function(index) {
        yearControl.append($("<option />").val(years[index]).text(years[index]));
    })

    var selmonth = monthControl.val();
    var selyear = yearControl.val();

    monthControl.change(function() {
        selmonth = monthControl.val();
    });

    yearControl.change(function() {
        selyear = yearControl.val();
    });

    $('#strengthProgress').click(function() {
        console.log(selyear + ":" +selmonth);
        $.getJSON('completedExerciseData.php', {month : selmonth, year: selyear}, function (data) {
            var ctx = document.getElementById("myChart");
            var labels = [];
            var datasets = [
                {
                    label: "Statistics",
                    borderWidth: 1,
                    data: []
                }
            ];
            $.each(data, function(index,exercise){
                labels.push(exercise.exercise_name);
                //console.log(exercise.exercise_id + ":" + exercise.exercise_name + ":" + exercise.SetSum);
                datasets[0].data.push(exercise.SetSum);
            });

            var data = {
                labels: labels,
                datasets: datasets
            }

            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
            });
        });
    });

    $('#cardioProgress').click(function() {
        console.log(selyear + ":" +selmonth);
        $.getJSON('completedCardioData.php', {month : selmonth, year: selyear}, function (data) {
            var ctx = document.getElementById("myChart");

            var labels = ["Distance", "Goal Distance"];
            var datasets = [
                {
                    label: "Statistics",
                    borderWidth: 1,
                    data: [],
                    backgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                    ]
                }
            ];

            $.each(data, function(index,crdexercise){
                datasets[0].data.push(crdexercise.distance);
                datasets[0].data.push(crdexercise.goal_distance);
            });

            var data = {
                labels: labels,
                datasets: datasets
            }

            var myPieChart = new Chart(ctx,{
                type: 'bar',
                data: data,
            });
        });
    });

});