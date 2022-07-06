<?php 
include 'connect.inc.php';
session_start();

   if(isset($_SESSION['customerId'])) {

	$customer_id=$_SESSION['customerId'];

	$query="SELECT * FROM `customers` WHERE `id`= '$customer_id'";
		if($query_run=mysqli_query($db_link,$query)){
			while($row=mysqli_fetch_assoc($query_run)){

				$customer_name=$row['name'];
				$customer_phone=$row['phone'];
				$customer_email=$row['email'];
				$customer_delivery_details=$row['deliverydetails'];



			}
		}

}





include 'header.php';



//include modal css
echo '<link rel="stylesheet" type="text/css" href="css/modal1.css"/>';


if(isset($_GET['id'])){
	$id=$_GET['id'];
	if(!empty($id)){
		
		$query="SELECT * FROM `products` WHERE `id`= '$id'";
		if($query_run=mysqli_query($db_link,$query)){
			
		}else{
		echo mysqli_error($db_link);
		}
		
		while($row=mysqli_fetch_assoc($query_run)){
			$name=$row['name'];
			$price='KSh. '.number_format($row['price']);


			//$large_image=str_replace("..", "../stock-2/", $row['image']);
			//$image2=str_replace("..", "../stock-2/", $row['image1']);
			//$image3=str_replace("..", "../stock-2/", $row['image2']);
			//web code
			if($row['image']==''){
					$large_image='https://promote.javy.co.ke/assests/images/product-images/picture-coming-soon.jpg';
				}else{
					$large_image=str_replace("..", "https://promote.javy.co.ke", $row['image']);
				}

			
			$image2=str_replace("..", "https://promote.javy.co.ke/", $row['image1']);
			//in case you need another image
			$image3=str_replace("..", "https://promote.javy.co.ke/", $row['image2']);
			$short_specs=$row['highlights'];
			$description=$row['highlights'];
			$category=$row['category'];
		}
	}
}

?>


