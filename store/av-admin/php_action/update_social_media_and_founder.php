<?php 

require_once 'core.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$facebook_link = $_POST['facebook_page'];
	$instagram_link = $_POST['instagram_link'];
	$twitter_link = $_POST['twitter_profile'];
	$show_founder = $_POST['founder_ceo'];
	$userId = $_POST['user_id'];

			$updateSql = "UPDATE users SET facebook_link = '$facebook_link',instagram_link = '$instagram_link',twitter_link = '$twitter_link',show_founder = '$show_founder'  WHERE user_id = {$userId}";
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