<?php
include 'core.php';
?>
<html>
<head>
</head>
<body>

<?php

//timezone meant to align created on
date_default_timezone_set("Africa/Nairobi");

$totalMoneyOwed=0;
$numberofPromotersOwed=0;

require 'connect.inc.php';

$query='SELECT * FROM users';

$query_run=mysqli_query($db_link,$query);




while($row=mysqli_fetch_assoc($query_run)){

	$userId=$row['user_id'];

	$name=$row['storename'];

	echo $name." testing<br/>";

	$query_2='SELECT * FROM users';
$query_run_2=mysqli_query($db_link,$query_2);
while($row_2=mysqli_fetch_assoc($query_run_2)){

	if($name==$row_2['storename']&&$userId!=$row_2['user_id']){
		echo "  --  ".$name." matches twice.";
	}

}


	


}