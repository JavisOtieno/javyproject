<?php

require('connect.inc.php');
require('subdomain_storename.php');

if(isset($_POST['query'])){
$query=mysqli_real_escape_string($db_link,$_POST['query']);

}

$valid2['success'] = array('success' => false, 'messages' => array());

//getting the dealer id
$querydb="SELECT `user_id` FROM `users` WHERE `storename` ='$storename'";

$query_run=mysqli_query($db_link,$querydb);
if($row=mysqli_fetch_assoc($query_run)){
	
	$dealer_id=$row['user_id'];

}



$sql="INSERT INTO `customer_queries` VALUES(NULL,'$query','$dealer_id','$storename')";

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

      //PHP MAIL DOES NOT WORK ON LOCALHOST. UNCOMMENT ON UPLOAD
$to      = 'javisotieno@gmail.com';
$subject = 'QUERY:'.$query;
$message = $query;
$headers = 'From: info@javytech.co.ke' .'
'.
    'Reply-To: info@javytech.co.ke' .'
    '.
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);


        $valid2['success'] = true;
        $valid2['messages'] = "Your query has been received. Thank you!";  


    } else {
        $valid2['success'] = false;
        $valid2['messages'] = "Error while processing query. Kindly contact us if it persists";
    }

    $connect->close();

     echo json_encode($valid2);