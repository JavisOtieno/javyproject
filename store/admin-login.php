<?php 

include 'header.php';

session_start();

if(isset($_SESSION['userId'])) {
	//header('location: http://localhost/websites/stock-2/dashboard.php');
	// for the web
	header('location: dashboard.php');	
}

$errors = array();

if(isset($_COOKIE['storename'])&&isset($_COOKIE['password'])){
$storename= $_COOKIE['storename'];
$password_cookie=$_COOKIE['password'];	

//login using cookie
$mainSql = "SELECT * FROM users WHERE storename = '$storename' AND password = '$password_cookie'";
if(filter_var($storename, FILTER_VALIDATE_EMAIL)) {
$mainSql = "SELECT * FROM users WHERE email = '$storename' AND password = '$password_cookie'";
}


			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];


				// set session
				$_SESSION['userId'] = $user_id;


				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				header('location: http://promote.javy.co.ke/dashboard.php');
}
}
//end of login using cookie



if($_POST) {		

	$storename = $_POST['storename'];
	$storename=$connect->real_escape_string($storename);
	$password = $_POST['password'];
	$password=$connect->real_escape_string($password);

	if(empty($storename) || empty($password)) {
		if($storename == "") {
			$errors[] = "Please enter your Storename or Email";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {

		//make state of email to be false as the default
		$email_entered=false;
		if(filter_var($storename, FILTER_VALIDATE_EMAIL)) {
			$sql = "SELECT * FROM users WHERE email = '$storename'";
			$email_entered=true;
		    }
		    else {
		        $sql = "SELECT * FROM users WHERE storename = '$storename'";
		    }



		
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);
			// exists

			$mainSql = "SELECT * FROM users WHERE storename = '$storename' AND password = '$password'";

			if($email_entered){
				$mainSql = "SELECT * FROM users WHERE email = '$storename' AND password = '$password'";
			}
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];


				if(isset($_POST['remember'])) {
					setcookie('storename',$storename,time() + (86400 * 30));
					setcookie('password',$password,time() + (86400 * 30));
				}else{
					setcookie('storename',$storename,time() + (3600 * 6));
					setcookie('password',$password,time() + (3600 * 6));
				}


				// set session
				$_SESSION['userId'] = $user_id;


				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				header('location: http://promote.javy.co.ke/dashboard.php');
					
			} else{
				
				$errors[] = "Incorrect Password";
			} // /else
		} else {		
			
			if($email_entered){
				$errors[] = "Incorrect Email. Please check your email and try again";
			}else{
				$errors[] = "Incorrect Storename. Please check your store name and try again";
			}		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>

<!DOCTYPE html>
<html>
<head>
	<title>Javy Store | Login</title>

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
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Store : Sign in</h3>
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
									<label for="storename" class="col-sm-5 control-label">Store Name or Email</label>
									<div class="col-sm-7">
									  <input type="text" class="form-control" id="storename" name="storename" placeholder="Store Name or Email" autocomplete="off" value="<?php echo isset($_POST['storename']) ? $_POST['storename'] : '' ?>" />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-5 control-label">Password</label>
									<div class="col-sm-7">
									  <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									
									<div class="col-sm-offset-5 col-sm-7">
									  <input type="checkbox"  id="password" name="remember" value="1" autocomplete="off" /> Remember me
									</div>

								</div>								
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-8">
									  <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i> Sign in</button>
									</div>
								</div>

								<a href="forgot-password.php"><h5 style="margin-top: 30px;" class="col-sm-offset-4 col-sm-8">Forgot password.</h5></a>

								<h5 style="margin-top: 10px;" class="col-sm-offset-4 col-sm-8">Don't have an account?</h5>
								<div class="col-sm-offset-4 col-sm-8">
								 <a href="signup.php">Register</button></a>
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
<?php include 'footer.php' ?>







	