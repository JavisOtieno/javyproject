<?php
//web code

$localhost = "sql286.your-server.de";
$username = "javy2021";
$password = "@Ja20vy20";
$dbname = "javy2021";



$connect = new mysqli($localhost,$username, $password, $dbname);
$db_link= mysqli_connect($localhost,$username, $password, $dbname);


if($connect->connect_error){
	echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}

?>