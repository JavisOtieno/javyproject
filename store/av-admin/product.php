<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; 

//localhost code
/*

$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "stock2";
*/

//web code

$localhost = "sql286.your-server.de";
$username = "javy2021";
$password = "@Ja20vy20";
$dbname = "javy2021";


if($connect->connect_error){
	echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}


$connect = new mysqli($localhost,$username, $password, $dbname);
$db_link= mysqli_connect($localhost,$username, $password, $dbname);


?>
	<link href="custom/css-products/owl.carousel.css" rel="stylesheet" type="text/css" media="all"> <!-- carousel slider --> 
	<link href="custom/css-products/animate.min.css" rel="stylesheet" type="text/css" media="all" />  
	<link href='//fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'>		
	<!-- web-fonts --> 		
	<!-- scroll to fixed--> 		
	
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="The product clicked is here. Make money on your own electronics store." />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--favicon-->
<link rel="icon" href="icon.gif" />
<!-- Custom Theme files -->
<link href="custom/css-products/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="custom/css-products/style.css" rel="stylesheet" type="text/css" media="all" /> 
<link href="custom/css-products/menu.css" rel="stylesheet" type="text/css" media="all" /> <!-- menu style --> 
<link href="custom/css-products/ken-burns.css" rel="stylesheet" type="text/css" media="all" /> <!-- banner slider --> 
<link href="custom/css-products/animate.min.css" rel="stylesheet" type="text/css" media="all" /> 
<link href="custom/css-products/owl.carousel.css" rel="stylesheet" type="text/css" media="all"> <!-- carousel slider -->  
<!-- //Custom Theme files -->
<!-- font-awesome icons -->
<link href="custom/css-products/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- js -->
<script src="custom/js-products/jquery-2.2.3.min.js"></script> 
<!-- //js --> 
<!-- web-fonts -->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Lovers+Quarrel' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Offside' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'>
<!-- web-fonts --> 
<script src="custom/js-products/owl.carousel.js"></script>  
<script>
$(document).ready(function() { 
	$("#owl-demo").owlCarousel({ 
	  autoPlay: 3000, //Set AutoPlay to 3 seconds 
	  items :4,
	  itemsDesktop : [640,5],
	  itemsDesktopSmall : [480,2],
	  navigation : true
 
	}); 

	
}); 
</script>
<script src="custom/js-products/jquery-scrolltofixed-min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        // Dock the header to the top of the window when scrolled past the banner. This is the default behaviour.

        $('.header-two').scrollToFixed();  
        // previous summary up the page.

        var summaries = $('.summary');
        summaries.each(function(i) {
            var summary = $(summaries[i]);
            var next = summaries[i + 1];

            summary.scrollToFixed({
                marginTop: $('.header-two').outerHeight(true) + 10, 
                zIndex: 999
            });
        });

        //make products navigation active(more grey) when selected
	$('#navProducts').addClass('active');	
	//
    });
</script>
<!-- start-smooth-scrolling -->
<script src="assests/bootstrap/js/bootstrap.min.js"></script>
<script src="assests/jquery/jquery.min.js"></script>
<script src="assests/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="custom/js-products/move-top.js"></script>
<script type="text/javascript" src="custom/js-products/easing.js"></script>	
<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
			});
		});
</script>
<!-- //end-smooth-scrolling -->
<!-- smooth-scrolling-of-move-up -->
	<script type="text/javascript">
		$(document).ready(function() {
		
			var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
			};
			
			$().UItoTop({ easingType: 'easeOutQuart' });
			
		});
	</script>
	<!-- //smooth-scrolling-of-move-up -->


