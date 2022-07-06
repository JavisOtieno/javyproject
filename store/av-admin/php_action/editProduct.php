<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$productId = $_POST['productId'];
	$productName 		= addslashes($_POST['editProductName']); 
  $cost 			= $_POST['editCost'];
  $price 					= $_POST['editRate'];
  $commission				= $_POST['editCommission'];
  $description = addslashes(nl2br($_POST['editDescription']));
  $brandName 			= $_POST['editBrandName'];
  $categoryName 	= $_POST['editCategoryName'];
  $productStatus 	= $_POST['editProductStatus'];
  $approvalStatus = $_POST['editApprovalStatus'];

   $profit=($price-$cost)*0.6;

				
	$sql = "UPDATE products SET name = '$productName',price='$price',profit='$commission',cost='$cost',category='$categoryName',brand='$brandName',status='$productStatus', highlights='$description',approval='$approvalStatus' WHERE id = $productId ";

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
 