<!--javascript required for the product page only-->
<script src="js/owl.carousel.js"></script>
<script src="js/jquery-scrolltofixed-min.js" type="text/javascript"></script><!-- fixed nav js -->
<!--bootstrap js makes my account menu disappear so it has to be commented out
	<script src="js/bootstrap.js"></script>		-->
	<!--flex slider-->		
	<script defer src="js/jquery.flexslider.js"></script>		
	<link rel="stylesheet" href="css/flexslider-1.css" type="text/css" media="screen" />		
	<script>		
		// Can also be used with $(document).ready()		
		$(window).load(function() {		
		  $('.flexslider').flexslider({		
			animation: "slide",		
			controlNav: "thumbnails"		
		  });		
		});		
	</script>		
	<!--flex slider		
	<script src="js/imagezoom.js"></script>	-->

	<!--javascript required for the product page only-->
	<!-- breadcrumbs --> 
	<div class="container"> 
		<ol class="breadcrumb breadcrumb1">
			<li><a href="index.php">Home</a></li>
			<li ><a href="shop.php">Products</a></li><li class="active">  <?php echo $name ?></li>
		</ol> 
		<div class="clearfix"> </div>
	</div>
	<!-- //breadcrumbs -->
	<!-- products -->
	<div class="products">	 
		<div class="container">  
			<div class="single-page">
				<div class="single-page-row" id="detail-21">
					<div class="col-md-6 single-top-left">	
						<div class="flexslider">
							<ul class="slides">
								<li data-thumb="<?php echo $large_image; ?>">
									<div class="thumb-image detail_images"> <img src="<?php echo $large_image; ?>" data-imagezoom="true" class="img-responsive" alt=""> </div>
								</li>
								<?php 
								if(strlen($image2)>3){
									echo '<li data-thumb="'.$image2.'">
									 <div class="thumb-image"> <img src="'.$image2.'" data-imagezoom="true" class="img-responsive" alt=""> </div>
								</li>';

								}

								if(strlen($image3)>3){
									echo '<li data-thumb="'.$image3.'">
									 <div class="thumb-image"> <img src="'.$image3.'" data-imagezoom="true" class="img-responsive" alt=""> </div>
								</li>';

								}
								?>
								
		 
							</ul>
						</div>
					</div>
					<div class="col-md-6 single-top-right">
						<h3 class="item_name"><?php echo $name; ?></h3>
						
						<!--<p>Processing Time: Item will be delivered on the same day within Nairobi. Next day outside Nairobi </p>
						<div class="single-rating">
							<ul>
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								<li class="rating">20 reviews</li>
								<li><a href="#">Add your review</a></li>
							</ul> 
						</div>-->


						<p class="single-price-text"><strong>Key Features</strong><br/ ><?php echo $short_specs ?></p>
								<div class="single-price">
							<ul>
								<li style="color: #0280e1;margin-bottom: 20px;"><?php echo $price;?></li>  
								<!--<li><del>$600</del></li> 
								<li><span class="w3off">10% OFF</span></li> 
								<li>Ends on: June,5th</li>
								<li><a href="#"><i class="fa fa-gift" aria-hidden="true"></i> Coupon</a></li>-->
							</ul>	
						</div> 
						<!--w3ls-cart is red--w3ls-cart w3ls-cart-like--makes button blue-->
						<a href="javascript:void(0);" id="mpopupLink">
						<button class="w3ls-cart" ><i class="fa fa-check-circle" aria-hidden="true"></i> Buy Now</button>
						</a>

						<!--<a href="javascript:void(0);" id="mpopupLink2">
						<button class="w3ls-cart w3ls-cart-like" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Contact Shop</button>
						</a>-->
						<!--disabled add to card button for future use-->
						<form action="#" method="post">
							<input type="hidden" name="cmd" value="_cart" />
							<input type="hidden" name="add" value="1" /> 
							<input type="hidden" name="w3ls_item" value="Snow Blower" /> 
							<input type="hidden" name="amount" value="540.00" /> 
							<!--<button type="submit" class="w3ls-cart w3ls-cart-like" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>-->
						</form>
						
					</div>
				   <div class="clearfix"> </div>  
				</div>

								<!-- mPopup box -->
						<div id="mpopupBox" class="mpopup" style="z-index: 2000;">
						    <!-- mPopup content -->
						    <div class="mpopup-content">
						        <div class="mpopup-head">
						            <div id="closeModal"><span class="close">X</span></div>
						            <h2>Buy Now - Enter your details below</h2>
						        </div>
						        <div class="mpopup-main">
						       <div style="border-radius: 5px;background-color: #f2f2f2;padding: 20px;">
						       <div id="add-order-messages"></div>
						              <form action="submit-order.php" method="POST" id="submitOrderForm" >
									    <label for="name">Name</label><br/>
									    <input type="text" id="name" name="name" placeholder="Your name.."
									     required="" <?php if(isset($customer_id)){echo " value=".$customer_name." ";}?>>
									    <br/>

									    <label for="email">Email</label><br/>
									    <input type="text" id="email" name="email" placeholder="Your email.." required="" <?php if(isset($customer_id)){echo " value=".$customer_email." ";}?> >
									    <br/>

									    <label for="phone_number">Phone Number</label><br/>
									    <input type="text" id="phone_number" name="phone_number" placeholder="Your phone number.." <?php if(isset($customer_id)){echo " value=".$customer_phone." ";}?> required="">
									    <br/>

									    <label for="delivery_details">Delivery details</label><br/>
									    <input type="textarea"  id="delivery_details" name="delivery_details" placeholder="Your delivery/location details" required="" <?php if(isset($customer_id)){echo " value=".$customer_delivery_details." ";}?> >
									    <br/>

									    <label for="product_name">Product</label><br/>
									    <input style="font-weight: bold;" type="text" id="product_name" name="product_name" placeholder="<?php echo $name?>" readonly="readonly" value="<?php echo $name?>"><br/><br/>


									  <input type="hidden" id="product_id" name="product_id" value="<?php echo $id; ?>"  >
									  
									    <input type="submit" value="Submit">
									  </form>
									  </div>
						        </div>
						        <!--
						        <div class="mpopup-foot">
						            <p>created by CodexWorld</p>
						        </div>
						        -->
						    </div>
						</div>


						<div id="mpopupBox2" class="mpopup" style="z-index: 2000;">
						    <!-- mPopup content -->
						    <div class="mpopup-content">
						        <div class="mpopup-head">
						            <div id="closeModal2"><span class="close">X</span></div>
						            <h2>Contact Shop - Send a message</h2>
						        </div>
						        <div class="mpopup-main">
						       <div style="border-radius: 5px;background-color: #f2f2f2;padding: 20px;">
						       <div id="add-product-message-messages"></div>
						              <form action="submit-product-message.php" method="POST" id="submitProductMessageForm" >
									    <label for="contact_name">Name</label><br/>
									    <input type="text" id="contact_name" name="contact_name" placeholder="Your name.."  <?php if(isset($customer_id)){echo " value=".$customer_name." ";}?> required="">
									    <br/>

									    <label for="contact_email">Email</label><br/>
									    <input type="text" id="contact_email" name="contact_email" placeholder="Your email.." <?php if(isset($customer_id)){echo " value=".$customer_email." ";}?> required="">
									    <br/>

									    <label for="contact_email_2" style="display: none;">Email</label><br/>
									    <input type="text" id="contact_email_2" name="contact_email_2" placeholder="Your email.." style="display: none;">
									    

									    <label for="contact_phone_number">Phone Number</label><br/>
									    <input type="text" id="contact_phone_number" name="contact_phone_number" placeholder="Your phone number.." <?php if(isset($customer_id)){echo " value=".$customer_phone." ";}?>
									    required="">
									    <br/>

									    <label for="contact_message">Message</label><br/>
									    <input type="textarea"  id="contact_message" name="contact_message" placeholder="Your Message" required="">
									    <br/>

									    <label for="contact_product_name">Product</label><br/>
									    <input style="font-weight: bold;" type="text" id="contact_product_name" name="contact_product_name" placeholder="<?php echo $name?>" readonly="readonly" value="<?php echo $name?>"><br/><br/>


									  <input type="hidden" id="contact_product_id" name="contact_product_id" value="<?php echo $id; ?>"  >
									  
									    <input type="submit" value="Submit">
									  </form>
									  </div>
						        </div>
						        <!--
						        <div class="mpopup-foot">
						            <p>created by CodexWorld</p>
						        </div>
						        -->
						    </div>
						</div>

						
						

				<div class="single-page-icons social-icons"> 
					<ul>
						<li><h4>Share on</h4></li>
						<li><a href="https://www.facebook.com/sharer.php?u=<?php echo $actual_link; ?>" target="_blank" class="fa fa-facebook icon facebook"></a></li>
						<!--<li><a href="#" class="fa fa-facebook icon facebook"> </a></li>-->
						
						<li><a href="https://twitter.com/share?url=<?php echo $actual_link; ?>&amp;text=<?php echo $name;?>&amp; target="_blank" class="fa fa-twitter icon twitter"> </a></li>

						<li><a href="whatsapp://send?text=<?php echo $name.' '.$actual_link; ?>" data-action="share/whatsapp/share" class="fa fa-whatsapp icon whatsapp" ></a></li>


						<!--<li><a href="#" class="fa fa-instagram icon fa-instagram"> </a></li>-->
						<!--<li><a href="#" class="fa fa-dribbble icon dribbble"> </a></li>
						<li><a href="#" class="fa fa-rss icon rss"> </a></li> -->
					</ul>
				</div>
			</div> 
			
			<!-- collapse-tabs -->
			<div class="collpse tabs" style="padding-top: 0px;">
				<h3 class="w3ls-title">About this item</h3> 
				<div class="panel-group collpse" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a class="pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									<i class="fa fa-file-text-o fa-icon" aria-hidden="true"></i> Description <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<?php echo $short_specs ?>
								<br /><br />
								We're working on a detailed description. Stay tuned!
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title">
								<a class="collapsed pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									<i class="fa fa-info-circle fa-icon" aria-hidden="true"></i> Specifications <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
								</a> 
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
							<div class="panel-body">
								<?php echo $short_specs ?>
								<br /><br />
								We're working on detailed specifications. Stay tuned!
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
								<a class="collapsed pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									<i class="fa fa-check-square-o fa-icon" aria-hidden="true"></i> reviews (0) <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
								</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">
								No reviews yet
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFour">
							<h4 class="panel-title">
								<a class="collapsed pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									<i class="fa fa-question-circle fa-icon" aria-hidden="true"></i> help <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
								</a>
							</h4>
						</div>
						<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
							<div class="panel-body">

							HOW TO BUY<br/ >
							<!--FIRST WAY-->
							Click on buy now. Quickly submit your name,number,email and address. Then submit.<br/>
							<!--This is fast when you're looking to purchase a single product fast
							<br/ >
							If you want to buy many products, consider the second way
							<br/ ><br/ >
							SECOND WAY<br/ >
							Click on 'buy now', to add this product to your cart,<br/ >
							Click on 'cart' in the top right corner,<br/ >
							Register/Login into your account by entering your email and password,<br/ >
							Enter your shipping/billing information,<br/ >
							Choose your preferred payment option,<br/ >
							Click on 'Confirm order' to proceed to the payement portal and complete your order.<br/ >
							Once your order is placed, we will either automatically confirm it by notifying you via email, or we will call you for confirmation in case we need more details. <br/ >
							In case you have a doubt about whether the confirmation was done or not, do not hesitate to contact our Customer Service Call Center at 0707641174 or email us on info@javy.co.ke after your order placement..<br/ >
							<br/ >-->
								Processing Time: Item will be shipped out within 24 hours. You'll get it on the same day in Nairobi but the next day if you're outside Nairobi.

							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- recommendations -->
			<div class="recommend">
				<h3 class="w3ls-title">Our Recommendations </h3> 
				<script>
					$(document).ready(function() { 
						$("#owl-demo5").owlCarousel({
					 
						  autoPlay: 3000, //Set AutoPlay to 3 seconds
					 
						  items :4,
						  itemsDesktop : [640,5],
						  itemsDesktopSmall : [414,4],
						  navigation : true
					 
						});
						
					}); 
				</script>
				<div id="owl-demo5" class="owl-carousel">
					<?php
			
			$query='SELECT * FROM `products` WHERE featured="1" AND category="'.$category.'"';
			$query_run=mysqli_query($db_link,$query);
			$count=1;
			
			while($row=mysqli_fetch_assoc($query_run)){
			
				//$image_uri=str_replace("..", "../stock-2/", $row['image']);

				//web code
				$image_uri=str_replace("..", "https://promote.javy.co.ke/", $row['image']);
				$price='KSh. '.number_format($row['price']);
				$id=$row['id'];
				$name=$row['name'];
				$category=$row['category'];
				$brand=$row['brand'];
				showProduct($image_uri,$name,$price,$id,$category,$brand);
				
			}

			function showProduct($image,$name,$price,$id,$category,$brand)
			{echo '<div class="item">
										<div class="glry-w3agile-grids agileits"> 
											<a href="product.php?id='.$id.'"><img src="'.$image.'" alt="img"></a>
											<h4><a href="product.php?id='.$id.'">'.$name.'</a></h4> 
											<h4 style="margin-bottom: 10px;margin-top: 10px;color: #333;">'.$price.'</h4>

											<a href="product.php?id='.$id.'"><div class="view-caption agileits-w3layouts">           
												<h4>'.$name.'</h4>
												<p>'.ucfirst($category).'>>'.ucfirst($brand).'</p>
												<h5>Buy</h5> 
												
													<button type="submit" class="w3ls-cart" > '.$price.'</button>
												
											</div></a> 
										</div>   
									</div>';}
			
			
			
			
			
			?>

			
			<!-- //recommendations --> 
			<!-- //collapse --> 
			<!-- offers-cards --> <!--
			<div class="w3single-offers offer-bottom"> 
				<div class="col-md-6 offer-bottom-grids">
					<div class="offer-bottom-grids-info2">
						<h4>Special Gift Cards</h4> 
						<h6>More brands, more ways to shop. <br> Check out these ideal gifts!</h6>
					</div>
				</div>
				<div class="col-md-6 offer-bottom-grids">
					<div class="offer-bottom-grids-info">
						<h4>Flat $10 Discount</h4> 
						<h6>The best Shopping Offer <br> On Fashion Store</h6>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
			-->
			<!-- //offers-cards -->
		</div>
	</div>
	</div>
	</div>
	<!--//products-->  
<?php include 'footer.php'; ?>
<script type="text/javascript" src="js/modal1.js"></script>



<script type="text/javascript">


	
	$(document).ready(function(){


	$("#add-order-messages").html("");

$("#submitOrderForm").unbind('submit').bind('submit',function(){

	$(this).find("input[type='submit']").attr('disabled', 'disabled').val('Submitting'); 
			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/


			var name=$("#name").val();
			var email=$("#email").val();
			var phone_number=$("#phone_number").val();
			var product_name=$('#product_name').val();
			var delivery_details=$('#delivery_details').val();
			var product_id=$('#product_id').val();

			if(name&&email&&phone_number&&product_name&&delivery_details&&product_id){
				
				var form =$(this);
				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){

						form.find("input[type='submit']").removeAttr('disabled').val('Submit'); 
					
						if(response.success == true){

						
						console.log(response);
							//reload the manage member datatable
							//manageCategoriesTable.ajax.reload(null,false);

							if(response.customer_password==true){
							window.location.href = "login.php?source=order&message="+response.messages;
						}else{
							window.location.href = "orders.php";
						}

							//reset the form text
							$("#submitOrderForm")[0].reset();
						

							$("#add-order-messages").html('<div class="alert  alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');


							//remove the messages after 10 seconds
							

						}else{

							$("#submitOrderForm")[0].reset();
						

							$("#add-order-messages").html('<div class="alert  alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');

						}///if */
					} //success
				});//ajax
				
			
			}//if



			return false;
		});//submit categories form function

