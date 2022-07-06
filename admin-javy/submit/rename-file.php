<?php
include '../core.php';
include '../connect.inc.php';

if(isset($_GET['file_name'])){
	$file_name = $_GET['file_name'];
}
if(isset($_GET['new_file_name'])){
	$new_file_name = $_GET['new_file_name'];
}

if(isset($_GET['source'])){
	$source = $_GET['source'];
	//account for folder up one level
	$source="../".$source;
}

$new_source=str_replace($file_name, $new_file_name, $source);

$original_source_database=str_replace('../../javy-promote/', '../', $source);
$new_source_database=str_replace('../../javy-promote/', '../', $new_source);

$sql_rename_file="UPDATE products SET image='".$new_source_database."' WHERE image='".$original_source_database."'";



if(rename($source, $new_source)) {

     if(($connect->query($sql_rename_file) === true)) {


    $valid['success'] = true;
    $valid['messages'] = "The file ". $file_name. " has been renamed and database updated succesfully.";

    }else{

    	 if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        $valid['success'] = false;
        $valid['messages'] = "Original Source ".$original_source_database." New Source ".$new_source_database."File ". $file_name. "has been moved but there's error updating file details on database. Error No - ".$e->getCode(). " - ". $e->getMessage()."<br/>".nl2br($e->getTraceAsString()); 
    }
}

    }

    }else{

    $valid['success'] = false;
    $valid['messages'] = "Failed to rename file ". $file_name. ". Please try again.";

    }

 echo json_encode($valid);
?>