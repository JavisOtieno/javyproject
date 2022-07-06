<?php
session_start();

   if(!isset($_SESSION['customerId'])) {
	header('location: login.php');		
}else{
	$customerId=$_SESSION['customerId'];
}


?>
<?php include 'header.php';

$sqlnumberexists="SELECT * FROM customers WHERE id=".$customerId;

$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

  if($row=mysqli_fetch_assoc($query_run_number_exists)){
  $customer_password=$row['password'];
  }
  ?>
	<!-- //header --> 	
	<!-- login-page -->
	<div class="login-page">
		<div class="container"> 

			       <div style="margin-bottom: 30px;">
      <a href="orders.php"><button type='button' class='btn btn-primary'>Orders</button></a>
      <a href="messages.php"><button type='button' class='btn btn-primary'>Messages</button></a>
      <a href="account-details.php"><button type='button' class='btn btn-primary'>Account Details</button></a>
      
      <a href="logout.php"><button type='button' class='btn btn-primary'>Log out</button></a>
    </div>
       <?php
      if($customer_password==''){
        echo "<a href='set-password.php'><h4 style='text-align:center;margin-bottom:30px;'><span style='margin-right:30px;'>Finish setting up your account by setting your password</span><button type='button' class='btn btn-primary'>Set Password</button></h4></a>";
      }
      
      ?>

			<h3 class="w3ls-title w3ls-title1">Change Password</h3> 

			


			<div id="reset-password-messages"></div> 
			<div class="login-body">
				<form action="submit-change-password.php" method="post" id='resetPasswordForm'>

					<input id="currentPassword" type="password" name="currentPassword" class="lock" placeholder="Current Password" required="">
					<input id="password" type="password" name="password" class="lock" placeholder="New Password" required="">
					<input id="confirmPassword" type="password" class="user" name="confirmPassword" placeholder="Confirm Pasword" required="">
					<input hidden="hidden" value="<?php echo $customerId; ?>" name="user_id">
					
					<input type="submit" value="Submit">
					
				</form>
			</div>  
			


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

