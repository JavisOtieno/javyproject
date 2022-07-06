<?php 
require_once 'php_action/db_connect.php';

$errors = array();

session_start();


if(isset($_GET['code'])){

	$hash=$_GET['code'];

	$sql = "SELECT * FROM reset_password_suppliers WHERE hash = '$hash'";
		$resultQueryRun = $connect->query($sql);

		if($resultQueryRun->num_rows==0){
			$user_id="invalid";
		}else{
			$result =$resultQueryRun->fetch_assoc();
		$user_id=$result['user_id'];
		}
		


}else {
	$errors[] = "Invalid link";
	$user_id="invalid";
}

if($_POST) {		

	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];

	if(empty($password) || empty($password)) {
		if($password== "") {
			$errors[] = "Password is required";
		} 

		if($confirmPassword == "") {
			$errors[] = "Please Confirm Password";
		}
	} else {

		if($password==$confirmPassword) {
			$password = md5($password);
			// exists
			$mainSql = "UPDATE suppliers SET password = '$password' WHERE id='$user_id'";


			if($connect->query($mainSql)) {
				

				// set session
				$_SESSION['supplierId'] = $user_id;

				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				header('location: dashboard.php');
					
			} else{
				
				$errors[] = "Error updating your password. Please try again.";
			} // /else
		} else {		
			$errors[] = "Passwords don't match";		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>

<!DOCTYPE html>
<html>
<head>
	<title>Javy | Login</title>

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


					<?php 
					if ($user_id=="invalid"){
						echo "<h1>Invalid details</h2>";
						echo "<!--";
					}
					?>




					<div class="panel-heading">
						<h3 class="panel-title">Change password</h3>
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

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?code='.$hash; ?>" method="post" id="loginForm">
							<fieldset>
							  <div class="form-group">
									<label for="password" class="col-sm-5 control-label">New Password</label>
									<div class="col-sm-7">
									  <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" value="" />
									</div>
								</div>
								<div class="form-group">
									<label for="confirmPassword" class="col-sm-5 control-label">Confirm Password</label>
									<div class="col-sm-7">
									  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" autocomplete="off" />
									</div>
								</div>								
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
									  <button type="submit" class="btn btn-default">Confirm password</button>
									</div>
								</div>

								
								

							</fieldset>
						</form>
					</div>

					<?php 
					if ($user_id=="invalid"){
						echo "-->";
					}
					?>
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







	