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

    echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://kenyatronics.com/browse/televisions"><button>TVs</button></a></div>';
     echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://kenyatronics.com/browse/home-appliances"><button>Home Appliances</button></a></div>';
    echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://kenyatronics.com/browse/mobile-phones"><button>Phones</button></a></div>';
    echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://kenyatronics.com/browse/sound-systems"><button>Sound Systems</button></a></div>';
    echo '<div style="display:inline-block;margin:10px;"><a href="products-list.php?link=https://www.kenyatronics.com/browse/cameras"><button>Cameras</button></a></div>';


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
  echo '<a class="dropdown-item" href="products-list.php?link=https:/kenyatronics.com/browse/'.$category_key.'">All '.ucfirst($row_category['categories_name']).'</a>';

$sql_brands="SELECT * FROM brands WHERE brand_category=".$row_category['categories_id'];
$query_run_brands=mysqli_query($db_link,$sql_brands);


while($row_brand=mysqli_fetch_assoc($query_run_brands)){

	$brand_slug=$row_brand['brand_slug'];
	$brand_name=$row_brand['brand_name'];

	echo '<a class="dropdown-item" href="products-list.php?link=https:/kenyatronics.com/search/'.$brand_slug.'">'.$brand_name.'</a>';

}	
echo '
  </div>
</div>';

}



	if (isset($_GET['link'])){
$setlink = $_GET['link'];
}else{
$setlink = 'https://www.kenyatronics.com/browse/televisions';
}




echo '<br/><div style="display:inline-block;margin:10px;"><a href="products-list.php?type=all&link='.$setlink.'"><button>All Products</button></a></div>';
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

foreach ($html->find('.item_parent') as $link) {

		$link_from_supplier=$link->find('a',1);
		$website_url="https://www.kenyatronics.com/".$link_from_supplier->attr['href'];
		$website_url_to_display=$link_from_supplier->attr['href'];
		echo "<a href='".$website_url."' target='_blank'>".$website_url_to_display."</a>";
		
		
		if( strpos( $link->plaintext , "Coming Soon" ) !== false) {
			echo "--COMING SOON--";
		}else{
			echo "--RELEASED--";
		}

		$query2="SELECT * FROM products WHERE link='".$website_url."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){
			echo "NOT ON SITE--<a target='_blank' href=add-product.php?link=".$website_url.">ADD</a>";
		}else{

			while($row=mysqli_fetch_assoc($query_run2)){
				$product_id=$row['id'];
			}
			echo " --<a target='_blank' href=product.php?id=".$product_id.">VIEW ON SITE</a> ";
		}
		echo "<br/>";
	

	}

		}


				else if ($type=='unavailable'){

		foreach ($html->find('a[class="pt_prod_card"]') as $link) {

		$link_from_supplier=$link->attr['href'];
		$website_url=str_replace('https:/kenyatronics.com', ' ', $link_from_supplier);

		$query2="SELECT * FROM products WHERE link='".$link_from_supplier."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){

		echo "<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";
		
	
		if( strpos( $link->plaintext, "Coming Soon" ) !== false) {
			echo "--COMING SOON--";
		}else{
			echo "--RELEASED--";
		}

			echo "NOT ON SITE--<a target='_blank' href=add-product.php?link=".$link_from_supplier.">ADD</a>";
			echo "<br/>";
		}

	}
		}

		else if ($type=='coming-soon'){

		foreach ($html->find('a[class="pt_prod_card"]') as $link) {

		$link_from_supplier=$link->attr['href'];
		
		
		if( strpos( $link->plaintext, "Coming Soon" ) !== false) {
			$website_url=str_replace('https:/kenyatronics.com', ' ', $link_from_supplier);
			echo "<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";
			echo "--COMING SOON--";

			$query2="SELECT * FROM products WHERE link='".$link_from_supplier."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){
			echo "NOT ON SITE --<a target='_blank' href=add-product.php?link=".$link_from_supplier.">ADD</a>";
		}
		echo "<br/>";

		}
	}

		}

		else if ($type=='released-unavailable'){

			foreach ($html->find('a[class="pt_prod_card"]') as $link) {

		$link_from_supplier=$link->attr['href'];
		
		
		if( strpos( $link->plaintext, "Coming Soon" ) == false) {
			$website_url=str_replace('https:/kenyatronics.com', ' ', $link_from_supplier);
			

			$query2="SELECT * FROM products WHERE link='".$link_from_supplier."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){
			echo "<a href='".$link_from_supplier."' target='_blank'>".$website_url."</a>";
			echo "--RELEASED--";
			echo "NOT ON SITE -- <a target='_blank' href=add-product.php?link=".$link_from_supplier.">ADD</a>";
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
		$website_url=str_replace('https:/kenyatronics.com', ' ', $link_from_supplier);

		
		if( strpos( $link->plaintext, "Coming Soon" ) == false) {
			
			

		$query2="SELECT * FROM products WHERE link='".$link_from_supplier."'";
		$query_run2=mysqli_query($db_link,$query2);
		if(mysqli_num_rows($query_run2)==0){

			
			$count_loops++;

			if($count_loops>$original_count){
			
			$count++;

			$html2 = file_get_html($link_from_supplier);

			$website_url=str_replace('https:/kenyatronics.com', ' ', $link_from_supplier);

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

			echo "NOT ON SITE --<a target='_blank' href=add-product.php?link=".$link_from_supplier.">ADD</a>";
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
		$website_url=str_replace('https:/kenyatronics.com', ' ', $link_from_supplier);
		
		
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
			echo " <a href='add-product.php?link=".$link_from_supplier."' target='_blank'>ADD</a>--RELEASED--";
			echo "NOT ON SITE --<a target='_blank' href=add-product.php?link=".$link_from_supplier.">ADD</a>";
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