<style type="text/css">
	body {
    margin: 0;
    font-family: inherit;
    background: #fff;
}
</style>
</head>
<body>
	<div class="agileits-modal modal fade" id="myModal88" tabindex="-1" role="dialog" aria-labelledby="myModal88"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><i class="fa fa-map-marker" aria-hidden="true"></i> Location</h4>
				</div>
				<div class="modal-body modal-body-sub"> 
					<h5>Select your delivery location </h5>  
					<select class="form-control bfh-states" data-country="KE" data-state="KE">
						<option value="">Select Your location</option>
						<option value="NRB">Nairobi</option><option value="KSM">Kisumu</option>
					</select>
					<input type="text" name="Name" placeholder="Enter your area / Landmark / Pincode" required="">
					<button type="button" class="close2" data-dismiss="modal" aria-hidden="true">Skip & Explore</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		//$('#myModal88').modal('show');
	</script> 

		


	<!-- the mousewheel plugin -->

	<?php
	if(isset($_GET['category'])){
		$category=$_GET['category'];

		if($category=='phones'){
		$query_category='WHERE category="phones"';
		$title='PHONES';
		$brands= array("Apple", "Asus", "Blackberry", "Cubot", "Fero", "HTC", "Nokia");
	}else if ($category=='cameras') {
		$query_category='WHERE category="cameras"';
		$title='CAMERAS';
		$brands=array("Nikon","Sony");
	}else if($category=='laptops'){
		$query_category='WHERE category="laptops"';
		$title='LAPTOPS';
		$brands=array("HP","Lenovo");
	}else if($category=='tvs'){
		$query_category='WHERE category="tvs"';
		$title='TVs';
		$brands=array("Sony","Samsung","TCL");
	}else if($category=='home-theatres'){
		$query_category='WHERE category="home-theatres"';
		$title='HOME THEATRES';
		$brands=array("Sony","Samsung","LG","home-theatres");
	}
	else if($category=='accessories'){
		$query_category='WHERE category="accessories"';
		$title='ACCESSORIES';
		$brands=array("Phone Chargers","Smartwatches");
	}
	}else{
		$category="phones";
		$query_category='WHERE category="phones"';
		$title='PHONES';
		$brands= array("Apple", "Asus", "Blackberry", "Cubot", "Fero", "HTC", "Nokia");

	}

	if(isset($_GET['brand'])){
		$brand=$_GET['brand'];
		$query_brand='AND brand="'.$brand.'"';
	}else{
		$query_brand='';
	}

	if(isset($_GET['page'])){
		$page=$_GET['page'];
	}else{
		$page="1";
	}

		if($page==""||$page=="1"){
			$page1=0;
		}else{
			$page1=($page*20)-20;
		}





//include modal css
echo '<link rel="stylesheet" type="text/css" href="custom/css-products/modal.css"/>';


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

			//check below code
			//find condition tomorrow
			  	if ($supplier_id!=$row['supplier_id']&&$row['supplier_id']!=0){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier_id AND product_id=".$row['id'];
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
					if($row2=mysqli_fetch_assoc($query_run_more_suppliers)){
						if($row2['price']!=0){
							$price=$row2['price'];
						}else{
							$price=$row['price'];
						}
						if($row2['profit']!=0){
							$profit=$row2['profit'];
						}else{
							$product_profit=$row['profit'];
						}
						if($row2['cost']!=0){
							$cost=$row2['cost'];
						}else{
							$cost=$row['cost'];
						}
					}else{
					$price=$row['price'];
					$profit=$row['profit'];	
					$cost=$row['cost'];	
					}
				}else{
					$price=$row['price'];
					$profit=$row['profit'];	
					$cost=$row['cost'];			}


					//check above code


			$price='KSh. '.number_format($price);
			

			if($row['image']==''){
					$large_image='assests/images/product-images/picture-coming-soon.jpg';
				}else{
					$large_image=str_replace('../', '', $row['image']);
				}


			$image2=str_replace('../', '', $row['image2']);
			
			//$image3=str_replace('../', '', $row['image3']);

			$query_2='SELECT * FROM variables WHERE product_id='.$row['id'].'';
		    $query_run_2=mysqli_query($db_link,$query_2);

		    $number_of_variables=mysqli_num_rows($query_run_2);

		    //echo "<br/><br/>";

		    if($number_of_variables==0){
		      $variables='';
		    }else{
		      while($row_variable=mysqli_fetch_assoc($query_run_2)){
		      $variables = $variables.$row_variable['variable'].' @ KSh. '.number_format($row_variable['price']).'<br/>';
		    }
		    }
		    $variables='<strong style="margin-top:20px;">'.$variables.'</strong>';
			
			$short_specs=$row['highlights'].'<br><br>'.$variables;
			$description=$row['highlights'];
			$category=$row['category'];
			$profit='KSh. '.number_format($profit);
		}
	}
}

?>


