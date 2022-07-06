<?php 

require_once 'core.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$shop_type = $_POST['shop_type'];
	//$userId = $_POST['user_id'];

			$updateSql = "UPDATE users SET shop_type= '$shop_type' WHERE user_id = {$userId}";
			if($connect->query($updateSql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully Updated";		
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while updating shop type ".$shop_type." ".$userId;	
			}

		

	$connect->close();

	echo json_encode($valid);

}

?>