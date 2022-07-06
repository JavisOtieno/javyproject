<?php include 'header-front.php'; ?>



	<!-- banner -->
<div class="banner_inner_content_agile_w3l">
	
</div>
	<!--//banner -->
		<!-- /inner_content -->
	<div class="banner-bottom">
		<div class="container">
			<div class="inner_sec_info_agileits_w3">
              <h2 class="heading-agileinfo">Contact Us<span>Location : Nairobi, Kenya<br/><br/>Phone Number : 0716 545459<br/><br/>Email : <i style="text-transform: lowercase;">info@javy.co.ke</i></span></h2>

              <?php
              if($_POST){
               echo '<div class="alert alert-success" role="alert">
					<strong>Message Received!</strong> We will get back to you.
				</div>';
              }
             ?>
				<div class="contact-form">
					     <form method="post" action="contact-us.php">
							 <div class="left_form">
					    	<div>
						    	<span><label>Name</label></span>
						    	<span><input name="userName" type="text" class="textbox" required=""></span>
						    </div>
						    <div>
						    	<span><label>E-mail</label></span>
						    	<span><input name="userEmail" type="text" class="textbox" required=""></span>
						    </div>
						    <div>
						     	<span><label>Phone Number</label></span>
						    	<span><input name="userPhone" type="text" class="textbox" ></span>
						    </div>
					    </div>
					    <div class="right_form">
								<div>					    	
									<span><label>Message</label></span>
									<span><textarea name="Message" required=""> </textarea></span>
								</div>
							   <div>
									<span><input type="submit" value="Submit" class="myButton"></span>
							  </div>
					    </div>
					    <div class="clearfix"></div>
						</form>
				  </div>
				 			</div>

				 			

				 			  <?php
				 			       //PHP MAIL DOES NOT WORK ON LOCALHOST. UNCOMMENT ON UPLOAD
				 			  if($_POST){

				 			  	$name=$_POST['userName'];
				 			  	$email=$_POST['userEmail'];
				 			  	$phone=$_POST['userPhone'];
				 			  	$message=$_POST['Message'];

									$to      = 'javisotieno@gmail.com';
									$subject = 'CONTACT ON JAVY.CO.KE from'.$name;
									$message = 'Name: '.$name.'
									'.'Email: '.$email.'
									'.'Phone: '.$phone.'
									'.'Message: '.$message;
									$headers = 'From: info@javytech.co.ke' .'
									'.
									    'Reply-To: info@javytech.co.ke' .'
									    '.
									    'X-Mailer: PHP/' . phpversion();

									mail($to, $subject, $message, $headers);

									}

									?>
		

		</div>
	</div>
		<!-- /map -->
			<div class="map_w3layouts_agile">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8166656620324!2d36.82111431387061!3d-1.2838939990635643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d6e86aa345%3A0x1c271cdc51ce6fea!2sJavy+Technologies!5e0!3m2!1sen!2ske!4v1519155254717" style="border:0"></iframe>


			</div>
		<!-- //map -->

	<!-- footer -->


<?php include 'footer-front.php'; ?>