<!--javascript required for the product page only-->
<script src="custom/js-products/owl.carousel.js"></script>
<script src="custom/js-products/jquery-scrolltofixed-min.js" type="text/javascript"></script><!-- fixed nav js -->
<!--bootstrap js makes my account menu disappear so it has to be commented out
	<script src="js/bootstrap.js"></script>		-->
	<!--flex slider-->		
	<script defer src="custom/js-products/jquery.flexslider.js"></script>		
	<link rel="stylesheet" href="custom/css-products/flexslider.css" type="text/css" media="screen" />		
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
			<li ><a href="products.php">Products</a></li><li class="active">  <?php echo $name; ?></li>
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
								<li style="color: #0280e1;margin-bottom: 10px;"><?php echo $price;?></li><br/> 
								<li style="color: #2cb742;margin-bottom: 10px;font-size: 20px;">Commission: <?php echo $profit; ?></li> 
								<!--<li><span class="w3off">10% OFF</span></li> 
								<li>Ends on: June,5th</li>
								<li><a href="#"><i class="fa fa-gift" aria-hidden="true"></i> Coupon</a></li>-->
							</ul>	
						</div> 
						<!--w3ls-cart is red--w3ls-cart w3ls-cart-like--makes button blue-->
						<a href="javascript:void(0);" id="mpopupLink">
						<button class="w3ls-cart" ><i class="fa fa-check-circle" aria-hidden="true"></i> Sell Now</button>
						</a>
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
						            <h2>Sell Now - Enter the customer's details below</h2>
						        </div>
						        <div class="mpopup-main">
						       <div style="border-radius: 5px;background-color: #f2f2f2;padding: 20px;">
						       <div id="add-order-messages"></div>
						              <form action="php_action/submitDeal.php" method="POST" id="submitOrderForm" >
									    <label for="name">Name</label><br/>
									    <input type="text" id="name" name="name" placeholder="Customer name..">
									    <br/>

									    <label for="email">Email</label><br/>
									    <input type="text" id="email" name="email" placeholder="Customer email..">
									    <br/>

									    <label for="phone_number">Phone Number</label><br/>
									    <input type="text" id="phone_number" name="phone_number" placeholder="Customer phone number..">
									    <br/>

									    <label for="delivery_details">Delivery details</label><br/>
									    <input type="textarea"  id="delivery_details" name="delivery_details" placeholder="Customer delivery/location details" >
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

						
						

				<div class="single-page-icons social-icons"> 
					<ul>
						<li><h4>Share on</h4></li>
						<li><a href="http://www.facebook.com/sharer.php?u=http://<?php echo $storename; ?>.av.ke/product.php?id=<?php echo $id; ?>" target="_blank" class="fa fa-facebook icon facebook"></a></li>
						<!--<li><a href="#" class="fa fa-facebook icon facebook"> </a></li>-->
						
						<li><a href="https://twitter.com/share?url=http://<?php echo $storename; ?>.av.ke/product.php?id=<?php echo $id; ?>&amp;text=<?php echo $name;?>&amp; target="_blank" class="fa fa-twitter icon twitter"> </a></li>

						<li><a href="whatsapp://send?text=<?php echo $name.' '; ?> http://<?php echo $storename; ?>.av.ke/product.php?id=<?php echo $id; ?>" data-action="share/whatsapp/share" class="fa fa-whatsapp icon whatsapp" ></a></li>


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

							HOW TO BUY<br/ ><br/ >
						
							Click on buy now. Quickly submit your details.
							<br/ >
							
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

				if($row['image']==''){
					$image_uri='http://promote.javy.co.ke/assests/images/product-images/picture-coming-soon.jpg';
				}else{
					$image_uri=str_replace('../', '', $row['image']);
				}




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
<script type="text/javascript" src="custom/js-products/modal.js"></script>



<script type="text/javascript">
	
	$(document).ready(function(){
	$("#add-order-messages").html("");

$("#submitOrderForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/
		//disable submit button to prevent multiple submits
		$(this).find("input[type='submit']").attr('disabled', 'disabled').val('Submitting'); 


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

							//reset the form text
							$("#submitOrderForm")[0].reset();
						

							$("#add-order-messages").html('<div class="alert  alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');

							setTimeout(function () {
       window.location.href = "orders.php?o=manord"; //will redirect to your blog page (an ex: blog.html)
    }, 1000);
							//remove the messages after 10 seconds
							

						}//if */
					} //success
				});//ajax
				
			
			}//if



			return false;
		});//submit categories form function

});
</script>