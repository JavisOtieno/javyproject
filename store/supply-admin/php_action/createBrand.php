<?php 	$date=date('d/m/Y \a\t h:iA', strtotime('+1 hours'));

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

$userId = $_SESSION['supplierId'];

if($_POST) {	

	$withdrawalAmount = $_POST['brandName'];
	$withdrawalMethod = $_POST['brandStatus']; 
	$revenue = $_POST['revenue']; 

	$sql = "INSERT INTO withdrawals (withdrawal_id, user_id, amount, method, date,status) VALUES (NULL,'$userId','$revenue', '$withdrawalMethod','$date', 0)";


		

	//$sql = "INSERT INTO withdrawals (withdrawal_id, user_id, amount, method, date,status) VALUES (NULL,'$userId','$withdrawalAmount', '$withdrawalMethod', '$date', 0)";

	if($connect->query($sql) === TRUE) {

		//$withdrawal_id = $connect->insert_id;

	

		//PHP MAIL DOES NOT WORK ON LOCALHOST. UNCOMMENT ON UPLOAD      
$to      = 'javisotieno@gmail.com';
$subject = 'Withdrawal by: promoter id '.$userId;
$headers = 'From: info@javytech.co.ke' 
.'
'.
    'Reply-To: info@javytech.co.ke' 
    .'
    '.
    'X-Mailer: PHP/' . phpversion();
$message =  (
            'Withdrawal Amount: '.$revenue
            .'
            '.
            'Date: '.$date
            .'
            '.
            'Withdrawal Method: '.$withdrawalMethod
            .'
            '.
            'Promoter Id: '.$userId
            .'
            ');
mail($to, $subject, $message, $headers);




	 	$valid['success'] = true;
		$valid['messages'] = "Withdrawal successful";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while processing withdrawal";
	}
	 

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST