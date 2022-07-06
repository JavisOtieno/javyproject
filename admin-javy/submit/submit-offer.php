<?php

include '../core.php';
require '../connect.inc.php';

	$time=time();

if(isset($_GET['title'])){
	$title=$_GET['title'];
}


if(isset($_GET['imagelink'])){
	$image=$_GET['imagelink'];
}
if(isset($_GET['originalImagelink'])){
    $originalImage=$_GET['originalImagelink'];
}
if(isset($_GET['product_id'])){
	$product_id=$_GET['product_id'];
}
if(isset($_GET['on_slider'])){
	$on_slider=$_GET['on_slider'];
}
if(isset($_GET['font_size'])){
    $font_size=$_GET['font_size'];
    if(empty($font_size)){
        $font_size=0;
    }
}
if(isset($_GET['fill_colour'])){
    $fill_colour=$_GET['fill_colour'];
}
if(isset($_GET['x_value'])){
    $x_value=$_GET['x_value'];
    if(empty($x_value)){
        $x_value=0;
    }
}
if(isset($_GET['y_value'])){
    $y_value=$_GET['y_value'];
    if(empty($y_value)){
        $y_value=0;
    }
}
if(isset($_GET['position'])){
    $position=$_GET['position'];
    if(empty($position)){
        $position=0;
    }
}
/*

if(isset($_GET['phone'])){
	$customer_phone=$_GET['phone'];
}

*/

	if(isset($_GET['status'])){
	$status=$_GET['status'];

$sql="INSERT INTO `offers2` VALUES(NULL,'$title','$image','$originalImage','$product_id','$on_slider',$status,'$time',$font_size,'$fill_colour',$x_value,$y_value,$position)";

if($connect->query($sql)){



    $valid['success'] = true;
    $valid['messages'] = "Offer Successfully Added";        

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