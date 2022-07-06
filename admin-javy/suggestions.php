

<?php include 'header.php'; ?>

<?php


require 'connect.inc.php';

$query='SELECT * FROM marketing_suggestions ORDER BY id DESC';


//order by order id
//$query='SELECT * FROM supplier_payments ORDER BY order_id';


$query_run=mysqli_query($db_link,$query);

$rows_payments=mysqli_num_rows($query_run);

echo "Number of suggestions ".$rows_payments;

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr><th>ID</th>
<th>Suggestion</th>
<th>User id</th>
<th>Date</th>
<th>View/Edit</th>
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
<td>'.$row['id'].'</td>
<td>'.$row['suggestion'].'</td>
<td>'.$row['user_id'].'</td>
<td>'.date('d/m/Y \a\t h:iA', $row["date"]).'</td>
<td><a href="edit/edit-suggestion.php?id='.$row['id'].'"><button>view/edit</button></a></td>
<td>'.$status.'</td>
<td><a href="delete/delete-suggestion.php?id='.$row['id'].'"><button>Delete</button></a></td>
</tr>';

}

echo "</tbody></table></div>";

include 'footer.php'; ?>
