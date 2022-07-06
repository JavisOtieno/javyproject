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
$success = array();



if($_POST) {		

	$email = $_POST['email'];
	

	if(empty($email) ) {
		if($email == "") {
			$errors[] = "Email is required";
		} 

	} else {
		$sql = "SELECT * FROM customers WHERE email = '$email'";
		$result = $connect->query($sql);
		$customer=$result->fetch_assoc();
		$customer_id=$customer['id'];
		$name=$customer['name'];
		$random_hash = md5(uniqid(rand(), true));

		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

		if($result->num_rows > 0) {

			$date=time();

			$sql = "INSERT INTO reset_password_customers VALUES (NULL,'$customer_id','$random_hash','$date')";
				
				$connect->query($sql);

				/*$to=$email;
				$subject = 'Reset Password';
				$message = "Use the following link to reset your password. http://www.javy.co.ke/reset-password.php?code=".$random_hash;
				$headers = 'From: info@javytech.co.ke' .'
				'.
				'Reply-To: info@javytech.co.ke';



				mail($to, $subject, $message, $headers);
				*/
				require("email-sendgrid/sendgrid-php.php"); 


				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
				$email_sendgrid->setSubject("Reset Password.");
				$email_sendgrid->addTo($email, $name);
				$email_sendgrid->addContent("text/plain", "Hello, ".$name.". Use the following link to reset your password. http://www.".$storename.".av.ke/reset-password.php?code=".$random_hash );
				//$email_sendgrid->addContent("text", "<strong>and easy to do anywhere, even with PHP</strong>");
				$sendgrid = new \SendGrid('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');
				try {
				    $response = $sendgrid->send($email_sendgrid);
				     //print $response->statusCode() . "\n";
				     //print_r($response->headers());
				     //print $response->body() . "\n";
				} catch (Exception $e) {
				    //echo 'Caught exception: ',  $e->getMessage(), "\n";
				}


				//for the web
				//header('location: http://javy.av.ke/dashboard.php');

				$success[]="Success. Reset password link sent to <strong>".$email."</strong>";
  
				
			}  // /else
		 else {		
			$errors[] = "The email is not registered with us. Register if you don't have an account";		
		} // /else
	}  
	else {
		 $errors[] = "Invalid email address!";
			}
		}
	
} // /if $_POST

 if($errors) {

 	$valid['success'] = false;
	$valid['messages'] = $errors[0];									
			}
	else{
		$valid['success'] = true;
	$valid['messages'] = "A password reset link has been sent to your email: ".$email.". Kindly check your email and use the link to reset your password";
	}

	echo json_encode($valid);

		


?>