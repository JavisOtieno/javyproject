<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $dealer_id=$_GET['id'];
}

$query='SELECT * FROM users WHERE user_id='.$dealer_id;

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["promoter"] = array();

if( $row=mysqli_fetch_array($query_run) ){
  $promoter = array();
  $promoter["promoter_id"] = $row["user_id"];
  $promoter["promoter_firstname"] = $row["firstname"];
  $promoter["promoter_lastname"] = $row["lastname"];
  $promoter["storename"] = $row["storename"];
  $promoter["promoter_phone"] = $row["phone"];
  $promoter["promoter_email"] = $row["email"];



 
 array_push($response["promoter"], $promoter);

  }


echo json_encode($response);