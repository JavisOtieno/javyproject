<?php
include '../../header.php';
include('../simple_html_dom.php');


$sql_categories="SELECT * FROM categories";

$query_run_categories=mysqli_query($db_link,$sql_categories);

echo "<div>";



	echo '<!-- Example single danger button -->
<div class="btn-group">
  <a href="update-prices.php?website=ballytech"><button type="button" class="btn btn-info" >Ballytech</button></a>
  </div>';
  	echo '<!-- Example single danger button -->
<div class="btn-group">
  <a href="update-prices.php?website=vividgold"><button type="button" class="btn btn-info" >Vividgold</button></a>
  </div>';
    echo '<!-- Example single danger button -->
<div class="btn-group">
  <a href="update-prices.php?website=shopnbuy"><button type="button" class="btn btn-info" >Shopnbuy</button></a>
  </div>';
      echo '<!-- Example single danger button -->
<div class="btn-group">
  <a href="update-prices.php?website=onestopautogarage"><button type="button" class="btn btn-info" >Onestopautogarage</button></a>
  </div>';
  echo '<!-- Example single danger button -->
<div class="btn-group">
  <a href="update-prices.php?website=camerasafrica"><button type="button" class="btn btn-info" >Camerasafrica</button></a>
  </div>';
  echo '<!-- Example single danger button -->
<div class="btn-group">
  <a href="update-prices.php?website=others"><button type="button" class="btn btn-info" >Others</button></a>
  </div>';

echo '<br/>';



$query3="SELECT * FROM products WHERE link NOT LIKE '%phonestablets%' AND link NOT LIKE '%kenyatronics%' AND link NOT LIKE '%ramtons%' AND link!=''";


if(isset($_GET['website'])){
	$website = $_GET['website'];
}

if($website=='ballytech'){
	$query3="SELECT * FROM products WHERE link LIKE '%ballytech%' AND link!=''";
}else if($website=='vividgold'){
	$query3="SELECT * FROM products WHERE link LIKE '%vividgold%' AND link!=''";
}else if($website=='shopnbuy'){
	$query3="SELECT * FROM products WHERE link LIKE '%shopnbuy%' AND link!=''";
}else if($website=='onestopautogarage'){
	$query3="SELECT * FROM products WHERE link LIKE '%onestopautogarage%' AND link!=''";
}else if($website=='camerasafrica'){
	$query3="SELECT * FROM products WHERE link LIKE '%camerasafrica%' AND link!=''";
}
else if($website=='others'){
	$query3="SELECT * FROM products WHERE link NOT LIKE '%phonestablets%' AND link NOT LIKE '%kenyatronics%' AND link NOT LIKE '%ramtons%' AND link NOT LIKE '%ballytech%' AND link NOT LIKE '%vividgold%' AND link NOT LIKE '%shopnbuy%' AND link NOT LIKE '%onestopautogarage%' AND link NOT LIKE '%camerasafrica%' AND link!=''";
}

echo $query3;

$query_run3=mysqli_query($db_link,$query3);

$number_of_products=mysqli_num_rows($query_run3);

echo "Total number of products: <strong>".$number_of_products."</strong>    ";

if (isset($_GET['id'])){
$id_received = $_GET['id'];
}else{
$id_received = 0;
}

$offset_id = $id_received;

if($offset_id<=$number_of_products){


if ( !isset($_GET['brand']) && !isset($_GET['category']) )
{
$query2=$query3." ORDER BY id DESC LIMIT ".$offset_id.",50 ";
}

//$query2="SELECT * FROM products WHERE category='phones' ORDER BY brand DESC LIMIT ".$offset_id.",50 ";






$query_run2=mysqli_query($db_link,$query2);

$number_of_products=mysqli_num_rows($query_run2);

echo "Number of products selected: <strong>".$number_of_products."</strong><br/>";

while($row=mysqli_fetch_assoc($query_run2)){

	$website_url=$row['link'];
	$product_id=$row['id'];
	$product_price=$row['price'];

	//if(strpos( $website_url , 'phonestablets' ) === false ){


		$html = file_get_html($website_url);

		if(!empty($html)){



			//echo $html->find('title',0)->plaintext;

			$value=$html->find('.price',0);

			if(empty($value)){
				$price_from_website='0';
				echo 'No price found on this link-';
			}else{
			if(isset($value->find('bdi',0)->plaintext)){
				$price_from_website = $value->find('bdi',0)->plaintext;
			}else if(isset($value->find('.amount',0)->plaintext)){
				$price_from_website = $value->find('.amount',0)->plaintext;
			}
			else{
				$price_from_website = $value->find('.amount',1)->plaintext;
			}


			}

			if(strpos($website_url, 'shopnbuy')!==false){
				$value=$html->find('p[class="price"]',0);
				if($value->find('bdi',1)){
					$price_from_website = $value->find('bdi',1)->plaintext;
				}else{
					$price_from_website = $value->find('bdi',0)->plaintext;
				}
				
			}




$strip_ksh = str_replace('KShs', '', $price_from_website);
			$strip_ksh = str_replace('KSh.', '', $strip_ksh);
			$strip_ksh = str_replace('KSh', '', $strip_ksh);
			$strip_ksh = str_replace('KES', '', $strip_ksh);
			$strip_comma = str_replace(',', '', $strip_ksh);
			$strip_nbsp = str_replace('&nbsp;', '', $strip_comma);
			$strip_space = str_replace(' ', '', $strip_nbsp);
			
			

				$strip_outofstock = str_replace('OutOfStock', '', $strip_space);
			$trim_outofstock = trim($strip_outofstock);

			$int_price = (int)$trim_outofstock;


echo $product_id."---<a href='".$website_url."' target='_blank'>".$website_url."</a> ---- ".$product_price."---".$int_price;



if($int_price!=0){
	/* UPDATE PRICES
	$update_prices_query="UPDATE `products` SET price='".$int_price."' WHERE id=".$product_id;
	if(mysqli_query($db_link,$update_prices_query)){
		echo "----UPDATED";
	}

	*/
	//only update if the price is different	
	if($int_price!=$product_price){
		echo "DIFFERENT";


					//profit calculated
			$calculated_profit = floor($int_price*0.03);
			$profit_over_hundred=($int_price*0.03)%100;

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

echo "</br>";

}  //empty html



}

$next_offset_id=$offset_id+50;

echo "<a href='update-prices.php?id=".($offset_id-50);
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
if(isset($_GET['website'])){
	echo "&website=".$website;
}
echo "'><button type='button' class='btn btn-primary'>Previous List of Prices</button></a>";



echo "<a href='update-prices.php?id=".$next_offset_id;
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
if(isset($_GET['website'])){
	echo "&website=".$website;
}
echo "'><button type='button' class='btn btn-primary'>Next List of Prices</button></a>";


echo "<a href='update-prices.php?id=".$offset_id;
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
if(isset($_GET['website'])){
	echo "&website=".$website;
}
echo "&update=true'><button type='button' class='btn btn-primary'>Current List Update of Prices</button></a>";

echo "<a href='update-prices.php?id=".$next_offset_id;
if(isset($_GET['category'])){
	echo "&category=".$category_received;
}
if(isset($_GET['brand'])){
	echo "&brand=".$brand_received;
}
if(isset($_GET['website'])){
	echo "&website=".$website;
}
echo "&update=true'><button type='button' class='btn btn-primary'>Next Update of Prices</button></a>";



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
include '../../footer.php'; 



?>