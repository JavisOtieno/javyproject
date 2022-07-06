<?php include 'header.php'; ?>

<?php


require 'connect.inc.php';

$query='SELECT * FROM suppliers ORDER BY id DESC';

$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

echo "Number of Suppliers:  ".$rows;

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr>
<th>ID</th>
<th>Username</th>
<th>Name</th>
<th>Phone</th>
<th>Registered On</th>
<th>View/Edit</th>
<th>Delete</th>
<th>All Products</th>
<th>Active Products</th>
<th><strong>Products Sold</strong></th>
<th><strong>Login</strong></th>
<th><strong>Pay</strong></th>
<th><strong>Authorization</strong></th>
<th><strong>Website</strong></th>
</tr></thead><tbody>';


while($row=mysqli_fetch_assoc($query_run)){

	$userId=$row['id'];

	$sqlsales= "SELECT * FROM deals WHERE status=1 AND supplier_id=$userId";
$query_run2=mysqli_query($db_link,$sqlsales);
$sales=mysqli_num_rows($query_run2);


$sqlActiveProducts="SELECT * FROM products WHERE supplier_id='$userId' AND (status=0 OR status=1)";
$query_run3=mysqli_query($db_link,$sqlActiveProducts);
$numberOfActiveProducts=mysqli_num_rows($query_run3);

$sqlAllProducts="SELECT * FROM products WHERE supplier_id='$userId'";
$query_run4=mysqli_query($db_link,$sqlAllProducts);
$numberOfAllProducts=mysqli_num_rows($query_run4);


if($row['authorized']==1){
	$status="authorized";
}else{
	$status="NOT AUTHORIZED";
}


echo '<tr>
<td>'.$row['id'].'</td>
<td>'.$row['username'].'</td>
<td>'.$row['name'].'</td>
<td>'.$row['phone'].'</td>
<td>'.$row['registered_on'].'</td>
<td><a href="edit/edit-supplier.php?id='.$row['id'].'"><button>view/edit</button></a></td>
<td><a href="delete/delete-supplier.php?id='.$row['id'].'"><button>delete</button></a></td>
<td>'.$numberOfAllProducts.'</td>
<td>'.$numberOfActiveProducts.'</td>
<td>'.$sales.'</td>
<td><a href="http://supply.javy.co.ke/bypass.php?id='.$row['id'].'" target="_blank"><button>Login</button></a></td>
<td><a href="pay-supplier.php?id='.$row['id'].'"><button>Pay</button></a></td>
<td>'.$status.'</td>
<td><a href="http://www.'.$row['username'].'.av.ke" target="_blank"><button>'.$row['username'].'</button></a></td>

</tr>';


}

echo "</tbody></table></div>";

 include 'footer.php'; 

 ?>