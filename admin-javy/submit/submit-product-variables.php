<?php

include '../core.php';
require '../connect.inc.php';

if(isset($_POST['id'])){
    $id=$_POST['id'];
}



if(isset($_POST['variables'])){
    //$product_description=nl2br($_POST['description']);
    $product_variables=$_POST['variables'];
    $variants_array=explode('-',$product_variables);

    foreach ($variants_array as $value) {

    $variant_item=explode('@', $value);

    $variable=$variant_item[0];
    $price=$variant_item[1];

    if(isset($_GET['edit'])){
        $sql='UPDATE `variables` SET price='.$price.' WHERE product_id='.$id.' AND variable='.$variable.'';
    }else{

    $sql='INSERT INTO `variables` VALUES(NULL,'.$id.','.$variable.','.$price.')';
        
        }


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


    }


   echo json_encode($valid);



}


?>