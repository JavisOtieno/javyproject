<?php


require 'connect.inc.php';

date_default_timezone_set("Africa/Nairobi");

$query="SELECT * FROM products WHERE `supplier_id` != '1'";


$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){

	$profit=($row['price']-$row['cost'])*0.6;

	$query_profit="UPDATE `products` SET profit='$profit' WHERE id = '".$row['id']."'";
	$query_run_profit=mysqli_query($db_link,$query_profit);

}

