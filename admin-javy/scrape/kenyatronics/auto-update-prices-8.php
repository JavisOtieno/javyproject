<?php
$base = dirname(dirname(__FILE__).'/../../'); 

echo $base;
echo __DIR__ . '/..';

require __DIR__ . '/../../'.'/connect.inc.php';
include(__DIR__ . '/../../'.'/simple_html_dom.php');


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

echo '<a href="../list-products-on-javy.php"><button type="button" class="btn btn-success">Product Links List</button></a>';

echo '<br/>';



$query3="SELECT * FROM products WHERE supplier_id=1";
$query_run3=mysqli_query($db_link,$query3);
$number_of_products=mysqli_num_rows($query_run3);

echo "Total number of products: <strong>".$number_of_products."</strong> --- ";

$query4="SELECT * FROM products WHERE link LIKE '%kenyatronics%'";
$query_run4=mysqli_query($db_link,$query4);
$number_of_products=mysqli_num_rows($query_run4);
echo "PNT Products: <strong>".$number_of_products."</strong> --- ";

if (isset($_GET['id'])){
$id_received = $_GET['id'];
}else{
$id_received = 0;
}

$offset_id = $id_received;

if($offset_id<=$number_of_products){

if (isset($_GET['category'])){
$category_received = $_GET['category'];

$query_products_total=$query2="SELECT * FROM products WHERE category='".$category_received."' AND supplier_id=1 AND link LIKE '%kenyatronics%' ORDER BY id DESC";
$query2=$query_products_total." LIMIT 100 OFFSET 700 ";

}
if (isset($_GET['brand'])){
$brand_received = $_GET['brand'];

$query_products_total="SELECT * FROM products WHERE category='".$category_received."' AND brand='".$brand_received."' AND supplier_id=1 AND link LIKE '%kenyatronics%' ORDER BY id DESC";
$query2=$query_products_total." LIMIT 100 OFFSET 700 ";

}
if ( !isset($_GET['brand']) && !isset($_GET['category']) )
{
$query_products_total="SELECT * FROM products WHERE supplier_id=1 AND link LIKE '%kenyatronics%' ORDER BY id DESC";
$query2=$query_products_total." LIMIT 100 OFFSET 700 ";
}

//$query2="SELECT * FROM products WHERE category='phones' ORDER BY brand DESC LIMIT ".$offset_id.",50 ";

$query_run_total=mysqli_query($db_link,$query_products_total);
$number_of_products=mysqli_num_rows($query_run_total);
echo "Products Selected: <strong>".$number_of_products."</strong> --- ";





$query_run2=mysqli_query($db_link,$query2);
$number_of_products=mysqli_num_rows($query_run2);
echo "Number of products selected: <strong>".$number_of_products."</strong><br/>";


$next_offset_id=$offset_id+100;


echo "<a href='update-prices.php?id=".($offset_id-100);
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
echo "'><button type='button' class='btn btn-primary'>Previous List of Prices</button></a>";


echo "<a href='update-prices.php?id=".$next_offset_id;
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
echo "'><button type='button' class='btn btn-primary'>Next List of Prices</button></a>";


echo "<a href='update-prices.php?id=".$offset_id;
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
echo "&update=true'><button type='button' class='btn btn-primary'>Current List Update of Prices</button></a>";

echo "<a href='update-prices.php?id=".$next_offset_id;
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
echo "&update=true'><button type='button' class='btn btn-primary'>Next Update of Prices</button></a>";

echo "<br/><br/>";

while($row=mysqli_fetch_assoc($query_run2)){

	$website_url=$row['link'];
	$product_id=$row['id'];
	$product_price=$row['price'];

if(strpos($website_url, 'kenyatronics')!=false){



$html = file_get_html($website_url);

$website_url=str_replace('https://www.kenyatronics.com', ' ', $row['link']);

//echo $html->find('title',0)->plaintext;



$price_from_website = $html->find("span[itemprop='price'] ",0)->plaintext;

$strip_ksh = str_replace('Ksh.', '', $price_from_website);

$strip_comma = str_replace(',', '', $strip_ksh);
$strip_space = str_replace(' ', '', $strip_comma);
$trim_space = trim($strip_space);

$int_price = (int)$strip_space;

echo $product_id."---".$website_url." ---- ".$product_price."--- new-> ".$int_price." ";



}else{
	echo $product_id."---".$website_url." ---- ".$product_price."--- new->  MISSING DIV/SPAN";
}

if(isset($int_price)){
if($int_price!=0){

//only update if the price is different	
	if($int_price!=$product_price){
		echo "DIFFERENT";


					//profit calculated
			$calculated_profit = floor($int_price*0.05);
			$profit_over_hundred=($int_price*0.05)%100;

			if($profit_over_hundred>=50){
				$profit=$calculated_profit-$profit_over_hundred+100;
			}else{
				$profit=$calculated_profit-$profit_over_hundred;
			}

			if($profit==0){
				$profit=100;
			}

			echo " ".$profit." ";

					if (isset($_GET['update'])){

						// UPDATE PRICES
						$update=$_GET['update'];
						$update=true;
						if($update=='true'){
							$update_prices_query="UPDATE `products` SET price='".$int_price."',profit='".$profit."' WHERE id=".$product_id;
					if(mysqli_query($db_link,$update_prices_query)){
						echo "----UPDATED";
						}
						}


				}

	}


}


echo "<a target='_blank' href='http://control.javy.av.ke/edit/edit-product.php?product_id=".$product_id."'>OPEN</a>";
echo "</br>";

}

}



}

echo "<a href='update-prices.php?id=".($offset_id-100);
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
echo "'><button type='button' class='btn btn-primary'>Previous List of Prices</button></a>";



echo "<a href='update-prices.php?id=".$next_offset_id;
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
echo "'><button type='button' class='btn btn-primary'>Next List of Prices</button></a>";


echo "<a href='update-prices.php?id=".$offset_id;
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
echo "&update=true'><button type='button' class='btn btn-primary'>Current List Update of Prices</button></a>";

echo "<a href='update-prices.php?id=".$next_offset_id;
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
echo "&update=true'><button type='button' class='btn btn-primary'>Next Update of Prices</button></a>";




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
include '../../footer.php'; 



?>