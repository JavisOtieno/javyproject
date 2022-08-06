<?php 	

require('connect.inc.php');
require('subdomain_storename.php');
require("email-sendgrid/sendgrid-php.php"); 
require_once('AfricasTalkingGateway.php');

//setting session
session_start();


$query="SELECT * FROM `users` WHERE `storename` ='$storename'";

$query_run=mysqli_query($db_link,$query);

if($row=mysqli_fetch_assoc($query_run)){
	$supplier_id=$row['supplier_registered_on'];
}

if(isset($_POST['name'])&&isset($_POST['email'])&&$_POST['phone_number']!=="+1 213 425 1453"&&strlen($_POST['phone_number'])==10){

$name=mysqli_real_escape_string($db_link,$_POST['name']);
$email=mysqli_real_escape_string($db_link,$_POST['email']);

$orderdate=time();

$delivery_details=mysqli_real_escape_string($db_link,$_POST['delivery_details']);
$phone_number=mysqli_real_escape_string($db_link,$_POST['phone_number']);

//echo $phone_number.' '.$delivery_details.' '.$email.' '.$name;
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
	$quantity=$value['quantity'];
	$price_multiple=$value['price'];
	$profit_multiple=$value['profit'];
	$cost_multiple=$value['cost'];
	$name_individual=$value['name'];

    $product_profit = $product_profit+($quantity*$profit_multiple);
	$product_price = $product_price+($quantity*$price_multiple);
	$cost = $cost+$quantity*$cost_multiple;
	$product_name = $product_name.' - '.$quantity.' X '.$name_individual;


}

	$product_id=0;
	$supplier_id=0;

	//reset cart products to zero
	$_SESSION['cart_products']=[];



}else{


	$product_id=$_POST['product_id'];

	$product_variable_name=$_POST['variable_name'];
	$product_variable_price=$_POST['variable_price'];

$productSql = "SELECT * FROM products WHERE id=$product_id";
  $productData = $connect->query($productSql);

	  while($row = $productData->fetch_array()) {	

  									 		

	if ($supplier_id!=$row['supplier_id']&&$row['supplier_id']!=0){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier_id AND product_id=".$row['id'];
					//echo $query_more_suppliers;
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
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
					$supplier_id = $row['supplier_id'];
					$product_price=$row['price'];
					$product_profit=$row['profit'];	
					$cost=$row['cost'];	
					}
				}else{
					$supplier_id = $row['supplier_id'];
					$product_price=$row['price'];
					$product_profit=$row['profit'];	
					$cost=$row['cost'];			}

  $product_name = $row['name'].' '.$product_variable_name;
//variables accounted for - change the price on order
  if(!empty($product_variable_price)){
  	$product_price=$product_variable_price;
  }


  
}

}



$querydb="SELECT * FROM `users` WHERE `storename` ='$storename'";

$query_run=mysqli_query($db_link,$querydb);
if($row=mysqli_fetch_assoc($query_run)){
	$dealer_id=$row['user_id'];
	$firstname=$row['firstname'];
	$promoter_email=$row['email'];
	$promoter_phone=$row['phone'];
}



