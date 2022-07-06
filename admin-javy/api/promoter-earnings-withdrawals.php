<?php include '../connect.inc.php'; 
date_default_timezone_set("Africa/Nairobi");
?>

<?php
if(isset($_GET['id'])){
    $dealer_id=$_GET['id'];
}



$sqlearnings= "SELECT product_profit FROM deals WHERE status=1 AND dealer_id=".$dealer_id;
$result=$connect->query($sqlearnings);
$totalRevenue=0;
while($row=$result->fetch_assoc()){
  $totalRevenue += $row['product_profit'];
}

$sqlwithdrawals="SELECT amount FROM withdrawals WHERE user_id=".$dealer_id." AND (status=0 OR status=1)";
$result=$connect->query($sqlwithdrawals);
$totalWithdrawals=0;
while($row=$result->fetch_assoc()){
  $totalWithdrawals +=$row['amount'];
}

$totalEarningsToDate=$totalRevenue;
$totalEarningsAvailable=$totalRevenue-$totalWithdrawals;

$query='SELECT * FROM withdrawals WHERE user_id='.$dealer_id.' ORDER BY date DESC';

$query_run=mysqli_query($db_link,$query);

$response = array('success' => 1);


$response["earnings_available"]=$totalEarningsAvailable;

$response["withdrawals"] = array();

while( $row=mysqli_fetch_array($query_run) ){
  $withdrawal = array();
  $withdrawal["withdrawal_id"] = $row["withdrawal_id"];
  $withdrawal["withdrawal_amount"] = "KSh. ".number_format($row["amount"]);
  $withdrawal["withdrawal_method"] = $row["method"];
  $withdrawal["withdrawal_date"] = date('d/m/Y \a\t h:iA',$row["date"]);

    if($row['status']==0){
  $withdrawal['withdrawal_status']='Processing';  
  }
  else if($row['status']==1){
  $withdrawal['withdrawal_status']='Complete'; 
  } 
  else if($row['status']==2){
  $withdrawal['withdrawal_status']='Cancelled';  
  }
 
 array_push($response["withdrawals"], $withdrawal);
  }


echo json_encode($response);