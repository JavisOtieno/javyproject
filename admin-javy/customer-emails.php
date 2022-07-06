<?php include 'header.php'; ?>
<?php



require 'connect.inc.php';

$query='SELECT * FROM customer_emails  ORDER BY id DESC';

echo '<div class="table-responsive"><table class="table table-striped">
<tr><th>ID</strong></th>
<th>Email</th>
<th>Dealer ID</th>
<th>Store Name</th>
</tr></thead><tbody>';

$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){


echo '<tr">
<td>'.$row['id'].'</td>
<td>'.$row['email'].'</td>
<td>'.$row['dealer_id'].'</td>
<td>'.$row['storename'].'</td>
</tr>';

}

echo "</tbody></table></body>";

include 'footer.php'; ?>