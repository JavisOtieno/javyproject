
				<div class="row">
						<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-shopping-cart"></i> <h5>Recent Orders</h5></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<table class="table">
					<thead>
						<tr>							
							<th>#</th>
							<th>Client</th>
							<th>Product</th>
							<th style="width:15%;">Profit</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqldeals="SELECT * FROM deals ORDER BY id DESC LIMIT 5 ";
						$dealsResult=$connect->query($sqldeals);
						$count=0;

						if($dealsResult->num_rows>0){
							while($row=$dealsResult->fetch_assoc()){
								if($count==0){
									echo "<tr class='table-primary'>";
								}
								else if($count==1){
									echo '<tr class="table-secondary">';
								}
 								else if($count==2){
 									echo '<tr class="table-success">';
 								}else if($count==3){
 									echo '<tr class="table-danger">';
 								}else if($count==4){
 									echo '<tr class="table-warning">';
 								}
								else if($count==5){
									echo '<tr class="table-info">';
								}

								echo '<td>'.$row['id'].'</td>';
								echo '<td>'.$row['name'].'</td>';
								echo '<td>'.$row['product_name'].'</td>';
								echo '<td>'.$row['product_profit'].'</td>';
								echo "</tr>";

								$count++;
								
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No deals so far</td></tr>";
						}
						
						?>
					</tbody>
			</table>
			<a href="orders.php"><button style="width: 50%;margin-left:25%;" class="btn btn-info">VIEW ALL ORDERS</button></a>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->

				<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-user"></i> <h5>New Promoters</h5></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<table class="table">
					<thead>
						<tr>							
							<th>#</th>
							<th>Name</th>
							<th>Store Name</th>
							<th style="width:15%;">Website Visits</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqldeals="SELECT * FROM users ORDER BY user_id DESC LIMIT 5 ";
						$dealsResult=$connect->query($sqldeals);
						$count=0;

						if($dealsResult->num_rows>0){
							while($row=$dealsResult->fetch_assoc()){

								$customer_id=$row['user_id'];


								if($count==0){
									echo "<tr class='table-primary'>";
								}
								else if($count==1){
									echo '<tr class="table-secondary">';
								}
 								else if($count==2){
 									echo '<tr class="table-success">';
 								}else if($count==3){
 									echo '<tr class="table-danger">';
 								}else if($count==4){
 									echo '<tr class="table-warning">';
 								}
								else if($count==5){
									echo '<tr class="table-info">';
								}

								echo '<td>'.$row['user_id'].'</td>';
								echo '<td>'.$row['firstname'].' '.$row['lastname'].'</td>';
								echo '<td>'.$row['storename'].'</td>';
								echo '<td>'.$row['web_visits'].'</td>';
								echo "</tr>";
								$count++;
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No customers so far</td></tr>";
						}
						
						?>
					</tbody>
			</table>

			<a href="promoters.php"><button style="width: 50%;margin-left:25%;" class="btn btn-info">VIEW ALL PROMOTERS</button></a>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->	

		


	</div>
				<div class="col-sm-6">
					<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-ruble"></i><h5>Recent Products</h5></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<table class="table">
					<thead>
						<tr>							
							<th>Photo</th>
							<th>Product Name</th>
							<th>Product Price</th>
							<th style="width:15%;">Profit</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqlproducts="SELECT * FROM products ORDER BY id DESC LIMIT 10 ";
						$productsResult=$connect->query($sqlproducts);


						if($productsResult->num_rows>0){
							while($row=$productsResult->fetch_assoc()){
								
								
								$imageUrl = str_replace('../', 'https://promote.javy.co.ke/', $row['image']);;
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:50px; width:50px;'  />";

								echo "<tr>";
								echo "";
								echo '<td><a href="edit/edit-product.php?product_id='.$row['id'].'">'.$productImage.'</a></td>';
								echo '<td><a href="edit/edit-product.php?product_id='.$row['id'].'">'.$row['name'].'</a></td>';
								echo '<td>'.$row['price'].'</td>';
								echo '<td>'.$row['profit'].'</td>';
								
								echo "</tr>";
															}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No products so far</td></tr>";
						}
						?>
					</tbody>
			</table>
			<a href="products.php"><button style="width: 50%;margin-left:25%;" class="btn btn-info">VIEW ALL PRODUCTS</button></a>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		




					
	</div>

</div>
<div class="row">
	<div class="col-sm-6">


					<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-user"></i> <h5>New Suppliers</h5></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<table class="table">
					<thead>
						<tr>							
							<th>#</th>
							<th>Name</th>
							<th>Username</th>
							<th style="width:15%;">Name</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqldeals="SELECT * FROM suppliers ORDER BY id DESC LIMIT 5 ";
						$dealsResult=$connect->query($sqldeals);
						$count=0;

						if($dealsResult->num_rows>0){
							while($row=$dealsResult->fetch_assoc()){

								$customer_id=$row['id'];

									if(empty($row['password'])){
									$password_set="not-set";
								}else{
									$password_set="account";
								}
								if($count==0){
									echo "<tr class='table-primary'>";
								}
								else if($count==1){
									echo '<tr class="table-secondary">';
								}
 								else if($count==2){
 									echo '<tr class="table-success">';
 								}else if($count==3){
 									echo '<tr class="table-danger">';
 								}else if($count==4){
 									echo '<tr class="table-warning">';
 								}
								else if($count==5){
									echo '<tr class="table-info">';
								}
								echo '<td>'.$row['id'].'</td>';
								echo '<td>'.$row['name'].'</td>';
								echo '<td>'.$row['username'].'</td>';
								echo '<td>'.$row['authorized'].'</td>';
								
								echo "</tr>";

								$count++;
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No suppliers so far</td></tr>";
						}
						
						?>
					</tbody>
			</table>

			<a href="suppliers.php"><button style="width: 50%;margin-left:25%;" class="btn btn-info">VIEW ALL SUPPLIERS</button></a>


			</div> <!-- /panel-body -->
		</div> <!-- /panel -->	

	</div>
	<div class="col-sm-6">

					<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-user"></i> <h5>New Customers</h5></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<table class="table">
					<thead>
						<tr>							
							<th>#</th>
							<th>Name</th>
							<th>Password</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqldeals="SELECT * FROM customers ORDER BY id DESC LIMIT 5 ";
						$dealsResult=$connect->query($sqldeals);
						$count=0;

						if($dealsResult->num_rows>0){
							while($row=$dealsResult->fetch_assoc()){

								$customer_id=$row['id'];

								if(empty($row['password'])){
									$password_set="not-set";
								}else{
									$password_set="account";
								}
								if($count==0){
									echo "<tr class='table-primary'>";
								}
								else if($count==1){
									echo '<tr class="table-secondary">';
								}
 								else if($count==2){
 									echo '<tr class="table-success">';
 								}else if($count==3){
 									echo '<tr class="table-danger">';
 								}else if($count==4){
 									echo '<tr class="table-warning">';
 								}
								else if($count==5){
									echo '<tr class="table-info">';
								}
  								

							
								echo '<td>'.$row['id'].'</td>';
								echo '<td>'.$row['name'].'</td>';
								echo '<td>'.$password_set.'</td>';
								
								echo "</tr>";

								$count++;
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No suppliers so far</td></tr>";
						}
						
						?>
					</tbody>
			</table>

			<a href="customers.php"><button style="width: 50%;margin-left:25%;" class="btn btn-info">VIEW ALL CUSTOMERS</button></a>


			</div> <!-- /panel-body -->
		</div> <!-- /panel -->	
	</div>
	</div>