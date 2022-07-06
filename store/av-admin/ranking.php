<?php
include 'core.php';
?>
<html>
<head>
</head>
<body>

<?php


require 'connect.inc.php';

$query='SELECT * FROM users';

$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

echo "Number of Promoters:  ".$rows."<br/><br/>";

// echo '<div>
// <div style="width:5%;display:inline-block;" ><strong>ID</strong></div>
// <div style="width:15%;display:inline-block;"><strong>StoreName</strong></div>
// <div style="width:10%;display:inline-block;"><strong>Promoter Name</strong></div>
// <div style="width:10%;display:inline-block;"><strong>Promoter Phone</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Web Visits</strong></div>
// <div style="width:10%;display:inline-block;"><strong>View/Edit</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Total Earnings</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Earnings Available</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Login</strong></div>
// <div style="width:5%;display:inline-block;"><strong>Withdraw</strong></div>
// </div>';

echo '<div>
<div style="margin-left:20px;width:15%;display:inline-block;"><strong>Promoter</strong></div>
<div style="width:20%;display:inline-block;"><strong>Website</strong></div>
<div style="width:15%;display:inline-block;"><strong>Earnings</strong></div>
</div>';


$promoters_array=array();

while($row=mysqli_fetch_assoc($query_run)){

	$userId=$row['user_id'];

	$sqlearnings= "SELECT product_profit FROM deals WHERE status=1 AND dealer_id=$userId";
$query_run2=mysqli_query($db_link,$sqlearnings);
$totalRevenue=0;
while($row2=mysqli_fetch_assoc($query_run2)){
	$totalRevenue += $row2['product_profit'];
}

$sqlwithdrawals="SELECT amount FROM withdrawals WHERE user_id='$userId' AND (status=0 OR status=1)";
$query_run3=mysqli_query($db_link,$sqlwithdrawals);
$totalWithdrawals=0;
while($row3=mysqli_fetch_assoc($query_run3)){
	$totalWithdrawals +=$row3['amount'];
}

$totalEarningsToDate=$totalRevenue;
$totalEarningsAvailable=$totalRevenue-$totalWithdrawals;

$promoters_array += [$row['storename']=>$totalEarningsToDate];




// echo '<div style="margin:20px">
// <div style="width:5%;display:inline-block;" >'.$row['user_id'].'</div>
// <div style="width:15%;display:inline-block;">'.$row['storename'].'</div>
// <div style="width:10%;display:inline-block;">'.$row['firstname'].' '.$row['lastname'].'</div>
// <div style="width:10%;display:inline-block;">'.$row['phone'].'</div>
// <div style="width:5%;display:inline-block;">'.$row['web_visits'].'</div>
// <div style="width:10%;display:inline-block;"><a href="edit-promoter.php?id='.$row['user_id'].'"><button>view/edit</button></a></div>
// <div style="width:5%;display:inline-block;">'.$totalEarningsToDate.'</div>
// <div style="width:5%;display:inline-block;">'.$totalEarningsAvailable.'</div>
// <div style="width:5%;display:inline-block;"><a href="http://www.javy.co.ke/bypass.php?id='.$row['user_id'].'" target="_blank"><button>Login</button></a></div>
// <div style="width:5%;display:inline-block;"><a href="add-withdrawal.php?id='.$row['user_id'].'"><button>Withdraw</button></a></div>

// </div>';

}

arsort($promoters_array);

// echo '<div style="margin:20px">
// <div style="width:5%;display:inline-block;" >'.$row['user_id'].'</div>
// <div style="width:15%;display:inline-block;">'.$row['storename'].'</div>
// <div style="width:10%;display:inline-block;">'.$row['firstname'].' '.$row['lastname'].'</div>
// <div style="width:10%;display:inline-block;">'.$row['phone'].'</div>
// <div style="width:5%;display:inline-block;">'.$row['web_visits'].'</div>
// <div style="width:10%;display:inline-block;"><a href="edit-promoter.php?id='.$row['user_id'].'"><button>view/edit</button></a></div>
// <div style="width:5%;display:inline-block;">'.$totalEarningsToDate.'</div>
// <div style="width:5%;display:inline-block;">'.$totalEarningsAvailable.'</div>
// <div style="width:5%;display:inline-block;"><a href="http://www.javy.co.ke/bypass.php?id='.$row['user_id'].'" target="_blank"><button>Login</button></a></div>
// <div style="width:5%;display:inline-block;"><a href="add-withdrawal.php?id='.$row['user_id'].'"><button>Withdraw</button></a></div>

// </div>';


foreach ($promoters_array as $key => $value) {
	echo '<div>
<div style="margin-left:20px;width:15%;display:inline-block;">'.$key.'</div>
<div style="width:20%;display:inline-block;">www.'.$key.'.av.ke</div>
<div style="width:15%;display:inline-block;">'.$value.'</div>
</div>';
}

