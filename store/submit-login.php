<?php 

require('connect.inc.php');
require('subdomain_storename.php');




session_start();

if(isset($_SESSION['customerId'])) {
	//header('location: http://localhost/websites/stock-2/dashboard.php');
	// for the web
	header('location: orders.php');	
}



$errors = array();

if(isset($_COOKIE['phone_email'])&&isset($_COOKIE['password'])){
$phone_email= $_COOKIE['phone_email'];
$password_cookie=$_COOKIE['password'];	




//login using cookie
$mainSql = "SELECT * FROM customers WHERE phone = '$phone_email' AND password = '$password_cookie'";
if(filter_var($storename, FILTER_VALIDATE_EMAIL)) {
$mainSql = "SELECT * FROM customers WHERE email = '$phone_email' AND password = '$password_cookie'";
}


			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$customer_id = $value['id'];


				// set session
				$_SESSION['customerId'] = $customer_id;


				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				header('location: orders.php');
}
}

//end of login using cookie


if($_POST) {		

	$phone_email = $_POST['phone_email'];
	$phone_email=$connect->real_escape_string($phone_email);
	$password = $_POST['password'];
	$password=$connect->real_escape_string($password);

	if(empty($phone_email) || empty($password)) {
		if($phone_email == "") {
			$errors[] = "Please enter your Phone number or Email";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {

		//make state of email to be false as the default
		$email_entered=false;
		if(filter_var($phone_email, FILTER_VALIDATE_EMAIL)) {
			$sql = "SELECT * FROM customers WHERE email = '$phone_email'";
			$email_entered=true;
		    }
		    else {
		        $sql = "SELECT * FROM customers WHERE phone = '$phone_email'";
		    }


		
		$result = $connect->query($sql);

		if($result->num_rows >= 1) {
			$password = md5($password);
			// exists

			$mainSql = "SELECT * FROM customers WHERE phone = '$phone_email' AND password = '$password'";

			if($email_entered){
				$mainSql = "SELECT * FROM customers WHERE email = '$phone_email' AND password = '$password'";
			}
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows > 0) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['id'];


				if(isset($_POST['remember'])) {
					setcookie('phone_email',$phone_email,time() + (86400 * 366));
					setcookie('password',$password,time() + (86400 * 366));
				}else{
					setcookie('phone_email',$phone_email,time() + (3600 * 6));
					setcookie('password',$password,time() + (3600 * 6));
				}


				// set session
				$_SESSION['customerId'] = $user_id;


				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				//header('location: orders.php');
					
			} else{
				
				$errors[] = "Incorrect Password";
			} // /else
		} else {		
			
			if($email_entered){
				$errors[] = "Incorrect Email. Please check your email and try again. Sign up if you don't have an account";
			}else{
				$errors[] = "Incorrect Phone Number. Please check your phone number and try again. Sign up if you don't have an account";
			}		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST

 if($errors) {
 	$valid['success'] = false;
	$valid['messages'] = $errors[0];
	}
	else{
	$valid['success'] = true;
	$valid['messages'] = "Login Succesful. Redirecting you...";
	}

	echo json_encode($valid);
			?>
