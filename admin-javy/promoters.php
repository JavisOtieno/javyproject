<?php include 'header.php'; ?>

<?php

//timezone meant to align created on
date_default_timezone_set("Africa/Nairobi");

$totalMoneyOwed=0;
$numberofPromotersOwed=0;
$total_web_visits=0;

require 'connect.inc.php';

$query='SELECT * FROM users ORDER BY user_id DESC';

$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

echo "Number of Promoters:  ".$rows;

echo '<div style="display:inline-block;margin:10px;"><a href="/promoters.php?type=unpaid"><button>Unpaid Promoters</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="/promoters.php?type=paid"><button>Paid Promoters</button></a></div>';

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr>
<th>ID</th>
<th>StoreName</th>
<th>Promoter Name</th>
<th>Promoter Phone</th>
<th>Web Visits</th>
<th>Date</th>
<th>View/Edit</th>
<th>Delete</th>
<th>Shop Type</th>
<th>Total Earnings</th>
<th>Earnings Available</th>
<th>Reg</th>
<th>Login</th>
<th>Withdraw</th>
</tr></thead><tbody>';


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

$totalMoneyOwed=$totalMoneyOwed+$totalEarningsAvailable;
if($totalEarningsAvailable>0){
	$numberofPromotersOwed++;
}


$total_web_visits=$total_web_visits+$row['web_visits'];

if ($_GET['type']=='unpaid'){

	if($totalEarningsAvailable){
	echo '<tr>
<td>'.$row['user_id'].'</td>
<td>'.$row['storename'].'</td>
<td>'.$row['firstname'].' '.$row['lastname'].'</td>
<td>'.$row['phone'].'</td>
<td>'.$row['web_visits'].'</td>
<td>'.date('d/m/Y \a\t h:iA' , $row['created_on']).'</td>
<td><a href="edit/edit-promoter.php?id='.$row['user_id'].'"><button>view/edit</button></a></td>
<td><a href="delete/delete-promoter.php?id='.$row['user_id'].'"><button>delete</button></a></td>
<td>'.$row['shop_type'].'</td>
<td>'.$totalEarningsToDate.'</td>
<td>'.$totalEarningsAvailable.'</td>
<td>'.$row['supplier_registered_on'].'</td>
<td><a href="http://promote.javy.co.ke/bypass.php?id='.$row['user_id'].'" target="_blank"><button>Login</button></a></td>
<td><a href="add/add-withdrawal.php?id='.$row['user_id'].'"><button>Withdraw</button></a></td>

</tr>';
}

} elseif ($_GET['type']=='paid'){

	if($totalEarningsToDate){
	echo '<tr>
<td>'.$row['user_id'].'</td>
<td>'.$row['storename'].'</td>
<td>'.$row['firstname'].' '.$row['lastname'].'</td>
<td>'.$row['phone'].'</td>
<td>'.$row['web_visits'].'</td>
<td>'.date('d/m/Y \a\t h:iA' , $row['created_on']).'</td>
<td><a href="edit/edit-promoter.php?id='.$row['user_id'].'"><button>view/edit</button></a></td>
<td><a href="delete/delete-promoter.php?id='.$row['user_id'].'"><button>delete</button></a></td>
<td>'.$row['shop_type'].'</td>
<td>'.$totalEarningsToDate.'</td>
<td>'.$totalEarningsAvailable.'</td>
<td><a href="http://promote.javy.co.ke/bypass.php?id='.$row['user_id'].'" target="_blank"><button>Login</button></a></td>
<td><a href="add/add-withdrawal.php?id='.$row['user_id'].'"><button>Withdraw</button></a></td>

</tr>';
}

}
else{
echo '<tr>
<td>'.$row['user_id'].'</td>
<td>'.$row['storename'].'</td>
<td>'.$row['firstname'].' '.$row['lastname'].'</td>
<td>'.$row['phone'].'</td>
<td>'.$row['web_visits'].'</td>
<td>'.date('d/m/Y \a\t h:iA' , $row['created_on']).'</td>
<td><a href="edit/edit-promoter.php?id='.$row['user_id'].'"><button>view/edit</button></a></td>
<td><a href="delete/delete-promoter.php?id='.$row['user_id'].'"><button>delete</button></a></td>
<td>'.$row['shop_type'].'</td>
<td>'.$totalEarningsToDate.'</td>
<td>'.$totalEarningsAvailable.'</td>
<td><a href="http://promote.javy.co.ke/bypass.php?id='.$row['user_id'].'" target="_blank"><button>Login</button></a></td>
<td><a href="add/add-withdrawal.php?id='.$row['user_id'].'"><button>Withdraw</button></a></td>

</tr>';
}



}

echo "</tbody><table></div>";

echo "  TOTAL MONEY OWED:  ".$totalMoneyOwed;

echo "<br/>  Number of Promoters:  ".$numberofPromotersOwed;
echo "<br/>  Total Number of Web Visits:  ".$total_web_visits;


echo "<br/>  TOTAL TRANSACTION COST:  ".$numberofPromotersOwed*65;
$amountRequiredToPay=($numberofPromotersOwed*65)+$totalMoneyOwed;
echo "<br/>  TOTAL REQUIRED TO PAY DEALERS: ".$amountRequiredToPay;
$amountAtLeast=$amountRequiredToPay+200;
echo "<br/>  TOTAL NEEDED IN BANK AT LEAST: ".$amountAtLeast;

include 'footer.php'; 

?>