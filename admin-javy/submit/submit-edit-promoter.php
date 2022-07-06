<?php

include '../core.php';
require '../connect.inc.php';


if(isset($_GET['promoter_id'])){
	$promoter_id=$_GET['promoter_id'];
}
if(isset($_GET['storename'])){
	$storename=$_GET['storename'];
}
if(isset($_GET['phone'])){
	$phone=$_GET['phone'];
}
if(isset($_GET['email'])){
	$email=$_GET['email'];
}
if(isset($_GET['firstname'])){
	$firstname=$_GET['firstname'];
}
if(isset($_GET['lastname'])){
	$lastname=$_GET['lastname'];
}
if(isset($_GET['show_founder'])){
	$show_founder=$_GET['show_founder'];
}

if(isset($_GET['validation_status'])){
	$validation_status=$_GET['validation_status'];



$sql="UPDATE `users` SET storename='$storename',email='$email',phone='$phone',firstname='$firstname',lastname='$lastname',show_founder='$show_founder',validation_status=$validation_status WHERE user_id=$promoter_id";

if($connect->query($sql)){
    $valid['success'] = true;
    $valid['messages'] = "Promoter Succesfully Edited";        
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