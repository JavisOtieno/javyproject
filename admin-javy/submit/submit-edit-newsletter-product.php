<?php

include '../core.php';
require '../connect.inc.php';

    
if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if(isset($_GET['product_id'])){
    $product_id=$_GET['product_id'];




$sql="UPDATE `newsletter_products` SET product_id='$product_id' WHERE id=".$id;

if($connect->query($sql)){


    $valid['success'] = true;
    $valid['messages'] = "Newsletter product edited successfully";

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