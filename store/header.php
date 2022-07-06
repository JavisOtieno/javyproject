<?php 

//for my account option on menu purposes
if (session_status() == PHP_SESSION_NONE) {
    	session_start();
   }

		require('connect.inc.php');

    	//if customerId is not set
    	if(!isset($_SESSION['customerId'])){
    	//login using cookie
    	if(isset($_COOKIE['phone_email'])&&isset($_COOKIE['password'])){
		$phone_email_cookie= $_COOKIE['phone_email'];
		$password_cookie=$_COOKIE['password'];	

		//login using cookie
		$mainSql = "SELECT * FROM customers WHERE phone = '$phone_email_cookie' AND password = '$password_cookie'";
		if(filter_var($phone_email_cookie, FILTER_VALIDATE_EMAIL)) {
		$mainSql = "SELECT * FROM customers WHERE email = '$phone_email_cookie' AND password = '$password_cookie'";
		}

			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$customer_id = $value['id'];

				// set session
				$_SESSION['customerId'] = $customer_id;

				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				}
				}
//end of login using cookie
			}

require('subdomain_storename.php');


//getting the phone number
$query="SELECT * FROM `users` WHERE `storename` ='$storename'";

$query_run=mysqli_query($db_link,$query);
if(mysqli_num_rows($query_run)==0){
	echo "<script type='text/javascript'>
window.location.href = 'find.php';
</script>";
}
if($row=mysqli_fetch_assoc($query_run)){
	
	$phone_number=$row['phone'];



	$email=$row['email'];
	if(strlen($email)<1){
		$email="info@javy.co.ke";
	}

	$display_phone=$row['display_phone'];
	$display_email=$row['display_email'];

	if($display_phone!=""){
		$phone_number=$display_phone;
	}
	if($display_email!=""){
		$email=$display_email;
	}

	if (strpos($phone_number, '254')!==false){
		$whatsapp_phone_number=$phone_number;
	}else{
		$whatsapp_phone_number='254'.$phone_number;
	}
	


	$user_id=$row['user_id'];
	$supplier_id=$row['supplier_registered_on'];
	$name=$row['firstname'].' '.$row['lastname'];
	$show_founder=$row['show_founder'];
	$created_on=$row['created_on'];
	$facebook_link=$row['facebook_link'];
	$twitter_link=$row['twitter_link'];
	$instagram_link=$row['instagram_link'];
	$profile_picture=$row['profile_picture'];
	$shop_type=$row['shop_type'];
	$facebook_pixel_code=$row['facebook_pixel_code'];
	$google_tag_code=$row['google_tag_code'];
	$web_visits=$row['web_visits'];

	//This is to ensure that as we're searching for products with the supplier id, we do not end up searching for products with the supplier id as 0 since those products have store ids instead
	if($supplier_id==0){
		$supplier_id=100000000;
	}

	if($shop_type==1 || $shop_type==4){
				$page_with_products='index.php';
	}else{
				$page_with_products='shop.php';
		}

}


