<?php 	

require_once 'core.php';
$db_link=@mysqli_connect($localhost, $username, $password, $dbname);

//getting the dealer id



if(isset($_POST['name'])&&isset($_POST['email'])){

$name=mysqli_real_escape_string($db_link,$_POST['name']);
$email=mysqli_real_escape_string($db_link,$_POST['email']);

$orderdate=date('d/m/Y \a\t h:iA', strtotime('+1 hours'));
$product_id=$_POST['product_id'];

$delivery_details=mysqli_real_escape_string($db_link,$_POST['delivery_details']);
$phone_number=mysqli_real_escape_string($db_link,$_POST['phone_number']);
//fetch product data
  $productSql = "SELECT * FROM products WHERE id=$product_id";
  $productData = $connect->query($productSql);

  while($row = $productData->fetch_array()) {									 		
  $product_profit = $row['profit'];
  $product_name = $row['name'];
  $product_price = $row['price'];
  $supplier_id=$row['supplier_id'];
}

/*$querydb="SELECT `user_id` FROM `users` WHERE `storename` ='$storename'";

$query_run=mysqli_query($db_link,$querydb);
if($row=mysqli_fetch_assoc($query_run)){
	$dealer_id=$row['user_id'];
}
*/
$dealer_id=$_SESSION['supplierId'];



$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');

 

$sqlnumberexists="SELECT * FROM customers WHERE phone='$phone_number'";
$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

if(mysqli_num_rows($query_run_number_exists)>0){

	if($row=mysqli_fetch_assoc($query_run_number_exists)){
	$customer_id=$row['id'];
	}

}else{

	$sqlcustomers = "INSERT INTO customers VALUES(NULL,'$name','$phone_number','$email', '$delivery_details','$dealer_id','$orderdate')";

	if(($connect->query($sqlcustomers) === true)){
			$customer_id= $connect->insert_id;
				}

}
	
	
	$order_id;
	$orderStatus = false;
	

			$sql = "INSERT INTO deals VALUES (NULL,'$name', '$phone_number', '$email', '$delivery_details', '$product_name',$product_price, $product_profit, $product_id, '$dealer_id','$customer_id','$supplier_id',0,'$orderdate',0)";

			

	if(($connect->query($sql) === true)) {
		

		 //PHP MAIL DOES NOT WORK ON LOCALHOST. UNCOMMENT ON UPLOAD      
$to      = 'javisotieno@gmail.com';
$subject = 'ORDER by:'.$name;
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
            'ClientName: '.$name
            .'
            '.
            'Phone number: '.$phone_number
            .'
            '.
            'Dealer Id: '.$dealer_id
            .'
            '.
            'Storename: Order by dealer --AddNameLater'
            .'
            '.
            'Product : '.$product_name
            .'
            '.
            'Product Profit: '.$product_profit.'');


   

mail($to, $subject, $message, $headers);





		$valid['order_id'] = $order_id;



		$orderStatus = true;

		$valid['success'] = true;
		$valid['messages'] = "Sale/Order Successful. We're working on it";	

	}else  {
		$valid['success'] = false;
		$valid['messages'] = 'Sale/Order Failed. Kindly contact us if it persists ';
  
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

	
	
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);