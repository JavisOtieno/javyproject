<?php include 'header.php'; ?>

<!-- site map -->
	<div class="sitemap">
		<div class="container"> 
			<h3 class="w3ls-title w3ls-title1">Our Sitemap</h3>
			<div class="sitemap-row"> 
				<nav class="sitemap-tabs" data-spy="affix" data-offset-top="400"> 
					<div  id="myNavbar">
						<ul> 
							

								<?php


			$sql_categories="SELECT * FROM categories";
									

							$query_run_categories=$connect->query($sql_categories);
							$categories_and_brands=[];
							while($row=mysqli_fetch_assoc($query_run_categories)){
								$category_name=$row['categories_name'];
								$category_slug=$row['categories_slug'];
								$category_id=$row['categories_id'];

								if($products_type==0){
									$query_check_category='SELECT * FROM `products` WHERE (supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'"';
								}else{
									$query_check_category='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'"';
								}
								//check if the category has products approved by Javy and Promoter
								
								$query_run_check_categories=$connect->query($query_check_category);
								$products_in_category=mysqli_num_rows ($query_run_check_categories);
								//check if the category has products approved by Javy and Promoter
								//check complete
								if($products_in_category){


								echo '<li><a href="#w3sec1"><i class="fa fa-'.$category_slug.'"></i>'.ucfirst($category_name).'</a></li>';

							}

							}

							

					
							?>

						</ul> 
					</div>
				</nav>	

				<?php		

			foreach ($category_array as $category => $brand_array) {

			 echo '<div id="w3sec1" class="container-fluid sitemap-text">
					<h3 class="w3sitemap-title"><i class="fa fa-cart-arrow-down"></i>'.ucfirst($category).'</h3>  
					<div class="col-md-3 sitemap-text-grids"> 
						<h5 class="sitemap-text-title"><a href="shop.php?category='.$category.'">ALL '.strtoupper($category).'</a></h5> 
						<ul> ';


			foreach($brand_array as $brand) {
				echo '<li><a href="shop.php?category='.$category.'&brand='.$brand.'">'.ucfirst($brand).'</a></li>';
			}
			

			 echo '</ul>  
						
					</div>	
				
					
					
					<div class="clearfix"> </div>
				</div>';
			}








			?>

			<?php


			$sql_categories="SELECT * FROM categories";
									

							$query_run_categories=$connect->query($sql_categories);
							$categories_and_brands=[];
							while($row=mysqli_fetch_assoc($query_run_categories)){
								$category_name=$row['categories_name'];
								$category_slug=$row['categories_slug'];
								$category_id=$row['categories_id'];

								if($products_type==0){
									$query_check_category='SELECT * FROM `products` WHERE (supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'"';
								}else{
									$query_check_category='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'"';
								}
								//check if the category has products approved by Javy and Promoter
								//echo $query_check_category;
								
								$query_run_check_categories=$connect->query($query_check_category);
								$products_in_category=mysqli_num_rows ($query_run_check_categories);
								//check if the category has products approved by Javy and Promoter
								//check complete
								if($products_in_category){



					echo '<div id="w3sec1" class="container-fluid sitemap-text">
					<h3 class="w3sitemap-title"><i class="fa fa-cart-arrow-down"></i>'.ucfirst($category_name).'</h3>  
					<div class="col-md-3 sitemap-text-grids"> 
						<h5 class="sitemap-text-title"><a href="shop.php?category='.$category_slug.'">ALL '.strtoupper($category_name).'</a></h5> 
						<ul> ';

									$sql_brands="SELECT * FROM brands WHERE brand_category='$category_id' ORDER BY brand_name";
								$query_run_brands=$connect->query($sql_brands);
								while ($row=mysqli_fetch_assoc($query_run_brands)){
									$brand_name=$row['brand_name'];
									$brand_slug=$row['brand_slug'];
									$brand_id=$row['brand_id'];


								if($products_type==0){
									$query_check_brand='SELECT * FROM `products` WHERE (supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND brand="'.$brand_slug.'"';
								}else{
									$query_check_brand='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND brand="'.$brand_slug.'"';
								}

								
								$query_run_check_brands=$connect->query($query_check_brand);
								$products_in_brand=mysqli_num_rows ($query_run_check_brands);
								//check if the brand has products approved by Javy and Promoter
								//check complete
								if($products_in_brand){

									echo '<li><a href="index.php?category='.$category_slug.'&brand='.$brand_slug.'">'.ucfirst($brand_name).'</a></li>';
								}
									
								}


								if($products_type==0){
									$query_check_other='SELECT * FROM `products` WHERE (supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'" AND brand="other"';
								}else{
									$query_check_other='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'" AND brand="other"';
								}
								
								$query_run_check_other=$connect->query($query_check_other);
								$products_in_other=mysqli_num_rows ($query_run_check_other);
								//check if the brand has products approved by Javy and Promoter
								//check complete
								if($products_in_other){
									echo '<li><a href="index.php?category='.$category_slug.'&brand=other">'.ucfirst($brand_name).'</a></li>';
								}

								  echo '</ul>  
						
					</div>	
				
					<div class="clearfix"> </div>
				</div>';
							}

							}

							

						?>

			<script>
			$(document).ready(function(){
			  // Add scrollspy to <body>
			  $('body').scrollspy({target: ".sitemap-tabs", offset: 50});

			  // Add smooth scrolling on all links inside the navbar
			  $("#myNavbar a").on('click', function(event) {
				// Make sure this.hash has a value before overriding default behaviour
				if (this.hash !== "") {
				  // Prevent default anchor click behaviour
				  event.preventDefault();

				  // Store hash
				  var hash = this.hash;

				  // Using jQuery's animate() method to add smooth page scroll
				  // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
				  $('html, body').animate({
					scrollTop: $(hash).offset().top
				  }, 800, function(){
			   
					// Add hash (#) to URL when done scrolling (default click behaviour)
					window.location.hash = hash;
				  });
				}  // End if
			  });
			});
			</script> 
			<div class="sitemap-row2  sitemap-text"> 
				<h3 class="w3sitemap-title"><i class="fa fa-gears"></i><?php echo ucfirst($storename);?> Services</h3>  
				<div class="col-md-4 sitemap-text-grids">
					<ul>  
					 	<li><a href="about.php">About Us</a></li> 
						<li><a href="contact.php">Contact Us</a></li> 
						<li><a href="privacy.php">Privacy Policy</a></li>  
					</ul>
				</div>
				<div class="col-md-4 sitemap-text-grids">
					<ul>  
						

						<li><a href="login.php">Login</a></li> 
						<li><a href="signup.php">Sign Up</a></li>
						<li><a href="login.php">Order Status</a></li>   
					</ul>
				</div>
				<div class="col-md-4 sitemap-text-grids">
					<ul>  
						<!--Comment out founder if set as 0 or don't show dealer details-->
							
						
						<li><a href="faq.php">FAQ</a></li>  
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	</div>
	<!-- //site map --> 

<?php include 'footer.php'; ?>