<?php
include '../../header.php';
include('../simple_html_dom.php');




if (isset($_GET['type'])){
$type = $_GET['type'];
}else{
$type = 'all';
}

echo '<form method="GET" action="products-list.php" id="linkForm">';

    echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Link:</label>';
	echo '<input class="form-control" name="link" ></input></div>';

	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    cursor: pointer;" type="submit" value="SUBMIT" /></div></div></div></form>';

    echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://www.ballytechelectronics.co.ke/shop/"><button>Ballytech</button></a></div>';
    echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://sweech.co.ke/shop/"><button>Sweech</button></a></div>';
    echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://phoneplacekenya.com/shop/"><button>Phoneplacekenya</button></a></div>';
    echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://saruk.co.ke/shop/"><button>Saruk</button></a></div>';
    echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://smartdigital.co.ke/shop"><button>Smartdigital</button></a></div>';


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
  echo '<a class="dropdown-item" href="products-list.php?link=https://www.phonestablets.co.ke/search/'.$category_key.'">All '.ucfirst($row_category['categories_name']).'</a>';

$sql_brands="SELECT * FROM brands WHERE brand_category=".$row_category['categories_id'];
$query_run_brands=mysqli_query($db_link,$sql_brands);


while($row_brand=mysqli_fetch_assoc($query_run_brands)){

	$brand_slug=$row_brand['brand_slug'];
	$brand_name=$row_brand['brand_name'];

	echo '<a class="dropdown-item" href="products-list.php?link=https://www.phonestablets.co.ke/search/'.$brand_slug.'">'.$brand_name.'</a>';

}	
echo '
  </div>
</div>';

}



	if (isset($_GET['link'])){
$setlink = $_GET['link'];
}else{
$setlink = 'https://www.ballytechelectronics.co.ke/shop/';
}




