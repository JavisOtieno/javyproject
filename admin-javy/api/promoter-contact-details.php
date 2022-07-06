<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");

if(isset($_GET['id'])){
    $customer_id=$_GET['id'];
}else{
  $customer_id=1872;
}

$query='SELECT * FROM customers WHERE id='.$customer_id;

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["store"] = array();

if( $row=mysqli_fetch_array($query_run) ){

   $query2='SELECT * FROM users WHERE user_id='.$row['dealerid'];
   $query_run2=mysqli_query($db_link,$query2);
   if( $row2=mysqli_fetch_array($query_run2) ){

    $store['store_id']=$row['dealerid'];
    $store['store_name']="We're always happy to help.";
    $store['store_phone']='0716 545459';
    $store['store_email']='info@javy.co.ke';

 array_push( $response["store"], $store );

  }
}

echo json_encode($response);