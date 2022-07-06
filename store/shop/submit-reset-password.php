<?php

require('connect.inc.php');

if($_POST) {		

	$errors=[];

	$password = $_POST['password'];
	$user_id=$_POST['user_id'];
	$confirmPassword = $_POST['confirmPassword'];

	if(empty($password) || empty($password)) {
		if($password== "") {
			$errors[] = "Password is required";
		} 

		if($confirmPassword == "") {
			$errors[] = "Please Confirm Password";
		}
	} else {

		if($password==$confirmPassword) {
			$password = md5($password);
			// exists
			$mainSql = "UPDATE customers SET password = '$password' WHERE id='$user_id'";


			if($connect->query($mainSql)) {
				

				// set session
				session_start();
				$_SESSION['customerId'] = $user_id;

				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				//header('location: orders.php');
					
			} else{
				
				$errors[] = "Error updating your password. Please try again.";
			} // /else
		} else {		
			$errors[] = "Passwords don't match";		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST


 if($errors) {

 	$valid['success'] = false;
	$valid['messages'] = $errors[0];									
			}
	else{
		$valid['success'] = true;
	$valid['messages'] = "Password reset. Redirecting you to your account ...";
	}

	echo json_encode($valid);


?>