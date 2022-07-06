<?php 
require_once 'php_action/db_connect.php';

require_once '../subdomain_storename.php';

$query_username="SELECT * FROM `suppliers` WHERE `username` ='$storename'";
//get store_id for registration_purposes
$query_run_username = $connect->query($query_username);
if($row=mysqli_fetch_assoc($query_run_username)){
	$supplier_id=$row['id'];
	$products_type=$row['products'];
	//Temporary Applemall setup to ensure inclusion of all products

	if($products_type==1){
	$shop_type=0;
	}else if($products_type==0){
	$shop_type=4;
	}

}else{
	$supplier_id=0;
	$shop_type=0;
}

session_start();

if(isset($_SESSION['userId'])) {
	header('location: dashboard.php');		
}


$errors = array();

if($_POST) {		

	$storename = trim($connect->real_escape_string($_POST['storename']));
	$password = $connect->real_escape_string($_POST['password']);
	$firstname = trim($connect->real_escape_string($_POST['firstname']));
	$lastname = trim($connect->real_escape_string($_POST['lastname']));
	$phonenumber = $connect->real_escape_string($_POST['phonenumber']);
	$email = $connect->real_escape_string($_POST['email']);
	$email = trim($email);
	$email2 = $connect->real_escape_string($_POST['email2']);
	$password = $connect->real_escape_string($_POST['password']);

	if(strpos($firstname, 'http') !== false){
		$linkinstring=true;
	}
	else if(strpos($lastname, 'http') !== false){
		$linkinstring=true;
	}

	if( empty($storename) || empty($password) || empty($firstname) || empty($lastname) || empty($phonenumber) || empty($email) || empty($password) || !empty($email2) || $linkinstring ) {

		if($linkinstring) {
			$errors[] = "Valid Name is required";
		} 
		if($storename == "") {
			$errors[] = "Store / Website Name is required";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}

		if($firstname == "") {
			$errors[] = "First Name is required";
		} 

		if($lastname == ""){
			$errors[] = "Last Name is required";
		}

		if($phonenumber == ""){
			$errors[] = "Phone Number is required";
		}

		if($email == ""){
			$errors[] = "Email is required";
		}

		if($email2 != ""){
			$errors[] = "Success! Contact us on 0716545459 if you can't sign up.";
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

			$mainSql = "INSERT INTO users VALUES (NULL,'$storename','$password','$email','$phonenumber','$firstname','$lastname',1,'$time','$supplier_id','','','',0,'$random_hash','',0,$shop_type,'','',0,'','')";

			
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

				//mail($to, $subject, $message, $headers);


				require("email-sendgrid/sendgrid-php.php"); 
				// If not using Composer, uncomment the above line

				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javytech.co.ke", "Javy Technologies");
				$email_sendgrid->setSubject($subject);
				$email_sendgrid->addTo($to, 'Javis');
				$email_sendgrid->addContent("text/plain", $message );
				//$email_sendgrid->addContent( "text", "<strong>and easy to do anywhere, even with PHP</strong>");
				$sendgrid = new \SendGrid('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');
				try {
				    $response = $sendgrid->send($email_sendgrid);
				     //print $response->statusCode() . "\n";
				     //print_r($response->headers());
				     //print $response->body() . "\n";
				} catch (Exception $e) {
				    //echo 'Caught exception: ',  $e->getMessage(), "\n";
				}


				


				require("email-sendgrid/sendgrid-php.php"); 
				// If not using Composer, uncomment the above line

				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
				$email_sendgrid->setSubject("Confirm Email.");
				$email_sendgrid->addTo($email, $firstname);
				$email_sendgrid->addContent("text/plain", "Hello, ".$firstname.". Thank you for signing up on Javy. Click on the following link to confirm your account. http://promote.javy.co.ke/confirm-email.php?code=".$random_hash );
				//$email_sendgrid->addContent( "text", "<strong>and easy to do anywhere, even with PHP</strong>");
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
require_once('AfricasTalkingGateway.php');
// Specify your authentication credentials
$username   = "Javisotieno";
$apikey     = "fc8597cbed40cda6a2e7651458aa02b44b5a0a2c148557b39d371e1efe28d6af";
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

$from = "JAVY";

try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message, $from);
            
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
				$_SESSION['userId'] = $user_id;

				
				header('location: dashboard.php');	

			} else{
				
				$errors[] = "Sorry. Something went wrong. Try again. Contact us if it persists";
			} // /else
		}else{
			$errors[] = "Store Name already exists. Try and pick another. Contact us if you need help";
		}
		} else {	//error when email exists	
			$errors[] = "Email already exists. Contact us if you're sure the email is yours.";		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>

<!DOCTYPE html>
<html>
<head>
	<title>Javy | Signup</title>

	<!--favicon-->
	<link rel="icon" href="images-front/icon.png" />

<!--make it responsive-->
   <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">	

  <!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
  <!-- jquery ui -->  
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-68172934-5"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-68172934-5');
</script>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '703528689985924');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=703528689985924&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>
<body>
	<div class="container">
		<div class="col-md-5 col-md-offset-4" style="margin-top: 40px">
		<?php
			//display image or back to store link depending on whether supplier is accessing system from the promoter's website or from supply.javy.co.ke
			if ($host=='promote.javy.co.ke'){
				echo '<a href="http://www.javy.co.ke/index.php"><img src="assests/images/javy-promote-learn-more.jpg"></a>';
			}
			else{
				echo '<h1><a href=http://'.$host.' style="display: inline-block;color: #000;text-decoration: none;position: relative;font-weight: 700;" >Back to <span style="font-size: 1.7em;color: #F44336;vertical-align: sub;margin-right: 3px;">'.strtoupper(substr($storename, 0, 1)).'</span>'.substr($storename,1,mb_strlen($storename)-1).'</a></h1>';


			} 

			?>
		</div>
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Promoter : Sign Up</h3>
					</div>
					<div class="panel-body">

						<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							<fieldset>
							<div class="form-group">
									<label for="firstname" class="col-sm-4 control-label">First Name</label>
									<div class="col-sm-8">
									  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" autocomplete="off" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>" required />
									</div>
								</div>
							<div class="form-group">
									<label for="lastname" class="col-sm-4 control-label">Last Name</label>
									<div class="col-sm-8">
									  <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" autocomplete="off" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>" required />
									</div>
								</div>
								<script>
									function lettersOnly(input){
										var regex = /[^a-z0-9-]/gi;
										if(input.value.search(regex)>0){
											$('#store-name-error').html('Invalid character');

											//setTimeout("",3000);
											setTimeout("$('#store-name-error').html('');",1500);
										}
										else{
											//setTimeout("$('#store-name-error').html('');",1500);
											
										}
										input.value=input.value.replace(regex,"");

										
									}
								</script>
							  <div class="form-group">
									<label for="storename" class="col-sm-4 control-label">Store Name</label>
									<div class="col-sm-8">
									  <input type="text" class="form-control" id="storename" name="storename" placeholder="Store Name (New Website Name)" autocomplete="off" value="<?php echo isset($_POST['storename']) ? $_POST['storename'] : '' ?>" onkeyup="lettersOnly(this)" required/>
									</div>
									<div id="store-name-error" class="col-sm-offset-4 col-sm-8"></div>
								</div>
								<div class="form-group">
									<label for="phonenumber" class="col-sm-4 control-label">Phone Number</label>
									<div class="col-sm-8">
									  <input type="text" class="form-control" id="phonenumber" name="phonenumber" placeholder="Phone Number" autocomplete="off" value="<?php echo isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '' ?>" required/>
									</div>
								</div>
								<div class="form-group" style="display:none">
									<label for="Email2" class="col-sm-4 control-label">Email</label>
									<div class="col-sm-8">
									  <input type="email" class="form-control" id="email2" name="email2" placeholder="Email2" autocomplete="off" value="<?php echo isset($_POST['email2']) ? $_POST['email2'] : '' ?>"/>
									</div>
								</div>
								<div class="form-group">
									<label for="Email" class="col-sm-4 control-label">Email</label>
									<div class="col-sm-8">
									  <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"/>
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-4 control-label">Password</label>
									<div class="col-sm-8">
									  <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>" required/>
									</div>
								</div>								
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
									  <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i> Sign up</button>
									</div>
								</div>
								<h5 style="margin-top: 30px;" class="col-sm-offset-1 col-sm-10">Already have an account?</h5>
								<div class="col-sm-offset-2 col-sm-10">
								 <a href="login.php"> Sign In</a>
								 </div>
							</fieldset>
						</form>
					</div>
					<!-- panel-body -->
				</div>
				<!-- /panel -->
			</div>
			<!-- /col-md-4 -->
		</div>
		<!-- /row -->
	</div>
	<!-- container -->	
</body>
</html>







	