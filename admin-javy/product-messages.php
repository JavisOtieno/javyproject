<?php include 'header.php'; ?>

<?php



require 'connect.inc.php';


$query='SELECT * FROM product_messages  ORDER BY id DESC';

$count=0;

if(isset($_GET['type'])){
	$type=$_GET['type'];

	if($type=="all"){
$query='SELECT * FROM product_messages ORDER BY id DESC';
}
else if($type=="processing"){
$query='SELECT * FROM product_messages WHERE status=0 ORDER BY id DESC';
}
else if($type=="answered"){
$query='SELECT * FROM product_messages WHERE status=1 ORDER BY id DESC';
}else if($type=="not-answered"){
$query='SELECT * FROM product_messages WHERE status=2 ORDER BY id DESC';
}



}

echo '<br/><br/<div style="display:inline-block;margin:10px;"><a href="product-messages.php"><button>All Messages</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="product-messages.php?type=processing"><button>Processing Messages</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="product-messages.php?type=answered"><button>Answered Messages</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="product-messages.php?type=not-answered"><button>Not answered messages</button></a></div>';

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr><th>ID</th>
<th>Customer Name</th>
<th>Customer Phone</th>
<th>Customer Email</th>
<th>Message</th>
<th>Notes</th>
<th>View/Edit</th>
<th>Delete</th>
<th>Status</th>
</thead><tbody>';

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
<td>'.$row['name'].'</td>
<td>'.$row['phone'].'</td>
<td>'.$row['email'].'</td>
<td>'.$row['message'].'</td>
<td>'.$row['notes'].'</td>
<td><a href="edit/edit-message.php?id='.$row['id'].'"><button>view/edit</button></a></td>
<td><a href="delete/delete-message.php?id='.$row['id'].'"><button>delete</button></a></td>
<td>'.$status.'</td>

</tr>';

$count++;

}

echo '</tbody><table></div>';

echo 'count: '.$count;

 include 'footer.php'; ?>