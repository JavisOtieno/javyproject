<?php
include '../header.php';

$sql_categories="SELECT * FROM categories";

$query_run_categories=mysqli_query($db_link,$sql_categories);

echo "<div>";

while($row_category=mysqli_fetch_assoc($query_run_categories)){

	$row_category['categories_name'];
	$category_array=explode(' ', $row_category['categories_name']);
	$array_size=sizeof($category_array);
	$category_key=$category_array[$array_size-1];
	$category_key=strtolower($category_key);
	$category_key=substr($category_key, 0, -1);

	echo '<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    '.$row_category['categories_name'].'
  </button>
  <div class="dropdown-menu">';
  $categories_slug=$row_category['categories_slug'];
  echo '<a class="dropdown-item" href="update-prices.php?category='.$categories_slug.'">All '.ucfirst($row_category['categories_name']).'</a>';

$sql_brands="SELECT * FROM brands WHERE brand_category=".$row_category['categories_id'];
$query_run_brands=mysqli_query($db_link,$sql_brands);


while($row_brand=mysqli_fetch_assoc($query_run_brands)){

	$brand_slug=$row_brand['brand_slug'];
	$brand_name=$row_brand['brand_name'];

	echo '<a class="dropdown-item" href="update-prices.php?category='.$categories_slug.'&brand='.$brand_slug.'">'.$brand_name.'</a>';

}	
echo '
  </div>
</div>';

}


echo '<br/>';



$query3="SELECT * FROM products WHERE supplier_id=1";
$query_run3=mysqli_query($db_link,$query3);
$number_of_products=mysqli_num_rows($query_run3);

echo "Total number of products: <strong>".$number_of_products."</strong> --- ";

$query4="SELECT * FROM products WHERE supplier_id=1 AND link LIKE '%phonestablets%'";
$query_run4=mysqli_query($db_link,$query4);
$number_of_products=mysqli_num_rows($query_run4);
echo "<a href='list-products-on-javy.php?type=pnt'>PNT Products</a>: <strong>".$number_of_products."</strong> --- ";

$query4="SELECT * FROM products WHERE supplier_id=1 AND link=''";
$query_run4=mysqli_query($db_link,$query4);
$number_of_products=mysqli_num_rows($query_run4);
echo "<a href='list-products-on-javy.php?type=without-link'>Products without links</a>: <strong>".$number_of_products."</strong> --- ";

$query4="SELECT * FROM products WHERE supplier_id=1 AND link!='' AND link NOT LIKE '%phonestablets%'";
$query_run4=mysqli_query($db_link,$query4);
$number_of_products=mysqli_num_rows($query_run4);
echo "<a href='list-products-on-javy.php?type=wp'>WP Products</a>: <strong>".$number_of_products."</strong> --- ";



$offset_id = $id_received;

if($offset_id<=$number_of_products){

if (isset($_GET['category'])){
$category_received = $_GET['category'];

$query_products_total=$query2="SELECT * FROM products WHERE category='".$category_received."' AND supplier_id=1 ORDER BY id DESC";
$query2=$query_products_total;

}
if (isset($_GET['brand'])){
$brand_received = $_GET['brand'];

$query_products_total="SELECT * FROM products WHERE category='".$category_received."' AND brand='".$brand_received."' AND supplier_id=1 ORDER BY id DESC";
$query2=$query_products_total;

}
if ( !isset($_GET['brand']) && !isset($_GET['category']) )
{
$query_products_total="SELECT * FROM products WHERE supplier_id=1 ORDER BY id DESC";
$query2=$query_products_total;
}


if (isset($_GET['type'])){
$type_received = $_GET['type'];

if($type_received=='pnt'){
	$query2="SELECT * FROM products WHERE supplier_id=1 AND link LIKE '%phonestablets%'";

}else if($type_received=='wp'){
	$query2="SELECT * FROM products WHERE supplier_id=1 AND link!='' AND link NOT LIKE '%phonestablets%'";

}else if($type_received=='without-link'){
	
	$query2="SELECT * FROM products WHERE supplier_id=1 AND link=''";
}
}else{
$type_received = 'all';
}

//$query2="SELECT * FROM products WHERE category='phones' ORDER BY brand DESC LIMIT ".$offset_id.",50 ";

$query_run2=mysqli_query($db_link,$query2);
$number_of_products=mysqli_num_rows($query_run2);
echo "Number of products selected: <strong>".$number_of_products."</strong><br/>";


$next_offset_id=$offset_id+50;


while($row=mysqli_fetch_assoc($query_run2)){

	$website_url=$row['link'];
	$product_id=$row['id'];
	$product_price=$row['price'];
	$product_name=$row['name'];


$website_url=str_replace('https://www.phonestablets.co.ke', ' ', $row['link']);

//echo $html->find('title',0)->plaintext;

	echo $product_id."---".$website_url." ---- ".$product_price;


echo "----<a target='_blank' href='http://control.javy.av.ke/edit/edit-product.php?product_id=".$product_id."'>OPEN</a>---".$product_name;
echo "</br>";


}



}






/*
$website_url = "https://www.phonestablets.co.ke/product/samsung-galaxy-a70";

$html = file_get_html($website_url);

//echo $html->find('title',0)->plaintext;
$price_from_website = $html->find('span[class="payBlkBig"]',0)->plaintext;

$strip_ksh = str_replace('Ksh.', '', $price_from_website);

$strip_comma = str_replace(',', '', $strip_ksh);
$strip_space = str_replace(' ', '', $strip_comma);
$trim_space = trim($strip_space);

$int_price = (int)$strip_space;


$sql="UPDATE `products` SET price='".$trim_space."' WHERE id=8124";

if($connect->query($sql)){
    $valid['success'] = true;
    $valid['messages'] = "Product Price Succesfully Edited";        
}
else{
        if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        $valid['success'] = false;
        $valid['messages'] = "Error No - ".$e->getCode(). " - ". $e->getMessage()."<br/>".nl2br($e->getTraceAsString()); 
    }
}
}
echo json_encode($valid);
*/
include '../footer.php'; 



?>