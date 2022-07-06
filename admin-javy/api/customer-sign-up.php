<?php 
require('../connect.inc.php');
require("../email-sendgrid/sendgrid-php.php"); 

session_start();


//getting the store id
/*
$query="SELECT * FROM `users` WHERE `storename` ='$storename'";

$query_run=mysqli_query($db_link,$query);

if($row=mysqli_fetch_assoc($query_run)){
	
	$id=$row['user_id'];
	$promoter_email=$row['email'];
	$firstname=$row['firstname'];

}
*/

$errors = array();
$signup_date=time();

if($_GET) {		

	$address = $connect->real_escape_string($_GET['address']);
	$name = $connect->real_escape_string($_GET['name']);
	$phonenumber = $connect->real_escape_string($_GET['phone']);
	$email = $connect->real_escape_string($_GET['email']);
	$password = $connect->real_escape_string($_GET['password']);

	

	if(  empty($name) || empty($phonenumber) || empty($email) || empty($password)  ) {

		

		if($name == "") {
			
			$errors[] = "Your Name is required";
		} 

		if($phonenumber == "") {
			
			$errors[] = "Phone is required";
		}

		if($email == "") {
			
			$errors[] = "Email is required";
		} 

		if($email2 != "") {
			
			$errors[] = "Success!";
		} 

		if($address == ""){
			
			
		}

		if($password == ""){
			
			$errors[] = "Password is required";
		}


	} else {


			$password = md5($password);

			// exists

			//random hash for email validation
			$random_hash = substr(md5(uniqid(rand(), true)), 16, 16); 

			$mainSql = "INSERT INTO customers VALUES (NULL,'$name','$phonenumber','$email','$address','$id',0,'$password','$signup_date')";

			
			//$mainSql = "SELECT * FROM users WHERE username = '$storename' AND password = '$password'";

					//check if email exists in database
		$sql_email_found = "SELECT * FROM customers WHERE email = '$email'";
		$result_email_found = $connect->query($sql_email_found);

		//get user id for session purposes
		if($row_email_found=mysqli_fetch_assoc($result_email_found)){
			$user_id=$row_email_found['id'];

			$password_from_database=$row_email_found['password'];

		}

		//checking if password has been set

		$signup_date=time();
		



		//Remove spaces from phone number
		$phonenumber=str_replace(' ', '', $phonenumber);

		//check if storename exists in database
		$sql_number_found = "SELECT * FROM customers WHERE phone= '$phonenumber'";
		$result_number_found = $connect->query($sql_number_found);

		//get user id for session purposes
		if($row_number_found=mysqli_fetch_assoc($result_number_found)){
			$user_id=$row_number_found['id'];
			echo $user_id;
			$password_from_database=$row_number_found['password'];
		}

		$password_set="not-set";


		if($result_number_found->num_rows > 0) {
			//acccount with the same phone number found

			//echo "Account with the same phone number has been found";
			//if password is less than 5
			if(strlen($password_from_database)==0){
				//echo "Password is not set. Update";
				$mainSql = "UPDATE customers SET password='$password' WHERE phone = '$phonenumber' ";
			}
			else{
				//echo "Password is set so display wrong password";
				$password_set="phone-password-found";

			}
			


		}else{
			//error when phone number exists on account with password set recommend Forgot Password
			//echo "Phone number doesn't exist.";
		}


		if($result_email_found->num_rows > 0 ) {

			//echo "Account with the email has been found";
			//account with the same email found

			if(strlen($password_from_database)==0){
				//echo "Password is not set. Update";
				$mainSql = "UPDATE customers SET password='$password' WHERE email= '$email' ";
			}
			else{
				//echo "Password is set so display wrong password";
				$password_set="email-password-found";

			}


			
		} else {	//error when email exists on account with password set recommend Forgot Password
					//echo "Email doesn't exist";
		} // /

		//echo $mainSql;

		//Make sure password is not set before we insert customers data
		if($password_set=="not-set"){
		
			if($mainResult = $connect->query($mainSql)) {

				if(!isset($user_id)){
					$user_id= $connect->insert_id;
				}
				
				//$value = $mainResult->fetch_assoc();
				//$user_id = $value['user_id'];

				$to      = 'javisotieno@gmail.com';
				$subject = 'NEW CUSTOMER REGISTRATION on '.$storename;
				$message = 'Name: '.$name.'
				'.'Phone: '.$phonenumber.'
				'.'Storename: '.$storename.'
				'.'Email: '.$email.'
				'.'Phone Number: '.$phonenumber;
				$headers = 'From: info@javytech.co.ke' .'
				'.
				'Reply-To: info@javytech.co.ke' .'
				'.
				'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);

				
				// Uncommented sign up notification for customers since we do not detect the storename on sign up

				/*

				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javy.co.ke", ucfirst($storename));
				$email_sendgrid->setSubject("SIGN UP SUCCESFUL");
				$email_sendgrid->addTo($email, $name);
				$email_sendgrid->addContent("text/plain", "Hello, ".$name.". Thank you for signing up on www.".ucfirst($storename).".av.ke . We're glad to have you as our customer " );
				
				$sendgrid = new \SendGrid('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');
				try {
				    //uncomment on upload
				    $response = $sendgrid->send($email_sendgrid);
				    
				     //print $response->statusCode() . "\n";
				     //print_r($response->headers());
				     //print $response->body() . "\n";
				} catch (Exception $e) {
				    //echo 'Caught exception: ',  $e->getMessage(), "\n";
				}

				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
				$email_sendgrid->setSubject("New Customer sign up on www.".$storename.".av.ke");
				$email_sendgrid->addTo($promoter_email, $firstname);
				$email_sendgrid->addContent("text/plain", "Hello, ".$firstname.". A new customer signed up on www.".$storename.".av.ke. Login to promote.javy.co.ke for details" );
				//$email_sendgrid->addContent("text", "<strong>and easy to do anywhere, even with PHP</strong>");
				$sendgrid = new \SendGrid('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');
				try {

					//uncomment on upload
				    $response = $sendgrid->send($email_sendgrid);
				    
				     //print $response->statusCode() . "\n";
				     //print_r($response->headers());
				     //print $response->body() . "\n";
				} catch (Exception $e) {
				    //echo 'Caught exception: ',  $e->getMessage(), "\n";
				}




			// Be sure to include the file you've just downloaded
// Specify your authentication credentials
$username   = "Javisotieno";
$apikey     = "d202356db965801d98ecc0421a039d71f85fe081840c5bd07338090a6cd92029";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
$firstdigit=substr($phonenumber, 0, 1);


if($firstdigit=='0'){
	$recipients = "+254".substr($phonenumber,1);
}elseif($firstdigit=='7'){
	$recipients = "+254".$phonenumber;
}elseif($firstdigit=='2'){
	$recipients = "+".$phonenumber;
}elseif($firstdigit=="+"){
	$recipients = $phonenumber;
}

//$recipients = "+254707641174,+254733YYYZZZ";

// And of course we want our recipients to know what we really do
$message    = strtoupper($storename)." : ".$name.", thank you for signing up on www.".($storename).".av.ke. We're glad to have you as our customer. ";

$gateway    = new AfricasTalkingGateway($username, $apikey);


try 
{ 

	//uncomment on upload

/*
  // Thats it, hit send and we'll take care of the rest. 
	
  //$results = $gateway->sendMessage($recipients, $message);
            
  foreach($results as $result) {
    // status is either "Success" or "error message"
    //echo " Number: " .$result->number;
    //echo " Status: " .$result->status;
    //echo " MessageId: " .$result->messageId;
    //echo " Cost: "   .$result->cost."\n";
  }
  //
}
catch ( AfricasTalkingGatewayException $e )
{
  //echo "Encountered an error while sending: ".$e->getMessage();
}
*/
				
				//header('location: orders.php');	

			} else{
				
				$errors[] = "Sorry. Something went wrong. Try again. Contact us if it persists";
			} // /else


		} else{

			if($password_set=="email-password-found"){
				$errors[] = "Email address already exists. Please Login or Try changing your password by clicking Forgot Password.";
			}
			elseif ($password_set=="phone-password-found") {
				$errors[] = "Phone number already exists. Please Login or Try changing your password by clicking Forgot Password.";
			}
		}

			 

		
	} // /else not empty username // password

	if($errors) {

 	$valid['success'] = false;
 	$valid['customer_id']=0;
	$valid['messages'] = $errors[0];									
			}
	else{
	$valid['success'] = true;
	$valid['customer_id']=$user_id;
	$valid['messages'] = "Sign up Succesful.";
	}

	
	
}else{

	$valid['success'] = false;
 	$valid['customer_id']=0;
	$valid['messages'] = "Enter Details";

} // /if $_POST

	echo json_encode($valid);



		

