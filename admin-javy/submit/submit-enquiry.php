<?php

include '../core.php';
require '../connect.inc.php';

	
if(isset($_GET['enquiryDate'])){
    $enquiryDate=$_GET['enquiryDate'];
}
if(isset($_GET['enquiryPhone'])){
	$enquiryPhone=$_GET['enquiryPhone'];
}
if(isset($_GET['enquiryItem'])){
	$enquiryItem=$_GET['enquiryItem'];
}
if(isset($_GET['enquiryDescription'])){
    $enquiryDescription=$_GET['enquiryDescription'];
}
if(isset($_GET['enquiryNotes'])){
	$enquiryNotes=$_GET['enquiryNotes'];

$sql="INSERT INTO `enquiries` VALUES(NULL,'$enquiryDate','$enquiryPhone','$enquiryItem','$enquiryDescription','$enquiryNotes')";




if($connect->query($sql)){


    $valid['success'] = true;
    $valid['messages'] = "Enquiry Successfully Added";        

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