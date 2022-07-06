<?php include 'header.php'; 

if (isset($_GET['startPrice'])){
	$startPrice=$_GET['startPrice'];
}else{
	$startPrice=0;
}

if (isset($_GET['endPrice'])){
	$endPrice=$_GET['endPrice'];
}else{
	$endPrice=1000000000;
}


$sql_categories="SELECT * FROM categories";

$query_run_categories=mysqli_query($db_link,$sql_categories);

echo '<div>
<a href="pricelists.php"><button type="button" class="btn btn-info">All Products</button></a>
';
echo '<div>
<a href="pricelist-limits.php"><button type="button" class="btn btn-info">Set Price Limits</button></a>
';



while($row_category=mysqli_fetch_assoc($query_run_categories)){

	echo '<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    '.$row_category['categories_name'].'
  </button>
  <div class="dropdown-menu">';
  $categories_slug=$row_category['categories_slug'];
  echo '<a class="dropdown-item" href="pricelists.php?category='.$row_category['categories_slug'].'">All '.ucfirst($row_category['categories_name']).'</a>';

$sql_brands="SELECT * FROM brands WHERE brand_category=".$row_category['categories_id'];
$query_run_brands=mysqli_query($db_link,$sql_brands);


while($row_brand=mysqli_fetch_assoc($query_run_brands)){

	$brand_slug=$row_brand['brand_slug'];
	$brand_name=$row_brand['brand_name'];

	echo '<a class="dropdown-item" href="pricelists.php?category='.$categories_slug.'&brand='.$brand_slug.'">'.$brand_name.'</a>';

}	
echo '
  </div>
</div>';

}
echo "</div>";


$products_query="SELECT * FROM products WHERE status=1 AND approval=2 AND price>".$startPrice." AND price<".$endPrice." ORDER BY category,brand,price";

if(isset($_GET['brand'])&&isset($_GET['category'])&&!empty($_GET['brand'])){
	$brand=$_GET['brand'];
	$category=$_GET['category'];
	$products_query='SELECT * FROM products WHERE status=1 AND approval=2 AND price>'.$startPrice.' AND price<'.$endPrice.' AND category="'.$category.'" AND brand="'.$brand.'" ORDER BY price';
}
else if(isset($_GET['category'])){
	$category=$_GET['category'];
	$products_query='SELECT * FROM products WHERE status=1 AND approval=2 AND price>'.$startPrice.' AND price<'.$endPrice.' AND category="'.$category.'" ORDER BY brand,price';
}


$query_run=mysqli_query($db_link,$products_query);

while($row=mysqli_fetch_assoc($query_run)){
	
	if(!isset($brand)||$brand!=$row['brand']){
		$brand=$row['brand'];
		echo '<br/>'.strtoupper($brand).'<br/>';
	}
	

	echo $row['name'].' @ KSh. '.number_format($row['price']).'<br/>';
}







?>
<?php include 'footer.php'; ?>
