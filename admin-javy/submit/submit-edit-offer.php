<?php

include '../core.php';
require '../connect.inc.php';

	$time=time();

    if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if(isset($_GET['title'])){
	$title=$_GET['title'];
}
if(isset($_GET['imagelink'])){
	$image=$_GET['imagelink'];
}
if(isset($_GET['originalImagelink'])){
    $original_image=$_GET['originalImagelink'];
}
if(isset($_GET['product_id'])){
	$product_id=$_GET['product_id'];
}
if(isset($_GET['on_slider'])){
	$on_slider=$_GET['on_slider'];
}
if(isset($_GET['font_size'])){
    $font_size=$_GET['font_size'];
}
if(isset($_GET['fill_colour'])){
    $fill_colour=$_GET['fill_colour'];
}
if(isset($_GET['x_value'])){
    $x_value=$_GET['x_value'];
}
if(isset($_GET['y_value'])){
    $y_value=$_GET['y_value'];
}
if(isset($_GET['position'])){
    $position=$_GET['position'];
}
/*

if(isset($_GET['phone'])){
	$customer_phone=$_GET['phone'];
}

*/

	if(isset($_GET['status'])){
	$status=$_GET['status'];

$sql="UPDATE `offers2` SET title='$title',image='$image',original_image='$original_image',product_id='$product_id',on_slider='$on_slider',status='$status',font_size='$font_size',x='$x_value',y='$y_value',fill_color='$fill_colour',position='$position' WHERE id=$id";

if($connect->query($sql)){
    $valid['success'] = true;
    $valid['messages'] = "Offer Succesfully Edited";        
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