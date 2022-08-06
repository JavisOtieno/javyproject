<?php 
require_once 'php_action/core.php';
require_once '../subdomain_storename.php';


$errors = array();


if($_POST) {		

	$code = $_POST['code'];
	$code = $connect->real_escape_string($code);


	if(empty($code) ) {

		if($code == "") {
			$errors[] = "Please enter code sent to your phone number";
		} 

	} else {
			// exists

			$mainSql = "SELECT * FROM phone_verification_codes WHERE code = '$code' AND store_id = '$userId'";

			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {

			$userSql = "UPDATE users SET phone_verification_status=1 WHERE user_id = '$userId' ";

			$mainResult = $connect->query($userSql);
				
				header('location: dashboard.php');	
					
			} else{
				
				$errors[] = "Incorrect Verification Code";
			} // /else
		


		
	} // /else not empty username // password
	
} // /if $_POST

?>

<!DOCTYPE html>
<html>
<head>
	<title>Javy Store| Verify Phone Number</title>

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
						<h3 class="panel-title">Promoter : Verify Phone Number</h3>
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
						<?php

						if (isset($_GET['page'])){
							$requested_page=$_GET['page'];
						}else{
							$requested_page='dashboard';
						}

												?>

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?page='.$requested_page ?>" method="post" id="loginForm">
							<fieldset>
							  <div class="form-group">
									<label for="code" class="col-sm-5 control-label">Code</label>
									<div class="col-sm-7">
									  <input type="text" class="form-control" id="code" name="code" placeholder="Code" autocomplete="off" value="<?php echo isset($_POST['']) ? $_POST['code'] : '' ?>" />
									</div>
								</div>
								
															
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-8">
									  <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i> Verify</button>
									</div>
								</div>

								<!--<a href="ajax-sendcode.php"><h5 style="margin-top: 30px;" class="col-sm-offset-4 col-sm-8">Resend</h5></a>-->
								<a href="logout.php"><h5 style="margin-top: 30px;" class="col-sm-offset-4 col-sm-8">Log out </h5></a>

								

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







	