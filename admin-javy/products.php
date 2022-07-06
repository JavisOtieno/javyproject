<?php include('header.php'); ?>

<?php

require 'connect.inc.php';


//with pagination
//$query='SELECT * FROM products LIMIT 20';

if(isset($_GET['type']) || isset($_GET['category']) || isset($_GET['featured']) || isset($_GET['supplier_id'])|| isset($_GET['store_id']) || isset($_GET['storename']) || isset($_GET['username']) ){
	$type=$_GET['type'];
	$featured=$_GET['featured'];

	$category=$_GET['category'];
	$brand=$_GET['brand'];

	$store_id=$_GET['store_id'];
	$storename_retrieved = $_GET['storename'];
	$username_retrieved = $_GET['username'];
	$supplier_id=$_GET['supplier_id'];

	if (isset($_GET['store_id']) || isset($_GET['storename'])){

		if (isset($_GET['storename'])){

		$query_storename="SELECT * FROM users WHERE storename='".$storename_retrieved."'";

		$query_run_storename=mysqli_query($db_link,$query_storename);

		while($row_storename=mysqli_fetch_assoc($query_run_storename)){ 
			$store_id=$row_storename['user_id'];
		}

		}



		$query="SELECT * FROM products WHERE store_id=$store_id";
	}
	if (isset($_GET['supplier_id']) || isset($_GET['username'])){

		if(isset($_GET['username'])){

		$query_username="SELECT * FROM suppliers WHERE username='".$username_retrieved."'";

		$query_run_username=mysqli_query($db_link,$query_username);

		//echo $query_username;

		while($row_username=mysqli_fetch_assoc($query_run_username)){ 
			$supplier_id=$row_username['id'];
		}

		}



		$query="SELECT * FROM products WHERE supplier_id=$supplier_id";
	}

	if($type=="available"){
$query='SELECT * FROM products WHERE status=1';
}
else if($type=="unavailable"){
$query='SELECT * FROM products WHERE status=0';
}
else if($type=="removed"){
$query='SELECT * FROM products WHERE status=2';
}

	if($type=="links"){
$query="SELECT * FROM products WHERE link <> ''";
}

if($type=="approvedonmainjavy"){
$query='SELECT * FROM products WHERE status=1 AND approval=2';
} else if($type=="approvedonmain"){
$query='SELECT * FROM products WHERE status=1 AND approval=1';
}  else if($type=="notapprovedonmain"){
$query='SELECT * FROM products WHERE status=1 AND approval=0';
}elseif ($type=='approvedonmainjavylinks') {
$query="SELECT * FROM products WHERE status=1 AND approval=2 AND link <> ''";
} 


if(isset($_GET['brand'])&&isset($_GET['category'])){
	$brand=$_GET['brand'];
	$category=$_GET['category'];
	$query='SELECT * FROM products WHERE category="'.$category.'" AND brand="'.$brand.'"';
}
else if(isset($_GET['category'])){
	$category=$_GET['category'];
	$query='SELECT * FROM products WHERE category="'.$category.'"';
}

	if($featured=="all"){
$query='SELECT * FROM products WHERE featured=1';
} else if(!empty($featured)) {
$query='SELECT * FROM products WHERE featured=1 AND category="'.$featured.'"';
}


}
else{
	$query='SELECT * FROM products ORDER BY id DESC';
}

$query_run=mysqli_query($db_link,$query);
$number_of_products=mysqli_num_rows($query_run);

echo '<div style="display:inline-block;margin:10px;">Number of Products: '.$number_of_products.'</div>';

echo '<div style="display:inline-block;margin:10px;"><a href="../products.php?show=images"><button>Products with Images</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="../products.php?type=links"><button>Products with Links</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="../products.php"><button>All Products</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="../products.php?type=available"><button>Available Products</button></a></div>';


echo '<div style="display:inline-block;margin:10px;"><a href="../products.php?type=unavailable"><button>Unavailable Products</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="../products.php?type=removed"><button>Removed Products</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="../products.php?type=approvedonmainjavy"><button>Available and approved on Main & Javy</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="../products.php?type=approvedonmain"><button>Available and Approved on Main Site</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="../products.php?type=notapprovedonmain"><button>Available and Not Approved on Main Site</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="../products.php?type=approvedonmainjavylinks"><button>Available and approved on Main & Javy plus links</button></a></div>';



