<?php

include '../core.php';
require '../connect.inc.php';


if(isset($_GET['id'])){
	$id=$_GET['id'];
}
if(isset($_GET['name'])){
	$name=$_GET['name'];
}
if(isset($_GET['phone'])){
	$phone=$_GET['phone'];
}
if(isset($_GET['email'])){
	$email=$_GET['email'];
}
if(isset($_GET['deliverydetails'])){
	$deliverydetails=$_GET['deliverydetails'];
}


if(isset($_GET['dealerid'])){
	$dealerid=$_GET['dealerid'];



$sql="UPDATE `customers` SET name='$name',email='$email',phone='$phone',deliverydetails='$deliverydetails',dealerid='$dealerid' WHERE id=$id";

if($connect->query($sql)){
    $valid['success'] = true;
    $valid['messages'] = "Customer Succesfully Edited";        
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