$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
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
	$sqlcustomers = "INSERT INTO customers VALUES(NULL,'$name','$phone_number','$email', '$delivery_details','$dealer_id',0,'',$orderdate)";

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

	

			$sql = "INSERT INTO deals VALUES (NULL,'$name', '$phone_number', '$email', '$delivery_details','', '$product_name',$product_price ,$product_profit,$cost, $product_id, '$dealer_id','$customer_id','$supplier_id',0,0, '$orderdate',0)";


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
            'Dealer Id: '.$dealer_id
            .'
            '.
            'Storename: '.$storename
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
				$email_sendgrid->setSubject("Order received on www.".$storename.".av.ke");
				$email_sendgrid->addTo($promoter_email, $firstname);
				$email_sendgrid->addContent("text/plain", "Hello, ".$firstname.". Order received on www.".$storename.".av.ke from ".$name." ".$phone_number." for the ".$product_name.". We will contact the client and update you. However if you know the client, you can let us know on 0716 545459 and contact the client directly." );
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
				$email_sendgrid_customer->setFrom("info@javy.co.ke", ucfirst($storename));
				$email_sendgrid_customer->setSubject("Your order on www.".$storename.".av.ke has been received.");
				$email_sendgrid_customer->addTo($email, $name);
				$email_sendgrid_customer->addContent("text/plain", "Hello, ".$name.". Your order on www.".$storename.".av.ke  for the ".$product_name." has been received. One of our representatives will contact you for details on the order." );
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


				
				// Specify your authentication credentials
				$username   = "Javisotieno";
				$apikey     = "fc8597cbed40cda6a2e7651458aa02b44b5a0a2c148557b39d371e1efe28d6af";
				// Specify the numbers that you want to send to in a comma-separated list
				// Please ensure you include the country code (+254 for Kenya in this case)



				function formatPhoneNumber($phone){
					$firstdigit=substr($phone, 0, 1);

				if($firstdigit=='0'){
				  $recipient = "+254".substr($phone,1);
				}elseif($firstdigit=='7'){
				  $recipient= "+254".$phone;
				}elseif($firstdigit=='2'){
				  $recipient = "+".$phone;
				}elseif($firstdigit=="+"){
				  $recipient = $phone;
				}
				return $recipient;
				}

				$recipient_customer = formatPhoneNumber($phone_number);
				$recipient_promoter = formatPhoneNumber($promoter_phone);

				//$recipients = "+254707641174,+254733YYYZZZ";

				// And of course we want our recipients to know what we really do
				$message_customer    = "Your order on www.".$storename.".av.ke for the ".$product_name." has been received. We will contact you shortly to process the order";

				$message_promoter    = "Order received on www.".$storename.".av.ke for the ".$product_name." has been received. Customer contact: ".$phone_number." - Javy Helpline: 0716 545459";

				$gateway    = new AfricasTalkingGateway($username, $apikey);

				$from = "JAVY";

				try 
				{ 
				  // Thats it, hit send and we'll take care of the rest. 
				  $results_promoter = $gateway->sendMessage($recipient_promoter, $message_promoter, $from);
				            
				  foreach($results_promoter as $result) {
				    // status is either "Success" or "error message"
				    //echo " Number: " .$result->number;
				    //echo " Status: " .$result->status;
				    //echo " MessageId: " .$result->messageId;
				    //echo " Cost: "   .$result->cost."\n";
				  }
				   // Thats it, hit send and we'll take care of the rest. 
				  $results_customer = $gateway->sendMessage($recipient_customer, $message_customer, $from);
				            
				  foreach($results_customer as $result) {
				    // status is either "Success" or "error message"
				    //echo " Number: " .$result->number;
				    //echo " Status: " .$result->status;
				    //echo " MessageId: " .$result->messageId;
				    //echo " Cost: "   .$result->cost."\n";
				  }
				}
				catch ( AfricasTalkingGatewayException $e )
				{
				  //echo "Encountered an error while sending: ".$e->getMessage();
				}




		$valid['success'] = true;
		$valid['customer_password']=$customer_password_set;
		$valid['messages'] = "Thank you. Your order has been received and is now being processed. Order number : <strong>".$order_id
		."</strong> Date : <strong>".date('d/m/Y \a\t h:iA' , $orderdate)."</strong> Total : <strong>".number_format($product_price)."</strong>";

	}else  {
		$valid['success'] = false;
		$valid['messages'] = 'Order Failed. Please try again. Kindly contact us if the problem persists';
  
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


 
} // /if $_POST
// echo json_encode($valid);
else{
$valid['success'] = false;
$valid['messages'] = 'Order Failed. Check your details. Kindly contact us if the problem persists';



	}

echo json_encode($valid);