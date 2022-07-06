<?php 

include 'header.php'; 

if(isset($_GET['code'])){

	$hash=$_GET['code'];

	$sql = "SELECT * FROM reset_password_customers WHERE hash = '$hash'";
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



?>
	<!-- //header --> 	
	<!-- login-page -->
	<div class="login-page">
		<div class="container"> 
			<h3 class="w3ls-title w3ls-title1">Reset Password</h3> 

			<?php 
					if ($user_id=="invalid"){
						echo "<h1>Invalid details</h1>";
						echo "<!--";
					}
					?>


			<div id="reset-password-messages"></div> 
			<div class="login-body">
				<form action="submit-reset-password.php" method="post" id='resetPasswordForm'>
					
					<input id="password" type="password" name="password" class="lock" placeholder="Password" required="">
					<input id="confirmPassword" type="password" class="user" name="confirmPassword" placeholder="Confirm Pasword" required="">
					<input hidden="hidden" value="<?php echo $user_id; ?>" name="user_id">
					<input type="submit" value="Submit">
					
				</form>
			</div>  
			

			<?php 
					if ($user_id=="invalid"){
						echo "-->";
					}
					?>

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
	$("#reset-password-messages").html("");



$("#resetPasswordForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/


			var password=$("#password").val();
			var confirmPassword=$("#confirmPassword").val();
			

			if(password&&confirmPassword){
				
				var form =$(this);
				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){
					
						if(response.success == true){

							//reset the form text
							
							$("#reset-password-messages").html('<div class="alert  alert-success" role="alert">'+'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+'</div>');

							$("#resetPasswordForm")[0].reset();
							
							//delay

								setTimeout(function() {
								    window.location.replace("orders.php");
								}, 2000);

							//reset the form text								         
								        
						
							//remove the messages after 10 seconds
							

						}else{

								//reset the form text


							
						

							$("#reset-password-messages").html('<div class="alert  alert-warning" role="alert">'+'<strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> '+response.messages+'</div>');


						}//if */

					} //success
				
				});//ajax close
			
			}//if



			return false;
		});//submit categories form function


});
</script>