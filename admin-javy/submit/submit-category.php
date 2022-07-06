<?php

include '../core.php';
require '../connect.inc.php';

	

if(isset($_GET['categoryName'])){
	$categoryName=$_GET['categoryName'];
}
if(isset($_GET['categorySlug'])){
	$categorySlug=$_GET['categorySlug'];


$sql="INSERT INTO `categories` VALUES(NULL,'$categoryName','$categorySlug',1,0,0)";


if($connect->query($sql)){



    $valid['success'] = true;
    $valid['messages'] = "Category Successfully Added"; 

    

      if (!file_exists('../javy-promote/assests/images/product-images/'.$categorySlug )) {
    mkdir('../javy-promote/assests/images/product-images/'.$categorySlug , 0777, true);
}       

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