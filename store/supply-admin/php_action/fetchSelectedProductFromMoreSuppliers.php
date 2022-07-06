<?php

require_once 'core.php';

$productId = $_POST['productId'];
//$productId=3;

$sql = "SELECT profit,cost, price FROM more_suppliers WHERE product_id = $productId AND supplier_id=$userId";
//echo $sql;
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);