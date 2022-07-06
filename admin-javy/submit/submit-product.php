<?php

include '../core.php';
require('../connect.inc.php');

if(isset($_GET['productName'])){
$productName=addslashes($_GET['productName']);
}
if(isset($_GET['productPrice'])){
$productPrice=$_GET['productPrice'];
}
if(isset($_GET['productCost'])){
$productCost=$_GET['productCost'];
}

if(isset($_GET['productHighlights'])){
$productHighlights=nl2br(str_replace('-', '', $_GET['productHighlights']));
$productHighlights=addslashes($productHighlights);
}
if(isset($_GET['productProfit'])){
$productProfit=$_GET['productProfit'];
}
if(isset($_GET['categoryName'])){
$productCategory=$_GET['categoryName'];
}
if(isset($_GET['brandName'])){
$productBrand=$_GET['brandName'];
}
if(isset($_GET['productStatus'])){
$productStatus=$_GET['productStatus'];
}
if(isset($_GET['approval'])){
$productApproval=$_GET['approval'];
}
if(isset($_GET['javytech_id'])){
$javytech_id=$_GET['javytech_id'];
}else{
$javytech_id=0;
}


if(isset($_GET['productFeatured'])){
$productFeatured=$_GET['productFeatured'];
}
if(isset($_GET['productVariable'])){
$productVariable=$_GET['productVariable'];

}else{
$productVariable=0;
}
if(isset($_GET['productLink'])){
$productLink=$_GET['productLink'];
}
else{
$productLink='';  
}

$date=time();


$query='SELECT * FROM products';
$query_run=mysqli_query($db_link,$query);
$rows=mysqli_num_rows($query_run);

$array_slug=[];

function form_slug($name){ 

        $name=str_replace(' ', '_', $name);
        $name=str_replace('"', '', $name);
        $name=str_replace('”', '', $name);
        $name=str_replace('“', '', $name);
        $name=str_replace('#', '', $name);
        $name=str_replace('&', '', $name);
        $name=str_replace('+', '', $name);
        $name=str_replace('@', '', $name);
        $name=str_replace('-', '', $name);
        $name=str_replace(',', '', $name);
        
        $slug=strtolower($name);
        return $slug;

}

while($row=mysqli_fetch_assoc($query_run)){

        $name=$row['name'];
        $product_id=$row['id'];
        $slug=form_slug($name);
        array_push($array_slug, $slug);
        
        }

        $found=false;
        $count=0;

        $slug=form_slug($productName);

        foreach ($array_slug as $value) 
        {
          if($value==$slug){
            $found=true;
            $count++;
          }
        }

        if($found){
          //echo "Doubled ";
          $slug=$slug.'_'.strval($count);
        }


        //echo $slug.'<br/>';


$sql="INSERT INTO `products` VALUES(NULL,'$productName','','','$productPrice','$productHighlights','','$productProfit','$productCost','$productCategory','$productBrand','$productStatus',$productApproval,'$productFeatured','$productVariable','','',1,0,'$slug','$productLink',$javytech_id,0,$date)";



if($connect->query($sql)){

    //id to be used in variables
    $valid['id']=$connect->insert_id;
    $id=$valid['id'];


    if($productVariable){

    $product_variables=$_GET['productVariables'];
    //echo "Variables: ".$product_variables;
    $variants_array=explode('-',$product_variables);

    foreach ($variants_array as $value) {

    $variant_item=explode('@', $value);

    $variable=$variant_item[0];
    $price=$variant_item[1];

    if(!empty($variable)){

    $sql='INSERT INTO `variables` VALUES(NULL,'.$id.','.$variable.','.$price.')';


    if($connect->query($sql)){

    $valid['success'] = true;
    $valid['messages'] = $valid['messages']."Product Variables Succesfully edited"; 

    //echo $valid['messages'];       

    }
    else{
        if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        $valid['success'] = false;
        $valid['messages'] = $valid['messages']."Error No - ".$e->getCode(). " - ". $e->getMessage()."<br/>".nl2br($e->getTraceAsString()); 
        //echo $valid['messages'];  
    }
    }
    }

}

}

}

    $valid['success'] = true;
    $valid['messages'] = $valid['messages']."Product Successfully Added"; 



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