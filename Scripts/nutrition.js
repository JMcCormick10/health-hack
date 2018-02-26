var todaysArr = [];
var sixDaysArr = [];
var fiveDaysArr = [];
var fourDaysArr = [];
var threeDaysArr = [];
var twoDaysArr = [];
var weeklyArr = [];


//$(document).ready(function(){

    //when the DV% is over 100 present change colour
    //var progressBar = document.querySelector(".progress-bar");
    //var progressValue = progressBar.value;
    //console.log(progressBar);

    //-------------------
    //add message to wait for load time
    var loadingDiv = document.getElementById('loading');
    var statsDiv = document.getElementById('stats');
    loadingDiv.style.display = 'block';
    statsDiv.style.display = 'none';
    //-------------------

    //JSON call to todaysArrCall.php to grab today's input
    $.getJSON('todaysArrCall.php', function(data){
        todaysArr.push(data.calories);
        todaysArr.push(data.carbs);
        todaysArr.push(data.cholesterol);
        todaysArr.push(data.fat);
        todaysArr.push(data.protein);
        todaysArr.push(data.sodium);
        console.log("todays data", data);
    }); //end of json call

    //JSON call to sixDaysAgoCall.php to grab six days ago input
    $.getJSON('SixDaysAgoCall.php', function(data){
        sixDaysArr.push(data.calories);
        sixDaysArr.push(data.carbs);
        sixDaysArr.push(data.cholesterol);
        sixDaysArr.push(data.fat);
        sixDaysArr.push(data.protein);
        sixDaysArr.push(data.sodium);
    }); //end of json call

    //JSON call to fiveDaysAgoCall.php to grab six days ago input

    $.getJSON('fiveDaysAgoCall.php', function(data){
        fiveDaysArr.push(data.calories);
        fiveDaysArr.push(data.carbs);
        fiveDaysArr.push(data.cholesterol);
        fiveDaysArr.push(data.fat);
        fiveDaysArr.push(data.protein);
        fiveDaysArr.push(data.sodium);
    }); //end of json call

    //JSON call to fourDaysAgoCall.php to grab six days ago input

    $.getJSON('fourDaysAgoCall.php', function(data){
        fourDaysArr.push(data.calories);
        fourDaysArr.push(data.carbs);
        fourDaysArr.push(data.cholesterol);
        fourDaysArr.push(data.fat);
        fourDaysArr.push(data.protein);
        fourDaysArr.push(data.sodium);
    }); //end of json call

    //JSON call to threeDaysAgoCall.php to grab six days ago input

    $.getJSON('threeDaysAgoCall.php', function(data){
        threeDaysArr.push(data.calories);
        threeDaysArr.push(data.carbs);
        threeDaysArr.push(data.cholesterol);
        threeDaysArr.push(data.fat);
        threeDaysArr.push(data.protein);
        threeDaysArr.push(data.sodium);
    }); //end of json call

    //JSON call to twoDaysAgoCall.php to grab six days ago input
    $.getJSON('twoDaysAgoCall.php', function(data){
        twoDaysArr.push(data.calories);
        twoDaysArr.push(data.carbs);
        twoDaysArr.push(data.cholesterol);
        twoDaysArr.push(data.fat);
        twoDaysArr.push(data.protein);
        twoDaysArr.push(data.sodium);
    }); //end of json call

    //JSON call to weeklyArrCall.php to grab weekly input
    $.getJSON('weeklyArrCall.php', function(data){
        weeklyArr.push(data.calories);
        weeklyArr.push(data.carbs);
        weeklyArr.push(data.cholesterol);
        weeklyArr.push(data.fat);
        weeklyArr.push(data.protein);
        weeklyArr.push(data.sodium);
        loadingDiv.style.display = 'none';
        statsDiv.style.display = 'block';
        callCharts();
    }); //end of json call

    function callCharts() {
        //function to input data into chart js canvas called nutritionChart
        var nutritionContext = document.getElementById('nutritionChart').getContext('2d');
        var nutritionChart = new Chart(nutritionContext, {
            type: 'doughnut',
            data: {
                labels: ["Calories", "Fat", "Cholesterol", "Sodium", "Carbohydrates", "Protein"],
                datasets: [{
                    backgroundColor: [
                        "#35adda",
                        "#e04152",
                        "#434a54",
                        "#ffcf48",
                        "#8cc34b",
                        "#ccd0d9"
                    ],
                    data: todaysArr//[cals, fat, cholesterol, sodium, carbs, protein]
                }] //end datasets
            }, //end data
            options: {
                legend: {
                    display: true,
                    position: 'bottom'
                },
                cutoutPercentage: 65
            }//end options
            }); //end nutritionChart var

        //--------------------------

        //function to input data into chart js canvas called nutritionChart
        var weeklyContext = document.getElementById('weeklyNutritionChart').getContext('2d');
        var weeklyNutritionChart = new Chart(weeklyContext, {
            type: 'doughnut',
            data: {
                labels: ["Calories", "Fat", "Cholesterol", "Sodium", "Carbohydrates", "Protein"],
                datasets: [{
                    backgroundColor: [
                        "#35adda",
                        "#e04152",
                        "#434a54",
                        "#ffcf48",
                        "#8cc34b",
                        "#ccd0d9"
                    ],
                    data: weeklyArr//[cals, fat, cholesterol, sodium, carbs, protein]
                }] //end datasets
            },
            options: {
                legend: {
                    display: true,
                    position: 'bottom'
                },
                cutoutPercentage: 65
            }//end options//end data
        }); //end nutritionChart var

        //--------------------------

        //function to input data into chart js canvas called nutritionChart
        var weekContext = document.getElementById('weekResults').getContext('2d');
        var weekResults = new Chart(weekContext, {
            type: 'line',
            data: {
                labels: ["6 Days Ago", "5 Days Ago", "4 Days Ago", "3 Days Ago", "2 Days Ago", "Today"],
                datasets: [{
                    label: 'Calories',
                    data: [sixDaysArr[0], fiveDaysArr[0], fourDaysArr[0], threeDaysArr[0], twoDaysArr[0], todaysArr[0]],
                    borderColor: "#35adda",
                    backgroundColor: "transparent"
                },{
                    label: 'Carbs',
                    data: [sixDaysArr[1], fiveDaysArr[1], fourDaysArr[1], threeDaysArr[1], twoDaysArr[1], todaysArr[1]],
                    borderColor: "#8cc34b",
                    backgroundColor: "transparent"
                },{
                    label: 'Cholesterol',
                    data: [sixDaysArr[2], fiveDaysArr[2], fourDaysArr[2], threeDaysArr[2], twoDaysArr[2], todaysArr[2]],
                    borderColor: "#434a54",
                    backgroundColor: "transparent"
                },{
                    label: 'Fat',
                    data: [sixDaysArr[3], fiveDaysArr[3], fourDaysArr[3], threeDaysArr[3], twoDaysArr[3], todaysArr[3]],
                    borderColor: "#e04152",
                    backgroundColor: "transparent"
                },{
                    label: 'Protein',
                    data: [sixDaysArr[4], fiveDaysArr[4], fourDaysArr[4], threeDaysArr[4], twoDaysArr[4], todaysArr[4]],
                    borderColor: "#ccd0d9",
                    backgroundColor: "transparent"
                },{
                    label: 'Sodium',
                    data: [sixDaysArr[5], fiveDaysArr[5], fourDaysArr[5], threeDaysArr[5], twoDaysArr[5], todaysArr[5]],
                    borderColor: "#8cc34b",
                    backgroundColor: "transparent"
                }] //end datasets
            },
            options: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }//end options//end data
        }); //end nutritionChart var
    }

//}); //end of page load



