<?php 	

require_once 'core.php';



$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	
	
	$orderId = $connect->real_escape_string($_POST['orderId']);

  $clientName 					= addslashes($_POST['clientName']);
  $clientContact 				= addslashes($_POST['clientContact']);
  $clientEmail= addslashes($_POST['clientEmail']);
  $clientDeliveryDetails=addslashes($_POST['clientDeliveryDetails']);
  $productId=$connect->real_escape_string($_POST['productName']);
  
  
  /*

  	$orderId = 22;

  $clientName 					= 'javis';
  $clientContact 				= '0707641174';
  $clientEmail= 'javis@gmail.com';
  $clientDeliveryDetails='Kasarani, North';
  $productId=2;

  */

  

  


  $sqlproduct="SELECT name,profit FROM products WHERE id='$productId'";
  $result=$connect->query($sqlproduct);
  $row=$result->fetch_row();
  $productName=$row[0];
  $productProfit=$row[1]; 
  
				
	$sql = "UPDATE deals SET name = '$clientName', phone = '$clientContact', email='$clientEmail', delivery_details='$clientDeliveryDetails',product_name='$productName',product_profit='$productProfit', product_id='$productId' WHERE id = {$orderId}";	
	$connect->query($sql);



	/*not needed
	
	$readyToUpdateOrderItem = false;
	// add the quantity from the order item to product table
	for($x = 0; $x < count($_POST['productName']); $x++) {		
		//  product table
		$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = ".$_POST['productName'][$x]."";
		$updateProductQuantityData = $connect->query($updateProductQuantitySql);			
			
		while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
			// order item table add product quantity
			$orderItemTableSql = "SELECT order_item.quantity FROM order_item WHERE order_item.order_id = {$orderId}";
			$orderItemResult = $connect->query($orderItemTableSql);
			$orderItemData = $orderItemResult->fetch_row();

			$editQuantity = $updateProductQuantityResult[0] + $orderItemData[0];							

			$updateQuantitySql = "UPDATE product SET quantity = $editQuantity WHERE product_id = ".$_POST['productName'][$x]."";
			$connect->query($updateQuantitySql);		
		} // while	
		
		if(count($_POST['productName']) == count($_POST['productName'])) {
			$readyToUpdateOrderItem = true;			
		}
	} // /for quantity

	// remove the order item data from order item table
	for($x = 0; $x < count($_POST['productName']); $x++) {			
		$removeOrderSql = "DELETE FROM order_item WHERE order_id = {$orderId}";
		$connect->query($removeOrderSql);	
	} // /for quantity

	if($readyToUpdateOrderItem) {
			// insert the order item data 
		for($x = 0; $x < count($_POST['productName']); $x++) {			
			$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = ".$_POST['productName'][$x]."";
			$updateProductQuantityData = $connect->query($updateProductQuantitySql);
			
			while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
				$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];							
					// update product table
					$updateProductTable = "UPDATE product SET quantity = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]."";
					$connect->query($updateProductTable);

					// add into order_item
				$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
				VALUES ({$orderId}, '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

				$connect->query($orderItemSql);		
			} // while	
		} // /for quantity
	}

	*/

	

	$valid['success'] = true;
	$valid['messages'] = "Successfully Updated";		
	
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);