$("#add-product-message-messages").html("");

$("#submitProductMessageForm").unbind('submit').bind('submit',function(){

$(this).find("input[type='submit']").attr('disabled', 'disabled').val('Submitting'); 

			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/


			var name=$("#contact_name").val();
			var email=$("#contact_email").val();
			var phone_number=$("#contact_phone_number").val();
			var product_name=$('#contact_product_name').val();
			var message=$('#contact_message').val();
			var product_id=$('#contact_product_id').val();



			if(name&&email&&phone_number&&product_name&&message&&product_id){


				
				var form =$(this);
				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){
					
					form.find("input[type='submit']").removeAttr('disabled').val('Submit');	

						if(response.success == true){


						console.log(response);
						if(response.customer_password==true){
							window.location.href = "login.php?source=message&message="+response.messages;
						}else{
							window.location.href = "messages.php";
						}
							//reload the manage member datatable
							//manageCategoriesTable.ajax.reload(null,false);

							//reset the form text
							$("#submitProductMessageForm")[0].reset();
						

							$("#add-product-message-messages").html('<div class="alert  alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');

							//remove the messages after 10 seconds
							

						}else{

							$("#submitProductMessageForm")[0].reset();
						

							$("#add-product-message-messages").html('<div class="alert  alert-dismissible" role="alert">'+
							  '<strong><i class="glyphicon glyphicon-warning-sign"></i></strong> '+response.messages+
							'</div>');

						}//if */
					} //success
				});//ajax
				
			
			}//if



			return false;
		});//submit categories form function





});
</script>