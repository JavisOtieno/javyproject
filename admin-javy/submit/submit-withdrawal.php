<?php

include '../core.php';
require '../connect.inc.php';

	$date=time();

if(isset($_GET['user_id'])){
	$user_id=$_GET['user_id'];
}


if(isset($_GET['amount'])){
	$amount=$_GET['amount'];
}
if(isset($_GET['method'])){
	$method=$_GET['method'];
}
if(isset($_GET['date'])){
	$date=$_GET['date'];
}
if(isset($_GET['status'])){
	$status=$_GET['status'];
}
/*

if(isset($_GET['phone'])){
	$customer_phone=$_GET['phone'];
}

*/

	if(isset($_GET['status'])){
	$status=$_GET['status'];

$sql="INSERT INTO `withdrawals` VALUES(NULL,$user_id,$amount,'$method','$date',$status)";

if($connect->query($sql)){



    $valid['success'] = true;
    $valid['messages'] = "Withdrawal Successfully Added";        

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