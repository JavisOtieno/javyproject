<?php

include '../core.php';
require '../connect.inc.php';


if(isset($_GET['message_id'])){
	$message_id=$_GET['message_id'];
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
if(isset($_GET['message'])){
	$message=$_GET['message'];
}
if(isset($_GET['notes'])){
    $notes=$_GET['notes'];
}


if(isset($_GET['status'])){
	$status=$_GET['status'];



$sql="UPDATE `customer_contact_forms` SET name='$customer_name',email='$customer_email',phone='$customer_phone',message='$message',status=$status,notes='$notes' WHERE id=$message_id";

if($connect->query($sql)){
    $valid['success'] = true;
    $valid['messages'] = "Contact Message Succesfully Edited";        
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