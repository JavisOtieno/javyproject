<?php 

session_start();

require_once 'db_connect.php';

// echo $_SESSION['supplierId'];

if(!isset($_SESSION['supplierId'])) {
	//header('location: http://localhost/websites/stock-2/login.php');
	// for the web	
	header('location: index.php');	
} 

$userId=$_SESSION['supplierId'];



?>