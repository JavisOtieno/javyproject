<?php

include 'core.php';
require 'connect.inc.php';

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM product_messages WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

	echo '<br>';
	echo '<form method="GET" action="submit-order-from-message.php">';

	echo '<div style="margin-top:10px"><label>Customer Name:</label><br/></div>';
	echo '<div><input name="name" value="'.$row['name'].'"></input></div>';

	echo '<div style="margin-top:10px"><label>Customer Phone:</label><br/>';
	echo '<input name="phone" value="'.$row['phone'].'"></input></div>';

	echo '<div style="margin-top:10px"><label>Customer Email:</label><br/></div>';
	echo '<div><input name="email" value="'.$row['email'].'"></input></div>';

	$customer_id=$row['customer_id'];
$query_customer='SELECT * FROM customers WHERE id='.$customer_id.'';
$query_run_customer=mysqli_query($db_link,$query_customer);
if($row_customer=mysqli_fetch_assoc($query_run_customer)){
	$customer_address=$row_customer['deliverydetails'];
	}

	echo '<div style="margin-top:10px"><label>Address:</label><br/></div>';
	echo '<div><input name="address" value="'.$customer_address.'"></input></div>';

	// echo '<div style="margin-top:10px"><label>Product Name:</label><br/></div>';
	// echo '<div><input name="product_name" value="'.$row['product_name'].'" readonly></input></div>';

	// echo '<div style="margin-top:10px"><label>Product Price:</label><br/></div>';
	// echo '<div><input name="product_price" value="'.$row['product_price'].'" ></input></div>';

	// echo '<div style="margin-top:10px"><label>Product Profit:</label><br/></div>';
	// echo '<div><input name="product_profit" value="'.$row['product_profit'].'" ></input></div>';
$product_id=$row['product_id'];

$query_product='SELECT * FROM products WHERE id='.$product_id.'';
$query_run_product=mysqli_query($db_link,$query_product);
if($row_product=mysqli_fetch_assoc($query_run_product)){
	$supplier_id=$row_product['supplier_id'];
	$product_price=$row_product['price'];
	$product_profit=$row_product['profit'];
	$product_name=$row_product['name'];
	}

	echo '<div style="margin-top:10px"><label>Product Name:</label><br/>';
	echo '<input name="product_name" value="'.$product_name.'"></input></div>';

	echo '<div style="margin-top:10px"><label>Product Price:</label><br/>';
	echo '<input name="product_price" value="'.$product_price.'"></input></div>';

	echo '<div style="margin-top:10px"><label>Product Profit:</label><br/>';
	echo '<input name="product_profit" value="'.$product_profit.'"></input></div>';

	echo '<div style="margin-top:10px"><label>Product Id:</label><br/>';
	echo '<input name="product_id" value="'.$product_id.'" readonly></input></div>';
	
	echo '<div style="margin-top:10px"><label>Supplier Id:</label><br/>';
	echo '<input name="supplier_id" value="'.$supplier_id.'" readonly></input></div>';
	// echo '<div style="margin-top:10px"><label>Supplier Id:</label><br/>';
	// echo '<input name="supplier_id" value="'.$row['supplier_id'].'" readonly></input></div>';


	echo '<div style="margin-top:10px"><label>Customer Id:</label><br/>';
	echo '<input name="customer_id" value="'.$row['customer_id'].'" readonly></input></div>';

	echo '<div style="margin-top:10px"><label>Dealer Id:</label><br/>';
	echo '<input name="dealer_id" value="'.$row['dealer_id'].'" readonly></input></div>';

	

	echo '<div style="margin-top:10px"><label>Status:</label><br/></div>';
	//echo '<div><input name="status" value="'.$row['status'].'"></input></div>';

	if($row['status']==0){
	$selected0='selected';	
	}else{
		$selected0='';
	}

	if($row['status']==1){
	$selected1='selected';	
	}else{
		$selected1='';
	}

	if($row['status']==2){
	$selected2='selected';	
	}else{
		$selected2='';
	}


	echo '<div><select name="status">
  <option value="0" '.$selected0.' >Processing</option>
  <option value="1" '.$selected1.'>Complete</option>
  <option value="2" '.$selected2.'>Cancelled</option>
</select></div>';

	







	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    cursor: pointer;" type="submit" value="CONVERT"></form>';




}

?>