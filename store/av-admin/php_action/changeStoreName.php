<?php 

require_once 'core.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$storename = $_POST['storename'];
	$userId = $_POST['user_id'];


	//check if storename exists in database
		$sql = "SELECT * FROM users WHERE storename = '$storename'";
		$result = $connect->query($sql);

		$sql2 = "SELECT * FROM suppliers WHERE username = '$storename'";
		$result2 = $connect->query($sql2);

		if($result->num_rows == 0 && $result2->num_rows == 0 && strtolower($storename)!='javy') {

			$updateSql = "UPDATE users SET storename = '$storename' WHERE user_id = {$userId}";
			if($connect->query($updateSql) === TRUE) {
				$valid['success'] = true;
				$valid['messages'] = "Successfully Updated";		
			} else {
				$valid['success'] = false;
				$valid['messages'] = "Error while updating Store Name";	
			}

		}else{
			$valid['success'] = false;
			$valid['messages'] = "Store name already exists";	

		}



		

	$connect->close();

	echo json_encode($valid);

}

?>