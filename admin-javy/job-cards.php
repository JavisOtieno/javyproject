<?php include 'header.php'; ?>




<?php

echo '<a href="add/add-job-card.php" ><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Add Job Card</button></a>';
 


require 'connect.inc.php';

$query='SELECT * FROM job_cards';


echo "<strong><br/><br/> JOB CARDS<br/></strong>";



$sql_job_cards="SELECT * FROM job_cards";
$query_run_job_cards=mysqli_query($db_link,$sql_job_cards);

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

while($row_job_cards=mysqli_fetch_assoc($query_run_job_cards)){

    echo '
<tr><td>'.$row_job_cards['id'].'</td>
<td>'.$row_job_cards['timestamp'].'</td>
<td>'.$row_job_cards['name'].'</td>
<td>'.$row_job_cards['phone'].'</td>
<td>'.$row_job_cards['email'].'</td>
<td><a href="edit/edit-job-card.php?id='.$row_job_cards['id'].'"><button>edit</button></a></td>
<td><a href="document.php?id='.$row_job_cards['id'].'&type=job_card"><button>View Doc</button></a></td>

</tr>';

}
echo "</tbody></table></div>";

    


include 'footer.php'; ?>






    

