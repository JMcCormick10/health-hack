//when the DV% is over 100 present change colour
var fatProgress = document.querySelector("#fat-num");
var cholProgress = document.querySelector("#chol-num");
var sodiumProgress = document.querySelector("#sodium-num");
var carbsProgress = document.querySelector("#carbs-num");

var fatBg = document.querySelector("#fat-progress");
var cholBg = document.querySelector("#chol-progress");
var sodiumBg = document.querySelector("#sodium-progress");
var carbsBg = document.querySelector("#carbs-progress");

if (fatProgress.innerHTML >= 100){ fatBg.style.backgroundColor = "#e04152";}
if (cholProgress.innerHTML >= 100){ cholBg.style.backgroundColor = "#e04152";}
if (sodiumProgress.innerHTML >= 100){ sodiumBg.style.backgroundColor = "#e04152";}
if (carbsProgress.innerHTML >= 100){ carbsBg.style.backgroundColor = "#e04152";}
