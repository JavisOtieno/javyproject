<?php include 'header.php' ?>
	<!-- banner -->
	<div class="banner">
		<div id="kb" class="carousel kb_elastic animate_text kb_wrapper" data-ride="carousel" data-interval="6000" data-pause="hover">
			<!-- Wrapper-for-Slides -->
            <div class="carousel-inner" role="listbox">  
                <div class="item active"><!-- First-Slide -->
                <a href="shop.php?category=phones">
                    <img src="images/smartphones.jpg" alt="" class="img-responsive" />
                    <div class="carousel-caption kb_caption kb_caption_right">
                        <h3 data-animation="animated flipInX">Best Prices on <span>All</span> Smartphones</h3>
                        <h4 data-animation="animated flipInX">Shop Now</h4>
                    </div>
                    </a>
                </div>  
                <div class="item"> <!-- Second-Slide -->
                <a href="search.php?search=hp+spectre">
                    <img src="images/hp-spectre-banner.jpg" alt="" class="img-responsive" />
                    <div class="carousel-caption kb_caption kb_caption_right">
                        <h3 data-animation="animated fadeInDown">HP Spectre</h3>
                        <h4 data-animation="animated fadeInUp">Shop Now</h4>
                    </div>
                    </a>
                </div> 
                <div class="item"><!-- Third-Slide -->
                <a href="shop.php?category=tvs">
                    <img src="images/tvs-banner.jpg" alt="" class="img-responsive"/>
                    <div class="carousel-caption kb_caption kb_caption_center">
                        <h3 data-animation="animated fadeInLeft">TVs Available</h3>
                        <h4 data-animation="animated flipInX">Shop Now</h4>
                    </div>
                </div> 
                </a>
            </div> 
            <!-- Left-Button -->
            <a class="left carousel-control kb_control_left" href="#kb" role="button" data-slide="prev">
				<span class="fa fa-angle-left kb_icons" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a> 
            <!-- Right-Button -->
            <a class="right carousel-control kb_control_right" href="#kb" role="button" data-slide="next">
                <span class="fa fa-angle-right kb_icons" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a> 
        </div>
		<script src="js/custom.js"></script>
	</div>
	<!-- //banner -->  
	<!-- welcome -->
	<div class="welcome"> 
		<div class="container"> 
			<div class="welcome-info">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class=" nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" >
							<i class="fa fa-mobile" aria-hidden="true"></i> 
							<h5>Phones</h5>
						</a></li>

						<li role="presentation"><a href="#carl" role="tab" id="carl-tab" data-toggle="tab"> 
							<i class="fa fa-camera" aria-hidden="true"></i>
							<h5>Cameras and Tablets</h5>
						</a></li>
						<li role="presentation"><a href="#james" role="tab" id="james-tab" data-toggle="tab"> 
							<i class="fa fa-laptop" aria-hidden="true"></i>
							<h5>Laptops</h5>
						</a></li>
						<li role="presentation"><a href="#decor" role="tab" id="decor-tab" data-toggle="tab"> 
							<i class="fa fa-desktop" aria-hidden="true"></i>
							<h5>TVs and Home Theatres</h5>
						</a></li>
						<li role="presentation"><a href="#sports" role="tab" id="sports-tab" data-toggle="tab"> 
							<i class="fa fa-pencil" aria-hidden="true"></i>
							<h5>Accessories</h5>
						</a></li> 

					</ul>
					<div class="clearfix"> </div>
					<h3 class="w3ls-title">Featured Products</h3>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
							<div class="tabcontent-grids">  
								<div id="owl-demo" class="owl-carousel"> 

									<?php

									displayFeaturedProducts("phones",$db_link);

									function displayFeaturedProducts($featured_category,$db_link){
			
			$query='SELECT * FROM `products` WHERE featured="1" AND category="'.$featured_category.'"';
			$query_run=mysqli_query($db_link,$query);
			$count=1;
			
			while($row=mysqli_fetch_assoc($query_run)){
				//localhost code
				//$image_uri=str_replace("..", "../stock-2", $row['image']);

				$image_uri=str_replace("..", "https://javy.co.ke/", $row['image']);
				$price='KSh. '.number_format($row['price']);
				$id=$row['id'];
				$name=$row['name'];
				$category=$row['category'];
				$brand=$row['brand'];
				showProduct($image_uri,$name,$price,$id,$category,$brand);
				
			}
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

								</div> 
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="carl" aria-labelledby="carl-tab">
							<div class="tabcontent-grids">
								<script>
									$(document).ready(function() { 
										$("#owl-demo1").owlCarousel({
									 
										  autoPlay: 3000, //Set AutoPlay to 3 seconds
									 
										  items :4,
										  itemsDesktop : [640,5],
										  itemsDesktopSmall : [414,4],
										  navigation : true
									 
										});
										
									}); 
								</script>
								<div id="owl-demo1" class="owl-carousel">

								<?php 

									
			
								$query='SELECT * FROM `products` WHERE featured="1" AND category IN ("cameras","tablets")';
								$query_run=mysqli_query($db_link,$query);
								$count=1;
								
								while($row=mysqli_fetch_assoc($query_run)){
								
									//localhost code
				//$image_uri=str_replace("..", "../stock-2", $row['image']);

				$image_uri=str_replace("..", "https://javy.co.ke/", $row['image']);
									$price='KSh. '.number_format($row['price']);
									$id=$row['id'];
									$name=$row['name'];
									$category=$row['category'];
									$brand=$row['brand'];
									showProduct($image_uri,$name,$price,$id,$category,$brand);
									
								}

							

								?>
									
								   
								</div>   
							</div>
						</div> 
						<div role="tabpanel" class="tab-pane fade" id="james" aria-labelledby="james-tab">
							<div class="tabcontent-grids">
								<script>
									$(document).ready(function() { 
										$("#owl-demo2").owlCarousel({
									 
										  autoPlay: 3000, //Set AutoPlay to 3 seconds
									 
										  items :4,
										  itemsDesktop : [640,5],
										  itemsDesktopSmall : [414,4],
										  navigation : true
									 
										});
										
									}); 
								</script>
								<div id="owl-demo2" class="owl-carousel"> 
									
								<?php 
								
								displayFeaturedProducts("laptops",$db_link);

								?>

								</div>    
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="decor" aria-labelledby="decor-tab">
							<div class="tabcontent-grids">
								<script>
									$(document).ready(function() { 
										$("#owl-demo3").owlCarousel({
									 
										  autoPlay: 3000, //Set AutoPlay to 3 seconds
									 
										  items :4,
										  itemsDesktop : [640,5],
										  itemsDesktopSmall : [414,4],
										  navigation : true
									 
										});
										
									}); 
								</script>
								<div id="owl-demo3" class="owl-carousel"> 
									
							<?php
			
								$query='SELECT * FROM `products` WHERE featured="1" AND category IN ("tvs","home-theatres")';
								$query_run=mysqli_query($db_link,$query);
								$count=1;
								
								while($row=mysqli_fetch_assoc($query_run)){
								
									//localhost code
				//$image_uri=str_replace("..", "../stock-2", $row['image']);

				$image_uri=str_replace("..", "https://javy.co.ke/", $row['image']);
				
									$price='KSh. '.number_format($row['price']);
									$id=$row['id'];
									$name=$row['name'];
									$category=$row['category'];
									$brand=$row['brand'];
									showProduct($image_uri,$name,$price,$id,$category,$brand);
									
								}

								?>

								</div>    
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="sports" aria-labelledby="sports-tab">
							<div class="tabcontent-grids">
								<script>
									$(document).ready(function() { 
										$("#owl-demo4").owlCarousel({
									 
										  autoPlay: 3000, //Set AutoPlay to 3 seconds
									 
										  items :4,
										  itemsDesktop : [640,5],
										  itemsDesktopSmall : [414,4],
										  navigation : true
									 
										}); 
									}); 
								</script>
								<div id="owl-demo4" class="owl-carousel"> 
									
								<?php 
								
								displayFeaturedProducts("accessories",$db_link);

								?>


								</div>    
							</div>
						</div> 
					</div>   
				</div>  
			</div>  	
		</div>  	
	</div> 
	<!-- //welcome -->



	<!-- add-products -->
	<div class="add-products"> 
		<div class="container">  
			<div class="add-products-row">
				<div class="w3ls-add-grids" style=" background: url(images/canon-banner.jpg)no-repeat 0px 0px;background-size: cover;">
					<a href="product.php?id=51" > 
						<h4>CANON EOS 1300D CAMERA <br />KSh. <span>37,999/-</span> </h4>
						<h6 style="color:#ffffff">Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
				</div>
				<div class="w3ls-add-grids w3ls-add-grids-mdl" style="background: url(images/huawei-y5-prime-banner.jpg)no-repeat 0px 0px;background-size: cover; ">
					<a href="product.php?id=348"> 
						<h4>HUAWEI Y5 PRIME <br />KSh. <span>10,500/-</span> </h4>
						<h6>Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
				</div>
				<div class="w3ls-add-grids w3ls-add-grids-mdl1" style="background: url(images/samsung-galaxy-note-9-banner.jpg)no-repeat 0px 0px;background-size: cover; ">
					<a href="product.php?id=1153"> 
						<h4>SAMSUNG GALAXY NOTE 9 <br />KSh. <span> 87,999/-</span></h4>
						<h6 style="color:#ffffff">Shop now <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></h6>
					</a>
				</div>
				<div class="clerfix"> </div>
			</div>  	
		</div>  	
	</div>
	<!-- //add-products -->
	<!-- coming soon -->
	<a href="shop.php"><div class="soon">
		<div class="container">
			<h3>Want to see more?</h3>
			<h4>SHOP NOW</h4>  
			<!--<div id="countdown1" class="ClassyCountdownDemo"></div>-->
		</div> 
	</div>
	</a>
	<!-- //coming soon -->
	<!-- deals -->
	<div class="deals"> 
		<div class="container"> 
			<h3 class="w3ls-title">SHOP CATEGORIES </h3>
			<div class="deals-row">
				<div class="col-md-3 focus-grid"> 
					<a href="shop.php?category=phones" class="wthree-btn"> 
						<div class="focus-image"><i class="fa fa-mobile"></i></div>
						<h4 class="clrchg">Phones</h4> 
					</a>
				</div>
				<div class="col-md-3 focus-grid"> 
					<a href="shop.php?category=tablets" class="wthree-btn wthree2"> 
						<div class="focus-image"><i class="fa fa-tablet"></i></div>
						<h4 class="clrchg">Tablets</h4>
					</a>
				</div> 
				<div class="col-md-3 focus-grid"> 
					<a href="shop.php?category=cameras" class="wthree-btn wthree1"> 
						<div class="focus-image"><i class="fa fa-camera"></i></div>
						<h4 class="clrchg">Cameras</h4> 
					</a>
				</div> 
				<div class="col-md-3 focus-grid"> 
					<a href="shop.php?category=laptops" class="wthree-btn wthree2"> 
						<div class="focus-image"><i class="fa fa-laptop"></i></div>
						<h4 class="clrchg">Laptops</h4>
					</a>
				</div> 
				<div class="col-md-3 focus-grid"> 
					<a href="shop.php?category=tvs" class="wthree-btn wthree3"> 
						<div class="focus-image"><i class="fa fa-desktop"></i></div>
						<h4 class="clrchg">TVs</h4>
					</a>
				</div> 
				<!--
				<div class="col-md-2 focus-grid w3focus-grid-mdl"> 
					<a href="products9.html" class="wthree-btn wthree3"> 
						<div class="focus-image"><i class="fa fa-book"></i></div>
						<h4 class="clrchg">Books & Music</h4> 
					</a>
				</div>
				<div class="col-md-2 focus-grid w3focus-grid-mdl"> 
					<a href="products1.html" class="wthree-btn wthree4"> 
						<div class="focus-image"><i class="fa fa-asterisk"></i></div>
						<h4 class="clrchg">Fashion</h4>
					</a>
				</div>
				<div class="col-md-2 focus-grid w3focus-grid-mdl"> 
					<a href="products2.html" class="wthree-btn wthree2"> 
						<div class="focus-image"><i class="fa fa-gamepad"></i></div>
						<h4 class="clrchg">Kids</h4>
					</a>
				</div> 
				<div class="col-md-2 focus-grid w3focus-grid-mdl"> 
					<a href="products5.html" class="wthree-btn wthree"> 
						<div class="focus-image"><i class="fa fa-shopping-basket"></i></div>
						<h4 class="clrchg">Groceries</h4>
					</a>
				</div> 
				<div class="col-md-2 focus-grid w3focus-grid-mdl"> 
					<a href="products7.html" class="wthree-btn wthree5"> 
						<div class="focus-image"><i class="fa fa-medkit"></i></div>
						<h4 class="clrchg">Health</h4> 
					</a>
				</div> 
				<div class="col-md-2 focus-grid w3focus-grid-mdl"> 
					<a href="products8.html" class="wthree-btn wthree1"> 
						<div class="focus-image"><i class="fa fa-car"></i></div>
						<h4 class="clrchg">Automotive</h4> 
					</a>
				</div>-->
				<div class="col-md-3 focus-grid"> 
					<a href="shop.php?category=home-theatres" class="wthree-btn wthree1"> 
						<div class="focus-image"><i class="fa fa-book"></i></div>
						<h4 class="clrchg">Home Theatres</h4> 
					</a>
				</div>
				<div class="col-md-3 focus-grid"> 
					<a href="shop.php?category=accessories" class="wthree-btn wthree5"> 
						<div class="focus-image"><i class="fa fa-pencil"></i></div>
						<h4 class="clrchg">Accessories</h4> 
					</a>
				</div> 
				<!--
				<div class="col-md-3 focus-grid"> 
					<a href="products2.html" class="wthree-btn wthree3"> 
						<div class="focus-image"><i class="fa fa-gamepad"></i></div>
						<h4 class="clrchg">Games & Toys</h4> 
					</a>
				</div> 
				<div class="col-md-3 focus-grid"> 
					<a href="products6.html" class="wthree-btn "> 
						<div class="focus-image"><i class="fa fa-gift"></i></div>
						<h4 class="clrchg">Gifts</h4> 
					</a>
				</div> 
				-->
				<div class="clearfix"> </div>
			</div>  	
		</div>  	
	</div> 
	<!-- //deals --> 


	<?php include 'footer.php' ?>
	