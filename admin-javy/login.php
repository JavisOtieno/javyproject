<?php 
require_once 'db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	header('location: index.php');

}

$errors = array();

if(isset($_COOKIE['username'])&&isset($_COOKIE['password'])){
$username= $_COOKIE['username'];
$password_cookie=$_COOKIE['password'];	

//login using cookie


$mainSql = "SELECT * FROM admins WHERE username = '$username' AND password = '$password_cookie'";

if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
$mainSql = "SELECT * FROM admins WHERE email = '$username' AND password = '$password_cookie'";
}

			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];


				// set session
				$_SESSION['userId'] = $user_id;


				header('location: index.php');
				
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
			$errors[] = "Please enter your username or Email";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {

		//make state of email to be false as the default
		$email_entered=false;
		if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$sql = "SELECT * FROM admins WHERE email = '$username'";
			$email_entered=true;
		    }
		    else {
		        $sql = "SELECT * FROM admins WHERE username = '$username'";
		    }



		
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);
			// exists

			$mainSql = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";

			if($email_entered){
				$mainSql = "SELECT * FROM admins WHERE email = '$username' AND password = '$password'";
			}
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];


				if(isset($_POST['remember'])) {
					setcookie('username',$username,time() + (86400 * 30));
					setcookie('password',$password,time() + (86400 * 30));
				}else{
					setcookie('username',$username,time() + (3600 * 6));
					setcookie('password',$password,time() + (3600 * 6));
				}


				// set session
				$_SESSION['userId'] = $user_id;


				header('location: index.php');
				
					
			} else{
				
				$errors[] = "Incorrect Password";
			} // /else
		} else {		
			
			if($email_entered){
				$errors[] = "Incorrect Email. Please check your email and try again";
			}else{
				$errors[] = "Incorrect username. Please check your username and try again";
			}		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>

<?php include 'connect.inc.php'; ?>

<html>
<head>

<!-- bootstrap -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <!-- bootstrap js -->
     <script src="jquery/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script> 



   </head>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Javy Administrator</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

</nav>



<body>


	<div class="container">
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Please Sign in</h3>
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
									<label for="username" class="col-sm-5 control-label">UserName or Email</label>
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







	