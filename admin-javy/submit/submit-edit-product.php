<?php

include '../core.php';
require '../connect.inc.php';

if(isset($_GET['name'])){
	$product_name=addslashes($_GET['name']);
	$product_name=str_replace('"', "'", $product_name);
}
if(isset($_GET['price'])){
	$product_price=$_GET['price'];
}
if(isset($_GET['profit'])){
	$product_profit=$_GET['profit'];
}
if(isset($_GET['cost'])){
	$product_cost=$_GET['cost'];
}
if(isset($_GET['link'])){
	$product_link=$_GET['link'];
}
//submit get does not work with description

if(isset($_GET['approval'])){
	$approval=$_GET['approval'];
}
if(isset($_GET['editCategoryName'])){
	$category=$_GET['editCategoryName'];
}
if(isset($_GET['productStatus'])){
	$status=$_GET['productStatus'];
}
if(isset($_GET['editBrandName'])){
	$brand=$_GET['editBrandName'];
}
if(isset($_GET['id'])){
	$product_id=$_GET['id'];
}
if(isset($_GET['supplier_id'])){
	$supplier_id=$_GET['supplier_id'];
}
if(isset($_GET['javytech_id'])){
	$javytech_id=$_GET['javytech_id'];
}
if(isset($_GET['product_image'])){
	$product_image=$_GET['product_image'];
}
if(isset($_GET['variable'])){
	if($_GET['variable']=='set_variable'){
		$product_variable=1;
	};
}else{
	$product_variable=0;
}
if(isset($_GET['delivery'])){
	if($_GET['delivery']=='set_delivery'){
		$product_delivery=1;
	};
}else{
	$product_delivery=0;
}
if(isset($_GET['featured'])){
	if($_GET['featured']=='set_featured'){
		$product_featured=1;
	};
}else{
	$product_featured=0;
}


if(isset($_GET['highlights'])){
	$product_highlights=nl2br($_GET['highlights']);
	$product_highlights=addslashes($product_highlights);



$sql="UPDATE `products` SET name='$product_name',price='$product_price',highlights='$product_highlights',featured='$product_featured',variable='$product_variable',delivery='$product_delivery',status='$status',category='$category',brand='$brand',profit='$product_profit',link='$product_link',javytech_id='$javytech_id',supplier_id='$supplier_id',cost='$product_cost',approval='$approval',image='$product_image' WHERE id=$product_id";

if($connect->query($sql)){



    $valid['success'] = true;
    $valid['messages'] = "Product Succesfully edited";        

}
else{
        if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        $valid['success'] = false;
        $valid['messages'] = "Error No - ".$e->getCode(). " - ". $e->getMessage()."<br/>".nl2br($e->getTraceAsString()); 
    }
}
}

   echo json_encode($valid);



}


?>