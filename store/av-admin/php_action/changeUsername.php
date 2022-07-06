<?php 

require_once 'core.php';

if($_POST) {

	$valid['success'] = array('success' => false, 'messages' => array());

	$currentstorename = $_POST['currentstorename'];
	$currentphonenumber = $_POST['currentphonenumber'];
	$newstorename = $_POST['newstorename'];
	$newphonenumber = $_POST['newphonenumber'];
	$userId = $_POST['user_id'];

	$to      = 'javisotieno@gmail.com';
$subject = 'CHANGE REQUEST by:'.$currentstorename;
$headers = 'From: info@javytech.co.ke' 
.'
'.
    'Reply-To: info@javytech.co.ke' 
    .'
    '.
    'X-Mailer: PHP/' . phpversion();
$message =  (
            'Id: '.$userId
            .'
            '.
            'Current Store Name: '.$currentstorename
            .'
            '.
            'Current Phone number: '.$currentphonenumber
            .'
            '.
            'New Store Name: '.$newstorename
            .'
            '.
            'New Phone Number: '.$newphonenumber.'');






	//$sql = "UPDATE users SET username = '$username' WHERE user_id = {$userId}";
	//if($connect->query($sql) === TRUE) {
if(mail($to, $subject, $message, $headers)) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Requested";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while making Request";
	}

	$connect->close();

	echo json_encode($valid);

}

?>