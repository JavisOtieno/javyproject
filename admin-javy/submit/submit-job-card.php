<?php

include '../core.php';
require('../connect.inc.php');

if(isset($_GET['customerName'])){
$customerName=addslashes($_GET['customerName']);
}
if(isset($_GET['customerPhone'])){
$customerPhone=$_GET['customerPhone'];
}
if(isset($_GET['customerEmail'])){
$customerEmail=$_GET['customerEmail'];
}

if(isset($_GET['customerAddress'])){
$customerAddress=nl2br(str_replace('-', '', $_GET['customerAddress']));
$customerAddress=addslashes($customerAddress);
}
if(isset($_GET['productName'])){
$productName=$_GET['productName'];
}
if(isset($_GET['productPrice'])){
$productPrice=$_GET['productPrice'];
}

if(isset($_GET['shopId'])){
$dealerID=$_GET['shopId'];
}


$date=time();

        //echo $slug.'<br/>';
//phone and email check on customers

$sqlnumberexists="SELECT * FROM customers WHERE phone='$customerName'";
$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

//prevent multiple entry of customers
$sqlemailexists="SELECT * FROM customers WHERE email='$customerEmail'";
$query_run_email_exists=mysqli_query($db_link,$sqlemailexists);

if(mysqli_num_rows($query_run_number_exists)>0){

    if($row=mysqli_fetch_assoc($query_run_number_exists)){
    $customer_id=$row['id'];
    }

}else if((mysqli_num_rows($query_run_email_exists)>0) && $customerEmail!="N/A" && $customerEmail!="NA" &&
$customerEmail!="NONE")
{
    if($row=mysqli_fetch_assoc($query_run_email_exists)){
    $customer_id=$row['id'];
    }
}
else{

    $sqlcustomers = "INSERT INTO customers VALUES(NULL,'$customerName', '$customerContact', '$customerEmail', '$customerAddress','$dealerID',0,'',$dealDate)";

    if(($connect->query($sqlcustomers) === true)){
            $customer_id= $connect->insert_id;
                }

}


$sql="INSERT INTO `job_cards` VALUES(NULL,'$customerName','$customerPhone','$customerEmail','$customerAddress','$dealerID','$customer_id',404,'$productName','$productPrice')";



if($connect->query($sql)){

    //id to be used in variables
    $valid['id']=$connect->insert_id;
    $id=$valid['id'];

    $valid['success'] = true;
    $valid['messages'] = $valid['messages']."Job Card Successfully Added"; 


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