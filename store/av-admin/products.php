<?php require_once 'includes/header.php'; 

echo '</div>';
//localhost code

/*
$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "stock2";
//web code
*/


$localhost = "sql286.your-server.de";
$username = "javy2021";
$password = "@Ja20vy20";
$dbname = "javy2021";


$connect = new mysqli($localhost,$username, $password, $dbname);
$db_link= mysqli_connect($localhost,$username, $password, $dbname);


if($connect->connect_error){
	echo 'Connection failed:'.$connect->connect_error;
}else{
	//echo "succesfully connected.";
}


$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$shop_type=$result['shop_type'];
$supplier_id=$result['supplier_registered_on'];

if($supplier_id==0){
	$supplier_id=10000000;
}


?>
	<link href="custom/css-products/owl.carousel.css" rel="stylesheet" type="text/css" media="all"> <!-- carousel slider --> 
	<link href="custom/css-products/animate.min.css" rel="stylesheet" type="text/css" media="all" />  
	<link href='//fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'>		
	<!-- web-fonts --> 		
	<!-- scroll to fixed--> 		
	
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Find all your products here. Make money on your own electronics store." />
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
  <!-- bootstrap and jquery js-->
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

		

<?php
	//all our categories placed on top before the categories section
	$phone_brands= array("Asus", "Blackberry", "Fero", "Google", "HTC", "Huawei","Infinix","iPhone","Lenovo","LG","Nokia","Oppo","Samsung","Sony","Tecno","Xiaomi","X-tigi","Tesla");
		$camera_brands=array("Nikon","Sony");
		$tablet_brands=array("Fero","Huawei","iPad","Lenovo","Samsung","Tecno","X-tigi");
		$laptop_brands=array("Dell","HP","Lenovo","iLife","Toshiba");
		$home_theatre_brands=array("Sony","LG");
		$tv_brands=array("Hisense","LG","Samsung","Sony","TCL","Skyworth");
		$accessories_brands=array("Smartwatches","Camera Lenses","Flash Disks","Memory Cards","Hard Disks","Earphones","Headphones","Bluetooth Earphones","Laptop Bags");
	?>

	<!-- the mousewheel plugin -->

	<?php
