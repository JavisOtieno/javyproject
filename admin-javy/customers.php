<?php include 'header.php'; ?>

<?php


require 'connect.inc.php';

$query='SELECT * FROM customers ORDER BY id DESC';

$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

echo "Number of Customers:  ".$rows;

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr><th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>Email</th>
<th>Delivery Details</th>
<th>View/Edit</th>
<th>Delete</th>
<th>Promoter ID</th>
</tr></thead><tbody>';


while($row=mysqli_fetch_assoc($query_run)){


echo '<tr>
<td>'.$row['id'].'</td>
<td>'.$row['name'].'</td>
<td>'.$row['phone'].'</td>
<td>'.$row['email'].'</td>
<td>'.$row['deliverydetails'].'</td>
<td><a href="edit/edit-customer.php?id='.$row['id'].'"><button>view/edit</button></a></td>
<td><a href="delete/delete-customer.php?id='.$row['id'].'"><button>delete</button></a></td>
<td>'.$row['dealerid'].'</td>

</tr>';

}
echo '</tbody></table></div>';

include 'footer.php';

 ?>