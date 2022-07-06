<?php 	



require_once 'core.php';



$sqlusers ="SELECT * FROM users WHERE user_id = $userId";
$userResult=$connect->query($sqlusers);
$storeResult=$userResult->fetch_assoc();
$storename=$storeResult['storename'];
$supplier_id = $storeResult['supplier_registered_on'];
$storename=ucfirst($storename);

$sql = "SELECT * FROM products 
		WHERE  store_id='$userId' AND supplier_id!='$supplier_id' AND status!=2 ORDER BY id DESC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$productId = $row['id'];
 	// active 
 	$sqlsupplier ="SELECT username FROM suppliers WHERE id = ".$row['supplier_id'];
$supplierResult=$connect->query($sqlsupplier);
$supplierResult=$supplierResult->fetch_assoc();
$username=$supplierResult['username'];
$username=ucfirst($username);

//default approve button
$approve_button = '';

 	if($row['status'] == 0 ) {
 		// activate member
 		$active = "<label class='label label-danger'>Not Available</label>";
 	} else if($row['status'] == 1 && $row['approval'] == 0 ){

 		if($supplier_id==$row['supplier_id']){
 		$active = "<label class='label label-success'>Available on your website
 		<br/> Product added by supplier : ".$username." </label>";
 		$approve_button = '';

 	}else{
 		$active = "<label class='label label-warning'>Awaiting your approval".$supplier_id.$row['supplier_id']."</label>";
 		$approve_button = '<a href="php_action/approveProduct.php?productId='.$productId.'"><button type="button" class="btn btn-success">Approve</button>';
 	}


 	}
 	else if($row['status']==2){
 		$active = "<label class='label label-danger'>Removed</label>";
 	}
 	else if($row['status'] == 1 && $row['approval'] == 1 && $row['supplier_id'] != 0){

 		$active = "<label class='label label-success'>Available on your website: ".$storename."<br/> Product added by supplier : ".$username." </label>";
 	}
 	else if($row['status'] == 1 && $row['approval'] == 1 && $row['supplier_id'] == 0){
 		$active = "<label class='label label-success'>Available on your website: ".$storename." <br/> Product added by you </label>";
 	}
 	else if($row['status'] == 1 && $row['approval'] == 2 && $row['supplier_id'] != 0){

 		$active = "<label class='label label-success'>Available on your website: ".$storename." & Javy website. <br/> Product added by supplier : ".$username." </label>";
 	}
 	else if($row['status'] == 1 && $row['approval'] == 2 && $row['supplier_id'] == 0){
 		$active = "<label class='label label-success'>Available on your website: ".$storename." & Javy website. <br/> Product added by you. </label>";
 	}
 	
 	
 	

 	 //NO NEED FOR THE DEALER TO EDIT OR REMOVE THE PRODUCTS

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct('.$productId.')"> <i class="glyphicon glyphicon-trash"></i> Delete</a></li>       
	  </ul>
	</div>';

	$remove_button = '<a data-toggle="modal" id="removeProductModalBtn" data-target="#removeProductModal" onclick="removeProduct('.$productId.')"><button type="button" class="btn btn-default">
	    Remove
	  </button></a>';


	$edit_button ='<a data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')"><button type="button" class="btn btn-default">
	    Edit
	  </button></a>';

	  if($supplier_id==$row['supplier_id']){
	  	$edit_button='';
	  	$remove_button='';
	  }

	

	// $brandId = $row[3];
	// $brandSql = "SELECT * FROM brands WHERE brand_id = $brandId";
	// $brandData = $connect->query($sql);
	// $brand = "";
	// while($row = $brandData->fetch_assoc()) {
	// 	$brand = $row['brand_name'];
	// }

	$status=$row[10];
	$brand = $row[9];
	$category = $row[8];

	$imageUrl = substr($row[3], 3);
	$imageUrl=str_replace("..", "https://promote.javy.co.ke/", $row['image']);

	$noImageUploaded='https://promote.javy.co.ke/assests/images/product-images/no-image-uploaded.jpg';

	if($imageUrl==''){
		$imageUrl=$noImageUploaded;
	}
	
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

 	$output['data'][] = array( 		
 		// image
 		$productImage,
 		// product name
 		$row[1], 

 		$edit_button,
 		// price
 		$row[4],
 		// cost
 		$row['cost'], 		 	
 		// category
 		$category,
 		// brand		
 		$brand,
 		// active

 		//NOT DISPLAYING ACTIVE AND EDIT & REMOVE BUTTONS
 		$active,
 		// button
 		$remove_button,
 		$approve_button
 			
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);