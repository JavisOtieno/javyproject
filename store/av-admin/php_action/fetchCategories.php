<?php 	

require_once 'core.php';

$sql = "SELECT id,name  FROM customers";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeCategories = ""; 

 while($row = $result->fetch_array()) {
 	$customerId = $row[0];
 	// active 
 	//if($row[2] == 1) {
 	if($row[0]!=0){
 		// activate member
 		$activeCategories = "<label class='label label-success'>Active</label>";
 	} else {
 		// deactivate member
 		$activeCategories = "<label class='label label-danger'>Inactive</label>";
 	}

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editCategoriesModalBtn" data-target="#editCategoriesModal" onclick="editCategories('.$customerId.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeCategoriesModal" id="removeCategoriesModalBtn" onclick="removeCategories('.$customerId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';

	$sqldeals = "SELECT * FROM deals WHERE customer_id='$customerId'";
	$resultdeals = $connect->query($sqldeals);
	$totaldeals=$resultdeals->num_rows;


 	$output['data'][] = array( 		
 		'&nbsp;&nbsp;'.$row[1], 		
 		$activeCategories,
 		//$button
 		$totaldeals


 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);