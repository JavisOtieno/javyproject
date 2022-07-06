<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {



	$productId = $_POST['productId'];
	$productName 		= $_POST['editProductName']; 
  $cost 			= $_POST['editCost'];
  $commission 			= $_POST['editCommission'];
  $price 					= $_POST['editRate'];
  $description = addslashes(nl2br($_POST['editDescription']));
  $brandName 			= $_POST['editBrandName'];
  $categoryName 	= $_POST['editCategoryName'];
  $productStatus 	= $_POST['editProductStatus'];

  $user_id=$_POST['user_id'];

//   $profit=($price-$cost)*0.6;

  	$sql2 = "SELECT supplier_id FROM products WHERE id = $productId";
	$result = $connect->query($sql2);
	$row = $result->fetch_array();
	$supplier_id=$row['supplier_id'];

	
	if($supplier_id==$user_id){			
	$sql = "UPDATE products SET name = '$productName',price='$price',profit='$commission',cost='$cost',category='$categoryName',brand='$brandName',status='$productStatus', highlights='$description' WHERE id = $productId ";
}else{
	$sql = "UPDATE more_suppliers SET price='$price',profit='$commission',cost='$cost' WHERE product_id = $productId AND supplier_id=$user_id ";
}

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating product info";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);
 