if(isset($_GET['category'])){
		$category=$_GET['category'];

		$sql_category="SELECT categories_id FROM categories WHERE categories_name='$category'";
		$query_run_category=$connect->query($sql_category);
		while($row=mysqli_fetch_assoc($query_run_category)){
			$category_id=$row['categories_id'];
		}
		

		
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


		//search purposes
	

	?> 

	<!-- products -->
	<div class="products">	 
		<div class="container">
			<div class="col-md-9 product-w3ls-right ">
				<!-- breadcrumbs --> 
					<!-- Search form -->
					<div style="margin-bottom: 15px;">
<form class="form-inline md-form mr-auto">
  <input class="form-control mr-lg-2" type="text" placeholder="Search Products" aria-label="Search" name="search" >
  <button class="btn aqua-gradient btn-rounded btn-lg-2 my-0" style="font-size: 1.0em;" type="submit">Search</button>
</form>
</div>
				
				<div class="clearfix"> </div>
				<!-- //breadcrumbs -->
				<div class="product-top">
					<h4><?php 
					if(!isset($category))
						{echo "All Products";}
						else
							{echo ucfirst($category);} ?>
								
							</h4>
					<ul> 
						<!--<li class="dropdown head-dpdn">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Filter By<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">Low price</a></li> 
								<li><a href="#">High price</a></li>
								<li><a href="#">Latest</a></li> 
								<li><a href="#">Popular</a></li> 
							</ul> 
						</li>
						-->
						<li class="dropdown head-dpdn">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Brands<span class="caret"></span></a>
							<ul class="dropdown-menu">
							<?php
							if(!empty($category)){
								echo '<li><a href="products.php?category='.$category.'">All '.ucfirst($category).'</a></li>';
						

							$sql_brands="SELECT brand_name FROM brands WHERE brand_category='$category_id'";
							$query_run_brands=$connect->query($sql_brands);
							$brands=[];
							while($row=mysqli_fetch_assoc($query_run_brands))
							{
								echo '<li><a href="products.php?category='.$category.'&brand='.strtolower($row['brand_name']).'">'.$row['brand_name'].'</a></li>';
							}


							}
							?>
							
							</ul> 
						</li>
					</ul> 
					<div class="clearfix"> </div>
				</div>
								<div class="products-row">

							<?php

			if(isset($_GET['category'])&&isset($_GET['brand'])){
			$query='SELECT * FROM `products` WHERE category="'.$category.'" AND status="1" AND (approval="2" OR (approval="1" AND store_id='.$user_id.') OR supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND brand="'.$brand.'"';
			}
			else if(isset($_GET['category'])&&!isset($_GET['brand'])){
				$query='SELECT * FROM `products` WHERE category="'.$category.'" AND status="1"  AND (approval="2" OR (approval="1" AND store_id='.$user_id.') OR supplier_id="'.$supplier_id.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')")';
			}
			else{

				if($shop_type==0){
					$query='SELECT * FROM `products` WHERE status="1"  AND (approval="2" OR (approval="1" AND store_id='.$user_id.') OR supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.'))';
				}else{
					$sql_categories="SELECT * FROM categories WHERE shop_type=".$shop_type;

					$query_run_categories=$connect->query($sql_categories);

					$firstone=1;
					$category_slug_query='';
					
					while($row=mysqli_fetch_assoc($query_run_categories)){
						$category_slug=$row['categories_slug'];
						if($firstone==1){
							$category_slug_query=$category_slug_query.' AND category="'.$category_slug.'"';
						}else{
							$category_slug_query=$category_slug_query.' OR category="'.$category_slug.'"';
						}
						

						$firstone=2;
					}

					$query='SELECT * FROM `products` WHERE status="1"  AND (approval="2" OR (approval="1" AND store_id='.$user_id.') OR supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.'))'.$category_slug_query;
			
				}

				
			}

			//echo $shop_type;

			if($shop_type==1){

			if(isset($_GET['category'])&&isset($_GET['brand'])){
			$query='SELECT * FROM `products` WHERE category="'.$category.'" AND store_id='.$user_id.' AND brand="'.$brand.'" AND status="1" AND approval!="0" ORDER BY price';
			}
			else if(isset($_GET['category'])&&!isset($_GET['brand'])){
				$query='SELECT * FROM `products` WHERE category="'.$category.'" AND store_id='.$user_id.' AND status="1" AND approval!="0" ORDER BY price';
			}
			else{
				$query='SELECT * FROM `products` WHERE status="1" AND store_id='.$user_id.' AND approval!="0" ORDER BY category,brand,price';
			}

		}else if($shop_type==4){

			if(isset($_GET['category'])&&isset($_GET['brand'])){
			$query='SELECT * FROM `products` WHERE category="'.$category.'" AND ((supplier_id='.$supplier_id.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) OR (approval!="0" AND store_id='.$user_id.')) AND brand="'.$brand.'" AND status="1" ORDER BY price';
			}
			else if(isset($_GET['category'])&&!isset($_GET['brand'])){
				$query='SELECT * FROM `products` WHERE category="'.$category.'" AND ((supplier_id='.$supplier_id.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) OR (approval!="0" AND store_id='.$user_id.')) AND status="1" ORDER BY price';
			}
			else{
				$query='SELECT * FROM `products` WHERE status="1" AND ((supplier_id='.$supplier_id.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) OR (approval!="0" AND store_id='.$user_id.')) ORDER BY category,brand,price';
			}

		}
		

			$query_first=$query;
			
			//pagination start
			$result=$connect->query($query);
			$count_rows=$result->num_rows;
			$pages=ceil($count_rows/20);
			//pagination continued at the bottom 

			if(isset($_GET['category'])&&isset($_GET['brand'])){
			$query='SELECT * FROM `products` WHERE category="'.$category.'" AND status="1" AND (approval="2" OR (approval="1" AND store_id='.$user_id.') OR supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND brand="'.$brand.'" ORDER BY price LIMIT '.$page1.',20';

			if($shop_type==1){
				$query='SELECT * FROM `products` WHERE category="'.$category.'" AND status="1" AND approval!="0" AND store_id='.$user_id.' AND brand="'.$brand.'" ORDER BY price LIMIT '.$page1.',20';
			}else if($shop_type==4){
				$query='SELECT * FROM `products` WHERE category="'.$category.'" AND status="1" AND ((supplier_id='.$supplier_id.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) OR (approval!="0" AND store_id='.$user_id.')) AND brand="'.$brand.'" ORDER BY price LIMIT '.$page1.',20';
			}

			}
			else if(isset($_GET['category'])&&!isset($_GET['brand'])){
				$query='SELECT * FROM `products` WHERE category="'.$category.'" AND status="1" AND (approval="2" OR (approval="1" AND store_id='.$user_id.') OR supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) ORDER BY brand,price LIMIT '.$page1.',20';

				if($shop_type==1){
				$query='SELECT * FROM `products` WHERE category="'.$category.'" AND status="1" AND approval!="0" AND store_id='.$user_id.' ORDER BY brand,price LIMIT '.$page1.',20';
			}else if($shop_type==4){
				$query='SELECT * FROM `products` WHERE category="'.$category.'" AND status="1" AND ((supplier_id='.$supplier_id.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) OR (approval!="0" AND store_id='.$user_id.')) ORDER BY brand,price LIMIT '.$page1.',20';
			}

			}
			else{
				$query=$query_first.' LIMIT '.$page1.',20';
				
			}

			if(isset($_GET['search'])){
				$search=$_GET['search'];

							$search_array=explode(' ',$search);

			$search_sql='';
			foreach($search_array as $item) {

			$search_sql.=" AND `name` LIKE '%".$item."%'";

			}



				if($shop_type==0){
					$query="SELECT * FROM `products` WHERE `status`='1' AND (approval='2' OR (approval='1' AND store_id='$user_id') OR supplier_id=".$supplier_id." OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id=".$supplier_id."))".$search_sql;
				}else if($shop_type==1){
					$query="SELECT * FROM `products` WHERE `status`='1' AND (approval='2' OR approval='1') AND store_id='$user_id' ".$search_sql;
				}
				else if($shop_type==4){
					$query="SELECT * FROM `products` WHERE `status`='1' AND (supplier_id='$supplier_id' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) ".$search_sql;
				}
				else{
					$sql_categories="SELECT * FROM categories WHERE shop_type=".$shop_type;

					$query_run_categories=$connect->query($sql_categories);

					$firstone=1;
					$category_slug_query='';
					
					while($row=mysqli_fetch_assoc($query_run_categories)){
						$category_slug=$row['categories_slug'];
						if($firstone==1){
							$category_slug_query=$category_slug_query.' AND (category="'.$category_slug.'"';
						}else{
							$category_slug_query=$category_slug_query.' OR category="'.$category_slug.'"';
						}

						

						$firstone=2;
					}
					
					$category_slug_query=$category_slug_query.')';

					
					$query="SELECT * FROM `products` WHERE `status`='1' AND (approval='2' OR (approval='1' AND store_id='$user_id') OR supplier_id=".$supplier_id." OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id=".$supplier_id."))".$search_sql." ".$category_slug_query;
				}

				//pagination start meant for search
			$result=$connect->query($query);
			$count_rows=$result->num_rows;
			$pages=ceil($count_rows/20);
			//pagination continued at the bottom meant for search

			$query = $query.' LIMIT '.$page1.',20';
			}
	
			
		

			$query_run=mysqli_query($db_link,$query);
			$count=1;

		
			while($row=mysqli_fetch_assoc($query_run)){

				
				if($row['image']==''){
					$image_uri='https://promote.javy.co.ke/assests/images/product-images/picture-coming-soon.jpg';
				}else{
					$image_uri=str_replace("..", "https://promote.javy.co.ke", $row['image']);
				}

				//check code below
				//echo $supplier_id.'-'.$row['supplier_id'];

				if($supplier_id!=$row['supplier_id'] &&$row['supplier_id']!=0){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier_id AND product_id=".$row['id'];
					//echo $query_more_suppliers;
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
					if($row2=mysqli_fetch_assoc($query_run_more_suppliers)){
						if($row2['price']!=0){
							$product_price=$row2['price'];
						}else{
							$product_price=$row['price'];
						}
						if($row2['profit']!=0){
							$product_profit=$row2['profit'];
						}else{
							$product_profit=$row['profit'];
						}
						if($row2['cost']!=0){
							$cost=$row2['cost'];
						}else{
							$cost=$row['cost'];
						}
					}else{
					$product_price=$row['price'];
					$product_profit=$row['profit'];	
					$cost=$row['cost'];
					}
				}else{
					$product_price=$row['price'];
					$product_profit=$row['profit'];	
					$cost=$row['cost'];			}

					//check above code

				showProduct($image_uri,$row['name'],$product_price,$product_profit,$row['id'],$count);
				
				
				$count++;
				
				
				
			}

						function showProduct($image,$name,$price,$profit,$id,$count)
			{
			

				echo '	<div class="col-md-3 product-grids" > 
						<div class="agile-products" >
							
							<a href="product.php?id='.$id.'"><img src="'.$image.'" class="img-responsive img-match-height" alt="img"></a>
							<div class="agile-product-text">   
							<div id="link'.$count.'">           
								<h5><a href="product.php?id='.$id.'">'.$name.'</a></h5>
								</div> 
								<h6>KSh. '.number_format($price).'</h6> 
								<h6 style="color:green;">KSh. '.number_format($profit).'</h6> 
								<!--<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Audio speaker" /> 
									<input type="hidden" name="amount" value="100.00" /> 
									<button type="submit" class="w3ls-cart pw3ls-cart"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form> -->
								<a href="product.php?id='.$id.'"><button class="w3ls-cart pw3ls-cart" ><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
							</div>
						</div> 
					</div>';}
			
			
			
			
			
			?>
	 
					<div class="clearfix"> </div>
				</div>


					<style>
.pagination {
    display: inline-block;
    margin-top: 50px;
    font-size: 1.5em;
}

.pagination a {
    color: #F55044;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
    margin: 0 4px;
}

.pagination a.active {
    background-color: #F44336;
    color: white;
    border: 1px solid #F44336;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>

				<div class="pagination">

<a href="products.php<?php if(isset($category)){echo '?category='.$category;} if(isset($_GET['brand'])){echo '&brand='.$brand; }  if(isset($search)){echo '?search='.$search;} ?><?php if(isset($category)||isset($search)){echo '&page=';}else {echo '?page=';} ?><?php echo $page-1;  ?>" <?php if($page==1){ echo 'style="display: none;"';} ?>>&laquo; Previous</a>

		<?php
		for($b=1;$b<=$pages;$b++){

			
			?><a href="products.php<?php if(isset($category)){echo '?category='.$category;} if(isset($_GET['brand'])){echo '&brand='.$brand; }  if(isset($search)){echo '?search='.$search;} ?><?php if(isset($category)||isset($search)){echo '&page=';}else {echo '?page=';} ?><?php echo $b; ?>" <?php if ($page==$b){echo 'class="active"';}?> ><?php echo $b; ?></a><?php
				
			}

			?>
  
 
  <a href="products.php<?php if(isset($category)){echo '?category='.$category;} if(isset($_GET['brand'])){echo '&brand='.$brand; } if(isset($search)){echo '?search='.$search;} ?><?php if(isset($category)||isset($search)){echo '&page=';}else {echo '?page=';} ?><?php echo $page+1;  ?>" <?php if($page==$pages){ echo 'style="display: none;"';} ?>>&raquo; Next</a>

</div>
				<!-- add-products --> 
				<!--
				<div class="w3ls-add-grids w3agile-add-products">
					<a href="#"> 
						<h4>TOP 10 TRENDS FOR YOU FLAT <span>20%</span> OFF</h4>
						<h6>Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
				</div>
				--> 
				<!-- //add-products -->
			</div>
			<div class="col-md-3 rsidebar">
				<div class="rsidebar-top">
					
					<div class="sidebar-row" style="margin-top: 0;">
						
						<h4>  CATEGORIES & BRANDS</h4>
								<ul class="faq">
								<?php

								if(false){

			if($shop_type==1){
				$query_category_brand='SELECT category,brand FROM `products` WHERE store_id="'.$user_id.'" AND status="1" AND approval!="0"';
			}else if($shop_type==4){
				$query_category_brand='SELECT category,brand FROM `products` WHERE ((supplier_id='.$supplier_id.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) OR (approval!="0" AND store_id='.$user_id.')) AND status="1" AND approval!="0"';
			}
			


			$query_run_category_brand=mysqli_query($db_link,$query_category_brand);

			$category_array=[];
			$brand_array=[];

				while($row=mysqli_fetch_assoc($query_run_category_brand)){

					$category_slug=$row['category'];
					$brand_slug=$row['brand'];
					if(empty($category_array[$category_slug])){
						$category_array[$category_slug]=[];
					}
					array_push($category_array[$category_slug], $brand_slug);
					
					
				}
			foreach ($category_array as $key => $value) {
										 $category_array[$key]=array_unique($category_array[$key]);
										}								

			foreach ($category_array as $category => $brand_array) {

			 echo '<li class="item1"><a href="#">'.ucfirst($category).'<span class="glyphicon glyphicon-menu-down"></span></a>
								<ul>
									<li class="subitem1"><a href="products.php?category='.$category.'">All '.ucfirst($category).'</a></li>';

			


			foreach($brand_array as $brand) {
				echo '<li class="subitem1"><a href="products.php?category='.$category.'&brand='.$brand.'">'.ucfirst($brand).'</a></li>';
			}
			

			 echo '</ul>
							</li>';

			}	

								}

								else{



							if($shop_type==0 || $shop_type==1 || $shop_type==4 ){
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

								//check if the category has products approved by Javy and Promoter
								if($shop_type==1){
								    $query_check_category='SELECT * FROM `products` WHERE store_id="'.$user_id.'" AND status="1" AND approval!="0" AND category="'.$category_slug.'" ';
								}else if($shop_type==4){
									$query_check_category='SELECT * FROM `products` WHERE ((supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND status="1" AND category="'.$category_slug.'") OR (store_id="'.$user_id.'" AND status="1" AND approval!="0" AND category="'.$category_slug.'") ';
								}else{
									$query_check_category='SELECT * FROM `products` WHERE status="1" AND (approval="2" OR (approval="1" AND store_id='.$user_id.') OR supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND category="'.$category_slug.'"';
								}
								
								$query_run_check_categories=$connect->query($query_check_category);
								$products_in_category=mysqli_num_rows ($query_run_check_categories);
								//check if the category has products approved by Javy and Promoter
								//check complete
								if($products_in_category){

								echo '<li class="item1"><a href="#">'.$category_name.'<span class="glyphicon glyphicon-menu-down"></span></a>
								<ul>
									<li class="subitem1"><a href="products.php?category='.$category_slug.'">All '.$category_name.'</a></li>';	


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
									$query_check_brand='SELECT * FROM `products` WHERE status="1" AND (approval="2" OR (approval="1" AND store_id='.$user_id.') OR supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND brand="'.$brand_slug.'"';
								}
								$query_run_check_brands=$connect->query($query_check_brand);
								$products_in_brand=mysqli_num_rows ($query_run_check_brands);
								//check if the brand has products approved by Javy and Promoter
								//check complete
								if($products_in_brand){
									echo '<li class="subitem1"><a href="products.php?category='.$category_slug.'&brand='.$brand_slug.'">'.$brand_name.'</a></li>';
								}
									
								}
								//echo '<li class="subitem1"><a href="shop.php?category='.$category_slug.'&brand=other">Other</a></li>';

								$query_check_other='SELECT * FROM `products` WHERE status="1" AND (approval="2" OR (approval="1" AND store_id='.$user_id.') OR supplier_id="'.$supplier_id.'" OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier_id.')) AND brand="other" AND category="'.$category_slug.'"';
								$query_run_check_other=$connect->query($query_check_other);
								$products_in_other=mysqli_num_rows ($query_run_check_other);
								//check if the brand has products approved by Javy and Promoter
								//check complete
								if($products_in_other){
									echo '<li class="subitem1"><a href="shop.php?category='.$category_slug.'&brand=other">Other</a></li>';
								}
						
																
																		
								echo '</ul>
							</li>';
						}
						}

						//echo '<li class="item1"><a href="#">Other<span class="glyphicon glyphicon-menu-down"></span></a><ul><li class="subitem1"><a href="shop.php?category=other">Other</a></li></ul></li>';

						}

						?>
					</ul>
							
						<!-- script for tabs -->
						<script type="text/javascript">
							$(function() {
							
								var menu_ul = $('.faq > li > ul'),
									   menu_a  = $('.faq > li > a');
								
								menu_ul.hide();
							
								menu_a.click(function(e) {
									e.preventDefault();
									if(!$(this).hasClass('active')) {
										menu_a.removeClass('active');
										menu_ul.filter(':visible').slideUp('normal');
										$(this).addClass('active').next().stop(true,true).slideDown('normal');
									} else {
										$(this).removeClass('active');
										$(this).next().stop(true,true).slideUp('normal');
									}
								});
							
							});
						</script>
						<!-- script for tabs -->
					</div>

					<!--<div class="slider-left" style="margin-top: 2em;">
						<h4>Filter By Price</h4>            
						<div class="row row1 scroll-pane">
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>KSh. 0 - 10,000 </label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>KSh 10,000 - 20,000 </label> 
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>KSh 20,000 - 30,000  </label> 
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>KSh 30,000 - 40,000</label> 
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>KSh 40,000 - 50,000</label> 
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>KSh 50,000 - 60,000</label> 
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>KSh 60,000 plus</label> 
						</div> 
					</div>-->
					<!--
					<div class="sidebar-row">
						<h4>DISCOUNTS</h4>
						<div class="row row1 scroll-pane">
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Upto - 10% (20)</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>70% - 60% (5)</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>50% - 40% (7)</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>30% - 20% (2)</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>10% - 5% (5)</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>30% - 20% (7)</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>10% - 5% (2)</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Other(50)</label>
						</div>
					</div>
					<div class="sidebar-row">
						<h4>Color</h4>
						<div class="row row1 scroll-pane">
							<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>White</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Pink</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Gold</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Blue</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Orange</label>
							<label class="checkbox"><input type="checkbox" name="checkbox"><i></i> Brown</label> 
						</div>
					</div>	-->		 
				</div>
				<!--<div class="related-row">
					<h4>Top Searches</h4>
					<ul>
						<li><a href="product.php?id=348">Huawei Y5 Prime 2018</a></li>
						<li><a href="product.php?id=600">Tecno Spark 2</a></li>
						<li><a href="product.php?id=349">Huawei Y9 2019</a></li>
						<li><a href="products.php?category=phones&brand=iphone">iPhone </a></li>
						<li><a href="products.php?category=phones&brand=samsung">Samsung Phones</a></li>
						<li><a href="products.php?category=tvs&brand=sony">Sony TV</a></li>
					</ul>
				</div>-->

				<?php 

				//get single product

				/*$query='SELECT * FROM `products` WHERE id=1';
								$query_run=mysqli_query($db_link,$query);
								$count=1;
								
								$row=mysqli_fetch_assoc($query_run);
								
									$image_uri=str_replace('../', '', $row['image']);
									$price='KSh. '.number_format($row['price']);
									$id=$row['id'];
									$name=$row['name'];

									*/

									
							
				?>
				<!--<div class="related-row">
					<h4>FEATURED PRODUCT</h4>
					<div class="galry-like">  
						<a href="product.php?id=<?php echo $id; ?>"><img src="<?php echo $image_uri; ?>" class="img-responsive" alt="img"></a>             
						<h4><a href="product.php?id=<?php echo $id; ?>"><?php echo $name; ?></a></h4> 
						<h5><?php echo $price; ?></h5>       
					</div>
				</div>-->
			</div>
			<div class="clearfix"> </div>
			
		</div>
	</div>
	</div>
	</div>

	</body>
	<!--//products-->  
	</html>
  <!-- bootstrap js -->







