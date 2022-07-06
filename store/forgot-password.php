<?php 
session_start();

   if(isset($_SESSION['customerId'])) {
	header('location: orders.php');		
}
include 'header.php'; ?>
	<!-- //header --> 	
	<!-- login-page -->
	<div class="login-page">
		<div class="container"> 
			<h3 class="w3ls-title w3ls-title1">Forgot Password</h3> 

			<div id="forgot-password-messages"></div> 
			<div class="login-body">
				<form action="submit-forgot-password.php" method="post" id='forgotPasswordForm'>
					Enter your email below:
					<input id="email" type="text" class="user" name="email" placeholder="Enter your Email" required="">
					<input type="submit" id="submitButton" value="Submit">
					<div class="forgot-grid">
						
						
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
	$("#forgot-password-messages-messages").html("");



$("#forgotPasswordForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/


			var email=$("#email").val();

			

			if(email){

				
				var form =$(this);
				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){
					
						if(response.success == true){

							//reset the form text
							
						

							$("#forgot-password-messages").html('<div class="alert  alert-success" role="alert">'+'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+'</div>');

						

							
							//block double-clicking of a button
							$("#submitButton").attr("disabled", true);


							//remove the messages after 10 seconds
							

						}else{

							
								//reset the form text

							$("#forgot-password-messages").html('<div class="alert  alert-warning" role="alert">'+'<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> '+response.messages+'</div>');


						}//if */

					}, //success

					error: function(xhr, status, error) {
						var err = eval("(" + xhr.responseText + ")");
						alert(err.Message);
					}
				
				}); //ajax close
			
			}//if



			return false;
		});//submit categories form function


});
</script>