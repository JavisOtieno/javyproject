<?php

include '../core.php';
require '../connect.inc.php';



if(isset($_GET['link'])){
	$link=$_GET['link'];
}

if(isset($_GET['main_link'])){
    $main_link=$_GET['main_link'];
}

if(isset($_GET['product_id'])){
    $product_id=$_GET['product_id'];
}


$sql="UPDATE `products` SET link='".$link."' WHERE id=$product_id";
$sql2="UPDATE `more_links` SET link='".$main_link."' WHERE id=".$product_id." AND link='".$main_link."'";


if($connect->query($sql) && $connect->query($sql2)){
	header('location: ../add/add-link.php?id='.$product_id);
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