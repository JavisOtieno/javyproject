<?php include 'header.php'; ?>




<?php

echo '<a href="add/add-quote.php" ><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Add Quote</button></a>';
 


require 'connect.inc.php';

$query='SELECT * FROM quotes';


echo "<strong><br/><br/> QUOTES<br/></strong>";



$sql_quotes="SELECT * FROM quotes";
$query_run_quotes=mysqli_query($db_link,$sql_quotes);

echo '<div class="table-responsive"><table class="table table-striped">
<thead>
<tr>
<th>Id</th>
<th>Date/Time</th>
<th>Name</th>
<th>Phone</th>
<th>Email</th>
<th>View/Edit</th>
<th>Document</th>
</tr>
</thead>
<tbody>';

while($row_quote=mysqli_fetch_assoc($query_run_quotes)){

	echo '
<tr><td>'.$row_quote['id'].'</td>
<td>'.$row_quote['timestamp'].'</td>
<td>'.$row_quote['name'].'</td>
<td>'.$row_quote['phone'].'</td>
<td>'.$row_quote['email'].'</td>
<td><a href="edit/edit-quote.php?id='.$row_quote['id'].'"><button>edit</button></a></td>
<td><a href="view-document.php?id='.$row_quote['id'].'&type=quote"><button>View Doc</button></a></td>

</tr>';

}
echo "</tbody></table></div>";


	


include 'footer.php'; ?>
