<?php 	

require_once 'db_connect.php';
$db_link=@mysqli_connect($localhost, $username, $password, $dbname);


$valid['success'] = array('success' => false, 'messages' => array());

if($_GET) {

	$productId = $connect->real_escape_string($_GET['productId']);
 			
	$sql = "UPDATE products SET approval='1' WHERE id = {$productId}";

	if	($connect->query($sql)){
	$valid['success'] = true;
	$valid['messages'] = "Successfully Updated";
	}else{
	$valid['success'] = false;
	$valid['messages'] = "Error updating order";
	}

	header('location: ../manage-add-products.php');
		
	$connect->close();

	echo json_encode($valid);
 
}

 // /if $_POST
// echo json_encode($valid);