<?php

include '../core.php';
require '../connect.inc.php';

$date = time();	

if(isset($_GET['deal_id'])){
	$deal_id=$_GET['deal_id'];
}
if(isset($_GET['name'])){
	$customer_name=$_GET['name'];
}
if(isset($_GET['phone'])){
	$customer_phone=$_GET['phone'];
}
if(isset($_GET['email'])){
	$customer_email=$_GET['email'];
}
if(isset($_GET['address'])){
	$customer_address=$_GET['address'];
}
if(isset($_GET['product_name'])){
	$product_name=$_GET['product_name'];
}
if(isset($_GET['product_price'])){
	$product_price=$_GET['product_price'];
}
if(isset($_GET['product_profit'])){
	$product_profit=$_GET['product_profit'];
}
if(isset($_GET['product_id'])){
	$product_id=$_GET['product_id'];
}
if(isset($_GET['supplier_id'])){
	$product_id=$_GET['supplier_id'];
}
if(isset($_GET['dealer_id'])){
	$dealer_id=$_GET['dealer_id'];
}
if(isset($_GET['customer_id'])){
	$customer_id=$_GET['customer_id'];
}
if(isset($_GET['supplier_id'])){
	$supplier_id=$_GET['supplier_id'];
}



if(isset($_GET['status'])){
	$status=$_GET['status'];



$sql="INSERT INTO `deals` VALUES (NULL,'$customer_name','$customer_phone','$customer_email','$customer_address','','$product_name',$product_price,$product_profit,0,$product_id,$dealer_id,$customer_id,$supplier_id,2,'$date',$status)";



if($connect->query($sql)){

    $valid['success'] = true;
    $valid['messages'] = "Order Succesfully Converted";        

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