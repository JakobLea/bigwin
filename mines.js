$(document).ready(function(){    
    loadstation();
});

function loadstation(){
    $("#coinCount").load("station.php");
    setTimeout(loadstation, 2000);
}

// function changeCoins(changeBy) {
//     var coins = $("#coins").val();

//     coins = coins + changeBy;

//     document.cookie = "coins=" + coins + "; max-age=5; path=/";
//     $("#coinCount").load("updateCoins.php");
// }