//update web visits
mysqli_query($db_link,"UPDATE users SET web_visits = web_visits + 1 WHERE user_id='$user_id'");

	//count from 100;
	$count=2;
	while ($count<15){
	//website visits fetched yet to add 1;	
	$current_website_visits=$web_visits+1;

	if($current_website_visits==pow(10,$count)){

		include 'send-congratulations-email.php';
	}

	$count++;

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<title><?php echo ucfirst($storename) ?> | Online Store - Electronics and many more products</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
//code to set metas depending on the product
if (strpos($page,'product.php') !== false)
{
	if(isset($_GET['id']) || isset($_GET['p'])){

	if(isset($_GET['id'])){
	$id=mysqli_real_escape_string($db_link, $_GET['id']);
	}else if(isset($_GET['p'])){
	$slug=mysqli_real_escape_string($db_link, $_GET['p']);

	$query_slug="SELECT * FROM `products` WHERE `slug`= '$slug'";
		//echo $query_slug;
	$query_run_slug=mysqli_query($db_link,$query_slug);

	while($row_slug=mysqli_fetch_assoc($query_run_slug)){
			$id = $row_slug['id'];
			//print_r($row_slug);
	}

	}




	if(!empty($id)){
		
		$query="SELECT * FROM `products` WHERE `id`= '$id'";
		if($query_run=mysqli_query($db_link,$query)){
			
		}else{
		echo mysqli_error($db_link);
		}
		
		while($row=mysqli_fetch_assoc($query_run)){
			$name=$row['name'];
			$product_price=$row['price'];

			if($row['image']==''){
					$large_image='https://promote.javy.co.ke/assests/images/product-images/picture-coming-soon.jpg';
				}else{
					$large_image=str_replace("..", "https://promote.javy.co.ke", $row['image']);
				}

		}
	}
}

echo '
<meta name="keywords" content="'.$name.' available in Kenya" />
<meta property="og:title" content="'.$name.' @ Ksh. '.number_format($product_price).'" />
<meta property="og:url" content="'.$actual_link.'" />
<meta property="og:image" content="'.$large_image.'" /> 
';

}else if (strpos($page,'offers.php') !== false)
{

if(isset($_GET['offer'])){
    $offer=$_GET['offer'];

$sql="SELECT * FROM offers2 WHERE id='$offer'";
}else{
$sql="SELECT * FROM offers2 WHERE status=1 ORDER BY id DESC LIMIT 10";
}
$result=$connect->query($sql);


?>
<?php


while ($row=$result->fetch_assoc()){
    
    $offer_id=$row['id'];
    $title=$row['title'];
    $image_url=$row['image'];
    if($image_url==''){
        $image_url=$row['original_image'];
    }
    $image_url=str_replace("assests","https://promote.javy.co.ke/assests", $image_url);
    $product_id=$row['product_id'];

       if(strpos($image_url, '.php') !== false){
            $image_url=$image_url."?image_on_store=".$storename;
        }

    $sqlproduct="SELECT * FROM products WHERE id='$product_id'";
    $result2=$connect->query($sqlproduct);
    while($row=$result2->fetch_assoc()){
        $product_name=$row['name'];
        $product_price=$row['price'];
        $product_image=$row['image'];
        $product_image=str_replace("..", "https://promote.javy.co.ke/", $row['image']);
        $product_profit=$row['profit'];
        $product_category=$row['category'];


    }
}


echo '
<meta name="keywords" content="'.$title.' now on offer on our website. Delivery available in Kenya." />
<meta property="og:title" content="'.$title.' @ Ksh. '.number_format($product_price).' | Now on Offer" />
<meta property="og:url" content="'.$actual_link.'" />
<meta property="og:image" content="'.$image_url.'" /> 
';

}


else{
	echo '<meta name="keywords" content="<?php echo ucfirst($storename) ?> | For all your electronics in Kenya. Shop online for phones, cameras, laptops, tvs, home theatre systems and accessories "
	<meta property="og:title" content="<?php echo ucfirst($storename) ?> | For all your electronics in Kenya. Shop online for phones, cameras, laptops, tvs, home theatre systems and accessories " />';
}
?>



<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--favicon-->
<link rel="icon" href="icon.gif" />
<!-- Custom Theme files -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" /> 
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all" /> <!-- menu style --> 
<link href="css/ken-burns.css" rel="stylesheet" type="text/css" media="all" /> <!-- banner slider --> 
<link href="css/animate.min.css" rel="stylesheet" type="text/css" media="all" /> 
<link href="css/owl.carousel.css" rel="stylesheet" type="text/css" media="all"> <!-- carousel slider -->  
<!-- //Custom Theme files -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- js -->
<script src="js/jquery-2.2.3.min.js"></script> 
<!-- //js --> 
<!-- web-fonts -->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Lovers+Quarrel' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Offside' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'>
<!-- web-fonts --> 
<script src="js/owl.carousel.js"></script>  
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
<script src="js/jquery-scrolltofixed-min.js" type="text/javascript"></script>
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
    });
</script>
<!-- start-smooth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>	
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
<script src="js/bootstrap.js"></script>	

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-68172934-9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-68172934-9');
</script>


<!--testing multiple google tags -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<?php if ($googletagmanager){

echo "<script async src='https://www.googletagmanager.com/gtag/js?id=".
$google_tag_code."'></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '".$google_tag_code."');
</script>";

}else{

	echo "<script async src='https://www.googletagmanager.com/gtag/js?id=UA-68172934-9'></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-68172934-9');
</script>";

}


if($facebook_pixel_code){
	//facebook pixel code slowing down website
/*
echo "<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '".$facebook_pixel_code."');
  fbq('track', 'PageView');
</script>
<noscript><img height='1' width='1' style='display:none'
  src='https://www.facebook.com/tr?id=".$facebook_pixel_code."&ev=PageView&noscript=1'
/></noscript>";
*/
	
}

