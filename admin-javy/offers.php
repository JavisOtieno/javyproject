<?php include 'header.php'; ?>


<?php

date_default_timezone_set("Africa/Nairobi");

require 'connect.inc.php';

$query='SELECT * FROM offers2 ORDER BY id DESC';

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr><th>ID</th>
<th>Offer Title</th>
<th>Offer Image Link</th>
<th>On-slider</th>

<th>View/Edit</th>
<th>Date</th>
<th>Status</th>
<th>Delete</th>
</tr>

</thead><tbody>';

$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){

	if ($row['status']==1){
		$status='active';
	}elseif ($row['status']==0) {
		$status='inactive';
	}elseif ($row['status']==2) {
		$status='to activate';
	}

	if ($row['on_slider']==1){
		$on_slider='on slider';
	}elseif ($row['on_slider']==0) {
		$on_slider='NOT on slider';
	}
echo '<tr>
<td>'.$row['id'].'</td>
<td>'.$row['title'].'</td>
<td>'.$row['image'].'</td>
<td>'.$on_slider.'</td>
<td><a href="edit/edit-offer.php?id='.$row['id'].'"><button>view/edit</button></a></td>
<td>'.date('d/m/Y \a\t h:iA', $row["date"]).'</td>
<td>'.$status.'</td>
<td><a href="delete/delete-offer.php?id='.$row['id'].'"><button>Delete</button></a></td>
</tr>';

}


 include 'footer.php'; ?>
