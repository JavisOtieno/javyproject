<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['user_id'])){
    $dealer_id=$_GET['user_id'];
}

$query='SELECT * FROM customers WHERE dealerid='.$dealer_id;

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["customers"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $customer = array();
  $customer["customer_id"] = $row["id"];
  $customer["customer_name"] = $row["name"];
  $customer["customer_phone"] = $row["phone"];
  $customer["customer_email"] = $row["email"];

 
 array_push($response["customers"], $customer);
  }


echo json_encode($response);