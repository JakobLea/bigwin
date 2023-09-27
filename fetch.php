<?php
error_reporting(0);
// make is suitable for SSE
header("Cache-Control: no-store");
header("Content-Type: text/event-stream");
// make connection with database
include("db_conn.php");

// lets continue to check data in database with loop
$p = '';
while(true){
// now fetch data from database
$result = $conn->query("SELECT * FROM user WHERE user_name='$uname'");
$r = array();
if($result->num_rows > 0){
    while($row = $result-> fetch_assoc()){
        // get all data in json from
        $r[] = $row;
    }
}
$n = json_encode($r);
if(strcmp($p, $n) !== 0){
    // here data will shown on change
    echo "data:" . $n . "\n\n";
    $p = $n;
}
// here data is shown each time
// but we need data when change
// mean when data add, update or delete then show only

// this will show data even the loading is not completed
ob_end_flush();
flush();

// sleep process for 1 sec
sleep(1);
// but still data will not show
}
?>