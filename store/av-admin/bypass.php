<?php

$user_id=$_GET['id'];

session_start();

// set session
				$_SESSION['userId'] = $user_id;


				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				header('location: dashboard.php');

?>