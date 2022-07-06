<?php
require('connect.inc.php');

require('subdomain_storename.php');


//getting the phone number
$query="SELECT `user_id`,`phone`,`email`,`firstname`,`lastname`,`show_founder`,`created_on`,`facebook_link`,`twitter_link`,`instagram_link`,`profile_picture` FROM `users` WHERE `storename` ='$storename'";
$query_run=mysqli_query($db_link,$query);


$username=$storename;
$query_suppliers="SELECT * FROM `suppliers` WHERE `username` ='$username'";
$query_run_suppliers=mysqli_query($db_link,$query_suppliers);


if(mysqli_num_rows($query_run)>0){
	echo "<script type='text/javascript'>
window.location.href = 'index.php';
</script>";
}else if(mysqli_num_rows($query_run_suppliers)>0){

	echo "<script type='text/javascript'>
window.location.href = 'shop/';
</script>";

	//echo "<div style='margin:20px 40px;text-align: center;'><h2>We're working on this website.</h2></div><div style='margin:20px 40px;text-align: center;''><h3>Please check again in a few hours.</h3>";
}else{
	echo "<div style='margin:20px 40px;text-align: center;'>
<h2>This website is unavailable</h2>
</div>
<div style='margin:20px 40px;text-align: center;'>
<h3>Please check whether you typed in the correct website name</h3>";
}

?>








</div>
