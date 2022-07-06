<?php


	

require_once 'core.php';

$valid['success'] = array('success' => false, 'earnings' => array());
//$valid['success'] = array('success' => false, 'messages' => array());




$sqlearnings= "SELECT product_profit FROM deals WHERE status=1 AND dealer_id=$userId";
$result=$connect->query($sqlearnings);
$totalRevenue=0;
while($row=$result->fetch_assoc()){
	$totalRevenue += $row['product_profit'];
}

$sqlwithdrawals="SELECT amount FROM withdrawals WHERE user_id=$userId AND status!=2 ";
$result=$connect->query($sqlwithdrawals);
$totalWithdrawals=0;
while($row=$result->fetch_assoc()){
	$totalWithdrawals +=$row['amount'];
}

$totalRevenue=$totalRevenue-$totalWithdrawals;

// $valid['success'] = true;
// $valid['earnings'] = "this is";

$valid['success'] = true;
		$valid['earnings'] = $totalRevenue;	

$connect->close();

echo json_encode($valid);
