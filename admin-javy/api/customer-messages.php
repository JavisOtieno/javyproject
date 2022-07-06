<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $customer_id=$_GET['id'];
}


$query='SELECT * FROM product_messages WHERE customer_id='.$customer_id.' ORDER BY id DESC';

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["messages"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $message = array();
  $message["message_id"] = $row["id"];

  $message["customer_name"] = $row["name"];
  $message["customer_phone"] = $row['phone'];
  $message['customer_email'] = $row['email'];
  $message['customer_message'] = $row['message'];

$query2='SELECT * FROM products WHERE id='.$row['product_id'];
$query_run2=mysqli_query($db_link,$query2);
while( $row2=mysqli_fetch_array($query_run2) ){

  $message['product_name']=$row2['name'];
  $message['product_price']=$row2['price'];


}

  $message["message"] = $row["message"];
  $message["message_date"] = date('d/m/Y \a\t h:iA',$row["date"]);

    if($row['status']==0){
  $message['message_status']='Processing';  
  }
  else if($row['status']==1){
  $message['message_status']='Answered'; 
  } 
  else if($row['status']==2){
  $message['message_status']='Not Answered';  
  }

  $message["message_notes"] = $row["notes"];
 
 array_push($response["messages"], $message);
 
  }


echo json_encode($response);