<?php 

session_start();

$product_id=$_GET['id'];
$product_quantity=1;

$cart_product=[$product_id,$product_quantity];

if (isset($_SESSION['cart_products'])){

	$_SESSION['cart_products'][$product_id]=$product_quantity;

}else{

	$_SESSION['cart_products'][$product_id]=$product_quantity;
	
}





?>