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
echo '<br/>';



$query3="SELECT * FROM products WHERE link LIKE '%phonestablets%' AND link!=''";
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

if (isset($_GET['category'])){
$category_received = $_GET['category'];

$query2="SELECT * FROM products WHERE category='".$category_received."' AND link LIKE '%phonestablets%' AND link!='' ORDER BY id DESC LIMIT 300 OFFSET 300 ";



}
if (isset($_GET['brand'])){
$brand_received = $_GET['brand'];

$query2="SELECT * FROM products WHERE category='".$category_received."' AND brand='".$brand_received."' AND supplier_id=1 AND link LIKE '%phonestablets%' AND link!='' ORDER BY id DESC LIMIT 300 OFFSET 300 ";

}
if ( !isset($_GET['brand']) && !isset($_GET['category']) )
{
$query2="SELECT * FROM products WHERE supplier_id=1 AND link LIKE '%phonestablets%' AND link!='' ORDER BY id DESC LIMIT 300 OFFSET 300 ";
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

			if(strpos( $html->plaintext , 'Go to Shop' ) !== false ){

				$price_from_website='0';
				echo "Redirected Link - No price found";
			}else{



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


if(isset($int_price)){
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
						//auto update prices
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


			$scripts = $html->find('script');
		    foreach($scripts as $s) {
		    	//echo 'found scripts';
		        if(strpos($s->innertext, '"isVariable":true') !== false) {
		            $script = $s;
		            //echo "Variable";
		            $productVariable=true;
		        }
		        if(strpos($s->innertext, 'window.pysWooProductData = window.pysWooProductData || [];')&& $check==false){
		        	//echo $s->innertext;
		        	echo "<br>";
		        	$text_to_split=substr($s->innertext, strpos($s->innertext, 'w'));
		        	//echo $text_to_split;

		        	$last_ending_position=strrpos($text_to_split, ',"currency":"KES"}}}',$ending_position);
		        	

		      		$keep_loop=true;
		      		while($keep_loop){

		      		$initial_category_text=$heading_from_website.' - ';
		        	$starting_position=strpos($text_to_split, $initial_category_text,$initial_starting_position );
		        	

		      		$ending_position=strpos($text_to_split, '","category_name"', $starting_position);

		        	//echo 'STARTING'.$starting_position;
		        	//echo 'ENDING'.$ending_position;

		        	$variable_including_name=substr($text_to_split, $starting_position,$ending_position-$starting_position );

		        	$variable = str_replace($initial_category_text,'',$variable_including_name);

		        	$initial_value_splitting_text=',"value":';

		        	$second_starting_position=strpos($text_to_split, $initial_value_splitting_text, $ending_position);

		        	$second_ending_position=strpos($text_to_split, ',"currency":"KES"}}}',$ending_position);
		        	//echo '    2. STARTING'.$second_starting_position;
		        	//echo '    2. ENDING'.$second_ending_position;

		        	$price_including_value=substr($text_to_split, $second_starting_position, $second_ending_position-$second_starting_position);

		        	$price=str_replace($initial_value_splitting_text, '', $price_including_value);

		        	//echo 'variable'.$variable."price".$price.'done'.'<br>';
		        	
		        	    $sql2="UPDATE `variables` SET price='".$price."' WHERE product_id=".$product_id." AND variable='".$variable."'";

    //$sql2='INSERT INTO `variables` VALUES(NULL,'.$product_id.',"'.$variable.'","'.$price.'")';
    

    //echo $sql2;
		        	if (isset($_GET['update'])){

						// UPDATE PRICES
						$update=$_GET['update'];
						if($update=='true'){


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
			    }else{

			    $query_product_variable="SELECT * FROM variables WHERE product_id='".$product_id."' AND variable ='".$variable."'";

			    //echo $query_product_variable;


				$query_run_product_variable=mysqli_query($db_link,$query_product_variable);

				while($row_product_variable=mysqli_fetch_assoc($query_run_product_variable)){
					$current_price=$row_product_variable['price'];
				}
			    	echo $variable." - ".$price."  current_price:".$current_price."current"; 
			    	if($current_price!=$price){
			    		echo "DIFFERENT";
			    	}
			    	echo '<br>';
			    }

		        	$initial_starting_position=$second_ending_position;

		        	if($second_ending_position==$last_ending_position){
		        		$keep_loop=false;
		        	}

		        	}

		        	//echo "THIS IS THE SHIT";




		        	//echo "<br><br>";

		        	$check=true;

		        }
		    }


}

echo "</br>";

}  //empty html



}

$next_offset_id=$offset_id+300;

echo "<a href='update-prices.php?id=".($offset_id-300);
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