<?php 	

//localhost code
/*
$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "stock2";

$localhost = "sql485.your-server.de";
$username = "stock_2";
$dbname = "stock_2";
$password = "#Fastdeal24";

*/
$localhost = "sql286.your-server.de";
$username = "javy2021";
$password = "@Ja20vy20";
$dbname = "javy2021";




// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>