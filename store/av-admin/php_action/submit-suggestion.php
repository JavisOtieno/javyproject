<?php

require('core.php');

if(isset($_POST['suggestion'])){
$suggestion=$connect->real_escape_string($_POST['suggestion']);
}

$date=time();

$valid['success'] = array('success' => false, 'messages' => array());


$sql="INSERT INTO `marketing_suggestions` VALUES(NULL,'.".$suggestion."','".$userId."','".$date."')";

// if($connect->query($sql)){
// 	echo 'success';
// }
// else{
// 		if ($connect->error) {
//     try {    
//         throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
//     } catch(Exception $e ) {
//         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//         echo nl2br($e->getTraceAsString());
//     }
// }
// }

    if($connect->query($sql) === TRUE) {
        $valid['success'] = true;
        $valid['messages'] = "Suggestion successfully submitted. Thank you!";   
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error while processing. Kindly contact us if it persists. Error description: " .$connect -> error;
    }

    $connect->close();

     echo json_encode($valid);