<?php

include '../core.php';
require '../connect.inc.php';


if(isset($_GET['supplier_id'])){
	$supplier_id=$_GET['supplier_id'];
}
if(isset($_GET['username'])){
	$username=$_GET['username'];
}
if(isset($_GET['phone'])){
	$phone=$_GET['phone'];
}
if(isset($_GET['email'])){
	$email=$_GET['email'];
}
if(isset($_GET['name'])){
	$name=$_GET['name'];
}
if(isset($_GET['co_ke'])){
    $co_ke=$_GET['co_ke'];
}


if(isset($_GET['authorization_status'])){
	$authorization_status=$_GET['authorization_status'];



$sql="UPDATE `suppliers` SET username='$username',email='$email',phone='$phone',name='$name',authorized=$authorization_status,co_ke=$co_ke WHERE id=$supplier_id";

if($connect->query($sql)){
    $valid['success'] = true;
    $valid['messages'] = "Supplier Succesfully Edited";        
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