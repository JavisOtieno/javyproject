<?php
include '../../header.php';
include('../simple_html_dom.php');


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

$query4="SELECT * FROM products WHERE link LIKE '%ramtons.com%'";
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

$query_products_total=$query2="SELECT * FROM products WHERE category='".$category_received."' AND supplier_id=1 AND link LIKE '%ramtons.com%' ORDER BY id DESC";
$query2=$query_products_total." LIMIT ".$offset_id.",50 ";

}
if (isset($_GET['brand'])){
$brand_received = $_GET['brand'];

$query_products_total="SELECT * FROM products WHERE category='".$category_received."' AND brand='".$brand_received."' AND supplier_id=1 AND link LIKE '%ramtons.com%' ORDER BY id DESC";
$query2=$query_products_total." LIMIT ".$offset_id.",50 ";

}
if ( !isset($_GET['brand']) && !isset($_GET['category']) )
{
$query_products_total="SELECT * FROM products WHERE supplier_id=1 AND link LIKE '%ramtons.com%' ORDER BY id DESC";
$query2=$query_products_total." LIMIT ".$offset_id.",50 ";
}

//$query2="SELECT * FROM products WHERE category='phones' ORDER BY brand DESC LIMIT ".$offset_id.",50 ";

$query_run_total=mysqli_query($db_link,$query_products_total);
$number_of_products=mysqli_num_rows($query_run_total);
echo "Products Selected: <strong>".$number_of_products."</strong> --- ";





$query_run2=mysqli_query($db_link,$query2);
$number_of_products=mysqli_num_rows($query_run2);
echo "Number of products selected: <strong>".$number_of_products."</strong><br/>";


$next_offset_id=$offset_id+50;


echo "<a href='update-prices.php?id=".($offset_id-50);
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
	$status=$row['status'];
	$variable_status=$row['variable'];

if ($status==0){
	$status_text='<span style="color:red">NOT AVAILABLE</span>';
}else{
	$status_text='';
}

if(strpos($website_url, 'ramtons.com')!=false){



$html = file_get_html($website_url);

//$website_url=str_replace('https://www.ramtons.com', ' ', $row['link']);

//echo $html->find('title',0)->plaintext;

if($html->find('span[class="price-wrapper"]',0)){


$price_from_website = $html->find('span[class="price-wrapper"]',0)->attr['data-price-amount'];

$strip_ksh = str_replace('Ksh.', '', $price_from_website);

$strip_comma = str_replace(',', '', $strip_ksh);
$strip_space = str_replace(' ', '', $strip_comma);
$trim_space = trim($strip_space);

$int_price = (int)$strip_space;



echo $product_id."---".$website_url." ---- ".$product_price."--- new-> ".$int_price." ".$status_text." ";

}

else if($html->find('div[class="disp-table"]',0)) {

$price_from_website = $html->find('div[class="disp-table"]',0)->plaintext;

$strip_ksh = str_replace('Ksh.', '', $price_from_website);
$strip_comma = str_replace(',', '', $strip_ksh);
$strip_nbsp = str_replace('&nbsp;', '', $strip_comma);
$strip_space = str_replace(' ', '', $strip_nbsp);
$strip_outofstock = str_replace('OutOfStock', '', $strip_space);
$trim_outofstock = trim($strip_outofstock);

echo $product_id."---".$website_url." ---- ".$product_price."--- new-> ".$int_price." ".$status_text." ";

$int_price = (int)$trim_outofstock;
if($int_price==0){
	echo "---PRODUCT OUT OF STOCK--";
	echo '---<a href="../../submit/set-product-as-not-available.php?id='.$product_id.'">SET AS NOT AVAILABLE</a>---';
}
else{
	echo "---".$int_price."---"."Out Of Stock";
	echo '---<a href="../../submit/set-product-as-not-available.php?id='.$product_id.'">SET AS NOT AVAILABLE</a>---';
}

}else{
	echo $product_id."---".$website_url." ---- ".$product_price."--- new->  MISSING ON WEBSITE".$status_text." ";
	//making sure the price is not updated if the product is missing on the website
	$int_price=0;
	echo '---<a href="../../submit/set-product-as-not-available.php?id='.$product_id.'">SET AS NOT AVAILABLE</a>---';

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
						if($update=='true'){
							$update_prices_query="UPDATE `products` SET price='".$int_price."',profit='".$profit."' WHERE id=".$product_id;
					if(mysqli_query($db_link,$update_prices_query)){
						echo "----UPDATED";
						}
						}


				}



	}


}

	$variants_from_website = $html->find('input[name="products_variant"]',0)->attr['value'];
    //echo "<br><br>Variants found : ".$variants_from_website."<br><br>";

    
    $variants_from_website = str_replace('&quot;,&quot;', '*', $variants_from_website);
    $variants_from_website = str_replace(',&quot;', '*', $variants_from_website);
    $variants_from_website = str_replace('&quot;,', '*', $variants_from_website);

    $variants_from_website = str_replace(',0', '0', $variants_from_website);
    $variants_from_website = str_replace(',1', '1', $variants_from_website);
    $variants_from_website = str_replace(',2', '2', $variants_from_website);
    $variants_from_website = str_replace(',3', '3', $variants_from_website);
    $variants_from_website = str_replace(',4', '4', $variants_from_website);
    $variants_from_website = str_replace(',5', '5', $variants_from_website);
    $variants_from_website = str_replace(',6', '6', $variants_from_website);
    $variants_from_website = str_replace(',7', '7', $variants_from_website);
    $variants_from_website = str_replace(',8', '8', $variants_from_website);
    $variants_from_website = str_replace(',9', '9', $variants_from_website);

    $variants_strings=explode("*", $variants_from_website);
    //print_r($variants_strings);

    $variables_size=sizeof($variants_strings);
    $variable_count=0;

    if($variables_size>1&&$variable_status==0){
    	//SET AS VARIABLE

    $sql3="UPDATE `products` SET variable='1' WHERE id=".$product_id;
    if($connect->query($sql3)){

    echo " - PRODUCT NOT VARIABLE SET AS VARIABLE"; 

    //echo $valid['messages'];       

    }
    else{
        if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        echo " Product Variable Error No - ".$e->getCode(). " - ". $e->getMessage()."<br/>".nl2br($e->getTraceAsString()); 
        //echo $valid['messages'];  
    }
    }
    }

    }

    while($variable_count<$variables_size){
      $variant_variable=$variants_strings[$variable_count+1];
      $variant_price=$variants_strings[$variable_count+2];
      $variable_count=$variable_count+3;

      //$variant_variable=substr($variant_variable, 1, -2);
      //$variant_price=substr($variant_price, 1, -2);

      $variant_variable=str_replace('&quot;', '"', $variant_variable);
      $variant_price=str_replace('&quot;', '"', $variant_price);


    $variable=$variant_variable;
    $price=$variant_price;

    if(!empty($variable)){

    $sql2="UPDATE `variables` SET price='".$price."' WHERE product_id=".$product_id." AND variable='".$variable."'";

    //$sql2='INSERT INTO `variables` VALUES(NULL,'.$product_id.',"'.$variable.'","'.$price.'")';
    

    //echo $sql2;


    if($connect->query($sql2)){

    echo $variable." - ".$price." Variable Updated"; 

    //echo $valid['messages'];       

    }
    else{
        if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        echo "Error No - ".$e->getCode(). " - ". $e->getMessage()."<br/>".nl2br($e->getTraceAsString()); 
        //echo $valid['messages'];  
    }
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

echo "<a href='update-prices.php?id=".($offset_id-50);
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