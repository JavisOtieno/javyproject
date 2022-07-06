<?php include 'connect.inc.php'; ?>

<?php
if(isset($_GET['product_id'])){
    $product_id=$_GET['product_id'];
}else{
  $product_id=8054;
}

$query='SELECT * FROM products WHERE status=1 AND category="phones" AND image!=""';

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["product"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $product = array();
  $product["id"] = $row["id"];
  $product["name"] = $row["name"];
  $product["price"] = $row["price"];
  $product["highlights"] = $row["highlights"];
  $product['image']=str_replace('../', 'http://promote.javy.co.ke/', $row['image']);;
 
 array_push($response["product"], $product);
  }

$query='SELECT * FROM categories';
$query_run=mysqli_query($db_link,$query);

$response["categories"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $category = array();
  $category["categories_name"] = $row["categories_name"];
  $category["categories_id"] = $row["categories_id"];
 
 array_push($response["categories"], $category);
  }

echo json_encode($response);