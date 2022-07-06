<?php 
require_once '../connect.inc.php';


if($_GET) {		

	$storename = $connect->real_escape_string($_GET['storename']);
	$password = $connect->real_escape_string($_GET['password']);
	$firstname = $connect->real_escape_string($_GET['firstname']);
	$lastname = $connect->real_escape_string($_GET['lastname']);
	$phonenumber = $connect->real_escape_string($_GET['phonenumber']);
	$email = $connect->real_escape_string($_GET['email']);
	$email = trim($email);
	$password = $connect->real_escape_string($_GET['password']);

	if( empty($storename) || empty($password) || empty($firstname) || empty($lastname) || empty($phonenumber) || empty($email) || empty($password)  ) {
		if($storename == "") {
			$errors = "Store / Website Name is required";
		} 

		if($password == "") {
			$errors = "Password is required";
		}

		if($firstname == "") {
			$errors = "First Name is required";
		} 

		if($lastname == ""){
			$errors = "Last Name is required";
		}

		if($phonenumber == ""){
			$errors = "Phone Number is required";
		}

		if($email == ""){
			$errors = "Email is required";
		}




	} else {
		//check if email exists in database
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$result = $connect->query($sql);

		if($result->num_rows == 0) {

			//Make store name lowercase
			$storename=strtolower($storename);
			$storename=trim($storename);
			$storename = str_replace(' ','-',$storename);

		//check if storename exists in database
		$sql = "SELECT * FROM users WHERE storename = '$storename'";
		$result = $connect->query($sql);

		$sql2 = "SELECT * FROM suppliers WHERE username = '$storename'";
		$result2 = $connect->query($sql2);

		if($result->num_rows == 0 && $result2->num_rows == 0 && strtolower($storename)!='javy') {

			$password = md5($password);
			// exists

			//random hash for email validation
			$random_hash = substr(md5(uniqid(rand(), true)), 16, 16); 

			$time=time();

			$mainSql = "INSERT INTO users VALUES (NULL,'$storename','$password','$email','$phonenumber','$firstname','$lastname',1,'$time','','','',0,'$random_hash','',0,0,'','')";

			
			//$mainSql = "SELECT * FROM users WHERE username = '$storename' AND password = '$password'";
			


			if($mainResult = $connect->query($mainSql)) {
				$user_id= $connect->insert_id;
				//$value = $mainResult->fetch_assoc();
				//$user_id = $value['user_id'];

				$to      = 'javisotieno@gmail.com';
				$subject = 'NEW STORE REGISTRATION from'.$storename;
				$message = 'First Name: '.$firstname.'
				'.'Last Name: '.$lastname.'
				'.'Storename: '.$storename.'
				'.'Email: '.$email.'
				'.'Phone Number: '.$phonenumber;
				$headers = 'From: info@javytech.co.ke' .'
				'.
				'Reply-To: info@javytech.co.ke' .'
				'.
				'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);


				


				require("../email-sendgrid/sendgrid-php.php"); 
				// If not using Composer, uncomment the above line

				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
				$email_sendgrid->setSubject("Confirm Email.");
				$email_sendgrid->addTo($email, $firstname);
				$email_sendgrid->addContent("text/plain", "Hello, ".$firstname.". Thank you for signing up on Javy. Click on the following link to confirm your account. http://promote.javy.co.ke/confirm-email.php?code=".$random_hash );
				$email_sendgrid->addContent(
				    "text", "<strong>and easy to do anywhere, even with PHP</strong>"
				);
				$sendgrid = new \SendGrid('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');
				try {
				    $response = $sendgrid->send($email_sendgrid);
				     //print $response->statusCode() . "\n";
				     //print_r($response->headers());
				     //print $response->body() . "\n";
				} catch (Exception $e) {
				    //echo 'Caught exception: ',  $e->getMessage(), "\n";
				}




				// Be sure to include the file you've just downloaded
require_once('../AfricasTalkingGateway.php');
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
$message    = "JAVY : $firstname, welcome to Javy. www.".$storename.".av.ke is ready. Login to http://promote.javy.co.ke to manage your account. Our contact:0716545459";

$gateway    = new AfricasTalkingGateway($username, $apikey);


try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message);
            
  foreach($results as $result) {
    // status is either "Success" or "error message"
    //echo " Number: " .$result->number;
    //echo " Status: " .$result->status;
    //echo " MessageId: " .$result->messageId;
    //echo " Cost: "   .$result->cost."\n";
  }
}
catch ( AfricasTalkingGatewayException $e )
{
  //echo "Encountered an error while sending: ".$e->getMessage();
}





									

				// set session
				//$_SESSION['userId'] = $user_id;

				
				//header('location: dashboard.php');	

			} else{
				
				$errors = "Sorry. Something went wrong. Try again. Contact us if it persists";
			} // /else
		}else{
			$errors = "Store Name already exists. Try and pick another. Contact us if you need help";
		}
		} else {	//error when email exists	
			$errors = "Email already exists. Contact us if you're sure the email is yours.";		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
else {
	$errors = "Please Enter your details";
} // /if $_POST

if(empty($user_id)){
	$response = array('success' => false);
	$response['user_id']=0;
	$response['message']=$errors;

}else{
	$response = array('success' => true);
	$response['user_id']=$user_id;
	$response['message']="Sign up successful";
}
echo json_encode($response);
?>