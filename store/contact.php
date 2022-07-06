<?php include 'header.php' ?>	
	<!-- contact-page -->
	<div class="contact">
		<div class="container"> 
			<h3 class="w3ls-title w3ls-title1">Contact Us</h3>  
			<div class="map-info">
				<div class="col-md-12 map-grids">
					<!--<h4>Our Location</h4>

					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.75293483813!2d36.837244014168675!3d-1.3241101860406292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f11b8e20b6fd7%3A0xd5b704be08e26341!2sStockwell+Homes%2C+Nairobi!5e0!3m2!1sen!2ske!4v1523159526531" width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>

					-->
				</div>
				
				<div class="clearfix"> </div>
			</div>  
			<div class="contact-form-row">
				<!--<h3 class="w3ls-title w3ls-title1">Drop Us a line</h3>  -->
				<div class="col-md-7 contact-left">
										<div class="cnt-w3agile-row">
						<div class="col-md-3 contact-w3icon">
							<i class="fa fa-phone" aria-hidden="true"></i>
						</div>
						<div class="col-md-9 contact-w3text">
						<p>Phone</p>
							<h4> <?php echo $phone_number; ?></h4>
							<!--<p>Manage Your Orders <br>Easily Track Orders & Returns </p> -->
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="cnt-w3agile-row cnt-w3agile-row-mdl">
						<div class="col-md-3 contact-w3icon">
							<i class="fa fa-envelope-o" aria-hidden="true"></i>
						</div>
						<div class="col-md-9 contact-w3text">

						<p>Email</p>
							<h4><?php echo $email; ?></h4>
							<!--<p>Notifications <br>Get Relevant Alerts & Recommendations</p> -->
						</div>
						<div class="clearfix"> </div>
					</div>
					<!--<form action="submit-contact.php" method="post" id="contactForm">
					<div id="submit-contact-messages"></div>
						<input id="name" type="text" name="name" placeholder="Name" required="required">
						<input id="phone" class="email" type="text" name="phone" placeholder="Phone number" required="required">
						<input id="email" style="width:100%;" type="text" name="email" placeholder="Email" required="required">
						<input id="email2" style="width:100%;display: none;" type="text" name="email2" placeholder="Email" required="required">
						<textarea id="message" placeholder="Message" name="message" required="required"></textarea>
						<input type="submit" value="SUBMIT">
					</form> -->
				</div> 
				<div class="col-md-4 contact-right">
					
					<div class="cnt-w3agile-row">
						<div class="col-md-3 contact-w3icon">
							<i class="fa fa-map-marker" aria-hidden="true"></i>
						</div>
						<div class="col-md-9 contact-w3text">
						<p>Location</p>
							<h4><?php if($storename=='phoneplacekisumu'){ echo 'Kisumu'; }else{ echo 'Nairobi'; }?>, Kenya</h4>
							<!--<p>Requirements<br> With Wishlists, Reviews, Ratings</p> -->
						</div>
						<div class="clearfix"> </div>
					</div>
				</div> 
				<div class="clearfix"> </div>	
			</div>
		</div>
	</div>
	<!-- //contact-page --> 
<?php include 'footer.php' ?>

<!-- //submit query script --> 
	<script type="text/javascript">

		$(document).ready(function(){
	$("#submit-contact-messages").html("");

$("#contactForm").unbind('submit').bind('submit',function(){

	
		
			var name=$("#name").val();
			var email=$("#email").val();
			var message=$("#message").val();
			
			if(name&&email&&message){

				
				var form =$(this);
				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){
						

						console.log(response);
						
						
						
					
						if(response.success == true){

							//reload the manage member datatable
							//manageCategoriesTable.ajax.reload(null,false);
							
							//reset the form text
							$("#contactForm")[0].reset();
						

							$("#submit-contact-messages").html('<div class="alert  alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');


							//remove the messages after 10 seconds
							

						}//if */
						else
						{
							console.log(response);
						}
					}
				});//ajax
				
			
			}//if



			return false;
		});//submit categories form function

});
	</script>
