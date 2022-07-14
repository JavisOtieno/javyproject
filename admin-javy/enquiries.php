<?php include 'header.php'; ?>




<?php

echo '<a href="add/add-enquiry.php" ><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Add Enquiry</button></a>';
 


require 'connect.inc.php';

$query='SELECT * FROM enquiries';


echo "<strong><br/><br/> ENQUIRIES<br/></strong>";



$sql_enquiries="SELECT * FROM enquiries";
$query_run_enquiries=mysqli_query($db_link,$sql_enquiries);

echo '<div class="table-responsive"><table class="table table-striped">
<thead>
<tr>
<th>Id</th>
<th>Date</th>
<th>Phone</th>
<th>Item</th>
<th>Description</th>
<th>Resolution Notes</th>
</tr>
</thead>
<tbody>';

while($row_enquiry=mysqli_fetch_assoc($query_run_enquiries)){

	echo '
<tr><td>'.$row_enquiry['id'].'</td>
<td>'.$row_enquiry['enquiry_date'].'</td>
<td>'.$row_enquiry['enquiry_phone'].'</td>
<td>'.$row_enquiry['enquiry_item'].'</td>
<td>'.$row_enquiry['enquiry_description'].'</td>
<td>'.$row_enquiry['enquiry_notes'].'</td>
<td><a href="edit/edit-enquiry.php?id='.$row_enquiry['id'].'"><button>edit</button></a></td>



</tr>';

}
echo "</tbody></table></div>";


	


include 'footer.php'; ?>
