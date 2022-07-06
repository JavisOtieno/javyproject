<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $supplier_id=$_GET['id'];
}

$query='SELECT * FROM suppliers WHERE id='.$supplier_id;

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["supplier"] = array();

if( $row=mysqli_fetch_array($query_run) ){
  $supplier = array();
  $supplier["supplier_id"] = $row["supplier_id"];
  $supplier["supplier_name"] = $row["name"];
  $supplier["username"] = $row["username"];
  $supplier["supplier_phone"] = $row["phone"];
  $supplier["supplier_email"] = $row["email"];



 
 array_push($response["supplier"], $supplier);

  }


echo json_encode($response);