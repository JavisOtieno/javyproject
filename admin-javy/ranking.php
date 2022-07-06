<?php include 'header.php'; ?>


<?php


require 'connect.inc.php';

$query='SELECT * FROM users';

$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

echo "Number of Promoters:  ".$rows."<br/><br/>";

echo '<div style="display:inline-block;margin:10px;"><a href="/ranking.php?rankby=sales"><button>Ranking by Sales</button></a></div>';
echo '<div style="display:inline-block;margin:10px;"><a href="/ranking.php?rankby=webvisits"><button>Ranking By Website Visits</button></a></div>';

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

if(isset($_GET['rankby'])){
	$rank_by=$_GET['rankby'];
}else{
	$rank_by='sales';
}



echo '<div class="table-responsive"><table class="table table-striped"><thead>
<th>Promoter</th>
<th>Website</th>
<th>'.ucfirst($rank_by).'</th>
</thead><tbody>';


$promoters_array=array();

while($row=mysqli_fetch_assoc($query_run)){

	$userId=$row['user_id'];
	$webvisits=$row['web_visits'];

	$sqlearnings= "SELECT product_profit,product_price FROM deals WHERE status=1 AND dealer_id=$userId";
$query_run2=mysqli_query($db_link,$sqlearnings);
$totalRevenue=0;
while($row2=mysqli_fetch_assoc($query_run2)){
	$totalRevenue += $row2['product_price'];
}

if($rank_by=='webvisits'){
	$promoters_array += [$row['storename']=>$webvisits];
}else{
$promoters_array += [$row['storename']=>$totalRevenue];
}


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
	echo '<tr>
<td>'.$key.'</td>
<td>www.'.$key.'.av.ke</td>
<td>'.$value.'</td>
</tr>';
}

echo "</tbody></table></div>";

//display on web visits

echo "<br/><br/>BY WEB VISITS<br/>";

$query='SELECT * FROM users';

$query_run4=mysqli_query($db_link,$query);

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<th>Promoter</th>
<th>Website</th>
<th>Web Visits</th>
</thead><tbody>';


$promoters_web_array=array();

while($row=mysqli_fetch_assoc($query_run4)){

	$userId=$row['user_id'];

	$sqlearnings= "SELECT web_visits FROM users WHERE user_id='$userId'";
$query_run2=mysqli_query($db_link,$sqlearnings);
while($row2=mysqli_fetch_assoc($query_run2)){
	$web_visits=$row2['web_visits'];
}


$promoters_web_array += [$row['storename']=>$web_visits];

}


arsort($promoters_web_array);




foreach ($promoters_web_array as $key => $value) {
	echo '<tr>
<td>'.$key.'</td>
<td>www.'.$key.'.av.ke</td>
<td>'.number_format($value).'</td>
</tr>';
}


echo "</tbody></table></div>";


include 'footer.php'; ?>
