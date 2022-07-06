<?php 

session_start();

$product_id=$_GET['id'];

if (isset($_SESSION['cart_products'])){
	unset($_SESSION['cart_products'][$product_id]);
}

header('location: cart.php');


?>