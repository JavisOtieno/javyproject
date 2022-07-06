<?php



require('connect.inc.php');

require('subdomain_storename.php');



//getting the phone number
//$query="SELECT * FROM `suppliers` WHERE `storename` ='$storename'";

$query="SELECT * FROM `suppliers` WHERE `username` ='$username'";


$query_run=mysqli_query($db_link,$query);
if(mysqli_num_rows($query_run)==0){
	echo "<script type='text/javascript'>
window.location.href = 'not-found.php';
</script>";
}
if($row=mysqli_fetch_assoc($query_run)){



	$phone_number=$row['phone'];
	$email=$row['email'];
	if(strlen($email)<1){
		$email="info@javy.co.ke";
	}
	$supplier=$row['id'];
	$fullname=$row['username'];
	$products_type=$row['products'];
	$facebook_pixel_code=$row['facebook_pixel_code'];
	$google_tag_code=$row['google_tag_code'];

	if (strpos($phone_number, '254')!==false){
		$whatsapp_phone_number=$phone_number;
	}else{
		$whatsapp_phone_number='254'.$phone_number;
	}
	

}


?>