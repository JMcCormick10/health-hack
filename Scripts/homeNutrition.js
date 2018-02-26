//JSON call to todaysArrCall.php to grab today's input
var todaysArr = [];
$.getJSON('GroceryList/todaysArrCall.php', function(data){
    todaysArr.push(data.calories);
    todaysArr.push(data.carbs);
    todaysArr.push(data.cholesterol);
    todaysArr.push(data.fat);
    todaysArr.push(data.protein);
    todaysArr.push(data.sodium);
}); //end of json call

console.log(todaysArr);

//function to input data into chart js canvas called nutritionChart
var nutritionContext = document.getElementById('todaysFat').getContext('2d');
var nutritionChart = new Chart(nutritionContext, {
    type: 'doughnut',
    data: {
        borderWidth : 0,
        labels: ["Calories", "Fat", "Cholesterol", "Sodium", "Carbohydrates", "Protein"],
        datasets: [{
            borderWidth: 0,
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