echo '<br/><div style="display:inline-block;margin:10px;"><a href="https://www.ballytechelectronics.co.ke/shop/"><button>All Products</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?type=available&link='.$setlink.'"><button>Available Products</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?type=unavailable&link='.$setlink.'"><button>Unavailable Products</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?type=coming-soon&link='.$setlink.'"><button>Coming Soon Unavailable Products</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?type=released-unavailable&link='.$setlink.'"><button>Released Unavailable Products</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?type=released-out-of-stock&link='.$setlink.'"><button>Released Unavailable Out Of Stock Products</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?type=released-in-stock&link='.$setlink.'"><button>Released Unavailable In Stock Products</button></a></div><br/>';





	$html = file_get_html($setlink);



	//0 makes for the 1st entry
	//$link_from_website = $html->find('a[class="pt_prod_card"]',0)->attr['href'];

	

		# code...
		if($type=='all'){

foreach ($html->find('.product') as $link) {

	/*echo $link->plaintext;
		
		$website_url=str_replace('https://www.ballytechelectronics.co.ke', ' ', $link_from_supplier);
		echo "<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";*/


		if(($link->find('h1', 0))) {
    $product_title=$link->find('h1',0)->plaintext;
    }else if(($link->find('h2', 0)))
    {
    $product_title=$link->find('h2',0)->plaintext;
    }else if(($link->find('h3', 0)))
    {
    $product_title=$link->find('h3',0)->plaintext;
    }else if(($link->find('h4', 0)))
    {
    $product_title=$link->find('h4',0)->plaintext;
    echo 'passes here';
    }else if(($link->find('.product-title',0))){
    	$product_title=$link->find('.product-title',0)->plaintext;
    	echo 'passes here';
    }
			/*
			foreach ($link->find('.amount') as $link4) {
			$product_price = $link4->plaintext;
			}
			*/	

		/*
		$product_title=$link->find('h2[class="woocommerce-loop-product__title"]',0)->plaintext;
		*/
		if(($link->find('.amount',0))){
			$product_price=$link->find('.amount',0)->plaintext; 
		}else{
			$product_price="PRICE NOT AVAILABLE";
		}
		
		if($link->find('.woocommerce-LoopProduct-link',0)){
			$product_link=$link->find('.woocommerce-LoopProduct-link',0)->attr['href'];
		}else if($link->find('a',0)){

			//if first link is category tag as on saruk.co.ke
			if(isset($link->find('a',0)->attr['rel'])){
				$product_link=$link->find('a',1)->attr['href'];
			}else{
				$product_link=$link->find('a',0)->attr['href'];
			}
			

		}
		

		echo "- <a href='".$product_link."' target='_blank'>".$product_title."</a>--".$product_price." --- ";
		
		
		/*if( strpos( $link->plaintext , "Coming Soon" ) !== false) {
			echo "--COMING SOON--";
		}else{
			echo "--RELEASED--";
		}*/

		$query2="SELECT * FROM products WHERE link='".$product_link."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){
			echo "NOT ON SITE - <a href='add-product.php?link=".$product_link."' target='_blank'>ADD</a>";
		}else{
			echo "ON SITE";
		}
		echo "<br/>";

	}

		}

				else if ($type=='available'){

foreach ($html->find('.product') as $link) {

	/*echo $link->plaintext;
		
		$website_url=str_replace('https://www.ballytechelectronics.co.ke', ' ', $link_from_supplier);
		echo "<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";*/

		foreach ($link->find('h2') as $link2) {
			$product_title=$link2->plaintext;
		}

		if(($link->find('h1', 0))) {
    $product_title=$link->find('h1',0)->plaintext;
    }else if(($link->find('h2', 0)))
    {
    $product_title=$link->find('h2',0)->plaintext;
    }else if(($link->find('h3', 0)))
    {
    $product_title=$link->find('h3',0)->plaintext;
    }else if(($link->find('h4', 0)))
    {
    $product_title=$link->find('h4',0)->plaintext;
    }

		if(($link->find('.amount',0))){
			$product_price=$link->find('.amount',0)->plaintext; 
		}else{
			$product_price="PRICE NOT AVAILABLE";
		}
		

		$product_link=$link->find('a',0)->attr['href'];

		

		$query2="SELECT * FROM products WHERE link='".$product_link."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)!=0){
			echo "- <a href='".$product_link."' target='_blank'>".$product_title."</a>--".$product_price." --- ";
			echo "<br/>";
		}
		

	}
		}


				else if ($type=='unavailable'){

foreach ($html->find('.product') as $link) {

	/*echo $link->plaintext;
		
		$website_url=str_replace('https://www.ballytechelectronics.co.ke', ' ', $link_from_supplier);
		echo "<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";*/

		if(($link->find('h1', 0))) {
    $product_title=$link->find('h1',0)->plaintext;
    }else if(($link->find('h2', 0)))
    {
    $product_title=$link->find('h2',0)->plaintext;
    }else if(($link->find('h3', 0)))
    {
    $product_title=$link->find('h3',0)->plaintext;
    }else if(($link->find('h4', 0)))
    {
    $product_title=$link->find('h4',0)->plaintext;
    }

		if(($link->find('.amount',0))){
			$product_price=$link->find('.amount',0)->plaintext; 
		}else{
			$product_price="PRICE NOT AVAILABLE";
		}
		

		$product_link=$link->find('.woocommerce-LoopProduct-link',0)->attr['href'];

		

		$query2="SELECT * FROM products WHERE link='".$product_link."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){
			echo "- <a href='".$product_link."' target='_blank'>".$product_title."</a>--".$product_price." --- - <a href='add-product.php?link=".$product_link."' target='_blank'>ADD</a>";
			echo "<br/>";
		}
		

	}
		}

		else if ($type=='coming-soon'){

		foreach ($html->find('a[class="pt_prod_card"]') as $link) {

		$link_from_supplier=$link->attr['href'];
		
		
		if( strpos( $link->plaintext, "Coming Soon" ) !== false) {
			$website_url=str_replace('https://www.phonestablets.co.ke', ' ', $link_from_supplier);
			echo "<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";
			echo "--COMING SOON--";

			$query2="SELECT * FROM products WHERE link='".$link_from_supplier."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){
			echo "NOT ON SITE";
		}
		echo "<br/>";

		}
	}

		}

		else if ($type=='released-unavailable'){

			foreach ($html->find('a[class="pt_prod_card"]') as $link) {

		$link_from_supplier=$link->attr['href'];
		
		
		if( strpos( $link->plaintext, "Coming Soon" ) == false) {
			$website_url=str_replace('https://www.phonestablets.co.ke', ' ', $link_from_supplier);
			

			$query2="SELECT * FROM products WHERE link='".$link_from_supplier."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){
			echo "<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";
			echo "--RELEASED--";
			echo "NOT ON SITE";
			echo "<br/>";
		}
		

		}
		}
	}
		
		else if ($type=='released-out-of-stock'){

			if(isset($_GET['count'])){
				$count=$_GET['count'];
				
			}else{
				$count=0;
			}
			$original_count=$count;

			$count_loops=0;

			echo "count".$count;
			

			foreach ($html->find('a[class="pt_prod_card"]') as $link) {

		$link_from_supplier=$link->attr['href'];
		$website_url=str_replace('https://www.phonestablets.co.ke', ' ', $link_from_supplier);

		
		if( strpos( $link->plaintext, "Coming Soon" ) == false) {
			
			

		$query2="SELECT * FROM products WHERE link='".$link_from_supplier."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){

			
			$count_loops++;

			if($count_loops>$original_count){
			
			$count++;

			$html2 = file_get_html($link_from_supplier);

			$website_url=str_replace('https://www.phonestablets.co.ke', ' ', $link_from_supplier);

			//echo $html->find('title',0)->plaintext;

			$price_from_website = $html2->find('div[class="disp-table"]',0)->plaintext;

			$strip_ksh = str_replace('Ksh.', '', $price_from_website);
			$strip_comma = str_replace(',', '', $strip_ksh);
			$strip_nbsp = str_replace('&nbsp;', '', $strip_comma);
			$strip_space = str_replace(' ', '', $strip_nbsp);


			if( strpos( $strip_space, "OutOfStock" ) !== false) {

				$strip_outofstock = str_replace('OutOfStock', '', $strip_space);
			$trim_outofstock = trim($strip_outofstock);

			$int_price = (int)$trim_outofstock;
			if($int_price!=0){
				echo $count."----<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";
			echo "--RELEASED--";
			echo "NOT ON SITE";
				echo "---".$int_price."---"."Out Of Stock";
				echo "<br/>";

				
				}
			
			}

			

			
			}


			if($count_loops % 50 == 0 && $count_loops>$original_count){
					echo '<a href="products-list.php?type=released-out-of-stock&link='.$setlink.'&count='.$count.'"><button>Next</button></a>';
					break;


			}

			}

		}

		

		}


	}

		else if ($type=='released-in-stock'){

			if(isset($_GET['count'])){
				$count=$_GET['count'];
				
			}else{
				$count=0;
			}
			$original_count=$count;

			$count_loops=0;

			echo "count".$count;

		foreach ($html->find('a[class="pt_prod_card"]') as $link) {	

		$link_from_supplier=$link->attr['href'];
		$website_url=str_replace('https://www.phonestablets.co.ke', ' ', $link_from_supplier);
		
		
		if( strpos( $link->plaintext, "Coming Soon" ) == false) {
			

		$query2="SELECT * FROM products WHERE link='".$link_from_supplier."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){
			
			$count_loops++;

			if($count_loops>$original_count){
			
			$count++;


			$html2 = file_get_html($link_from_supplier);

			//echo $html->find('title',0)->plaintext;

			$price_from_website = $html2->find('div[class="disp-table"]',0)->plaintext;

			$strip_ksh = str_replace('Ksh.', '', $price_from_website);
			$strip_comma = str_replace(',', '', $strip_ksh);
			$strip_nbsp = str_replace('&nbsp;', '', $strip_comma);
			$strip_space = str_replace(' ', '', $strip_nbsp);

			if( strpos( $strip_space, "OutOfStock" ) == false) {

				$strip_outofstock = str_replace('OutOfStock', '', $strip_space);
			$trim_outofstock = trim($strip_outofstock);

			$int_price = (int)$trim_outofstock;
			if($int_price!=0){
				echo $count."----<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";
			echo " <a href='add-product.php?link=".$link_from_supplier."'>ADD</a>--RELEASED--";
			echo "NOT ON SITE";
				echo "---".$int_price."---"."In Stock";
				echo "<br/>";
			}


			}
			
			}

		if($count_loops % 50 == 0 && $count_loops>$original_count){

					echo '<a href="products-list.php?type=released-in-stock&link='.$setlink.'&count='.$count.'"><button>Next</button></a>';
					break;


			}

			}

		}
		
		

		}
	}




include '../../footer.php'; 
	



?>