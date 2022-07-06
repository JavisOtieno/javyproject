<?php include 'header.php'; ?>

<?php


require 'connect.inc.php';

$query='SELECT * FROM supplier_payments ORDER BY payment_id DESC';


//order by order id
//$query='SELECT * FROM supplier_payments ORDER BY order_id';


$query_run=mysqli_query($db_link,$query);

$rows_payments=mysqli_num_rows($query_run);

echo "Number of orders paid for: ".$rows_payments;

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr><th>ID</th>
<th>Supplier ID</th>
<th>Order id</th>
<th>Amount</th>
<th>Date</th>
<th>View/Edit</th>
<th>Status</div>
<th>Delete</strong></th>
</tr>';


while($row=mysqli_fetch_assoc($query_run)){

	if ($row['status']==1){
		$status='complete';
	}elseif ($row['status']==0) {
		$status='processing';
	}elseif ($row['status']==2) {
		$status='cancelled';
	}




echo '<tr">
<td>'.$row['payment_id'].'</td>
<td>'.$row['supplier_id'].'</td>
<td>'.$row['order_id'].'</td>
<td>'.$row['amount'].'</td>
<td>'.date('d/m/Y \a\t h:iA', $row["date"]).'</td>
<td><a href="edit/edit-payment.php?id='.$row['payment_id'].'"><button>view/edit</button></a></td>
<td>'.$status.'</td>
<td><a href="delete/delete-payment.php?id='.$row['payment_id'].'"><button>Delete</button></a></td>
</tr>';

}

echo "</tbody></table></div>";

include 'footer.php'; ?>
