<?php include 'header.php'; ?>

<?php

echo "PROMOTER EMAIL SUBSCRIBERS<br/>";

require 'connect.inc.php';

if(isset($_GET['type']))
{
	$type=$_GET['type'];
	if($type=="unsubscribed"){
	 $query='SELECT * FROM users WHERE user_id IN (SELECT user_id FROM unsubscribe_list)';

     //$query='SELECT * FROM users,unsubscribe_list WHERE users.user_id=unsubscribe_list.user_id';

		}
}else{
		$query='SELECT * FROM users WHERE user_id NOT IN (SELECT user_id FROM unsubscribe_list)';
	}



$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

echo "Number of Subscribed Promoters:  ".$rows;

echo '<br/><div style="display:inline-block;margin:10px;"><a href="promoters-subscribers.php"><button>All Promoters</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="promoters-subscribers.php?type=unsubscribed"><button>Unsubscribed Promoters</button></a></div>';





echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr>
<th>ID</th>
<th>StoreName</th>
<th>Promoter Name</th>
<th>Promoter Phone</th>
<th><strong>Web Visits</th>

</tr></thead><tbody>';


while($row=mysqli_fetch_assoc($query_run)){

	$userId=$row['user_id'];


echo '<tr>
<td>'.$row['user_id'].'</td>
<td>'.$row['storename'].'</td>
<td>'.$row['firstname'].' '.$row['lastname'].'</td>
<td>'.$row['phone'].'</td>
<td>'.$row['web_visits'].'</td>

</tr>';

}

echo "</tbody></table></body>";


?>

<?php include 'footer.php'; ?>