$sql_categories="SELECT * FROM categories";

$query_run_categories=mysqli_query($db_link,$sql_categories);




	echo '<!-- Example single danger button -->
<div class="btn-group" style="display:inline-block;margin-left:10px;">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Featured Products
  </button>
  <div class="dropdown-menu">';

  echo '<a class="dropdown-item" href="products.php?featured=all">All Featured Products</a>';

while($row_category=mysqli_fetch_assoc($query_run_categories)){
	
	  $categories_slug=$row_category['categories_slug'];
  $categories_name=$row_category['categories_name'];

	echo '<a class="dropdown-item" href="products.php?featured='.$categories_slug.'">'.$categories_name.'</a>';
	
}
echo '
  </div>
</div>';


	echo '<!-- Example single danger button -->
<div class="btn-group" style="display:inline-block;margin-left:10px;">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products by Store/Supplier
  </button>
  <div class="dropdown-menu">';

  echo '<a class="dropdown-item" href="products.php?supplier_id=44">GET supplier id</a>';
  echo '<a class="dropdown-item" href="products.php?username=applemall">GET supplier name</a>';
  echo '<a class="dropdown-item" href="products.php?store_id=1">GET store id</a>';
  echo '<a class="dropdown-item" href="products.php?storename=javytech">GET store name</a>';


echo '
  </div>
</div>';

$sql_categories="SELECT * FROM categories";

$query_run_categories=mysqli_query($db_link,$sql_categories);

echo "<div>";

while($row_category=mysqli_fetch_assoc($query_run_categories)){

	echo '<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    '.$row_category['categories_name'].'
  </button>
  <div class="dropdown-menu">';
  $categories_slug=$row_category['categories_slug'];
  echo '<a class="dropdown-item" href="products.php?category='.$row_category['categories_slug'].'">All '.ucfirst($row_category['categories_name']).'</a>';

$sql_brands="SELECT * FROM brands WHERE brand_category=".$row_category['categories_id'];
$query_run_brands=mysqli_query($db_link,$sql_brands);


while($row_brand=mysqli_fetch_assoc($query_run_brands)){

	$brand_slug=$row_brand['brand_slug'];
	$brand_name=$row_brand['brand_name'];

	echo '<a class="dropdown-item" href="products.php?category='.$categories_slug.'&brand='.$brand_slug.'">'.$brand_name.'</a>';

}	
echo '
  </div>
</div>';

}
echo "</div>";






echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr>
<th>ID</th>';
if(isset($_GET['show'])){
	echo '<th>Image</th>';
}
echo '
<th>Name</th>
<th>Category</th>
<th>Brand</th>
<th>Available</th>
<th>Approved</th>
<th>Edit</th>
<th>Price</th>
</tr></thead><tbody>';

while($row=mysqli_fetch_assoc($query_run)){

echo '<tr>
<td>'.$row['id'].'</td>';

if(isset($_GET['show'])){

echo '<td>';
if($row['image']==''){
	echo 'No Image';
}else{

	$imageUrl = str_replace('../', 'https://promote.javy.co.ke/', $row['image']);;
	echo '<img src="'.$imageUrl.'"  style="height:50px; width:50px;"/>';

}
echo '</td>';

}


echo '<td>'.$row['name'].'</td>
<td>'.$row['category'].'</td>
<td>'.$row['brand'].'</td>
<td>';

$status=$row['status'];

if ($status==1){
	echo 'Available';
}
else if($status==2){
	echo "Removed";
}
else if($status==0){
	echo 'NOT AVAILABLE';
}

echo '</td>

<td>';

$status=$row['approval'];

if ($status==1){
	echo 'Approved main';
}
else if($status==2){
	echo "Approved JAVY";
}
else if($status==0){
	echo 'NOT APPROVED';
}

echo '</td>



<td><a href="edit/edit-product.php?product_id='.$row['id'].'"><button>edit</button></a></td>

<td>'.$row['price'].'</td>
</tr>';

}

echo '</tbody></table>';

?>




<?php include 'footer.php'; ?>