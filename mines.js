$(document).ready(function(){    
    loadstation();
});

function loadstation(){
    $("#station_data").load("station.php");
    setTimeout(loadstation, 2000);
}