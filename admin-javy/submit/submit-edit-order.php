<?php

include '../core.php';
require '../connect.inc.php';


if(isset($_GET['deal_id'])){
	$deal_id=$_GET['deal_id'];
}
if(isset($_GET['name'])){
	$customer_name=addslashes($_GET['name']);
}
if(isset($_GET['phone'])){
	$customer_phone=addslashes($_GET['phone']);
}
if(isset($_GET['email'])){
	$customer_email=addslashes($_GET['email']);
}
if(isset($_GET['delivery_details'])){
	$delivery_details=addslashes($_GET['delivery_details']);
}
if(isset($_GET['product_price'])){
	$product_price=$_GET['product_price'];
}
if(isset($_GET['product_id'])){
	$product_id=$_GET['product_id'];
}
if(isset($_GET['supplier_id'])){
	$supplier_id=$_GET['supplier_id'];
}
if(isset($_GET['product_name'])){
	$product_name=$_GET['product_name'];
}
if(isset($_GET['product_profit'])){
	$product_profit=$_GET['product_profit'];
}
if(isset($_GET['cost'])){
	$cost=$_GET['cost'];
}
if(isset($_GET['notes'])){
	$notes=addslashes($_GET['notes']);
}



if(isset($_GET['status'])){
	$status=$_GET['status'];



$sql="UPDATE `deals` SET name='$customer_name',email='$customer_email',phone='$customer_phone',delivery_details='$delivery_details',notes='$notes',product_price='$product_price',product_profit='$product_profit', cost='$cost',status=$status,product_name='$product_name',product_id='$product_id',supplier_id='$supplier_id' WHERE id=$deal_id";

if($connect->query($sql)){



    $valid['success'] = true;
    $valid['messages'] = "Order Succesfully edited";        

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