<?php include 'header.php'; ?>

<?php



require 'connect.inc.php';

$query='SELECT * FROM customer_contact_forms  ORDER BY id DESC';

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr><th>ID</th>
<th>Dealer ID</th>
<th>Name</th>
<th>Email</th>
<th>Message</th>
<th>Notes</th>
<th>View/Edit</th>
<th>Delete</th>
<th>Status</th>
</tr></thead><tbody';

$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){

		if ($row['status']==1){
		$status='answered';
	}elseif ($row['status']==0) {
		$status='processing';
	}elseif ($row['status']==2) {
		$status='not answered';
	}


echo '<tr>
<td>'.$row['id'].'</td>
<td>'.$row['dealer_id'].'</td>
<td>'.$row['name'].'</td>
<td>'.$row['email'].'</td>
<td>'.$row['message'].'</td>
<td>'.$row['notes'].'</td>
<td><a href="edit/edit-contact-message.php?id='.$row['id'].'"><button>view/edit</button></a></td>
<td><a href="delete/delete-contact-message.php?id='.$row['id'].'"><button>delete</button></a></td>
<td>'.$status.'</td>


</tr>';

}
echo  "</tbody></table></div>";

include 'footer.php'; ?>