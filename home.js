$(document).ready(function () {
  loadstation();
});

function loadstation() {
  $("#coinCount").load("station.php");
  setTimeout(loadstation, 2000);
}
