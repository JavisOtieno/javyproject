<?php

include '../core.php';
require '../connect.inc.php';

	

if(isset($_GET['link'])){
	$link=$_GET['link'];
}

if(isset($_GET['id'])){
    $id=$_GET['id'];


$sql="INSERT INTO `more_links` VALUES(NULL,'$id','$link')";


if($connect->query($sql)){



    $valid['success'] = true;
    $valid['id']= $id;
    $valid['messages'] = "Link Successfully Added"; 
     

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