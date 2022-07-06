<?php 	

require('connect.inc.php');
require('subdomain_storename.php');


$valid['success'] = array('success' => false, 'messages' => array());

if($_GET) {

	$orderId = $connect->real_escape_string($_GET['orderId']);

	$sql_deal = "SELECT * FROM deals WHERE id = {$orderId}";
	$query_order=mysqli_query($db_link,$sql_deal);

	 if($row=mysqli_fetch_assoc($query_order)){
	 	$customer_password=$row['password'];
	 }



 			
	$sql = "UPDATE deals SET status='2' WHERE id = {$orderId}";

	if	($connect->query($sql)){
	$valid['success'] = true;
	$valid['messages'] = "Successfully Updated";
	}else{
	$valid['success'] = false;
	$valid['messages'] = "Error updating order";
	}

	header('location: orders.php');
		
	$connect->close();

	echo json_encode($valid);
 
}

 // /if $_POST
// echo json_encode($valid);