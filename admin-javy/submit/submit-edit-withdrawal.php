<?php

include '../core.php';
require '../connect.inc.php';



if(isset($_GET['withdrawal_id'])){
	$withdrawal_id=$_GET['withdrawal_id'];
}

if(isset($_GET['amount'])){
    $amount=$_GET['amount'];
}


/*

if(isset($_GET['phone'])){
	$customer_phone=$_GET['phone'];
}

*/

	if(isset($_GET['status'])){
	$status=$_GET['status'];

$sql="UPDATE `withdrawals` SET status=$status,amount=$amount WHERE withdrawal_id=$withdrawal_id";

if($connect->query($sql)){
    $valid['success'] = true;
    $valid['messages'] = "Withdrawal Succesfully Edited";        
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