<?php 	


require("email-sendgrid/sendgrid-php.php"); 

//getting the supplier details
session_start();

include('get_supplier_details.php');
$supplier_id=$supplier;



if(isset($_POST['name'])&&isset($_POST['email'])){

$name=mysqli_real_escape_string($db_link,$_POST['name']);
$email=mysqli_real_escape_string($db_link,$_POST['email']);



$orderdate=time();
$product_id=$_POST['product_id'];
$delivery_details=mysqli_real_escape_string($db_link,$_POST['delivery_details']);
$phone_number=mysqli_real_escape_string($db_link,$_POST['phone_number']);
//fetch product data


  if(isset($_GET['cart'])){


	if(isset($_SESSION['cart_products'])){
$products_array=$_SESSION['cart_products'];
}else
{
  $products_array=[];
}

foreach ($products_array as $key => $value) {
  # code...
     $sql="SELECT * FROM products WHERE id='".$key."'";
   $result=$connect->query($sql);

    if($row=mysqli_fetch_assoc($result)){

    		if ($supplier_id!=$row['supplier_id']&&$row['supplier_id']!=0){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier_id AND product_id=".$row['id'];
					//echo $query_more_suppliers;
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
					if($row2=mysqli_fetch_assoc($query_run_more_suppliers)){

						if($row2['price']!=0){
							$price_multiple=$row2['price'];
						}else{
							$price_multiple=$row['price'];
						}
						if($row2['profit']!=0){
							$profit_multiple=$row2['profit'];
						}else{
							$profit_multiple=$row['profit'];
						}
						if($row2['cost']!=0){
							$cost_multiple=$row2['cost'];
						}else{
							$cost_multiple=$row['cost'];
						}
					}else{
					$price_multiple=$row['price'];
					$profit_multiple=$row['profit'];	
					$cost_multiple=$row['cost'];	
					}
				}else{
					$price_multiple=$row['price'];
					$profit_multiple=$row['profit'];	
					$cost_multiple=$row['cost'];			
				}

    $product_profit = $product_profit+($value*$profit_multiple);
	$product_price = $product_price+($value*$price_multiple);
	$cost = $cost+$value*$cost_multiple;
	$product_name = $product_name.' - '.$value.' X '.$row['name'];

    }


}

	$product_id=0;
	$supplier_id=0;



}else{
  $productSql = "SELECT * FROM products WHERE id=$product_id";
  $productData = $connect->query($productSql);

  while($row = $productData->fetch_array()) {									 		
  $product_profit = $row['profit'];
  $product_price = $row['price'];
  $cost = $row['cost'];
  $product_name = $row['name'];

  				if ($supplier!=$row['supplier_id']){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier AND product_id=".$row['id'];
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
					if($row2=mysqli_fetch_assoc($query_run_more_suppliers)){
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
						}
				}else{
					$product_price=$row['price'];
					$product_profit=$row['profit'];	
					$cost=$row['cost'];			}


}
}

$querydb="SELECT * FROM `suppliers` WHERE `id` ='$supplier'";

$query_run=mysqli_query($db_link,$querydb);
if($row=mysqli_fetch_assoc($query_run)){
	$supplier_id=$row['id'];
	$fullname=$row['name'];
	$supplier_email=$row['email'];
	$supplier_phone_number=$row['phone'];
	$username=$row['username'];
}



$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
//prevent multiple entry of customers
//prevent multiple entry of customers
$sqlnumberexists="SELECT * FROM customers WHERE phone='$phone_number'";
$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

//prevent multiple entry of customers
$sqlemailexists="SELECT * FROM customers WHERE email='$email'";
$query_run_email_exists=mysqli_query($db_link,$sqlemailexists);


if(mysqli_num_rows($query_run_number_exists)>0){

	if($row=mysqli_fetch_assoc($query_run_number_exists)){
	$customer_id=$row['id'];
	$phone_email=$phone_number;
	$customer_password=$row['password'];

	setcookie('phone_email',$phone_email,time() + (86400 * 366));
	setcookie('password',$password,time() + (86400 * 366));

	}

}else if (($row=mysqli_fetch_assoc($query_run_email_exists)) && $email!="N/A" && $email!="NA" &&
$email!="NONE"){
	$customer_id=$row['id'];
	$phone_email=$email;

	$customer_password=$row['password'];

	setcookie('phone_email',$phone_email,time() + (86400 * 366));
	setcookie('password',$password,time() + (86400 * 366));
}else{

	$customer_password='';
	$sqlcustomers = "INSERT INTO customers VALUES(NULL,'$name','$phone_number','$email', '$delivery_details',0,'$supplier_id','',$orderdate)";

	$phone_email=$phone_number;

	if(($connect->query($sqlcustomers) === true)){
			$customer_id= $connect->insert_id;
				}
				
}
//set customer password state


if($customer_password==''){
	$customer_password_set=false;
	$_SESSION['customerId'] = $customer_id;
}else{
	$customer_password_set=true;
}



	$order_id;
	$orderStatus = false;
	

			

			$sql = "INSERT INTO deals VALUES (NULL,'$name', '$phone_number', '$email', '$delivery_details','', '$product_name',$product_price ,$product_profit,$cost, $product_id, 0,'$customer_id','$supplier_id',5,0, '$orderdate',0)";

			


	if(($connect->query($sql) === true)) {
		$order_id = $connect->insert_id;

		$valid['order_id'] = $order_id;	

			//add cart items to cart
		if(!empty($products_array)){
	foreach ($products_array as $key => $value) {
  # code...
	$quantity=$value['quantity'];
	$price_multiple=$value['price'];
	$profit_multiple=$value['profit'];
	$cost_multiple=$value['cost'];
	$name_individual=addslashes($value['name']);

	//key is the product id
	$sql_cart = "INSERT INTO cart_items VALUES (NULL,'$order_id','$key', '$name_individual', '$quantity', '$price_multiple', '$cost_multiple','$profit_multiple')";

	$connect->query($sql_cart);

	}
		}

		$orderStatus = true;

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
            'Supplier Id: '.$supplier_id.' name: '.$fullname.' phone: '.$supplier_phone_number.' email: '.$supplier_email
            .'
            '.
            'Product : '.$product_name
            .'
            '.
            'Product Profit: '.$product_profit.'');


   
//uncomment for upload
mail($to, $subject, $message, $headers);






				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
				$email_sendgrid->setSubject("Order received on www.".$username.".av.ke");
				$email_sendgrid->addTo($supplier_email, $fullname);
				$email_sendgrid->addContent("text/plain", "Hello, ".$fullname.". Order received on www.".$username.".av.ke from ".$name." ".$phone_number." for the ".$product_name.". Login on http://supply.javy.co.ke for details. " );
				//$email_sendgrid->addContent("text", "<strong>and easy to do anywhere, even with PHP</strong>");
				$sendgrid = new \SendGrid('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');
				try {
				    $response = $sendgrid->send($email_sendgrid);
				     //print $response->statusCode() . "\n";
				     //print_r($response->headers());
				     //print $response->body() . "\n";
				} catch (Exception $e) {
				    //echo 'Caught exception: ',  $e->getMessage(), "\n";
				}

				$email_sendgrid_customer = new \SendGrid\Mail\Mail(); 
				$email_sendgrid_customer->setFrom("info@javy.co.ke", ucfirst($username));
				$email_sendgrid_customer->setSubject("Your order on www.".$username.".av.ke has been received.");
				$email_sendgrid_customer->addTo($email, $name);
				$email_sendgrid_customer->addContent("text/plain", "Hello, ".$name.". Your order on www.".$username.".av.ke  for the ".$product_name." has been received. One of our representatives will contact you for details on the order." );
				//$email_sendgrid->addContent("text", "<strong>and easy to do anywhere, even with PHP</strong>");
				$sendgrid = new \SendGrid('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');
				try {
				    $response = $sendgrid->send($email_sendgrid_customer);
				     //print $response->statusCode() . "\n";
				     //print_r($response->headers());
				     //print $response->body() . "\n";
				} catch (Exception $e) {
				    //echo 'Caught exception: ',  $e->getMessage(), "\n";
				}




		$valid['success'] = true;
		$valid['customer_password'] = $customer_password_set;
		$valid['messages'] = "Order Successful. We're working on it";	
	}else  {
		$valid['success'] = false;
		$valid['messages'] = 'Order Failed. Kindly contact us if it persists ';
  
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