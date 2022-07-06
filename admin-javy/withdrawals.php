<?php include 'header.php'; ?>

<?php


require 'connect.inc.php';

date_default_timezone_set("Africa/Nairobi");

$query='SELECT * FROM withdrawals  ORDER BY withdrawal_id DESC';

if (isset($_GET['id'])){
$promoter_id=$_GET['id'];
$query="SELECT * FROM withdrawals WHERE user_id=".$promoter_id." ORDER BY withdrawal_id DESC";
}



echo '<div style="table-responsive"><table class="table table-striped"><thead>
<tr>
<th>ID</th>
<th>Promoter ID</th>
<th>Amount</th>
<th>Method</th>
<th>Date</th>
<th>View/Edit</th>
<th>Status</th>
<th>Delete</th>
</tr>';

$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){

	if ($row['status']==1){
		$status='complete';
	}elseif ($row['status']==0) {
		$status='processing';
	}elseif ($row['status']==2) {
		$status='cancelled';
	}
echo '<tr>
<td>'.$row['withdrawal_id'].'</td>
<td>'.$row['user_id'].'</td>
<td>'.$row['amount'].'</td>
<td>'.$row['method'].'</td>
<td>'.date('d/m/Y \a\t h:iA',$row['date']).'</td>
<td><a href="edit/edit-withdrawal.php?id='.$row['withdrawal_id'].'"><button>view/edit</button></a></td>
<td>'.$status.'</td>
<td><a href="delete/delete-withdrawal.php?id='.$row['withdrawal_id'].'"><button>Delete</button></a></td>
</tr>';

}

include 'footer.php'; ?>
