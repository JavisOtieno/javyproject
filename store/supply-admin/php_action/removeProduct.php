<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$productId = $_POST['productId'];

if($productId) { 

$sql = "SELECT supplier_id FROM products WHERE id=".$productId;
$query = $connect->query($sql);
$result = $query->fetch_assoc();
$supplier_id=$result['supplier_id'];


if($userId==$supplier_id){
	 $sql = "UPDATE products SET status = 3 WHERE id = {$productId}";
	}else{
	 $sql = "DELETE FROM more_suppliers WHERE product_id = {$productId} AND supplier_id={$userId}";
	}


 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST