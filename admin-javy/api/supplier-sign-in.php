<?php 
require_once '../connect.inc.php';


$errors = array();
//end of login using cookie


if($_GET) {		

	$username = $_GET['username_email'];
	$username=$connect->real_escape_string($username);
	$password = $_GET['password'];
	$password=$connect->real_escape_string($password);

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors = "Please enter your username or Email";
		} 

		if($password == "") {
			$errors = "Password is required";
		}
	} else {

		//make state of email to be false as the default
		$email_entered=false;
		if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$sql = "SELECT * FROM users WHERE email = '$username'";
			$email_entered=true;
		    }
		    else {
		        $sql = "SELECT * FROM users WHERE username = '$username'";
		    }



		
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);
			// exists

			$mainSql = "SELECT * FROM suppliers WHERE username = '$username' AND password = '$password'";

			if($email_entered){
				$mainSql = "SELECT * FROM suppliers WHERE email = '$username' AND password = '$password'";
			}
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['id'];
				$username = $value['username'];



				// set session
				//$_SESSION['userId'] = $user_id;


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
				$errors= "Incorrect username. Please check your store name and try again";
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
	$response['username']=$username;
	$response['message']="Sign in successful";
}
echo json_encode($response);

?>