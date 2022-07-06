<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $customer_id=$_GET['id'];
}

$query='SELECT * FROM customers WHERE id='.$customer_id;

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["customer"] = array();

if( $row=mysqli_fetch_array($query_run) ){
  $customer = array();
  $customer["customer_id"] = $row["id"];
  $customer["customer_name"] = $row["name"];
  $customer["customer_phone"] = $row["phone"];
  $customer["customer_email"] = $row["email"];
  $customer["customer_delivery_details"] = $row["deliverydetails"];
  if(  $customer["customer_delivery_details"]==""){
     $customer["customer_delivery_details"]=" ";
  }
  if(empty($row["password"])){
    $customer["customer_password_set"]=false;
  }else{
    $customer["customer_password_set"]=true;
  }

   $query2='SELECT * FROM users WHERE user_id='.$row['dealerid'];
   $query_run2=mysqli_query($db_link,$query2);
   if( $row2=mysqli_fetch_array($query_run2) ){
    $customer['customer_storename']=ucfirst($row2['storename']);
   }else{
    $customer['customer_storename']="Tap Change store to select a store";
   }



 
 array_push($response["customer"], $customer);

  }


echo json_encode($response);