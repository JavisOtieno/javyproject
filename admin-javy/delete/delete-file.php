<?php

	include '../core.php';
    include '../connect.inc.php';

    $source = $_GET['source'];
    $category = $connect->real_escape_string($_GET['category']);
    $brand = $connect->real_escape_string($_GET['brand']);
   
    //local code
    //$target_dir = "../stock-2/assests/images/offers/";
    
    $fullFileName='../'.$source;

$myFileLink = fopen($fullFileName, 'w') or die("can't open file");
fclose($myFileLink);
if(unlink($fullFileName))
{
$sql_delete_file="DELETE FROM files WHERE id=".$fileId;

 //if(($connect->query($sql_delete_file) === true)) {
    if((true)) {

    $valid['success'] = true;
    $valid['messages'] = "The file ". $fullFileName. " has been deleted.";

    }else{

    $valid['success'] = true;
    $valid['messages'] = "File ". $fullFileName. "has been deleted but there's rror updating file details on ". $fullFileName. ".";

    }
}else{
    $valid['success'] = false;
    $valid['messages'] = "Error deleting file : ". $fullFileName. "";

}

    $connect->close();

    echo json_encode($valid);
    ?>