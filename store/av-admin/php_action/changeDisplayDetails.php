<?php 

require_once 'core.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$display_email = $_POST['display_email'];
	$display_phone = $_POST['display_phone'];
	$userId = $_POST['user_id'];

			$updateSql = "UPDATE users SET display_phone = '$display_phone',display_email = '$display_email' WHERE user_id = {$userId}";
			if($connect->query($updateSql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully Updated";		
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while updating display details";	
			}

		

	$connect->close();

	echo json_encode($valid);

}

?>