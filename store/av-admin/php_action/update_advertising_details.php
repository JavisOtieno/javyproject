<?php 

require_once 'core.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$facebook_pixel_code = $_POST['facebook_pixel_code'];
	$google_tag_code = $_POST['google_tag_code'];
	$userId = $_POST['user_id'];

			$updateSql = "UPDATE users SET facebook_pixel_code = '$facebook_pixel_code',google_tag_code = '$google_tag_code' WHERE user_id = {$userId}";
			
			if($connect->query($updateSql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully Updated";		
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while updating the password";	
			}

		

	$connect->close();

	echo json_encode($valid);

}

?>