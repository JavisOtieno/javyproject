<?php 	

require_once 'core.php';
$db_link=@mysqli_connect($localhost, $username, $password, $dbname);

$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
$dealerID=$_SESSION['supplierId'];
// print_r($valid);
if($_POST) {	

  $dealerID						=$_SESSION['supplierId'];
  $dealDate 					= date('d/m/Y \a\t h:iA', strtotime('+1 hours'));	
  $clientName 					= $connect->real_escape_string($_POST['clientName']);
  $clientEmail 					= $connect->real_escape_string($_POST['clientEmail']);
  $clientContact		        = $connect->real_escape_string($_POST['clientContact']);
  $clientDeliveryDetails 				= $connect->real_escape_string($_POST['clientDeliveryDetails']); 
  $productId					= $connect->real_escape_string($_POST['productName']);

  $productSql = "SELECT * FROM products WHERE status = 1 AND id=$productId";
  $productData = $connect->query($productSql);

  while($row = $productData->fetch_array()) {									 		
  $productProfit = $row['profit'];
  $productName = $row['name'];
  $productPrice = $row['price'];
  $supplier_id=$row['supplier_id'];
  } // /while 
  

  
				




		$sqlnumberexists="SELECT * FROM customers WHERE phone='$clientContact'";
$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

if(mysqli_num_rows($query_run_number_exists)>0){

	if($row=mysqli_fetch_assoc($query_run_number_exists)){
	$customer_id=$row['id'];
	}

}else{

	$sqlcustomers = "INSERT INTO customers VALUES(NULL,'$clientName', '$clientContact', '$clientEmail', '$clientDeliveryDetails','$dealerID')";

	if(($connect->query($sqlcustomers) === true)){
			$customer_id= $connect->insert_id;
				}

}




		$order_id;
	$orderStatus = false;
			
			$sql = "INSERT INTO deals VALUES (NULL,'$clientName', '$clientContact', '$clientEmail', '$clientDeliveryDetails', '$productName',$productPrice, $productProfit,'$productId','$dealerID','$customer_id','$supplier_id',0,'$dealDate',0)";

	if(($connect->query($sql) === true)) {
		$order_id = $connect->insert_id;

		$valid['order_id'] = $order_id;	

		//PHP MAIL DOES NOT WORK ON LOCALHOST. UNCOMMENT ON UPLOAD      
$to      = 'javisotieno@gmail.com';
$subject = 'ORDER by:'.$clientName;
$headers = 'From: info@javytech.co.ke' 
.'
'.
    'Reply-To: info@javytech.co.ke' 
    .'
    '.
    'X-Mailer: PHP/' . phpversion();
$message =  (
            'Order: '.$order_id
            .'
            '.
            'ClientName: '.$clientName
            .'
            '.
            'Phone number: '.$clientContact
            .'
            '.
            'Dealer Id: '.$dealerID
            .'
            '.
            'Order: Order Made by Dealer --AddNameLater'
            .'
            '.
            'Product : '.$productName
            .'
            '.
            'Product Profit: '.$productProfit.'');


   

mail($to, $subject, $message, $headers);





		$orderStatus = true;
	}

		
	// echo $_POST['productName'];
	$orderItemStatus = false;

	/* quantity not needed


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
				VALUES ('$order_id', '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

				$connect->query($orderItemSql);		

				if($x == count($_POST['productName'])) {
					$orderItemStatus = true;
				}		
		} // while	
	} // /for quantity

	*/

	$valid['success'] = true;
	$valid['messages'] = "Deal Successfully Added";		
	
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);