<?php 	

require('connect.inc.php');
require('subdomain_storename.php');
require("email-sendgrid/sendgrid-php.php"); 

session_start();
//getting the supplier id
include('get_supplier_details.php');


if(isset($_POST['contact_name'])&&isset($_POST['contact_email'])){

$name=mysqli_real_escape_string($db_link,$_POST['contact_name']);
$email=mysqli_real_escape_string($db_link,$_POST['contact_email']);
$email2=mysqli_real_escape_string($db_link,$_POST['contact_email_2']);

$message_date=time();
$product_id=$_POST['contact_product_id'];
$message=mysqli_real_escape_string($db_link,$_POST['contact_message']);
$phone_number=mysqli_real_escape_string($db_link,$_POST['contact_phone_number']);
//fetch product data
  $productSql = "SELECT * FROM products WHERE id=$product_id";
  $productData = $connect->query($productSql);

  while($row = $productData->fetch_array()) {									 		
  $product_profit = $row['profit'];
  $product_price = $row['price'];
  $product_name = $row['name'];
  $supplier_id = $row['supplier_id'];

    				if ($supplier!=$row['supplier_id']){
					$query_more_suppliers= "SELECT * FROM more_suppliers WHERE supplier_id=$supplier AND product_id=".$row['id'];
					$query_run_more_suppliers=mysqli_query($db_link,$query_more_suppliers);
					if($row2=mysqli_fetch_assoc($query_run_more_suppliers)){
						if($row2['price']!=0){
							$product_price=$row2['price'];
							$product_profit=$row2['profit'];
	
						}else{
							$product_price=$row['price'];
							$product_profit=$row['profit'];
						}
					}else{
					$product_price=$row['price'];
					$product_profit=$row['profit'];
				}
				}else{
					$product_price=$row['price'];
					$product_profit=$row['profit'];				}
					
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
$sqlnumberexists="SELECT * FROM customers WHERE phone='$phone_number'";
$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

//prevent multiple entry of customers
$sqlemailexists="SELECT * FROM customers WHERE email='$email'";
$query_run_email_exists=mysqli_query($db_link,$sqlemailexists);



if(empty($email2))
{

if(mysqli_num_rows($query_run_number_exists)>0){

	if($row=mysqli_fetch_assoc($query_run_number_exists)){
	$customer_id=$row['id'];
	$customer_password=$row['password'];

	setcookie('phone_email',$phone_email,time() + (86400 * 366));
	setcookie('password',$password,time() + (86400 * 366));
	}

}else if(($row=mysqli_fetch_assoc($query_run_email_exists))  && $email!="N/A" && $email!="NA" &&
$email!="NONE"){
	$customer_id=$row['id'];
	$customer_password=$row['password'];

	setcookie('phone_email',$phone_email,time() + (86400 * 366));
	setcookie('password',$password,time() + (86400 * 366));
}
else{

	$customer_password='';
	$sqlcustomers = "INSERT INTO customers VALUES(NULL,'$name','$phone_number','$email', 'none','$dealer_id',0,'',$message_date)";

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
	

	$sql = "INSERT INTO product_messages VALUES (NULL,'$name', '$phone_number', '$email', '$message','', $product_id, 0,'$supplier_id','$customer_id','$message_date',0)";



	if(($connect->query($sql) === true)) {
		$order_id = $connect->insert_id;

		$orderStatus = true;

		//PHP MAIL DOES NOT WORK ON LOCALHOST. UNCOMMENT ON UPLOAD      
$to      = 'javisotieno@gmail.com';
$subject = 'PRODUCT MESSAGE SENT by:'.$name;
$headers = 'From: info@javytech.co.ke' 
.'
'.
    'Reply-To: info@javytech.co.ke' 
    .'
    '.
    'X-Mailer: PHP/' . phpversion();
$message_email_javis =  (
            'Message id: '.$order_id
            .'
            '.
            'ClientName: '.$name
            .'
            '.
            'Phone number: '.$phone_number
            .'
            '.
            'Email: '.$email
            .'
            '.
            'Supplier Id: '.$supplier_id.' name '.$fullname.' phone'.$supplier_phone_number
            .'
            '.
            'Message: '.$message
            .'
            '.
            'Product Name : '.$product_name
            .'
            '.
            'Product ID: '.$product_id.'');


   
//uncomment on upload
mail($to, $subject, $message_email_javis, $headers);





				$email_sendgrid = new \SendGrid\Mail\Mail(); 
				$email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
				$email_sendgrid->setSubject("Message received on www.".$username.".av.ke");
				$email_sendgrid->addTo($supplier_email, $fullname);
				$email_sendgrid->addContent("text/plain", "Hello, ".$fullname.". Message received on www.".$username.".av.ke from ".$name." ".$phone_number." regarding the ".$product_name.". Login on http://supply.javy.co.ke for details. " );
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
				$email_sendgrid_customer->setSubject("Your message on www.".$username.".av.ke has been received.");
				$email_sendgrid_customer->addTo($email, $name);
				$email_sendgrid_customer->addContent("text/plain", "Hello, ".$name.". Your message on www.".$username.".av.ke  regarding the ".$product_name." has been received. One of our representatives will be contacting you soon." );
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
		$valid['messages'] = "Message received. We'll get back to you soon";	
	}else  {
		$valid['success'] = false;
		$valid['messages'] = 'Message was not sent. Kindly contact us if it persists ';
}

}else{
	$valid['success'] = false;
	$valid['messages'] = 'Message was not sent. Please fill only the required details ';
}
		
	// echo $_POST['productName'];
	//$orderItemStatus = false;

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