<?php 
require_once '../connect.inc.php';


$errors = array();
//end of login using cookie


if($_GET) {		

	$storename = $_GET['storename_email'];
	$storename=$connect->real_escape_string($storename);
	$password = $_GET['password'];
	$password=$connect->real_escape_string($password);

	if(empty($storename) || empty($password)) {
		if($storename == "") {
			$errors = "Please enter your Storename or Email";
		} 

		if($password == "") {
			$errors = "Password is required";
		}
	} else {

		//make state of email to be false as the default
		$email_entered=false;
		if(filter_var($storename, FILTER_VALIDATE_EMAIL)) {
			$sql = "SELECT * FROM users WHERE email = '$storename'";
			$email_entered=true;
		    }
		    else {
		        $sql = "SELECT * FROM users WHERE storename = '$storename'";
		    }



		
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);
			// exists

			$mainSql = "SELECT * FROM users WHERE storename = '$storename' AND password = '$password'";

			if($email_entered){
				$mainSql = "SELECT * FROM users WHERE email = '$storename' AND password = '$password'";
			}
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];
				$storename = $value['storename'];



				// set session
				$_SESSION['userId'] = $user_id;


				//header('location: http://localhost/websites/stock-2/dashboard.php');
				//for the web
				//header('location: '.$requested_page.'.php');
					
			} else{
				
				$errors = "Incorrect Password";
			} // /else
		} else {		
			
			if($email_entered){
				$errors = "Incorrect Email. Please check your email and try again";
			}else{
				$errors= "Incorrect Storename. Please check your store name and try again";
			}		
		} // /else
	} // /else not empty username // password
	
}else {
	$errors = "Please Enter your details";
} // /if $_POST

if(empty($user_id)){
	$response = array('success' => false);
	$response['user_id']=0;
	$response['message']=$errors;

}else{
	$response = array('success' => true);
	$response['user_id']=$user_id;
	$response['storename']=$storename;
	$response['message']="Sign in successful";
}
echo json_encode($response);

?>