<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['user_id'])){
    $dealer_id=$_GET['user_id'];
}

$query='SELECT * FROM deals WHERE dealer_id='.$dealer_id;

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["orders"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $order = array();
  $order["order_id"] = $row["id"];
  $order["product_name"] = $row["product_name"];
  $order["customer_name"] = $row["name"];
  $order["customer_phone"] = $row['phone'];
  $order['customer_email'] = $row['email'];
  $order['customer_delivery_details'] = $row['delivery_details'];
  $order["product_price"] = "KSh. ".number_format($row["product_price"]);
  $order["product_profit"] = "KSh. ".number_format($row["product_price"]);
  $order["order_date"] = date('d/m/Y \a\t h:iA',$row["dealDate"]);

    if($row['status']==0){
  $order['order_status']='Processing';  
  }
  else if($row['status']==1){
  $order['order_status']='Complete'; 
  } 
  else if($row['status']==2){
  $order['order_status']='Cancelled';  
  }
 
 array_push($response["orders"], $order);
  }


echo json_encode($response);