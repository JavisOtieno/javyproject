<?php include 'header.php'; ?>

<?php



require 'connect.inc.php';

$query='SELECT * FROM customer_queries ORDER BY id DESC';

echo '<div class="table-responsive"><table class="table table-striped">
<<thead>tr><th>ID</th>
<th>Query</th>
<th>Dealer ID</th>
<th>Store Name</th>
</tr></thead><tbody';

$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){


echo '<tr>
<td>'.$row['id'].'</td>
<td>'.$row['query'].'</td>
<td>'.$row['dealer_id'].'</td>
<td>'.$row['storename'].'</td>

</tr>';

}

echo "</tbody></table></div>";

 include 'footer.php'; ?>