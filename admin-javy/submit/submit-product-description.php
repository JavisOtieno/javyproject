<?php

include '../core.php';
require '../connect.inc.php';

if(isset($_POST['id'])){
    $id=$_POST['id'];
}



if(isset($_POST['description'])){
    //$product_description=nl2br($_POST['description']);
    $product_description=htmlentities($_POST['description']);
    $product_description=addslashes($product_description);



$sql="UPDATE `products` SET description='$product_description' WHERE id=$id";

if($connect->query($sql)){

    $valid['success'] = true;
    $valid['messages'] = "Product Description Succesfully edited";        

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