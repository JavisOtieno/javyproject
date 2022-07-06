<?php include 'header.php';  




		$query='SELECT * FROM users ORDER BY web_visits DESC LIMIT 50';


		if(isset($_GET['search'])){

		$search=$_GET['search'];

		$query ="SELECT * FROM users WHERE `storename` LIKE '%".$search."%' ORDER BY web_visits DESC LIMIT 50";
			}

		$query_run=mysqli_query($db_link,$query);

		//echo $query;


?>

<form class="form-inline md-form mr-auto">
  <input class="form-control mr-lg-2" type="text" placeholder="Search Shop" aria-label="Search" name="search" >
  <button class="btn aqua-gradient btn-rounded btn-lg-2 my-0" style="font-size: 1.0em;" type="submit">Search</button>
</form>

<?php

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr>
<th>ID</th>
<th>StoreName</th>
<th>Date</th>
<th>Shop Type</th>
</tr></thead><tbody>';


while($row=mysqli_fetch_assoc($query_run)){

	$userId=$row['user_id'];
	$storename=$row['storename'];



echo '<tr>
<td>'.$userId.'</td>
<td>'.$storename.'<a href="add/add-order.php?shop_id='.$userId.'&shop_name='.$storename.'"><button>Select</button></a></td>
<td>'.date('d/m/Y \a\t h:iA' , $row['created_on']).'</td>

<td>'.$row['shop_type'].'</td>


</tr>';




}

?>