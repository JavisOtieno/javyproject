<?php 	$date=time();

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

$userId = $_SESSION['userId'];

if($_POST) {	

	$withdrawalAmount = $_POST['brandName'];
	$withdrawalMethod = $_POST['brandStatus']; 
	$revenue = $_POST['revenue']; 



	$sql = "INSERT INTO withdrawals (withdrawal_id, user_id, amount, method, date,status) VALUES (NULL,'$userId','$revenue', '$withdrawalMethod','$date', 0)";


		

	//$sql = "INSERT INTO withdrawals (withdrawal_id, user_id, amount, method, date,status) VALUES (NULL,'$userId','$withdrawalAmount', '$withdrawalMethod', '$date', 0)";
if($revenue==0)
{
	
$valid['success'] = false;
$valid['messages'] = "Sorry, you cannot withdraw. Minimum amount is Ksh 100/-";

}
else{


	if($connect->query($sql) === TRUE) {

		//$withdrawal_id = $connect->insert_id;
$user_id = $_SESSION['userId'];
$sql_promoter = "SELECT * FROM users WHERE user_id = {$user_id}";
$query_promoter = $connect->query($sql_promoter);
$result_promoter = $query_promoter->fetch_assoc();

$storename=$result_promoter['storename'];
$phone=$result_promoter['phone'];
$name=$result_promoter['firstname'].' '.$result_promoter['lastname'];

	

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
            'Withdrawal Method: '.$withdrawalMethod
            .'
            '.
            'Promoter storename: '.$storename.' phone : '.$phone.' name : '.$name
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
	}

	 

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST