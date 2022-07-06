<?php include 'header.php'; ?>

<?php

echo "PROMOTER EMAIL SUBSCRIBERS<br/>";

require 'connect.inc.php';

if(isset($_GET['type']))
{
	$type=$_GET['type'];
	if($type=="unsubscribed"){
	 $query='SELECT * FROM customers WHERE id IN (SELECT id FROM unsubscribe_list_customers)';

     //$query='SELECT * FROM users,unsubscribe_list WHERE users.user_id=unsubscribe_list.user_id';

		}
}else{
		$query='SELECT * FROM customers WHERE id NOT IN (SELECT id FROM unsubscribe_list_customers)';
	}



$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

echo "Number of Subscribed Customers:  ".$rows;

echo '<br/><div style="display:inline-block;margin:10px;"><a href="customers-subscribers.php"><button>All Customers</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="customers-subscribers.php?type=unsubscribed"><button>Unsubscribed Customers</button></a></div>';





echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr>
<th>ID</th>
<th>Dealer Id</th>
<th>Customer Name</th>
<th>Customer Phone</th>
<th><strong>Customer Email</th>

</tr></thead><tbody>';


while($row=mysqli_fetch_assoc($query_run)){



echo '<tr>
<td>'.$row['id'].'</td>

<td>'.$row['dealerid'].'</td>
<td>'.$row['name'].'</td>
<td>'.$row['phone'].'</td>
<td>'.$row['email'].'</td>

</tr>';

}

echo "</tbody></table></body>";


?>

<?php include 'footer.php'; ?>