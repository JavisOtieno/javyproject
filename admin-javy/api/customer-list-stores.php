<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php


$query='SELECT * FROM users';

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["stores"] = array();

while( $row=mysqli_fetch_array($query_run) ){

  $store = array();
  $store["store_id"] = $row["user_id"];
  $store["store_name"] = $row["storename"];
  $store['store_phone']=$row['phone'];

 array_push($response["stores"], $store);

  }


echo json_encode($response);