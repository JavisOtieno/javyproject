<?php 	

require_once 'core.php';

$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1";
$sql = "SELECT withdrawal_id, user_id, amount,method,date,status FROM withdrawals";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeBrands = ""; 

 while($row = $result->fetch_array()) {
 	$brandId = $row[0];
 	// active 
 	if($row[5] == 1) {
 		// activate member
 		$activeWithdrawals = "<label class='label label-success'>Completed</label>";
 	} else {
 		// deactivate member
 		$activeWithdrawals = "<label class='label label-warning'>Processing ...</label>";
 	}

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" data-target="#editBrandModel" onclick="editBrands('.$brandId.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeBrands('.$brandId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';

 	// $output['data'][] = array( 		
 	// 	$row[1], 		
 	// 	$activeBrands,
 	// 	$button
 	// 	); 	


 	$output['data'][] = array( 		
 		$row[4], 	
 		$row[2],
 		$row[3],	
 		$activeWithdrawals,
 		); 	



 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);