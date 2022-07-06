<?php 
require_once 'php_action/db_connect.php';

session_start();

require_once '../subdomain_storename.php';



if(isset($_SESSION['supplierId'])) {
	//header('location: http://localhost/websites/stock-2/dashboard.php');
	// for the web
	header('location: dashboard.php');	
}

$errors = array();

if(isset($_COOKIE['username'])&&isset($_COOKIE['password'])){
$username= $_COOKIE['username'];
$password_cookie=$_COOKIE['password'];	




//login using cookie
$mainSql = "SELECT * FROM suppliers WHERE username = '$username' AND password = '$password_cookie'";
if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
$mainSql = "SELECT * FROM suppliers WHERE email = '$username' AND password = '$password_cookie'";
}


			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows > 0) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['id'];


				// set session
				$_SESSION['supplierId'] = $user_id;


				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				header('location: dashboard.php');
}
}
//end of login using cookie



if($_POST) {		

	$username = $_POST['username'];
	$username=$connect->real_escape_string($username);
	$password = $_POST['password'];
	$password=$connect->real_escape_string($password);

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Please enter your Username or Email";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {

		//make state of email to be false as the default
		$email_entered=false;
		if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$sql = "SELECT * FROM suppliers WHERE email = '$username'";
			$email_entered=true;
		    }
		    else {
		        $sql = "SELECT * FROM suppliers WHERE username = '$username'";
		    }



		
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);
			// exists

			$mainSql = "SELECT * FROM suppliers WHERE username = '$username' AND password = '$password'";

			if($email_entered){
				$mainSql = "SELECT * FROM suppliers WHERE email = '$username' AND password = '$password'";
			}
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['id'];


				if(isset($_POST['remember'])) {
					setcookie('username',$username,time() + (86400 * 30));
					setcookie('password',$password,time() + (86400 * 30));
				}else{
					setcookie('username',$username,time() + (3600 * 6));
					setcookie('password',$password,time() + (3600 * 6));
				}


				// set session
				$_SESSION['supplierId'] = $user_id;


				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				header('location: dashboard.php');
					
			} else{
				
				$errors[] = "Incorrect Password";
			} // /else
		} else {		
			
			if($email_entered){
				$errors[] = "Incorrect Email. Please check your email and try again";
			}else{
				$errors[] = "Incorrect Username. Please check your username and try again";
			}		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>

<!DOCTYPE html>
<html>
<head>
	<title>Javy Supply | Login</title>

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
  fbq('init', '267215030895608');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=267215030895608&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<!-- End Facebook Pixel Code -->
<!-- End Facebook Pixel Code -->


</head>
<body>
	<div class="container">
		<div class="col-md-5 col-md-offset-4" style="margin-top: 40px">

			<?php
			//display image or back to store link depending on whether supplier is accessing system from the promoter's website or from supply.javy.co.ke
			if ($host=='supply.javy.co.ke'){
				echo '<a href="http://www.javy.co.ke/supply-us.php"><img src="assests/images/javy-supply-learn-more.jpg"></a>';
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
						<h3 class="panel-title">Supply : Sign in</h3>
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
									<label for="username" class="col-sm-5 control-label">Username or Email</label>
									<div class="col-sm-7">
									  <input type="text" class="form-control" id="username" name="username" placeholder="Username or Email" autocomplete="off" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" />
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

								 <?php				if ($host=='promote.javy.co.ke'){

				echo "<h5 style='margin-top: 10px;' class='col-sm-offset-4 col-sm-8'>Don't have an account?</h5>
								<div class='col-sm-offset-4 col-sm-8'>
								 <a href='signup.php'>Register</button></a>
								 </div>";

			}

			?>

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







	