<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $customer_id=$_GET['id'];
}

$query='SELECT * FROM deals WHERE customer_id='.$customer_id.' ORDER BY id DESC';

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["orders"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $product = array();
  $product["order_id"] = $row["id"];
  $product["product_name"] = $row["product_name"];
  $product["customer_name"] = $row["name"];
  $product["customer_phone"] = $row['phone'];
  $product['customer_email'] = $row['email'];
  $product['customer_delivery_details'] = $row['delivery_details'];
  $product["product_price"] = "KSh. ".number_format($row["product_price"]);
  $product["order_date"] = date('d/m/Y \a\t h:iA',$row["dealDate"]);

    if($row['status']==0){
  $product['order_status']='Processing';  
  }
  else if($row['status']==1){
  $product['order_status']='Complete'; 
  } 
  else if($row['status']==2){
  $product['order_status']='Cancelled';  
  }
 
 array_push($response["orders"], $product);
  }


echo json_encode($response);