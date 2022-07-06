<?php

include 'header.php';

if( (isset($_GET['category'])) && (isset($_GET['brand'])) ) {

	$category=$_GET['category'];
	$brand=$_GET['brand'];

	if($category=='offers'&&$brand=='offers'){

		$files = scandir('../javy-promote/assests/images/offers/');

//localhost code for testing purposes
//$files = scandir('../stock-2/assests/images/offers');

sort($files); // this does the sorting
foreach($files as $file){
	if($file==".." || $file=="." ){

	}else{
   echo'<a href="display-image.php?source=../javy-promote/assests/images/offers/'.$file.'"><img style="width:200px;height:200px;" src="http://promote.javy.co.ke/assests/images/offers/'.$file.'"></img></a>';
     //localhost code for testing purposes
   //echo'<a href="display-image.php?source=../stock-2/assests/images/offers/'.$file.'"><img style="width:200px;height:200px;" src="../stock-2/assests/images/offers/'.$file.'"></img></a>';
}

 

}

	}
	else{
		$files = scandir('../javy-promote/assests/images/product-images/'.$category.'/'.$brand.'/');

//localhost code for testing purposes
//$files = scandir('../stock-2/assests/images/product-images/'.$category.'/'.$brand.'/');

sort($files); // this does the sorting
foreach($files as $file){
	if($file==".." || $file=="." ){

	}else{
   echo'<a href="display-image.php?file='.$file.'&source=../javy-promote/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"><img style="width:200px;height:200px;" src="http://promote.javy.co.ke/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"></img></a>';
      //localhost code for testing purposes
   //echo'<a href="display-image.php?file='.$file.'&category='.$category.'&brand='.$brand.'&source=../stock-2/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"><img style="width:200px;height:200px;" src="../stock-2/assests/images/product-images/'.$category.'/'.$brand.'/'.$file.'"></img></a>';
}



}
	}



}
else{
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