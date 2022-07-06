

<!-- footer-top -->
	<div class="w3agile-ftr-top">
		<div class="container">
			<div class="ftr-toprow">
				<div class="col-md-4 ftr-top-grids">
					<div class="ftr-top-left">
						<i class="fa fa-truck" aria-hidden="true"></i>
					</div> 
					<div class="ftr-top-right">
						<h4>COUNTRYWIDE DELIVERY</h4>
						<p>We deliver all over Kenya. Same day delivery within Nairobi and Next day outside Nairobi </p>
					</div> 
					<div class="clearfix"> </div>
				</div> 
				<div class="col-md-4 ftr-top-grids">
					<div class="ftr-top-left">
						<i class="fa fa-user" aria-hidden="true"></i>
					</div> 
					<div class="ftr-top-right">
						<h4>CUSTOMER CARE</h4>
						<p>We're always willing to assist you. Don't hesitate to contact us </p>
					</div> 
					<div class="clearfix"> </div>
				</div>
				<div class="col-md-4 ftr-top-grids">
					<div class="ftr-top-left">
						<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
					</div> 
					<div class="ftr-top-right">
						<h4>GOOD QUALITY</h4>
						<p>Our products are of great quality and affordable </p>
					</div>
					<div class="clearfix"> </div>
				</div> 
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //footer-top --> 
	<!-- subscribe -->
	<div class="subscribe"> 
		<div class="container">
			<div class="col-md-6 social-icons w3-agile-icons">
				<h4>Keep in touch</h4>  
				<ul>
					<li><a href="<?php
					 if(empty($facebook_link)){echo 'social-fb-ig-twitter.php?s=facebook';}else{echo $facebook_link;}?>" class="fa fa-facebook icon facebook"> </a></li>
					<li><a href="<?php
					 if(empty($twitter_link)){echo 'social-fb-ig-twitter.php?s=twitter';}else{echo $twitter_link;}?>" class="fa fa-twitter icon twitter"> </a></li>
					<li><a href="<?php
					 if(empty($instagram_link)){echo 'social-fb-ig-twitter.php?s=instagram';}else{echo $instagram_link;}?>" class="fa fa-instagram icon instagram"> </a></li>
					<!--<li><a href="#" class="fa fa-dribbble icon dribbble"> </a></li>
					<li><a href="#" class="fa fa-rss icon rss"> </a></li> -->
				</ul>
				<!-- 
					ADD BACK android_app_link onto database first before your proceed

				<ul class="apps"> 
					<li><h4>Download Our app : </h4> </li>
					<!--<li><a href="#" class="fa fa-apple"></a></li>//
					<!--<li><a href="#" class="fa fa-windows"></a></li>//
					
					<li><a href="<?php
					 //if(empty($android_app_link)){echo 'app-not-available.php';}else{echo $android_app_link;}?>" class="fa fa-android"></a></li>
				</ul> -->
			</div> 
			<div class="col-md-6 subscribe-right">
				<h4>Sign up for email newsletter and stay updated!</h4> 
				
				<form id="EmailSubscriptionForm" action="submit_subscribe.php" method="post"> 
				<div id="add-email-messages"></div> 
					<input type="text" id="email" name="email" placeholder="Enter your Email..." required="">
					<input type="submit" value="Subscribe">
				</form>
				<div class="clearfix"> </div> 
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<!-- //subscribe --> 
	<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="footer-info w3-agileits-info">
				<div class="col-md-4 address-left agileinfo">
					<div class="footer-logo header-logo">
						<h1><a href="index.php"><span><?php echo strtoupper(substr($fullname, 0, 1)); ?></span><?php echo substr($fullname,1,mb_strlen($fullname)-1); ?> <!--<i>Bazaar</i>--></a></h1>
					<!--<h6>Your stores. Your place.</h6>--> 
					</div>
					<ul>
						<li><i class="fa fa-truck"></i> Countrywide Delivery</li>
						<li><i class="fa fa-map-marker"></i> Nairobi, Kenya.</li>
						<!--<li><i class="fa fa-mobile"></i> 333 222 3333 </li>-->
						<li><i class="fa fa-phone"></i> <a href="tel:<?php echo $phone_number; ?>"><?php echo $phone_number; ?></li>
						<li><i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo $email; ?>"> <?php echo $email; ?></a></li>
					</ul> 
				</div>
				<div class="col-md-8 address-right">
					<div class="col-md-4 footer-grids">
						<h3>Company</h3>
						<ul>
							<li><a href="about.php">About Us</a></li>
							<!--<li><a href="marketplace.html">Marketplace</a></li>  
							<li><a href="values.html">Core Values</a></li>-->  
							<li><a href="privacy.php">Privacy Policy</a></li>
							<li><a href="http://supply.javy.co.ke/signup.php">Got Products? Sell your products on a website like this one. Sign up</a></li>
							<li><a href="../admin/signup.php">Promote our products and earn a commission. Sign up.</a></li>
							<!--<li><a href="http://promote.javy.co.ke/signup.php">Interested in promoting other products apart from ours? Sign up. </a></li>-->
							
							<!--Comment out founder if set as 0 or don't show dealer details
							<?php //if(!$show_founder){echo "<!--";} ?>
							<li><a href="founder_ceo.php">Founder & CEO</a></li>
							<?php //if(!$show_founder){echo "-->";} ?>
							-->
						</ul>
					</div>
					<div class="col-md-4 footer-grids">
						<h3>Services</h3>
						<ul>

							<li><a href="contact.php">Contact Us</a></li>
							<!--<li><a href="login.html">Returns</a></li>--> 
							<li><a href="faq.php">FAQ</a></li>
							<!--<li><a href="sitemap.html">Site Map</a></li>
							<li><a href="login.html">Order Status</a></li>-->
						</ul> 
					</div>
					<div class="col-md-4 footer-grids">
						<h3>Payment Methods</h3>
						<ul>
						    <li><i class="fa fa-money" aria-hidden="true"></i> Cash On Delivery</li>
						    <li><i class="fa fa-laptop" aria-hidden="true"></i> MPesa</li>
							<li><i class="fa fa-credit-card" aria-hidden="true"></i> Equitel</li>
							<li><i class="fa fa-laptop" aria-hidden="true"></i> Airtel Money</li>
							<!--<li><i class="fa fa-credit-card" aria-hidden="true"></i> Debit/Credit Card</li>-->
						</ul>  
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!-- //footer -->		
	<div class="copy-right"> 
		<div class="container">
			<p>© 2018 <?php echo ucfirst($fullname); ?>. All rights reserved </a></p>
		</div>
	</div> 
	<!-- cart-js -->
	<script src="js/minicart.js"></script>
	<script>
        w3ls.render();

        w3ls.cart.on('w3sb_checkout', function (evt) {
        	var items, len, i;

        	if (this.subtotal() > 0) {
        		items = this.items();

        		for (i = 0, len = items.length; i < len; i++) {
        			items[i].set('shipping', 0);
        			items[i].set('shipping2', 0);
        		}
        	}
        });
    </script>  
	<!-- //cart-js -->	
	<!-- countdown.js -->	
	<script src="js/jquery.knob.js"></script>
	<script src="js/jquery.throttle.js"></script>
	<script src="js/jquery.classycountdown.js"></script>
		<script>
			$(document).ready(function() {
				$('#countdown1').ClassyCountdown({
					end: '1388268325',
					now: '1387999995',
					labels: true,
					style: {
						element: "",
						textResponsive: .5,
						days: {
							gauge: {
								thickness: .10,
								bgColor: "rgba(0,0,0,0)",
								fgColor: "#1abc9c",
								lineCap: 'round'
							},
							textCSS: 'font-weight:300; color:#fff;'
						},
						hours: {
							gauge: {
								thickness: .10,
								bgColor: "rgba(0,0,0,0)",
								fgColor: "#05BEF6",
								lineCap: 'round'
							},
							textCSS: ' font-weight:300; color:#fff;'
						},
						minutes: {
							gauge: {
								thickness: .10,
								bgColor: "rgba(0,0,0,0)",
								fgColor: "#8e44ad",
								lineCap: 'round'
							},
							textCSS: ' font-weight:300; color:#fff;'
						},
						seconds: {
							gauge: {
								thickness: .10,
								bgColor: "rgba(0,0,0,0)",
								fgColor: "#f39c12",
								lineCap: 'round'
							},
							textCSS: ' font-weight:300; color:#fff;'
						}

					},
					onEndCallback: function() {
						console.log("Time out!");
					}
				});
			});
		</script>
	<!-- //countdown.js -->
	<!-- menu js aim -->
	<script src="js/jquery.menu-aim.js"> </script>
	<script src="js/main.js"></script> <!-- Resource jQuery -->

	<script type="text/javascript">
		$(document).ready(function(){
	$("#add-email-messages").html("");


$("#EmailSubscriptionForm").unbind('submit').bind('submit',function(){

			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/
		
			var email=$("#email").val();

			/*
			if(categoriesName==""){
				$("#categoriesName").after('<p class="text-danger">Categories Name Field is required</p>');
				$("#categoriesName").closest().addClass(".formgroup").addClass('has-error');
			}else{
				//remove error-text field
				$("#categoriesName").find('.text-danger').remove();
				$("#categoriesName").closest('.form-group').addClass('has-success');
			}

			if(categoriesStatus==""){
				$("#categoriesStatus").after('<p class="text-danger">Categories Status Field is required</p>');
				$("#categoriesStatus").closest().addClass(".formgroup").addClass('has-error');
			}else{
				//remove error-text field
				$("#categoriesStatus").find('.text-danger').remove();
				$("#categoriesStatus").closest('.form-group').addClass('has-success');
			}

			*/
			
			if(email){

				
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
							$("#EmailSubscriptionForm")[0].reset();
						

							$("#add-email-messages").html('<div class="alert  alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');


							//remove the messages after 10 seconds
							

						}//if */
					} //success
				});//ajax
				
			
			}//if



			return false;
		});//submit categories form function

});
	</script>
	<!-- //menu js aim --> 
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster --> 


</body>
</html>