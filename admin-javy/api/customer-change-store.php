<?php
require('../connect.inc.php');


if($_GET) {		

	$customer_id = $connect->real_escape_string($_GET['customer_id']);
	$dealer_id = $connect->real_escape_string($_GET['dealer_id']);
	//$confirm_password = $connect->real_escape_string($_GET['confirm_password']);


		$password = md5($password);

	$mainSql = "UPDATE customers SET dealerid='$dealer_id' WHERE id=".$customer_id;

	if($mainResult = $connect->query($mainSql)) {
			$valid['success']=true;
			$valid['message']="Store Updated";

	}else{
		$valid['success']=false;
		$valid['message']="Error updating store";

	}

	
	

}else{
	$valid['success']=false;
	$valid['message']="Select a store";
}

echo json_encode($valid);