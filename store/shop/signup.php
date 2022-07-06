<?php include 'header.php';?>
	<!-- //header --> 	
	<!-- sign up-page -->
	<div class="login-page">
		<div class="container"> 
			<h3 class="w3ls-title w3ls-title1">Create your account</h3> 
			<div id="signup-messages"></div>  
			<div class="login-body">
				<form action="submit-sign-up.php" method="post" id="signupForm">
					<input type="text" class="user" id="name" name="name" placeholder="Enter your Name" required="">
					<input type="text" class="user" id="phone" name="phone" placeholder="Enter your phone number" required="">
					<input type="text" class="user" id="email" name="email" placeholder="Enter your email" required="">
					<input type="text" class="user" id="email2" name="email2" placeholder="Enter your email" style="display: none;" >
					<input type="text" class="user" id="address" name="address" placeholder="Enter your delivery details (Location details)" required="">
					<input type="password" id="password" name="password" class="lock" placeholder="Password" required="">
					<input type="submit" value="Sign Up ">
					<div class="forgot-grid">
						<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Remember me</label>
						<div class="forgot">
							<a href="forgot-password.php">Forgot Password?</a>
						</div>
						<div class="clearfix"> </div>
					</div>
				</form>
			</div>  
			<h6>Already have an account? <a href="login.php">Login Now »</a> </h6>  
		</div>
	</div>
	<!-- //sign up-page --> 
	<?php include 'footer.php'; ?>

	<script type="text/javascript">
	
	$(document).ready(function(){
	$("#signup-messages").html("");



$("#signupForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/
			var name=$("#name").val();
			var phone=$("#phone").val();
			var email=$("#email").val();
			var address=$("#address").val();
			var password=$("#password").val();


			

			if(name&&phone&&email&&address&&password){

				
				var form =$(this);
				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){

						if(response.success == true){

							//reset the form text
							
					
							$("#signup-messages").html('<div class="alert  alert-success" role="alert">'+'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+'</div>');

							window.location.replace("orders.php");

							//remove the messages after 10 seconds
							

						}else{

								//reset the form text
								
							
						

							$("#signup-messages").html('<div class="alert  alert-warning" role="alert">'+'<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> '+response.messages+'</div>');


						}//if */

					} //success
				
				}); //ajax close
			
			}//if



			return false;
		});//submit categories form function


});
</script>