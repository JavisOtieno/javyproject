<?php

/*
$mysqli_host='localhost';
$mysqli_username='root';
$mysqli_password='';
$mysqli_database='stock2';
*/

//web code


$mysqli_host = "sql286.your-server.de";
$mysqli_username = "javy2021";
$mysqli_password = "@Ja20vy20";
$mysqli_database= "javy2021";



if($db_link=@mysqli_connect($mysqli_host,$mysqli_username,$mysqli_password,$mysqli_database))
{
	
}
$connect = new mysqli($mysqli_host,$mysqli_username, $mysqli_password, $mysqli_database);

if($connect->connect_error){
	echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}



?>