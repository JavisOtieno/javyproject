<?php 

session_start();

// echo $_SESSION['userId'];


if(!$_SESSION['userId']) {
	//header('location: http://localhost/websites/stock-2/login.php');
	// for the web	
	header('location: ../login.php');	
} 

$userId=$_SESSION['userId'];



?>