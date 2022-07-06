<?php
require('connect.inc.php');

require('subdomain_storename.php');


//getting the phone number
$query="SELECT * FROM `suppliers` WHERE `username` ='$storename'";

$query_run=mysqli_query($db_link,$query);
if(mysqli_num_rows($query_run)>0){
	echo "<script type='text/javascript'>
window.location.href = 'index.php';
</script>";
}

?>



<div style="margin:20px 40px;text-align: center;">
<h2>This website is unavailable.</h2>
</div>
<div style="margin:20px 40px;text-align: center;">
<h3>Please check whether you typed in the correct website name</h3>
</div>
