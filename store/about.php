<?php include 'header.php'; ?>	
	<!--  about-page -->
	<div class="about">
		<div class="container"> 
			<h3 class="w3ls-title w3ls-title1">About <?php echo ucfirst($storename);?></h3>
			<div class="about-text">	
				<p>Welcome to <?php echo ucfirst($storename);?>. <?php echo ucfirst($storename);?> is an online store that deals in products such as electronics : phones, laptops, cameras, home theatre systems, tvs, accessories and more all over Kenya. We deliver countrywide and let you pay on delivery.
					</p> 
				<div class="col-md-3 ftr-top-left about-text-grids">
					<i class="fa fa-shopping-basket" aria-hidden="true"></i>
					<h4>Variety of <br>Products</h4>
				</div>
				<div class="col-md-3 ftr-top-left about-text-grids">
					<i class="fa fa-users" aria-hidden="true"></i>
					<h4>Meeting <br> Customer needs</h4>
				</div>
				<div class="col-md-3 ftr-top-left about-text-grids">
					<i class="fa fa-credit-card" aria-hidden="true"></i>
					<h4>Flexible Payment <br>Options</h4>
				</div>
				<div class="col-md-3 ftr-top-left about-text-grids">
					<i class="fa fa-truck" aria-hidden="true"></i>
					<h4>Countrywide <br>Delivery</h4>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="history">
				<h3 class="w3ls-title">Our History and Mission</h3>

				<p><?php echo ucfirst($storename);?> was launched in 2018.</p>
				<p><?php echo ucfirst($storename);?> is a store that is dedicated to offering customers with the best products at affordable prices. We know that most of our customers want convenience and thats why we seek to deliver our products countrywide as fast as possible. We currently deliver on the next day for places outside <?php if($storename=='phoneplacekisumu'){ echo 'Kisumu'; }else{ echo 'Nairobi'; }?> and on the same day within <?php if($storename=='phoneplacekisumu'){ echo 'Kisumu'; }else{ echo 'Nairobi'; }?>.</p> 
				
			</div>
		</div>
	</div>
	<!-- //about-page --> 
	
	<?php include 'footer.php'; ?>