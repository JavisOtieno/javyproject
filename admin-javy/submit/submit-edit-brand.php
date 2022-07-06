<?php

include '../core.php';
require '../connect.inc.php';

	
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
if(isset($_GET['brand_name'])){
	$brandName=$_GET['brand_name'];
}
if(isset($_GET['brandCategory'])){
    $brandCategory=$_GET['brandCategory'];
}
if(isset($_GET['javytech_id'])){
    $javytech_id=$_GET['javytech_id'];
}
if(isset($_GET['brand_slug'])){
	$brandSlug=$_GET['brand_slug'];
    $previousBrandSlug=$_GET['previous_brand_slug'];
    $previousCategoryID=$_GET['previous_brand_category'];


$sql="UPDATE `brands` SET javytech_id='$javytech_id',brand_name='$brandName',brand_slug='$brandSlug',brand_category='$brandCategory' WHERE brand_id=".$id;

if($connect->query($sql)){


    if($brandCategory!=$previousCategoryID || $brandSlug != $previousBrandSlug){

        $sql = "SELECT categories_id,categories_slug FROM categories WHERE categories_status = 1";
        $result = $connect->query($sql);

        while($row = $result->fetch_array()) {
            if($row[0]==$brandCategory){
                $categorySlug=$row[1];
            }
            if($row[0]==$previousCategoryID){
                $previousCategorySlug=$row[1];
            }
           
        } // while

    $sql2="UPDATE `products` SET category='".$categorySlug."',brand='".$brandSlug."' WHERE category='".$previousCategorySlug."' AND brand='".$previousBrandSlug."'";
           


if($connect->query($sql2)){
    $valid['success'] = true;
    $valid['messages'] = "Brand/Category Successfully Edited and Products Updated as well. New Category: ".$categorySlug." Old Category: ".$previousCategorySlug." New Brand:".$brandSlug." Old Brand".$previousBrandSlug." Previous Category ID ".$previousCategoryID."New Category ID ".$brandCategory." SQL : ".$sql2;
    }else{
    $valid['success'] = false;
    $valid['messages'] = "Brand/Category Successfully Edited BUT PRODUCTS NOT UPDATED!!!!".$connect -> error;
}
}
    else{
    $valid['success'] = true;
    $valid['messages'] = "Brand Successfully Edited. New Brand:".$brandSlug." Old Brand".$previousBrandSlug." Previous Category ID ".$previousCategoryID."New Category ID ".$brandCategory;
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