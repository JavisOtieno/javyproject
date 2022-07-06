<?php 	



require_once 'core.php';

$sql = "SELECT * FROM products WHERE (supplier_id='$userId' OR id IN (SELECT product_id FROM more_suppliers WHERE supplier_id='$userId')) AND status!=2 ORDER BY id DESC";


$result = $connect->query($sql);

$output = array('data' => array());

$sqlsupplier ="SELECT username FROM suppliers WHERE id = $userId";
$supplierResult=$connect->query($sqlsupplier);
$supplierResult=$supplierResult->fetch_assoc();
$username=$supplierResult['username'];
$username=ucfirst($username);

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$productId = $row['id'];

 	$sqlusers ="SELECT storename FROM users WHERE user_id = ".$row['store_id'];
$userResult=$connect->query($sqlusers);
$storeResult=$userResult->fetch_assoc();
$storename=$storeResult['storename'];
$storename=ucfirst($storename);
 	// active 

 	 //No need to show the dealer the products that are available and unavailable
 	if($row['status'] == 0 ) {
 		// activate member
 		$active = "<label class='label label-danger'>Not Available</label>";
 	} else if($row['status'] == 1 && $row['approval'] == 0){

 		$active = "<label class='label label-warning'>Available on your website: ".$username."<br/> Awaiting approval on main website: ".$storename."</label>";
 	}
 	else if($row['status']==2){
 		$active = "<label class='label label-danger'>Removed</label>";
 	}
 	else if($row['status'] == 1 && $row['approval'] == 1){
 		$active = "<label class='label label-success'>Available on your website: ".$username."<br/>Available on main website: ".$storename."</label>";
 	}
 	else if($row['status'] == 1 && $row['approval'] == 2){
 		$active = "<label class='label label-success'>Available on your website: ".$username."<br/>Available on main website: ".$storename." & Javy website</label>";
 	}
 	
 	

 	 //NO NEED FOR THE DEALER TO EDIT OR REMOVE THE PRODUCTS

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct('.$productId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';

	$remove_button = '<a data-toggle="modal" id="removeProductModalBtn" data-target="#removeProductModal" onclick="removeProduct('.$productId.')"><button type="button" class="btn btn-default">
	    Remove
	  </button></a>';
	$edit_button ='<a data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')"><button type="button" class="btn btn-default">
	    Edit
	  </button></a>';

if($row['supplier_id']!=$userId){
$sql_more_suppliers_product = "SELECT * FROM more_suppliers WHERE supplier_id='$userId' AND product_id='$productId'";
$result_more_suppliers = $connect->query($sql_more_suppliers_product);

 if($row_more_suppliers = $result_more_suppliers->fetch_array()) {
 	$price=$row_more_suppliers['price'];
 	$profit=$row_more_suppliers['profit'];
 	$cost=$row_more_suppliers['cost'];

 	if($price==0){
 		$price=$row[4];
 	}
 	if($profit==0){
 		$profit=$row['profit'];
 	}
 	if($cost==0){
 		$cost=$row['cost'];
 	}
 }

}else{
	 	$price=$row[4];
 		$cost=$row['cost'];
 		$profit=$row['profit'];
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
 		$price,
 		// cost
 		$cost, 

 		$profit,		 	
 		// category
 		$category,
 		// brand		
 		$brand,
 		// active

 		//NOT DISPLAYING ACTIVE AND EDIT & REMOVE BUTTONS
 		$active,
 		// button
 		$remove_button
 			
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);