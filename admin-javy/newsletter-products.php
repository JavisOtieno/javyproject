<?php include 'header.php'; ?>


<?php

date_default_timezone_set("Africa/Nairobi");

require 'connect.inc.php';

$query='SELECT * FROM newsletter_products ORDER BY id DESC';

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr><th>ID</th>
<th>Placement</th>
<th>Newsletter ID</th>
<th>Product Name</th>
<th>View/Edit</th>
</tr>

</thead><tbody>';



$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){

$product_id=$row['product_id'];

$query_product_name="SELECT * FROM products WHERE id='".$product_id."'";

$query_run_product_name=mysqli_query($db_link,$query_product_name);
while($row_product=mysqli_fetch_assoc($query_run_product_name)){
	$product_name=$row_product['name'];
}


echo '<tr>
<td>'.$row['id'].'</td>
<td>'.$row['placement'].'</td>
<td>'.$row['product_id'].'</td>
<td>'.$product_name.'</td>
<td><a href="edit/edit-newsletter-product.php?id='.$row['id'].'"><button>view/edit</button></a></td>


</tr>';

}


 include 'footer.php'; ?>
