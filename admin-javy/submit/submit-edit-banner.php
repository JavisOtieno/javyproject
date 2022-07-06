<?php

include '../core.php';
require '../connect.inc.php';

	$time=time();

    if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if(isset($_GET['title'])){
	$title=$_GET['title'];
}
if(isset($_GET['imagelink'])){
	$image=$_GET['imagelink'];
}
if(isset($_GET['link'])){
    $link=$_GET['link'];
}
if(isset($_GET['price'])){
	$price=$_GET['price'];
}


/*

if(isset($_GET['phone'])){
	$customer_phone=$_GET['phone'];
}

*/

	if(isset($_GET['status'])){
	$status=$_GET['status'];

$sql="UPDATE `banners` SET title='$title',image='$image',link='$link',price='$price',status='$status' WHERE id=$id";

if($connect->query($sql)){
    $valid['success'] = true;
    $valid['messages'] = "Banner Succesfully Edited";        
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