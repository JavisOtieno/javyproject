<?php 	

require_once 'core.php';

$category_slug = $_GET['category_slug'];


$sql_category = "SELECT categories_id FROM categories WHERE categories_slug = '".$category_slug."'";
$result_category = $connect->query($sql_category);
if($result_category->num_rows > 0) { 
 $row_category = $result_category->fetch_array();
 $categoryId = $row_category['categories_id'];
} // if num_rows



$sql = "SELECT brand_id, brand_name, brand_slug, brand_category, brand_status FROM brands WHERE brand_category = $categoryId";
$result = $connect->query($sql);
$brands_array=[];
$count=0;

while($row_brand = $result->fetch_array())
{
	$brands_array[$count]=$row_brand;
	$count++;
}

$connect->close();

echo json_encode($brands_array);