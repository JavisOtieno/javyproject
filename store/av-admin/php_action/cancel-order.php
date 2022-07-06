<?php 	

require_once 'db_connect.php';
$db_link=@mysqli_connect($localhost, $username, $password, $dbname);


$valid['success'] = array('success' => false, 'messages' => array());

if($_GET) {

	$orderId = $connect->real_escape_string($_GET['orderId']);

	$sqlorder="SELECT * FROM deals WHERE id=".$orderId;
	$query_run_order=mysqli_query($db_link,$sqlorder);
  	if($row=mysqli_fetch_assoc($query_run_order)){
  	$order_notes=$row['notes'];
  	}

  	$order_notes="Cancelled by Promoter".$order_notes;
 			
	$sql = "UPDATE deals SET status='2',notes='$order_notes' WHERE id = {$orderId}";

	if	($connect->query($sql)){
	$valid['success'] = true;
	$valid['messages'] = "Successfully Updated";
	}else{
	$valid['success'] = false;
	$valid['messages'] = "Error updating order";
	}

	header('location: ../orders.php?o=manord');
		
	$connect->close();

	echo json_encode($valid);
 
}

 // /if $_POST
// echo json_encode($valid);