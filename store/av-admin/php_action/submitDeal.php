<?php 	

require_once 'core.php';
$db_link=@mysqli_connect($localhost, $username, $password, $dbname);

$sqlusers ="SELECT * FROM users WHERE user_id = $userId";
$userResult=$connect->query($sqlusers);
$storeResult=$userResult->fetch_assoc();
$supplier_id=$storeResult['supplier_registered_on'];



if(isset($_POST['name'])&&isset($_POST['email'])){




$name=mysqli_real_escape_string($db_link,$_POST['name']);
$email=mysqli_real_escape_string($db_link,$_POST['email']);

$orderdate=time();
$product_id=$_POST['product_id'];

$delivery_details=mysqli_real_escape_string($db_link,$_POST['delivery_details']);
$phone_number=mysqli_real_escape_string($db_link,$_POST['phone_number']);
//fetch product data
  $productSql = "SELECT * FROM products WHERE id=$product_id";
  $productData = $connect->query($productSql);

  while($row = $productData->fetch_array()) {	


  	if($supplier_id!=$row['supplier_id'] && $row['supplier_id']!=0){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier_id AND product_id=".$row['id'];
					//echo $query_more_suppliers;
					//echo $query_more_suppliers;
					//echo $supplier_id;
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
					//echo $query_more_suppliers;
					if($row2=mysqli_fetch_assoc($query_run_more_suppliers)){
						$supplier_id=$row2['supplier_id'];
						if($row2['price']!=0){
							$product_price=$row2['price'];
						}else{
							$product_price=$row['price'];
						}
						if($row2['profit']!=0){
							$product_profit=$row2['profit'];
						}else{
							$product_profit=$row['profit'];
						}
						if($row2['cost']!=0){
							$cost=$row2['cost'];
						}else{
							$cost=$row['cost'];
						}
					}else{
					$product_price=$row['price'];
					$product_profit=$row['profit'];	
					$cost=$row['cost'];
					$supplier_id=$row['supplier_id'];

					}
				}else{
					$product_price=$row['price'];
					$product_profit=$row['profit'];	
					$cost=$row['cost'];
					$supplier_id=$row['supplier_id'];			
				}



  $product_name = $row['name'];

}

/*$querydb="SELECT `user_id` FROM `users` WHERE `storename` ='$storename'";

$query_run=mysqli_query($db_link,$querydb);
if($row=mysqli_fetch_assoc($query_run)){
	$dealer_id=$row['user_id'];
}
*/
$dealer_id=$_SESSION['userId'];



$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');

 

$sqlnumberexists="SELECT * FROM customers WHERE phone='$phone_number'";
$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

//prevent multiple entry of customers
$sqlemailexists="SELECT * FROM customers WHERE email='$email'";
$query_run_email_exists=mysqli_query($db_link,$sqlemailexists);

if(mysqli_num_rows($query_run_number_exists)>0){

	if($row=mysqli_fetch_assoc($query_run_number_exists)){
	$customer_id=$row['id'];
	}

}else if(mysqli_num_rows($query_run_email_exists)>0 && $email!="N/A" && $email!="NA" &&
$email!="NONE")
{
	if($row=mysqli_fetch_assoc($query_run_email_exists)){
	$customer_id=$row['id'];
	}

}else{

	$sqlcustomers = "INSERT INTO customers VALUES(NULL,'$name','$phone_number','$email', '$delivery_details','$dealer_id',0,'',$orderdate)";

	if(($connect->query($sqlcustomers) === true)){
			$customer_id= $connect->insert_id;
				}

}
	
	
	$order_id;
	$orderStatus = false;
	

$sql = "INSERT INTO deals VALUES (NULL,'$name', '$phone_number', '$email', '$delivery_details','', '$product_name',$product_price, $product_profit, $cost, $product_id, '$dealer_id','$customer_id','$supplier_id',1,0,'$orderdate',0)";

//echo $sql;
			

	if(($connect->query($sql) === true)) {

		$order_id= $connect->insert_id;
		//get promoter details to display on email
	$user_id = $_SESSION['userId'];
$sql_promoter = "SELECT * FROM users WHERE user_id = {$user_id}";
$query_promoter = $connect->query($sql_promoter);
$result_promoter = $query_promoter->fetch_assoc();

$storename=$result_promoter['storename'];
$phone=$result_promoter['phone'];
$promoter_name=$result_promoter['firstname'].' '.$result_promoter['lastname'];
//end of getting 
		

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
            'Order Made by Promoter - '.'storename : '.$storename.' phone : '.$phone.' name : '.$promoter_name
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
		$valid['messages'] = "Thank you. Your order has been received and is now being processed. Order number : <strong>".$order_id
		."</strong> Date : <strong>".date('d/m/Y \a\t h:iA' , $orderdate)."</strong> Total : <strong>".number_format($product_price)."</strong>";	

	}else  {
		$valid['success'] = false;
		$valid['messages'] = 'Order Failed. Please try again. Kindly contact us if the problem persists ';
  
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