<?php

include '../core.php';
require '../connect.inc.php';

	

if(isset($_GET['brandName'])){
	$brandName=$_GET['brandName'];
}
if(isset($_GET['brandSlug'])){
	$brandSlug
    =$_GET['brandSlug'];
}
if(isset($_GET['javytech_id'])){
    $javytech_id=$_GET['javytech_id'];
}else{
    $javytech_id=0;
}
/*
if(isset($_GET['phone'])){
	$customer_phone=$_GET['phone'];
}
*/
	if(isset($_GET['brandCategory'])){
	$brandCategory=$_GET['brandCategory'];

$sql="INSERT INTO `brands` VALUES(NULL,'$brandName','$brandSlug','$brandCategory',1,'$javytech_id')";




if($connect->query($sql)){

    $sql_category_slug = "SELECT categories_slug FROM categories WHERE categories_id =".$brandCategory;
                                $result_slug = $connect->query($sql_category_slug);

        while($row_slug = $result_slug->fetch_array()) {
                $category_slug=$row_slug[0];                    
        } // while


   //make brand folder if brand folder is missing
if (!file_exists('../javy-promote/assests/images/product-images/'.$category_slug.'/'.$brandSlug)) {
    mkdir('../javy-promote/assests/images/product-images/'.$category_slug.'/'.$brandSlug , 0777, true);
}

    $valid['success'] = true;
    $valid['messages'] = "Brand Successfully Added";        

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