<?php

require('connect.inc.php');

if(isset($_GET['productName'])){
$productName=$_GET['productName'];
}
if(isset($_GET['productPrice'])){
$productPrice=$_GET['productPrice'];
}
if(isset($_GET['productId'])){
$productId=$_GET['productId'];
}
if(isset($_GET['productHighlights'])){

$productHighlights=nl2br(str_replace('-', '', $_GET['productHighlights']));
}
if(isset($_GET['productProfit'])){
$productProfit=$_GET['productProfit'];
}
if(isset($_GET['productCategory'])){
$productCategory=$_GET['productCategory'];
}
if(isset($_GET['productBrand'])){
$productBrand=$_GET['productBrand'];
}
if(isset($_GET['productStatus'])){
$productStatus=$_GET['productStatus'];
}
if(isset($_GET['productFeatured'])){
$productFeatured=$_GET['productFeatured'];
}


$sql="INSERT INTO `products` VALUES('$productId','$productName','','','$productPrice','$productHighlights','$productProfit','$productCategory','$productBrand','$productStatus','$productFeatured','','',1)";

if($connect->query($sql)){
	echo 'success';
}
else{
		if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
}
}





?>