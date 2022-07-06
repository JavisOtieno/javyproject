<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
header('Content-Type: application/json; charset=utf-8');
?>


<?php


  $query="SELECT * FROM car_products";



$query_run=mysqli_query($db_link,$query);

$response = array('total_size' => 6);

$response["type_id"] = 2;
$response["offset"] = 0;



$response["products"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $product = array();
  $product["id"] = intval($row["id"]);
  $product["name"] = $row["name"];
  $product["description"] = $row["description"];
  $product["stars"] = intval($row["stars"]);
  $product["price"] = intval($row["price"]);
  $product['img']=str_replace('../', 'http://promote.javy.co.ke/', $row['image']);
  $product["location"] = $row["location"];
  $product["created_at"] = date('d/m/Y \a\t h:iA',$row["created_at"]);
  $product["updated_at"] = date('d/m/Y \a\t h:iA',$row["updated_at"]);
  $product["type_id"] = intval($row["type_id"]);

 
 array_push($response["products"], $product);
  }

echo json_encode($response);