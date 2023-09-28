$(document).ready(function(){    
    loadstation();
});

function loadstation(){
    $("#coinCount").load("station.php");
    let coins = document.getElementById("coins").innerHTML;
    setTimeout(loadstation, 2000);
}