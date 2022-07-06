<?php 

require_once 'core.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$products = $_POST['products'];
	$userId = $_POST['user_id'];

	if($products==1){
		$shop_type=0;
	}
	else if($products==0){
		$shop_type=4;
	}


	$sql = "UPDATE suppliers SET products = '$products' WHERE id = {$userId}";

	$sql2 = "UPDATE users SET shop_type = '$shop_type' WHERE supplier_registered_on = {$userId}";

	if($connect->query($sql) === TRUE && $connect->query($sql2) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating information";
	}

	$connect->close();

	echo json_encode($valid);

}

?>