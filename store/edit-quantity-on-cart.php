<?php

session_start();

$product_id=$_GET['id'];

$action=$_GET['action'];

if($action=='add'){
	$_SESSION['cart_products'][$product_id]['quantity']=$_SESSION['cart_products'][$product_id]['quantity']+1;
}else if ($action=='minus'){
	$_SESSION['cart_products'][$product_id]['quantity']=$_SESSION['cart_products'][$product_id]['quantity']-1;
}
