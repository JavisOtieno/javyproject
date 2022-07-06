
				<div class="row">
						
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
							<th style="width:15%;">Price</th>
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
								echo '<td>'.$row['product_price'].'</td>';
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
	</div>

</div>
