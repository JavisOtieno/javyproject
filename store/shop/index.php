<?php include 'header.php'; ?>
	<link href="css/owl.carousel.css" rel="stylesheet" type="text/css" media="all"> <!-- carousel slider --> 
	<link href="css/animate.min.css" rel="stylesheet" type="text/css" media="all" />  
	<link href='//fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'>		
	<!-- web-fonts --> 		
	<!-- scroll to fixed--> 		
	


		


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
	}

	if(isset($_GET['supplier'])){
		$supplier=$_GET['supplier'];
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

		




	?> 

	<!-- products -->
	<div class="products">	 
		<div class="container">
			<div class="col-md-9 product-w3ls-right ">
				<!-- breadcrumbs --> 
				<ol class="breadcrumb breadcrumb1">
					<li><a href="index.php">Home</a></li>
					<li class="active">Products</li>
				</ol> 
				<div class="clearfix"> </div>
				<!-- //breadcrumbs -->
				<h4>
								
							</h4>
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
								echo '<li><a href="index.php?category='.$category.'">All '.ucfirst($category).'</a></li>';

							foreach ($category_array[$category] as $brand_on_brands) {
							 echo '<li><a href="index.php?category='.$category.'&brand='.$brand_on_brands.'">'.ucfirst($brand_on_brands).'</a></li>';
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


			if($products_type==0){

			if(isset($_GET['category'])&&isset($_GET['brand'])){
			$query='SELECT * FROM `products` WHERE category="'.$category.'" AND (supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND brand="'.$brand.'" AND status="1" ORDER BY price';
			}
			else if(isset($_GET['category'])&&!isset($_GET['brand'])){
				$query='SELECT * FROM `products` WHERE category="'.$category.'" AND (supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" ORDER BY price';
			}
			else{
				$query='SELECT * FROM `products` WHERE status="1" AND (supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) ORDER BY category,brand,price';
			}

		}else{

			if (isset($_GET['category'])&&isset($_GET['brand'])){
			$query='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category.'" AND brand="'.$brand.'" ORDER BY price';
			}
			else if(isset($_GET['category'])&&!isset($_GET['brand'])){
				$query='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category.'" ORDER BY price';
			}
			else{
				$query='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" ORDER BY category,brand,price';
			}

		}

			

			//pagination start
			$result=$connect->query($query);
			$count_rows=$result->num_rows;
			$pages=ceil($count_rows/20);
			//pagination continued at the bottom

			$query=$query.' LIMIT '.$page1.',20';
			//echo $query;
			$query_run=mysqli_query($db_link,$query);
			$count=1;

			if(mysqli_num_rows($query_run)==0){

				echo "<h2 style='text-align:center; margin:30px;'>No products at the moment.</h2>";
			}

			
			while($row=mysqli_fetch_assoc($query_run)){

				if($row['image']==''){
					$image_uri='https://promote.javy.co.ke/assests/images/product-images/picture-coming-soon.jpg';
				}else{
					$image_uri=str_replace("..", "https://promote.javy.co.ke", $row['image']);
				}

				if ($supplier!=$row['supplier_id']){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier AND product_id=".$row['id'];
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
					if($row2=mysqli_fetch_assoc($query_run_more_suppliers)){
						if($row2['price']!=0){
							$price=$row2['price'];
						}else{
							$price=$row['price'];
						}
					}else{
						$price=$row['price'];
					}
				}else{
					$price=$row['price'];
				}
				
				showProduct($image_uri,$row['name'],$price,$row['slug'],$count);
				
				
				$count++;
				
				
				
			}

						function showProduct($image,$name,$price,$slug,$count)
			{
			

				echo '	<div class="col-md-3 product-grids" > 
						<div class="agile-products" >
							
							<a href="product.php?p='.$slug.'"><img src="'.$image.'" class="img-responsive img-match-height" style="height: 100%; width: 100%; object-fit: contain" alt="img"></a>
							<div class="agile-product-text">   
							<div id="link'.$count.'">           
								<h5><a href="product.php?p='.$slug.'">'.$name.'</a></h5>
								</div> 
								<h6>KSh. '.number_format($price).'</h6> 
								<!--<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Audio speaker" /> 
									<input type="hidden" name="amount" value="100.00" /> 
									<button type="submit" class="w3ls-cart pw3ls-cart"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form> -->
								<a href="product.php?p='.$slug.'"><button class="w3ls-cart pw3ls-cart" ><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
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



<a href="index.php<?php if(isset($category)){echo '?category='.$category;} if(isset($_GET['brand'])){echo '&brand='.$brand; }?><?php if(isset($category)){echo '&page=';}else {echo '?page=';} ?><?php echo $page-1;  ?>" <?php if($page==1){ echo 'style="display: none;"';} ?>>&laquo; Previous</a>

		<?php
		for($b=1;$b<=$pages;$b++){

			
			?><a href="index.php<?php if(isset($category)){echo '?category='.$category;} if(isset($_GET['brand'])){echo '&brand='.$brand; } ?><?php if(isset($category)){echo '&page=';}else {echo '?page=';} ?><?php echo $b; ?>" <?php if ($page==$b){echo 'class="active"';}?> ><?php echo $b; ?></a><?php
				
			}

			?>
  
 
  <a href="index.php<?php if(isset($category)){echo '?category='.$category;} if(isset($_GET['brand'])){echo '&brand='.$brand; } ?><?php if(isset($category)){echo '&page=';}else {echo '?page=';} ?><?php echo $page+1;  ?>" <?php if($page==$pages){ echo 'style="display: none;"';} ?>>&raquo; Next</a>
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


			$sql_categories="SELECT * FROM categories";
									

							$query_run_categories=$connect->query($sql_categories);
							$categories_and_brands=[];
							while($row=mysqli_fetch_assoc($query_run_categories)){
								$category_name=$row['categories_name'];
								$category_slug=$row['categories_slug'];
								$category_id=$row['categories_id'];

								if($products_type==0){
									$query_check_category='SELECT * FROM `products` WHERE 
									(supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'"';
								}else{
									$query_check_category='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'"';
								}
								//check if the category has products approved by Javy and Promoter
								//echo 'products '.$products_type;
								//echo $query_check_category;
								
								$query_run_check_categories=$connect->query($query_check_category);
								$products_in_category=mysqli_num_rows ($query_run_check_categories);
								//check if the category has products approved by Javy and Promoter
								//check complete
								if($products_in_category){


											 echo '<li class="item1"><a href="#">'.ucfirst($category_name).'<span class="glyphicon glyphicon-menu-down"></span></a>
								<ul>
									<li class="subitem1"><a href="index.php?category='.$category_slug.'">All '.ucfirst($category_name).'</a></li>';		


									$sql_brands="SELECT * FROM brands WHERE brand_category='$category_id' ORDER BY brand_name";
								$query_run_brands=$connect->query($sql_brands);
								while ($row=mysqli_fetch_assoc($query_run_brands)){
									$brand_name=$row['brand_name'];
									$brand_slug=$row['brand_slug'];
									$brand_id=$row['brand_id'];


								if($products_type==0){
									$query_check_brand='SELECT * FROM `products` WHERE 
									(supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.'))  AND status="1" AND brand="'.$brand_slug.'"';
								}else{
									$query_check_brand='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND brand="'.$brand_slug.'"';
								}

								
								$query_run_check_brands=$connect->query($query_check_brand);
								$products_in_brand=mysqli_num_rows ($query_run_check_brands);
								//check if the brand has products approved by Javy and Promoter
								//check complete
								if($products_in_brand){

									echo '<li class="subitem1"><a href="index.php?category='.$category_slug.'&brand='.$brand_slug.'">'.ucfirst($brand_name).'</a></li>';
								}
									
								}


								if($products_type==0){
									$query_check_other='SELECT * FROM `products` WHERE 
									(supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'" AND brand="other"';
								}else{
									$query_check_other='SELECT * FROM `products` WHERE (approval="2" OR supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) AND status="1" AND category="'.$category_slug.'" AND brand="other"';
								}
								
								$query_run_check_other=$connect->query($query_check_other);
								$products_in_other=mysqli_num_rows ($query_run_check_other);
								//check if the brand has products approved by Javy and Promoter
								//check complete
								if($products_in_other){
									echo '<li class="subitem1"><a href="index.php?category='.$category_slug.'&brand=other">Other</a></li>';
								}

								 echo '</ul>
							</li>';
							}

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
						<li><a href="shop.php?category=phones&brand=tecno">Tecno Phones </a></li>
						<li><a href="shop.php?category=cameras&brand=nikon">Nikon Cameras</a></li>
						<li><a href="product.php?id=316">Huawei Y7 Prime 2018</a></li>
						<li><a href="shop.php?category=laptops">Laptops </a></li>
						<li><a href="shop.php?category=tvs&brand=samsung">Samsung TVs</a></li>
						<li><a href="product.php?id=553">Tecno Spark K7</a></li>
					</ul>
				</div>-->

				<?php 

				//get single product
				$query='SELECT * FROM `products` WHERE  ( status="1" OR status="2" )  AND (supplier_id='.$supplier.' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='.$supplier.')) ORDER BY category,brand,price LIMIT 1';
								$query_run=mysqli_query($db_link,$query);
								$count=1;
								
								if($row=mysqli_fetch_assoc($query_run)){

				if($row['image']==''){
					$image_uri='https://promote.javy.co.ke/assests/images/product-images/picture-coming-soon.jpg';
				}else{
					$image_uri=str_replace("..", "https://promote.javy.co.ke/", $row['image']);
				}
					

				if ($supplier!=$row['supplier_id']){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier AND product_id=".$row['id'];
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
					if($row2=mysqli_fetch_assoc($query_run_more_suppliers)){
						if($row2['price']!=0){
							$price=$row2['price'];
						}else{
							$price=$row['price'];
						}
					}
					else{
							$price=$row['price'];
						}
				}else{
					$price=$row['price'];
				}
								
									
									$price='KSh. '.number_format($price);
									$id=$row['id'];
									$slug=$row['slug'];
									$name=$row['name'];



									echo '<div class="related-row">
					<h4>YOU MAY ALSO LIKE</h4>
					<div class="galry-like">  
						<a href="product.php?p='.$slug.'"><img src="'.$image_uri.'" class="img-responsive" alt="img"></a>             
						<h4><a href="product.php?p='.$slug.'">.'.$name.'</a></h4> 
						<h5>'.$price.'</h5>       
					</div>
				</div>';

								}
									
							
				?>
				
			</div>
			<div class="clearfix"> </div>
			<!-- recommendations -->
			<!--
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
					<div class="item">
						<div class="glry-w3agile-grids agileits">
							<div class="new-tag"><h6>20% <br> Off</h6></div>
							<a href="products1.html"><img src="images/f2.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products1.html">Women Sandal</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$20</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Women Sandal" /> 
									<input type="hidden" name="amount" value="20.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>        
						</div> 
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<a href="products.html"><img src="images/e4.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products.html">Digital Camera</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$80</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Digital Camera"/> 
									<input type="hidden" name="amount" value="100.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>         
						</div>  
					</div>  
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<div class="new-tag"><h6>New</h6></div>
							<a href="products4.html"><img src="images/s1.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products4.html">Roller Skates</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$180</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Roller Skates"/> 
									<input type="hidden" name="amount" value="180.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>         
						</div>  
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<a href="products1.html"><img src="images/f1.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products1.html">T Shirt</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$10</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="T Shirt" /> 
									<input type="hidden" name="amount" value="10.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>        
						</div>    
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<div class="new-tag"><h6>New</h6></div>
							<a href="products6.html"><img src="images/p1.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products6.html">Coffee Mug</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$14</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Coffee Mug" /> 
									<input type="hidden" name="amount" value="14.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>         
						</div>  
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<div class="new-tag"><h6>20% <br> Off</h6></div>
							<a href="products6.html"><img src="images/p2.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">              
								<h4><a href="products6.html">Teddy bear</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$20</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Teddy bear" /> 
									<input type="hidden" name="amount" value="20.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>        
						</div> 
					</div>
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<a href="products4.html"><img src="images/s2.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products4.html">Football</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$70</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Football"/> 
									<input type="hidden" name="amount" value="70.00"/>
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>        
						</div> 
					</div> 
					<div class="item">
						<div class="glry-w3agile-grids agileits"> 
							<div class="new-tag"><h6>Sale</h6></div>
							<a href="products3.html"><img src="images/h1.png" alt="img"></a>
							<div class="view-caption agileits-w3layouts">           
								<h4><a href="products3.html">Wall Clock</a></h4>
								<p>Lorem ipsum dolor sit amet consectetur</p>
								<h5>$80</h5>
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart" />
									<input type="hidden" name="add" value="1" /> 
									<input type="hidden" name="w3ls_item" value="Wall Clock" /> 
									<input type="hidden" name="amount" value="80.00" /> 
									<button type="submit" class="w3ls-cart" ><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
								</form>
							</div>         
						</div>  
					</div> 
				</div>    
			</div>-->
			<div class="recommend">
				<!--<h3 class="w3ls-title">Our Recommendations </h3> -->
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

					/*
			
			if(isset($category)){
				$query='SELECT * FROM `products` WHERE featured="1" AND category="'.$category.'"';
			}
			else{
				$query='SELECT * FROM `products` WHERE featured="1"';
			}
			
			$query_run=mysqli_query($db_link,$query);
			$count=1;
			
			while($row=mysqli_fetch_assoc($query_run)){
			
				$image_uri=str_replace("..", "https://javy.co.ke/", $row['image']);
				$price='KSh. '.number_format($row['price']);
				$id=$row['id'];
				$name=$row['name'];
				$category=$row['category'];
				$brand=$row['brand'];

				showProduct2($image_uri,$name,$price,$id,$category,$brand);
				
			}

			function showProduct2($image,$name,$price,$id,$category,$brand)
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

									*/
			
			
			
			
			
			?>
										
											
											
											
											       
											
												
			<!-- //recommendations -->
		</div>
	</div>
	</div>
	</div>
	<!--//products-->  

<?php include 'footer.php'; ?>

<script src="js/jquery-scrolltofixed-min.js" type="text/javascript"></script>
	<!-- the jScrollPane script -->				};
	<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>	

	<script type="text/javascript" id="sourcecode">				
		$(function()				
		{			
			$('.scroll-pane').jScrollPane();		
		});			<!-- //smooth-scrolling-of-move-up -->
	</script>		
	<!-- //the jScrollPane script -->		
	<script type="text/javascript" src="js/jquery.mousewheel.js"></script>	

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


		matchHeight('#link1','#link2','#link3','#link4');
		matchHeight('#link5','#link6','#link7','#link8');
		matchHeight('#link9','#link10','#link11','#link12');
		matchHeight('#link13','#link14','#link15','#link16');
		matchHeight('#link17','#link18','#link19','#link20');

		var cw = $('.img-match-height').width();
		$('.img-match-height').css({'height':cw+'px'});


		});			<!-- //smooth-scrolling-of-move-up -->
	</script>


