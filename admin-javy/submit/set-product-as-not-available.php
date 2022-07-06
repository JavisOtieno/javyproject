<?php

include '../core.php';
require '../connect.inc.php';



if(isset($_GET['id'])){
	$product_id=$_GET['id'];
}


$sql="UPDATE `products` SET status='0' WHERE id=$product_id";

if($connect->query($sql)){
	header('location: ../edit/edit-product.php?product_id='.$product_id);
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


?>