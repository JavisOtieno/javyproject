<?php

include '../core.php';
require '../connect.inc.php';

	
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
if(isset($_GET['categoryName'])){
	$categoryName=$_GET['categoryName'];
}
if(isset($_GET['javytech_id'])){
    $javytech_id=$_GET['javytech_id'];
}
if(isset($_GET['new_category_id'])){
    $new_category_id=$_GET['new_category_id'];
}
if(isset($_GET['categorySlug'])){
	$categorySlug=$_GET['categorySlug'];
    $previousCategorySlug=$_GET['previousCategorySlug'];




$sql="UPDATE `categories` SET categories_id='$new_category_id',javytech_id='$javytech_id',categories_name='$categoryName',categories_slug='$categorySlug' WHERE categories_id=".$id;

if($connect->query($sql)){

if($categorySlug!=$previousCategorySlug){        
$sql2="UPDATE `products` SET category='".$categorySlug."' WHERE category='".$previousCategorySlug."'";

if($connect->query($sql2)){
    $valid['success'] = true;
    $valid['messages'] = "Category Succesfully Edited and Products Updated as well";

    }else{
    $valid['success'] = false;
    $valid['messages'] = "Category Succesfully Edited BUT PRODUCTS NOT UPDATED!!!!".$connect -> error;


    }
}else if(isset($_GET['new_category_id'])){
    
    $sql3="UPDATE `brands` SET brand_category='".$new_category_id."' WHERE brand_category='".$id."'";
        if($connect->query($sql3)){
    $valid['success'] = true;
    $valid['messages'] = "Category Succesfully Edited and Brands Updated as well";
    }else{
    $valid['success'] = false;
    $valid['messages'] = "Category Succesfully Edited BUT BRANDS NOT UPDATED!!!!".$connect -> error;
    }

}else{
    $valid['success'] = true;
    $valid['messages'] = "Category Succesfully Edited";

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