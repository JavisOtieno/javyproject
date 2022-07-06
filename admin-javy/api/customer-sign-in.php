<?php 

require('../connect.inc.php');



$errors = array();


if($_GET) {		

	$phone_email = $_GET['phone_email'];
	$phone_email = $connect->real_escape_string($phone_email);
	$password = $_GET['password'];
	$password = $connect->real_escape_string($password);

	if(empty($phone_email) || empty($password)) {
		if($phone_email == "") {
			$errors = "Please enter your Phone number or Email";
		} 

		if($password == "") {
			$errors = "Password is required";
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
				$customer_id = $value['id'];
				$customer_phone = $value['phone'];
				$customer_name = $value['name'];
				$customer_email = $value['email'];
				$customer_delivery_details=$value['deliverydetails'];

				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				//header('location: orders.php');
					
			} else{
				
				$errors = "Incorrect Password";
			} // /else
		} else {		
			
			if($email_entered){
				$errors = "Incorrect Email. Please check your email and try again. Sign up if you don't have an account";
			}else{
				$errors = "Incorrect Phone Number. Please check your phone number and try again. Sign up if you don't have an account";
			}		
		} // /else
	} // /else not empty username // password
	
}else{
	$errors="Enter Details";
}

 if($errors) {

 	$valid['success'] = false;
 	$valid['user_id']=0;
	$valid['messages'] = $errors;									
			}
	else{

		$valid['success'] = true;
		$valid['customer_id']=$customer_id;
		$valid['customer_name']=$customer_name;
		$valid['customer_phone']=$customer_phone;
		$valid['customer_email']=$customer_email;
		$valid['customer_delivery_details']=$customer_delivery_details;

	$valid['messages'] = "Signin Succesful.";
	}

	echo json_encode($valid);
			?>
