<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $customer_id=$_GET['id'];
}else{
  $customer_id=1872;
}



$query='SELECT * FROM offers2 WHERE status=1 ORDER BY id DESC';

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["offers"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $offer = array();
  $offer["offer_id"] = $row["id"];
  $offer["offer_title"] = $row["title"];
  $offer['offer_image']='http://promote.javy.co.ke/'.$row['original_image'];

 array_push($response["offers"], $offer);

  }


echo json_encode($response);