<script src="custom/js-products/jquery-scrolltofixed-min.js" type="text/javascript"></script>


	<!-- the jScrollPane script -->				};
	<script type="text/javascript" src="custom/js-products/jquery.jscrollpane.min.js"></script>	

	<script type="text/javascript" id="sourcecode">				
		$(function()				
		{			
			$('.scroll-pane').jScrollPane();		
		});			<!-- //smooth-scrolling-of-move-up -->
	</script>	   
	<script type="text/javascript">
		$('#navProducts').addClass('active');
		$("#topNavViewProducts").addClass('active');

	</script>
	</script>	
	<!-- //the jScrollPane script -->		
	<script type="text/javascript" src="custom/js-products/jquery.mousewheel.js"></script>	

	<script type="text/javascript" id="matchHeight">				
		$(function()				
		{		

		function compareHeight(y,z){
			var w;
		if(y>z){
			return y;
		}else{
			return z;
		}
		}




		function matchHeight(h1,h2,h3,h4){
		var x =compareHeight($(h1).outerHeight(),$(h2).outerHeight());
		x=compareHeight($(h3).outerHeight(),x);
		x=compareHeight($(h4).outerHeight(),x);

			$(h1).height(x);
			$(h2).height(x);
			$(h3).height(x);
			$(h4).height(x);
		}


window.addEventListener("load", function(){

			matchHeight('#link1','#link2','#link3','#link4');
		matchHeight('#link5','#link6','#link7','#link8');
		matchHeight('#link9','#link10','#link11','#link12');
		matchHeight('#link13','#link14','#link15','#link16');
		matchHeight('#link17','#link18','#link19','#link20');

		var cw = $('.img-match-height').width();
		$('.img-match-height').css({'height':cw+'px'});

    
});


		});			<!-- //smooth-scrolling-of-move-up -->
	</script>




