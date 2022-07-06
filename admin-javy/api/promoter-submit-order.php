<?php   

$base = dirname(dirname(__FILE__)); // now $base contains "app"

require('../connect.inc.php');
//require('/../../store/admin/subdomain_storename.php');
require('../email-sendgrid/sendgrid-php.php'); 

//getting the dealer id
//localhost code



if(isset($_GET['name'])&&isset($_GET['email'])&&isset($_GET['phone_number'])
  &&!empty($_GET['email'])&&!empty($_GET['name'])&&!empty($_GET['phone_number'])){

$name=mysqli_real_escape_string($db_link,$_GET['name']);
$email=mysqli_real_escape_string($db_link,$_GET['email']);
$dealer_id=mysqli_real_escape_string($db_link,$_GET['user_id']);



$orderdate=time();
$product_id=$_GET['product_id'];
$delivery_details=mysqli_real_escape_string($db_link,$_GET['delivery_details']);
$phone_number=mysqli_real_escape_string($db_link,$_GET['phone_number']);
//fetch product data
  $productSql = "SELECT * FROM products WHERE id=$product_id";
  $productData = $connect->query($productSql);

  while($row = $productData->fetch_array()) {                     
  $product_profit = $row['profit'];
  $product_price = $row['price'];
  $cost = $row['cost'];
  $product_name = $row['name'];
  $supplier_id = $row['supplier_id'];
}

$querydb="SELECT * FROM `users` WHERE `user_id` =".$dealer_id;

$query_run=mysqli_query($db_link,$querydb);
if($row=mysqli_fetch_assoc($query_run)){
  $dealer_id=$row['user_id'];
  $storename=$row['storename'];
  $firstname=$row['firstname'];
  $promoter_email=$row['email'];
}



//$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
//prevent multiple entry of customers
$sqlnumberexists="SELECT * FROM customers WHERE phone='$phone_number'";
$query_run_number_exists=mysqli_query($db_link,$sqlnumberexists);

$sqlemailexists="SELECT * FROM customers WHERE email='$email'";
$query_run_email_exists=mysqli_query($db_link,$sqlemailexists);

if(mysqli_num_rows($query_run_number_exists)>0){

  if($row=mysqli_fetch_assoc($query_run_number_exists)){
  $customer_id=$row['id'];

  }

}else if( ($row=mysqli_fetch_assoc($query_run_email_exists)) && $email!="N/A" && $email!="NA" &&
$email!="NONE"){
  $customer_id=$row['id'];

}else{

  $sqlcustomers = "INSERT INTO customers VALUES(NULL,'$name','$phone_number','$email', '$delivery_details','$dealer_id',0,'','$orderdate')";

  if(($connect->query($sqlcustomers) === true)){
      $customer_id= $connect->insert_id;
        }

}

  $order_id;
  $orderStatus = false;
  

      $sql = "INSERT INTO deals VALUES (NULL,'$name', '$phone_number', '$email', '$delivery_details','', '$product_name',$product_price ,$product_profit,$cost, $product_id, '$dealer_id','$customer_id','$supplier_id',3, 0,'$orderdate',0)";


  if(($connect->query($sql) === true)) {
    $order_id = $connect->insert_id;

    $valid['order_id'] = $order_id; 

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




    $valid['success'] = true;
    $valid['messages'] = "Thank you. Your order has been received and is now being processed. Order number : ".$order_id
    ." Date : ".date('d/m/Y \a\t h:iA' , $orderdate)." Total : ".number_format($product_price); 
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

  echo json_encode($valid);
 // echo json_encode($valid);

}
// /if $_POST
else{
  $valid['success'] = false;
    $valid['messages'] = 'Enter Details';

  echo json_encode($valid);
} 
