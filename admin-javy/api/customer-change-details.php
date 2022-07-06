<?php
require('../connect.inc.php');


if($_GET) {		

	$customer_id = $connect->real_escape_string($_GET['customer_id']);
	$name = $connect->real_escape_string($_GET['name']);
	$phone = $connect->real_escape_string($_GET['phone']);
	$email = $connect->real_escape_string($_GET['email']);
	$delivery_details = $connect->real_escape_string($_GET['delivery_details']);
	//$confirm_password = $connect->real_escape_string($_GET['confirm_password']);


		$password = md5($password);

	$mainSql = "UPDATE customers SET name='$name',phone='$phone',email='$email',deliverydetails='$delivery_details' WHERE id=".$customer_id;

	if($mainResult = $connect->query($mainSql)) {
			$valid['success']=true;
			$valid['message']="Store Updated";

	}else{
		$valid['success']=false;
		$valid['message']="Error updating store";

	}

	
	

}else{
	$valid['success']=false;
	$valid['message']="Enter Details";
}

echo json_encode($valid);