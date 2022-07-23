<?php

include '../core.php';
require '../connect.inc.php';

	
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
if(isset($_GET['enquiry_phone'])){
	$enquiryPhone=$_GET['enquiry_phone'];
}
if(isset($_GET['enquiry_description'])){
    $enquiryDescription=$_GET['enquiry_description'];
}
if(isset($_GET['enquiry_item'])){
    $enquiryItem=$_GET['enquiry_item'];
}
if(isset($_GET['enquiry_notes'])){

$enquiryNotes=$_GET['enquiry_notes'];

$sql="UPDATE `enquiries` SET enquiry_item='$enquiryItem',enquiry_phone='$enquiryPhone',enquiry_description='$enquiryDescription',enquiry_notes='$enquiry_notes' WHERE id=".$id;

if($connect->query($sql)){


           




    $valid['success'] = true;
    $valid['messages'] = "Enquiry Successfully Edited.";
    


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