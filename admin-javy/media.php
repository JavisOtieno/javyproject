<?php

include 'header.php';

if( (isset($_GET['category'])) && (isset($_GET['brand'])) ) {

	$category=$_GET['category'];
	$brand=$_GET['brand'];

	if($category=='offers'&&$brand=='offers'){


$files = scandir('../store/admin/assests/images/offers/');
//localhost code for testing purposes
//$files = scandir('../stock-2/assests/images/offers');

sort($files); // this does the sorting
foreach($files as $file){
	if($file==".." || $file=="." ){

	}else{
   echo'<a href="display-image.php?source=../store/admin/assests/images/offers/'.$file.'"><img style="width:200px;height:200px;" src="https://promote.javy.co.ke/assests/images/offers/'.$file.'"></img></a>';
     //localhost code for testing purposes
   //echo'<a href="display-image.php?source=../stock-2/assests/images/offers/'.$file.'"><img style="width:200px;height:200px;" src="../stock-2/assests/images/offers/'.$file.'"></img></a>';
}

}
echo "offers----offers";

	}else if($category=='all-products'){


		function getDirContents($path) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

    $files = array(); 
    foreach ($rii as $file)
        if (!$file->isDir())
            $files[] = $file->getPathname();

    return $files;
	}

	$files=(getDirContents('../store/admin/assests/images/product-images/'));


		//$files = scandir('../store/admin/assests/images/product-images/');
//localhost code for testing purposes
//$files = scandir('../stock-2/assests/images/offers');

sort($files); // this does the sorting
foreach($files as $file){
	if($file==".." || $file=="." ){

	}else{

		$file_name_on_database=str_replace('/store/admin', '', $file);

$sql="SELECT * FROM products WHERE image='".$file_name_on_database."'";
$query_run=mysqli_query($db_link,$sql);
if($row=mysqli_fetch_assoc($query_run)){
	$product_name=$row['name'];
	$product_id=$row['id'];

}else{
	$product_name='NOT ON DATABASE';
	$product_id=0;
}



		$file_name=str_replace('../store/admin/assests/images/product-images/', '', $file);

   echo '<div style="display:inline-block;text-align: center;width: 220px;"><a href="display-image.php?source='.$file.'"><img style="width:200px;height:200px;" src="https://promote.javy.co.ke/assests/images/product-images/'.$file_name.'"></img></a><span style="display: block;">'.$product_name.'</span><a target="_blank" href="edit/edit-product.php?product_id='.$product_id.'"><button>View Product</button></a></div>';




     //localhost code for testing purposes
   //echo'<a href="display-image.php?source=../stock-2/assests/images/offers/'.$file.'"><img style="width:200px;height:200px;" src="../stock-2/assests/images/offers/'.$file.'"></img></a>';


}

}

	}
	else{
		$files = scandir('../store/admin/assests/images/product-images/'.$category.'/'.$brand.'/');

//localhost code for testing purposes
//$files = scandir('../stock-2/assests/images/product-images/'.$category.'/'.$brand.'/');

sort($files); // this does the sorting
foreach($files as $file){
	if($file==".." || $file=="." ){

	}else{

				$file_name_on_database='../assests/images/product-images/'.$category.'/'.$brand.'/'.$file;

$sql="SELECT * FROM products WHERE image='".$file_name_on_database."'";
$query_run=mysqli_query($db_link,$sql);
if($row=mysqli_fetch_assoc($query_run)){
	$product_name=$row['name'];
	$product_id=$row['id'];

}else{
	$product_name='NOT FOUND '.$file;
	$product_id=0;
}

   //echo '<a href="display-image.php?file='.$file.'&source=../store/admin/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"><img style="width:200px;height:200px;" src="http://promote.javy.co.ke/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"></img></a>';
   echo '<div style="display:inline-block;text-align: center;width: 220px;"><a href="display-image.php?file='.$file.'&source=../store/admin/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"><img style="width:200px;height:200px;" src="https://promote.javy.co.ke/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"></img></a><span style="display: block;">'.$product_name.'</span><a target="_blank" href="edit/edit-product.php?product_id='.$product_id.'"><button>View Product</button></a></div>';
      //localhost code for testing purposes
   //echo'<a href="display-image.php?file='.$file.'&category='.$category.'&brand='.$brand.'&source=../stock-2/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"><img style="width:200px;height:200px;" src="../stock-2/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"></img></a>';
}



}
	}



}
else{
echo '<br/><strong>PRODUCTS</strong><br/>';
echo '<a href="media.php?category=all-products&brand=all-products"><button>All Products</button></a>';


echo '<br/><strong>OFFERS</strong><br/>';
echo '<a href="media.php?category=offers&brand=offers"><button>Offers</button></a>';

$sql_categories="SELECT * FROM categories";

$query_run_categories=mysqli_query($db_link,$sql_categories);

while($row_category=mysqli_fetch_assoc($query_run_categories)){

	echo '<br/><strong>'.$row_category['categories_name'].'</strong><br/>';
	$categories_slug=$row_category['categories_slug'];

$sql_brands="SELECT * FROM brands WHERE brand_category=".$row_category['categories_id'];
$query_run_brands=mysqli_query($db_link,$sql_brands);


while($row_brand=mysqli_fetch_assoc($query_run_brands)){

	$brand_slug=$row_brand['brand_slug'];

	echo '<a href="media.php?category='.$categories_slug.'&brand='.$brand_slug.'"><button>'.$brand_slug.'</button></a>';

}	

}

}




include 'footer.php';

?>