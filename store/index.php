<?php include 'header.php' ?>

<?php

if($shop_type==0){
	include 'home-pages/all-products-home-page.php';
	include 'footer.php';
} else if ($shop_type==2) {
	include 'home-pages/electronics-home-page.php';
	include 'footer.php';
}else if ($shop_type==3) {
	include 'home-pages/fashion-home-page.php';
	include 'footer.php';
}else if ($shop_type==1 || $shop_type==4 ) {
	include 'home-pages/shop-home-page.php';
}


?>


	
	