<?php

include '../core.php';
require '../connect.inc.php';

	$time=time();

if(isset($_GET['orderId'])){
	$orderId=$_GET['orderId'];
}
if(isset($_GET['supplierId'])){
	$supplierId=$_GET['supplierId'];
}
if(isset($_GET['cost'])){
	$cost=$_GET['cost'];
}




/*

if(isset($_GET['phone'])){
	$customer_phone=$_GET['phone'];
}

*/

	if(isset($_GET['status'])){
	$status=$_GET['status'];

$sql="INSERT INTO `supplier_payments` VALUES(NULL,'$supplierId','$orderId','$cost','$time',$status)";


if($connect->query($sql)){

    //update cost when making a payment
    $query_update_cost="UPDATE deals SET cost=".$cost." WHERE id=".$orderId;
    $connect->query($query_update_cost);

    $valid['success'] = true;
    $valid['messages'] = "Payment Successfully Added".$query_update_cost;        

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