?>




<!--End Facebook Pixel Code -->

<a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp_phone_number; ?>&text=Hello <?php echo ucfirst($storename).', I need more info on - '.str_replace('+', '%2B', $actual_link); ?>" class="float" target="_blank" style="position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	background-color:#25d366;
	color:#FFF;
	border-radius:50px;
	text-align:center;
  font-size:30px;
	box-shadow: 2px 2px 3px #999;
  z-index:100;">
<i class="fa fa-whatsapp my-float" style="margin-top:16px;"></i>
</a>


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
					<select class="form-control bfh-states" data-country="KE" data-state="NRB">
						<option value="">Select Your location</option>
						<option value="Nrb">Nairobi</option><option value="Ksm">Kisumu</option><option value="Mbsa">Mombasa</option>
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
	<!-- header -->
	<div class="header">
		<div class="w3ls-header"><!--header-one--> 
			<div class="w3ls-header-left">
				<p><a href="#">CONTACT US   &nbsp;&nbsp;|&nbsp;&nbsp;   <?php echo $phone_number; ?> </a></p>
			</div>
			<div class="w3ls-header-right">
				<ul>

					<?php
					if($storename=='javy'){
						echo '<li class="dropdown head-dpdn">
						<a href="https://biz.javy.co.ke" class="dropdown-toggle"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back to Main Website</a>
					</li>';
					echo '<li class="dropdown head-dpdn">
						<a href="http://promote.javy.co.ke/signup.php" class="dropdown-toggle"><i class="fa fa-cart-plus" aria-hidden="true"></i> Open up your own store like this</a>
					</li>';
					echo '<li class="dropdown head-dpdn">
						<a href="http://supply.javy.co.ke/signup.php" class="dropdown-toggle"><i class="fa fa-users" aria-hidden="true"></i> Supply Us</a>
					</li>';
					}
					

					?>
					
					
					<li class="dropdown head-dpdn">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i>Account<span class="caret"></span></a>
						<ul class="dropdown-menu">

							<?php

							
							if(isset($_SESSION['customerId'])) {
								echo '<li><a href="orders.php">Customer Orders</a></li>
								<li><a href="messages.php">Customer Messages</a></li>
								<li><a href="account-details.php">Customer Account Details</a></li> 
							<li><a href="logout.php">Customer Logout</a></li>';
							}else{
								echo '<li><a href="login.php">Customer Login</a></li> 
							<li><a href="signup.php">Customer Sign Up</a></li>';	
							}
							echo '<li><a href="supply-admin/login.php">Supplier Login</a></li> ';
							echo '<li><a href="supply-admin/signup.php">Supplier Sign Up</a></li> ';

							echo '<li><a href="av-admin/">Admin Login</a></li> ';

							?>
							
							
							<!--<li><a href="login.html">Wallet</a></li>-->
						</ul> 
					</li> 
					

					<!--temporarily disable account options for future use
					<li class="dropdown head-dpdn">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gift" aria-hidden="true"></i> Today's Deals<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="offers.html">Cash Back Offers</a></li> 
							<li><a href="offers.html">Product Discounts</a></li>
							<li><a href="offers.html">Special Offers</a></li> 
						</ul> 
					</li> -->

					<li class="dropdown head-dpdn">
						<a href="offers.php" class="dropdown-toggle"><i class="fa fa-gift" aria-hidden="true"></i> Special Offers</a>
					</li> 
					<!--<li class="dropdown head-dpdn">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gift" aria-hidden="true"></i> Gift Cards<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="offers.html">Product Gift card</a></li> 
							<li><a href="offers.html">Occasions Register</a></li>
							<li><a href="offers.html">View Balance</a></li> 
						</ul> 
					</li> -->
					<li class="dropdown head-dpdn">
						<a href="about.php" class="dropdown-toggle"><i class="fa fa-book" aria-hidden="true"></i> About Us</a>
					</li> 
					<li class="dropdown head-dpdn">
						<a href="contact.php" class="dropdown-toggle"><i class="fa fa-map-marker" aria-hidden="true"></i> Contact Us</a>
					</li> 

					<!--Comment out founder if set as 0 or don't show dealer details-->
					<?php if(!$show_founder){echo "<!--";} ?>
					<li class="dropdown head-dpdn">
						<a href="founder_ceo.php" class="dropdown-toggle"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Founder & CEO</a>
					</li> 
					<?php if(!$show_founder){echo "-->";} ?>
					<li class="dropdown head-dpdn">
						<a href="help.php" class="dropdown-toggle"><i class="fa fa-question-circle" aria-hidden="true"></i> Help</a>
					</li>
				</ul>
			</div>
			<div class="clearfix"> </div> 
		</div>
		<div class="header-two"><!-- header-two -->
			<div class="container">
				<div class="header-logo">
					<h1><a href="index.php"><span><?php echo strtoupper(substr($storename, 0, 1)); ?></span><?php echo substr($storename,1,mb_strlen($storename)-1); ?> </a></h1>
					<!--<h6>Your stores. Your place.</h6>--> 
				</div>	
				<div class="header-search">
					<form action="search.php" method="GET">
						<input type="search" name="search" placeholder="Search for a Product..." required="">
						<button type="submit" class="btn btn-default" aria-label="Left Align">
							<i class="fa fa-search" aria-hidden="true"> </i>
						</button>
					</form>
				</div>
				<div class="header-cart"> 
					<div class="my-account">
						<a href="contact.php"><i class="fa fa-map-marker" aria-hidden="true"></i> CONTACT US</a>						
					</div>
					<div class="cart"> 
						
							<a href="cart.php"><button class="w3view-cart"  value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button></a> 
					</div>
					<div class="clearfix"> </div> 
				</div> 
				<div class="clearfix"> </div>
			</div>		
		</div><!-- //header-two -->



		<div class="header-three"><!-- header-three -->
			<div class="container">
				<div class="menu">
					<div class="cd-dropdown-wrapper">
						<a class="cd-dropdown-trigger" href="#0"><i class="fa fa-bars"></i>  Store Categories</a>
						<nav class="cd-dropdown"> 
							<a href="#0" class="cd-close">Close</a>
							<ul class="cd-dropdown-content"> 
								<li><a href="<?php echo $page_with_products; ?>">Shop - All Products</a></li>





								<?php 


								//retrieving products approved on the store id and supplier stores
								
								if($shop_type==0 || $shop_type==1 || $shop_type==4){
									$sql_categories="SELECT * FROM categories";
								}else{
									$sql_categories="SELECT * FROM categories WHERE shop_type=".$shop_type;
								}

							$query_run_categories=$connect->query($sql_categories);
							$categories_and_brands=[];
							while($row=mysqli_fetch_assoc($query_run_categories)){
								$category_name=$row['categories_name'];
								$category_slug=$row['categories_slug'];
								$category_id=$row['categories_id'];

								if($shop_type==1){
								    $query_check_category='SELECT * FROM `products` WHERE store_id="'.$user_id.'" AND status="1" AND approval!="0" AND category="'.$category_slug.'" ';
								}else if($shop_type==4){
									$query_check_category='SELECT * FROM `products` WHERE ((supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND status="1" AND category="'.$category_slug.'") OR (store_id="'.$user_id.'" AND status="1" AND approval!="0" AND category="'.$category_slug.'") ';
								}else{
									$query_check_category=$query='SELECT * FROM `products` WHERE ((supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND status="1" AND category="'.$category_slug.'") OR (status="1" AND (approval="2" OR (approval="1" AND store_id='.$user_id.')) AND category="'.$category_slug.'")';
								}
								//check if the category has products approved by Javy and Promoter
								
								$query_run_check_categories=$connect->query($query_check_category);
								$products_in_category=mysqli_num_rows ($query_run_check_categories);
								//check if the category has products approved by Javy and Promoter
								//check complete
								if($products_in_category){

								echo '<li class="has-children">
									<a href="#">'.ucfirst($category_name).'</a> 
									<ul class="cd-secondary-dropdown is-hidden">
										<li class="go-back"><a href="#">Menu</a></li>
										<li class="see-all"><a href="'.$page_with_products.'?category='.$category_slug.'">All '.ucfirst($category_name).'</a></li>
										<li class="has-children">
											<a href="'.$page_with_products.'?category='.$category_slug.'">'.strtoupper($category_name).' BRANDS</a>  
											<ul class="is-hidden"> 
												<li class="go-back"><a href="#">Back</a></li> ';	


									$sql_brands="SELECT * FROM brands WHERE brand_category='$category_id' ORDER BY brand_name";
								$query_run_brands=$connect->query($sql_brands);
								while ($row=mysqli_fetch_assoc($query_run_brands)){
									$brand_name=$row['brand_name'];
									$brand_slug=$row['brand_slug'];
									$brand_id=$row['brand_id'];

								//check if the brand has products approved by Javy and Promoter
								if($shop_type==1){
								    $query_check_brand='SELECT * FROM `products` WHERE store_id="'.$user_id.'" AND status="1" AND approval!="0" AND brand="'.$brand_slug.'" ';
								}else if($shop_type==4){
									$query_check_brand='SELECT * FROM `products` WHERE ((supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND status="1" AND brand="'.$brand_slug.'") OR (store_id="'.$user_id.'" AND status="1" AND approval!="0" AND brand="'.$brand_slug.'") ';
								}else{
									$query_check_brand=$query='SELECT * FROM `products` WHERE ((supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND status="1" AND brand="'.$brand_slug.'") OR (status="1" AND (approval="2" OR (approval="1" AND store_id='.$user_id.')) AND brand="'.$brand_slug.'")';
								}

								
								$query_run_check_brands=$connect->query($query_check_brand);
								$products_in_brand=mysqli_num_rows ($query_run_check_brands);
								//check if the brand has products approved by Javy and Promoter
								//check complete
								if($products_in_brand){
									echo '<li><a href="'.$page_with_products.'?category='.$category_slug.'&brand='.$brand_slug.'">'.$brand_name.'</a></li>';
								}
									
								}


								if($shop_type==1){
								    $query_check_other='SELECT * FROM `products` WHERE store_id="'.$user_id.'" AND status="1" AND approval!="0" AND brand="other" AND category="'.$category_slug.'" ';
								}else if($shop_type==4){
									$query_check_other='SELECT * FROM `products` WHERE ((supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND status="1" AND brand="other" AND category="'.$category_slug.'") OR (store_id="'.$user_id.'" AND status="1" AND approval!="0" AND brand="other" AND category="'.$category_slug.'") ';
								}else{
									$query_check_other='SELECT * FROM `products` WHERE ((supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND status="1" AND brand="other" AND category="'.$category_slug.'") OR (status="1" AND (approval="2" OR (approval="1" AND store_id='.$user_id.')) AND brand="other" AND category="'.$category_slug.'")';
								}
								
								$query_run_check_other=$connect->query($query_check_other);
								$products_in_other=mysqli_num_rows ($query_run_check_other);
								//check if the brand has products approved by Javy and Promoter
								//check complete
								if($products_in_other){
									echo '<li><a href="'.$page_with_products.'?category='.$category_slug.'&brand=other">Other</a></li>';
								}

								echo "</ul>
										</li> 

									</ul> <!-- .cd-secondary-dropdown --> 
								</li> <!-- .has-children -->";
							}

							}

							// No need for other categories
							// echo '<li class="has-children">
							// 		<a href="#">Other</a> 
							// 		<ul class="cd-secondary-dropdown is-hidden">
							// 			<li class="go-back"><a href="#">Menu</a></li>
							// 			<li class="see-all"><a href="shop.php?category=other">All Other</a></li>
							// 			<li class="has-children">
							// 				<a href="shop.php?category=other">OTHER BRANDS</a>  
							// 				<ul class="is-hidden"> 
							// 					<li class="go-back"><a href="#">Back</a></li> ';

							// echo '<li><a href="shop.php?category=other&brand=other">Other</a></li>';

							// echo "</ul>
							// 			</li> 

							// 		</ul> <!-- .cd-secondary-dropdown --> 
							// 	</li> <!-- .has-children -->";

									



								?>
												 
											




								<li><a href="sitemap.php">Full Site Directory </a></li>  
							</ul> <!-- .cd-dropdown-content -->
						</nav> <!-- .cd-dropdown -->
					</div> <!-- .cd-dropdown-wrapper -->	 
				</div>
				<div class="move-text">
					<div class="marquee"><a href="offers.php"> Best offers on all products...... <span> Place your order | get it fast! </span> <span> Countrywide delivery. Same day in Nairobi. Next day outside Nairobi</span></a></div>
					<script type="text/javascript" src="js/jquery.marquee.min.js"></script>
					<script>
					  $('.marquee').marquee({ pauseOnHover: true });
					  //@ sourceURL=pen.js
					</script>
				</div>
			</div>
		</div>
	</div>


	<!-- //header -->	