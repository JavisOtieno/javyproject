<?php

require('connect.inc.php');
require('subdomain_storename.php');

if(isset($_POST['email'])){
$email=mysqli_real_escape_string($db_link,$_POST['email']);

}

    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // valid address


$date=time();

$valid['success'] = array('success' => false, 'messages' => array());

//getting the phone number
$query="SELECT `user_id` FROM `users` WHERE `storename` ='$storename'";

$query_run=mysqli_query($db_link,$query);
if($row=mysqli_fetch_assoc($query_run)){
    
    $user_id=$row['user_id'];

}

$sql="INSERT INTO `customer_emails` VALUES(NULL,'$email','$user_id','$storename','$date')";

// if($connect->query($sql)){
//  echo 'success';
// }
// else{
//      if ($connect->error) {
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
        $valid['messages'] = "You've succesfully subscribed. Thank you!";   
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error while processing subscription. Kindly contact us if it persists";
    }

} 
    else {
        // invalid address
        $valid['success'] = false;
        $valid['messages'] = "Invalid Email Address";
    }

    $connect->close();

     echo json_encode($valid);