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
if(isset($_GET['address'])){
    $address=$_GET['address'];
}
if(isset($_GET['storeId'])){
    $storeId=$_GET['storeId'];
}
if(isset($_GET['productId'])){
    $productId=$_GET['productId'];
}
if(isset($_GET['productName'])){
    $productName=$_GET['productName'];
}




if(isset($_GET['productPrice'])){

$productPrice=$_GET['productPrice'];

$sql="UPDATE `job_cards` SET name='$name',phone='$phone',email='$email',address='$address',product_name='$productName',product_price='$productPrice' WHERE id=".$id;

if($connect->query($sql)){


           




    $valid['success'] = true;
    $valid['messages'] = "Job Card Successfully Edited.";
    


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