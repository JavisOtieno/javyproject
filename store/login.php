<?php 
session_start();

   if(isset($_SESSION['customerId'])) {
	
	if(isset($_GET['source'])){
      	$source=$_GET['source'];

      	if($source=='messages'){
      		header('location: messages.php');	
      	}else{
      		header('location: orders.php');	
      }
}else{
      	header('location: orders.php');	
      }

}


include 'header.php'; ?>
	<!-- //header --> 	
	<!-- login-page -->
	<div class="login-page">
		<div class="container"> 
			<?php
      if(isset($_GET['source'])&&isset($_GET['message'])){
      	$source=$_GET['source'];
      	$message=$_GET['message'];
        echo "<h4 style='text-align:center;margin-bottom:30px;'><span style='margin-right:30px;'>".$message."</span></h4>";
        if($source=='order'){
        	echo '<h3 class="w3ls-title w3ls-title1">To view your order, login to your account</h4>';
        }else if($source=='message'){
        	echo '<h3 class="w3ls-title w3ls-title1">To view your message, login to your account</h4>';
        }
        
      }else{
      	$source='orders';
      	echo '<h3 class="w3ls-title w3ls-title1">Login to your account</h3>';
      }
      
      ?>
			

			 
			<div id="login-messages"></div> 
			<div class="login-body">
				<form action="submit-login.php" method="post" id='loginForm'>
					<input id="phone_email" type="text" class="user" name="phone_email" placeholder="Enter your phone number or Email" required="">
					<input id="password" type="password" name="password" class="lock" placeholder="Password" required="">
					<input type="submit" value="Login">
					<div class="forgot-grid">
						<label class="checkbox"><input type="checkbox" name="remember" value="1" checked="checked"><i></i>Remember me</label>
						<div class="forgot">
							<a href="forgot-password.php">Forgot Password?</a>
						</div>
						<div class="clearfix"> </div>
					</div>
				</form>
			</div>  
			<h6> Not a Member? <a href="signup.php">Sign Up Now »</a> </h6> 

			<!--
			<div class="login-page-bottom social-icons">
				<h5>Recover your social account</h5>
				<ul>
					<li><a href="#" class="fa fa-facebook icon facebook"> </a></li>
					<li><a href="#" class="fa fa-twitter icon twitter"> </a></li>
					<li><a href="#" class="fa fa-google-plus icon googleplus"> </a></li>
					<li><a href="#" class="fa fa-dribbble icon dribbble"> </a></li>
					<li><a href="#" class="fa fa-rss icon rss"> </a></li> 
				</ul> 
			</div>
			-->
		</div>
	</div>
	<!-- //login-page --> 
	<?php include 'footer.php'; ?>


	<script type="text/javascript">
	
	$(document).ready(function(){
	$("#login-messages").html("");



$("#loginForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/


			var phone_email=$("#phone_email").val();
			var password=$("#password").val();
			

			if(phone_email&&password){
				
				var form =$(this);
				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){
					
						if(response.success == true){

							//reset the form text
							
						

							$("#login-messages").html('<div class="alert  alert-success" role="alert">'+'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+'</div>');

							window.location.href = "login.php?source=message&message="+response.messages;

							//remove the messages after 10 seconds
							

						}else{

								//reset the form text


							
						

							$("#login-messages").html('<div class="alert  alert-warning" role="alert">'+'<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> '+response.messages+'</div>');


						}//if */

					} //success
				
				}); //ajax close
			
			}//if



			return false;
		});//submit categories form function


});
</script>