<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>


<?php
if(isset($_GET['category'])){
    $category=$_GET['category'];



}
if($category=='All Products'){
  $query='SELECT * FROM products WHERE status=1 AND approval=2 AND image!="" ORDER BY category';
}else{

    $query_categories="SELECT * FROM categories WHERE categories_name='".$category."'";
    $query_run_categories=mysqli_query($db_link,$query_categories);
    while( $row_categories=mysqli_fetch_array($query_run_categories) ){
      $categories_slug=$row_categories['categories_slug'];
    }
    $category=$categories_slug;

  $query="SELECT * FROM products WHERE status=1 AND approval=2 AND image!='' AND category='".$category."' ORDER BY category";

}

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);

$response["product"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $product = array();
  $product["id"] = $row["id"];
  $product["name"] = $row["name"];
  $product["price"] = "KSh. ".number_format($row["price"]);
  $product["profit"] = "KSh. ".number_format($row["profit"]);
  $product["highlights"] = $row["highlights"];
  $product['image']=str_replace('../', 'http://promote.javy.co.ke/', $row['image']);
 
 array_push($response["product"], $product);
  }


$query='SELECT * FROM categories';
$query_run=mysqli_query($db_link,$query);

$response["categories"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $category = array();
  $category["categories_name"] = $row["categories_name"];
  $category["categories_slug"] = $row["categories_slug"];
  $category["categories_id"] = $row["categories_id"];
 
 array_push($response["categories"], $category);
  }

echo json_encode($response);