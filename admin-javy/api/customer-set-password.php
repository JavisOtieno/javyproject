<?php
require('../connect.inc.php');


if($_GET) {		

	$customer_id = $connect->real_escape_string($_GET['customer_id']);
	$password = $connect->real_escape_string($_GET['password']);
	$confirm_password = $connect->real_escape_string($_GET['confirm_password']);


	if($password!=$confirm_password){
		$valid['success']=false;
		$valid['message']="Passwords don't match";
	}else{

		$password = md5($password);

		$mainSql = "UPDATE customers SET password='$password' WHERE id=".$customer_id;

		if($mainResult = $connect->query($mainSql)) {
			$valid['success']=true;
			$valid['message']="Password Updated";

	}else{
		$valid['success']=false;
		$valid['message']="Error updating password";

	}

	}
	

}else{
	$valid['success']=false;
	$valid['message']="Enter Passwords";
}

echo json_encode($valid);