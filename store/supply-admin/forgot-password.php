<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['supplierId'])) {
	//header('location: http://localhost/websites/stock-2/dashboard.php');
	// for the web
	header('location: dashboard.php');	
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
		$sql = "SELECT * FROM suppliers WHERE email = '$email'";
		$result = $connect->query($sql);
		$user=$result->fetch_assoc();
		$user_id=$user['id'];
		$name=$user['name'];
		$random_hash = md5(uniqid(rand(), true));

		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

		if($result->num_rows > 0) {

			$date=time();

			$sql = "INSERT INTO reset_password_suppliers VALUES (NULL,'$user_id','$random_hash','$date')";
				
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
				$email_sendgrid->addContent("text/plain", "Hello, ".$name.". Use the following link to reset your password. http://www.supply.javy.co.ke/reset-password.php?code=".$random_hash );
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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Javy | Forgot Password</title>

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
</head>
<body>
	<div class="container">
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Please enter your registered email</h3>
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
								<?php if($success) {
								foreach ($success as $key => $value) {
									echo '<div class="alert alert-success" role="alert">
									<i class="glyphicon glyphicon-ok-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

						<h5 style="margin-top: 10px;"> We will send you a link to help you reset your password on your email.<br/><br/> Check your spam if you can't see the message on your email inbox.</h5>

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							<fieldset>
							  <div class="form-group">
									<label for="email" class="col-sm-3 control-label">Email </label>
									<div class="col-sm-9">
									  <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" />
									</div>
								</div>
															
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
									  <button type="submit" class="btn btn-default"> Send link</button>
									</div>
								</div>


								<h5 style="margin-top: 10px;" class="col-sm-offset-1 col-sm-10">Don't have an account?</h5>
								<div class="col-sm-offset-1 col-sm-10">
								 <a href="signup.php">Register</a>
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







	