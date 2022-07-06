<?php

require('connect.inc.php');

if($_POST) {		

	$errors=[];

	$password = $_POST['password'];
	$user_id=$_POST['user_id'];
	$confirmPassword = $_POST['confirmPassword'];
	$currentPassword = $_POST['currentPassword'];

	$sqlcustomer="SELECT * FROM customers WHERE id='$user_id'";
			$query_run_customer=mysqli_query($db_link,$sqlcustomer);
			if($row_customer=mysqli_fetch_assoc($query_run_customer)){
				$phone_email=$row_customer['phone'];
				$current_password_on_database=$row_customer['password'];
			}

	if(empty($password) || empty($password) || empty($currentPassword)) {
		if($password== "") {
			$errors[] = "Password is required";
		} 

		if($currentPassword == "") {
			$errors[] = "Current password is required";
		}

		if($confirmPassword == "") {
			$errors[] = "Please Confirm Password";
		}
	} else {

		if($password==$confirmPassword) {
			$password = md5($password);
			// exists
			$currentPassword = md5($currentPassword);
			

			

			if($currentPassword==$current_password_on_database){

			

			$mainSql = "UPDATE customers SET password = '$password' WHERE id='$user_id'";

			if($connect->query($mainSql)) {

				setcookie('phone_email',$phone_email,time() + (86400 * 366));
				setcookie('password',$password,time() + (86400 * 366));

				// set session
				session_start();
				$_SESSION['customerId'] = $user_id;

				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				//header('location: orders.php');
					
			} else{
				
				$errors[] = "Error updating your password. Please try again.";
			} // /else

		}else{
			$errors[] = "Incorrect current Password";
		}
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
	$valid['messages'] = "Password set. Redirecting you to your account ...";
	}

	echo json_encode($valid);


?>